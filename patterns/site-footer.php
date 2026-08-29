<?php
/**
 * Title: Site footer
 * Slug: batavia/site-footer
 * Categories: batavia, footer
 * Description: Site identity, secondary navigation and social icons above a monospace colophon.
 * Keywords: footer, colophon, credits, social
 * Block Types: core/template-part/footer
 * Viewport Width: 1400
 *
 * The icons cover every service Appearance -> Batavia -> Settings offers, so
 * filling in a field is all it takes for one to appear. Icons with nothing to
 * point at are dropped before the page is sent, so the strip only ever shows the
 * profiles that exist -- which is why the editor shows more icons here than the
 * published page does.
 *
 * @package Batavia
 * @since   1.0.0
 */

$batavia_copyright_text = batavia_get_setting( 'copyright_text' );

?>
<!-- wp:group {"align":"full","style":{"border":{"top":{"color":"var:preset|color|rule","width":"1px"}},"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="border-top-color:var(--wp--preset--color--rule);border-top-width:1px;padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--50)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained","contentSize":"46rem","wideSize":"76rem","justifyContent":"left"}} -->
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

		<!-- wp:social-links {"size":"has-small-icon-size","className":"is-style-logos-only","layout":{"type":"flex","justifyContent":"left"}} -->
		<ul class="wp-block-social-links has-small-icon-size is-style-logos-only">
			<!-- wp:social-link {"service":"github"} /-->

			<!-- wp:social-link {"service":"x"} /-->

			<!-- wp:social-link {"service":"bluesky"} /-->

			<!-- wp:social-link {"service":"mastodon"} /-->

			<!-- wp:social-link {"service":"linkedin"} /-->

			<!-- wp:social-link {"service":"instagram"} /-->

			<!-- wp:social-link {"service":"youtube"} /-->

			<!-- wp:social-link {"service":"facebook"} /-->

			<!-- wp:social-link {"service":"threads"} /-->

			<!-- wp:social-link {"service":"tiktok"} /-->

			<!-- wp:social-link {"service":"telegram"} /-->

			<!-- wp:social-link {"service":"codepen"} /-->

			<!-- wp:social-link {"service":"dribbble"} /-->

			<!-- wp:social-link {"service":"medium"} /-->
		</ul>
		<!-- /wp:social-links -->

		<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
		<div class="wp-block-group alignwide">
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
			<div class="wp-block-group">
				<!-- wp:paragraph {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
				<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family">
				<?php if ( '' !== $batavia_copyright_text ) : ?>
					<?php echo esc_html( $batavia_copyright_text ); ?>
				<?php else : ?>
					<?php
					printf(
						/* translators: %s: The current year, for example 2026. */
						esc_html__( '© %s', 'batavia' ),
						esc_html( gmdate( 'Y' ) )
					);
					?>
				<?php endif; ?>
				</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"batavia/setting","args":{"key":"location"}}}},"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
				<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family"><?php esc_html_e( 'Your location', 'batavia' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:paragraph {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
			<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family"><a href="<?php echo esc_url( __( 'https://wordpress.org/', 'batavia' ) ); ?>" rel="nofollow"><?php esc_html_e( 'Proudly powered by WordPress', 'batavia' ); ?></a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
