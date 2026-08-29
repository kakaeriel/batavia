<?php
/**
 * Title: Experience timeline
 * Slug: celestine/experience-timeline
 * Categories: celestine, text, about
 * Description: A ruled chronological rail of roles and companies, each with dates and a short description.
 * Keywords: experience, timeline, career, roles, history, resume
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
		<!-- wp:heading {"level":2,"className":"is-style-celestine-label"} -->
		<h2 class="wp-block-heading is-style-celestine-label"><?php esc_html_e( 'Experience', 'celestine' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:group {"className":"is-style-celestine-timeline","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-celestine-timeline">
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group">
				<!-- wp:paragraph {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
				<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family"><?php esc_html_e( '2021 — Present', 'celestine' ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:heading {"level":3,"fontSize":"large"} -->
				<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Principal Engineer, Northwind Data', 'celestine' ); ?></h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"textColor":"muted"} -->
				<p class="has-muted-color has-text-color"><?php esc_html_e( 'Owned the storage layer through a rewrite from a single Postgres primary to a sharded, multi-region cluster. Cut p99 write latency by two thirds and took the on-call page count down with it.', 'celestine' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group">
				<!-- wp:paragraph {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
				<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family"><?php esc_html_e( '2017 — 2021', 'celestine' ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:heading {"level":3,"fontSize":"large"} -->
				<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Staff Engineer, Halyard Systems', 'celestine' ); ?></h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"textColor":"muted"} -->
				<p class="has-muted-color has-text-color"><?php esc_html_e( 'Built the event pipeline that every other team eventually depended on. Wrote the runbooks, then spent two years making most of them unnecessary.', 'celestine' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group">
				<!-- wp:paragraph {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
				<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family"><?php esc_html_e( '2013 — 2017', 'celestine' ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:heading {"level":3,"fontSize":"large"} -->
				<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Senior Engineer, Ferrous Labs', 'celestine' ); ?></h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"textColor":"muted"} -->
				<p class="has-muted-color has-text-color"><?php esc_html_e( 'Backend and infrastructure for a product that went from four customers to four thousand. Learned what actually breaks at each order of magnitude.', 'celestine' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
