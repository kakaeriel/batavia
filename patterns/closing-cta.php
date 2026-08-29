<?php
/**
 * Title: Closing call to action
 * Slug: batavia/closing-cta
 * Categories: batavia, banner, call-to-action
 * Description: A closing invitation to get in touch, just above the footer. The button reads the same contact link as Hero's primary button -- a booking page, WhatsApp or email, whichever is filled in.
 * Keywords: cta, contact, get in touch, whatsapp, email, closing
 * Viewport Width: 1400
 *
 * Deliberately a button, not a form: Batavia ships without a contact page on
 * purpose (see Appearance -> Batavia -> Contact), and a form here would mean
 * a submission handler, spam handling and outgoing mail -- the "no external
 * requests" a WordPress.org review holds a theme to. Reusing Hero's own
 * contact_url binding keeps this section truthful to that: it can only ever
 * open WhatsApp, an email client or a booking page the site owner already
 * chose, never collect anything itself.
 *
 * Can be turned off from Appearance -> Batavia -> Homepage. The heading and
 * paragraph are edited directly here, like Hero's own wording.
 *
 * @package Batavia
 * @since   1.4.0
 */

if ( ! batavia_get_setting_bool( 'show_cta' ) ) {
	return;
}

?>
<!-- wp:group {"align":"full","backgroundColor":"ink","textColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-color has-ink-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"36rem","wideSize":"76rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":2,"fontSize":"xx-large"} -->
		<h2 class="wp-block-heading has-xx-large-font-size"><?php esc_html_e( 'Have something worth building?', 'batavia' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"large"} -->
		<p class="has-large-font-size"><?php esc_html_e( 'Tell me what you are trying to do. If it is a fit, you will hear back within a day.', 'batavia' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--30)">
			<!-- wp:button {"metadata":{"bindings":{"url":{"source":"batavia/setting","args":{"key":"contact_url"}}}}} -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Get in touch', 'batavia' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
