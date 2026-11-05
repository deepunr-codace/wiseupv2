<?php
/**
 * WiseUp TV page ("WiseUp: TV" in the page Template dropdown). The page's own design from existing pages/wiseup-tv.html
 * (owner, 2026-11-05), with the WiseUp header and footer (includes/landing.php) instead of its own, the lead popup for
 * its "Collaborate With WiseUp TV" buttons, styles in assets/css/wiseup-tv.css, images in assets/tv/.
 */
defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', function () {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "
";
	echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,300;0,400;0,500;0,600;1,500;1,600&amp;display=swap">' . "
";
	echo '<link rel="stylesheet" href="' . esc_url( WISEUP_URL . 'assets/css/wiseup-tv.css?ver=' . filemtime( WISEUP_DIR . 'assets/css/wiseup-tv.css' ) ) . "\">
";
}, 7 );

wiseup_landing_isolate();
wiseup_landing_open( 'wu-landing wu-tv-page' );
?>
<main id="main">
<div class="wiseup-tv">

    <section class="glow tv-hero" id="top" style="padding:110px 0 0;">
        <div class="layer"></div>
        <div class="inner">
            <h1 class="reveal">Stories That Build <span class="accent">Enduring</span> Brands</h1>
            <div class="hero-row">
                <p class="reveal d1">We create refined, high-impact content that positions brands with clarity,
                    credibility,
                    and
                    cultural relevance.</p>
                <div class="hero-cta reveal d2">
                    <a href="#" data-lead-open data-lead-source="wiseup-tv" class="btn btn-primary btn-md">Collaborate With WiseUp TV</a>
                    <a href="#work" class="btn btn-outline btn-md">View Our Work <svg class="arr" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path d="M7 7h10v10M7 17 17 7"></path>
                        </svg></a>
                </div>
            </div>
        </div>
    </section>

    <section class="visibility">
        <span class="tv-eyebrow">A Different Kind of Visibility</span>
        <p class="tv-lead">In a landscape saturated with noise, attention is no longer earned through repetition—but
            through
            relevance.<br>The most respected brands are not the loudest. They are the most understood.<br><span
                style="color:var(--mint)">WiseUp&nbsp;TV</span> is a media platform dedicated to documenting and shaping
            business narratives—through carefully crafted storytelling and considered production.</p>
        <p class="muted">We work with brands that value depth over volume, meaning over messaging, and long-term
            perception
            over short-term reach.</p>
    </section>

    <section class="create">
        <div class="center">
            <span class="tv-eyebrow center">What We Create</span>
            <h2 style="margin-top:18px;">Precision in Every <span class="accent">Frame</span></h2>
            <p class="sub" style="margin-top:18px;">Each piece of content is designed to reflect the brand's essence
                with
                precision and restraint.</p>
        </div>
        <div class="cards">
            <article class="tv-card" style="background:var(--lime);color:var(--black-900);"><svg class="arr"
                    viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M7 7h10v10M7 17 17 7"></path>
                </svg>
                <div>
                    <h3>Brand Films</h3>
                    <p>Each piece of content is designed to reflect the brand's essence with precision and
                        restraint.</p>
                </div>
            </article>
            <article class="tv-card" style="background:var(--teal-deep);color:#fff;"><svg class="arr" viewBox="0 0 24 24"
                    aria-hidden="true">
                    <path d="M7 7h10v10M7 17 17 7"></path>
                </svg>
                <div>
                    <h3>Founder &amp; Leadership Conversations</h3>
                    <p>Thoughtful dialogues that reveal the people behind the brand.</p>
                </div>
            </article>
            <article class="tv-card" style="background:var(--orange);color:#fff;"><svg class="arr" viewBox="0 0 24 24"
                    aria-hidden="true">
                    <path d="M7 7h10v10M7 17 17 7"></path>
                </svg>
                <div>
                    <h3>Strategic Insight Content</h3>
                    <p>Positioning brands through clarity of thought and perspective.</p>
                </div>
            </article>
            <article class="tv-card" style="background:var(--grey-150);color:var(--black-900);"><svg class="arr"
                    viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M7 7h10v10M7 17 17 7"></path>
                </svg>
                <div>
                    <h3>Industry Narratives</h3>
                    <p>Contextual storytelling that places your brand within a larger conversation.</p>
                </div>
            </article>
            <article class="tv-card" style="background:var(--teal-green);color:#fff;"><svg class="arr" viewBox="0 0 24 24"
                    aria-hidden="true">
                    <path d="M7 7h10v10M7 17 17 7"></path>
                </svg>
                <div>
                    <h3>Short-form Editorial</h3>
                    <p>Refined, high-impact formats designed for modern attention spans.</p>
                </div>
            </article>
        </div>
    </section>

    <section class="approach">
        <span class="tv-eyebrow">Our Approach</span>
        <h2>How content makes<br>people perceive you</h2>
        <p class="sub">We believe strong brands are not built through content alone—but through how that content makes
            people perceive you. Our process is guided by four principles.</p>
        <div>
            <div class="row"
                style="--g:linear-gradient(90deg,var(--black) 0%,#053040 14%,var(--teal-deep) 40%,var(--teal) 64%,var(--teal-green) 100%);">
                <div class="fill">
                    <div class="cols">
                        <span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                    </div>
                </div>
                <div class="body">
                    <h3>Clarity</h3>
                    <p>Understanding what truly defines your brand—and articulating it without ambiguity.</p>
                </div>
            </div>
            <div class="row"
                style="--g:linear-gradient(90deg,var(--black) 0%,#0c2e12 16%,var(--green) 50%,var(--lime) 74%,#16360f 100%);">
                <div class="fill">
                    <div class="cols">
                        <span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                    </div>
                </div>
                <div class="body">
                    <h3>Restraint</h3>
                    <p>Saying only what matters—nothing more. Edited precision over exhaustive volume.</p>
                </div>
            </div>
            <div class="row"
                style="--g:linear-gradient(90deg,var(--black) 0%,#2a1006 14%,var(--orange) 45%,#d34a1e 66%,#6b5048 86%,#9a9a9a 100%);">
                <div class="fill">
                    <div class="cols">
                        <span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                    </div>
                </div>
                <div class="body">
                    <h3>Craft</h3>
                    <p>Elevated production that reflects quality without excess or spectacle.</p>
                </div>
            </div>
            <div class="row"
                style="--g:linear-gradient(90deg,var(--black) 0%,#0a3029 14%,var(--teal-green) 42%,#3aa896 64%,#6f7f7a 84%,#9a9a9a 100%);">
                <div class="fill">
                    <div class="cols">
                        <span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                    </div>
                </div>
                <div class="body">
                    <h3>Continuity</h3>
                    <p>Building a consistent narrative across platforms that compounds over time.</p>
                </div>
            </div>
            <div style="border-top:1px solid var(--grey-150);"></div>
        </div>
    </section>

    <section class="curated">
        <div class="panel">
            <div class="inner">
                <span class="tv-eyebrow center">Select Work</span>
                <h2>A <span class="accent">Curated</span> Collection</h2>
                <p>Brand films, conversations, and editorial content—crafted with intention.</p>
                <a href="#work" class="view">View Portfolio <span class="arr2">→</span></a>
            </div>
        </div>
    </section>

    <section class="work" id="work">
        <span class="tv-eyebrow">Collaboration</span>
        <h2>Depth, Focus,<br>and Quality</h2>
        <p class="sub">We partner with a limited number of brands to ensure the depth, focus, and quality each story
            deserves. Each collaboration is strategically structured, not templated.</p>
        <div class="work-grid">
            <div class="work-col">
                <article class="wcard">
                    <div class="img"
                        style="background-image:url('<?php echo esc_url( WISEUP_URL . 'assets/tv/collab1.webp' ); ?>')">
                    </div>
                    <div class="veil"></div>
                    <div class="cap"><span>Brand Films</span><svg class="arr" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M7 7h10v10M7 17 17 7"></path>
                        </svg></div>
                </article>
                <article class="wcard">
                    <div class="img"
                        style="background-image:url('<?php echo esc_url( WISEUP_URL . 'assets/tv/collab3.webp' ); ?>')">
                    </div>
                    <div class="veil"></div>
                    <div class="cap"><span>Private &amp; Public<br>Event Coverage</span><svg class="arr"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M7 7h10v10M7 17 17 7"></path>
                        </svg></div>
                </article>
            </div>
            <div class="work-col offset">
                <article class="wcard">
                    <div class="img"
                        style="background-image:url('<?php echo esc_url( WISEUP_URL . 'assets/tv/collab2.webp' ); ?>')">
                    </div>
                    <div class="veil"></div>
                    <div class="cap"><span>Founder<br>Conversations</span><svg class="arr" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path d="M7 7h10v10M7 17 17 7"></path>
                        </svg></div>
                </article>
                <article class="wcard">
                    <div class="img"
                        style="background-image:url('<?php echo esc_url( WISEUP_URL . 'assets/tv/collab4.webp' ); ?>')">
                    </div>
                    <div class="veil"></div>
                    <div class="cap"><span>Editorial Integrations<br>within WiseUp TV</span><svg class="arr"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M7 7h10v10M7 17 17 7"></path>
                        </svg></div>
                </article>
            </div>
        </div>
    </section>

    <section class="dist">
        <div class="center"><span class="tv-eyebrow center">Distribution &amp; Presence</span></div>
        <h2><span style="color:var(--mint)">WiseUp&nbsp;TV</span> content reaches a carefully built<br>audience of
            decision-makers.</h2>
        <div class="discs">
            <div class="disc" style="background:var(--orange);">Entrepreneurs</div>
            <div class="disc" style="background:var(--teal-green);">Business Leaders</div>
            <div class="disc" style="background:var(--lime);color:#243;">Decision-Makers</div>
        </div>
        <p class="cap">Every piece is designed to resonate, not just reach.</p>
    </section>

    <section class="cta" id="cta" style="background-color:black !important;">
        <span class="tv-eyebrow">For Brands That Think Long-Term</span>
        <h2>Tell Your Story<br>with <span class="accent">Intention</span></h2>
        <p>If your brand values perception, positioning, and meaningful visibility, WiseUp&nbsp;TV offers a platform
            built
            for it.</p>
        <a href="#" data-lead-open data-lead-source="wiseup-tv" class="btn btn-primary btn-md">Collaborate With WiseUp TV</a>
    </section>
</div>
<script>
/* scroll reveals, from the page's own script; limited to this page's content (not the WiseUp header and footer) */
(function () {
	var r = document.querySelector('.wiseup-tv'); if (!r) return;
	r.classList.add('js');
	var q = function (s) { return r.querySelectorAll(s); };
	q('section .tv-eyebrow, section h2, .visibility p, .create .sub, .approach .sub, .work .sub, .cta p, .dist .cap, .panel .view, .row, .wcard').forEach(function (el) { el.classList.add('sr'); });
	q('.tv-card, .disc').forEach(function (el) { el.classList.add('sro'); });
	['.cards', '.discs', '.work-col'].forEach(function (sel) { q(sel).forEach(function (g) { Array.prototype.forEach.call(g.children, function (ch, i) { ch.style.transitionDelay = (i * 0.09) + 's'; }); }); });
	if (!('IntersectionObserver' in window)) { q('.sr,.sro').forEach(function (el) { el.classList.add('in'); }); return; }
	var io = new IntersectionObserver(function (es) { es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } }); }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
	q('.sr,.sro').forEach(function (el) { io.observe(el); });
})();
</script>
</main>
<?php
$wu_lead_source = 'wiseup-tv';
include WISEUP_DIR . 'landing/lead-popup.php';
wiseup_landing_close( 'wiseup-tv' );
