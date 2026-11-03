<?php
/**
 * The small animated illustration at the top of each service card (landing/services.php), drawn in SVG/HTML and
 * animated in CSS (assets/css/services.css, the .vz-* rules). Decorative only: the card prints them inside an
 * aria-hidden wrapper. Keys match the icon keys in services.php.
 */
defined( 'ABSPATH' ) || exit;

return array(

	// Brand: a logo being constructed on a grid, with a palette under it
	'signature' => '<svg class="vz vz-brand" viewBox="0 0 400 220" preserveAspectRatio="xMidYMid meet">
		<g class="vz-grid">' . implode( '', array_map( function ( $x ) { return '<line x1="' . $x . '" y1="10" x2="' . $x . '" y2="210"/>'; }, range( 40, 360, 40 ) ) ) . implode( '', array_map( function ( $y ) { return '<line x1="10" y1="' . $y . '" x2="390" y2="' . $y . '"/>'; }, range( 30, 190, 40 ) ) ) . '</g>
		<circle class="vz-guide" cx="200" cy="110" r="78"/><circle class="vz-guide vz-guide--2" cx="200" cy="110" r="48"/>
		<path class="vz-draw" pathLength="1" d="M128 72 L162 152 L200 96 L238 152 L272 72"/>
		<g class="vz-pts"><circle cx="128" cy="72" r="4"/><circle cx="162" cy="152" r="4"/><circle cx="200" cy="96" r="4"/><circle cx="238" cy="152" r="4"/><circle cx="272" cy="72" r="4"/></g>
		<g class="vz-swatch"><circle cx="318" cy="186" r="9" fill="#BEDA52"/><circle cx="342" cy="186" r="9" fill="#ffffff"/><circle cx="366" cy="186" r="9" fill="#3a3f2a"/></g>
	</svg>',

	// Packaging: a kraft-card product box turning in 3D, WiseUp label, packing tape over the lid
	'box' => '<div class="vz vz-pack"><div class="vz-box">
		<span class="f f-front"><i class="vz-lbl"><b>W</b><em>WiseUp</em></i><i class="vz-tape-v"></i></span>
		<span class="f f-back"><i class="vz-tape-v"></i></span>
		<span class="f f-right"><i class="vz-stripe"></i><i class="vz-icons"></i></span>
		<span class="f f-left"><i class="vz-stripe"></i></span>
		<span class="f f-top"><i class="vz-tape"></i></span>
		<span class="f f-bottom"></span>
	</div><i class="vz-floor"></i></div>',

	// Web: a page building itself, the cursor clicks the button
	'code' => '<svg class="vz vz-web" viewBox="0 0 400 220" preserveAspectRatio="xMidYMid meet">
		<rect class="vz-frame" x="40" y="18" width="320" height="184" rx="14"/>
		<line class="vz-frame" x1="40" y1="46" x2="360" y2="46"/>
		<circle cx="60" cy="32" r="4" class="vz-dotc"/><circle cx="74" cy="32" r="4" class="vz-dotc"/><circle cx="88" cy="32" r="4" class="vz-dotc"/>
		<rect class="vz-url" x="120" y="25" width="160" height="14" rx="7"/>
		<rect class="vz-bar b1" x="62" y="66" width="180" height="16" rx="5"/>
		<rect class="vz-bar b2" x="62" y="92" width="240" height="8" rx="4"/>
		<rect class="vz-bar b3" x="62" y="108" width="200" height="8" rx="4"/>
		<rect class="vz-btn" x="62" y="132" width="92" height="30" rx="15"/>
		<rect class="vz-tile t1" x="250" y="128" width="40" height="52" rx="8"/><rect class="vz-tile t2" x="298" y="128" width="40" height="52" rx="8"/>
		<path class="vz-cursor" d="M0 0 L0 20 L5 15 L9 24 L13 22 L9 13 L16 13 Z"/>
	</svg>',

	// SEO: a search being typed, our result climbs to first place
	'search' => '<div class="vz vz-seo">
		<div class="vz-q"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="6.5"/><path d="m20 20-4.2-4.2"/></svg><span class="vz-type">branding agency kozhikode</span></div>
		<div class="vz-res">
			<div class="r r1"><i></i><i></i></div>
			<div class="r r2"><i></i><i></i></div>
			<div class="r r-us"><em>1</em><i></i><i></i></div>
		</div>
	</div>',

	// Performance: bars rising with a growth line drawn over them
	'target' => '<svg class="vz vz-perf" viewBox="0 0 400 220" preserveAspectRatio="xMidYMid meet">
		<line class="vz-axis" x1="40" y1="190" x2="360" y2="190"/>
		' . implode( '', array_map( function ( $i ) { $h = array( 40, 62, 54, 86, 104, 96, 132, 150 )[ $i ]; $x = 52 + $i * 38; return '<rect class="vz-col" style="--i:' . $i . '" x="' . $x . '" y="' . ( 190 - $h ) . '" width="24" height="' . $h . '" rx="5"/>'; }, range( 0, 7 ) ) ) . '
		<polyline class="vz-line" pathLength="1" points="64,142 102,122 140,128 178,96 216,80 254,86 292,52 330,30"/>
		<circle class="vz-head" cx="330" cy="30" r="6"/>
	</svg>',

	// Digital: a turning globe with a signal orbiting it
	'globe' => '<svg class="vz vz-globe" viewBox="0 0 400 220" preserveAspectRatio="xMidYMid meet">
		<circle class="vz-sphere" cx="200" cy="110" r="78"/>
		<g class="vz-mer"><ellipse cx="200" cy="110" rx="78" ry="78" class="m m1"/><ellipse cx="200" cy="110" rx="78" ry="78" class="m m2"/><ellipse cx="200" cy="110" rx="78" ry="78" class="m m3"/></g>
		<line class="vz-lat" x1="122" y1="110" x2="278" y2="110"/><ellipse class="vz-lat" cx="200" cy="72" rx="68" ry="10"/><ellipse class="vz-lat" cx="200" cy="148" rx="68" ry="10"/>
		<g class="vz-orbit"><ellipse class="vz-ring" cx="200" cy="110" rx="140" ry="40"/><circle class="vz-sat" cx="0" cy="0" r="7"/></g>
	</svg>',

	// Social: a phone playing reels, likes floating up
	'chat' => '<div class="vz vz-social">
		<div class="vz-phone"><div class="vz-prog"><i></i><i></i><i></i></div><svg class="vz-play" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg><div class="vz-cap"><i></i><i></i></div></div>
		<span class="vz-heart h1">♥</span><span class="vz-heart h2">♥</span><span class="vz-heart h3">♥</span><span class="vz-heart h4">♥</span>
	</div>',

	// Video: a camera viewfinder, recording
	'video' => '<svg class="vz vz-cam" viewBox="0 0 400 220" preserveAspectRatio="xMidYMid meet">
		<g class="vz-thirds"><line x1="146" y1="24" x2="146" y2="196"/><line x1="254" y1="24" x2="254" y2="196"/><line x1="40" y1="81" x2="360" y2="81"/><line x1="40" y1="139" x2="360" y2="139"/></g>
		<path class="vz-corner" d="M40 54V24h30M360 54V24h-30M40 166v30h30M360 166v30h-30"/>
		<rect class="vz-focus" x="170" y="80" width="60" height="60" rx="4"/>
		<circle class="vz-rec" cx="64" cy="44" r="6"/><text class="vz-rectext" x="78" y="49">REC</text>
		<rect class="vz-scan" x="40" y="24" width="320" height="2"/>
	</svg>',

	// Campaigns: a megaphone broadcasting, the channels running past
	'megaphone' => '<div class="vz vz-cast">
		<svg viewBox="0 0 400 150" preserveAspectRatio="xMidYMid meet">
			<path class="vz-mega" d="M120 62v26a6 6 0 0 0 6 6h14l58 34V22l-58 34h-14a6 6 0 0 0-6 6Z"/>
			<path class="vz-wave w1" d="M222 52a32 32 0 0 1 0 46"/><path class="vz-wave w2" d="M240 36a56 56 0 0 1 0 78"/><path class="vz-wave w3" d="M258 20a80 80 0 0 1 0 110"/>
		</svg>
		<div class="vz-tick"><div><span>OOH</span><span>Print</span><span>Radio</span><span>Digital</span><span>Video</span><span>OOH</span><span>Print</span><span>Radio</span><span>Digital</span><span>Video</span></div></div>
	</div>',
);
