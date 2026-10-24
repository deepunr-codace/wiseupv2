# Change log: Claude (AI pair) on wiseupv2

A record of the changes made by Claude in this repo, so other teams working on `main` can see what changed and where.
Every entry is a commit on `main` authored **Claude**; run `git show <hash>` for the full diff. Newer commits by other
authors (for example `1ad13ee`, Deepu, shared footer) are not listed here.

- Commits: 73, from 2026-10-23 18:35 to 2026-10-24 00:31
- Branch: `main` (pushed directly, no PRs)

## Things to know before you edit

- **Theme**: dark is the default (`defaultTheme` in `src/layouts/Base.astro`); the visitor's choice is stored in `localStorage` key `wu-theme`.
- **Layout tokens**: content width and gutters now match the header everywhere: `--maxw: 1360px`, `--gx` 40 / 24 / 16px (desktop / <992px / <768px), set near the end of `src/styles/site.css` ("Responsive pass"). Phone section rhythm is 44px.
- **Many styles are appended at the end of `src/styles/site.css` and `src/styles/podcast.css`** as labelled blocks (later rules intentionally override earlier ones). Search for the block comment before editing a component.
- **Lead popup**: `src/components/LeadModal.astro` + `src/styles/lead.css` + `src/motion/lead.ts`, rendered on every page from `Base.astro`. **Form action is not wired yet**: set `const action` in `LeadModal.astro` or define `window.WISEUP_LEAD = { endpoint, nonce }`; until then sending opens WhatsApp with the details.
- **Podcast data**: `scripts/fetch-episodes.py` pulls the YouTube channel's long-form feed into `src/data/episodes.json` (+ thumbnails in `public/podcast/ep/`) and the top Shorts into `src/data/shorts.json`. Rerun it to refresh; it does not run on its own.
- **Hero strip videos** (`src/data/reels.ts`) stream from `wiseup.in/wp-content/uploads`; posters for portfolio videos are frames saved in `public/strip/`.
- **Podcast motion** lives in `src/motion/podcast.ts` (featured stack, scroll effects, host 3D, gallery lightbox, testimonial videos); home motion in `src/motion/main.ts` (hero strip pin/flatten, header dock).

## Home page (/)

- `8fc1272` 2026-10-23 18:38: Hero: remove category line, larger wordmark  
  Files: `src/pages/index.astro`, `src/styles/site.css`
- `a50d2ca` 2026-10-23 18:41: Hero wordmark: much larger; entrance hop wave, glossy light sweep, hover colour wave + letter kicks, click ripple, 3D pointer tilt  
  Files: `src/motion/hero-type.ts`, `src/styles/site.css`
- `4409a15` 2026-10-23 18:49: Hero heading as real Lobster text (3D extruded, animated); light hero: aurora, dotted grid, soft ground shadow  
  Files: `public/fonts/lobster-latin-400.woff2`, `src/motion/hero-mark.ts`, `src/motion/main.ts`, `src/pages/index.astro`, `src/styles/site.css`
- `bb81f00` 2026-10-23 19:00: Hero rebuilt in the Lunar template layout: WiseUp wordmark SVG (converted from the reference), subtitle, orbit dot, tilted strip; dark exact + light black-wordmark alternative  
  Files: `public/brand/hero-wiseup-lunar-logo-big.svg`, `public/fonts/unbounded-latin-wght.woff2`, `scripts/fonts/Unbounded-wght340.ttf`, `scripts/make-lunar-wordmark.mjs`, `src/motion/hero-lunar.ts`, `src/motion/main.ts` +2 more
- `c6048e9` 2026-10-23 19:25: Hero wordmark: round i-dot  
  Files: `public/brand/hero-wiseup-lunar-logo-big.svg`, `scripts/make-lunar-wordmark.mjs`, `src/pages/index.astro`, `src/styles/site.css`
- `763a0c9` 2026-10-23 19:28: Hero wordmark: narrower w, glowing breathing i-dot, per-letter entrance, light sweep, pointer tilt and letter lift  
  Files: `public/brand/hero-wiseup-lunar-logo-big.svg`, `scripts/fonts/Syne-wght540.ttf`, `scripts/make-lunar-wordmark.mjs`, `src/motion/hero-lunar.ts`, `src/pages/index.astro`, `src/styles/site.css`
- `27c1b55` 2026-10-23 19:32: Process cards: inset photo frame, outlined step number, case tag, arrow chip, pointer spotlight rim, hover zoom and progress bar  
  Files: `src/motion/main.ts`, `src/pages/index.astro`, `src/styles/site.css`
- `4eb93ef` 2026-10-23 19:35: Home page: one shared size for all section headings (--h-sec)  
  Files: `src/styles/site.css`
- `77b58cd` 2026-10-23 19:44: Brand lime #BEDA52 everywhere (mint removed); lime marker/underlines on key words, tilted lime tag chips, rotating Since 2018 sticker, lime blobs  
  Files: `public/brand/hero-wiseup-lunar-logo-big.svg`, `scripts/make-lunar-wordmark.mjs`, `src/components/SecHead.astro`, `src/data/site.ts`, `src/motion/main.ts`, `src/pages/index.astro` +1 more
- `81cb337` 2026-10-23 19:47: Home: move What we do (services) to right after the hero  
  Files: `src/pages/index.astro`
- `116c7c9` 2026-10-23 19:48: Voice section: remove large empty space above and below the headline  
  Files: `src/styles/site.css`
- `52a0b7a` 2026-10-23 19:51: Remove lime highlights, hand-drawn underlines and the Since 2018 sticker; accent lines in deep lime  
  Files: `src/data/site.ts`, `src/pages/index.astro`, `src/styles/site.css`
- `1e976b1` 2026-10-23 19:54: Services drum: bold green words, lifted 50px  
  Files: `src/styles/site.css`
- `60ff886` 2026-10-23 19:57: Home: move Selected work up, right after the voice section  
  Files: `src/pages/index.astro`
- `79061ab` 2026-10-23 20:01: Section tag chips: straight (no tilt)  
  Files: `src/styles/site.css`
- `6e8dba6` 2026-10-23 20:24: CodeAce morph: C turns into the wordmark w and back; mobile/tablet fixes  
  Files: `src/motion/main.ts`, `src/pages/index.astro`, `src/styles/podcast.css`, `src/styles/site.css`
- `4a590d5` 2026-10-23 21:49: Process: illustrated cards with the three step images  
  Files: `public/process/step-1-sm.webp`, `public/process/step-1.webp`, `public/process/step-2-sm.webp`, `public/process/step-2.webp`, `public/process/step-3-sm.webp`, `public/process/step-3.webp` +3 more
- `522d2b2` 2026-10-23 23:07: Hero strip: video reels that show whole and play on hover; simpler process cards  
  Files: `public/strip/abc-juice.webp`, `public/strip/ai-branding.webp`, `public/strip/bootland.webp`, `public/strip/cellar.webp`, `public/strip/cgi-1.webp`, `public/strip/cgi-2.webp` +8 more

## Header

- `1d6f174` 2026-10-23 19:22: Hero wordmark rebuilt from Syne (the Lunar logo's typeface), lowercase 'wiseup'; hero, header and slider set to the template's measured values; cursor dot  
  Files: `public/brand/hero-wiseup-lunar-logo-big.svg`, `scripts/fonts/Syne-wght470.ttf`, `scripts/fonts/Unbounded-wght340.ttf`, `scripts/make-lunar-wordmark.mjs`, `src/motion/hero-lunar.ts`, `src/motion/main.ts` +2 more
- `044479a` 2026-10-23 20:06: Header logo: back-to-top on home, link home on other pages (no #top there)  
  Files: `src/components/Header.astro`
- `b0e5c97` 2026-10-23 20:43: Podcast header: YouTube subscribe pill instead of the plan CTA  
  Files: `src/components/Header.astro`, `src/styles/site.css`
- `5f4ebcb` 2026-10-23 21:22: Header: logo docks into a dark pill once the page scrolls  
  Files: `src/motion/main.ts`, `src/styles/site.css`
- `9808612` 2026-10-23 21:27: Header dock: one dark bar behind the whole header on scroll  
  Files: `src/styles/site.css`
- `414ae21` 2026-10-23 21:33: Header dock: 3D slab instead of the lime ring; theme switcher sized to the buttons  
  Files: `src/styles/site.css`
- `95f5398` 2026-10-23 21:55: Header: hide fully on scroll down (clear the docked bar and its shadow)  
  Files: `src/styles/site.css`
- `c3dec37` 2026-10-23 22:49: Header plain bar + hides after clicks; podcast testimonials and gallery tweaks  
  Files: `src/motion/main.ts`, `src/styles/podcast.css`, `src/styles/site.css`

## Lead popup (site-wide)

- `0cb9944` 2026-10-23 21:47: Lead popup on every page  
  Files: `src/components/LeadModal.astro`, `src/layouts/Base.astro`, `src/motion/lead.ts`, `src/motion/main.ts`, `src/styles/lead.css`
- `bdda534` 2026-10-23 22:05: Lead popup: flat, professional footer and a new chat-bubble mascot  
  Files: `src/components/LeadModal.astro`, `src/styles/lead.css`
- `e54d50a` 2026-10-23 23:11: Lead popup fits every screen with no scrollbar; launcher is icon-only  
  Files: `src/styles/lead.css`
- `7bf3aaa` 2026-10-23 23:30: Lead popup: fuller left column, roomier form  
  Files: `src/components/LeadModal.astro`, `src/styles/lead.css`

## Podcast page (/podcast)

- `4cc66f3` 2026-10-23 20:07: Podcast hero: Malayalam line uses the full column width  
  Files: `src/styles/podcast.css`
- `518c3c5` 2026-10-23 20:15: Podcast: rebuild on the home design system  
  Files: `src/pages/podcast.astro`, `src/styles/podcast.css`
- `68a0094` 2026-10-23 20:25: Podcast hosts: three hosts in one row, guest card removed  
  Files: `src/pages/podcast.astro`, `src/styles/podcast.css`
- `f15a664` 2026-10-23 20:29: Podcast hosts: editorial captions  
  Files: `src/pages/podcast.astro`, `src/styles/podcast.css`
- `b9b59c0` 2026-10-23 20:32: Podcast: YouTube play button over every video thumbnail  
  Files: `src/pages/podcast.astro`, `src/styles/podcast.css`
- `b169e69` 2026-10-23 20:34: Podcast hero: trimmed to heading, Malayalam line, buttons and proof  
  Files: `src/pages/podcast.astro`, `src/styles/podcast.css`
- `279b6e6` 2026-10-23 20:36: Podcast: full YouTube channel banner after Latest episodes  
  Files: `public/podcast/channel-banner-sm.webp`, `public/podcast/channel-banner.webp`, `src/pages/podcast.astro`, `src/styles/podcast.css`
- `56028ed` 2026-10-23 20:37: Podcast: gallery section with lightbox  
  Files: `src/motion/podcast.ts`, `src/pages/podcast.astro`, `src/styles/podcast.css`
- `b331588` 2026-10-23 20:39: Podcast hero: soft off-white backdrop shapes  
  Files: `src/styles/podcast.css`
- `eca221c` 2026-10-23 20:42: Podcast page: full-colour WiseUp Podcast logo in the header  
  Files: `src/assets/brand/podcast-logo.png`, `src/components/Header.astro`, `src/styles/site.css`
- `1ff014f` 2026-10-23 20:46: Podcast: video testimonials section  
  Files: `src/motion/podcast.ts`, `src/pages/podcast.astro`, `src/styles/podcast.css`
- `179ca21` 2026-10-23 20:47: Podcast hero: solid off-white background, edge to edge  
  Files: `src/styles/podcast.css`
- `3efc6db` 2026-10-23 20:49: Podcast hero: off-white fill starts below the header, more room above content  
  Files: `src/styles/podcast.css`
- `21509b6` 2026-10-23 20:51: Podcast hero: animated podcast icons  
  Files: `src/pages/podcast.astro`, `src/styles/podcast.css`
- `2c189c6` 2026-10-23 20:55: Podcast hero: off-white fills behind the header again; more top padding  
  Files: `src/styles/podcast.css`
- `ddf120a` 2026-10-23 21:50: Podcast gallery: the nine real shoot photos  
  Files: `public/podcast/gallery/g1-sm.webp`, `public/podcast/gallery/g1.webp`, `public/podcast/gallery/g2-sm.webp`, `public/podcast/gallery/g2.webp`, `public/podcast/gallery/g3-sm.webp`, `public/podcast/gallery/g3.webp` +14 more
- `2c0608b` 2026-10-23 22:03: Phones: paired buttons share a row; compact buttons and pills  
  Files: `src/styles/podcast.css`, `src/styles/site.css`
- `c139473` 2026-10-23 22:13: Section pills: black on light pages, white on dark, so they don't echo the lime buttons  
  Files: `src/styles/podcast.css`, `src/styles/site.css`
- `307b416` 2026-10-23 22:54: Podcast: community banner rebuilt as live HTML over the studio photo  
  Files: `public/podcast/community-bg-m.webp`, `public/podcast/community-bg-sm.webp`, `public/podcast/community-bg.webp`, `src/pages/podcast.astro`, `src/styles/podcast.css`
- `fa2a636` 2026-10-23 23:14: Podcast topics: redesigned in the site style  
  Files: `src/pages/podcast.astro`, `src/styles/podcast.css`
- `a6fa8eb` 2026-10-23 23:15: Podcast hosts: name only, no title line  
  Files: `src/pages/podcast.astro`
- `ee1d9a7` 2026-10-23 23:17: Podcast testimonials: play control moved off the face to a bottom-left 'Watch story' pill  
  Files: `src/pages/podcast.astro`, `src/styles/podcast.css`
- `4d04743` 2026-10-23 23:19: Podcast latest episodes: nine equal cards  
  Files: `src/pages/podcast.astro`, `src/styles/podcast.css`
- `1c51ad0` 2026-10-23 23:24: Podcast community banner: dark overlay; phone layout tuned  
  Files: `src/styles/podcast.css`
- `95c1076` 2026-10-23 23:27: Podcast featured: a stack of two episode cards  
  Files: `src/motion/podcast.ts`, `src/pages/podcast.astro`, `src/styles/podcast.css`
- `dee82d1` 2026-10-23 23:34: Podcast: 15 real episodes from YouTube; scroll animations; bolder arrows  
  Files: `public/podcast/ep/4J0dfKZoyhs-sm.webp`, `public/podcast/ep/4J0dfKZoyhs.webp`, `public/podcast/ep/6tq1aJsKRyA-sm.webp`, `public/podcast/ep/6tq1aJsKRyA.webp`, `public/podcast/ep/7laWPDIhhAE-sm.webp`, `public/podcast/ep/7laWPDIhhAE.webp` +29 more
- `1ea8630` 2026-10-23 23:34: Podcast FAQ: two columns, sticky heading + studio mic photo on the left  
  Files: `src/pages/podcast.astro`, `src/styles/podcast.css`
- `8b28f5e` 2026-10-23 23:36: Podcast hero: headphones sticker becomes a red YouTube play button  
  Files: `src/pages/podcast.astro`
- `d4d3724` 2026-10-23 23:42: Podcast: FAQ illustration; episodes without marquee or hover lift  
  Files: `src/motion/podcast.ts`, `src/pages/podcast.astro`, `src/styles/podcast.css`
- `4f68d8a` 2026-10-23 23:47: Podcast: floating mini player with shelves  
  Files: `public/podcast/shorts/4rWi3Kn4kW8.webp`, `public/podcast/shorts/BE6ri4DMjkw.webp`, `public/podcast/shorts/OEI5oUxHlGg.webp`, `public/podcast/shorts/OleoefHZMuE.webp`, `public/podcast/shorts/QO2uy3EAHcc.webp`, `public/podcast/shorts/bSuuP_ACvpw.webp` +11 more
- `080ac18` 2026-10-23 23:49: Podcast hosts: diamond-glass edges and a 3D turn on scroll; no hover border  
  Files: `src/motion/podcast.ts`, `src/pages/podcast.astro`, `src/styles/podcast.css`
- `e6f7f66` 2026-10-23 23:52: Podcast featured: three more cards, episodes hosted by Jijin Mohan  
  Files: `src/motion/podcast.ts`, `src/pages/podcast.astro`
- `e3d7884` 2026-10-23 23:57: Podcast: responsive pass  
  Files: `src/pages/podcast.astro`, `src/styles/podcast.css`
- `3a0e875` 2026-10-24 00:00: Podcast: remove the floating mini player  
  Files: `src/components/PodcastPlayer.astro`, `src/motion/podcast.ts`, `src/pages/podcast.astro`, `src/styles/podcast.css`
- `e92d3e2` 2026-10-24 00:10: Podcast hosts: no card shadow in the light theme  
  Files: `src/styles/podcast.css`
- `85e34e3` 2026-10-24 00:11: Podcast community banner: cleaner phone layout  
  Files: `src/styles/podcast.css`
- `7972a9a` 2026-10-24 00:23: Responsive pass across all pages  
  Files: `src/styles/podcast.css`, `src/styles/site.css`

## About & Contact

- `d422d7e` 2026-10-23 19:59: Brand lime hover on service, FAQ and contact rows; lime tint for open items  
  Files: `src/styles/site.css`
- `84dfeb2` 2026-10-23 23:09: About: 'Posts fade. Brands last.' redesigned as a fit test  
  Files: `src/pages/index.astro`, `src/styles/site.css`
- `4dff79c` 2026-10-24 00:31: About and Contact: even section spacing on phones  
  Files: `src/styles/about.css`, `src/styles/site.css`

## Site-wide: theme, responsive, spacing

- `5936125` 2026-10-23 18:35: Hero (light theme): solid green wordmark faces, larger wordmark, stronger labels, lime-tinted glow  
  Files: `src/motion/hero-type.ts`, `src/styles/site.css`
- `279b6b2` 2026-10-23 19:30: Voice headline: responsive size tuned to width and height (36px phone, ~61px laptop, 84px max)  
  Files: `src/styles/site.css`
- `6acfcf0` 2026-10-24 00:26: Dark theme by default; hero strip pins, flattens and offers play-with-sound  
  Files: `src/layouts/Base.astro`, `src/motion/main.ts`, `src/pages/index.astro`, `src/styles/site.css`
