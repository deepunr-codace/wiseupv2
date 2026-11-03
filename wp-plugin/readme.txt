=== Wiseup ===
Contributors: axilume
Requires at least: 6.0
Requires PHP: 7.4
Stable tag: 1.0.0
License: Proprietary

WiseUp's own page templates (Home, About, Contact, Podcast) with their own header, footer, settings and enquiry form.

== Description ==

Adds four page templates: WiseUp: Home, WiseUp: About, WiseUp: Contact and WiseUp: Podcast. A page using one of them
is rendered entirely by this plugin, with its own header, footer, styles and scripts, so the active theme's styles
don't affect it and it keeps working after a theme switch.

Settings live under wp-admin → Wiseup:

* Dashboard: which pages use each template, and a button to create each page.
* General: default dark/light mode, which header and footer WiseUp pages use (WiseUp's own, the theme's, or none),
  the lead popup, and where enquiries are emailed.
* Header: dark/light toggle, logos, the header button, the podcast page's Subscribe pill.
* Footer: texts, both social link sets, the podcast channel card, the particle wordmark, copyright and credit.

Each page can override the header and footer choice in its "WiseUp header & footer" box. The header and footer link
lists come from menus assigned under Appearance → Menus (WiseUp: header links / footer Quick Links / footer Useful
Links), falling back to the built-in links.

== Installation ==

1. Plugins → Add New → Upload Plugin, choose wiseup.zip, Install, Activate.
2. Wiseup → Dashboard → Create page for each template (or set Page → Template on existing pages).
3. Publish the pages. Make the Home page the homepage under Settings → Reading, and keep About, Contact and Podcast at
   /about/, /contact/ and /podcast/ (the pages link to each other at those addresses).

If the older WiseUp Contact Mail plugin is active, it can be deactivated: this plugin includes the enquiry endpoint.
If the theme still has the older template-wiseup-*.php files and wiseup-assets folder, delete them once every page
uses the "WiseUp: …" templates.
