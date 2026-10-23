// WiseUp Podcast (/podcast): the only truly page-specific behaviour left after the rebuild onto
// the homepage's own design system — click-to-embed thumbnails. Everything else (reveals, the
// episode filmstrip, the hosts/guests loop, stat counters) now runs on the shared engine's own
// mechanisms (horizontalGallery(), loopedPanels(), aboutCounters()) via the same data attributes
// the homepage uses, so there's nothing page-specific left to duplicate for them.
import { onPage } from '../engine';

export function setupPodcast() {
  embedThumbnails();
  galleryLightbox();
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
