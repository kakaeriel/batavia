<?php
/**
 * Title: Writing index
 * Slug: celestine/blog-listing
 * Categories: celestine, posts, query
 * Description: A ruled index of recent posts, each row a title and a date. Open the block's Filters panel and choose your Blog category to limit it to written posts.
 * Keywords: blog, posts, writing, articles, index
 * Block Types: core/query
 * Viewport Width: 1400
 *
 * @package Celestine
 * @since   1.0.0
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","contentSize":"46rem","wideSize":"76rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":2,"align":"wide","className":"is-style-celestine-label"} -->
		<h2 class="wp-block-heading alignwide is-style-celestine-label"><?php esc_html_e( 'Writing', 'celestine' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:query {"query":{"perPage":5,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"ignore","inherit":false,"taxQuery":null,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
		<div class="wp-block-query alignwide">
			<!-- wp:post-template {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
			<!-- wp:group {"style":{"border":{"bottom":{"color":"var:preset|color|rule","width":"1px"}},"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
			<div class="wp-block-group" style="border-bottom-color:var(--wp--preset--color--rule);border-bottom-width:1px;padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)">
				<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"large"} /-->

				<!-- wp:post-date /-->
			</div>
			<!-- /wp:group -->
			<!-- /wp:post-template -->

			<!-- wp:query-no-results -->
			<!-- wp:paragraph {"textColor":"muted"} -->
			<p class="has-muted-color has-text-color"><?php esc_html_e( 'Nothing published yet.', 'celestine' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- /wp:query-no-results -->
		</div>
		<!-- /wp:query -->

		<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--20)">
			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'All posts', 'celestine' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
