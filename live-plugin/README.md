# Live WordPress plugin (snapshot)

`wiseup/` is a copy of the **live** "Wiseup" WordPress plugin as it runs on the site (taken from the local WordPress
install on 2026-11-03). Several features exist only here, not in the Astro source: the live homepage hero (Lunar
wordmark, hover effects), the landing pages (social media, SEO, performance, services, blog), the mega menu ropes, etc.

To deploy: upload the `wiseup/` folder to `wp-content/plugins/` on the server (or zip it and use Plugins → Add New →
Upload), then clear the WP Rocket cache.

Note: `npm run wp:plugin` builds a plugin from the Astro source into `../wiseup-plugin/`; that build does NOT contain
the live-only changes above, so do not replace this folder with it.

Phones only, also live-only: the homepage's extra scroll choreography (`wiseup/assets/js/home-mobile.js` and
`wiseup/assets/css/home-mobile.css`, loaded from `includes/render.php` below 768px and without reduced motion). It
runs beside the site script without touching the elements' own transforms; see the comments at the top of both files.

Homepage speed work (2026-11-03), all live-only. Measured with Lighthouse 13 on PageSpeed Insights' mobile settings
against a local copy of the plugin served with gzip and long cache headers: 51 before, 93-95 after (desktop 100).
- The site bundle (`wiseup/assets/_astro/Base.astro_…js`) is patched in one place, function `Bc` (marked "WiseUp plugin
  patch"): scroll reveals are set up when their section comes within 60% of a screen of view, instead of all at boot.
  That was about half a second of main-thread work on a phone. If the bundle is rebuilt, re-apply that change.
  `generated/manifest.php`'s `build` was bumped so browsers fetch the patched file.
- `includes/render.php`: Figtree is self-hosted (`assets/fonts/figtree-latin-400_800.woff2`) instead of loaded from
  Google Fonts; the phone spacing stylesheet is inlined; on the homepage the hero strip is visible from the first paint
  (it was faded in by the script, which held the LCP back), its track starts at the drift's own start offset (no layout
  shift), the site bundle is fetched once the document has been parsed, and the phone motion layer once the visitor
  first touches or scrolls.
- `wiseup_page_html()` in `includes/render.php` adjusts the generated homepage at render time: the strip cards on the
  first screen load with the page (two with `fetchpriority="high"`), the rest of the strip's images get their address
  once the page has loaded.
- `parts/footer.php`: the dot wordmark's script is fetched once the footer is a couple of screens away.
