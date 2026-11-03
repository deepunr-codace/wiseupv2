# Live WordPress plugin (snapshot)

`wiseup/` is a copy of the **live** "Wiseup" WordPress plugin as it runs on the site (taken from the local WordPress
install on 2026-11-03). Several features exist only here, not in the Astro source: the live homepage hero (Lunar
wordmark, hover effects), the landing pages (social media, SEO, performance, services, blog), the mega menu ropes, etc.

To deploy: upload the `wiseup/` folder to `wp-content/plugins/` on the server (or zip it and use Plugins → Add New →
Upload), then clear the WP Rocket cache.

Note: `npm run wp:plugin` builds a plugin from the Astro source into `../wiseup-plugin/`; that build does NOT contain
the live-only changes above, so do not replace this folder with it.
