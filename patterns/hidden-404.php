<?php
/**
 * Title: 404 content
 * Slug: celestine/hidden-404
 * Inserter: no
 * Description: The message shown when a URL does not resolve, with a search field.
 *
 * @package Celestine
 * @since   1.0.0
 */

?>
<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide">
	<!-- wp:paragraph {"className":"is-style-celestine-label"} -->
	<p class="is-style-celestine-label"><?php esc_html_e( 'Error 404', 'celestine' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1,"fontSize":"xx-large"} -->
	<h1 class="wp-block-heading has-xx-large-font-size"><?php esc_html_e( 'That page is not here', 'celestine' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
	<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'The address may be mistyped, or the page may have been moved. Searching usually finds it.', 'celestine' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:search {"showLabel":false,"width":100,"widthUnit":"%","buttonPosition":"button-inside","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} /-->
</div>
<!-- /wp:group -->
