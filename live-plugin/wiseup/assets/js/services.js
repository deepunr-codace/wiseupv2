/*
 * Services page motion, the homepage's language in plain JS (no build step): Lenis smooth scroll driving ScrollTrigger,
 * masked line reveals (SplitText, yPercent 110, expo.out, 0.08 stagger), blocks rising 48px, cards revealing in
 * staggered batches with their numbers counting up, a cursor tilt + spotlight on each card, magnetic buttons, a
 * drifting hero glow and light scroll parallax. Content is only hidden while html.wu-motion is set (head script), and
 * nothing runs under reduced motion.
 */
(function () {
	var d = document.documentElement;
	if (!d.classList.contains('wu-motion') || !window.gsap || !window.ScrollTrigger) { d.classList.remove('wu-motion'); return; }
	window.__wuSvcMotion = true;
	var gsap = window.gsap, ST = window.ScrollTrigger, Split = window.SplitText;
	gsap.registerPlugin(ST);
	if (Split) gsap.registerPlugin(Split);
	var EASE = 'expo.out', SOFT = 'power3.out';
	var page = document.querySelector('.wu-svc');
	if (!page) return;
	var finePointer = matchMedia('(hover: hover) and (pointer: fine)').matches;

	// ---------- smooth scroll (same settings as the homepage) ----------
	if (window.Lenis) {
		var lenis = new window.Lenis({ lerp: 0.1, wheelMultiplier: 1, touchMultiplier: 1.2, anchors: { offset: -24 } });
		lenis.on('scroll', ST.update);
		gsap.ticker.add(function (t) { lenis.raf(t * 1000); });
		gsap.ticker.lagSmoothing(0);
		// the lead popup locks the page: pause smooth scroll while it is open
		var dlg = document.querySelector('[data-lead-modal]');
		if (dlg) new MutationObserver(function () { if (dlg.open) lenis.stop(); else lenis.start(); }).observe(dlg, { attributes: true, attributeFilter: ['open'] });
	}

	// ---------- reveals ----------
	var intro = gsap.timeline({ paused: true });

	function splitLines(el, isIntro) {
		var delay = parseFloat(el.dataset.delay || '0'), done = false, requested = false, tw = null;
		if (isIntro) intro.add(function () { requested = true; if (tw) tw.play(); }, 0.1);
		if (!Split) { gsap.set(el, { visibility: 'visible' }); return; }
		Split.create(el, {
			type: 'lines', mask: 'lines', autoSplit: true, linesClass: 'split-line',
			onSplit: function (self) {
				gsap.set(el, { visibility: 'visible' });
				if (done) return;
				tw = gsap.from(self.lines, {
					yPercent: 110, rotate: 2, duration: 1.2, stagger: 0.08, ease: EASE, delay: delay, paused: isIntro && !requested,
					onComplete: function () { done = true; },
					scrollTrigger: isIntro ? undefined : { trigger: el, start: 'top 88%', once: true },
				});
				return tw;
			},
		});
	}

	function block(el, isIntro) {
		var kind = el.dataset.reveal || 'up', delay = parseFloat(el.dataset.delay || '0');
		var from = kind === 'fade' ? { opacity: 0 }
			: kind === 'scale' ? { opacity: 0, clipPath: 'inset(10% 6% 10% 6% round 28px)', scale: 0.96 }
			: { opacity: 0, y: 48 };
		var to = { opacity: 1, y: 0, scale: 1, duration: kind === 'fade' ? 1 : 1.3, ease: EASE, delay: delay, paused: isIntro, clearProps: 'transform,clipPath' };
		if (kind === 'scale') to.clipPath = 'inset(0% 0% 0% 0% round 28px)';
		if (!isIntro) to.scrollTrigger = { trigger: el, start: 'top 90%', once: true };
		var tw = gsap.fromTo(el, from, to);
		if (isIntro) intro.add(function () { tw.play(); }, 0);
	}

	page.querySelectorAll('[data-split]').forEach(function (el) { splitLines(el, el.hasAttribute('data-intro')); });
	page.querySelectorAll('[data-reveal]').forEach(function (el) { block(el, el.hasAttribute('data-intro')); });

	// hero chips pop in one by one
	var chips = page.querySelectorAll('[data-chips] a');
	if (chips.length) {
		gsap.set(chips, { opacity: 0, y: 18, scale: 0.92 });
		intro.to(chips, { opacity: 1, y: 0, scale: 1, duration: 0.9, stagger: 0.045, ease: EASE, clearProps: 'transform' }, 0.45);
	}

	// ---------- cards: batch reveal, inner stagger, count-up ----------
	var cards = gsap.utils.toArray(page.querySelectorAll('[data-card]'));
	cards.forEach(function (c) {
		gsap.set(c, { opacity: 0, y: 80 });
		gsap.set(c.querySelector('.sv-card__ico'), { scale: 0.4, rotate: -25, opacity: 0 });
		gsap.set(c.querySelector('.sv-vis'), { opacity: 0, scale: 1.08 });
		gsap.set(c.querySelector('.sv-card__t'), { y: 26, opacity: 0 });
		gsap.set(c.querySelectorAll('.sv-chips li'), { y: 14, opacity: 0 });
		gsap.set(c.querySelector('.sv-card__foot'), { y: 14, opacity: 0 });
	});
	function playCard(c, i) {
		var tl = gsap.timeline({ delay: i * 0.1 });
		tl.to(c, { opacity: 1, y: 0, duration: 1.2, ease: EASE, clearProps: 'transform', onComplete: function () { c.classList.add('is-in'); } })
			.to(c.querySelector('.sv-vis'), { opacity: 1, scale: 1, duration: 1.4, ease: EASE, clearProps: 'transform' }, 0.1)
			.to(c.querySelector('.sv-card__ico'), { scale: 1, rotate: 0, opacity: 1, duration: 0.9, ease: 'back.out(2)', clearProps: 'transform' }, 0.2)
			.to(c.querySelector('.sv-card__t'), { y: 0, opacity: 1, duration: 1, ease: EASE, clearProps: 'transform' }, 0.25)
			.to(c.querySelectorAll('.sv-chips li'), { y: 0, opacity: 1, duration: 0.8, stagger: 0.05, ease: SOFT, clearProps: 'transform' }, 0.35)
			.to(c.querySelector('.sv-card__foot'), { y: 0, opacity: 1, duration: 0.8, ease: SOFT, clearProps: 'transform' }, 0.5);
		var n = c.querySelector('[data-count]');
		if (n) {
			var o = { v: 0 }, end = parseInt(n.dataset.count, 10) || 0;
			tl.to(o, { v: end, duration: 1.1, ease: 'power2.out', onUpdate: function () { n.textContent = String(Math.round(o.v)).padStart(2, '0'); } }, 0.15);
		}
	}
	// the illustrations only animate while their card is on screen (CSS pauses them otherwise)
	cards.forEach(function (c) {
		ST.create({ trigger: c, start: 'top bottom', end: 'bottom top', onToggle: function (st) { c.classList.toggle('is-live', st.isActive); } });
	});
	ST.batch(cards, { start: 'top 88%', once: true, onEnter: function (batch) { batch.forEach(playCard); } });

	// big outline numbers drift against the scroll
	page.querySelectorAll('.sv-card__n').forEach(function (n) {
		gsap.fromTo(n, { yPercent: 30 }, { yPercent: -30, ease: 'none', scrollTrigger: { trigger: n.closest('[data-card]'), start: 'top bottom', end: 'bottom top', scrub: true } });
	});

	// ---------- hero: drifting glow, content eases away on scroll ----------
	var glow = page.querySelector('.sv-glow');
	if (glow) {
		var drift = gsap.to(glow, { xPercent: -8, yPercent: 6, scale: 1.12, duration: 7, ease: 'sine.inOut', yoyo: true, repeat: -1 });
		ST.create({ trigger: '.sv-hero', start: 'top top', end: 'bottom top', onToggle: function (s) { if (s.isActive) drift.play(); else drift.pause(); } });
	}
	var heroWrap = page.querySelector('.sv-hero .sv-wrap');
	if (heroWrap) gsap.to(heroWrap, { y: -70, ease: 'none', scrollTrigger: { trigger: '.sv-hero', start: 'top top', end: 'bottom top', scrub: true } });

	// ---------- pointer: card tilt + spotlight, magnetic buttons (mouse only) ----------
	if (finePointer) {
		// cards have no hover effect of their own (owner request); only the buttons react
		page.querySelectorAll('.sv-btn, .sv-link').forEach(function (b) {
			var xTo = gsap.quickTo(b, 'x', { duration: 0.5, ease: SOFT }), yTo = gsap.quickTo(b, 'y', { duration: 0.5, ease: SOFT });
			b.addEventListener('pointermove', function (e) {
				var r = b.getBoundingClientRect();
				xTo((e.clientX - r.left - r.width / 2) * 0.25);
				yTo((e.clientY - r.top - r.height / 2) * 0.35);
			});
			b.addEventListener('pointerleave', function () { xTo(0); yTo(0); });
		});
	}

	// play the entrance once fonts are in (so the split measures the real lines)
	var go = function () { intro.play(); ST.refresh(); };
	if (document.fonts && document.fonts.ready) document.fonts.ready.then(go); else go();
})();

/* hero chip strip: fade edges by scroll position, drag to scroll with a mouse (a drag doesn't follow the link) */
(function () {
	var row = document.querySelector('.sv-jump');
	if (!row) return;
	function edges() {
		var max = row.scrollWidth - row.clientWidth;
		row.classList.toggle('is-fit', max <= 2);
		row.classList.toggle('is-end', max > 2 && row.scrollLeft >= max - 2);
		row.classList.toggle('is-mid', max > 2 && row.scrollLeft > 2 && row.scrollLeft < max - 2);
	}
	row.addEventListener('scroll', edges, { passive: true });
	window.addEventListener('resize', edges);
	edges();
	var down = false, moved = false, x0 = 0, s0 = 0;
	row.addEventListener('pointerdown', function (e) { if (e.pointerType !== 'mouse' || e.button !== 0) return; down = true; moved = false; x0 = e.clientX; s0 = row.scrollLeft; });
	window.addEventListener('pointermove', function (e) {
		if (!down) return;
		var dx = e.clientX - x0;
		if (!moved && Math.abs(dx) > 5) { moved = true; row.classList.add('is-drag'); }
		if (moved) row.scrollLeft = s0 - dx;
	});
	window.addEventListener('pointerup', function () { if (!down) return; down = false; setTimeout(function () { row.classList.remove('is-drag'); moved = false; }, 0); });
	row.addEventListener('click', function (e) { if (row.classList.contains('is-drag') || moved) { e.preventDefault(); e.stopPropagation(); } }, true);
	row.addEventListener('dragstart', function (e) { e.preventDefault(); });
})();
