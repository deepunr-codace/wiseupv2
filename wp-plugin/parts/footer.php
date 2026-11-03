<?php
/**
 * WiseUp footer. Mirrors wiseup-site/src/components/Footer.astro (same markup and classes); keep the two in sync.
 * Variables: $wu_slug. The podcast page gets its own layout: logo and description, the podcast's social icons, then
 * Company, Resources and Elsewhere columns. Its links are fixed here, as in Footer.astro.
 */
defined( 'ABSPATH' ) || exit;

$wu_podcast = 'podcast' === $wu_slug;
$wu_social  = wiseup_opt( $wu_podcast ? 'social_podcast' : 'social' );
$wu_follow  = wiseup_opt( $wu_podcast ? 'follow_text_podcast' : 'follow_text' );
$wu_lists   = array(
	'quick'  => array( 'id' => 'ft-quick', 'title' => wiseup_opt( 'footer_h_quick' ), 'links' => wiseup_links( 'wiseup-footer-quick' ) ),
	'useful' => array( 'id' => 'ft-useful', 'title' => wiseup_opt( 'footer_h_useful' ), 'links' => wiseup_links( 'wiseup-footer-useful' ) ),
);
// Podcast columns, the same links as the podcastCompany / podcastResources / podcastElsewhere arrays in Footer.astro.
$wu_podcast_cols = array(
	array( 'id' => 'ft-company', 'title' => 'Company', 'links' => array(
		array( 'About WiseUp', home_url( '/about/' ), false ),
		array( 'Contact', home_url( '/contact/' ), false ),
		array( 'Sponsor the show', '#sponsor-enquiry', false ),
		array( 'Get featured', home_url( '/podcast/#get-featured' ), false ),
		array( "Brands we've worked with", '#brands', false ),
	) ),
	array( 'id' => 'ft-resources', 'title' => 'Resources', 'links' => array(
		array( 'Latest episodes', '#episodes', false ),
		array( 'Topics', '#topics', false ),
		array( 'Hosts', '#hosts', false ),
		array( 'FAQ', '#faq', false ),
	) ),
	array( 'id' => 'ft-elsewhere', 'title' => 'Elsewhere', 'links' => array(
		array( 'WiseUp TV', 'https://wiseup.in/wiseup-tv/', true ),
		array( 'WiseUp Studio', 'https://wiseup.in/wiseup-studio/', true ),
		array( 'WiseUp Branding', 'https://wiseup.in', true ),
		array( 'CodeAce IT Solutions', 'https://codeace.com/', true ),
	) ),
);
$wu_credit  = wiseup_opt( 'credit_name' );
$wu_tagline = $wu_podcast
	? 'A weekly Malayalam business podcast, watched by founders and business owners who are building their brands online.'
	: wiseup_opt( 'footer_tagline' );
?>
<footer class="ft">
	<div class="wrap ft__top">
		<div class="ft__intro">
			<?php if ( $wu_podcast ) : ?>
				<img class="ft__logo" src="<?php echo esc_url( wiseup_logo_url( true ) ); ?>" alt="WiseUp Podcast" width="404" height="174" loading="lazy" decoding="async">
			<?php endif; ?>
			<?php if ( $wu_tagline ) : ?><p class="<?php echo $wu_podcast ? 'ft__tag ft__tag--sm' : 'ft__tag'; ?>"><?php echo esc_html( $wu_tagline ); ?></p><?php endif; ?>
			<?php if ( ! $wu_podcast ) : ?>
				<p class="ft__pillars">Strategy<span aria-hidden="true">|</span>Marketing<span aria-hidden="true">|</span>Production</p>
			<?php endif; ?>
			<?php if ( $wu_podcast ) : ?>
				<ul class="ft__social">
					<?php foreach ( wiseup_networks() as $network => $label ) : ?>
						<?php if ( empty( $wu_social[ $network ] ) ) continue; ?>
						<li><a class="ft__soc ft__soc--<?php echo esc_attr( wiseup_social_mod( $network ) ); ?>" href="<?php echo esc_url( wiseup_social_href( $network, $wu_social[ $network ] ) ); ?>"<?php echo 'email' === $network ? '' : ' target="_blank"'; ?> rel="me noopener" aria-label="<?php echo esc_attr( $label ); ?>"><?php echo wiseup_icon( $network ); // phpcs:ignore -- static SVG ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<?php if ( $wu_podcast ) : ?>
			<?php foreach ( $wu_podcast_cols as $col ) : ?>
				<nav class="ft__col" aria-labelledby="<?php echo esc_attr( $col['id'] ); ?>">
					<h2 class="ft__h" id="<?php echo esc_attr( $col['id'] ); ?>"><?php echo esc_html( $col['title'] ); ?></h2>
					<ul>
						<?php foreach ( $col['links'] as $l ) : ?>
							<li><a class="ft__link" href="<?php echo esc_url( $l[1] ); ?>"<?php echo $l[2] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $l[0] ); ?><?php if ( $l[2] ) : ?><span class="ft__ext" aria-hidden="true">↗</span><?php endif; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endforeach; ?>
		<?php else : ?>
			<?php foreach ( $wu_lists as $list ) : ?>
				<nav class="ft__col" aria-labelledby="<?php echo esc_attr( $list['id'] ); ?>">
					<h2 class="ft__h" id="<?php echo esc_attr( $list['id'] ); ?>"><?php echo esc_html( $list['title'] ); ?></h2>
					<ul>
						<?php foreach ( $list['links'] as $l ) : ?>
							<li><a class="ft__link" href="<?php echo esc_url( $l['url'] ); ?>"<?php echo $l['external'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $l['label'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endforeach; ?>
			<div class="ft__col ft__follow">
				<h2 class="ft__h"><?php echo esc_html( wiseup_opt( 'footer_h_follow' ) ); ?></h2>
				<?php if ( $wu_follow ) : ?><p><?php echo esc_html( $wu_follow ); ?></p><?php endif; ?>
				<ul class="ft__social">
					<?php foreach ( wiseup_networks() as $network => $label ) : ?>
						<?php if ( empty( $wu_social[ $network ] ) ) continue; ?>
						<li><a class="ft__soc ft__soc--<?php echo esc_attr( wiseup_social_mod( $network ) ); ?>" href="<?php echo esc_url( wiseup_social_href( $network, $wu_social[ $network ] ) ); ?>"<?php echo 'email' === $network ? '' : ' target="_blank"'; ?> rel="me noopener" aria-label="<?php echo esc_attr( $label ); ?>"><?php echo wiseup_icon( $network ); // phpcs:ignore -- static SVG ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
	<?php if ( wiseup_opt( 'wordmark' ) ) : ?>
		<div class="ft__word" aria-hidden="true" data-ft-word><span class="ft__word-text">wiseup</span><canvas class="ft__canvas"></canvas></div>
	<?php endif; ?>
		<div class="wrap ft__base">
			<p>© <?php echo esc_html( gmdate( 'Y' ) . ' ' . wiseup_opt( 'copyright' ) ); ?></p>
			<?php if ( $wu_credit ) : ?>
				<p><?php esc_html_e( 'Crafted by', 'wiseup' ); ?> <?php if ( wiseup_opt( 'credit_url' ) ) : ?><a class="ft__credit" href="<?php echo esc_url( wiseup_opt( 'credit_url' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $wu_credit ); ?></a><?php else : ?><b class="ft__credit"><?php echo esc_html( $wu_credit ); ?></b><?php endif; ?></p>
			<?php endif; ?>
		</div>
</footer>
