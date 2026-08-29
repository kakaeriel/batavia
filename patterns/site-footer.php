<?php
/**
 * Title: Site footer
 * Slug: celestine/site-footer
 * Categories: celestine, footer
 * Description: Site identity and secondary navigation above a monospace colophon.
 * Keywords: footer, colophon, credits
 * Block Types: core/template-part/footer
 * Viewport Width: 1400
 *
 * @package Celestine
 * @since   1.0.0
 */

?>
<!-- wp:group {"align":"full","style":{"border":{"top":{"color":"var:preset|color|rule","width":"1px"}},"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="border-top-color:var(--wp--preset--color--rule);border-top-width:1px;padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--50)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|60"}},"layout":{"type":"constrained","contentSize":"46rem","wideSize":"76rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
		<div class="wp-block-group alignwide">
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group">
				<!-- wp:site-title {"level":0} /-->

				<!-- wp:site-tagline {"textColor":"muted","fontSize":"small"} /-->
			</div>
			<!-- /wp:group -->

			<!-- wp:navigation {"overlayMenu":"never","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"right"}} /-->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
		<div class="wp-block-group alignwide">
			<!-- wp:paragraph {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
			<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family">
			<?php
			printf(
				/* translators: %s: The current year, for example 2026. */
				esc_html__( '© %s', 'celestine' ),
				esc_html( gmdate( 'Y' ) )
			);
			?>
			</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
			<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family"><a href="<?php echo esc_url( __( 'https://wordpress.org/', 'celestine' ) ); ?>" rel="nofollow"><?php esc_html_e( 'Proudly powered by WordPress', 'celestine' ); ?></a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
