<?php
/**
 * Title: Index header
 * Slug: batavia/hidden-index-header
 * Inserter: no
 * Description: The heading and standfirst above the posts index.
 *
 * The blog index has no title of its own to render -- the page assigned as the
 * posts page contributes its name to the menu, not to the template -- so the
 * heading lives here. Edit it in the Site Editor if your writing goes by
 * another name.
 *
 * @package Batavia
 * @since   1.3.0
 */

?>
<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|20","margin":{"bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="margin-bottom:var(--wp--preset--spacing--50)">
	<!-- wp:heading {"level":1,"fontSize":"xx-large"} -->
		<h1 class="wp-block-heading has-xx-large-font-size"><?php esc_html_e( 'Notes', 'batavia' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
	<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Notes on the work: what broke, what fixed it, and what turned out to be worth writing down.', 'batavia' ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
