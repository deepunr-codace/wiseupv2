<?php
/**
 * WiseUp Studio page ("WiseUp: Studio" in the page Template dropdown). The page's own design from existing pages/wiseup-studio.html
 * (owner, 2026-11-05), with the WiseUp header and footer (includes/landing.php) instead of its own, the lead popup for
 * its "Book Your Slot Now / Start a Project" buttons, styles in assets/css/wiseup-studio.css, images in assets/studio/.
 */
defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', function () {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "
";
	echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,300;0,400;0,500;0,600;1,500;1,600&amp;display=swap">' . "
";
	echo '<link rel="stylesheet" href="' . esc_url( WISEUP_URL . 'assets/css/wiseup-studio.css?ver=' . filemtime( WISEUP_DIR . 'assets/css/wiseup-studio.css' ) ) . "\">
";
}, 7 );

// The hero is white and the WiseUp logo is white: keep the dark pill behind the header from the top.
add_filter( 'wiseup_header_always_docked', '__return_true' );

wiseup_landing_isolate();
wiseup_landing_open( 'wu-landing wu-studio-page' );
?>
<main id="main">
<div id="wiseup-studio">

    <!-- HERO -->
    <section class="st-hero" id="wu-top">
        <div class="inner">
            <h1 class="watermark-studio"><span class="wu-sr">WiseUp </span>Studio</h1>
            <p class="tagline">We Shoot Every Frame Your Brand Needs</p>
            <a href="#" data-lead-open data-lead-source="wiseup-studio" class="btn btn-light btn-lg st-book">Book Your Slot Now</a>
        </div>
    </section>

    <!-- STATS -->
    <div class="st-stats">
        <div class="stat"><b>120+</b><span>Projects Delivered</span></div>
        <div class="stat active"><b>3M+</b><span>Audience Reached</span></div>
        <div class="stat dark"><b>7+</b><span>Years Experience</span></div>
        <div class="stat"><b>4K</b><span>Cinema Quality</span></div>
    </div>

    <!-- MARQUEE -->
    <div class="marquee-wrap">
        <div class="marquee tilt-a">
            <div class="track">
                <span class="tag">Explainer Videos<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Social Reels<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Brand Documentaries<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Podcasts &amp; Interviews<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Event Coverage<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">UGC &amp; Unboxing<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Explainer Videos<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Social Reels<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Brand Documentaries<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Podcasts &amp; Interviews<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Event Coverage<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">UGC &amp; Unboxing<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
            </div>
        </div>
        <div class="marquee tilt-b">
            <div class="track rev">
                <span class="tag">Explainer Videos<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Social Reels<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Brand Documentaries<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Podcasts &amp; Interviews<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Event Coverage<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">UGC &amp; Unboxing<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Explainer Videos<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Social Reels<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Brand Documentaries<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Podcasts &amp; Interviews<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">Event Coverage<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
                <span class="tag">UGC &amp; Unboxing<span class="tri"><svg viewBox="0 0 26 26">
                            <path
                                d="M9.536 6C11.075 3.333 14.925 3.333 16.464 6l4.33 7.5c1.54 2.667-.385 6-3.464 6H8.67c-3.079 0-5.004-3.333-3.464-6L9.536 6Z">
                            </path>
                        </svg></span></span>
            </div>
        </div>
    </div>

    <!-- WHAT WE SHOOT -->
    <section class="shoot">
        <div class="shoot-card">
            <div class="cornerglow"></div>
            <div class="inner">
                <span class="st-eyebrow">Our Services</span>
                <h2>What we <br><span class="blue">Shoot</span></h2>
                <p>Every format your brand needs — from a 6-second reel to a full-length TVC, we handle the complete
                    video mix.
                </p>
            </div>
        </div>
    </section>

    <!-- SERVICE PANELS (sticky stacking slider) -->
    <div class="services">
        <section class="srow">
            <div class="media">
                <div class="mimg"
                    style="background-image:url('<?php echo esc_url( WISEUP_URL . 'assets/studio/product-shoots.webp' ); ?>')">
                </div><svg class="arr" viewBox="0 0 47 47" fill="currentColor">
                    <path
                        d="M3.965 0v7.835h29.659C22.291 19.133 11.104 30.285 0 41.356c1.877 1.871 3.69 3.679 5.658 5.644C16.791 35.897 27.971 24.746 39.21 13.538V42.946H47.002V0H3.965Z">
                    </path>
                </svg>
            </div>
            <div class="cap">
                <h3>Product Shoots &amp; Films</h3>
                <p>Hero shots, close-ups, lifestyle context — cinematic product content that sells.</p>
            </div>
        </section>
        <section class="srow">
            <div class="media">
                <div class="mimg"
                    style="background-image:url('<?php echo esc_url( WISEUP_URL . 'assets/studio/reels.webp' ); ?>')"></div>
                <svg class="arr" viewBox="0 0 47 47" fill="currentColor">
                    <path
                        d="M3.965 0v7.835h29.659C22.291 19.133 11.104 30.285 0 41.356c1.877 1.871 3.69 3.679 5.658 5.644C16.791 35.897 27.971 24.746 39.21 13.538V42.946H47.002V0H3.965Z">
                    </path>
                </svg>
            </div>
            <div class="cap">
                <h3>Reels &amp; Short-Form</h3>
                <p>Hook-first vertical content for Instagram, YouTube Shorts, and TikTok.</p>
            </div>
        </section>
        <section class="srow">
            <div class="media">
                <div class="mimg" style="background-image:url('<?php echo esc_url( WISEUP_URL . 'assets/studio/tvc.webp' ); ?>')">
                </div>
                <svg class="arr" viewBox="0 0 47 47" fill="currentColor">
                    <path
                        d="M3.965 0v7.835h29.659C22.291 19.133 11.104 30.285 0 41.356c1.877 1.871 3.69 3.679 5.658 5.644C16.791 35.897 27.971 24.746 39.21 13.538V42.946H47.002V0H3.965Z">
                    </path>
                </svg>
            </div>
            <div class="cap">
                <h3>TVCs &amp; Ad Films</h3>
                <p>Broadcast-quality television commercials and digital ad films built for reach and recall.</p>
            </div>
        </section>
        <section class="srow">
            <div class="media">
                <div class="mimg"
                    style="background-image:url('<?php echo esc_url( WISEUP_URL . 'assets/studio/corporate.webp' ); ?>')">
                </div><svg class="arr" viewBox="0 0 47 47" fill="currentColor">
                    <path
                        d="M3.965 0v7.835h29.659C22.291 19.133 11.104 30.285 0 41.356c1.877 1.871 3.69 3.679 5.658 5.644C16.791 35.897 27.971 24.746 39.21 13.538V42.946H47.002V0H3.965Z">
                    </path>
                </svg>
            </div>
            <div class="cap">
                <h3>Corporate Videos</h3>
                <p>Company profiles, investor films, internal communications, and brand documentaries.</p>
            </div>
        </section>
        <section class="srow">
            <div class="media">
                <div class="mimg"
                    style="background-image:url('<?php echo esc_url( WISEUP_URL . 'assets/studio/podcasts.webp' ); ?>')">
                </div><svg class="arr" viewBox="0 0 47 47" fill="currentColor">
                    <path
                        d="M3.965 0v7.835h29.659C22.291 19.133 11.104 30.285 0 41.356c1.877 1.871 3.69 3.679 5.658 5.644C16.791 35.897 27.971 24.746 39.21 13.538V42.946H47.002V0H3.965Z">
                    </path>
                </svg>
            </div>
            <div class="cap">
                <h3>Podcasts &amp; Interviews</h3>
                <p>Multi-cam studio podcast setups, thought leadership interviews, and talking-head formats.</p>
            </div>
        </section>
    </div>

    <!-- BENTO GRID -->
    <section class="bento">
        <div class="bento-grid">
            <div class="brow">
                <article class="bcard b-event" style="flex:801">
                    <div class="bc">
                        <h4>Event &amp; Live Coverage</h4>
                        <p>Product launches, fashion shows, brand activations — multi-camera live event documentation.
                        </p>
                    </div>
                </article>
                <article class="bcard b-brand" style="flex:631">
                    <div class="bc">
                        <h4>Brand Documentaries</h4>
                        <p>Long-form storytelling that captures the soul of your brand — origin stories, team films,
                            impact pieces.
                        </p>
                    </div>
                </article>
            </div>
            <article class="bcard wide b-explainer">
                <div class="bc">
                    <h4>Explainer &amp; Training Videos</h4>
                    <p>Animated or live-action explainers, onboarding videos, and e-learning content.</p>
                </div>
            </article>
            <div class="brow">
                <article class="bcard b-customer" style="flex:554">
                    <div class="bc">
                        <h4>Customer Story Films</h4>
                        <p>Real client testimonials and case study videos — the most trusted content in any brand's
                            toolkit.</p>
                    </div>
                </article>
                <article class="bcard b-bts" style="flex:878">
                    <div class="bc">
                        <h4>BTS &amp; Raw Content</h4>
                        <p>Behind-the-scenes footage and day-in-the-life content — authentic, unpolished, and always
                            engaging.</p>
                    </div>
                </article>
            </div>
            <article class="bcard wide b-ugc">
                <div class="bc">
                    <h4>UGC &amp; Unboxing Content</h4>
                    <p>User-generated style videos, unboxing films, and creator-format content for D2C and e-commerce
                        brands.</p>
                </div>
            </article>
        </div>
    </section>

    <!-- NEED TO SHOOT CTA -->
    <section class="need" id="wu-need">
        <div class="guides">
            <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
        </div>
        <div class="inner">
            <h2>What Do You Need Us To <span class="blue">Shoot?</span></h2>
            <div class="need-row">
                <p>Tell us your brand, your campaign, your deadline. We'll bring the studio to you.</p>
                <a href="#" data-lead-open data-lead-source="wiseup-studio" class="btn btn-dark btn-lg">Start a Project</a>
            </div>
        </div>
    </section>
</div>
</main>
<?php
$wu_lead_source = 'wiseup-studio';
include WISEUP_DIR . 'landing/lead-popup.php';
wiseup_landing_close( 'wiseup-studio' );
