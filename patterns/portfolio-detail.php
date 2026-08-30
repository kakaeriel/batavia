<?php
/**
 * Title: Portfolio detail
 * Slug: batavia/portfolio-detail
 * Categories: batavia, text, portfolio
 * Description: A project's facts -- client, role, timeline, stack, live link -- as monospace rows on hairline rules, meant for the top of a portfolio post's content.
 * Keywords: portfolio, project, case study, client, meta, details
 * Viewport Width: 800
 *
 * Insert at the top of a portfolio post's content, before the write-up.
 * Delete a row that does not apply to a project rather than leaving it
 * blank, the same as Specification table.
 *
 * @package Batavia
 * @since   1.5.0

?>
<!-- wp:table {"className":"is-style-batavia-spec"} -->
<figure class="wp-block-table is-style-batavia-spec"><table class="has-fixed-layout"><tbody><tr><td><?php esc_html_e( 'Client', 'batavia' ); ?></td><td><?php esc_html_e( 'Who the work was for', 'batavia' ); ?></td></tr><tr><td><?php esc_html_e( 'Role', 'batavia' ); ?></td><td><?php esc_html_e( 'What you actually did', 'batavia' ); ?></td></tr><tr><td><?php esc_html_e( 'Timeline', 'batavia' ); ?></td><td><?php esc_html_e( 'Jan – Mar 2026', 'batavia' ); ?></td></tr><tr><td><?php esc_html_e( 'Stack', 'batavia' ); ?></td><td><?php esc_html_e( 'WordPress, PHP, MySQL', 'batavia' ); ?></td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--20)">
	<!-- wp:button {"className":"is-style-outline"} -->
	<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Visit the live site', 'batavia' ); ?></a></div>
	<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
