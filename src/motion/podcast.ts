// WiseUp Podcast (/podcast): the only truly page-specific behaviour left after the rebuild onto
// the homepage's own design system — click-to-embed thumbnails. Everything else (reveals, the
// episode filmstrip, the hosts/guests loop, stat counters) now runs on the shared engine's own
// mechanisms (horizontalGallery(), loopedPanels(), aboutCounters()) via the same data attributes
// the homepage uses, so there's nothing page-specific left to duplicate for them.
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { onPage, prefersReducedMotion } from '../engine';

export function setupPodcast() {
  embedThumbnails();
  galleryLightbox();
  testimonialVideos();
  featuredStack();
  podcastScroll();
  miniPlayer();
  hostCards3d();
}

/* Thumbnails stay real <a href="youtube.com/watch?v=..."> links (work with JS off, middle-click,
   Cmd/Ctrl-click, screen readers); a plain left click swaps the thumbnail for a playing
   youtube-nocookie.com iframe in place instead of leaving the page. */
function embedThumbnails() {
  onPage(() => {
    const els = [...document.querySelectorAll<HTMLAnchorElement>('[data-embed]')];
    if (!els.length) return;
    const onClick = (e: MouseEvent) => {
      const el = e.currentTarget as HTMLAnchorElement;
      if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
      e.preventDefault();
      const id = el.dataset.videoId;
      if (!id) return;
      const iframe = document.createElement('iframe');
      iframe.src = `https://www.youtube-nocookie.com/embed/${id}?autoplay=1`;
      iframe.title = el.getAttribute('aria-label') || el.querySelector('h3')?.textContent || 'WiseUp Podcast video';
      iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
      iframe.allowFullscreen = true;
      iframe.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;border:0';
      el.style.position = 'relative';
      el.replaceChildren(iframe);
      el.removeAttribute('href');
    };
    els.forEach((el) => el.addEventListener('click', onClick));
    return () => els.forEach((el) => el.removeEventListener('click', onClick));
  });
}

/* Gallery: a click opens the photo in a native <dialog> (Esc closes, focus is trapped and restored by the
   browser); prev/next buttons and the arrow keys step through, a click on the dark backdrop closes. */
function galleryLightbox() {
  onPage(() => {
    const dlg = document.querySelector<HTMLDialogElement>('[data-lightbox]');
    const items = [...document.querySelectorAll<HTMLButtonElement>('[data-gal-open]')];
    const img = dlg?.querySelector<HTMLImageElement>('[data-lb-img]');
    const cap = dlg?.querySelector<HTMLElement>('[data-lb-cap]');
    if (!dlg || !img || !cap || !items.length) return;
    let at = 0;
    const show = (i: number) => {
      at = (i + items.length) % items.length;
      const b = items[at];
      img.src = b.dataset.src!;
      img.alt = b.querySelector('img')?.alt || '';
      cap.textContent = b.dataset.cap || '';
    };
    const open = (e: Event) => { show(Number((e.currentTarget as HTMLElement).dataset.galOpen)); dlg.showModal(); };
    const prev = () => show(at - 1);
    const next = () => show(at + 1);
    const close = () => dlg.close();
    const key = (e: KeyboardEvent) => { if (e.key === 'ArrowLeft') prev(); else if (e.key === 'ArrowRight') next(); };
    const backdrop = (e: MouseEvent) => { if (e.target === dlg) close(); };
    const btnPrev = dlg.querySelector('[data-lb-prev]'), btnNext = dlg.querySelector('[data-lb-next]'), btnClose = dlg.querySelector('[data-lb-close]');
    items.forEach((b) => b.addEventListener('click', open));
    btnPrev?.addEventListener('click', prev); btnNext?.addEventListener('click', next); btnClose?.addEventListener('click', close);
    dlg.addEventListener('keydown', key); dlg.addEventListener('click', backdrop);
    return () => {
      items.forEach((b) => b.removeEventListener('click', open));
      btnPrev?.removeEventListener('click', prev); btnNext?.removeEventListener('click', next); btnClose?.removeEventListener('click', close);
      dlg.removeEventListener('keydown', key); dlg.removeEventListener('click', backdrop);
      if (dlg.open) dlg.close();
    };
  });
}

/* Testimonials: a click swaps the poster for the mp4 (linked from wiseup.in), playing in place with controls;
   starting one pauses every other. Prev/next scroll the row by one visible page. */
function testimonialVideos() {
  onPage(() => {
    const track = document.querySelector<HTMLElement>('[data-tst-track]');
    if (!track) return;
    const btns = [...track.querySelectorAll<HTMLButtonElement>('[data-tst-video]')];
    const play = (e: Event) => {
      const b = e.currentTarget as HTMLButtonElement;
      if (b.classList.contains('is-playing')) return;
      track.querySelectorAll('video').forEach((v) => v.pause());
      const v = document.createElement('video');
      v.src = b.dataset.tstVideo!;
      v.controls = true; v.playsInline = true; v.autoplay = true; v.preload = 'auto';
      v.poster = b.querySelector('img')?.currentSrc || '';
      v.addEventListener('play', () => track.querySelectorAll('video').forEach((o) => o !== v && o.pause()));
      b.replaceChildren(v);
      b.classList.add('is-playing');
      b.removeAttribute('aria-label');
      v.play().catch(() => {});
    };
    const page = (dir: number) => track.scrollBy({ left: dir * track.clientWidth, behavior: 'smooth' });
    const prev = document.querySelector('[data-tst-prev]'), next = document.querySelector('[data-tst-next]');
    const onPrev = () => page(-1), onNext = () => page(1);
    btns.forEach((b) => b.addEventListener('click', play));
    prev?.addEventListener('click', onPrev); next?.addEventListener('click', onNext);
    return () => {
      btns.forEach((b) => b.removeEventListener('click', play));
      prev?.removeEventListener('click', onPrev); next?.removeEventListener('click', onNext);
      track.querySelectorAll('video').forEach((v) => v.pause());
    };
  });
}

/* Featured stack: only the first card shows; the section pins and scrolling slides each next card up from below
   over it while the one underneath shrinks back and dims. Without JS / reduced motion the cards simply stack. */
function featuredStack() {
  onPage(() => {
    const stack = document.querySelector<HTMLElement>('[data-fstack]');
    const cards = gsap.utils.toArray<HTMLElement>('[data-fcard]');
    if (!stack || cards.length < 2 || prefersReducedMotion()) return;
    stack.classList.add('is-stacked');
    const tl = gsap.timeline({ defaults: { ease: 'none' } });
    cards.slice(1).forEach((card, i) => {
      tl.fromTo(card, { y: () => innerHeight }, { y: 0, duration: 1 }, i)
        .to(cards[i], { scale: 0.92, opacity: 0.35, duration: 1 }, i);
    });
    const st = ScrollTrigger.create({
      trigger: stack.closest('section') || stack, start: 'top top+=' + Math.round(innerHeight * 0.1), end: () => '+=' + innerHeight * 0.9 * (cards.length - 1),
      pin: true, scrub: 0.6, animation: tl, invalidateOnRefresh: true,
    });
    return () => { st.kill(); tl.kill(); stack.classList.remove('is-stacked'); gsap.set(cards, { clearProps: 'all' }); };
  });
}

/* Page-wide scroll motion for /podcast (Lenis smooth scroll + reveals come from the shared engine):
   - hero: the team photo zooms out and drifts, the text lifts away as the hero leaves
   - episodes: cards flip up into place row by row (3D, staggered
     by column) and the three columns then drift at different speeds while the grid passes (parallax)
   - community banner: the studio photo slowly zooms; gallery tiles drift at alternating speeds */
function podcastScroll() {
  onPage(() => {
    if (prefersReducedMotion()) return;
    const kill: (() => void)[] = [];
    const add = (a: gsap.core.Animation | ScrollTrigger) => kill.push(() => { (a as ScrollTrigger).kill?.(); });

    const heroImg = document.querySelector<HTMLElement>('.pc-hero__img img');
    const heroText = document.querySelector<HTMLElement>('.pc-hero__grid > div:first-child');
    if (heroImg) add(gsap.fromTo(heroImg, { scale: 1.12 }, { scale: 1, yPercent: 6, ease: 'none', scrollTrigger: { trigger: '.pc-hero', start: 'top top', end: 'bottom top', scrub: true } }));
    if (heroText) add(gsap.to(heroText, { y: -60, opacity: 0.2, ease: 'none', scrollTrigger: { trigger: '.pc-hero', start: 'center top+=30%', end: 'bottom top', scrub: true } }));


    const cards = gsap.utils.toArray<HTMLElement>('[data-ep]');
    if (cards.length) {
      gsap.set(cards, { opacity: 0, y: 90, rotateX: -22, transformOrigin: '50% 100%' });
      add(ScrollTrigger.batch(cards, {
        start: 'top 90%', once: true,
        onEnter: (batch) => gsap.to(batch, { opacity: 1, y: 0, rotateX: 0, duration: 1.1, ease: 'expo.out', stagger: 0.12, clearProps: 'transform' }),
      }) as unknown as ScrollTrigger);
      const grid = document.querySelector<HTMLElement>('[data-eps-grid]');
      if (grid && matchMedia('(min-width: 1000px)').matches) {
        const shifts = [0, -70, -25];
        // parallax rides on the CSS `translate` property (--py), separate from the entrance's transform
        cards.forEach((card, i) => {
          add(gsap.fromTo(card, { '--py': '0px' }, { '--py': `${shifts[i % 3]}px`, ease: 'none', scrollTrigger: { trigger: grid, start: 'top bottom', end: 'bottom top', scrub: 0.8 } }));
        });
      }
    }

    const cb = document.querySelector<HTMLElement>('.pc-cb__bg img');
    if (cb) add(gsap.fromTo(cb, { scale: 1.18 }, { scale: 1, ease: 'none', scrollTrigger: { trigger: '.pc-cb', start: 'top bottom', end: 'bottom top', scrub: true } }));

    gsap.utils.toArray<HTMLElement>('.pc-gal__item').forEach((el, i) => {
      add(gsap.fromTo(el, { y: i % 2 ? 40 : 0 }, { y: i % 2 ? -20 : 0, ease: 'none', scrollTrigger: { trigger: el, start: 'top bottom', end: 'bottom top', scrub: true } }));
    });

    return () => kill.forEach((f) => f());
  });
}

/* Floating mini player: slides in after the hero as a pill; opens into a player with shelves. Picking an item loads
   it on the stage (poster first, the embed once played), "Play next" walks the active shelf, Escape or the chevron
   minimises, the x dismisses for this visit (a small lime tab brings it back). */
function miniPlayer() {
  onPage(() => {
    const mp = document.querySelector<HTMLElement>('[data-mp]');
    if (!mp) return;
    const $ = <T extends Element>(s: string) => mp.querySelector<T>(s)!;
    const panel = $<HTMLElement>('[data-mp-panel]'), pill = $<HTMLButtonElement>('[data-mp-open]');
    const stage = $<HTMLElement>('[data-mp-stage]'), poster = $<HTMLImageElement>('[data-mp-poster]');
    const back = document.querySelector<HTMLButtonElement>('[data-mp-back]');
    const offs: (() => void)[] = [];
    const on = (el: EventTarget, ev: string, fn: (e: any) => void) => { el.addEventListener(ev, fn); offs.push(() => el.removeEventListener(ev, fn)); };
    let cur = '';
    let shelf = 'next';
    const store = (k: string, v?: string) => { try { return v === undefined ? sessionStorage.getItem(k) : sessionStorage.setItem(k, v); } catch { return null; } };

    const setOpen = (open: boolean) => {
      mp.classList.toggle('is-open', open); panel.hidden = !open; pill.setAttribute('aria-expanded', String(open));
      if (open) $<HTMLElement>('[data-mp-min]').focus({ preventScroll: true });
    };
    const stopVideo = () => stage.querySelector('iframe')?.remove();
    const playEmbed = () => {
      stopVideo();
      const f = document.createElement('iframe');
      f.src = `https://www.youtube-nocookie.com/embed/${cur}?autoplay=1&rel=0&modestbranding=1&playsinline=1`;
      f.title = $<HTMLElement>('[data-mp-title]').textContent || 'WiseUp Podcast';
      f.allow = 'autoplay; encrypted-media; picture-in-picture; fullscreen'; f.allowFullscreen = true;
      stage.appendChild(f);
      $<HTMLElement>('[data-mp-pkick]').textContent = 'Now playing';
    };
    const load = (btn: HTMLElement, autoplay: boolean) => {
      cur = btn.dataset.mpItem!;
      const d = btn.dataset;
      poster.src = d.img!; $<HTMLElement>('[data-mp-title]').textContent = d.title!;
      $<HTMLElement>('[data-mp-views]').textContent = `${d.views} views`; $<HTMLElement>('[data-mp-likes]').textContent = `${d.likes} likes`;
      $<HTMLAnchorElement>('[data-mp-yt]').href = d.short ? `https://www.youtube.com/shorts/${cur}` : `https://www.youtube.com/watch?v=${cur}`;
      $<HTMLImageElement>('[data-mp-pthumb]').src = d.img!.replace(/(\.webp)$/, d.short ? '$1' : '-sm$1');
      $<HTMLElement>('[data-mp-ptitle]').textContent = d.title!;
      mp.querySelectorAll('[data-mp-item]').forEach((b) => b.classList.toggle('is-current', (b as HTMLElement).dataset.mpItem === cur));
      stopVideo();
      if (autoplay) playEmbed();
    };
    const items = (id = shelf) => [...mp.querySelectorAll<HTMLElement>(`[data-mp-list="${id}"] [data-mp-item]`)];
    load(items()[0], false);

    on(pill, 'click', () => setOpen(true));
    mp.querySelectorAll('[data-mp-min]').forEach((b) => on(b, 'click', () => setOpen(false)));
    mp.querySelectorAll('[data-mp-close]').forEach((b) => on(b, 'click', () => {
      stopVideo(); setOpen(false); mp.classList.remove('is-in'); store('wu-mp-closed', '1'); if (back) back.hidden = false;
    }));
    if (back) on(back, 'click', () => { back.hidden = true; store('wu-mp-closed', '0'); mp.classList.add('is-in'); setOpen(true); });
    on($('[data-mp-play]'), 'click', playEmbed);
    on($('[data-mp-next]'), 'click', () => {
      const list = items(); const i = list.findIndex((b) => b.dataset.mpItem === cur);
      load(list[(i + 1) % list.length], true);
    });
    mp.querySelectorAll<HTMLButtonElement>('[data-mp-tab]').forEach((t) => on(t, 'click', () => {
      shelf = t.dataset.mpTab!;
      mp.querySelectorAll('[data-mp-tab]').forEach((x) => x.setAttribute('aria-selected', String(x === t)));
      mp.querySelectorAll<HTMLElement>('[data-mp-list]').forEach((l) => { l.hidden = l.dataset.mpList !== shelf; });
    }));
    mp.querySelectorAll<HTMLElement>('[data-mp-item]').forEach((b) => on(b, 'click', () => load(b, true)));
    on(mp, 'keydown', (e: KeyboardEvent) => { if (e.key === 'Escape' && mp.classList.contains('is-open')) { setOpen(false); pill.focus(); } });

    // slide in after the hero, unless dismissed this visit
    const hero = document.querySelector('.pc-hero');
    const st = ScrollTrigger.create({
      trigger: hero || document.body, start: 'bottom 60%',
      onEnter: () => { if (store('wu-mp-closed') === '1') { if (back) back.hidden = false; } else mp.classList.add('is-in'); },
      onLeaveBack: () => { if (!mp.classList.contains('is-open')) mp.classList.remove('is-in'); },
    });
    offs.push(() => st.kill());
    return () => { offs.forEach((f) => f()); stopVideo(); };
  });
}

/* Host cards turn in 3D with scroll: entering, the outer cards are angled inward (a half-open triptych) and tilted
   back; at the centre of the viewport they lie flat; leaving, they tip the other way. Scrubbed, desktop and phones. */
function hostCards3d() {
  onPage(() => {
    const cards = gsap.utils.toArray<HTMLElement>('.pc-person__card');
    if (!cards.length || prefersReducedMotion()) return;
    const wide = matchMedia('(min-width: 600px)').matches;
    const tws = cards.map((card, i) => {
      const side = wide ? (i === 0 ? 1 : i === cards.length - 1 ? -1 : 0) : 0;
      return gsap.timeline({ scrollTrigger: { trigger: card, start: 'top bottom', end: 'bottom top', scrub: 0.8 } })
        .fromTo(card, { rotateY: side * 26, rotateX: 14, z: -60 }, { rotateY: 0, rotateX: 0, z: 0, ease: 'power2.out', duration: 1 })
        .to(card, { rotateY: -side * 10, rotateX: -10, z: -30, ease: 'power1.in', duration: 1 });
    });
    return () => tws.forEach((t) => { t.scrollTrigger?.kill(); t.kill(); });
  });
}
