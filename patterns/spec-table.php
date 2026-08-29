<?php
/**
 * Title: Specification table
 * Slug: batavia/spec-table
 * Categories: batavia, text
 * Description: Key and value rows set in monospace on hairline rules, for versions, limits, dimensions and anything else that is really data.
 * Keywords: table, spec, specification, data, versions, environment, parameters
 * Block Types: core/table
 * Viewport Width: 800
 *
 * @package Batavia
 * @since   1.2.0
 */

?>
<!-- wp:table {"className":"is-style-batavia-spec"} -->
<figure class="wp-block-table is-style-batavia-spec"><table class="has-fixed-layout"><tbody><tr><td><?php esc_html_e( 'Runtime', 'batavia' ); ?></td><td><?php esc_html_e( 'PHP 8.3', 'batavia' ); ?></td></tr><tr><td><?php esc_html_e( 'Database', 'batavia' ); ?></td><td><?php esc_html_e( 'PostgreSQL 16', 'batavia' ); ?></td></tr><tr><td><?php esc_html_e( 'Requests per second', 'batavia' ); ?></td><td><?php esc_html_e( '12,400', 'batavia' ); ?></td></tr><tr><td><?php esc_html_e( 'p99 latency', 'batavia' ); ?></td><td><?php esc_html_e( '38 ms', 'batavia' ); ?></td></tr></tbody></table><figcaption class="wp-element-caption"><?php esc_html_e( 'What was measured, and on what. A table without this line invites the wrong conclusion.', 'batavia' ); ?></figcaption></figure>
<!-- /wp:table -->
