<?php
/**
 * Title: Post index
 * Slug: batavia/blog-listing
 * Categories: batavia, posts, query
 * Description: Recent posts as article entries: thumbnail, date, category, title and the opening sentences. Choose a category from Appearance -> Batavia -> Homepage, or open the block's own Filters panel.
 * Keywords: blog, posts, writing, notes, articles, index
 * Block Types: core/query
 * Viewport Width: 1400
 *
 * This was a row of titles and dates, which is an archive listing, not an
 * invitation to read. An entry now carries the two things a reader decides on
 * -- what it is about and how it opens -- and the thumbnail is simply left out
 * on posts that have no featured image.
 *
 * The section can be turned off and pointed at -- or away from -- a category
 * from Appearance -> Batavia -> Homepage, or by opening the block's own
 * Filters panel. See batavia_category_tax_query() in inc/settings.php for why
 * that value is baked into the query below rather than filtered in later.
 * The title is edited directly here, like any other heading.
 *
 * @package Batavia
 * @since   1.0.0
 */

if ( ! batavia_get_setting_bool( 'show_notes' ) ) {
	return;
}

$batavia_notes_scope       = batavia_get_category_scope( 'notes_category_mode', 'notes_category' );
$batavia_notes_category_id = absint( batavia_get_setting( 'notes_category' ) );
$batavia_notes_tax_query   = batavia_category_tax_query( 'notes_category', 'notes_category_mode' );
$batavia_notes_archive_url = ( 'specific' === $batavia_notes_scope && $batavia_notes_category_id > 0 )
	? get_category_link( $batavia_notes_category_id )
	: batavia_posts_page_url();

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},"border":{"top":{"color":"var:preset|color|rule","width":"1px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="border-top-color:var(--wp--preset--color--rule);border-top-width:1px;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","contentSize":"46rem","wideSize":"76rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":2,"align":"wide","className":"is-style-batavia-label"} -->
		<h2 class="wp-block-heading alignwide is-style-batavia-label"><?php esc_html_e( 'Notes', 'batavia' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:query {"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"ignore","inherit":false,"taxQuery":<?php echo $batavia_notes_tax_query; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already JSON-encoded by batavia_category_tax_query(), and only ever `null` or a filtered category id, never user input. */ ?>,"parents":[]},"align":"wide","className":"batavia-query-notes","layout":{"type":"default"}} -->
		<div class="wp-block-query alignwide batavia-query-notes">
			<!-- wp:post-template {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
			<!-- wp:group {"className":"is-style-batavia-entry","style":{"spacing":{"blockGap":"var:preset|spacing|40","padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"top"}} -->
			<div class="wp-block-group is-style-batavia-entry" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">
				<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","width":"12rem"} /-->

				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"40rem","justifyContent":"left"}} -->
				<div class="wp-block-group">
					<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
					<div class="wp-block-group">
						<!-- wp:post-date /-->

						<!-- wp:post-terms {"term":"category","textColor":"muted"} /-->
					</div>
					<!-- /wp:group -->

					<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"x-large"} /-->

					<!-- wp:post-excerpt {"excerptLength":26,"textColor":"muted","fontSize":"small"} /-->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
			<!-- /wp:post-template -->

			<!-- wp:query-no-results -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color"><?php esc_html_e( 'Nothing published yet.', 'batavia' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- /wp:query-no-results -->
		</div>
		<!-- /wp:query -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $batavia_notes_archive_url ? $batavia_notes_archive_url : '#' ); ?>"><?php esc_html_e( 'All notes', 'batavia' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
