/*
 * Event Branding page: the Kerala map beside "Cities We Work In".
 * A tilted 3D dot map of Kerala drawn with WebGL (2D canvas fallback): dots rise toward the Western Ghats, a light ring
 * ripples out of the Kozhikode studio, arcs of light run from the studio to each city, every city has a light beacon.
 * The active city cycles north to south; hovering a city in the list (or on the map) lights it up. The camera leans
 * toward the pointer. Paused off screen; one still frame under reduced motion.
 */
(function () {
	var box = document.querySelector('[data-ev-map]');
	if (!box) return;
	var glc = box.querySelector('.ev-map__gl'), ovc = box.querySelector('.ev-map__ov');
	var list = [].slice.call(document.querySelectorAll('[data-ev-city]'));
	var still = matchMedia('(prefers-reduced-motion: reduce)').matches;

	// ---- geography (approximate outline, lon/lat) ----
	var COAST = [[74.86,12.78],[74.98,12.5],[75.12,12.2],[75.37,11.87],[75.55,11.6],[75.68,11.45],[75.77,11.25],[75.86,11.0],[75.95,10.8],[76.05,10.55],[76.12,10.3],[76.2,10.1],[76.25,9.97],[76.3,9.7],[76.33,9.5],[76.4,9.3],[76.47,9.1],[76.57,8.88],[76.75,8.7],[76.92,8.5],[77.0,8.38],[77.07,8.29]];
	var EAST = [[77.17,8.33],[77.2,8.5],[77.18,8.75],[77.22,9.0],[77.3,9.3],[77.2,9.55],[77.25,9.75],[77.3,10.0],[77.22,10.2],[77.0,10.35],[76.95,10.6],[76.85,10.75],[76.95,10.85],[76.9,11.05],[76.75,11.25],[76.55,11.3],[76.6,11.45],[76.45,11.6],[76.45,11.75],[76.2,11.95],[76.0,11.95],[75.85,12.1],[75.6,12.3],[75.4,12.5],[75.15,12.78]];
	var POLY = COAST.concat(EAST);
	var CITIES = [
		{ n: 'Kannur', p: [75.37, 11.87], w: 1 },
		{ n: 'Kozhikode', p: [75.79, 11.25], home: true, w: 1 },
		{ n: 'Malappuram', p: [76.07, 11.05] },
		{ n: 'Thrissur', p: [76.21, 10.52], w: 1 },
		{ n: 'Kochi', p: [76.29, 9.95], w: 1 },
		{ n: 'Thiruvananthapuram', p: [76.95, 8.52], w: 1 },
	];
	var C0 = 76.05, C1 = 10.55, KX = 0.983;
	function local(ll) { return [(ll[0] - C0) * KX, ll[1] - C1]; }
	function inside(x, y) {
		var c = false;
		for (var i = 0, j = POLY.length - 1; i < POLY.length; j = i++) {
			var xi = POLY[i][0], yi = POLY[i][1], xj = POLY[j][0], yj = POLY[j][1];
			if ((yi > y) !== (yj > y) && x < (xj - xi) * (y - yi) / (yj - yi) + xi) c = !c;
		}
		return c;
	}
	function lonAt(line, lat) { // line runs north -> south (COAST) or south -> north (EAST)
		for (var i = 0; i < line.length - 1; i++) {
			var a = line[i], b = line[i + 1], lo = Math.min(a[1], b[1]), hi = Math.max(a[1], b[1]);
			if (lat >= lo && lat <= hi) return a[0] + (b[0] - a[0]) * ((lat - a[1]) / ((b[1] - a[1]) || 1e-6));
		}
		return lat > 12 ? line[0][0] : line[line.length - 1][0];
	}
	// dots: Kerala (bright, elevation rising to the Ghats) + neighbouring land (dim, low)
	var pts = [];
	var STEP = 0.034;
	for (var lat = 8.1; lat <= 12.95; lat += STEP) {
		var row = Math.round((lat - 8.1) / STEP), coast = lonAt(COAST, Math.min(12.78, Math.max(8.29, lat)));
		for (var lon = 74.7 + (row % 2) * STEP / 2; lon <= 77.75; lon += STEP) {
			if (lon < coast - 0.01) continue; // sea
			var inK = inside(lon, lat);
			var east = lonAt(EAST, Math.min(12.78, Math.max(8.33, lat)));
			var e = inK ? Math.pow(Math.max(0, Math.min(1, (lon - coast) / Math.max(0.15, east - coast))), 1.6) : 0.12;
			if (!inK && Math.random() < 0.35) continue;
			var l = local([lon, lat]);
			pts.push(l[0], l[1], inK ? 1 : 0, e, Math.random());
		}
	}
	var N = pts.length / 5;
	CITIES.forEach(function (c, i) { c.l = local(c.p); c.i = i; });
	var home = CITIES[1].l;

	// ---- camera ----
	var Y0 = -0.06, T0 = 0.74;
	var cam = { yaw: Y0, tilt: T0, D: 9 }, aim = { yaw: Y0, tilt: T0 };
	var W = 0, H = 0, dpr = 1, S = 1, OX = 0, OY = 0;
	function proj(x, y, z) {
		var cy = Math.cos(cam.yaw), sy = Math.sin(cam.yaw), ct = Math.cos(cam.tilt), st = Math.sin(cam.tilt);
		var x1 = x * cy - y * sy, y1 = x * sy + y * cy;
		var y2 = y1 * ct + z * st, d = y1 * st - z * ct, s = cam.D / (cam.D + d);
		return [x1 * s * S + OX, -y2 * s * S + OY, s];
	}
	function fit() {
		var r = box.getBoundingClientRect();
		dpr = Math.min(2, window.devicePixelRatio || 1);
		W = Math.max(1, Math.round(r.width * dpr)); H = Math.max(1, Math.round(r.height * dpr));
		[glc, ovc].forEach(function (c) { c.width = W; c.height = H; });
		var save = { yaw: cam.yaw, tilt: cam.tilt }; cam.yaw = Y0; cam.tilt = T0; S = 1; OX = 0; OY = 0;
		var mnx = 1e9, mxx = -1e9, mny = 1e9, mxy = -1e9;
		POLY.forEach(function (ll) { var l = local(ll), q = proj(l[0], l[1], 0); mnx = Math.min(mnx, q[0]); mxx = Math.max(mxx, q[0]); mny = Math.min(mny, q[1]); mxy = Math.max(mxy, q[1]); });
		S = Math.min(W * 0.86 / (mxx - mnx), H * 0.86 / (mxy - mny));
		OX = W / 2 - (mnx + mxx) / 2 * S; OY = H / 2 - (mny + mxy) / 2 * S + H * 0.02;
		cam.yaw = save.yaw; cam.tilt = save.tilt;
	}

	// ---- WebGL dots ----
	var gl = null, prog, U = {};
	try { gl = glc.getContext('webgl', { alpha: true, antialias: true, premultipliedAlpha: false }); } catch (e) { gl = null; }
	if (gl) {
		var vs = [
			'attribute vec2 p; attribute float k; attribute float e; attribute float r;',
			'uniform float t, yaw, tilt, D, S, at; uniform vec2 off, res, home, act; uniform float dpr;',
			'varying float va; varying vec3 vc;',
			'void main(){',
			' float dh = distance(p, home); float ring = mod(t * .55, 3.2);',
			' float w = exp(-pow((dh - ring) * 7., 2.)) * (1. - ring / 3.2) * k;',
			' float da = distance(p, act); float ra = at * 1.4;',
			' float wa = exp(-pow((da - ra) * 9., 2.)) * max(0., 1. - at / 1.6) * k;',
			' float glow = exp(-da * da * 60.) * k;',
			' float z = e * .2 * k + .015 + w * .09 + wa * .07 + .012 * sin(t * 1.4 + r * 6.283) * k;',
			' float cy = cos(yaw), sy = sin(yaw), ct = cos(tilt), st = sin(tilt);',
			' float x1 = p.x * cy - p.y * sy, y1 = p.x * sy + p.y * cy;',
			' float y2 = y1 * ct + z * st, d = y1 * st - z * ct, s = D / (D + d);',
			' vec2 q = vec2(x1 * s * S + off.x, -y2 * s * S + off.y);',
			' gl_Position = vec4(q.x / res.x * 2. - 1., 1. - q.y / res.y * 2., 0., 1.);',
			' gl_PointSize = (k > .5 ? 2.6 + e * 1.4 : 1.8) * dpr * s;',
			' vec3 lo = vec3(.12, .5, .4), hi = vec3(.76, .97, .38);',
			' vc = k > .5 ? mix(lo, hi, e * .8 + .2) : vec3(.55, .58, .6);',
			' vc = mix(vc, vec3(.9, 1., .7), clamp(w * 1.2 + wa + glow * .6, 0., 1.));',
			' va = k > .5 ? (.45 + e * .35 + .12 * sin(t * 1.1 + r * 9.) + w * .9 + wa + glow * .5) : .13;',
			'}'].join('\n');
		var fs = 'precision mediump float; varying float va; varying vec3 vc; void main(){ float d = length(gl_PointCoord - .5); float a = smoothstep(.5, .15, d) * va; if (a < .01) discard; gl_FragColor = vec4(vc, a); }';
		var sh = function (type, src) { var s = gl.createShader(type); gl.shaderSource(s, src); gl.compileShader(s); return s; };
		prog = gl.createProgram();
		gl.attachShader(prog, sh(gl.VERTEX_SHADER, vs)); gl.attachShader(prog, sh(gl.FRAGMENT_SHADER, fs)); gl.linkProgram(prog);
		if (!gl.getProgramParameter(prog, gl.LINK_STATUS)) gl = null;
	}
	if (gl) {
		gl.useProgram(prog);
		var buf = gl.createBuffer(); gl.bindBuffer(gl.ARRAY_BUFFER, buf); gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(pts), gl.STATIC_DRAW);
		[['p', 2, 0], ['k', 1, 2], ['e', 1, 3], ['r', 1, 4]].forEach(function (a) { var loc = gl.getAttribLocation(prog, a[0]); gl.enableVertexAttribArray(loc); gl.vertexAttribPointer(loc, a[1], gl.FLOAT, false, 20, a[2] * 4); });
		['t', 'yaw', 'tilt', 'D', 'S', 'at', 'off', 'res', 'home', 'act', 'dpr'].forEach(function (n) { U[n] = gl.getUniformLocation(prog, n); });
		gl.enable(gl.BLEND); gl.blendFunc(gl.SRC_ALPHA, gl.ONE);
	} else { glc.style.display = 'none'; }
	var ctx = ovc.getContext('2d');

	// ---- state ----
	var active = 1, actAt = 0, hold = false, t0 = performance.now(), last = 0, T = 0;
	function setActive(i, byUser) {
		if (i === active && !byUser) return;
		if (i !== active) { active = i; actAt = T; }
		list.forEach(function (li, j) { li.classList.toggle('is-on', j === active); });
	}
	setActive(1, true);

	function draw2dDots(z0) {
		for (var i = 0; i < N; i++) {
			var k = pts[i * 5 + 2]; if (k < .5) continue;
			var e = pts[i * 5 + 3], q = proj(pts[i * 5], pts[i * 5 + 1], e * .2 + .015);
			ctx.fillStyle = 'rgba(' + Math.round(40 + 150 * e) + ',' + Math.round(140 + 105 * e) + ',' + Math.round(100 - 10 * e) + ',' + (.45 + e * .35) + ')';
			ctx.fillRect(q[0] - 1.2 * dpr, q[1] - 1.2 * dpr, 2.4 * dpr, 2.4 * dpr);
		}
	}
	function frame(now) {
		T = still ? 2.2 : Math.max(0, (now - t0) / 1000);
		var dt = Math.min(.05, (now - (last || now)) / 1000); last = now;
		cam.yaw += (aim.yaw - cam.yaw) * Math.min(1, dt * 4 || 1);
		cam.tilt += (aim.tilt - cam.tilt) * Math.min(1, dt * 4 || 1);
		if (!still && !hold && T - actAt > 2.6) setActive((active + 1) % CITIES.length);
		var age = T - actAt, A = CITIES[active];
		if (gl) {
			gl.viewport(0, 0, W, H); gl.clearColor(0, 0, 0, 0); gl.clear(gl.COLOR_BUFFER_BIT);
			gl.uniform1f(U.t, T); gl.uniform1f(U.yaw, cam.yaw); gl.uniform1f(U.tilt, cam.tilt); gl.uniform1f(U.D, cam.D); gl.uniform1f(U.S, S);
			gl.uniform1f(U.at, still ? 9 : age); gl.uniform2f(U.off, OX, OY); gl.uniform2f(U.res, W, H); gl.uniform2f(U.home, home[0], home[1]);
			gl.uniform2f(U.act, A.l[0], A.l[1]); gl.uniform1f(U.dpr, dpr);
			gl.drawArrays(gl.POINTS, 0, N);
		}
		ctx.clearRect(0, 0, W, H);
		if (!gl) draw2dDots();
		ctx.lineCap = 'round';
		// arcs of light from the studio
		CITIES.forEach(function (c, i) {
			if (c.home) return;
			var on = i === active, pth = [];
			var dx = c.l[0] - home[0], dy = c.l[1] - home[1], len = Math.sqrt(dx * dx + dy * dy), h = .12 + len * .3;
			for (var s = 0; s <= 28; s++) { var u = s / 28; pth.push(proj(home[0] + dx * u, home[1] + dy * u, .05 + Math.sin(Math.PI * u) * h)); }
			ctx.beginPath(); pth.forEach(function (q, s) { if (s) ctx.lineTo(q[0], q[1]); else ctx.moveTo(q[0], q[1]); });
			ctx.strokeStyle = on ? 'rgba(194,247,96,.75)' : 'rgba(194,247,96,.22)'; ctx.lineWidth = (on ? 1.8 : 1) * dpr; ctx.stroke();
			var u = still ? .6 : ((T * .35 + i * .19) % 1), q = pth[Math.round(u * 28)];
			var g = ctx.createRadialGradient(q[0], q[1], 0, q[0], q[1], 9 * dpr);
			g.addColorStop(0, 'rgba(235,255,190,' + (on ? .95 : .55) + ')'); g.addColorStop(1, 'rgba(194,247,96,0)');
			ctx.fillStyle = g; ctx.beginPath(); ctx.arc(q[0], q[1], 9 * dpr, 0, 6.283); ctx.fill();
		});
		// beacons, ground rings, labels (far ones first)
		CITIES.slice().sort(function (a, b) { return b.l[1] - a.l[1]; }).forEach(function (c) {
			var on = c.i === active, top = c.home ? .3 : (on ? .26 : .15);
			var g0 = proj(c.l[0], c.l[1], .03), g1 = proj(c.l[0], c.l[1], top);
			// ground ring
			for (var k = 0; k < 2; k++) {
				var ph = still ? .4 : ((T * .6 + k * .5 + c.i * .13) % 1), rr = (.05 + ph * .2) * S * g0[2];
				ctx.beginPath(); ctx.ellipse(g0[0], g0[1], rr, rr * Math.cos(cam.tilt), 0, 0, 6.283);
				ctx.strokeStyle = 'rgba(194,247,96,' + ((1 - ph) * (on || c.home ? .7 : .3)) + ')'; ctx.lineWidth = 1.2 * dpr; ctx.stroke();
			}
			// beam
			var lg = ctx.createLinearGradient(g0[0], g0[1], g1[0], g1[1]);
			lg.addColorStop(0, 'rgba(194,247,96,' + (on ? .9 : .55) + ')'); lg.addColorStop(1, 'rgba(194,247,96,0)');
			ctx.strokeStyle = lg; ctx.lineWidth = (on || c.home ? 2.4 : 1.6) * dpr;
			ctx.beginPath(); ctx.moveTo(g0[0], g0[1]); ctx.lineTo(g1[0], g1[1]); ctx.stroke();
			// node
			var rd = (c.home ? 7 : on ? 6 : 4) * dpr, hg = ctx.createRadialGradient(g0[0], g0[1], 0, g0[0], g0[1], rd * 3.2);
			hg.addColorStop(0, 'rgba(194,247,96,.55)'); hg.addColorStop(1, 'rgba(194,247,96,0)');
			ctx.fillStyle = hg; ctx.beginPath(); ctx.arc(g0[0], g0[1], rd * 3.2, 0, 6.283); ctx.fill();
			ctx.fillStyle = c.home || on ? '#c2f760' : '#0b0b0d'; ctx.beginPath(); ctx.arc(g0[0], g0[1], rd, 0, 6.283); ctx.fill();
			ctx.strokeStyle = '#c2f760'; ctx.lineWidth = 2 * dpr; ctx.stroke();
			c.sx = g0[0] / dpr; c.sy = g0[1] / dpr;
			// label
			var fs = (on || c.home ? 13 : 11.5) * dpr, txt = c.home && W / dpr > 520 ? c.n + '  ·  Our studio' : c.n;
			ctx.font = (on || c.home ? '600 ' : '500 ') + fs + 'px Inter, system-ui, sans-serif';
			var tw = ctx.measureText(txt).width, py = g0[1], ph2 = fs * 1.9, px = c.w ? g0[0] - rd - tw - 32 * dpr : g0[0] + rd + 12 * dpr;
			if (px < 8 * dpr) px = g0[0] + rd + 12 * dpr; else if (px + tw + 22 * dpr > W) px = g0[0] - rd - tw - 32 * dpr;
			if (on || c.home) {
				ctx.fillStyle = on ? 'rgba(194,247,96,.95)' : 'rgba(17,17,19,.85)';
				ctx.beginPath(); ctx.roundRect ? ctx.roundRect(px, py - ph2 / 2, tw + 20 * dpr, ph2, ph2 / 2) : ctx.rect(px, py - ph2 / 2, tw + 20 * dpr, ph2); ctx.fill();
				if (!on) { ctx.strokeStyle = 'rgba(194,247,96,.45)'; ctx.lineWidth = 1 * dpr; ctx.stroke(); }
				ctx.fillStyle = on ? '#11150a' : '#fff';
			} else ctx.fillStyle = 'rgba(255,255,255,.62)';
			ctx.textBaseline = 'middle'; ctx.fillText(txt, px + 10 * dpr, py + .5 * dpr);
		});
	}

	// ---- loop, visibility, input ----
	var raf = 0, vis = false;
	function loop(now) { frame(now); raf = vis && !still ? requestAnimationFrame(loop) : 0; }
	function kick() { if (!raf) raf = requestAnimationFrame(loop); }
	fit();
	new ResizeObserver(function () { fit(); kick(); }).observe(box);
	new IntersectionObserver(function (es) { vis = es[0].isIntersecting; if (vis) { last = 0; kick(); } }, { rootMargin: '120px' }).observe(box);
	box.addEventListener('pointermove', function (e) {
		var r = box.getBoundingClientRect(), x = (e.clientX - r.left) / r.width - .5, y = (e.clientY - r.top) / r.height - .5;
		aim.yaw = Y0 + x * .2; aim.tilt = T0 - y * .14;
		var best = -1, bd = 34 * 34;
		CITIES.forEach(function (c, i) { var dx = c.sx - (e.clientX - r.left), dy = c.sy - (e.clientY - r.top), d = dx * dx + dy * dy; if (d < bd) { bd = d; best = i; } });
		if (best >= 0) { hold = true; setActive(best, true); } else hold = false;
		kick();
	});
	box.addEventListener('pointerleave', function () { aim.yaw = Y0; aim.tilt = T0; hold = false; actAt = T; kick(); });
	list.forEach(function (li, i) {
		var on = function () { hold = true; setActive(i, true); kick(); }, off = function () { hold = false; actAt = T; };
		li.addEventListener('pointerenter', on); li.addEventListener('pointerleave', off);
		li.addEventListener('focusin', on); li.addEventListener('focusout', off);
	});
	if (document.fonts && document.fonts.ready) document.fonts.ready.then(kick);
})();
