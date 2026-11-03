/*
 * Homepage scroll choreography for phones, on top of the site's own motion (the Astro bundle: reveals, the hero strip,
 * the flame sequence, the drum, the morphs). Loaded by wiseup_home_mobile_motion() (includes/render.php) only below
 * 768px and without reduced motion, with its own GSAP from assets/js/vendor.
 *
 * The bundle owns each element's `transform`, `opacity` on reveals and every pin, so nothing here pins or writes those:
 * movement goes through the --wm-* custom properties that home-mobile.css maps onto `translate` / `rotate` / `scale`
 * (they compose with the bundle's transforms), and the stacked process cards use CSS sticky instead of a pin.
 *
 * What it adds, top to bottom: a scroll progress line; velocity skew on the long lists and image rows; the wordmark's
 * letters scattering as the hero scrolls away; services tipping forward into place with the row in the middle of the
 * screen lit; figures counting up; work tiles swinging in by row; "Posts fade." fading while "Brands last." lands; the
 * fit cards parting; CodeAce cards swinging in from alternate sides; press columns drifting against each other; the
 * process cards stacking as a deck; swipe on the client tiers; FAQ and contact rows folding in; the footer rising; and a
 * lime ripple under every tap.
 */
(function () {
	var gsap = window.gsap, ST = window.ScrollTrigger;
	if (!gsap || !ST || !document.querySelector('.hero--lunar')) return;
	gsap.registerPlugin(ST);

	var root = document.documentElement;
	var $ = function (s, c) { return (c || document).querySelector(s); };
	var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
	var mark = function (els, cls) { els.forEach(function (el) { el.classList.add(cls || 'wm-t'); }); return els; };
	var clamp = gsap.utils.clamp;

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
	function scrub(targets, from, to, trigger, start, end, s) {
		return vt(targets, from, Object.assign({ ease: 'none', scrollTrigger: { trigger: trigger, start: start || 'top bottom', end: end || 'top 60%', scrub: s === undefined ? 0.6 : s, invalidateOnRefresh: true } }, to));
	}

	/** "120+", "3M+", "91K+": counts the number part up from zero once, keeping what's around it. */
	function countUp(el) {
		var m = el.textContent.trim().match(/^(\D*)(\d+(?:\.\d+)?)(.*)$/);
		if (!m) return;
		var end = parseFloat(m[2]), o = { v: 0 }, keep = el.textContent;
		ST.create({
			trigger: el, start: 'top 92%', once: true,
			onEnter: function () {
				gsap.to(o, { v: end, duration: 1.6, ease: 'expo.out', onUpdate: function () { el.textContent = m[1] + Math.round(o.v) + m[3]; }, onComplete: function () { el.textContent = keep; } });
			},
		});
	}

	function build() {
		root.classList.add('wm-on');
		var offs = [];

		// ---------- scroll progress line ----------
		var bar = document.createElement('div');
		bar.className = 'wm-progress';
		bar.setAttribute('aria-hidden', 'true');
		document.body.appendChild(bar);
		ST.create({ start: 0, end: 'max', onUpdate: function (s) { bar.style.setProperty('--wm-p', s.progress.toFixed(4)); } });
		offs.push(function () { bar.remove(); });

		// ---------- velocity skew: lists and rows lean with a fast flick and settle back ----------
		var skewEls = mark($$('.svc, .rows__row, .logos__marquee, .roots, .press__wall, .reach__view, .faq'), 'wm-skew');
		var skew = { v: 0 }, setSkew = gsap.quickTo(skew, 'v', { duration: 0.5, ease: 'power3.out', onUpdate: function () { root.style.setProperty('--wm-skew', skew.v.toFixed(2) + 'deg'); } });
		ST.create({ start: 0, end: 'max', onUpdate: function (s) { setSkew(clamp(-5, 5, s.getVelocity() / -350)); } });
		var settle = function () { setSkew(0); };
		ST.addEventListener('scrollEnd', settle);
		offs.push(function () { ST.removeEventListener('scrollEnd', settle); skewEls.forEach(function (el) { el.classList.remove('wm-skew'); }); root.style.removeProperty('--wm-skew'); });

		// ---------- hero: the wordmark's letters lift off at their own speeds as the page scrolls on ----------
		var hero = $('.hero--lunar');
		// Each letter moves inside a <g> of its own: the site script animates the paths themselves (entrance, pointer
		// lift), and a second hand on the same element would fold one transform into the other.
		var letters = $$('.lunar__mark .wm__l').map(function (l) {
			var g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
			g.setAttribute('class', 'wm-lw');
			l.parentNode.insertBefore(g, l);
			g.appendChild(l);
			offs.push(function () { if (g.parentNode) { g.parentNode.insertBefore(l, g); g.remove(); } });
			return g;
		});
		var mid = (letters.length - 1) / 2;
		letters.forEach(function (l, i) {
			var k = i - mid;
			vt(mark([l], 'wm-f'), { '--wm-y': '0px', '--wm-x': '0px', '--wm-r': '0deg', '--wm-blur': '0px', '--wm-o': 1 }, {
				'--wm-y': -(140 + Math.abs(k) * 50 + (i % 2) * 70) + 'px', '--wm-x': k * 44 + 'px', '--wm-r': k * 16 + 'deg', '--wm-blur': '6px', '--wm-o': 0.15, ease: 'power1.in',
				scrollTrigger: { trigger: hero, start: 'top top', end: '+=70%', scrub: 0.3 + i * 0.15 },
			});
		});
		var sub = $('.lunar__sub');
		if (sub) vt(mark([sub], 'wm-f'), { '--wm-ls': '0em', '--wm-o': 1 }, { '--wm-ls': '0.4em', '--wm-o': 0, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: '+=45%', scrub: 0.5 } });
		var orb = $('.hero__orb');
		if (orb) vt(mark(mark([orb]), 'wm-f'), { '--wm-s': 1, '--wm-o': 1 }, { '--wm-s': 3.2, '--wm-o': 0, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: '+=60%', scrub: 0.6 } });

		// ---------- section heads: the eyebrow slides in, the title drifts up and dims as it leaves ----------
		$$('.sh').forEach(function (sh) {
			var eb = $('.eyebrow', sh), h = $('.sh__h', sh);
			if (eb) scrub(mark([eb]), { '--wm-x': '-36px', '--wm-s': 0.8 }, { '--wm-x': '0px', '--wm-s': 1 }, sh, 'top bottom', 'top 70%');
			if (h) {
				mark(mark([h]), 'wm-f');
				vt(h, { '--wm-y': '0px' }, { '--wm-y': '-34px', ease: 'none', scrollTrigger: { trigger: h, start: 'top 60%', end: 'bottom top', scrub: 0.6 } });
				vt(h, { '--wm-o': 1 }, { '--wm-o': 0.25, ease: 'none', immediateRender: false, scrollTrigger: { trigger: h, start: 'top 22%', end: 'bottom top', scrub: 0.6 } });
			}
		});

		// ---------- services: each row tips forward into place; the one in the middle of the screen is lit ----------
		$$('.svc__item').forEach(function (li) {
			mark([li]);
			li.style.setProperty('--wm-ax', '1 0 0');
			scrub(li, { '--wm-r': '-58deg', '--wm-s': 0.9 }, { '--wm-r': '0deg', '--wm-s': 1 }, li, 'top bottom', 'top 72%', 0.5);
			ST.create({ trigger: li, start: 'top 55%', end: 'bottom 45%', toggleClass: 'wm-focus' });
		});

		// ---------- figures under the flame count up (the growing section's own script counts its figures) ----------
		$$('.stats dd').forEach(countUp);

		// ---------- statement + CTAs under the flame ----------
		$$('.seq__ctas .b').forEach(function (b, i) {
			scrub(mark([b]), { '--wm-x': (i ? 60 : -60) + 'px' }, { '--wm-x': '0px' }, b, 'top bottom', 'top 75%');
		});
		$$('.stats__item').forEach(function (it, i) {
			scrub(mark([it]), { '--wm-y': 30 + (i % 2) * 30 + 'px' }, { '--wm-y': '0px' }, it, 'top bottom', 'top 70%');
		});

		// ---------- work: tiles swing in by row, the buttons slide together ----------
		$$('.rows__row').forEach(function (row) {
			var dir = Number(row.dataset.dir) < 0 ? -1 : 1;
			var tiles = mark($$('.rows__tile', row));
			tiles.forEach(function (t) { t.style.setProperty('--wm-ax', '0 1 0'); });
			scrub(tiles, { '--wm-r': dir * 28 + 'deg', '--wm-s': 0.82, '--wm-y': '40px' }, { '--wm-r': '0deg', '--wm-s': 1, '--wm-y': '0px' }, row, 'top bottom', 'center 55%', 0.7);
		});
		$$('.work-more .b').forEach(function (b, i) {
			scrub(mark([b]), { '--wm-x': (i ? 50 : -50) + 'px' }, { '--wm-x': '0px' }, b, 'top bottom', 'top 80%');
		});
		var logos = $('.logos__row');
		if (logos) scrub(mark([logos]), { '--wm-x': '60px' }, { '--wm-x': '-60px' }, logos, 'top bottom', 'bottom top', 0.8);

		// ---------- about: "Posts fade." does, "Brands last." lands ----------
		var st = $('.contrast__statement');
		if (st) {
			var parts = mark(mark($$(':scope > span', st)), 'wm-f');
			if (parts[0]) scrub(parts[0], { '--wm-o': 1, '--wm-blur': '0px', '--wm-x': '0px' }, { '--wm-o': 0.18, '--wm-blur': '3px', '--wm-x': '-18px' }, st, 'top 80%', 'top 35%');
			if (parts[1]) scrub(parts[1], { '--wm-s': 0.7, '--wm-x': '40px' }, { '--wm-s': 1, '--wm-x': '0px' }, st, 'top 80%', 'top 45%');
		}
		var no = $('.fit__card--no'), yes = $('.fit__card--yes');
		if (no) {
			no.style.setProperty('--wm-ax', '0 0 1');
			vt(mark([no]), { '--wm-x': '0px', '--wm-r': '0deg', '--wm-s': 1 }, { '--wm-x': '-14px', '--wm-r': '-3deg', '--wm-s': 0.94, ease: 'none', scrollTrigger: { trigger: no, start: 'top 70%', end: 'bottom 25%', scrub: 0.6 } });
		}
		if (yes) {
			scrub(mark([yes]), { '--wm-y': '70px', '--wm-s': 0.88 }, { '--wm-y': '0px', '--wm-s': 1 }, yes, 'top bottom', 'top 62%');
			ST.create({ trigger: yes, start: 'top 65%', end: 'bottom 20%', toggleClass: 'wm-lit' });
		}

		// ---------- CodeAce: the morph floats, the three cards swing in from alternate sides ----------
		var morph = $('.morph');
		if (morph) scrub(mark([morph]), { '--wm-y': '60px', '--wm-s': 0.7 }, { '--wm-y': '-30px', '--wm-s': 1.05 }, morph, 'top bottom', 'bottom top', 0.8);
		$$('.roots .root').forEach(function (c, i) {
			var side = i % 2 ? 1 : -1;
			mark([c]);
			c.style.setProperty('--wm-ax', '0 1 0');
			scrub(c, { '--wm-r': side * -38 + 'deg', '--wm-x': side * 60 + 'px' }, { '--wm-r': '0deg', '--wm-x': '0px' }, c, 'top bottom', 'top 68%');
		});

		// ---------- growing: stat rows from alternate sides, press columns drift against each other, reach slides ----------
		$$('.grow__stats li').forEach(function (li, i) {
			scrub(mark([li]), { '--wm-x': (i % 2 ? 70 : -70) + 'px' }, { '--wm-x': '0px' }, li, 'top bottom', 'top 75%');
		});
		$$('.press__col').forEach(function (col, i) {
			var d = i % 2 ? 1 : -1;
			scrub(mark([col]), { '--wm-y': d * -50 + 'px' }, { '--wm-y': d * 50 + 'px' }, col.closest('.press') || col, 'top bottom', 'bottom top', 0.8);
		});
		var reach = $('.reach__track');
		if (reach) scrub(mark([reach]), { '--wm-x': '40px' }, { '--wm-x': function () { return -Math.max(0, reach.scrollWidth - innerWidth + 40) + 'px'; } }, reach.closest('.reach') || reach, 'top bottom', 'bottom 20%', 0.8);

		// ---------- process: a sticky deck; each card zooms its photo in and settles back under the next ----------
		var cards = $$('.hgal__list > .proc__card');
		cards.forEach(function (c, i) {
			c.style.setProperty('--wm-i', i);
			var dim = document.createElement('span');
			dim.className = 'wm-dim';
			dim.setAttribute('aria-hidden', 'true');
			c.appendChild(dim);
			mark([c]);
			c.style.setProperty('--wm-ax', '1 0 0');
			var shot = $('.proc__shot', c);
			if (shot) scrub(shot, { '--wm-zoom': 1.35 }, { '--wm-zoom': 1 }, c, 'top bottom', 'top 30%', 0.6);
			var next = cards[i + 1];
			if (next) {
				vt(c, { '--wm-s': 1, '--wm-r': '0deg', '--wm-dim': 0 }, {
					'--wm-s': 0.9, '--wm-r': '6deg', '--wm-dim': 0.6, ease: 'none',
					scrollTrigger: { trigger: next, start: 'top bottom', end: 'top 20%', scrub: 0.5 },
				});
			}
			offs.push(function () { dim.remove(); });
		});

		// ---------- clients: swipe between tiers (the arrows' own handlers do the paging), the deck tilts in ----------
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
			var track = $('[data-loop-track]', loop);
			if (track) {
				mark([track]);
				track.style.setProperty('--wm-ax', '0 1 0');
				scrub(track, { '--wm-r': '-24deg', '--wm-x': '50px' }, { '--wm-r': '0deg', '--wm-x': '0px' }, loop, 'top bottom', 'top 60%');
			}
		}

		// ---------- FAQ: questions fold down into place; an opened answer eases in ----------
		$$('.faq__item').forEach(function (d) {
			mark([d]);
			d.style.setProperty('--wm-ax', '1 0 0');
			scrub(d, { '--wm-r': '-50deg', '--wm-s': 0.92 }, { '--wm-r': '0deg', '--wm-s': 1 }, d, 'top bottom', 'top 78%', 0.5);
			var a = $('.faq__a', d);
			var toggle = function () { if (d.open && a) gsap.fromTo(a, { y: 14, opacity: 0 }, { y: 0, opacity: 1, duration: 0.6, ease: 'expo.out', clearProps: 'transform,opacity' }); };
			d.addEventListener('toggle', toggle);
			offs.push(function () { d.removeEventListener('toggle', toggle); });
		});

		// ---------- contact: channels slide in from the left, fields from the right ----------
		$$('.contact__rows > li').forEach(function (li, i) {
			scrub(mark([li]), { '--wm-x': -60 - i * 12 + 'px' }, { '--wm-x': '0px' }, li, 'top bottom', 'top 78%');
		});
		$$('.bform .bfield, .bform [data-form-submit]').forEach(function (f, i) {
			scrub(mark([f]), { '--wm-x': 60 + i * 8 + 'px' }, { '--wm-x': '0px' }, f, 'top bottom', 'top 82%');
		});
		$$('.socials .social').forEach(function (s, i) {
			scrub(mark([s]), { '--wm-y': '30px', '--wm-s': 0.7 }, { '--wm-y': '0px', '--wm-s': 1 }, s, 'top bottom', 'top 85%', 0.3 + i * 0.1);
		});

		// ---------- footer: columns rise in turn, the social marks pop ----------
		var ft = $('.ft');
		if (ft) {
			$$('.ft__brand, .ft__col, .ft__contact', ft).forEach(function (col) {
				scrub(mark([col]), { '--wm-y': '50px' }, { '--wm-y': '0px' }, col, 'top bottom', 'top 75%');
			});
			var soc = mark($$('.ft__social a', ft));
			if (soc.length) vt(soc, { '--wm-s': 0.4, '--wm-r': '-40deg' }, { '--wm-s': 1, '--wm-r': '0deg', duration: 0.8, ease: 'back.out(2)', stagger: 0.06, scrollTrigger: { trigger: soc[0], start: 'top 95%', once: true } });
		}

		// ---------- tap ripple ----------
		var rippleSel = '.b, .cta-row, .social, .loop-btn, .svc__btn, .faq__q';
		mark($$(rippleSel), 'wm-rip');
		var tap = function (e) {
			var el = e.target.closest && e.target.closest(rippleSel);
			if (!el) return;
			var r = el.getBoundingClientRect(), dot = document.createElement('span');
			dot.className = 'wm-ripple';
			dot.setAttribute('aria-hidden', 'true');
			dot.style.left = e.clientX - r.left + 'px';
			dot.style.top = e.clientY - r.top + 'px';
			el.appendChild(dot);
			gsap.fromTo(dot, { scale: 0, opacity: 1 }, { scale: Math.max(r.width, r.height) / 5, opacity: 0, duration: 0.8, ease: 'power2.out', onComplete: function () { dot.remove(); } });
		};
		document.addEventListener('pointerdown', tap, { passive: true });
		offs.push(function () { document.removeEventListener('pointerdown', tap); });

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
			$$('.wm-t').forEach(function (el) { el.classList.remove('wm-t'); });
			$$('.wm-rip').forEach(function (el) { el.classList.remove('wm-rip'); });
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
