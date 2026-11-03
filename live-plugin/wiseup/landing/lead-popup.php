<?php
/**
 * The site's lead popup (the same markup as the home page's), for the landing pages. Include it once near the end of
 * the page; set $wu_lead_source first to tag the leads (Wiseup → Leads). Any [data-lead-open] element opens it.
 * Styles: assets/css/lead-popup.css. Behaviour: assets/js/lead-popup.js (a plain-JS copy of motion/lead.ts).
 */
defined( 'ABSPATH' ) || exit;
$wu_popup_ver = file_exists( WISEUP_DIR . 'assets/js/lead-popup.js' ) ? filemtime( WISEUP_DIR . 'assets/js/lead-popup.js' ) : WISEUP_VERSION;
?>
<link rel="stylesheet" href="<?php echo esc_url( WISEUP_URL . 'assets/css/lead-popup.css?ver=' . $wu_popup_ver ); ?>">
<?php if ( wiseup_opt( 'lead_popup' ) ) : ?>
<button class="lead-fab" type="button" data-lead-open data-lead-source="launcher" aria-haspopup="dialog">
	<span class="lead-bot lead-bot--sm">
		<svg viewBox="0 0 48 48" aria-hidden="true">
			<path class="lb__body" d="M12 7h24a9 9 0 0 1 9 9v13a9 9 0 0 1-9 9H23l-8.5 6.5V38H12a9 9 0 0 1-9-9V16a9 9 0 0 1 9-9Z"/>
			<g class="lb__face">
				<g class="lb__eyes">
					<rect x="15.5" y="17" width="4" height="7.5" rx="2"/>
					<rect x="28.5" y="17" width="4" height="7.5" rx="2"/>
				</g>
				<path class="lb__smile" d="M19.5 29.5q4.5 3.5 9 0"/>
			</g>
			<g class="lb__dots">
				<circle cx="17" cy="22.5" r="2.4"/>
				<circle cx="24" cy="22.5" r="2.4"/>
				<circle cx="31" cy="22.5" r="2.4"/>
			</g>
			<g class="lb__joy">
				<path d="M15 21.5q2.5-3 5 0M28 21.5q2.5-3 5 0"/>
			</g>
		</svg>
	</span>
	<span class="lead-fab__label">
		Get a free plan
	</span>
</button>
<dialog class="lead" data-lead-modal aria-labelledby="lead-title" aria-describedby="lead-sub">
	<div class="lead__frame">
		<div class="lead__card">
			<div class="lead__head">
				<p class="lead__kicker">
					<i class="lead__live" aria-hidden="true">
					</i>
					Replies within 24 hours
				</p>
				<h2 class="lead__title" id="lead-title">
					<span>
						Get your growth plan,
					</span>
					<span>
						free in 24 hours.
					</span>
				</h2>
				<p class="lead__sub" id="lead-sub">
					Tell us where you want your brand to go. We send a plan before we ever talk numbers.
				</p>
				<ul class="lead__perks">
					<li>
						<svg viewBox="0 0 24 24" aria-hidden="true">
							<path d="m5 12.5 4.5 4.5L19 7.5">
							</path>
						</svg>
						A strategy before any price
					</li>
					<li>
						<svg viewBox="0 0 24 24" aria-hidden="true">
							<path d="m5 12.5 4.5 4.5L19 7.5">
							</path>
						</svg>
						One team for brand, web and ads
					</li>
					<li>
						<svg viewBox="0 0 24 24" aria-hidden="true">
							<path d="m5 12.5 4.5 4.5L19 7.5">
							</path>
						</svg>
						A reply within 24 hours
					</li>
				</ul>
				<p class="lead__or">
					Prefer to talk?
					<a href="https://wa.me/916282434503" target="_blank" rel="noopener">
						WhatsApp us
					</a>
				</p>
			</div>
			<form class="lead__form" id="lead-form" data-lead-form method="post" novalidate data-endpoint="<?php echo esc_url( rest_url( 'wiseup/v1/enquiry' ) ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ); ?>" data-source="<?php echo esc_attr( isset( $wu_lead_source ) ? $wu_lead_source : 'landing' ); ?>">
				<fieldset class="lf">
					<legend>
						Full Name
						<em aria-hidden="true">
							*
						</em>
					</legend>
					<input name="name" type="text" autocomplete="name" placeholder="Enter your name" required aria-label="Full name">
				</fieldset>
				<div class="lead__row">
					<fieldset class="lf">
						<legend>
							Email
							<em aria-hidden="true">
								*
							</em>
						</legend>
						<input name="email" type="email" autocomplete="email" placeholder="you@company.com" required aria-label="Email">
					</fieldset>
					<fieldset class="lf">
						<legend>
							Phone Number
							<em aria-hidden="true">
								*
							</em>
						</legend>
						<input name="phone" type="tel" autocomplete="tel" inputmode="tel" placeholder="+91 98765 43210" pattern="[0-9+()\s-]{7,}" required aria-label="Phone number">
					</fieldset>
				</div>
				<fieldset class="lf lf--select">
					<legend>
						Services
						<em aria-hidden="true">
							*
						</em>
					</legend>
					<select name="service" required aria-label="Service">
						<option value="" selected disabled>
							Choose a service
						</option>
						<option value="Brand Strategy &amp; Identity">
							Brand Strategy &amp; Identity
						</option>
						<option value="Packaging Design &amp; Events">
							Packaging Design &amp; Events
						</option>
						<option value="Web Development">
							Web Development
						</option>
						<option value="SEO Services">
							SEO Services
						</option>
						<option value="Performance Marketing">
							Performance Marketing
						</option>
						<option value="Digital Marketing &amp; Social Media">
							Digital Marketing &amp; Social Media
						</option>
						<option value="Video &amp; Photography">
							Video &amp; Photography
						</option>
						<option value="Campaigns &amp; Media Buying">
							Campaigns &amp; Media Buying
						</option>
					</select>
					<svg class="lf__chev" viewBox="0 0 24 24" aria-hidden="true">
						<path d="m6 9 6 6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						</path>
					</svg>
				</fieldset>
				<fieldset class="lf lf--area">
					<legend>
						Description
						<em aria-hidden="true">
							*
						</em>
					</legend>
					<textarea name="message" rows="3" placeholder="Type something you want us to know." required aria-label="Description">
					</textarea>
				</fieldset>
				<label class="lead__hp" aria-hidden="true">
					Leave empty
					<input type="text" name="hp_website" tabindex="-1" autocomplete="off">
				</label>
				<p class="lead__note" data-lead-note aria-live="polite">
				</p>
			</form>
			<div class="lead__done" data-lead-done hidden>
				<span class="lead-bot lead-bot--lg lead-bot--happy">
					<svg viewBox="0 0 48 48" aria-hidden="true">
						<path class="lb__body" d="M12 7h24a9 9 0 0 1 9 9v13a9 9 0 0 1-9 9H23l-8.5 6.5V38H12a9 9 0 0 1-9-9V16a9 9 0 0 1 9-9Z"/>
						<g class="lb__face">
							<g class="lb__eyes">
								<rect x="15.5" y="17" width="4" height="7.5" rx="2"/>
								<rect x="28.5" y="17" width="4" height="7.5" rx="2"/>
							</g>
							<path class="lb__smile" d="M19.5 29.5q4.5 3.5 9 0"/>
						</g>
						<g class="lb__dots">
							<circle cx="17" cy="22.5" r="2.4"/>
							<circle cx="24" cy="22.5" r="2.4"/>
							<circle cx="31" cy="22.5" r="2.4"/>
						</g>
						<g class="lb__joy">
							<path d="M15 21.5q2.5-3 5 0M28 21.5q2.5-3 5 0"/>
						</g>
					</svg>
				</span>
				<h3>
					Got it, thank you!
				</h3>
				<p data-lead-done-text>
					The WiseUp team will reach out within 24 hours.
				</p>
			</div>
		</div>
		<div class="lead__foot">
			<span class="lead-bot" data-lead-mascot>
				<svg viewBox="0 0 48 48" aria-hidden="true">
					<path class="lb__body" d="M12 7h24a9 9 0 0 1 9 9v13a9 9 0 0 1-9 9H23l-8.5 6.5V38H12a9 9 0 0 1-9-9V16a9 9 0 0 1 9-9Z"/>
					<g class="lb__face">
						<g class="lb__eyes">
							<rect x="15.5" y="17" width="4" height="7.5" rx="2"/>
							<rect x="28.5" y="17" width="4" height="7.5" rx="2"/>
						</g>
						<path class="lb__smile" d="M19.5 29.5q4.5 3.5 9 0"/>
					</g>
					<g class="lb__dots">
						<circle cx="17" cy="22.5" r="2.4"/>
						<circle cx="24" cy="22.5" r="2.4"/>
						<circle cx="31" cy="22.5" r="2.4"/>
					</g>
					<g class="lb__joy">
						<path d="M15 21.5q2.5-3 5 0M28 21.5q2.5-3 5 0"/>
					</g>
				</svg>
			</span>
			<span class="lead__trust">
				<b>
					120+
				</b>
				brands grown
			</span>
			<button class="lead__send" type="submit" form="lead-form" data-lead-send>
				<span>
					Send Message
				</span>
				<svg viewBox="0 0 24 24" aria-hidden="true">
					<path d="M4 12h15M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					</path>
				</svg>
			</button>
			<button class="lead__close" type="button" autofocus data-lead-close aria-label="Close">
				<svg class="ico" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
					<path d="m6.5 6.5 11 11M17.5 6.5l-11 11"/>
				</svg>
			</button>
		</div>
	</div>
</dialog>
<?php endif; ?>
<script src="<?php echo esc_url( WISEUP_URL . 'assets/js/lead-popup.js?ver=' . $wu_popup_ver ); ?>" defer></script>
