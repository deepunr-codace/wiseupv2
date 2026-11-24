/*
 * Event Branding page motion: the homepage's motion language in plain JS (same as assets/js/services.js):
 * Lenis smooth scroll driving ScrollTrigger, masked line reveals on headings (SplitText, yPercent 110, expo.out,
 * 0.08 stagger), blocks rising 48px, cards revealing in staggered batches (icons pop, checklist ticks and price
 * meters fill), outline numbers drifting against the scroll, the hero easing away, magnetic buttons.
 * Content is hidden only while html.wu-motion is set (head script in landing/event-branding.php); nothing runs under
 * reduced motion, and the page's own simple reveal takes over if this script does not start.
 */
(function () {
	var d = document.documentElement;
	if (!d.classList.contains('wu-motion') || !window.gsap || !window.ScrollTrigger) { d.classList.remove('wu-motion'); return; }
	window.__wuEvMotion = true;
	var gsap = window.gsap, ST = window.ScrollTrigger, Split = window.SplitText;
	gsap.registerPlugin(ST);
	ST.config({ ignoreMobileResize: true });
	if (Split) gsap.registerPlugin(Split);
	var EASE = 'expo.out', SOFT = 'power3.out';
	var page = document.querySelector('.wu-ev');
	if (!page) return;
	var finePointer = matchMedia('(hover: hover) and (pointer: fine)').matches;
	var $ = function (s, r) { return (r || page).querySelector(s); };
	var $$ = function (s, r) { return [].slice.call((r || page).querySelectorAll(s)); };
	// one-shot reveals use a single IntersectionObserver instead of a ScrollTrigger each: every ScrollTrigger is
	// re-measured (forced layout) on each refresh, which was most of the page's blocking time in PageSpeed
	var ioFns = new Map();
	var io = 'IntersectionObserver' in window ? new IntersectionObserver(function (es) {
		var k = 0;
		es.forEach(function (e) { if (!e.isIntersecting) return; var f = ioFns.get(e.target); io.unobserve(e.target); ioFns.delete(e.target); if (f) f(k++); });
	}, { rootMargin: '0px 0px -10% 0px' }) : null;
	function onceIn(el, fn) { if (!io) { fn(0); return; } ioFns.set(el, fn); io.observe(el); }
	window.__wuOnceIn = onceIn;

	// ---------- smooth scroll (homepage settings) ----------
	if (window.Lenis) {
		var lenis = new window.Lenis({ lerp: 0.1, wheelMultiplier: 1, touchMultiplier: 1.2, anchors: { offset: -24 } });
		lenis.on('scroll', ST.update);
		gsap.ticker.add(function (t) { lenis.raf(t * 1000); });
		gsap.ticker.lagSmoothing(0);
		// Pause smooth scroll while any page popup is open (lead popup, SEO free-report popup).
		var dlgs = [].slice.call(document.querySelectorAll('[data-lead-modal], [data-seo-report]'));
		var syncDlg = function () { if (dlgs.some(function (x) { return x.open; })) lenis.stop(); else lenis.start(); };
		dlgs.forEach(function (x) { new MutationObserver(syncDlg).observe(x, { attributes: true, attributeFilter: ['open'] }); });
	}

	var intro = gsap.timeline({ paused: true });

	// phones: no SplitText for headings / paragraphs (each split forces layout); a plain fade-up instead
	var lite = matchMedia('(max-width: 767px)').matches;
	function liteIn(el) {
		gsap.set(el, { visibility: 'visible' });
		var tw = gsap.from(el, { y: 26, opacity: 0, duration: 0.9, ease: EASE, paused: true });
		onceIn(el, function () { tw.play(); });
	}

	// run fn only once el is near the screen: splitting every heading at load forced layout on the whole page
	var fontsReady = (document.fonts && document.fonts.ready) || Promise.resolve();
	function whenNear(el, fn0, now) {
		// lines are measured after the web fonts have loaded (splitting earlier cut lines at the fallback font's widths and left doubled breaks)
		var fn = function () { fontsReady.then(fn0); };
		if (now || !('IntersectionObserver' in window)) { fn(); return; }
		var io = new IntersectionObserver(function (es) {
			if (es.some(function (e) { return e.isIntersecting; })) { io.disconnect(); fn(); }
		}, { rootMargin: '120% 0px 120% 0px' });
		io.observe(el);
	}

	// ---------- masked line reveals ----------
	function splitLines(el, isIntro, delay) {
		var done = false, requested = false, tw = null;
		if (isIntro) intro.add(function () { requested = true; if (tw) tw.play(); }, 0.1);
		if (!Split) { gsap.set(el, { visibility: 'visible' }); return; }
		if (lite && !isIntro) { liteIn(el); return; }
		whenNear(el, function () { Split.create(el, {
			type: 'lines', mask: 'lines', linesClass: 'split-line', autoSplit: true,
			onSplit: function (self) {
				gsap.set(el, { visibility: 'visible' });
				if (done) return;
				tw = gsap.from(self.lines, {
					yPercent: 110, rotate: 2, duration: 1.2, stagger: 0.08, ease: EASE, delay: delay || 0, paused: isIntro && !requested,
					onComplete: function () { done = true; },
				});
				if (!isIntro) { tw.pause(); onceIn(el, function () { tw.play(); }); }
				return tw;
			},
		}); }, isIntro);
	}
	// a hero marked data-css-intro shows its content with a CSS entrance on first paint (no wait for these scripts)
	var h1 = $('.ev-hero:not([data-css-intro]) .ev-hero__h');
	if (h1) splitLines(h1, true, 0.05);
	$$('.ev-sec .sh__h, .ev-quotes__h').forEach(function (el) { el.setAttribute('data-split', ''); splitLines(el, false); });

	// ---------- blocks ----------
	function block(el, opts) {
		opts = opts || {};
		var kind = opts.kind || 'up';
		var from = kind === 'fade' ? { opacity: 0 }
			: kind === 'scale' ? { opacity: 0, scale: 0.92, y: 30 }
			: { opacity: 0, y: opts.y || 48 };
		var to = { opacity: 1, y: 0, scale: 1, duration: kind === 'fade' ? 1 : 1.3, ease: EASE, delay: opts.delay || 0, paused: true, clearProps: 'transform' };
		var tw = gsap.fromTo(el, from, to);
		if (opts.intro) intro.add(function () { tw.play(); }, opts.at || 0);
		else onceIn(el, function () { tw.play(); });
	}

	// hero entrance, in order
	var hero = $('.ev-hero:not([data-css-intro])');
	if (hero) {
		var eb = $('.eyebrow', hero); if (eb) block(eb, { kind: 'fade', intro: true, at: 0 });
		var hp = $('.ev-hero__p', hero); if (hp) block(hp, { intro: true, at: 0.35 });
		var hb = $('.ev-btns', hero); if (hb) block(hb, { intro: true, at: 0.5 });
		var stats = $$('.ev-stat', hero);
		if (stats.length) {
			gsap.set(stats, { opacity: 0, y: 30 });
			intro.to(stats, { opacity: 1, y: 0, duration: 1, stagger: 0.08, ease: EASE, clearProps: 'transform' }, 0.65);
			// numbers count up as they rise
			$$('[data-count]', hero).forEach(function (n, i) {
				var raw = n.getAttribute('data-count') || '0', o = { v: 0 }, end = parseFloat(raw) || 0, dp = (raw.split('.')[1] || '').length;
				n.textContent = '0';
				intro.to(o, { v: end, duration: 1.4, ease: 'power2.out', onUpdate: function () { n.textContent = o.v.toFixed(dp); } }, 0.7 + i * 0.08);
			});
		}
		var stage = $('.ev-stage', hero); if (stage) block(stage, { kind: 'scale', intro: true, at: 0.25 });
		var logos = $('.ev-logos', hero); if (logos) block(logos, { kind: 'fade', intro: true, at: 0.9 });
	}

	// section eyebrows fade, text blocks rise
	$$('.ev-sec .eyebrow').forEach(function (el) { block(el, { kind: 'fade' }); });
	$$('.ev-prose > *, .ev-choose__intro, .ev-timeline, .ev-disc__card, .ev-from__note, .faq__item, .ev-final, .ev-quotes__track, .ev-quotes__nav, .ev-quotes__dots').forEach(function (el) { block(el); });
	var ticker = $('.ev-ticker'); if (ticker) block(ticker, { kind: 'fade' });

	// ---------- cards: batch reveal, inner pop ----------
	var cards = $$('.ev-disc__pts li, .ev-card, .ev-step, .ev-exp__card, .ev-why li, .ev-chk, .ev-cost, .ev-case, .ev-route, .ev-map, .ev-kl__side .ev-panel, .ev-corp .ev-panel, .ev-three .ev-panel');
	cards.forEach(function (c) {
		gsap.set(c, { opacity: 0, y: 80 });
		var ico = $('.ev-disc__pi, .ev-ico, .ev-chk__box, .ev-step__n, .ev-tstep__i, .ev-exp__i', c);
		if (ico) gsap.set(ico, { scale: 0.4, rotate: -25, opacity: 0 });
	});
	function playCard(c, i) {
		var tl = gsap.timeline({ delay: i * 0.1 });
		tl.to(c, { opacity: 1, y: 0, duration: 1.2, ease: EASE, clearProps: 'transform', onStart: function () { c.classList.add('is-in'); } });
		var ico = $('.ev-disc__pi, .ev-ico, .ev-chk__box, .ev-step__n, .ev-tstep__i, .ev-exp__i', c);
		if (ico) tl.to(ico, { scale: 1, rotate: 0, opacity: 1, duration: 0.9, ease: 'back.out(2)', clearProps: 'transform' }, 0.2);
		var stops = $$('.ev-stop', c);
		if (stops.length) tl.from(stops, { x: -24, opacity: 0, duration: 0.8, stagger: 0.07, ease: SOFT, clearProps: 'transform' }, 0.2);
		var tiles = $$('.ev-types li, .ev-venue__list li, .ev-check li, .ev-chips li, .ev-case__stats li', c);
		if (tiles.length) tl.from(tiles, { y: 14, opacity: 0, duration: 0.7, stagger: 0.04, ease: SOFT, clearProps: 'transform' }, 0.3);
	}
	cards.forEach(function (c) { onceIn(c, function (k) { playCard(c, k); }); });

	// ---------- parallax ----------
	$$('.ev-why__n, .ev-cost__n, .ev-chk__n').forEach(function (n) {
		gsap.fromTo(n, { yPercent: 40 }, { yPercent: -40, ease: 'none', scrollTrigger: { trigger: n.parentNode, start: 'top bottom', end: 'bottom top', scrub: true } });
	});
	if (hero) {
		var copy = $('.ev-hero__copy', hero), st = $('.ev-stage', hero);
		if (copy) gsap.to(copy, { y: -70, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true } });
		if (st) gsap.to(st, { y: -30, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: 1.2 } });
		// the stage photo rises gently off its glossy floor as the page scrolls: the image lifts and leans back a touch,
		// its contact shadow narrows and fades, the reflection sinks and fades, the floor glow dims (CSS reads --lift)
		var ph = $('.ev-photo', hero);
		if (ph) gsap.fromTo(ph, { '--lift': 0 }, { '--lift': 1, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: 1.2 } });
		var glow = $('.ev-hero__glow', hero);
		if (glow) {
			var drift = gsap.to(glow, { xPercent: -8, yPercent: 6, scale: 1.12, duration: 7, ease: 'sine.inOut', yoyo: true, repeat: -1 });
			ST.create({ trigger: hero, start: 'top top', end: 'bottom top', onToggle: function (s) { if (s.isActive) drift.play(); else drift.pause(); } });
		}
	}
	// the event-types ticker leans with scroll speed
	if (ticker) {
		var tr = $('.ev-ticker__track', ticker), skewTo = gsap.quickTo(tr, 'skewX', { duration: 0.6, ease: SOFT });
		ST.create({ trigger: ticker, start: 'top bottom', end: 'bottom top', onUpdate: function (s) { skewTo(gsap.utils.clamp(-8, 8, s.getVelocity() / -300)); } });
		ST.addEventListener('scrollEnd', function () { skewTo(0); });
	}

	// ---------- scroll techniques that break long content into steps (owner: "add more on scroll techniques") ----------
	// 1. portfolio case files stack: each card pins, the next slides over it; the covered card settles back and dims
	var cases = $$('.ev-cases--two .ev-case');
	if (matchMedia('(min-width: 1024px)').matches && cases.length > 1) {
		cases.forEach(function (c, i) {
			var next = cases[i + 1];
			if (!next) return;
			gsap.fromTo(c, { scale: 1, '--dim': 0 }, { scale: 0.94, '--dim': 0.55, ease: 'none', immediateRender: false,
				scrollTrigger: { trigger: next, start: 'top bottom', end: 'top 120px', scrub: true } });
		});
	}
	if (Split) {
		// 2. long lead paragraphs light up word by word as they pass through the screen
		$$('#what .ev-lead, #what .ev-fam3__text p, .ev-head--stack > .ev-intro p:first-child, .ev-kl__lead .ev-lead, .ev-price--col p:first-child').forEach(function (el) {
			el.classList.add('ev-scrub');
			if (lite) return;
			// no per-word elements: a CSS mask (.is-ml, --p) lights the paragraph from the top as it scrolls
			el.classList.add('is-ml');
			gsap.fromTo(el, { '--p': 0 }, { '--p': 1, ease: 'none', scrollTrigger: { trigger: el, start: 'top 82%', end: 'bottom 48%', scrub: true } });
		});
		// 3. section intros rise in line by line
		$$('.ev-head > .ev-intro p').forEach(function (el) {
			if (el.classList.contains('ev-scrub')) return;
			if (lite) { liteIn(el); return; }
			whenNear(el, function () { Split.create(el, { type: 'lines', mask: 'lines', linesClass: 'split-line', autoSplit: true, onSplit: function (self) {
				var tw = gsap.from(self.lines, { yPercent: 105, duration: 1, stagger: 0.06, ease: EASE, paused: true });
				onceIn(el, function () { tw.play(); });
				return tw;
			} }); });
		});
	}
	// 4. virtual and hybrid panels open with a top-down wipe
	$$('#virtual .ev-panel').forEach(function (pnl) {
		var tw = gsap.fromTo(pnl, { clipPath: 'inset(0 0 100% 0 round 24px)' }, { clipPath: 'inset(0 0 0% 0 round 24px)', duration: 1.3, ease: 'expo.inOut', clearProps: 'clipPath', paused: true });
		onceIn(pnl, function () { tw.play(); });
	});

	// ---------- magnetic buttons (mouse only) ----------
	if (finePointer) {
		$$('.b, .ev-qnav').forEach(function (b) {
			var xTo = gsap.quickTo(b, 'x', { duration: 0.5, ease: SOFT }), yTo = gsap.quickTo(b, 'y', { duration: 0.5, ease: SOFT });
			b.addEventListener('pointermove', function (e) {
				var r = b.getBoundingClientRect();
				xTo((e.clientX - r.left - r.width / 2) * 0.25);
				yTo((e.clientY - r.top - r.height / 2) * 0.35);
			});
			b.addEventListener('pointerleave', function () { xTo(0); yTo(0); });
		});
	}

	// ScrollTrigger refreshes by itself on window load; refresh again only if the fonts finished after that
	var go = function () { intro.play(); if (document.readyState === 'complete') ST.refresh(); };
	if (document.fonts && document.fonts.ready) document.fonts.ready.then(go); else go();
})();
