<?php
/**
 * Title: Portfolio grid
 * Slug: batavia/portfolio-grid
 * Categories: batavia, portfolio, query
 * Description: A three-column grid of project cards built from a Query Loop. Choose a category from Appearance -> Batavia -> Homepage, or open the block's own Filters panel.
 * Keywords: portfolio, projects, work, grid, case studies
 * Block Types: core/query
 * Viewport Width: 1400
 *
 * The section can be turned off and pointed at a category from Appearance ->
 * Batavia -> Homepage -- see batavia_filter_query_loop_category() in
 * inc/bindings.php for how the category setting reaches this block without a
 * hardcoded taxQuery. The title is edited directly here, like the paragraph
 * below it.
 *
 * @package Batavia
 * @since   1.0.0
 */

if ( ! batavia_get_setting_bool( 'show_portfolio' ) ) {
	return;
}

?>
<!-- wp:group {"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},"border":{"top":{"color":"var:preset|color|rule","width":"1px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-surface-background-color has-background" style="border-top-color:var(--wp--preset--color--rule);border-top-width:1px;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","contentSize":"46rem","wideSize":"76rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":2,"align":"wide","className":"is-style-batavia-label"} -->
		<h2 class="wp-block-heading alignwide is-style-batavia-label"><?php esc_html_e( 'Selected work', 'batavia' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"large"} -->
		<p class="has-large-font-size"><?php esc_html_e( 'Client work and the occasional thing built for the fun of it. The picture is the screenshot; the title is the write-up.', 'batavia' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:query {"query":{"perPage":6,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"ignore","inherit":false,"taxQuery":null,"parents":[]},"align":"wide","className":"batavia-query-portfolio","layout":{"type":"default"}} -->
		<div class="wp-block-query alignwide batavia-query-portfolio">
			<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","columnCount":3}} -->
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group">
				<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->

				<!-- wp:post-terms {"term":"category","textColor":"muted"} /-->

				<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"large"} /-->
			</div>
			<!-- /wp:group -->
			<!-- /wp:post-template -->

			<!-- wp:query-no-results -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color"><?php esc_html_e( 'No projects published yet. Add a post, assign it to your Portfolio category, and point this block at that category.', 'batavia' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- /wp:query-no-results -->
		</div>
		<!-- /wp:query -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
