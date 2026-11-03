/* Footer "wiseup" particle wordmark, plain-JS port of the site's footer-wordmark.ts (no GSAP) for the landing pages. */
(function () {
	var WORD = 'wiseup', TAU = Math.PI * 2, SHADES = 10;
	var wrap = document.querySelector('[data-ft-word]');
	if (!wrap) return;
	var canvas = wrap.querySelector('canvas'), text = wrap.querySelector('.ft__word-text');
	if (!canvas || !text) return;
	var ctx = canvas.getContext('2d');
	var reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
	var DPR = Math.min(window.devicePixelRatio || 1, 2);
	var particles = [], buckets = [], colors = [], cw = 0, ch = 0, radius = 100, dirty = true, alive = true;
	var palette = function () {
		var a = [];
		for (var k = 0; k < SHADES; k++) { var f = k / (SHADES - 1); a.push('hsl(' + (73 + f * 52).toFixed(0) + ' ' + (58 + ((k * 37) % 30)) + '% ' + (42 + ((k * 29) % 30)) + '%)'); }
		return a;
	};
	function build(intro) {
		var cs = getComputedStyle(text), size = parseFloat(cs.fontSize);
		var font = cs.fontWeight + ' ' + size + 'px ' + cs.fontFamily;
		var probe = document.createElement('canvas').getContext('2d');
		probe.font = font;
		var m = probe.measureText(WORD);
		var base = Math.ceil(m.actualBoundingBoxAscent + size * 0.04);
		wrap.style.height = base + 'px';
		cw = Math.max(1, Math.round(wrap.clientWidth));
		ch = base + Math.ceil(m.actualBoundingBoxDescent) + 4;
		canvas.style.height = ch + 'px';
		canvas.width = cw * DPR; canvas.height = ch * DPR;
		var mobile = cw < 768, gap = mobile ? 4 : 5;
		radius = mobile ? 50 : 110;
		var off = document.createElement('canvas'); off.width = cw; off.height = ch;
		var o = off.getContext('2d', { willReadFrequently: true });
		o.font = font;
		if ('letterSpacing' in o) o.letterSpacing = cs.letterSpacing;
		o.fillStyle = '#fff'; o.textAlign = 'center'; o.textBaseline = 'alphabetic';
		o.fillText(WORD, cw / 2, base - 2);
		var px = o.getImageData(0, 0, cw, ch).data;
		buckets = []; for (var i = 0; i < SHADES; i++) buckets.push([]);
		particles = [];
		for (var y = 0; y < ch; y += gap) for (var x = 0; x < cw; x += gap) {
			if (px[(y * cw + x) * 4 + 3] < 128) continue;
			var p = { bx: x, by: y, x: intro ? Math.random() * cw : x, y: intro ? Math.random() * ch : y, r: (gap / 5) * (0.8 + Math.random() * 1.2), pull: 2 + Math.random() * 18 };
			buckets[(Math.random() * SHADES) | 0].push(p); particles.push(p);
		}
		colors = palette(); dirty = true;
	}
	function draw() {
		ctx.setTransform(DPR, 0, 0, DPR, 0, 0);
		ctx.clearRect(0, 0, cw, ch);
		for (var k = 0; k < SHADES; k++) {
			ctx.fillStyle = colors[k]; ctx.beginPath();
			var b = buckets[k];
			for (var j = 0; j < b.length; j++) { var p = b[j]; ctx.moveTo(p.x + p.r, p.y); ctx.arc(p.x, p.y, p.r, 0, TAU); }
			ctx.fill();
		}
		dirty = false;
	}
	var ptr = { x: -1e4, y: -1e4, on: false };
	function step(dt) {
		var rect = canvas.getBoundingClientRect(), px = ptr.x - rect.left, py = ptr.y - rect.top;
		var near = ptr.on && px > -radius && px < cw + radius && py > -radius && py < ch + radius;
		var ease = 1 - Math.pow(0.9, dt), moving = false;
		for (var i = 0; i < particles.length; i++) {
			var p = particles[i], dx = px - p.x, dy = py - p.y, d = near ? Math.hypot(dx, dy) : Infinity;
			if (d < radius && d > 0.01) { var f = ((radius - d) / radius) * p.pull * dt; p.x -= (dx / d) * f; p.y -= (dy / d) * f; moving = true; }
			else {
				var ex = p.bx - p.x, ey = p.by - p.y;
				if (Math.abs(ex) > 0.05 || Math.abs(ey) > 0.05) { p.x += ex * ease; p.y += ey * ease; moving = true; } else { p.x = p.bx; p.y = p.by; }
			}
		}
		return moving;
	}
	build(false); draw();
	addEventListener('resize', function () { build(false); draw(); });
	var cs0 = getComputedStyle(text);
	var ready = (document.fonts && document.fonts.load) ? document.fonts.load(cs0.fontWeight + ' ' + cs0.fontSize + ' ' + cs0.fontFamily) : Promise.resolve();
	ready.catch(function () {}).then(function () {
		build(!reduced); draw();
		if (reduced) return;
		var running = false, last = 0;
		var move = function (e) { ptr.x = e.clientX; ptr.y = e.clientY; ptr.on = true; };
		var tick = function (t) {
			if (!running) return;
			var dt = Math.min(((t - (last || t)) / 1000) * 60, 3); last = t;
			if (dirty) { step(dt); draw(); } else if (step(dt)) draw();
			requestAnimationFrame(tick);
		};
		new IntersectionObserver(function (es) {
			var on = es[0].isIntersecting;
			if (on && !running) { running = true; last = 0; requestAnimationFrame(tick); addEventListener('pointermove', move, { passive: true }); addEventListener('touchmove', function (e) { if (e.touches[0]) move(e.touches[0]); }, { passive: true }); }
			else if (!on) { running = false; removeEventListener('pointermove', move); ptr.on = false; }
		}).observe(wrap);
		document.addEventListener('pointerleave', function () { ptr.on = false; });
		addEventListener('touchend', function () { ptr.on = false; });
	});
})();
