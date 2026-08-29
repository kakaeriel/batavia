<?php
/**
 * Title: Closing call to action
 * Slug: celestine/cta-footer
 * Categories: celestine, call-to-action, contact
 * Description: A closing section inviting the reader to get in touch, set on a tinted band above the site footer.
 * Keywords: cta, contact, booking, hire, enquiry
 * Viewport Width: 1400
 *
 * @package Celestine
 * @since   1.0.0
 */

?>
<!-- wp:group {"align":"full","backgroundColor":"surface","style":{"border":{"top":{"color":"var:preset|color|rule","width":"1px"}},"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-surface-background-color has-background" style="border-top-color:var(--wp--preset--color--rule);border-top-width:1px;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"46rem","wideSize":"76rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"className":"is-style-celestine-label"} -->
		<p class="is-style-celestine-label"><?php esc_html_e( 'Next step', 'celestine' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"fontSize":"xx-large"} -->
		<h2 class="wp-block-heading has-xx-large-font-size"><?php esc_html_e( 'Got a system that needs attention?', 'celestine' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
		<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Send a short description of the problem and what you have tried. If it is something I can help with, you will get a straight answer and a proposal within two working days.', 'celestine' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"style":{"spacing":{"blockGap":"var:preset|spacing|20","margin":{"top":"var:preset|spacing|20"}}}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--20)">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Book a call', 'celestine' ); ?></a></div>
			<!-- /wp:button -->

			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Send an email', 'celestine' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
