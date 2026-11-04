<?php
/**
 * Output for WiseUp pages: the head (fonts, styles, the theme-restore script) and the footer scripts, hooked into
 * wp_head / wp_footer so they work the same whether the page prints its own document or uses the theme's header.
 * What each page needs comes from generated/manifest.php, written by the build (scripts/build-wp-plugin.mjs).
 */
defined( 'ABSPATH' ) || exit;

function wiseup_manifest() {
	static $manifest = null;
	if ( null === $manifest ) $manifest = require WISEUP_DIR . 'generated/manifest.php';
	return $manifest;
}

function wiseup_manifest_page( $slug ) {
	$m = wiseup_manifest();
	return isset( $m['pages'][ $slug ] ) ? $m['pages'][ $slug ] : null;
}

function wiseup_asset( $path ) {
	return WISEUP_URL . 'assets/' . ltrim( $path, '/' );
}

/** Asset URL with a cache-busting version that changes on every build. */
function wiseup_versioned( $path ) {
	return add_query_arg( 'ver', wiseup_manifest()['build'], wiseup_asset( $path ) );
}

/**
 * Small render-time adjustments to a generated page body (generated/pages/{slug}.php), kept here so a rebuild of those
 * files doesn't lose them.
 *
 * Homepage hero strip: only the cards on the first screen load with the page. With the track's CSS start offset (one
 * set in, see the head) and the plane's tilt, those are the 8th to 10th cards of the last set at every screen width;
 * the 8th and 9th fill most of a phone's first screen (one of them is the page's LCP), so they get fetchpriority="high"
 * and the default decoding (decoding="async" let the browser paint them a few frames after they had arrived). Every
 * other card's image holds its address in data-wu-src / data-wu-srcset until the page has loaded or the visitor first
 * touches it (wiseup_home_strip_images() below), so 30-odd posters, several of them large, don't compete with the first
 * screen; the drift takes seconds to bring the next card in. If the cards change and the indexes no longer match the
 * first screen, nothing breaks: those cards just fill in a moment later.
 */
function wiseup_page_html( $slug, $html ) {
	// Lead popup: when a dialog opens the browser focuses its first field, which on a phone pops the keyboard up in the
	// middle of the entrance. autofocus on the close button gives that first focus to a button instead (mouse and
	// keyboard users still land in the first field: the site script focuses it for them).
	$html = str_replace( '<button class="lead__close" type="button"', '<button class="lead__close" type="button" autofocus', $html );
	if ( 'home' === $slug && preg_match( '#data-strip-track[^>]*data-sets="(\d+)"#', $html, $sets ) ) {
		$count = preg_match_all( '#<figure class="strip__card#', $html );
		$per   = max( 1, intdiv( $count, max( 1, (int) $sets[1] ) ) );
		$base  = $count - $per;
		$i     = -1;
		$html  = preg_replace_callback( '#<figure class="strip__card.*?</figure>#s', function ( $m ) use ( &$i, $base ) {
			$i++;
			$card = str_replace( ' loading="lazy"', ' loading="eager"', $m[0] );
			if ( $i === $base + 7 || $i === $base + 8 ) return preg_replace( '#<img #', '<img fetchpriority="high" ', str_replace( ' decoding="async"', '', $card ), 1 );
			if ( $i === $base + 9 ) return $card;
			return preg_replace( '#(<img\b[^>]*?) (src|srcset)="#', '$1 data-wu-$2="', preg_replace( '#(<img\b[^>]*?) (src|srcset)="#', '$1 data-wu-$2="', $card ) );
		}, $html );
	}
	return $html;
}

/** Homepage: gives the held-back hero strip images (see wiseup_page_html()) their addresses once the page has loaded. */
function wiseup_home_strip_images() {
	echo "<script>(function(){var done=0,go=function(){if(done)return;done=1;document.querySelectorAll('img[data-wu-src],img[data-wu-srcset]').forEach(function(i){if(i.dataset.wuSrcset){i.srcset=i.dataset.wuSrcset;i.removeAttribute('data-wu-srcset');}if(i.dataset.wuSrc){i.src=i.dataset.wuSrc;i.removeAttribute('data-wu-src');}});};if(document.readyState==='complete')go();else addEventListener('load',go,{once:true});['touchstart','pointerdown','scroll','keydown'].forEach(function(e){addEventListener(e,go,{once:true,passive:true});});})();</script>\n";
}

/** Includes a header/footer part with the current page's slug available as $wu_slug. */
function wiseup_part( $name ) {
	$wu_slug = wiseup_page_slug();
	include WISEUP_DIR . 'parts/' . $name . '.php';
}

add_action( 'wp_head', function () {
	$slug = wiseup_page_slug();
	if ( ! $slug ) return;
	$page = wiseup_manifest_page( $slug );
	$m = wiseup_manifest();

	if ( ! current_theme_supports( 'title-tag' ) && 'theme' !== wiseup_part_source( 'header' ) ) {
		echo '<title>' . esc_html( wp_get_document_title() ) . "</title>\n";
	}
	if ( ! wiseup_has_seo_plugin() && $page ) {
		echo '<meta name="description" content="' . esc_attr( html_entity_decode( $page['description'], ENT_QUOTES, 'UTF-8' ) ) . "\">\n";
	}
	if ( ! has_site_icon() ) {
		echo '<link rel="icon" href="' . esc_url( wiseup_asset( 'favicon.svg' ) ) . "\" type=\"image/svg+xml\">\n";
	}
	foreach ( array( 'fonts/inter-300_700-normal.woff2', 'fonts/outfit-200_500-normal.woff2' ) as $font ) {
		echo '<link rel="preload" href="' . esc_url( wiseup_asset( $font ) ) . "\" as=\"font\" type=\"font/woff2\" crossorigin>\n";
	}
	if ( $page && $page['extra_head'] ) {
		$extra = $page['extra_head'];
		// Figtree is served from the plugin (assets/fonts, one variable file for 400-800, latin) instead of Google Fonts:
		// the Google stylesheet blocked the first paint and cost two extra connections before anything could show.
		if ( false !== strpos( $extra, 'family=Figtree' ) ) {
			$extra = preg_replace( '#<link[^>]+fonts\.(googleapis|gstatic)\.com[^>]*>\s*#', '', $extra );
			$extra .= "<style>@font-face{font-family:'Figtree';font-style:normal;font-weight:400 800;font-display:swap;src:url('" . esc_url( wiseup_asset( 'fonts/figtree-latin-400_800.woff2' ) ) . "') format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}</style>";
		}
		echo $extra . "\n"; // phpcs:ignore -- static markup from the build (font links)
	}
	foreach ( $page ? $page['css'] : array( 'wiseup.css' ) as $css ) {
		echo '<link rel="stylesheet" href="' . esc_url( wiseup_versioned( 'css/' . $css ) ) . "\">\n";
	}
	$plugin_css = file_get_contents( WISEUP_DIR . 'assets/css/plugin.css' );
	if ( false !== $plugin_css ) {
		echo "<style id=\"wiseup-plugin-css\">\n" . $plugin_css . "\n</style>\n"; // Static plugin stylesheet; inlining avoids a separate render-blocking request.
	}
	if ( 'home' === $slug ) {
		// Phones only: one spacing scale for every homepage section (assets/css/home-mobile-layout.css), inlined so it
		// costs no extra render-blocking request.
		$layout_css = file_get_contents( WISEUP_DIR . 'assets/css/home-mobile-layout.css' );
		if ( false !== $layout_css ) echo "<style id=\"wiseup-home-mobile-layout\">\n" . $layout_css . "\n</style>\n"; // phpcs:ignore -- static plugin stylesheet
		// The hero strip is the page's largest first-screen element (its LCP). The site script fades it in from invisible
		// after it has loaded and run, which held the LCP back by seconds on phones; it is shown from the first paint
		// instead (the cards still drift, flatten and play as before).
		// Its looping track holds identical sets and the drift starts one set in (x = -set width); starting it there in CSS
		// too means the first frame of the drift doesn't jump it, which counted as a full-screen layout shift. While the
		// track's markup is still arriving that offset would be wrong, so the strip waits until something after it in the
		// hero has been parsed (or, failing that, the whole document: html.wu-parsed, set at the end of the body).
		echo "<style id=\"wiseup-home-lcp\">.wiseup-page-home [data-strip]{opacity:1!important;visibility:visible!important}"
			. 'html:not(.wu-parsed) .wiseup-page-home .hero:not(:has(> [data-strip] ~ *)) > [data-strip]{visibility:hidden!important}'
			. '.wiseup-page-home [data-strip-track][data-sets="2"]{transform:translateX(-50%)}'
			. '.wiseup-page-home [data-strip-track][data-sets="3"]{transform:translateX(-33.3333%)}'
			. '.wiseup-page-home [data-strip-track][data-sets="4"]{transform:translateX(-25%)}'
			. "</style>\n";
	}
	// Restores the visitor's saved light/dark choice before first paint; first-time visitors get the default theme.
	echo str_replace( '__WISEUP_DEFAULT_THEME__', wp_json_encode( 'light' === wiseup_opt( 'default_theme' ) ? 'light' : 'dark' ), $m['head_script'] ) . "\n"; // phpcs:ignore -- static script from the build
}, 5 );

// The document has been parsed (see the hero strip note in the head above), and the held-back strip images.
add_action( 'wp_footer', function () {
	if ( 'home' !== wiseup_page_slug() ) return;
	echo "<script>document.documentElement.classList.add('wu-parsed')</script>\n";
	wiseup_home_strip_images();
}, 1 );

add_action( 'wp_footer', function () {
	if ( ! wiseup_page_slug() ) return;
	// The enquiry endpoint (includes/enquiry.php) for the contact form and the lead popup; without it they fall back
	// to composing a WhatsApp message, never a fake "sent".
	printf(
		"<script>window.WISEUP_CONTACT = { endpoint: %s, nonce: %s };</script>\n",
		wp_json_encode( rest_url( 'wiseup/v1/enquiry' ) ),
		wp_json_encode( wp_create_nonce( 'wp_rest' ) )
	);
	$script = wiseup_versioned( wiseup_manifest()['script'] );
	if ( 'home' === wiseup_page_slug() ) {
		// Homepage: nothing on the first screen waits for the site script (the hero is visible without it), so it is
		// fetched once the document has been parsed, rather than alongside the hero's images and the stylesheet, which
		// it otherwise competed with for the first screen's bandwidth. It still runs after parsing, as a module script
		// would; it just starts downloading then.
		printf( "<script>addEventListener('DOMContentLoaded',function(){var s=document.createElement('script');s.type='module';s.src=%s;document.body.appendChild(s);});</script>\n", wp_json_encode( esc_url_raw( $script ) ) );
		wiseup_home_mobile_motion();
	} else {
		echo '<script type="module" src="' . esc_url( $script ) . "\"></script>\n";
	}
}, 20 );

/**
 * Homepage, every screen size (owner, 2026-11-04; was phones only): the extra scroll motion in assets/js/home-mobile.js (+ its CSS). It runs its own copy of GSAP
 * from assets/js/vendor, loaded only once the site script has booted (html.is-booted), so the two copies never register
 * into each other. Skipped under reduced motion.
 *
 * Everything it does follows the visitor's scrolling, so it is fetched on the first touch, scroll, wheel or key press
 * rather than during page load: the page's first paint and main-thread time stay the site script's alone.
 */
function wiseup_home_mobile_motion() {
	$file = function ( $path ) { return esc_url( WISEUP_URL . 'assets/' . $path . '?ver=' . filemtime( WISEUP_DIR . 'assets/' . $path ) ); };
	$js   = array();
	foreach ( array( 'js/vendor/gsap.min.js', 'js/vendor/ScrollTrigger.min.js', 'js/home-mobile.js' ) as $path ) $js[] = $file( $path );
	printf(
		"<script type=\"module\">(function(){if(matchMedia('(prefers-reduced-motion: reduce)').matches)return;var ev=['touchstart','pointerdown','scroll','wheel','keydown'],done=false;var h=document.documentElement,booted=function(f){if(h.classList.contains('is-booted'))return f();var o=new MutationObserver(function(){if(h.classList.contains('is-booted')){o.disconnect();f();}});o.observe(h,{attributes:true,attributeFilter:['class']});};var go=function(){if(done)return;done=true;ev.forEach(function(e){removeEventListener(e,go,{passive:true})});booted(load);};var load=function(){var l=document.createElement('link');l.rel='stylesheet';l.href=%s;document.head.appendChild(l);var q=%s;(function next(){var u=q.shift();if(!u)return;var s=document.createElement('script');s.src=u;s.onload=next;document.body.appendChild(s);})();};ev.forEach(function(e){addEventListener(e,go,{passive:true})});})();</script>\n",
		wp_json_encode( $file( 'css/home-mobile.css' ) ),
		wp_json_encode( $js )
	);
}

// ---------- Helpers for the parts ----------

function wiseup_logo_url( $podcast ) {
	$custom = wiseup_opt( $podcast ? 'podcast_logo' : 'logo' );
	return $custom ? $custom : wiseup_asset( $podcast ? 'brand/wiseup-podcast-logo.webp' : 'brand/wiseup-logo.webp' );
}

/** href for a social network: email addresses become mailto: links. */
function wiseup_social_href( $network, $value ) {
	if ( 'email' === $network ) return 'mailto:' . sanitize_email( preg_replace( '/^mailto:/i', '', $value ) );
	return $value;
}

/** Inline SVG icons (static markup). Brand marks are the original logos in their own colours. */
function wiseup_icon( $name ) {
	$yt = 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z';
	$line = '<svg class="ico%s" width="%d" height="%d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%s</svg>';
	switch ( $name ) {
		case 'moon':   return sprintf( $line, ' ico--moon', 18, 18, '<path d="M20 14.5A8.5 8.5 0 1 1 9.5 4a7 7 0 0 0 10.5 10.5Z"/>' );
		case 'sun':    return sprintf( $line, ' ico--sun', 18, 18, '<circle cx="12" cy="12" r="4.5"/><path d="M12 2.5v2.3M12 19.2v2.3M21.5 12h-2.3M4.8 12H2.5M18.5 5.5l-1.6 1.6M7.1 16.9l-1.6 1.6M18.5 18.5l-1.6-1.6M7.1 7.1 5.5 5.5"/>' );
		case 'menu':   return sprintf( $line, '', 18, 18, '<path d="M4 8h16M4 16h16"/>' );
		case 'call':   return '<svg class="ico-call" width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>'; // filled phone handset (Material Icons "call", Apache 2.0)
		case 'mail-chip': return '<span class="ft__ci"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4 5h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2zm0 2v.4l8 5 8-5V7H4zm16 2.75-7.47 4.67a1 1 0 0 1-1.06 0L4 9.75V17h16V9.75z"/></svg></span>';
		case 'bulb-chip': return '<span class="ft__ci"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a7 7 0 0 0-4 12.74V17a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2.26A7 7 0 0 0 12 2zm-2 18h4a1 1 0 0 1 0 2h-4a1 1 0 0 1 0-2z"/></svg></span>';
		case 'call-chip': return '<span class="ft__ci"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg></span>';
		case 'pin-chip':  return '<span class="ft__ci"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg></span>';
		case 'phone':  return sprintf( $line, '', 18, 18, '<path d="M6.5 3.5h3l1.5 4.5-2 1.5a12 12 0 0 0 5.5 5.5l1.5-2 4.5 1.5v3a2 2 0 0 1-2 2A16.5 16.5 0 0 1 4.5 5.5a2 2 0 0 1 2-2Z"/>' );
		case 'pin':    return sprintf( $line, '', 18, 18, '<path d="M12 21s-6.5-5.6-6.5-11a6.5 6.5 0 0 1 13 0c0 5.4-6.5 11-6.5 11Z"/><circle cx="12" cy="10" r="2.4"/>' );
		case 'arrow':  return sprintf( $line, '', 16, 16, '<path d="M5 12h14M13.5 6.5 19 12l-5.5 5.5"/>' );
		case 'yt-logo': // the red YouTube logo, 68x48
			return '<svg viewBox="0 0 68 48" aria-hidden="true"><path fill="#f00" d="M66.52 7.74c-.78-2.93-2.49-5.41-5.42-6.19C55.79.13 34 0 34 0S12.21.13 6.9 1.55C3.97 2.33 2.27 4.81 1.48 7.74.06 13.05 0 24 0 24s.06 10.95 1.48 16.26c.78 2.93 2.49 5.41 5.42 6.19C12.21 47.87 34 48 34 48s21.79-.13 27.1-1.55c2.93-.78 4.64-3.26 5.42-6.19C67.94 34.95 68 24 68 24s-.06-10.95-1.48-16.26z"/><path fill="#fff" d="M45 24 27 14v20z"/></svg>';
		case 'yt-glyph':
			return '<svg class="ft__yt-glyph" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="' . $yt . '"/></svg>';
		case 'whatsapp':
			return '<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#25d366" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>';
		case 'instagram':
			return '<svg viewBox="0 0 24 24" aria-hidden="true"><defs><radialGradient id="ft-ig" cx="0.3" cy="1.07" r="1.5"><stop offset="0" stop-color="#fdf497"/><stop offset=".05" stop-color="#fdf497"/><stop offset=".45" stop-color="#fd5949"/><stop offset=".6" stop-color="#d6249f"/><stop offset=".9" stop-color="#285aeb"/></radialGradient></defs><path fill="url(#ft-ig)" d="M7.0301.084c-1.2768.0602-2.1487.264-2.911.5634-.7888.3075-1.4575.72-2.1228 1.3877-.6652.6677-1.075 1.3368-1.3802 2.127-.2954.7638-.4956 1.6365-.552 2.914-.0564 1.2775-.0689 1.6882-.0626 4.947.0062 3.2586.0206 3.6671.0825 4.9473.061 1.2765.264 2.1482.5635 2.9107.308.7889.72 1.4573 1.388 2.1228.6679.6655 1.3365 1.0743 2.1285 1.38.7632.295 1.6361.4961 2.9134.552 1.2773.056 1.6884.069 4.9462.0627 3.2578-.0062 3.668-.0207 4.9478-.0814 1.28-.0607 2.147-.2652 2.9098-.5633.7889-.3086 1.4578-.72 2.1228-1.3881.665-.6682 1.0745-1.3378 1.3795-2.1284.2957-.7632.4966-1.636.552-2.9124.056-1.2809.0692-1.6898.063-4.948-.0063-3.2583-.021-3.6668-.0817-4.9465-.0607-1.2797-.264-2.1487-.5633-2.9117-.3084-.7889-.72-1.4568-1.3876-2.1228C21.2982 1.33 20.628.9208 19.8378.6165 19.074.321 18.2017.1197 16.9244.0645 15.6471.0093 15.236-.005 11.977.0014 8.718.0076 8.31.0215 7.0301.0839m.1402 21.6932c-1.17-.0509-1.8053-.2453-2.2287-.408-.5606-.216-.96-.4771-1.3819-.895-.422-.4178-.6811-.8186-.9-1.378-.1644-.4234-.3624-1.058-.4171-2.228-.0595-1.2645-.072-1.6442-.079-4.848-.007-3.2037.0053-3.583.0607-4.848.05-1.169.2456-1.805.408-2.2282.216-.5613.4762-.96.895-1.3816.4188-.4217.8184-.6814 1.3783-.9003.423-.1651 1.0575-.3614 2.227-.4171 1.2655-.06 1.6447-.072 4.848-.079 3.2033-.007 3.5835.005 4.8495.0608 1.169.0508 1.8053.2445 2.228.408.5608.216.96.4754 1.3816.895.4217.4194.6816.8176.9005 1.3787.1653.4217.3617 1.056.4169 2.2263.0602 1.2655.0739 1.645.0796 4.848.0058 3.203-.0055 3.5834-.061 4.848-.051 1.17-.245 1.8055-.408 2.2294-.216.5604-.4763.96-.8954 1.3814-.419.4215-.8181.6811-1.3783.9-.4224.1649-1.0577.3617-2.2262.4174-1.2656.0595-1.6448.072-4.8493.079-3.2045.007-3.5825-.006-4.848-.0608M16.953 5.5864A1.44 1.44 0 1 0 18.39 4.144a1.44 1.44 0 0 0-1.437 1.4424M5.8385 12.012c.0067 3.4032 2.7706 6.1557 6.173 6.1493 3.4026-.0065 6.157-2.7701 6.1506-6.1733-.0065-3.4032-2.771-6.1565-6.174-6.1498-3.403.0067-6.156 2.771-6.1496 6.1738M8 12.0077a4 4 0 1 1 4.008 3.9921A3.9996 3.9996 0 0 1 8 12.0077"/></svg>';
		case 'linkedin':
			return '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="2" width="20" height="20" fill="#fff"/><path fill="#0a66c2" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>';
		case 'behance':
			return '<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#1769ff" d="M16.969 16.927a2.561 2.561 0 0 0 1.901.677 2.501 2.501 0 0 0 1.531-.475c.362-.235.636-.584.779-.99h2.585a5.091 5.091 0 0 1-1.9 2.896 5.292 5.292 0 0 1-3.091.88 5.839 5.839 0 0 1-2.284-.433 4.871 4.871 0 0 1-1.723-1.211 5.657 5.657 0 0 1-1.08-1.874 7.057 7.057 0 0 1-.383-2.393c-.005-.8.129-1.595.396-2.349a5.313 5.313 0 0 1 5.088-3.604 4.87 4.87 0 0 1 2.376.563c.661.362 1.231.87 1.668 1.485a6.2 6.2 0 0 1 .943 2.133c.194.821.263 1.666.205 2.508h-7.699c-.063.79.184 1.574.688 2.187ZM6.947 4.084a8.065 8.065 0 0 1 1.928.198 4.29 4.29 0 0 1 1.49.638c.418.303.748.711.958 1.182.241.579.357 1.203.341 1.83a3.506 3.506 0 0 1-.506 1.961 3.726 3.726 0 0 1-1.503 1.287 3.588 3.588 0 0 1 2.027 1.437c.464.747.697 1.615.67 2.494a4.593 4.593 0 0 1-.423 2.032 3.945 3.945 0 0 1-1.163 1.413 5.114 5.114 0 0 1-1.683.807 7.135 7.135 0 0 1-1.928.259H0V4.084h6.947Zm-.235 12.9c.308.004.616-.029.916-.099a2.18 2.18 0 0 0 .766-.332c.228-.158.411-.371.534-.619.142-.317.208-.663.191-1.009a2.08 2.08 0 0 0-.642-1.715 2.618 2.618 0 0 0-1.696-.505h-3.54v4.279h3.471Zm13.635-5.967a2.13 2.13 0 0 0-1.654-.619 2.336 2.336 0 0 0-1.163.259 2.474 2.474 0 0 0-.738.62 2.359 2.359 0 0 0-.396.792c-.074.239-.12.485-.137.734h4.769a3.239 3.239 0 0 0-.679-1.785l-.002-.001Zm-13.813-.648a2.254 2.254 0 0 0 1.423-.433c.399-.355.607-.88.56-1.413a1.916 1.916 0 0 0-.178-.891 1.298 1.298 0 0 0-.495-.533 1.851 1.851 0 0 0-.711-.274 3.966 3.966 0 0 0-.835-.073H3.241v3.631h3.293v-.014ZM21.62 5.122h-5.976v1.527h5.976V5.122Z"/></svg>';
		case 'pinterest':
			return '<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#e60023" d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/></svg>';
		case 'youtube':
			return '<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#fff" d="M9.545 15.568V8.432L15.818 12z"/><path fill="#f00" d="' . $yt . '"/></svg>';
		case 'email':
			return '<svg viewBox="52 42 88 66" aria-hidden="true"><path fill="#4285f4" d="M58 108h14V74L52 59v43c0 3.32 2.69 6 6 6"/><path fill="#34a853" d="M120 108h14c3.32 0 6-2.69 6-6V59l-20 15"/><path fill="#fbbc04" d="M120 48v26l20-15v-8c0-7.42-8.47-11.65-14.4-7.2"/><path fill="#ea4335" d="M72 74V48l24 18 24-18v26L96 92"/><path fill="#c5221f" d="M52 51v8l20 15V48l-5.6-4.2c-5.94-4.45-14.4-.22-14.4 7.2"/></svg>';
	}
	return '';
}

/** CSS modifier for a network's social button (.ft__soc--*). */
function wiseup_social_mod( $network ) {
	$mods = array( 'whatsapp' => 'wa', 'instagram' => 'ig', 'linkedin' => 'in', 'behance' => 'be', 'pinterest' => 'pin', 'youtube' => 'yt', 'email' => 'mail' );
	return isset( $mods[ $network ] ) ? $mods[ $network ] : $network;
}

/**
 * The phone spacing scale shared by every template (assets/css/rhythm.css), inlined late in the head so it comes after
 * each template's own styles: the WiseUp pages, the landing pages (which print their own document) and the blog.
 */
add_action( 'wp_head', function () {
	$is_blog = ( function_exists( 'wiseup_is_blog_list' ) && wiseup_is_blog_list() ) || is_singular( 'post' );
	if ( ! wiseup_page_slug() && ! ( is_singular( 'page' ) && wiseup_landing_for( get_queried_object_id() ) ) && ! $is_blog ) return;
	$css = file_get_contents( WISEUP_DIR . 'assets/css/rhythm.css' );
	if ( false !== $css ) echo "<style id=\"wiseup-rhythm\">\n" . $css . "\n</style>\n"; // phpcs:ignore -- static plugin stylesheet
}, 20 );
