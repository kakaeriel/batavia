<?php
/**
 * Title: Sidebar: Selected work
 * Slug: batavia/widget-work
 * Categories: batavia, query, portfolio
 * Description: A random sample of projects for the post detail sidebar. Reads the same category as the front page's Selected work section.
 * Keywords: sidebar, widget, portfolio, work, projects
 * Block Types: core/query
 * Inserter: no
 *
 * Off whenever the front page's own Selected work section is, from
 * Appearance -> Batavia -> Homepage -- see widget-notes.php for why. Ordered
 * randomly rather than by date, so a sidebar sitting on the same post for a
 * while does not always point at the same three projects.
 *
 * @package Batavia
 * @since   1.5.0
 */

if ( ! batavia_get_setting_bool( 'show_portfolio' ) ) {
	return;
}

$batavia_widget_portfolio_tax_query = batavia_category_tax_query( 'portfolio_category' );
$batavia_current_post_id            = (int) get_the_ID();

$batavia_portfolio_category_id = absint( batavia_get_setting( 'portfolio_category' ) );
$batavia_widget_work_url       = $batavia_portfolio_category_id > 0
	? get_category_link( $batavia_portfolio_category_id )
	: batavia_posts_page_url();

?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:heading {"level":3,"className":"is-style-batavia-label"} -->
	<h3 class="wp-block-heading is-style-batavia-label"><?php esc_html_e( 'Selected work', 'batavia' ); ?></h3>
	<!-- /wp:heading -->

	<!-- wp:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"rand","author":"","search":"","exclude":[<?php echo $batavia_current_post_id; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Cast to int above, not user input. */ ?>],"sticky":"ignore","inherit":false,"taxQuery":<?php echo $batavia_widget_portfolio_tax_query; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already JSON-encoded by batavia_category_tax_query(), and only ever `null` or a filtered category id, never user input. */ ?>,"parents":[]},"layout":{"type":"default"}} -->
	<div class="wp-block-query">
		<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}}} -->
		<!-- wp:post-title {"level":4,"isLink":true,"fontSize":"small"} /-->
		<!-- /wp:post-template -->

		<!-- wp:query-no-results -->
		<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
		<p class="has-muted-color has-text-color has-small-font-size"><?php esc_html_e( 'No projects published yet.', 'batavia' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->

	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size"><a href="<?php echo esc_url( $batavia_widget_work_url ? $batavia_widget_work_url : '#' ); ?>"><?php esc_html_e( 'View all work', 'batavia' ); ?></a></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
