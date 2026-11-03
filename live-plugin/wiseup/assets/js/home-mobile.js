/*
 * Homepage scroll motion for phones, on top of the site's own motion (the Astro bundle: reveals, the hero strip, the
 * flame sequence, the drum, the morphs). Loaded by wiseup_home_mobile_motion() (includes/render.php) only below 768px
 * and without reduced motion, with its own GSAP from assets/js/vendor.
 *
 * The register is quiet and deliberate: the site's reveals already bring each block in, so this layer adds depth and
 * pacing rather than more entrances. Nothing rotates, skews or springs; distances stay small, scrubbed movement is
 * smoothed, and one-off movement uses the site's own curve (expo.out).
 *
 * The bundle owns each element's `transform`, `opacity` on reveals and every pin, so nothing here pins or writes those:
 * movement goes through the --wm-* custom properties that home-mobile.css maps onto `translate` / `scale` / `filter`
 * (they compose with the bundle's transforms), and the stacked process cards use CSS sticky instead of a pin.
 *
 * Top to bottom: a hairline scroll progress line; the hero wordmark easing up and away as the page scrolls on; section
 * titles drifting up and dimming as they leave; the service row in the middle of the screen marked; figures counting
 * up; the logo band and the CodeAce mark moving at their own depth; "Posts fade." fading as it is read; the fit cards
 * settling (one dims, one is lit); press columns drifting against each other and the reach photos sliding across;
 * the process cards stacking as a deck with their photos easing in; swipe between client tiers; FAQ answers easing
 * open; and the footer arriving in turn.
 */
(function () {
	var gsap = window.gsap, ST = window.ScrollTrigger;
	if (!gsap || !ST || !document.querySelector('.hero--lunar')) return;
	gsap.registerPlugin(ST);

	var EASE = 'expo.out';
	var SMOOTH = 1; // scrub lag, in seconds: scrubbed movement trails the finger a little, so it never feels mechanical
	var root = document.documentElement;
	var $ = function (s, c) { return (c || document).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
	var mark = function (els, cls) { els.forEach(function (el) { el.classList.add(cls || 'wm-t'); }); return els; };

	/**
	 * gsap.fromTo() for --wm-* custom properties. It tweens plain objects and copies their values onto the elements, so
	 * this copy of GSAP never touches an element's own styles: a direct tween would parse the element's transform and
	 * write it back inline (with translate/rotate/scale: none), freezing whatever the site script was animating there.
	 */
	function vt(els, from, to) {
		els = [].concat(els);
		var px = els.map(function () { return Object.assign({}, from); });
		var apply = function () { px.forEach(function (p, i) { for (var k in p) els[i].style.setProperty(k, p[k]); }); };
		var vars = Object.assign({}, to), user = vars.onUpdate;
		vars.onUpdate = function () { apply(); if (user) user(); };
		var tw = gsap.fromTo(px, from, vars);
		apply();
		return tw;
	}

	/** Scrubbed --wm-* tween over an element's pass through the screen. */
	function scrub(targets, from, to, trigger, start, end) {
		return vt(targets, from, Object.assign({ ease: 'none', scrollTrigger: { trigger: trigger, start: start || 'top bottom', end: end || 'bottom top', scrub: SMOOTH, invalidateOnRefresh: true } }, to));
	}

	/** "120+", "3M+", "91K+": counts the number part up from zero once, keeping what's around it. */
	function countUp(el) {
		var m = el.textContent.trim().match(/^(\D*)(\d+(?:\.\d+)?)(.*)$/);
		if (!m) return;
		var end = parseFloat(m[2]), o = { v: 0 }, keep = el.textContent;
		ST.create({
			trigger: el, start: 'top 90%', once: true,
			onEnter: function () {
				gsap.to(o, { v: end, duration: 2, ease: EASE, onUpdate: function () { el.textContent = m[1] + Math.round(o.v) + m[3]; }, onComplete: function () { el.textContent = keep; } });
			},
		});
	}

	function build() {
		root.classList.add('wm-on');
		var offs = [];

		// ---------- hairline progress line ----------
		var bar = document.createElement('div');
		bar.className = 'wm-progress';
		bar.setAttribute('aria-hidden', 'true');
		document.body.appendChild(bar);
		ST.create({ start: 0, end: 'max', onUpdate: function (s) { bar.style.setProperty('--wm-p', s.progress.toFixed(4)); } });
		offs.push(function () { bar.remove(); });

		// ---------- hero: the wordmark eases up, settles back a touch and fades as the page scrolls on ----------
		var hero = $('.hero--lunar'), lunar = $('.lunar');
		if (lunar) scrub(mark(mark([lunar]), 'wm-f'), { '--wm-y': '0px', '--wm-s': 1, '--wm-o': 1 }, { '--wm-y': '-90px', '--wm-s': 0.94, '--wm-o': 0 }, hero, 'top top', '55% top');
		var orb = $('.hero__orb');
		if (orb) scrub(mark([orb], 'wm-f'), { '--wm-o': 1 }, { '--wm-o': 0 }, hero, 'top top', '40% top');

		// ---------- section titles drift up a little slower than the page and dim as they leave ----------
		$$('.sh__h').forEach(function (h) {
			mark(mark([h]), 'wm-f');
			scrub(h, { '--wm-y': '0px' }, { '--wm-y': '-24px' }, h, 'top 70%', 'bottom top');
			vt(h, { '--wm-o': 1 }, { '--wm-o': 0.35, ease: 'none', immediateRender: false, scrollTrigger: { trigger: h, start: 'top 25%', end: 'bottom top', scrub: SMOOTH } });
		});

		// ---------- services: the row crossing the middle of the screen is marked ----------
		$$('.svc__item').forEach(function (li) {
			ST.create({ trigger: li, start: 'top 56%', end: 'bottom 44%', toggleClass: 'wm-focus' });
		});

		// ---------- figures under the flame count up (the growing section's own script counts its figures) ----------
		$$('.stats dd').forEach(countUp);

		// ---------- depth: the logo band and the CodeAce mark move at their own pace ----------
		var logos = $('.logos__row');
		if (logos) scrub(mark([logos]), { '--wm-x': '24px' }, { '--wm-x': '-24px' }, logos);
		var morph = $('.morph');
		if (morph) scrub(mark([morph]), { '--wm-y': '32px' }, { '--wm-y': '-32px' }, morph);

		// ---------- about: "Posts fade." fades as it is read; the fit cards settle, one dims and one is lit ----------
		var stmt = $('.contrast__statement > span');
		if (stmt) scrub(mark([stmt], 'wm-f'), { '--wm-o': 1, '--wm-blur': '0px' }, { '--wm-o': 0.3, '--wm-blur': '1.5px' }, stmt, 'top 75%', 'top 40%');
		var no = $('.fit__card--no'), yes = $('.fit__card--yes');
		if (no) scrub(mark([no], 'wm-f'), { '--wm-o': 1 }, { '--wm-o': 0.5 }, no, 'top 55%', 'bottom 30%');
		if (yes) ST.create({ trigger: yes, start: 'top 70%', end: 'bottom 20%', toggleClass: 'wm-lit' });

		// ---------- growing: press columns drift against each other, the reach photos slide across ----------
		$$('.press__col').forEach(function (col, i) {
			var d = i % 2 ? 1 : -1;
			scrub(mark([col]), { '--wm-y': d * -28 + 'px' }, { '--wm-y': d * 28 + 'px' }, col.closest('.press') || col);
		});
		var reach = $('.reach__track');
		if (reach) scrub(mark([reach]), { '--wm-x': '0px' }, { '--wm-x': function () { return -Math.max(0, reach.scrollWidth - innerWidth + 32) + 'px'; } }, reach.closest('.reach') || reach, 'top bottom', 'bottom 25%');

		// ---------- process: a sticky deck; each photo eases in, each card settles back under the next ----------
		var cards = $$('.hgal__list > .proc__card');
		cards.forEach(function (c, i) {
			c.style.setProperty('--wm-i', i);
			var dim = document.createElement('span');
			dim.className = 'wm-dim';
			dim.setAttribute('aria-hidden', 'true');
			c.appendChild(dim);
			offs.push(function () { dim.remove(); });
			var shot = $('.proc__shot', c);
			if (shot) scrub(shot, { '--wm-zoom': 1.16 }, { '--wm-zoom': 1 }, c, 'top bottom', 'top 25%');
			var next = cards[i + 1];
			if (next) scrub(mark([c]), { '--wm-s': 1, '--wm-dim': 0 }, { '--wm-s': 0.94, '--wm-dim': 0.45 }, next, 'top bottom', 'top 20%');
		});

		// ---------- clients: swipe between tiers (the arrows' own handlers do the paging) ----------
		var loop = $('[data-loop]'), prev = $('[data-loop-prev]'), nextBtn = $('[data-loop-next]');
		if (loop && prev && nextBtn) {
			var x0 = 0, y0 = 0, t0 = 0;
			var down = function (e) { x0 = e.touches[0].clientX; y0 = e.touches[0].clientY; t0 = Date.now(); };
			var up = function (e) {
				var dx = e.changedTouches[0].clientX - x0, dy = e.changedTouches[0].clientY - y0;
				if (Math.abs(dx) > 40 && Math.abs(dx) > Math.abs(dy) * 1.4 && Date.now() - t0 < 800) (dx < 0 ? nextBtn : prev).click();
			};
			loop.addEventListener('touchstart', down, { passive: true });
			loop.addEventListener('touchend', up, { passive: true });
			offs.push(function () { loop.removeEventListener('touchstart', down); loop.removeEventListener('touchend', up); });
		}

		// ---------- FAQ: an opened answer eases in ----------
		$$('.faq__item').forEach(function (d) {
			var a = $('.faq__a', d);
			if (!a) return;
			mark(mark([a]), 'wm-f');
			var toggle = function () { if (d.open) vt(a, { '--wm-y': '10px', '--wm-o': 0 }, { '--wm-y': '0px', '--wm-o': 1, duration: 0.9, ease: EASE }); };
			d.addEventListener('toggle', toggle);
			offs.push(function () { d.removeEventListener('toggle', toggle); });
		});

		// ---------- footer: the columns, then the base line, arrive in turn ----------
		var ft = $('.ft');
		if (ft) {
			var parts = mark(mark($$('.ft__top > *, .ft__base', ft)), 'wm-f');
			parts.forEach(function (p) {
				vt(p, { '--wm-y': '28px', '--wm-o': 0 }, { '--wm-y': '0px', '--wm-o': 1, duration: 1.2, ease: EASE, scrollTrigger: { trigger: p, start: 'top 92%', once: true } });
			});
		}

		// The site script adds and removes its own pins and spacers, which moves everything below them: re-measure this
		// layer's triggers whenever the page height changes.
		var h = 0, id = 0;
		var ro = new ResizeObserver(function () {
			var nh = document.documentElement.scrollHeight;
			if (Math.abs(nh - h) < 2) return;
			h = nh; clearTimeout(id); id = setTimeout(function () { ST.refresh(); }, 150);
		});
		ro.observe(document.body);
		offs.push(function () { ro.disconnect(); clearTimeout(id); });

		return function () {
			offs.forEach(function (f) { f(); });
			$$('.wm-t, .wm-f').forEach(function (el) { el.classList.remove('wm-t', 'wm-f'); });
			root.classList.remove('wm-on');
		};
	}

	// Start once the page (and the site script's first layout and pins) has settled.
	var start = function () {
		requestAnimationFrame(function () {
			gsap.matchMedia().add('(max-width: 767px) and (prefers-reduced-motion: no-preference)', build);
			ST.refresh();
		});
	};
	if (document.readyState === 'complete') start(); else addEventListener('load', start, { once: true });
})();
