// WiseUp Podcast (/podcast): the only truly page-specific behaviour left after the rebuild onto
// the homepage's own design system — click-to-embed thumbnails. Everything else (reveals, the
// episode filmstrip, the hosts/guests loop, stat counters) now runs on the shared engine's own
// mechanisms (horizontalGallery(), loopedPanels(), aboutCounters()) via the same data attributes
// the homepage uses, so there's nothing page-specific left to duplicate for them.
import { onPage } from '../engine';

export function setupPodcast() {
  embedThumbnails();
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
