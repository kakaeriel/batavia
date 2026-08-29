<?php
/**
 * Title: 404 content
 * Slug: batavia/hidden-404
 * Inserter: no
 * Description: The message shown when a URL does not resolve, with a search field.
 *
 * @package Batavia
 * @since   1.0.0
 */

?>
<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide">
	<!-- wp:paragraph {"className":"is-style-batavia-label"} -->
	<p class="is-style-batavia-label"><?php esc_html_e( 'Error 404', 'batavia' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1,"fontSize":"xx-large"} -->
	<h1 class="wp-block-heading has-xx-large-font-size"><?php esc_html_e( 'That page is not here', 'batavia' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
	<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'The address may be mistyped, or the page may have been moved. Searching usually finds it.', 'batavia' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:search {"showLabel":false,"width":100,"widthUnit":"%","buttonPosition":"button-inside","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} /-->
</div>
<!-- /wp:group -->
