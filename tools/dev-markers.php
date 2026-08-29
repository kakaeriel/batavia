<?php
/**
 * Plugin Name: Batavia dev markers
 * Description: Annotates the rendered page with the template, template parts and patterns that produced it.
 * Version:     1.0.0
 * License:     GPL-2.0-or-later
 *
 * Block themes are hard to debug by reading the page source. A section of the
 * front end can come from a template, a template part or a pattern, and once
 * rendered it is all just divs -- there is nothing in the output that says which
 * file to open. This drops HTML comments around each boundary, so "view source"
 * answers the question directly.
 *
 * Development-only. Loaded as a mu-plugin by the local environment and never
 * distributed with the theme.
 *
 * @package Batavia
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Wraps template parts and patterns in comments naming their source.
 *
 * @param string $block_content Rendered block HTML.
 * @param array  $block         Parsed block.
 * @return string Annotated HTML.
 */
function batavia_dev_mark_block( $block_content, $block ) {
	if ( is_admin() || wp_is_json_request() ) {
		return $block_content;
	}

	$name = isset( $block['blockName'] ) ? $block['blockName'] : '';

	$kinds = array(
		'core/template-part' => 'part',
		'core/pattern'       => 'pattern',
	);

	if ( ! isset( $kinds[ $name ] ) ) {
		return $block_content;
	}

	$slug = isset( $block['attrs']['slug'] ) ? $block['attrs']['slug'] : 'unknown';
	$tag  = $kinds[ $name ] . '/' . $slug;

	return sprintf(
		"\n<!-- batavia: %1\$s -->\n%2\$s\n<!-- /batavia: %1\$s -->\n",
		esc_html( $tag ),
		$block_content
	);
}
add_filter( 'render_block', 'batavia_dev_mark_block', 10, 2 );

/**
 * Names the template WordPress resolved for this request.
 *
 * @return void
 */
function batavia_dev_mark_template() {
	global $_wp_current_template_id;

	$template = is_string( $_wp_current_template_id ) && '' !== $_wp_current_template_id
		? $_wp_current_template_id
		: 'none (not a block template)';

	printf( "<!-- batavia: template = %s -->\n", esc_html( $template ) );
}
add_action( 'wp_head', 'batavia_dev_mark_template', 0 );

/**
 * Lists the theme's own stylesheets and their load order.
 *
 * Order matters in this theme: the dark-mode stylesheet has to win over the
 * global styles block, and core's skip-link stylesheet competes with the
 * theme's. Seeing the actual order beats reasoning about it.
 *
 * @return void
 */
function batavia_dev_mark_styles() {
	$queue = wp_styles()->queue;
	$mine  = array();

	foreach ( $queue as $handle ) {
		$src = isset( wp_styles()->registered[ $handle ] ) ? wp_styles()->registered[ $handle ]->src : '';

		if ( is_string( $src ) && false !== strpos( $src, '/themes/batavia/' ) ) {
			$mine[] = $handle;
		}
	}

	printf( "<!-- batavia: theme stylesheets in order = %s -->\n", esc_html( implode( ', ', $mine ) ) );
}
add_action( 'wp_footer', 'batavia_dev_mark_styles', 99 );
