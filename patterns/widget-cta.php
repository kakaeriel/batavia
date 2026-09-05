<?php
/**
 * Title: Sidebar: Get in touch
 * Slug: batavia/widget-cta
 * Categories: batavia, text
 * Description: A compact call to action for the post detail sidebar, reading the same contact link as the front page's Closing call to action.
 * Keywords: sidebar, widget, cta, contact, get in touch
 * Inserter: no
 *
 * Off whenever the front page's own Closing call to action is, from
 * Appearance -> Customize -> Batavia -- see widget-notes.php for why.
 *
 * @package Batavia
 * @since   1.5.0
 */

if ( ! batavia_get_setting_bool( 'show_cta' ) ) {
	return;
}

?>
<!-- wp:group {"backgroundColor":"surface","style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30)">
	<!-- wp:heading {"level":3,"className":"is-style-batavia-label"} -->
	<h3 class="wp-block-heading is-style-batavia-label"><?php esc_html_e( 'Get in touch', 'batavia' ); ?></h3>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size"><?php esc_html_e( 'Have something worth building? Tell me what you are trying to do.', 'batavia' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"metadata":{"bindings":{"url":{"source":"batavia/setting","args":{"key":"contact_url"}}}}} -->
		<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Get in touch', 'batavia' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
