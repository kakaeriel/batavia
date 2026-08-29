<?php
/**
 * Title: Hero
 * Slug: batavia/hero
 * Categories: batavia, banner, featured
 * Description: An opening statement: name, role, a one-line summary of the work, two calls to action, and a single ruled line of tools.
 * Keywords: hero, intro, headline, banner, about
 * Viewport Width: 1400
 *
 * The label, the name, the role and the first button read Appearance ->
 * Batavia -> Settings. Until those are filled in, the text below is what
 * shows -- which is why it reads as a finished page rather than as a form.
 *
 * The first button is bound to the contact link, which resolves to a booking
 * page, a WhatsApp chat or an email address, whichever is filled in. There is
 * no contact page to point it at, and that is deliberate.
 *
 * Every element here can also be turned off individually from Appearance ->
 * Batavia -> Homepage, for a page that does not want one of them. The tools
 * line's wording is edited directly here, like the summary paragraph below.
 *
 * @package Batavia
 * @since   1.0.0
 */

$batavia_show_name          = batavia_get_setting_bool( 'show_hero_name' );
$batavia_show_role          = batavia_get_setting_bool( 'show_hero_role' );
$batavia_show_description   = batavia_get_setting_bool( 'show_hero_description' );
$batavia_show_cta_primary   = batavia_get_setting_bool( 'show_hero_cta_primary' );
$batavia_show_cta_secondary = batavia_get_setting_bool( 'show_hero_cta_secondary' );
$batavia_show_tools         = batavia_get_setting_bool( 'show_hero_tools' );
$batavia_show_buttons       = $batavia_show_cta_primary || $batavia_show_cta_secondary;
$batavia_notes_archive_url  = batavia_notes_archive_url();

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"46rem","wideSize":"76rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<?php if ( $batavia_show_name ) : ?>
			<!-- wp:heading {"metadata":{"bindings":{"content":{"source":"batavia/setting","args":{"key":"name"}}}},"level":1,"fontSize":"xxx-large"} -->
			<h1 class="wp-block-heading has-xxx-large-font-size"><?php esc_html_e( 'Your Name', 'batavia' ); ?></h1>
			<!-- /wp:heading -->
		<?php endif; ?>

		<?php if ( $batavia_show_role ) : ?>
			<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"batavia/setting","args":{"key":"role"}}}},"textColor":"muted","fontFamily":"mono","fontSize":"large"} -->
			<p class="has-muted-color has-text-color has-large-font-size has-mono-font-family"><?php esc_html_e( 'What you do — and the two or three things you do it to', 'batavia' ); ?></p>
			<!-- /wp:paragraph -->
		<?php endif; ?>

		<?php if ( $batavia_show_description ) : ?>
			<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}},"fontSize":"large"} -->
			<p class="has-large-font-size" style="margin-top:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Two or three sentences on the work you want more of. Say what you are good at, who you do it for, and what someone gets out of hiring you or reading you — then stop. This paragraph is the one part of the page a visitor is certain to read.', 'batavia' ); ?></p>
			<!-- /wp:paragraph -->
		<?php endif; ?>

		<?php if ( $batavia_show_buttons ) : ?>
			<!-- wp:buttons {"style":{"spacing":{"blockGap":"var:preset|spacing|20","margin":{"top":"var:preset|spacing|30"}}}} -->
			<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--30)">
				<?php if ( $batavia_show_cta_primary ) : ?>
					<!-- wp:button {"metadata":{"bindings":{"url":{"source":"batavia/setting","args":{"key":"contact_url"}}}}} -->
					<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Get in touch', 'batavia' ); ?></a></div>
					<!-- /wp:button -->
				<?php endif; ?>

				<?php if ( $batavia_show_cta_secondary ) : ?>
					<!-- wp:button {"className":"is-style-outline"} -->
					<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $batavia_notes_archive_url ? $batavia_notes_archive_url : '#' ); ?>"><?php esc_html_e( 'Read the notes', 'batavia' ); ?></a></div>
					<!-- /wp:button -->
				<?php endif; ?>
			</div>
			<!-- /wp:buttons -->
		<?php endif; ?>

		<?php if ( $batavia_show_tools ) : ?>
			<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|20","margin":{"top":"var:preset|spacing|60"},"padding":{"top":"var:preset|spacing|30"}},"border":{"top":{"color":"var:preset|color|rule","width":"1px"}}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
			<div class="wp-block-group alignwide" style="border-top-color:var(--wp--preset--color--rule);border-top-width:1px;margin-top:var(--wp--preset--spacing--60);padding-top:var(--wp--preset--spacing--30)">
				<!-- wp:paragraph {"textColor":"muted","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"500"}},"fontFamily":"mono","fontSize":"x-small"} -->
				<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family" style="font-weight:500;letter-spacing:0.1em;text-transform:uppercase"><?php esc_html_e( 'Works with', 'batavia' ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"fontFamily":"mono","fontSize":"small"} -->
				<p class="has-small-font-size has-mono-font-family"><?php esc_html_e( 'WordPress · PHP · MySQL · Linux · Nginx · Git', 'batavia' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		<?php endif; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
