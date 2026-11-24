#!/usr/bin/env node
/**
 * Push the Wiseup plugin (live-plugin/wiseup) to a WordPress site without uploading the zip.
 * The site's plugin has includes/deploy.php and wp-config.php defines WISEUP_DEPLOY_KEY.
 *
 *   node scripts/deploy-plugin.mjs live            send what differs, then check the site
 *   node scripts/deploy-plugin.mjs live --dry      only list what would change
 *   node scripts/deploy-plugin.mjs live --rollback put back the files of the last deploy
 *   add --priority to also clear WP Rocket's priority elements (when hero images change)
 *   add --only a/b.php,c.css to send just those files
 *   add --delete to also remove plugin files that are on the site but no longer in the repo (listed first by --dry)
 *
 * Target files live outside the repo: D:/projects/wiseup/.deploy/<target>.json = { "url": "...", "key": "..." }.
 * Files are sent in batches of about 6 MB; the server checks syntax, backs up, writes, loads the pages and rolls back
 * by itself if anything shows a critical error.
 */
import { readFileSync, readdirSync, statSync } from 'node:fs';
import { createHash } from 'node:crypto';
import { join, relative, sep } from 'node:path';
import { fileURLToPath } from 'node:url';

const here = fileURLToPath(new URL('.', import.meta.url));
const SRC = join(here, '..', 'live-plugin', 'wiseup');
// exit after open network handles close (process.exit right after fetch crashes Node on Windows)
const quit = c => { process.exitCode = c; setTimeout(() => process.exit(c), 150); return new Promise(() => {}); };

const target = process.argv[2];
const doDelete = process.argv.includes('--delete'), dry = process.argv.includes('--dry'), rollback = process.argv.includes('--rollback'), priority = process.argv.includes('--priority');
if (!target) { console.error('usage: deploy-plugin.mjs <local|live> [--dry|--rollback|--priority]'); await quit(1); }
const cfg = JSON.parse(readFileSync(join(here, '..', '..', '.deploy', target + '.json'), 'utf8'));
const api = cfg.url.replace(/\/$/, '') + '/wp-json/wiseup/v1/deploy';
const H = { 'X-Wiseup-Deploy-Key': cfg.key, 'Content-Type': 'application/json', 'User-Agent': 'wiseup-deploy' };
const SKIP = /(^|\/)(\.git|node_modules)(\/|$)|\.before-|\.broken-|\.bak$|\.zip\d*$|\.wudeploy-/;
const OK = /\.(php|js|css|json|txt|md|svg|webp|png|jpe?g|gif|avif|ico|woff2?|ttf|mp4|webm|mp3|pdf|html)$/i;

async function call(path, opts = {}) {
	const r = await fetch(api + path, { headers: H, ...opts });
	const t = await r.text(); let j; try { j = JSON.parse(t); } catch { j = { raw: t.slice(0, 400) }; }
	return { status: r.status, body: j };
}

function walk(d, out = []) {
	for (const n of readdirSync(d)) { const p = join(d, n); if (statSync(p).isDirectory()) walk(p, out); else out.push(p); }
	return out;
}

if (rollback) { const r = await call('/rollback', { method: 'POST', body: '{}' }); console.log(r.status, JSON.stringify(r.body)); await quit(r.status === 200 ? 0 : 1); }

const st = await call('/status');
if (st.status !== 200) { console.error('status failed', st.status, JSON.stringify(st.body)); await quit(1); }
const remote = st.body.files || {};
const local = {};
for (const p of walk(SRC)) {
	const rel = relative(SRC, p).split(sep).join('/');
	if (SKIP.test(rel) || !OK.test(rel)) continue;
	local[rel] = readFileSync(p);
}
const ver = (readFileSync(join(SRC, 'wiseup.php'), 'utf8').match(/Version:\s*([\d.]+)/) || [])[1];
const sha = b => createHash('sha1').update(b).digest('hex');
const oi = process.argv.indexOf('--only'), only = oi > 0 ? process.argv[oi + 1].split(',') : null;
const changed = Object.keys(local).filter(rel => remote[rel] !== sha(local[rel]) && (!only || only.includes(rel)));
// remove only files this deploy owns: same types, not in the repo, never backups or uploads
const extra = Object.keys(remote).filter(rel => !local[rel] && OK.test(rel) && !SKIP.test(rel) && rel !== 'includes/deploy.php');
const gone = doDelete ? extra : [];
console.log(`${target}: live ${st.body.version} -> ${ver}; ${changed.length} changed, ${extra.length} extra on the site (${doDelete ? 'will delete' : 'kept; --delete removes them'})`);
changed.forEach(f => console.log('  ~', f)); if (doDelete || dry) extra.forEach(f => console.log('  -', f));
if (dry || (!changed.length && !gone.length)) await quit(0);

// batches, wiseup.php in the last one so the version changes only when everything else is in
const order = changed.filter(f => f !== 'wiseup.php'); if (changed.includes('wiseup.php')) order.push('wiseup.php');
const batches = []; let cur = [], size = 0;
for (const f of order) { const s = local[f].length * 1.37; if (cur.length && size + s > 6e6) { batches.push(cur); cur = []; size = 0; } cur.push(f); size += s; }
if (cur.length || gone.length) batches.push(cur);
for (let i = 0; i < batches.length; i++) {
	const last = i === batches.length - 1, files = {}, sums = {};
	for (const f of batches[i]) { files[f] = local[f].toString('base64'); sums[f] = sha(local[f]); }
	const body = JSON.stringify({ version: ver, files, sha1: sums, delete: last ? gone : [], clear_priority: last && priority });
	const r = await call('', { method: 'POST', body });
	console.log(`batch ${i + 1}/${batches.length}:`, r.status, JSON.stringify(r.body).slice(0, 600));
	if (r.status !== 200 || !r.body.ok) {
		if (r.body.rolled_back) console.error('The site showed an error with the new files, so it put this batch back by itself. Nothing from this batch is live.');
		else console.error('STOPPED. Nothing from this batch was written.');
		if (i > 0) console.error(`Batches 1-${i} are live; run with --rollback to undo the last of them, or fix and deploy again.`);
		await quit(1);
	}
}
// outside check of a couple of pages
for (const u of [cfg.url + '/', cfg.url + '/?wu=' + Date.now()]) {
	const r = await fetch(u, { headers: { 'User-Agent': 'wiseup-deploy-check' } }); const t = await r.text();
	console.log('check', r.status, u, /critical error/i.test(t) ? 'CRITICAL ERROR' : 'ok');
}
const after = await call('/status'); console.log('live version now', after.body.version);
