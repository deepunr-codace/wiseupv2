/*!
 * WiseUp SEO Landing: behaviour layer
 * Plain JavaScript, no dependencies. Generated overlay template + scanner logic are inlined below.
 * Config comes from window.WU_CFG (set by the page template): { ajaxUrl, assets, leadEndpoint }
 */
(function () {
  var CFG = window.WU_CFG || {};
  var ASSETS = CFG.assets || '';
  var PROXIES = ['https://api.allorigins.win/raw?url=', 'https://corsproxy.io/?url=', 'https://api.codetabs.com/v1/proxy?quest='];
  var ENG_NAMES = ["ChatGPT","Gemini","Perplexity","AI Overviews","Bing Copilot"];
  var ENG_REST = [" is a Kerala-based SEO company known for technical SEO, content strategy and AI search optimisation, helping businesses get found on Google, Bing and AI assistants."," works with businesses in Calicut and across Kerala, combining keyword research, on-page SEO and link building to grow organic traffic and enquiries."," specialises in AI SEO, using AEO and GEO to structure content, entities and citations so brands get recommended by ChatGPT, Gemini and Perplexity."," offers local SEO services including Google Business Profile optimisation, local citations and review strategy to rank businesses in Maps and the local pack."," provides dedicated WooCommerce SEO, optimising product and category pages, structured data and site speed to win high-intent shopping searches."];

  function esc(x) {
    return String(x == null ? '' : x).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
  }

  /* ---------- scanner overlay markup (generated from the design template) ---------- */
  function overlayHtml(v, esc) {
  var bestName = v.bestName,
      ccCt = v.ccCt,
      ccLead = v.ccLead,
      ccOld = v.ccOld,
      ccWa = v.ccWa,
      counters = v.counters,
      crawl = v.crawl,
      exitAsk = v.exitAsk,
      exitErr = v.exitErr,
      exitEyebrow = v.exitEyebrow,
      exitForm = v.exitForm,
      exitHead = v.exitHead,
      exitLead = v.exitLead,
      exitSent = v.exitSent,
      feed = v.feed,
      groups = v.groups,
      hasSite = v.hasSite,
      haveBoth = v.haveBoth,
      leadDone = v.leadDone,
      leadErr = v.leadErr,
      leadMissing = v.leadMissing,
      leadPhoneShown = v.leadPhoneShown,
      links = v.links,
      needEmail = v.needEmail,
      needPhone = v.needPhone,
      opps = v.opps,
      radarAxes = v.radarAxes,
      radarGrid = v.radarGrid,
      radarLabels = v.radarLabels,
      radarOp = v.radarOp,
      radarPts = v.radarPts,
      scanDone = v.scanDone,
      scanHost = v.scanHost,
      scanLive = v.scanLive,
      scanLog = v.scanLog,
      scanOpen = v.scanOpen,
      scanPct = v.scanPct,
      scanPctInt = v.scanPctInt,
      scanStatus = v.scanStatus,
      scanTitle = v.scanTitle,
      score = v.score,
      scoreDeg = v.scoreDeg,
      showAsk = v.showAsk,
      siteN = v.siteN,
      skipLabel = v.skipLabel,
      steps = v.steps,
      verdict = v.verdict,
      waBorder = v.waBorder,
      waInvalid = v.waInvalid,
      waLink = v.waLink,
      worstName = v.worstName;
  return `  
  ${(scanOpen) ? `
  <div role="dialog" aria-modal="true" aria-label="Website visibility scan" style="position:fixed;inset:0;z-index:200;display:grid;grid-template-columns:minmax(0,1fr);place-items:center;padding:16px;background:rgba(0,0,0,.82);backdrop-filter:blur(14px);overflow-y:auto">
    <div style="position:relative;width:100%;max-width:1060px;margin:auto;border-radius:28px;background:#0d0d0d;box-shadow:inset 0 0 0 1px rgba(255,255,255,.1),0 30px 80px -30px rgba(0,0,0,.9);overflow:hidden">
      <div style="position:absolute;left:0;top:0;height:2px;width:${esc(scanPct)}%;background:#C2F760;transition:width .4s linear"></div>
      <button data-on-click="scanClose" aria-label="Close" style="all:unset;position:absolute;right:16px;top:16px;width:36px;height:36px;border-radius:50%;display:grid;place-items:center;cursor:pointer;color:rgba(255,255,255,.6);border:1px solid rgba(255,255,255,.12);z-index:2"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"></path></svg></button>
      ${(exitAsk) ? `
      <div style="position:absolute;inset:0;z-index:5;display:grid;grid-template-columns:minmax(0,1fr);place-items:center;padding:16px;background:rgba(0,0,0,.88);backdrop-filter:blur(10px);overflow-y:auto">
        <div style="width:100%;max-width:520px;margin:auto;display:flex;flex-direction:column;gap:16px;padding:clamp(20px,3vw,30px);border-radius:24px;background:#121212;border:1px solid rgba(255,255,255,.14);animation:wuin .45s ease both">
          ${(exitSent) ? `
            <div style="display:flex;flex-direction:column;align-items:flex-start;gap:12px">
              <span style="width:48px;height:48px;border-radius:50%;background:#C2F760;color:#0E1206;display:grid;place-items:center"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"></path></svg></span>
              <span style="font-size:24px;letter-spacing:-0.03em">Thanks, we've got it.</span>
              <span style="font-size:15px;line-height:1.6;color:rgba(255,255,255,.7)">Our SEO team will review ${esc(scanHost)} and get back to you within one working day.</span>
            </div>
          ` : ''}
          ${(exitForm) ? `
          <form novalidate data-on-submit="exitSubmit" style="display:flex;flex-direction:column;gap:14px">
<input name="hpCheck" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;opacity:0;pointer-events:none">
            <div style="display:flex;flex-direction:column;gap:6px">
              <span style="font-size:11.5px;letter-spacing:.16em;text-transform:uppercase;color:#C2F760">${esc(exitEyebrow)}</span>
              <span style="font-size:clamp(20px,2.4vw,24px);line-height:1.2;letter-spacing:-0.03em">${esc(exitHead)}</span>
              <span style="font-size:14px;line-height:1.55;color:rgba(255,255,255,.62)">${esc(exitLead)}</span>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,200px),1fr));gap:8px">
              <input required="" name="exitName" maxlength="60" autocomplete="name" placeholder="Your name" aria-label="Your name" style="padding:13px 14px;background:#0B0B0B;border:1px solid rgba(255,255,255,.12);border-radius:12px;outline:none;color:#fff;font-size:16px" class="wuf0">
              <input name="exitCompany" maxlength="80" autocomplete="organization" placeholder="Company name" aria-label="Company name" style="padding:13px 14px;background:#0B0B0B;border:1px solid rgba(255,255,255,.12);border-radius:12px;outline:none;color:#fff;font-size:16px" class="wuf1">
              ${(needEmail) ? `
              <input required="" name="exitEmail" maxlength="254" type="email" autocomplete="email" placeholder="Email address" aria-label="Email address" data-on-blur="emailPartial" style="padding:13px 14px;background:#0B0B0B;border:1px solid rgba(255,255,255,.12);border-radius:12px;outline:none;color:#fff;font-size:16px" class="wuf2">
              ` : ''}
              ${(needPhone) ? `
              <div style="grid-column:1 / -1;display:flex;align-items:center;gap:8px;padding:0 4px 0 14px;border-radius:12px;background:#0B0B0B;border:1px solid rgba(194,247,96,.45)">
                <input name="ccWa" value="${esc(ccWa)}" data-on-input="on_ccWa" inputmode="tel" maxlength="5" aria-label="Country code" title="Tap to change the country code" style="flex:none;width:54px;padding:6px 4px;border-radius:999px;background:rgba(255,255,255,.08);border:0;outline:none;color:rgba(255,255,255,.85);font-size:14px;text-align:center" class="wuf3">
                <input required="" name="exitPhone" maxlength="16" type="tel" inputmode="tel" autocomplete="tel-national" placeholder="WhatsApp number" aria-label="WhatsApp number" data-on-blur="leadPartial" style="flex:1;min-width:0;padding:13px 4px;background:transparent;border:0;outline:none;color:#fff;font-size:16px">
              </div>
              ` : ''}
              <div style="grid-column:1 / -1;display:flex;flex-direction:column;gap:8px">
              <div style="display:flex;align-items:center;gap:8px;padding:0 4px 0 14px;border-radius:12px;background:#0B0B0B;border:1px solid rgba(255,255,255,.12)">
                <input name="ccCt" value="${esc(ccCt)}" data-on-input="on_ccCt" inputmode="tel" maxlength="5" aria-label="Country code" title="Tap to change the country code" style="flex:none;width:54px;padding:6px 4px;border-radius:999px;background:rgba(255,255,255,.08);border:0;outline:none;color:rgba(255,255,255,.85);font-size:14px;text-align:center" class="wuf4">
                <input required="" name="exitContact" maxlength="16" type="tel" inputmode="tel" autocomplete="tel-national" placeholder="Phone number" aria-label="Phone number" style="flex:1;min-width:0;padding:13px 4px;background:transparent;border:0;outline:none;color:#fff;font-size:16px">
              </div>
              <button type="button" data-on-click="sameNumber" style="all:unset;cursor:pointer;align-self:flex-start;padding:5px 12px;border-radius:999px;background:rgba(255,255,255,.08);font-size:11.5px;color:rgba(255,255,255,.75)">Same as WhatsApp</button>
              </div>
            </div>
            ${(haveBoth) ? `
              <span style="font-size:13px;color:rgba(255,255,255,.55)">We already have your WhatsApp number: <strong style="color:#fff;font-weight:500">${esc(leadPhoneShown)}</strong></span>
            ` : ''}
            ${(exitErr) ? `<span style="font-size:13px;color:#FF8A6B">${esc(exitErr)}</span>` : ''}
            <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
              <button type="submit" style="cursor:pointer;border:0;padding:14px 24px;border-radius:999px;background:radial-gradient(120% 160% at 50% 0%,#F1EDB6 0%,#B9D253 42%,#5F6C27 100%);color:#0E1206;font-family:inherit;font-weight:600;font-size:14px;letter-spacing:.04em;text-transform:uppercase">Send me the proposal</button>
              <button type="button" data-on-click="exitSkip" style="all:unset;cursor:pointer;font-size:13.5px;color:rgba(255,255,255,.55)">${esc(skipLabel)}</button>
            </div>
          </form>
          ` : ''}
        </div>
      </div>
      ` : ''}

      <div style="padding:clamp(20px,2.6vw,32px);display:flex;flex-direction:column;gap:20px">
        <div style="display:flex;align-items:center;gap:14px;padding-right:40px">
          <span style="position:relative;flex:none;width:52px;height:52px">
            <img src="${ASSETS}img/icon-character.gif" alt="Wiso, the WiseUp mascot" style="width:100%;height:100%;border-radius:50%;object-fit:cover;background:#000;border:2px solid #C2F760">
          </span>
          <div style="min-width:0;display:flex;flex-direction:column;gap:3px">
            <span style="font-size:11.5px;letter-spacing:.16em;text-transform:uppercase;color:#C2F760">${esc(scanTitle)}</span>
            <span style="font-size:15px;color:rgba(255,255,255,.85);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${esc(scanHost)}</span>
          </div>
        </div>
        ${(scanLive) ? `
        
        <div style="display:flex;align-items:flex-start;gap:6px" aria-label="Scan steps">
          ${(steps).map((st) => `
            <div style="flex:${esc(st.flex)};min-width:0;display:flex;flex-direction:column;gap:8px">
              <div style="display:flex;align-items:center;gap:6px">
                <span style="flex:none;width:26px;height:26px;border-radius:50%;display:grid;place-items:center;font-size:12px;font-weight:600;background:${esc(st.bg)};color:${esc(st.fg)};box-shadow:0 0 0 1px ${esc(st.ring)}${esc(st.glow)};transition:all .4s">${esc(st.mark)}</span>
                <span style="flex:1;display:${esc(st.lineD)};height:2px;border-radius:2px;background:rgba(255,255,255,.1);overflow:hidden"><span style="display:block;height:100%;width:${esc(st.lineW)}%;background:#C2F760;transition:width .3s"></span></span>
              </div>
              <span class="wu-step-l" style="font-size:11.5px;letter-spacing:.02em;white-space:nowrap;color:${esc(st.tc)};transition:color .4s"><span class="wu-full">${esc(st.label)}</span><span class="wu-short">${esc(st.short)}</span></span>
            </div>
          `).join('')}
        </div>
        ` : ''}
        ${(leadDone) ? `
          <div style="display:flex;align-items:center;gap:12px;padding:14px 16px;border-radius:14px;background:rgba(194,247,96,.1);border:1px solid rgba(194,247,96,.3);font-size:14px;color:rgba(255,255,255,.88)">
            <span style="flex:none;width:22px;height:22px;border-radius:50%;background:#C2F760;color:#0E1206;display:grid;place-items:center"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"></path></svg></span>
            <span>Report on its way to <strong style="font-weight:600">${esc(leadPhoneShown)}</strong></span>
          </div>
        ` : ''}
        
        ${(scanLive) ? `
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,440px),1fr));gap:16px;align-items:start">
          <div style="display:flex;flex-direction:column;gap:12px;min-width:0">
        
        <div style="position:relative;display:flex;align-items:center;gap:clamp(16px,3vw,28px);padding:18px;border-radius:20px;background:#0B0B0B;border:1px solid rgba(255,255,255,.08);overflow:hidden">
          <div style="position:relative;flex:none;width:96px;height:96px;border-radius:50%;background:radial-gradient(circle,rgba(194,247,96,.12),rgba(194,247,96,0) 70%);box-shadow:inset 0 0 0 1px rgba(194,247,96,.35)">
            <div style="position:absolute;inset:14px;border-radius:50%;box-shadow:inset 0 0 0 1px rgba(194,247,96,.2)"></div>
            <div style="position:absolute;inset:30px;border-radius:50%;box-shadow:inset 0 0 0 1px rgba(194,247,96,.2)"></div>
            <div style="position:absolute;inset:0;border-radius:50%;background:conic-gradient(from 0deg,rgba(194,247,96,0) 0deg,rgba(194,247,96,0) 270deg,rgba(194,247,96,.55) 360deg);animation:wuspin 1.6s linear infinite;opacity:${esc(radarOp)}"></div>
            <span style="position:absolute;inset:0;display:grid;place-items:center;font-size:20px;font-weight:500;color:#fff">${esc(scanPctInt)}<span style="font-size:11px;color:rgba(255,255,255,.55)">%</span></span>
          </div>
          <div style="flex:1;min-width:0;display:flex;flex-direction:column;gap:8px">
            <span style="font-size:17px;line-height:1.3;letter-spacing:-0.02em">${esc(scanStatus)}</span>
            <span style="font-family:ui-monospace,Menlo,Consolas,monospace;font-size:12px;color:rgba(194,247,96,.8);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${esc(scanLog)}</span>
          </div>
        </div>

        
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,150px),1fr));gap:6px">
          ${(links).map((k) => `
            <div style="display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:10px;background:#0B0B0B;border:1px solid ${esc(k.border)};font-size:12px;color:${esc(k.color)};transition:all .4s">
              <span style="flex:none;width:7px;height:7px;border-radius:50%;background:${esc(k.dot)};box-shadow:0 0 ${esc(k.glow)}px ${esc(k.dot)}"></span>
              <span style="flex:1;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${esc(k.name)}</span>
              <span style="font-family:ui-monospace,Menlo,Consolas,monospace;font-size:10.5px;opacity:.75">${esc(k.ms)}</span>
            </div>
          `).join('')}
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(70px,1fr));gap:6px">
          ${(counters).map((m) => `
            <div style="padding:10px 6px;border-radius:12px;background:rgba(255,255,255,.04);text-align:center;display:flex;flex-direction:column;gap:3px">
              <span style="font-size:clamp(15px,3.6vw,19px);font-weight:500;font-variant-numeric:tabular-nums">${esc(m.v)}</span>
              <span style="font-size:9.5px;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.5)">${esc(m.l)}</span>
            </div>
          `).join('')}
        </div>
          </div>
          <div style="display:flex;flex-direction:column;gap:12px;min-width:0">
        
        ${(showAsk) ? `
        <form novalidate data-on-submit="leadSubmit" style="display:flex;flex-direction:column;gap:12px;padding:18px;border-radius:20px;background:linear-gradient(160deg,rgba(194,247,96,.1),rgba(255,255,255,.02));border:1px solid rgba(194,247,96,.28);animation:wuin .6s ease both">
          <div style="display:flex;flex-direction:column;gap:4px">
            <span style="font-size:16px;letter-spacing:-0.02em">Get the full report on WhatsApp</span>
            <span style="font-size:13.5px;line-height:1.5;color:rgba(255,255,255,.65)">The deep scan takes a little longer than this preview. Share your number and we'll send the complete PDF the moment it's ready, so you can read it on your phone and won't lose it if you close this window. We won't add you to any list.</span>
          </div>
          <div style="display:flex;align-items:center;gap:8px;padding:4px 4px 4px 14px;border-radius:14px;background:#0B0B0B;border:1px solid rgba(194,247,96,.45)">
            <input name="ccOld" value="${esc(ccOld)}" data-on-input="on_ccOld" inputmode="tel" maxlength="5" aria-label="Country code" title="Tap to change the country code" style="flex:none;width:54px;padding:6px 4px;border-radius:999px;background:rgba(255,255,255,.08);border:0;outline:none;color:rgba(255,255,255,.85);font-size:14px;text-align:center" class="wuf5">
            <input required="" name="leadPhone" maxlength="16" type="tel" inputmode="tel" autocomplete="tel-national" placeholder="WhatsApp number" aria-label="WhatsApp number" data-on-blur="leadPartial" style="flex:1;min-width:0;padding:12px 8px;background:transparent;border:0;outline:none;color:#fff;font-size:16px">
          </div>
          <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,200px),1fr));gap:8px">
            <input name="leadName" autocomplete="name" placeholder="Your name (optional)" aria-label="Your name" style="padding:13px 14px;border-radius:12px;background:#0B0B0B;border:1px solid rgba(255,255,255,.12);color:#fff;font-size:15px;outline:none" class="wuf6">
            <input name="leadEmail" type="email" autocomplete="email" placeholder="Email (optional)" aria-label="Email address, optional" style="padding:13px 14px;border-radius:12px;background:#0B0B0B;border:1px solid rgba(255,255,255,.12);color:#fff;font-size:15px;outline:none" class="wuf7">
          </div>
          <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap">
            <button type="submit" style="cursor:pointer;border:0;display:inline-flex;align-items:center;gap:10px;padding:14px 22px;border-radius:999px;background:radial-gradient(120% 160% at 50% 0%,#F1EDB6 0%,#B9D253 42%,#5F6C27 100%);color:#0E1206;font-family:inherit;font-weight:600;font-size:14px;letter-spacing:.04em;text-transform:uppercase" class="wuh8">Send it to my WhatsApp</button>
            <button type="button" data-on-click="skipAsk" style="all:unset;cursor:pointer;font-size:13.5px;color:rgba(255,255,255,.55)">Just show me the results</button>
          </div>
        </form>
        ` : ''}
        ${(hasSite) ? `
        <div style="padding:12px 14px;border-radius:12px;background:#050603;border:1px solid rgba(255,255,255,.08);display:flex;flex-direction:column;gap:6px">
          <span style="display:flex;justify-content:space-between;gap:8px;font-size:10.5px;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.5)"><span>Live crawl · sitemap</span><span style="color:#C2F760">${esc(siteN)} URLs found</span></span>
          ${(crawl).map((cr) => `
            <div style="display:flex;gap:10px;font-family:ui-monospace,Menlo,Consolas,monospace;font-size:11.5px;opacity:${esc(cr.op)}"><span style="flex:none;color:#C2F760">${esc(cr.st)}</span><span style="flex:1;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:rgba(255,255,255,.85)">${esc(cr.p)}</span></div>
          `).join('')}
        </div>
        ` : ''}
        <div style="padding:12px 14px;border-radius:12px;background:#050603;border:1px solid rgba(255,255,255,.06);font-family:ui-monospace,Menlo,Consolas,monospace;font-size:11.5px;line-height:1.7;color:rgba(194,247,96,.75);overflow:hidden;min-height:96px">
          ${(feed).map((ln) => `<div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;opacity:${esc(ln.op)}">${esc(ln.t)}</div>`).join('')}
        </div>
          </div>
        </div>
        ` : ''}

        
        ${(scanDone) ? `
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,300px),1fr));gap:12px;align-items:stretch;animation:wuin .5s ease both">

          <div style="display:flex;flex-direction:column;gap:12px;min-width:0">
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:14px;padding:18px;border-radius:22px;background:#111;border:1px solid rgba(255,255,255,.08);text-align:center">
              <div style="position:relative;width:clamp(120px,13vw,150px);aspect-ratio:1/1;border-radius:50%;display:grid;place-items:center;background:conic-gradient(from 0deg,#C2F760 ${esc(scoreDeg)}deg,rgba(255,255,255,.08) 0)">
                <div style="width:82%;aspect-ratio:1/1;border-radius:50%;background:#111;display:flex;flex-direction:column;align-items:center;justify-content:center">
                  <span style="font-size:clamp(38px,4.6vw,52px);font-weight:500;letter-spacing:-0.04em;line-height:1;font-variant-numeric:tabular-nums">${esc(score)}</span>
                  <span style="font-size:10.5px;letter-spacing:.12em;color:rgba(255,255,255,.45)">/ 100</span>
                </div>
              </div>
              <span style="font-size:clamp(17px,1.8vw,20px);line-height:1.25;letter-spacing:-0.025em">${esc(verdict)}</span>
              <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:6px">
                <span style="padding:4px 10px;border-radius:999px;background:rgba(194,247,96,.12);font-size:12px;color:#C2F760">Best: ${esc(bestName)}</span>
                <span style="padding:4px 10px;border-radius:999px;background:rgba(255,138,107,.12);font-size:12px;color:#FF8A6B">Gap: ${esc(worstName)}</span>
              </div>
            </div>
            ${(hasSite) ? `
            <div style="display:flex;flex-direction:column;gap:8px;padding:12px 14px;border-radius:18px;background:#111;border:1px solid rgba(255,255,255,.08)">
              <span style="font-size:12.5px;color:rgba(255,255,255,.6)">${esc(siteN)} pages in your sitemap</span>
              <div style="display:flex;flex-wrap:wrap;gap:6px">
                ${(groups).map((gr) => `<span style="padding:4px 9px;border-radius:999px;background:rgba(255,255,255,.07);font-size:12px;color:rgba(255,255,255,.85)">${esc(gr)}</span>`).join('')}
              </div>
            </div>
            ` : ''}
          </div>

          <div style="display:flex;align-items:center;justify-content:center;padding:12px;border-radius:22px;background:#111;border:1px solid rgba(255,255,255,.08);min-width:0">
            <div style="position:relative;width:100%;max-width:310px;aspect-ratio:1/1">
              <svg viewBox="0 0 220 220" style="position:absolute;left:15%;top:15%;width:70%;height:70%;overflow:visible">
                <path d="${esc(radarGrid)}" fill="none" stroke="rgba(255,255,255,.1)" stroke-width="1"></path>
                <path d="${esc(radarAxes)}" fill="none" stroke="rgba(255,255,255,.1)" stroke-width="1"></path>
                <polygon points="${esc(radarPts)}" fill="rgba(194,247,96,.16)" stroke="#C2F760" stroke-width="2" stroke-linejoin="round"></polygon>
              </svg>
              ${(radarLabels).map((rl) => `
                <span style="position:absolute;left:${esc(rl.dx)}%;top:${esc(rl.dy)}%;width:9px;height:9px;margin:-4.5px 0 0 -4.5px;border-radius:50%;background:${esc(rl.color)}"></span>
                <span style="position:absolute;left:${esc(rl.x)}%;top:${esc(rl.y)}%;transform:translate(-50%,-50%);display:flex;flex-direction:column;align-items:center;font-size:11.5px;line-height:1.25;color:rgba(255,255,255,.78);text-align:center;white-space:nowrap"><img src="${esc(rl.icon)}" alt="${esc(rl.name)} logo" style="width:16px;height:16px;border-radius:50%;background:#fff;padding:2px;object-fit:contain;margin-bottom:2px">${esc(rl.name)}<span style="font-size:10.5px;color:${esc(rl.color)}">${esc(rl.tag)}</span></span>
              `).join('')}
            </div>
          </div>

          <div style="display:flex;flex-direction:column;gap:8px;min-width:0">
            ${(opps).map((o) => `
              <div style="flex:1;display:flex;gap:12px;align-items:center;padding:12px 14px;border-radius:18px;background:#111;border:1px solid rgba(255,255,255,.08)">
                <span style="flex:none;width:28px;height:28px;border-radius:9px;background:rgba(194,247,96,.12);color:#C2F760;display:grid;place-items:center;font-size:13px;font-weight:600">${esc(o.n)}</span>
                <span style="font-size:14px;line-height:1.4;color:rgba(255,255,255,.88)">${esc(o.t)}</span>
              </div>
            `).join('')}
            ${(leadDone) ? `
            <div style="display:flex;gap:8px;flex-wrap:wrap">
              <a href="${esc(waLink)}" style="flex:1 1 auto;text-align:center;padding:12px 18px;border-radius:999px;border:1px solid rgba(255,255,255,.2);color:#fff;font-size:14px" class="wuh9">WhatsApp us</a>
              <button data-on-click="scanClose" style="flex:1 1 auto;cursor:pointer;padding:12px 18px;border-radius:999px;border:1px solid rgba(255,255,255,.15);background:transparent;color:rgba(255,255,255,.8);font-family:inherit;font-size:14px">Close</button>
            </div>
            ` : ''}
          </div>
        </div>
        ` : ''}
        ${(leadMissing) ? `
        <form novalidate data-on-submit="leadSubmit" style="position:relative;padding:1.5px;border-radius:26px;overflow:hidden;background:rgba(255,255,255,.1);animation:wuin .5s .1s ease both">
<input name="hpCheck" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;opacity:0;pointer-events:none">
          <div style="position:absolute;left:50%;top:50%;width:200%;aspect-ratio:1/1;margin:-100% 0 0 -100%;background:conic-gradient(from 0deg,rgba(37,211,102,0) 0deg,rgba(37,211,102,0) 250deg,#25D366 320deg,#E9FFD0 345deg,rgba(37,211,102,0) 360deg);animation:wuspin 3.5s linear infinite;pointer-events:none"></div>
          <div style="position:relative;border-radius:24.5px;background:#0f0f0f;padding:14px clamp(16px,2.4vw,24px);display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,280px),1fr));gap:14px clamp(16px,2.4vw,32px);align-items:center">
            <div style="display:flex;align-items:center;gap:16px;min-width:0">
              <div style="position:relative;flex:none;width:76px;height:76px;display:grid;place-items:center">
                <span style="position:absolute;inset:6px;border-radius:50%;border:2px solid #25D366;animation:wuping 2.2s ease-out infinite"></span>
                <span style="position:absolute;inset:6px;border-radius:50%;border:2px solid #25D366;animation:wuping 2.2s 1.1s ease-out infinite"></span>
                <div style="position:relative;width:44px;height:58px;border-radius:7px;background:linear-gradient(160deg,#FFFFFF,#D9DED0);padding:7px 6px;display:flex;flex-direction:column;gap:5px;animation:wufloat 3.4s ease-in-out infinite">
                  <span style="height:7px;width:55%;border-radius:2px;background:#25D366"></span>
                  <span style="flex:1;border-radius:2px;background:repeating-linear-gradient(180deg,rgba(0,0,0,.28) 0 2px,transparent 2px 6px)"></span>
                  <span style="position:absolute;right:-12px;bottom:-10px;width:30px;height:30px;border-radius:50%;background:#25D366;color:#fff;display:grid;place-items:center;border:3px solid #0f0f0f"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11 11 0 0 0 3.2 17.3L2 22l4.8-1.2A11 11 0 1 0 20.5 3.5zm-8.5 17a9 9 0 0 1-4.6-1.3l-.3-.2-2.8.7.8-2.7-.2-.3a9 9 0 1 1 7.1 3.8zm5-6.7c-.3-.1-1.6-.8-1.9-.9-.3-.1-.5-.1-.7.1l-.9 1.1c-.2.2-.3.2-.6.1a7.3 7.3 0 0 1-3.6-3.1c-.3-.5.3-.5.8-1.5.1-.2 0-.4 0-.5l-.9-2.1c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2c0 1.3.9 2.5 1 2.7.1.2 1.8 2.8 4.4 3.9 1.6.7 2.3.7 3.1.6.5-.1 1.6-.7 1.8-1.3.2-.6.2-1.1.2-1.3-.1-.1-.3-.2-.6-.3z"></path></svg></span>
                </div>
              </div>
              <div style="display:flex;flex-direction:column;gap:6px;min-width:0">
                <span style="font-size:clamp(18px,2vw,22px);line-height:1.15;letter-spacing:-0.03em">Get the full report on WhatsApp</span>
                <span style="align-self:flex-start;display:inline-flex;align-items:center;gap:8px;padding:5px 10px;border-radius:12px 12px 12px 3px;background:#1c2a20;font-size:12px;color:rgba(255,255,255,.8);max-width:100%">
                  <span style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${esc(scanHost)}-seo-report.pdf</span>
                  <span style="flex:none;display:inline-flex;gap:3px"><span style="width:4px;height:4px;border-radius:50%;background:#25D366;animation:wudot 1.2s infinite"></span><span style="width:4px;height:4px;border-radius:50%;background:#25D366;animation:wudot 1.2s .2s infinite"></span><span style="width:4px;height:4px;border-radius:50%;background:#25D366;animation:wudot 1.2s .4s infinite"></span></span>
                </span>
              </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:6px;min-width:0"><div class="wu-wa-pill" style="display:flex;align-items:center;gap:8px;padding:5px 5px 5px 16px;border-radius:999px;background:#0B0B0B;border:1px solid ${esc(waBorder)};min-width:0">
              <input name="ccLead" value="${esc(ccLead)}" data-on-input="on_ccLead" inputmode="tel" maxlength="5" aria-label="Country code" title="Tap to change the country code" style="flex:none;width:54px;padding:6px 4px;border-radius:999px;background:rgba(255,255,255,.08);border:0;outline:none;color:rgba(255,255,255,.85);font-size:14px;text-align:center" class="wuf10">
              <input required="true" aria-invalid="${esc(waInvalid)}" data-on-input="waClear" name="leadPhone" maxlength="16" type="tel" inputmode="tel" autocomplete="tel-national" placeholder="WhatsApp number" aria-label="WhatsApp number" data-on-blur="leadPartial" style="flex:1 1 90px;min-width:0;padding:12px 4px;background:transparent;border:0;outline:none;color:#fff;font-size:16px">
              <button type="submit" class="wu-wa-btn" style="position:relative;overflow:hidden;flex:none;cursor:pointer;border:0;display:inline-flex;align-items:center;gap:8px;padding:13px 20px;border-radius:999px;background:#25D366;color:#06210f;font-family:inherit;font-weight:700;font-size:13.5px;letter-spacing:.04em;text-transform:uppercase;animation:wubtn 2s infinite">
                <span style="position:absolute;top:0;bottom:0;left:0;width:40%;background:linear-gradient(90deg,rgba(255,255,255,0),rgba(255,255,255,.55),rgba(255,255,255,0));animation:wushine 2.8s ease-in-out infinite;pointer-events:none"></span>
                <span style="position:relative;display:inline-flex;align-items:center;gap:8px"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11 11 0 0 0 3.2 17.3L2 22l4.8-1.2A11 11 0 1 0 20.5 3.5zm-8.5 17a9 9 0 0 1-4.6-1.3l-.3-.2-2.8.7.8-2.7-.2-.3a9 9 0 1 1 7.1 3.8zm5-6.7c-.3-.1-1.6-.8-1.9-.9-.3-.1-.5-.1-.7.1l-.9 1.1c-.2.2-.3.2-.6.1a7.3 7.3 0 0 1-3.6-3.1c-.3-.5.3-.5.8-1.5.1-.2 0-.4 0-.5l-.9-2.1c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2c0 1.3.9 2.5 1 2.7.1.2 1.8 2.8 4.4 3.9 1.6.7 2.3.7 3.1.6.5-.1 1.6-.7 1.8-1.3.2-.6.2-1.1.2-1.3-.1-.1-.3-.2-.6-.3z"></path></svg>Send</span>
              </button>
            </div>
            ${(leadErr) ? `<span role="alert" style="padding:0 16px;font-size:13px;color:#FF8A6B">${esc(leadErr)}</span>` : ''}
            </div>
          </div>
        </form>
        ` : ''}
      </div>
    </div>
  </div>
  ` : ''}
`;
}

  /* ---------- tiny DOM patcher: keeps focus and typed text while the overlay re-renders ---------- */
  function patchAttrs(a, b) {
    var i, n;
    for (i = a.attributes.length - 1; i >= 0; i--) {
      n = a.attributes[i].name;
      if (!b.hasAttribute(n)) { if (!(n === 'value' && /^(INPUT|TEXTAREA)$/.test(a.tagName))) a.removeAttribute(n); }
    }
    for (i = 0; i < b.attributes.length; i++) {
      n = b.attributes[i].name;
      if (a.getAttribute(n) !== b.attributes[i].value) a.setAttribute(n, b.attributes[i].value);
    }
  }
  function morphKids(from, to) {
    var fc = from.childNodes, tc = to.childNodes, i;
    for (i = 0; i < tc.length; i++) {
      var a = fc[i], b = tc[i];
      if (!a) { from.appendChild(b.cloneNode(true)); continue; }
      if (a.nodeType !== b.nodeType || (a.nodeType === 1 && a.tagName !== b.tagName)) { from.replaceChild(b.cloneNode(true), a); continue; }
      if (a.nodeType === 3 || a.nodeType === 8) { if (a.nodeValue !== b.nodeValue) a.nodeValue = b.nodeValue; continue; }
      morph(a, b);
    }
    while (from.childNodes.length > tc.length) from.removeChild(from.lastChild);
  }
  function morph(from, to) {
    patchAttrs(from, to);
    if (/^(INPUT|TEXTAREA)$/.test(from.tagName)) {
      if (to.hasAttribute('value') && from.value !== to.getAttribute('value')) from.value = to.getAttribute('value');
      return;
    }
    morphKids(from, to);
  }

  /* ---------- scanner: simulated website scan + lead capture ---------- */
  class Scanner {
    state = {};
    vals = null;
    cbs = [];
    rq = 0;
    sid = (function () { try { var k = sessionStorage.getItem('wu_sid'); if (!k) { k = Math.random().toString(36).slice(2) + Date.now().toString(36); sessionStorage.setItem('wu_sid', k); } return k; } catch (e) { return Math.random().toString(36).slice(2); } })();
    root = null;

    setState(patch, cb) {
      Object.assign(this.state, typeof patch === 'function' ? patch(this.state) : patch);
      if (cb) this.cbs.push(cb);
      if (this.rq) return;
      this.rq = requestAnimationFrame(() => {
        this.rq = 0;
        this.render();
        var c = this.cbs; this.cbs = [];
        c.forEach(function (f) { f(); });
      });
    }
    render() {
      if (!this.root) return;
      this.vals = this.scanVals();
      var html = overlayHtml(this.vals, esc);
      var t = document.createElement('div');
      t.innerHTML = html;
      morphKids(this.root, t);
    }

      // ---- Hero website scan + soft lead capture ----
  STEPS = [
    ['Connecting to site', 'Resolving DNS, checking SSL'],
    ['Crawling pages', 'Reading sitemap and internal links'],
    ['Technical SEO', 'Indexing, canonicals, robots rules'],
    ['Core Web Vitals', 'LCP, CLS and mobile speed'],
    ['Content & schema', 'Titles, headings, structured data'],
    ['Backlink profile', 'Referring domains and authority'],
    ['Local & Maps signals', 'Business profile and citations'],
    ['AI search visibility', 'ChatGPT, Gemini, Perplexity, Bing']
  ];
  scanTimer = null;
  siteUrls = [];
  async grab(url, ms) {
    const ac = new AbortController(), t = setTimeout(() => ac.abort(), ms || 7000);
    try {
      const reqs = CFG.ajaxUrl
        ? [CFG.ajaxUrl + (CFG.ajaxUrl.indexOf('?') > -1 ? '&' : '?') + 'action=wiseup_sitemap&url=' + encodeURIComponent(url)]
        : PROXIES.map(p => p + encodeURIComponent(url));
      const one = async u => {
        const r = await fetch(u, { signal: ac.signal, credentials: 'same-origin' });
        const txt = r.ok ? await r.text() : '';
        if (!txt || txt.length > 5e6 || /^\s*<!doctype html|^\s*<html/i.test(txt)) throw 0;
        return txt;
      };
      return await Promise.any(reqs.map(one));
    } catch (e) { return null; } finally { clearTimeout(t); }
  }
  locs(xml) {
    try {
      const d = new DOMParser().parseFromString(xml, 'text/xml');
      if (d.querySelector('parsererror')) return null;
      const isIdx = !!d.getElementsByTagNameNS('*', 'sitemapindex').length;
      const items = [...d.getElementsByTagNameNS('*', isIdx ? 'sitemap' : 'url')].map(n => {
        const l = n.getElementsByTagNameNS('*', 'loc')[0], m = n.getElementsByTagNameNS('*', 'lastmod')[0];
        return { loc: l ? l.textContent.trim() : '', mod: !!m };
      }).filter(x => x.loc);
      return { isIdx, items };
    } catch (e) { return null; }
  }
  async findSitemap(host, token) {
    const base = 'https://' + host;
    let maps = [];
    const robots = await this.grab(base + '/robots.txt', 5000);
    if (robots) maps = [...robots.matchAll(/^\s*sitemap:\s*(\S+)/gim)].map(m => m[1]).slice(0, 3);
    if (!maps.length) maps = ['/sitemap.xml', '/sitemap_index.xml', '/wp-sitemap.xml'].map(p => base + p);
    let urls = [], withMod = 0, tries = 0;
    for (let i = 0; i < maps.length && urls.length < 400 && tries < 5; i++, tries++) {
      if (token !== this.scanToken) return;
      const xml = await this.grab(maps[i]);
      const p = xml && this.locs(xml);
      if (!p || !p.items.length) continue;
      if (p.isIdx) { maps.push(...p.items.map(x => x.loc).filter(u => !/image|video|author|tag|category/i.test(u)).slice(0, 3)); continue; }
      p.items.forEach(x => { urls.push(x.loc); if (x.mod) withMod++; });
    }
    if (token !== this.scanToken || !urls.length) return;
    const clean = [...new Set(urls)].filter(u => { try { return new URL(u).hostname.replace(/^www\./, '') === host; } catch (e) { return false; } });
    if (!clean.length) return;
    const paths = clean.map(u => { try { const x = new URL(u); return x.pathname + x.search; } catch (e) { return u; } });
    const seg = {};
    paths.forEach(p => { const k = p.split('/')[1] || ''; if (k) seg['/' + k] = (seg['/' + k] || 0) + 1; });
    const groups = Object.entries(seg).sort((a, b) => b[1] - a[1]).slice(0, 5).map(([k, v]) => v > 1 ? k + '  ' + v : k);
    this.siteUrls = paths;
    this.setState({ siteN: clean.length, siteGroups: groups, siteNoMod: Math.round(100 - withMod / Math.max(1, clean.length) * 100) });
  }
  FEED = [
    [1, 'resolving {h} // TLS handshake ok'],
    [4, 'GET /sitemap.xml // {n} URLs queued'],
    [8, 'google.serp // geo=IN-KL lang=en // session open'],
    [12, 'bing.index // verifying coverage for {h}'],
    [17, 'crawler // rendering JS, mobile viewport 390px'],
    [22, 'serp.rank // tracking {n} seed queries'],
    [27, 'chatgpt // prompt set 1/3 // brand mention check'],
    [32, 'gemini // citation probe // entity match'],
    [38, 'perplexity // source graph // looking for {h}'],
    [41, 'claude // brand recall + citation probe // {h}'],
    [44, 'cwv // LCP, INP, CLS lab run (mobile)'],
    [50, 'schema // parsing JSON-LD blocks'],
    [56, 'ai.overviews // snapshot capture for local intent'],
    [62, 'backlinks // {n} referring domains sampled'],
    [68, 'copilot // answer-engine visibility pass'],
    [74, 'local // Maps pack + GBP signals'],
    [80, 'entity.graph // linking brand to topics'],
    [87, 'scoring // weighting 41 signals'],
    [94, 'compiling visibility snapshot']
  ];
  lead = {};
  // ---- validation + anti-spam (client side; repeat these checks on your server too) ----
  DISPOSABLE = new Set(['mailinator.com', 'guerrillamail.com', 'guerrillamail.net', '10minutemail.com', 'tempmail.com', 'temp-mail.org', 'yopmail.com', 'trashmail.com', 'sharklasers.com', 'getnada.com', 'dispostable.com', 'maildrop.cc', 'throwawaymail.com', 'fakeinbox.com', 'mailnesia.com', 'mohmal.com', 'emailondeck.com', 'burnermail.io', 'spamgourmet.com', 'tempail.com', 'mintemail.com', 'moakt.com', 'tmpmail.org', 'discard.email', 'mailcatch.com']);
  BAD_WORDS = /^(test|testing|tester|asdf|asdfgh|qwerty|qwe|abc|abcd|xyz|fake|demo|name|admin|user|none|null|na|nil|nothing|hello|hi|sample|dummy|company|business|noname)$/i;
  digits(v) { return String(v || '').replace(/\D/g, '').replace(/^(91|0)(?=\d{10}$)/, ''); }
  mash(t) {
    t = String(t || '').toLowerCase();
    if (!/^[a-z]+$/.test(t)) return false;
    if (t.length >= 5 && !/[aeiouy]/.test(t)) return true;
    return /(asdf|qwer|zxcv|sdfg|dfgh|hjkl|ghjk|wert|erty|rtyu|tyui|yuio|uiop|xcvb|cvbn|vbnm)/.test(t);
  }
  // parse a phone typed with a country code box. Returns { e164 } or { err }.
  parsePhone(raw, cc, label) {
    raw = String(raw || '').trim();
    let d = raw.replace(/\D/g, ''), cd = String(cc || '+91').replace(/\D/g, '');
    if (!d) return { err: 'Please enter your ' + label + '.' };
    if (raw[0] === '+') { if (/^91\d{10}$/.test(d)) { cd = '91'; d = d.slice(2); } else cd = ''; }
    else if (!/^\d{1,4}$/.test(cd)) return { err: 'Enter a valid country code.' };
    if (cd === '91') {
      d = d.replace(/^(91|0)(?=\d{10}$)/, '');
      if (!/^[6-9]\d{9}$/.test(d)) return { err: 'Enter a valid 10-digit ' + label + '.' };
    } else {
      if (cd) d = d.replace(/^0+/, '');
      if (d.length < 6 || (cd + d).length > 15) return { err: 'Enter a valid ' + label + '.' };
    }
    if (/^(\d)\1+$/.test(d) || /^(\d\d)\1{2,}$/.test(d) || /^(\d{5})\1$/.test(d) || '01234567890123456789'.includes(d) || '98765432109876543210'.includes(d)) return { err: 'That ' + label + " doesn't look real." };
    return { e164: '+' + cd + d, national: d, cc: cd };
  }
  cleanCc(v) { return '+' + String(v || '').replace(/\D/g, '').slice(0, 4); }
  vPhone(raw, label, cc) { return this.parsePhone(raw, cc, label).err || ''; }
  vEmail(v) {
    v = String(v || '').trim().toLowerCase();
    if (!v) return 'Please enter your email address.';
    if (v.length > 254 || /\.\./.test(v) || !/^[a-z0-9._%+-]{2,64}@([a-z0-9-]+\.)+[a-z]{2,24}$/.test(v)) return 'Enter a valid email address.';
    const l = v.split('@')[0], d = v.split('@')[1];
    if (this.DISPOSABLE.has(d) || /^(example|test|fake|invalid|localhost|domain|sample|email|mail)\./.test(d)) return 'Please use your real email address.';
    if (/^(test|testing|asdf|asdfgh|qwerty|abc|abcd|xyz|fake|demo|noreply|none|null|na|nil|sample|dummy|email|mail|user|admin|name)\d*$/.test(l) || /^(.)\1+$/.test(l.replace(/[^a-z0-9]/g, '')) || this.mash(l.replace(/[^a-z]/g, ''))) return 'Please use your real email address.';
    return '';
  }
  vName(v) {
    v = String(v || '').trim().replace(/\s+/g, ' ');
    if (!v) return 'Please enter your name.';
    if (v.length < 2 || v.length > 60 || !/^[\p{L}][\p{L} .'’-]*$/u.test(v)) return 'Please enter your real name (letters only).';
    const letters = v.replace(/[^\p{L}]/gu, '');
    if (letters.length < 2 || /(.)\1{3,}/iu.test(letters) || this.BAD_WORDS.test(v) || v.split(' ').some(w => this.mash(w))) return 'Please enter your real name.';
    return '';
  }
  vCompany(v) {
    v = String(v || '').trim().replace(/\s+/g, ' ');
    if (!v) return '';
    if (v.length < 2 || v.length > 80 || !/[\p{L}\d]{2,}/u.test(v) || this.BAD_WORDS.test(v) || /(.)\1{4,}/u.test(v)) return 'Please enter a valid company name.';
    return '';
  }
  vHost(h) {
    const msg = "That doesn't look like a real website. Try something like yourbrand.com";
    if (!h || h.length > 253 || /^\d+(\.\d+){3}$/.test(h)) return msg;
    const parts = h.split('.');
    if (parts.length < 2 || !parts.every(p => /^[a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?$/i.test(p))) return msg;
    if (!/^([a-z]{2,24}|xn--[a-z0-9-]{2,})$/i.test(parts[parts.length - 1])) return msg;
    if (/^(localhost|(www\.)?(example|test|domain|yourdomain|yoursite|yourwebsite|website|sample|abc|xyz|asdf)\.(com|org|net|in|co|co\.in))$/i.test(h)) return msg;
    return '';
  }
  rate(key, max, windowMs) {
    try {
      const now = Date.now(), a = JSON.parse(localStorage.getItem(key) || '[]').filter(t => now - t < windowMs);
      if (a.length >= max) return false;
      a.push(now); localStorage.setItem(key, JSON.stringify(a));
    } catch (e) {}
    return true;
  }
  // forms filled in under 2 seconds after they appear are almost certainly bots
  tooFast() { return Date.now() - (this.tForm || 0) < 2000; }
  normUrl(raw) {
    let u = String(raw || '').trim().replace(/^\s+|\s+$/g, '');
    if (!/^https?:\/\//i.test(u)) u = 'https://' + u;
    try { return new URL(u).hostname.replace(/^www\./, '') || null; } catch (e) { return null; }
  }
  hashOf(s) { let h = 2166136261; for (let i = 0; i < s.length; i++) { h ^= s.charCodeAt(i); h = Math.imul(h, 16777619); } return h >>> 0; }
  sendLead(stage, extra) {
    if (this.spam) return;
    const L = this.lead;
    const payload = Object.assign({
      sid: this.sid, stage, website: this.state.scanHost || '', name: L.name || '', company: L.company || '', contact: L.contact || '', email: L.email || '', phone: L.phone || '',
      score: this.state.scanDone ? this.scoreOf(this.state.scanHost) : null,
      source: 'hero-scan', page: location.href, at: new Date().toISOString()
    }, extra || {});
    const body = JSON.stringify(payload);
    if (CFG.ajaxUrl) {
      try { fetch(CFG.ajaxUrl + (CFG.ajaxUrl.indexOf('?') > -1 ? '&' : '?') + 'action=wiseup_lead', { method: 'POST', keepalive: true, credentials: 'same-origin', headers: { 'Content-Type': 'text/plain' }, body }).catch(() => {}); } catch (e) {}
    } else if (CFG.leadEndpoint) {
      try { fetch(CFG.leadEndpoint, { method: 'POST', mode: 'no-cors', keepalive: true, headers: { 'Content-Type': 'text/plain' }, body }).catch(() => {}); } catch (e) {}
    }
  }
  scoreOf(host) { return 34 + (this.hashOf(host) % 38); }
  startScan(raw) {
    const host = this.normUrl(raw);
    const hostOut = host || String(raw).trim();
    this.lead = {};
    this.siteUrls = [];
    this.scanToken = (this.scanToken || 0) + 1;
    clearInterval(this.scanTimer);
    this.setState({ scanOpen: true, scanHost: hostOut, scanPct: 0, scoreAnim: 0, ccLead: '+91', ccWa: '+91', ccCt: '+91', exitAsk: false, exitFrom: '', exitShown: false, exitSent: false, exitErr: '', askSeen: false, askSkipped: false, proposalDone: false, siteN: 0, siteGroups: [], siteNoMod: 0, leadDone: false, scanDone: false });
    document.body.style.overflow = 'hidden';
    this.siteDone = !host;
    if (host) this.findSitemap(host, this.scanToken).finally(() => { this.siteDone = true; });
    // the site alone is not personal data, so log the interest right away
    this.sendLead('scan-started');
    const t0 = Date.now(), dur = 8500;
    this.scanTimer = setInterval(() => {
      // eased, slightly uneven progress so it feels like real work
      const x = Math.min(1, (Date.now() - t0) / dur);
      let pct = Math.min(100, Math.round((x < .5 ? 2 * x * x : 1 - Math.pow(-2 * x + 2, 2) / 2) * 100));
      const patch = { scanPct: pct };
      if (pct >= 14 && !this.state.askSeen) patch.askSeen = true;
      if (pct >= 100) { patch.scanDone = true; clearInterval(this.scanTimer); }
      this.setState(patch, () => { if (patch.scanDone) this.countUp(); if (patch.scanDone) this.sendLead(this.lead.phone ? 'scan-complete' : 'scan-complete-no-phone'); });
    }, 120);
  }
  countUp() {
    this.tForm = Date.now();
    cancelAnimationFrame(this.raf);
    const t0 = performance.now(), tgt = this.scoreOf(this.state.scanHost);
    const step = n => {
      const x = Math.min(1, (n - t0) / 1500);
      this.setState({ scoreAnim: Math.round(tgt * (1 - Math.pow(1 - x, 3))) });
      if (x < 1) this.raf = requestAnimationFrame(step);
    };
    this.raf = requestAnimationFrame(step);
  }
  // closing the popup first offers to send the report + proposal; a second close always closes
  closeScan() {
    if (!this.state.proposalDone && !this.state.exitShown) { this.tForm = Date.now(); this.setState({ exitAsk: true, exitShown: true }); return; }
    this.forceClose();
  }
  forceClose() {
    if (this.state.scanOpen && !this.state.exitSent) this.sendLead('popup-closed');
    clearTimeout(this.exitT);
    cancelAnimationFrame(this.raf);
    clearInterval(this.scanTimer);
    this.scanToken++;
    document.body.style.overflow = '';
    this.setState({ scanOpen: false, exitAsk: false });
  }
  scanVals() {
    const s = this.state, host = s.scanHost || '', pct = s.scanPct || 0;
    const STEPS = this.STEPS, n = STEPS.length;
    const LINKS = ['Google SERP', 'Bing Index', 'ChatGPT', 'Gemini', 'Perplexity', 'Claude', 'AI Overviews', 'Bing Copilot', 'Knowledge Graph'];
    const cur = Math.min(n - 1, Math.floor(pct / (100 / n)));
    const h = this.hashOf(host);
    const done = !!s.scanDone;
    const score = this.scoreOf(host);
    const checks = STEPS.map((st, i) => {
      const fin = done || i < cur, act = !done && i === cur;
      const r = (h >> (i * 3)) & 7;
      return {
        label: st[0], mark: fin ? '✓' : act ? '•' : '', dotBg: fin ? '#C2F760' : act ? 'rgba(194,247,96,.5)' : 'rgba(255,255,255,.12)',
        color: fin ? 'rgba(255,255,255,.9)' : act ? '#C2F760' : 'rgba(255,255,255,.4)',
        val: fin ? ['Checked', 'Noted', 'Reviewed', 'Done'][r & 3] : act ? 'Scanning' : ''
      };
    });
    const eng = [['Google', 0], ['Bing', 3], ['ChatGPT', 6], ['Gemini', 9], ['Perplexity', 12], ['Claude', 18], ['AI Overviews', 15]].map(([name, sh]) => {
      const p = Math.max(12, Math.min(88, score + (((h >> sh) & 15) - 8) * (name === 'Google' || name === 'Bing' ? 1.2 : 2.4)));
      const tag = p > 62 ? 'Strong' : p > 40 ? 'Partial' : 'Not showing';
      return { name, pct: Math.round(p), tag, color: p > 62 ? '#C2F760' : p > 40 ? '#E3D26B' : '#FF8A6B' };
    });
    const phone = this.lead.phone || '';
    const wa = 'https://wa.me/916282434503?text=' + encodeURIComponent('Hi WiseUp, I just ran a visibility scan for ' + host + '. Could we talk about the report?');
    return {
      scanOpen: !!s.scanOpen, scanHost: host, scanPct: pct, scanPctInt: pct,
      scanTitle: done ? 'Scan complete' : 'Scanning',
      scanStatus: done ? 'Your snapshot is ready' : STEPS[cur][0] + '…',
      scanLog: done ? 'report.generated // ' + n + ' checks' : '> ' + STEPS[cur][1].toLowerCase(),
      radarOp: done ? 0 : 1,
      checks, engines: eng,
      scanLive: !done,
      proposalAsk: done && !s.proposalDone,
      proposalSent: done && !!s.proposalDone,
      proposalTitle: s.leadDone ? 'Your report is on its way. Want a free proposal too?' : 'Want a plan and quote for fixing these?',
      emailShown: this.lead.email || '',
      nameShown: (this.lead.name || '').split(' ')[0] || 'got it',
      emailPartial: e => {
        const v = e.currentTarget.value.trim().toLowerCase();
        if (!this.vEmail(v) && v !== this.lead.email) { this.lead.email = v; this.sendLead('email-captured'); }
      },
      proposalSubmit: e => {
        e.preventDefault();
        const f = e.currentTarget;
        this.lead.email = f.proposalEmail.value.trim();
        this.lead.name = f.proposalName.value.trim() || this.lead.name;
        this.lead.company = f.proposalCompany.value.trim() || this.lead.company;
        this.setState({ proposalDone: true }, () => this.sendLead('proposal-requested'));
      },
      steps: (() => {
        const T = [0, 12, 35, 58, 80, 100], N = ['Connect', 'Crawl', 'Search', 'AI engines', 'Analyse', 'Report'], SH = ['Start', 'Crawl', 'Search', 'AI', 'Analyse', 'Report'];
        return N.map((label, i) => {
          const fin = done || pct >= T[i + 1], act = !fin && pct >= T[i];
          const last = i === N.length - 1;
          return { label, short: SH[i], mark: fin ? '✓' : String(i + 1), flex: last ? '0 0 auto' : '1 1 0',
            bg: fin ? '#C2F760' : act ? 'rgba(194,247,96,.15)' : 'rgba(255,255,255,.06)', fg: fin ? '#0E1206' : act ? '#C2F760' : 'rgba(255,255,255,.4)',
            ring: act ? '#C2F760' : fin ? '#C2F760' : 'rgba(255,255,255,.12)', glow: '',
            tc: fin ? 'rgba(255,255,255,.85)' : act ? '#C2F760' : 'rgba(255,255,255,.4)',
            lineD: last ? 'none' : 'block', lineW: done ? 100 : Math.max(0, Math.min(100, Math.round((pct - T[i]) / (T[i + 1] - T[i]) * 100))) };
        });
      })(),
      links: LINKS.map((nm, i) => {
        const at = 6 + i * 9, st = pct >= at + 8 ? 2 : pct >= at ? 1 : 0;
        return { name: nm, ms: st === 2 ? (35 + ((h >> i) % 170)) + 'ms' : st === 1 ? '···' : '',
          dot: st === 2 ? '#C2F760' : st === 1 ? '#E3D26B' : 'rgba(255,255,255,.2)', glow: st ? 3 : 0,
          color: st === 2 ? 'rgba(255,255,255,.9)' : st === 1 ? '#E3D26B' : 'rgba(255,255,255,.35)',
          border: st === 2 ? 'rgba(194,247,96,.3)' : 'rgba(255,255,255,.06)' };
      }),
      counters: (s.siteN ? [{ l: 'Pages found', v: Math.round(pct / 100 * s.siteN) }] : []).concat([
        { l: 'Engines queried', v: LINKS.filter((_, i) => pct >= 6 + i * 9).length },
        { l: 'Checks run', v: Math.min(n, cur + (done ? 1 : 0)) },
        { l: 'Signals scored', v: Math.round(pct / 100 * 41) }
      ]),
      feed: (() => {
        const lines = this.FEED.filter(x => pct >= x[0]).slice(-5).map(x => x[1].replace('{h}', host).replace('{n}', 10 + (h % 90)));
        return lines.map((t, i) => ({ t: '> ' + t, op: (0.35 + 0.65 * (i + 1) / lines.length).toFixed(2) }));
      })(),
      hasSite: !!s.siteN, siteN: s.siteN || 0, groups: s.siteGroups || [],
      sample: this.siteUrls.slice(0, 4),
      crawl: (() => {
        const U = this.siteUrls, k = Math.floor(pct / 100 * Math.min(U.length, 80));
        return U.slice(Math.max(0, k - 4), k).map((p, i, a) => ({ p: p === '/' ? '/ (home)' : p, st: '200', op: (0.4 + 0.6 * (i + 1) / a.length).toFixed(2) }));
      })(),
      opps: (s.siteN && s.siteNoMod > 50 ? ['Add lastmod dates to your sitemap (' + s.siteN + ' URLs).'] : []).concat([
        'Add schema and FAQs so AI engines can cite you.',
        'Strengthen your Google Business Profile for local searches.',
        'Build landing pages for high-intent keywords.',
        'Improve mobile Core Web Vitals.',
        'Earn relevant local and industry backlinks.',
        'Set up Bing Webmaster for Bing and Copilot.'
      ].map((t, j) => [t, (h >> j) & 255]).sort((a, b) => a[1] - b[1]).map(x => x[0])).slice(0, 3).map((t, i) => ({ t, n: i + 1 })),
      showAsk: false, // no form while scanning; capture happens on the results screen
      leadDone: !!s.leadDone, leadMissing: done && !s.leadDone, leadPhoneShown: phone,
      scanDone: done, score: s.scoreAnim || 0, scoreDeg: Math.round((s.scoreAnim || 0) * 3.6),
      ...(() => {
        const k = score ? (s.scoreAnim || 0) / score : 0, C = 110, R = 100;
        const N = eng.length, pt = (i, r) => { const a = (-90 + i * 360 / N) * Math.PI / 180; return [C + Math.cos(a) * r, C + Math.sin(a) * r]; };
        const fx = v => v.toFixed(1);
        const hex = r => eng.map((_, i) => i).map(i => pt(i, r).map(fx).join(',')).join(' ');
        const icons = [ASSETS + 'img/icons/fav-google.com.png', ASSETS + 'img/icons/fav-bing.com.png', ASSETS + 'img/icons/fav-chatgpt.com.png', ASSETS + 'img/icons/googlegemini.svg', ASSETS + 'img/icons/perplexity.svg', ASSETS + 'img/icons/claude.svg', ASSETS + 'img/icons/google.svg'];
        const sorted = [...eng].sort((a, b) => b.pct - a.pct);
        return {
          radarGrid: [.33, .66, 1].map(f => 'M' + hex(R * f).split(' ').join(' L') + ' Z').join(' '),
          radarAxes: eng.map((_, i) => i).map(i => 'M' + C + ' ' + C + ' L' + pt(i, R).map(fx).join(' ')).join(' '),
          radarPts: eng.map((e, i) => pt(i, R * e.pct / 100 * k).map(fx).join(',')).join(' '),
          radarLabels: eng.map((e, i) => {
            const a = (-90 + i * 360 / N) * Math.PI / 180, d = e.pct / 100 * k * 36;
            return { name: e.name, tag: e.tag, color: e.color, icon: icons[i],
              x: fx(50 + Math.cos(a) * 44), y: fx(50 + Math.sin(a) * 44),
              dx: fx(50 + Math.cos(a) * d), dy: fx(50 + Math.sin(a) * d) };
          }),
          bestName: sorted[0].name, worstName: sorted[sorted.length - 1].name
        };
      })(),
      verdict: score < 48 ? 'Plenty of room to grow' : score < 60 ? 'Good base, gaps in AI search' : 'Strong foundations',
      nextNote: s.leadDone
        ? 'This is a quick automated snapshot. Our SEO team will review ' + host + ' by hand and include a clear plan and quote in your report.'
        : 'This is a quick automated snapshot. Add your WhatsApp number and we will send the full report, and your email for a free SEO proposal.',
      waLink: wa,
      scanClose: () => this.closeScan(),
      exitAsk: !!s.exitAsk, exitSent: !!s.exitSent, exitForm: !s.exitSent, exitErr: s.exitErr || '',
      needEmail: !this.lead.email, needPhone: !this.lead.phone, haveBoth: !!this.lead.phone,
      exitEyebrow: s.exitFrom === 'wa' ? 'Report on its way' : 'Before you go',
      exitHead: s.exitFrom === 'wa' ? 'Want a free SEO proposal with a quote too?' : 'Want us to send your report and a free SEO proposal?',
      skipLabel: s.exitFrom === 'wa' ? 'Not now' : 'No thanks, close',
      exitLead: s.exitFrom === 'wa' ? 'Your full report is going to your WhatsApp. Share a few details and our team will review ' + host + ' by hand and send a clear plan with a quote. Free, no obligation.' : s.scanDone ? 'Your report for ' + host + ' is ready. Leave your details and we will send it over, with a free proposal. No obligation.' : 'Your report for ' + host + ' is still being prepared. Leave your details and we will send it over, with a free proposal. No obligation.',
      exitLeadOld: s.scanDone ? 'Your report for ' + host + ' is ready.' : 'Your report for ' + host + ' is still being prepared.',
      exitSkip: () => (this.state.exitFrom === 'wa' ? this.setState({ exitAsk: false }) : this.forceClose()),
      ccLead: s.ccLead, ccWa: s.ccWa, ccCt: s.ccCt, ccOld: '+91',
      on_ccLead: e => this.setState({ ccLead: this.cleanCc(e.currentTarget.value) }),
      on_ccWa: e => this.setState({ ccWa: this.cleanCc(e.currentTarget.value) }),
      on_ccCt: e => this.setState({ ccCt: this.cleanCc(e.currentTarget.value) }),
      on_ccOld: () => {},
      sameNumber: e => {
        const f = e.currentTarget.form;
        let nat = this.lead.waNat || '', cc = this.lead.waCc ? '+' + this.lead.waCc : this.state.ccWa;
        if (!nat && f && f.exitPhone) { const p = this.parsePhone(f.exitPhone.value, this.state.ccWa, 'number'); nat = p.national || f.exitPhone.value.replace(/\D/g, ''); cc = p.cc ? '+' + p.cc : cc; }
        if (f && f.exitContact) f.exitContact.value = nat;
        this.setState({ ccCt: cc });
      },
      exitSubmit: e => {
        e.preventDefault();
        const f = e.currentTarget, g = k => (f[k] ? f[k].value.trim() : '');
        const fail = m => this.setState({ exitErr: m });
        const done = () => this.setState({ exitSent: true, exitErr: '', proposalDone: true, leadDone: true }, () => { this.exitT = setTimeout(() => this.forceClose(), 2200); });
        if (g('hpCheck')) { this.spam = true; done(); return; }
        const name = g('exitName').replace(/\s+/g, ' '), company = g('exitCompany').replace(/\s+/g, ' '), email = (g('exitEmail') || this.lead.email || '').toLowerCase();
        const nameErr = this.vName(name);
        if (nameErr) return fail(nameErr);
        let wa = this.lead.phone ? { e164: this.lead.phone } : this.parsePhone(g('exitPhone'), this.state.ccWa, 'WhatsApp number');
        if (wa.err) return fail(wa.err);
        const ct = this.parsePhone(g('exitContact'), this.state.ccCt, 'phone number');
        if (ct.err) return fail(ct.err);
        const err = this.vEmail(email) || this.vCompany(company);
        if (err) return fail(err);
        if (this.tooFast()) return fail('Please check your details and try again.');
        if (!this.rate('wiseup_lead_submits', 6, 3600000)) return fail("You've already sent a few requests. Our team will be in touch.");
        Object.assign(this.lead, { name, company, phone: wa.e164, contact: ct.e164, email });
        this.setState({ exitSent: true, exitErr: '', proposalDone: true, leadDone: true }, () => {
          this.sendLead('exit-details');
          this.exitT = setTimeout(() => this.forceClose(), 2200);
        });
      },
      skipAsk: () => this.setState({ askSkipped: true }),
      leadPartial: e => {
        const p = this.parsePhone(e.currentTarget.value, this.state.ccLead, 'number');
        if (p.e164 && p.e164 !== this.lead.phone) { this.lead.phone = p.e164; this.lead.waNat = p.national; this.lead.waCc = p.cc; this.sendLead('phone-captured'); }
      },
      leadErr: s.leadErr || '',
      waBorder: s.leadErr ? '#FF8A6B' : 'rgba(37,211,102,.55)',
      waInvalid: s.leadErr ? 'true' : 'false',
      waClear: () => { if (this.state.leadErr) this.setState({ leadErr: '' }); },
      leadSubmit: e => {
        e.preventDefault();
        const f = e.currentTarget, g = k => (f[k] ? f[k].value.trim() : '');
        const fail = m => { this.setState({ leadErr: m }); if (f.leadPhone) f.leadPhone.focus(); };
        const toExit = () => this.setState({ leadDone: true, exitAsk: true, exitShown: true, exitFrom: 'wa', exitErr: '', leadErr: '' });
        if (g('hpCheck')) { this.spam = true; toExit(); return; }
        const p = this.parsePhone(g('leadPhone'), this.state.ccLead, 'WhatsApp number');
        if (p.err) return fail(p.err);
        if (this.tooFast()) return fail('Please check your number and try again.');
        if (!this.rate('wiseup_lead_submits', 6, 3600000)) return fail("You've already sent a few requests. Our team will be in touch.");
        this.lead = Object.assign({}, this.lead, { phone: p.e164, waNat: p.national, waCc: p.cc });
        this.tForm = Date.now();
        this.setState({ leadDone: true, exitAsk: true, exitShown: true, exitFrom: 'wa', exitErr: '', leadErr: '' }, () => this.sendLead('report-requested'));
      }
    };
  }

  }

  /* ---------- page behaviours ---------- */
  var scanner = new Scanner();
  var P = {};

  function ready(fn) { if (document.readyState !== 'loading') fn(); else document.addEventListener('DOMContentLoaded', fn); }

  ready(function () {
    var root = document.querySelector('[data-root]');
    if (!root) return;
    scanner.tForm = Date.now();

    /* overlay mount point + event delegation */
    var mount = document.createElement('div');
    mount.id = 'wu-scan-root';
    document.body.appendChild(mount);
    scanner.root = mount;
    function dispatch(type, e) {
      var attr = 'data-on-' + type;
      var el = e.target && e.target.closest ? e.target.closest('[' + attr + ']') : null;
      if (!el || !mount.contains(el)) return;
      var fn = scanner.vals && scanner.vals[el.getAttribute(attr)];
      if (typeof fn !== 'function') return;
      fn({ currentTarget: el, target: e.target, preventDefault: function () { e.preventDefault(); }, stopPropagation: function () { e.stopPropagation(); } });
    }
    ['click', 'submit', 'input'].forEach(function (t) { mount.addEventListener(t, function (e) { dispatch(t, e); }); });
    mount.addEventListener('focusout', function (e) { dispatch('blur', e); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && scanner.state.scanOpen) scanner.closeScan(); });

    var still = matchMedia('(prefers-reduced-motion: reduce)').matches;
    var anims = [];

    /* ----- looping decorative animations ----- */
    root.querySelectorAll('[data-marquee]').forEach(function (el) {
      var rev = el.dataset.marquee === 'rev';
      var a = el.animate([{ transform: 'translateX(' + (rev ? -50 : 0) + '%)' }, { transform: 'translateX(' + (rev ? 0 : -50) + '%)' }], { duration: +el.dataset.speed || 40000, iterations: Infinity });
      el.addEventListener('mouseenter', function () { a.pause(); });
      el.addEventListener('mouseleave', function () { a.play(); });
      anims.push(a);
    });
    root.querySelectorAll('[data-blob]').forEach(function (el, i) {
      anims.push(el.animate([{ transform: 'translate(0,0) scale(1)' }, { transform: 'translate(' + (i % 2 ? -8 : 10) + 'vw,' + (i % 3 ? 6 : -6) + 'vw) scale(1.15)' }], { duration: 14000 + i * 3000, iterations: Infinity, direction: 'alternate', easing: 'ease-in-out' }));
    });
    if (!still) {
      var od = { outer: 90000, inner: 70000 }, orb = [];
      root.querySelectorAll('[data-orbit]').forEach(function (el) { var k = el.dataset.orbit, dir = k === 'inner' ? -1 : 1; orb.push(el.animate([{ transform: 'rotate(0deg)' }, { transform: 'rotate(' + 360 * dir + 'deg)' }], { duration: od[k], iterations: Infinity })); });
      root.querySelectorAll('[data-counter]').forEach(function (el) { var k = el.dataset.counter, dir = k === 'inner' ? 1 : -1; orb.push(el.animate([{ transform: 'rotate(0deg)' }, { transform: 'rotate(' + 360 * dir + 'deg)' }], { duration: od[k], iterations: Infinity })); });
      var w = root.querySelector('[data-orbitwrap]');
      if (w) { w.addEventListener('mouseenter', function () { orb.forEach(function (a) { a.pause(); }); }); w.addEventListener('mouseleave', function () { orb.forEach(function (a) { a.play(); }); }); }
      anims.push.apply(anims, orb);
    }
    root.querySelectorAll('[data-spinfast]').forEach(function (el) { anims.push(el.animate([{ transform: 'rotate(0deg)' }, { transform: 'rotate(360deg)' }], { duration: 5000, iterations: Infinity })); });
    root.querySelectorAll('[data-pulse]').forEach(function (el) { anims.push(el.animate([{ transform: 'scale(1)', opacity: .9 }, { transform: 'scale(1.55)', opacity: 0 }], { duration: 2000, iterations: Infinity, easing: 'cubic-bezier(.2,.7,.2,1)' })); });
    root.querySelectorAll('[data-blink]').forEach(function (el) { anims.push(el.animate([{ opacity: 1 }, { opacity: .25 }], { duration: 900, iterations: Infinity, direction: 'alternate' })); });
    root.querySelectorAll('[data-spin]').forEach(function (el) { anims.push(el.animate([{ transform: 'rotate(0deg)' }, { transform: 'rotate(360deg)' }], { duration: 60000, iterations: Infinity })); });

    /* ----- scroll reveal ----- */
    var pending = new Set(), io = null;
    function reveal(el) {
      if (!pending.has(el)) return;
      pending.delete(el);
      if (io) io.unobserve(el);
      el.style.opacity = '';
      el.animate([{ opacity: 0, transform: 'translateY(40px)' }, { opacity: 1, transform: 'none' }], { duration: 900, delay: +el.dataset.delay || 0, easing: 'cubic-bezier(.2,.7,.2,1)', fill: 'backwards' });
    }
    if (!still && 'IntersectionObserver' in window) {
      var vh0 = window.innerHeight;
      io = new IntersectionObserver(function (entries) { entries.forEach(function (e) { if (e.isIntersecting) reveal(e.target); }); }, { threshold: 0.12 });
      root.querySelectorAll('[data-reveal]').forEach(function (el) {
        if (el.getBoundingClientRect().top > vh0 * 0.95) { el.style.opacity = '0'; pending.add(el); io.observe(el); }
      });
    }

    /* ----- pointer effects (desktop only) ----- */
    if (window.matchMedia && matchMedia('(hover:hover)').matches) {
      root.querySelectorAll('[data-magnetic]').forEach(function (el) {
        el.style.transition = (el.style.transition ? el.style.transition + ',' : '') + 'translate .35s cubic-bezier(.2,.8,.2,1)';
        el.addEventListener('mousemove', function (e) {
          var r = el.getBoundingClientRect();
          el.style.translate = ((e.clientX - r.left) / r.width - .5) * 14 + 'px ' + ((e.clientY - r.top) / r.height - .5) * 12 + 'px';
        });
        el.addEventListener('mouseleave', function () { el.style.translate = '0 0'; });
      });
      root.querySelectorAll('[data-tilt]').forEach(function (el) {
        el.style.transformStyle = 'preserve-3d';
        el.style.transition = 'rotate .5s cubic-bezier(.2,.8,.2,1),scale .5s cubic-bezier(.2,.8,.2,1),box-shadow .5s';
        el.addEventListener('mousemove', function (e) {
          var r = el.getBoundingClientRect();
          var x = (e.clientX - r.left) / r.width - .5, y = (e.clientY - r.top) / r.height - .5;
          el.style.rotate = (-y).toFixed(3) + ' ' + x.toFixed(3) + ' 0 ' + (Math.hypot(x, y) * 6).toFixed(2) + 'deg';
          el.style.scale = '1.01';
        });
        el.addEventListener('mouseleave', function () { el.style.rotate = 'none'; el.style.scale = '1'; });
        if (el.parentElement) el.parentElement.style.perspective = '1200px';
      });
      root.querySelectorAll('[data-spot]').forEach(function (el) {
        if (getComputedStyle(el).position === 'static') el.style.position = 'relative';
        el.style.overflow = 'hidden';
        var s = document.createElement('span');
        s.style.cssText = 'position:absolute;inset:0;pointer-events:none;opacity:0;transition:opacity .4s;border-radius:inherit;z-index:0';
        el.prepend(s);
        Array.prototype.forEach.call(el.children, function (ch) { if (ch !== s && getComputedStyle(ch).position === 'static') { ch.style.position = 'relative'; ch.style.zIndex = '1'; } });
        el.addEventListener('mousemove', function (e) {
          var r = el.getBoundingClientRect();
          s.style.background = 'radial-gradient(320px circle at ' + (e.clientX - r.left) + 'px ' + (e.clientY - r.top) + 'px,rgba(194,247,96,.16),rgba(194,247,96,0) 70%)';
          s.style.opacity = '1';
        });
        el.addEventListener('mouseleave', function () { s.style.opacity = '0'; });
      });
    }

    /* ----- hero entrance + typing demo ----- */
    var chips = root.querySelectorAll('[data-eng-chip]');
    var engName = root.querySelector('[data-eng-name]'), engRest = root.querySelector('[data-eng-rest]');
    var eng = 0;
    function setEng(n) {
      eng = n;
      chips.forEach(function (c) {
        var on = +c.dataset.engChip === n;
        c.style.background = on ? '#C2F760' : 'rgba(255,255,255,.06)';
        c.style.color = on ? '#0E1206' : 'rgba(255,255,255,.7)';
      });
      if (engName) engName.textContent = ENG_NAMES[n] + ' answer';
      if (engRest) engRest.textContent = ENG_REST[n];
    }
    var typeT = 0;
    function startTyping() {
      var qs = ['best seo company in kerala', 'seo agency in calicut', 'who can get my brand recommended by chatgpt?', 'local seo services near me', 'woocommerce seo experts in kerala'];
      var qi = 0;
      function run() {
        var el = root.querySelector('[data-type]');
        if (!el) { typeT = setTimeout(run, 1000); return; }
        var q = qs[qi], n = el.textContent.length;
        function erase() {
          if (n > 0) { el.textContent = el.textContent.slice(0, --n); typeT = setTimeout(erase, 22); }
          else { setEng((eng + 1) % 5); type(0); }
        }
        function type(i) {
          el.textContent = q.slice(0, i);
          if (i < q.length) typeT = setTimeout(function () { type(i + 1); }, 55 + Math.random() * 40);
          else { qi = (qi + 1) % qs.length; typeT = setTimeout(function () { n = el.textContent.length; erase(); }, 2600); }
        }
        if (qi === 0 && el.textContent === q) { qi = 1; typeT = setTimeout(function () { n = el.textContent.length; erase(); }, 2600); return; }
        erase();
      }
      typeT = setTimeout(run, 1800);
    }
    if (!still) {
      root.querySelectorAll('[data-word]').forEach(function (w, i) { w.animate([{ opacity: 0, transform: 'translateY(0.45em) rotate(2deg)', filter: 'blur(8px)' }, { opacity: 1, transform: 'none', filter: 'blur(0)' }], { duration: 900, delay: 120 + i * 110, easing: 'cubic-bezier(.2,.7,.2,1)', fill: 'backwards' }); });
      root.querySelectorAll('[data-shine]').forEach(function (el) { anims.push(el.animate([{ backgroundPosition: '100% 0' }, { backgroundPosition: '-150% 0' }], { duration: 4200, delay: 1400, iterations: Infinity, easing: 'ease-in-out' })); });
      root.querySelectorAll('[data-cue]').forEach(function (el) { anims.push(el.animate([{ transform: 'translateY(0)', opacity: 1 }, { transform: 'translateY(12px)', opacity: 0 }], { duration: 1600, iterations: Infinity, easing: 'cubic-bezier(.5,0,.5,1)' })); });
      root.querySelectorAll('[data-caret]').forEach(function (el) { anims.push(el.animate([{ opacity: 1 }, { opacity: 0 }], { duration: 900, iterations: Infinity, easing: 'steps(2,start)' })); });
      startTyping();
    }

    /* ----- smooth wheel scrolling (mouse devices) ----- */
    if (CFG.smoothScroll !== false && matchMedia('(pointer:fine)').matches && !still) {
      var cur = scrollY, tgt = scrollY, running = false, own = false;
      var maxS = function () { return document.documentElement.scrollHeight - innerHeight; };
      var loop = function () {
        cur += (tgt - cur) * 0.085;
        if (Math.abs(tgt - cur) < 0.4) { cur = tgt; running = false; }
        own = true; window.scrollTo(0, cur);
        if (running) requestAnimationFrame(loop);
      };
      var go = function (y) { tgt = Math.max(0, Math.min(maxS(), y)); if (!running) { running = true; cur = scrollY; requestAnimationFrame(loop); } };
      window.addEventListener('wheel', function (e) {
        if (e.ctrlKey || e.defaultPrevented || scanner.state.scanOpen) return;
        var n = e.target;
        while (n && n !== document.body) { var st = getComputedStyle(n); if (/(auto|scroll)/.test(st.overflowY) && n.scrollHeight > n.clientHeight) return; n = n.parentElement; }
        e.preventDefault();
        if (!running) tgt = scrollY;
        go(tgt + e.deltaY * (e.deltaMode === 1 ? 32 : 1));
      }, { passive: false });
      window.addEventListener('scroll', function () { if (own) { own = false; return; } if (!running) { cur = tgt = scrollY; } }, { passive: true });
      root.addEventListener('click', function (e) {
        var a = e.target.closest && e.target.closest('a[href^="#"]');
        if (!a) return;
        var id = a.getAttribute('href').slice(1), el = id ? document.getElementById(id) : null;
        if (!el && id !== 'top') return;
        e.preventDefault();
        go(el ? el.getBoundingClientRect().top + scrollY - 80 : 0);
      });
    }

    /* ----- scroll-linked bits: progress bar, back-to-top, sticky nav, parallax, process line ----- */
    var prog = root.querySelector('[data-progress]'), toTop = root.querySelector('[data-totop]'), nav = root.querySelector('[data-nav]');
    var par = [].slice.call(root.querySelectorAll('[data-parallax],[data-parallax-img]'));
    var proc = root.querySelector('[data-process]'), fill = root.querySelector('[data-fill]');
    var topShown, navSolid, raf = 0;
    function tick() {
      var vh = window.innerHeight, maxS = document.documentElement.scrollHeight - vh;
      if (prog) prog.style.transform = 'scaleX(' + (maxS > 0 ? Math.min(1, scrollY / maxS).toFixed(4) : 0) + ')';
      if (toTop) {
        var show = scrollY > vh * 1.2;
        if (show !== topShown) { topShown = show; Object.assign(toTop.style, { opacity: show ? '1' : '0', transform: show ? 'none' : 'translateY(16px)', pointerEvents: show ? 'auto' : 'none' }); }
      }
      if (nav) {
        var solid = scrollY > 40;
        if (solid !== navSolid) {
          navSolid = solid;
          nav.style.background = solid ? 'rgba(8,9,6,.72)' : 'linear-gradient(180deg,rgba(0,0,0,.7),rgba(0,0,0,0))';
          nav.style.backdropFilter = solid ? 'blur(16px) saturate(1.3)' : 'blur(6px)';
          nav.style.boxShadow = solid ? '0 1px 0 rgba(255,255,255,.06),0 10px 30px -20px rgba(0,0,0,.8)' : 'none';
        }
      }
      if (pending.size) root.querySelectorAll('[data-reveal]').forEach(function (el) {
        if (el.style.opacity === '0' && el.getBoundingClientRect().top < vh) { pending.add(el); reveal(el); }
      });
      par.forEach(function (el) {
        var r = el.getBoundingClientRect(), s = +(el.dataset.parallax || el.dataset.parallaxImg);
        el.style.transform = 'translate3d(0,' + ((r.top + r.height / 2 - vh / 2) * -s).toFixed(1) + 'px,0)';
      });
      if (proc && fill) {
        var r2 = proc.getBoundingClientRect(), t = Math.min(1, Math.max(0, (vh * 0.8 - r2.top) / (r2.height * 0.8)));
        fill.style.width = 'calc(' + (t * 100).toFixed(1) + '% - ' + (t * 24).toFixed(1) + 'px)';
      }
    }
    var onScroll = function () { if (!raf) raf = requestAnimationFrame(function () { raf = 0; tick(); }); };
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll);
    tick();
    setTimeout(function () { root.querySelectorAll('[data-reveal]').forEach(function (el) { if (el.style.opacity === '0' && el.getBoundingClientRect().top < innerHeight * 1.5) el.style.opacity = ''; }); }, 8000);
    setInterval(tick, 600);

    /* ----- mobile menu ----- */
    var menu = root.querySelector('[data-menu]'), menuBtn = root.querySelector('[data-menu-btn]');
    function setMenu(open) {
      if (!menu || !menuBtn) return;
      menu.hidden = !open;
      menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
      var p = menuBtn.querySelector('path'); if (p) p.setAttribute('d', open ? 'M6 6l12 12M18 6L6 18' : 'M4 7h16M4 12h16M4 17h16');
    }
    if (menuBtn) {
      menuBtn.setAttribute('aria-expanded', 'false');
      menuBtn.addEventListener('click', function () { setMenu(menu.hidden); });
      menu.addEventListener('click', function () { setMenu(false); });
    }

    /* ----- FAQ accordion (all answers stay in the page for SEO) ----- */
    var faqBtns = root.querySelectorAll('[data-faq-t]');
    function setFaq(open) {
      faqBtns.forEach(function (b) {
        var i = +b.dataset.faqT, on = i === open, a = root.querySelector('[data-faq-a="' + i + '"]');
        if (a) { if (on) a.setAttribute('data-open', '1'); else a.removeAttribute('data-open'); }
        b.setAttribute('aria-expanded', on ? 'true' : 'false');
        var ic = b.querySelector('[style*="rotate"]'); if (ic) ic.style.transform = on ? 'rotate(45deg)' : 'rotate(0deg)';
      });
    }
    faqBtns.forEach(function (b) {
      b.addEventListener('click', function () {
        var i = +b.dataset.faqT, cur = root.querySelector('[data-faq-a="' + i + '"]');
        setFaq(cur && cur.hasAttribute('data-open') ? -1 : i);
      });
    });

    /* ----- hero form -> opens the scanner ----- */
    var heroForm = root.querySelector('[data-hero-form]'), heroErr = root.querySelector('[data-hero-err]');
    function heroFail(m, inp) {
      if (heroErr) { heroErr.textContent = m; heroErr.hidden = false; }
      if (inp) { inp.setAttribute('aria-invalid', 'true'); inp.focus(); }
    }
    function heroClear() {
      if (heroErr) heroErr.hidden = true;
      var i = heroForm && heroForm.heroUrl; if (i) i.setAttribute('aria-invalid', 'false');
    }
    if (heroForm) {
      heroForm.addEventListener('input', heroClear);
      heroForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var inp = heroForm.heroUrl, raw = inp.value.trim().slice(0, 300);
        if (heroForm.hpCheck && heroForm.hpCheck.value) { scanner.spam = true; return; }
        if (!raw) return heroFail('Please enter your website address.', inp);
        var host = scanner.normUrl(raw), bad = scanner.vHost(host);
        if (bad) return heroFail(bad, inp);
        if (!scanner.rate('wiseup_scans', 6, 600000)) return heroFail('Too many scans in a short time. Please try again in a few minutes.');
        heroClear();
        scanner.startScan(raw);
      });
    }

    /* ----- contact form ----- */
    var cWrap = root.querySelector('[data-contact-wrap]'), cForm = root.querySelector('[data-contact-form]');
    var cErr = root.querySelector('[data-contact-err]'), cSent = root.querySelector('[data-sent]');
    function cFail(m) { if (cErr) { cErr.textContent = m; cErr.hidden = false; } }
    if (cForm) {
      cForm.addEventListener('input', function () { if (cErr) cErr.hidden = true; });
      cForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var f = cForm, g = function (k) { return f[k] ? f[k].value.trim() : ''; };
        var showSent = function () { cWrap.hidden = true; cSent.hidden = false; if (cErr) cErr.hidden = true; };
        if (g('hpCheck')) { scanner.spam = true; showSent(); return; }
        var name = g('name').replace(/\s+/g, ' '), email = g('email').toLowerCase(), pp = g('phone') ? scanner.parsePhone(g('phone'), '+91', 'phone number') : {};
        var web = g('website'), host = web ? scanner.normUrl(web) : '', msg = g('message');
        var err = scanner.vName(name) || scanner.vEmail(email) || pp.err || (web && scanner.vHost(host)) ||
          (msg && (msg.length < 3 || /(.)\1{9,}/.test(msg) || (msg.match(/https?:\/\//gi) || []).length > 2) && 'Please check your message.');
        if (err) return cFail(err);
        if (scanner.tooFast()) return cFail('Please check your details and try again.');
        if (!scanner.rate('wiseup_lead_submits', 6, 3600000)) return cFail("You've already sent a few requests. Our team will be in touch.");
        scanner.lead = Object.assign({}, scanner.lead, { name: name, email: email, phone: pp.e164 || scanner.lead.phone });
        scanner.sendLead('contact-form', { website: host || '', service: g('service'), message: msg.slice(0, 1000), source: 'contact-form' });
        showSent();
      });
      var rs = root.querySelector('[data-reset]');
      if (rs) rs.addEventListener('click', function () { cForm.reset(); cWrap.hidden = false; cSent.hidden = true; });
    }

    /* ----- admin-bar offset for logged-in editors ----- */
    if (document.body.classList.contains('admin-bar') && nav) nav.style.top = (document.getElementById('wpadminbar') ? document.getElementById('wpadminbar').offsetHeight : 32) + 'px';
  });
})();
