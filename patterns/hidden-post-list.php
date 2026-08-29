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
 * @package Batavia
 * @since   1.0.0
 */

?>
<!-- wp:query {"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide">
	<!-- wp:post-template {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
	<!-- wp:group {"className":"is-style-batavia-entry","style":{"border":{"bottom":{"color":"var:preset|color|rule","width":"1px"}},"spacing":{"blockGap":"var:preset|spacing|40","padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"top"}} -->
	<div class="wp-block-group is-style-batavia-entry" style="border-bottom-color:var(--wp--preset--color--rule);border-bottom-width:1px;padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">
		<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","width":"12rem"} /-->

		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"40rem"}} -->
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
