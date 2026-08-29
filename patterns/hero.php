<?php
/**
 * Title: Hero
 * Slug: celestine/hero
 * Categories: celestine, banner, featured
 * Description: An opening statement: availability, name, role, a one-line summary of the work, and two calls to action.
 * Keywords: hero, intro, headline, banner, about
 * Viewport Width: 1400
 *
 * @package Celestine
 * @since   1.0.0
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"46rem","wideSize":"76rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"className":"is-style-celestine-label"} -->
		<p class="is-style-celestine-label"><?php esc_html_e( 'Available for new work', 'celestine' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":1,"fontSize":"xxx-large"} -->
		<h1 class="wp-block-heading has-xxx-large-font-size"><?php esc_html_e( 'Your Name', 'celestine' ); ?></h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"textColor":"muted","fontFamily":"mono","fontSize":"large"} -->
		<p class="has-muted-color has-text-color has-large-font-size has-mono-font-family"><?php esc_html_e( 'Principal Engineer — distributed systems, storage, reliability', 'celestine' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}},"fontSize":"large"} -->
		<p class="has-large-font-size" style="margin-top:var(--wp--preset--spacing--20)"><?php esc_html_e( 'I work on the parts of a system that are not allowed to fail: consensus, storage engines, and the unglamorous reliability work underneath them. Fifteen years of it, mostly at companies whose outages make the news.', 'celestine' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"style":{"spacing":{"blockGap":"var:preset|spacing|20","margin":{"top":"var:preset|spacing|30"}}}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--30)">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Book a call', 'celestine' ); ?></a></div>
			<!-- /wp:button -->

			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Read the writing', 'celestine' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
