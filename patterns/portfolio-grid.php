<?php
/**
 * Title: Portfolio grid
 * Slug: batavia/portfolio-grid
 * Categories: batavia, portfolio, query
 * Description: A two-column grid of project cards built from a Query Loop, the screenshot doing most of the talking. Choose a category from Appearance -> Batavia -> Homepage, or open the block's own Filters panel.
 * Keywords: portfolio, projects, work, grid, case studies
 * Block Types: core/query
 * Viewport Width: 1400
 *
 * The section can be turned off and pointed at -- or away from -- a category
 * from Appearance -> Batavia -> Homepage, or by opening the block's own
 * Filters panel. See batavia_category_tax_query() in inc/settings.php for why
 * that value is baked into the query below rather than filtered in later.
 * The title and paragraph are edited directly here, like any other heading.
 *
 * Two columns rather than three, so a screenshot reads as a screenshot
 * instead of a thumbnail. No category badge: once this is scoped to one
 * category the badge would repeat the same word under every card, which
 * reads as an oversight rather than as information. The hover state is the
 * rule under the image shifting from Rule to Accent, not a shadow or a zoom,
 * to stay on the same hairline-and-flat-colour vocabulary as everything else
 * in the theme.
 *
 * @package Batavia
 * @since   1.0.0
 */

if ( ! batavia_get_setting_bool( 'show_portfolio' ) ) {
	return;
}

$batavia_portfolio_tax_query = batavia_category_tax_query( 'portfolio_category' );

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

		<!-- wp:query {"query":{"perPage":6,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"ignore","inherit":false,"taxQuery":<?php echo $batavia_portfolio_tax_query; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already JSON-encoded by batavia_category_tax_query(), and only ever `null` or a filtered category id, never user input. */ ?>,"parents":[]},"align":"wide","className":"batavia-query-portfolio","layout":{"type":"default"}} -->
		<div class="wp-block-query alignwide batavia-query-portfolio">
			<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|60"}},"layout":{"type":"grid","columnCount":2}} -->
			<!-- wp:group {"className":"is-style-batavia-project","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group is-style-batavia-project">
				<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->

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
