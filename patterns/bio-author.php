<?php
/**
 * Title: About the author
 * Slug: batavia/bio-author
 * Categories: batavia, about, text
 * Description: A short bio for the end of an article: name, role and social icons, all taken from the theme's settings.
 * Keywords: author, bio, about, byline, profile
 * Viewport Width: 800
 *
 * The name, the role and every icon read Appearance -> Customize -> Batavia.
 * That is the point of this one: dropped at the end of fifty posts, it is still
 * a single place to correct a job title.
 *
 * @package Batavia
 * @since   1.2.0
 */

?>
<!-- wp:group {"className":"is-style-batavia-panel","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-batavia-panel">
	<!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"metadata":{"bindings":{"content":{"source":"batavia/setting","args":{"key":"name"}}}},"level":2,"fontSize":"medium"} -->
		<h2 class="wp-block-heading has-medium-font-size"><?php esc_html_e( 'Your Name', 'batavia' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"batavia/setting","args":{"key":"role"}}}},"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
		<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family"><?php esc_html_e( 'What you do — and the two or three things you do it to', 'batavia' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size"><?php esc_html_e( 'Two sentences on why you are worth listening to on this subject in particular. A bio that would fit any article on the site is a bio nobody reads.', 'batavia' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:social-links {"size":"has-small-icon-size","className":"is-style-logos-only","layout":{"type":"flex","justifyContent":"left"}} -->
	<ul class="wp-block-social-links has-small-icon-size is-style-logos-only">
		<!-- wp:social-link {"service":"github"} /-->

		<!-- wp:social-link {"service":"x"} /-->

		<!-- wp:social-link {"service":"bluesky"} /-->

		<!-- wp:social-link {"service":"mastodon"} /-->

		<!-- wp:social-link {"service":"linkedin"} /-->

		<!-- wp:social-link {"service":"instagram"} /-->

		<!-- wp:social-link {"service":"youtube"} /-->
	</ul>
	<!-- /wp:social-links -->
</div>
<!-- /wp:group -->
