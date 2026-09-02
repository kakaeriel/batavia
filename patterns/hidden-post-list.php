<?php
/**
 * Title: Post list
 * Slug: batavia/hidden-post-list
 * Inserter: no
 * Description: The paginated list of posts shared by the index, archive and search templates. Inherits the query from the page it appears on.
 *
 * The entry is the same shape as the one on the front page, so the notes
 * index and the archives are recognisably the same list rather than two designs
 * for one job.
 *
 * The one exception is the archive for whichever category Selected work is
 * scoped to, from Appearance -> Batavia -> Homepage: that page gets the
 * portfolio grid's own two-column, image-forward layout instead, since a
 * list of dates and excerpts is the wrong shape for a page of screenshots.
 * Everywhere else -- the blog index, other category archives, search --
 * keeps the list.
 *
 * @package Batavia
 * @since   1.0.0
 */

$batavia_portfolio_category_id = absint( batavia_get_setting( 'portfolio_category' ) );
$batavia_is_portfolio_archive  = $batavia_portfolio_category_id > 0 && is_category( $batavia_portfolio_category_id );

?>
<?php if ( $batavia_is_portfolio_archive ) : ?>
	<!-- wp:query {"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
	<div class="wp-block-query alignwide">
		<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|60"}},"layout":{"type":"grid","columnCount":2}} -->
		<!-- wp:group {"className":"is-style-batavia-project","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-batavia-project">
			<!-- wp:post-featured-image {"isLink":true} /-->

			<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"large"} /-->
		</div>
		<!-- /wp:group -->
		<!-- /wp:post-template -->

		<!-- wp:query-pagination {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}},"layout":{"type":"flex","justifyContent":"space-between"}} -->
		<!-- wp:query-pagination-previous /-->

		<!-- wp:query-pagination-numbers /-->

		<!-- wp:query-pagination-next /-->
		<!-- /wp:query-pagination -->

		<!-- wp:query-no-results -->
		<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
		<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Nothing here yet.', 'batavia' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
<?php else : ?>
	<!-- wp:query {"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
	<div class="wp-block-query alignwide">
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

				<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"x-large"} /-->

				<!-- wp:post-excerpt {"excerptLength":32,"textColor":"muted","fontSize":"small"} /-->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
		<!-- /wp:post-template -->

		<!-- wp:query-pagination {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}},"layout":{"type":"flex","justifyContent":"space-between"}} -->
		<!-- wp:query-pagination-previous /-->

		<!-- wp:query-pagination-numbers /-->

		<!-- wp:query-pagination-next /-->
		<!-- /wp:query-pagination -->

		<!-- wp:query-no-results -->
		<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
		<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Nothing here yet.', 'batavia' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
<?php endif; ?>
