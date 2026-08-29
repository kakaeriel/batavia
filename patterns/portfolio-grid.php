<?php
/**
 * Title: Portfolio grid
 * Slug: celestine/portfolio-grid
 * Categories: celestine, portfolio, query
 * Description: A three-column grid of project cards built from a Query Loop. Open the block's Filters panel and choose your Portfolio category to limit it to project posts.
 * Keywords: portfolio, projects, work, grid, case studies
 * Block Types: core/query
 * Viewport Width: 1400
 *
 * @package Celestine
 * @since   1.0.0
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained","contentSize":"46rem","wideSize":"76rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":2,"align":"wide","className":"is-style-celestine-label"} -->
		<h2 class="wp-block-heading alignwide is-style-celestine-label"><?php esc_html_e( 'Selected work', 'celestine' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:query {"query":{"perPage":6,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"ignore","inherit":false,"taxQuery":null,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
		<div class="wp-block-query alignwide">
			<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","columnCount":3}} -->
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group">
				<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->

				<!-- wp:post-terms {"term":"category","textColor":"muted"} /-->

				<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"large"} /-->

				<!-- wp:post-excerpt {"excerptLength":18,"textColor":"muted","fontSize":"small"} /-->
			</div>
			<!-- /wp:group -->
			<!-- /wp:post-template -->

			<!-- wp:query-no-results -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color"><?php esc_html_e( 'No projects published yet. Add a post, assign it to your Portfolio category, and point this block at that category.', 'celestine' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- /wp:query-no-results -->
		</div>
		<!-- /wp:query -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
