<?php
/**
 * Title: Related notes
 * Slug: batavia/related-notes
 * Categories: batavia, query
 * Description: Other posts sharing this one's first category, shown after the content. Nothing renders when the post has no category, or no other post shares it.
 * Keywords: related, similar, more, notes, recommendations
 * Block Types: core/query
 * Viewport Width: 1400
 *
 * The category checked is get_the_category()'s first entry -- a post
 * usually has one, and "related to every category this has" would mean
 * client work and personal notes recommending each other just because both
 * carry a second, incidental tag.
 *
 * Checked against a real WP_Query rather than relying on Query Loop's own
 * "No results" state, so an empty result hides the whole section -- heading
 * included -- rather than publishing a "Nothing here" note on every article
 * that happens to be alone in its category.
 *
 * @package Batavia
 * @since   1.5.0
 */

$batavia_related_category_id = 0;
$batavia_categories          = get_the_category();

if ( ! empty( $batavia_categories ) ) {
	$batavia_related_category_id = (int) $batavia_categories[0]->term_id;
}

if ( $batavia_related_category_id <= 0 ) {
	return;
}

$batavia_current_post_id = (int) get_the_ID();

$batavia_related_query = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'post__not_in'   => array( $batavia_current_post_id ),
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- One term derived from the current post, not user input.
			array(
				'taxonomy' => 'category',
				'terms'    => array( $batavia_related_category_id ),
			),
		),
	)
);

if ( ! $batavia_related_query->have_posts() ) {
	return;
}

$batavia_related_tax_query = wp_json_encode( array( 'include' => array( 'category' => array( $batavia_related_category_id ) ) ) );

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},"border":{"top":{"color":"var:preset|color|rule","width":"1px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="border-top-color:var(--wp--preset--color--rule);border-top-width:1px;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","contentSize":"46rem","wideSize":"76rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":2,"align":"wide","className":"is-style-batavia-label"} -->
		<h2 class="wp-block-heading alignwide is-style-batavia-label"><?php esc_html_e( 'Related notes', 'batavia' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[<?php echo $batavia_current_post_id; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Cast to int above, not user input. */ ?>],"sticky":"ignore","inherit":false,"taxQuery":<?php echo $batavia_related_tax_query; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already JSON-encoded by wp_json_encode(), and only ever a filtered category id, never user input. */ ?>,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
		<div class="wp-block-query alignwide">
			<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":3}} -->
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group">
				<!-- wp:post-date {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} /-->

				<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /-->
			</div>
			<!-- /wp:group -->
			<!-- /wp:post-template -->
		</div>
		<!-- /wp:query -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
