<?php
/**
 * Title: Sidebar: Consulting
 * Slug: batavia/widget-consulting
 * Categories: batavia, text
 * Description: A short teaser for the Consulting rates section, for the post detail sidebar.
 * Keywords: sidebar, widget, consulting, rates, pricing
 * Inserter: no
 *
 * Off whenever the front page's own Consulting section is, from Appearance
 * -> Batavia -> Homepage -- see widget-notes.php for why.
 *
 * @package Batavia
 * @since   1.5.0
 */

if ( ! batavia_get_setting_bool( 'show_consulting' ) ) {
	return;
}

?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:heading {"level":3,"className":"is-style-batavia-label"} -->
	<h3 class="wp-block-heading is-style-batavia-label"><?php esc_html_e( 'Consulting', 'batavia' ); ?></h3>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size"><?php esc_html_e( 'Advisory, project work and standing capacity, as ruled rows rather than a pricing page.', 'batavia' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'See rates', 'batavia' ); ?></a></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
