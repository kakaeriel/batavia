<?php
/**
 * Fills in for a post's missing featured image.
 *
 * Core's Featured Image block renders nothing at all when a post has none,
 * which turns "half the notes have a photo" into ragged, uneven grids and
 * lists. A placeholder keeps every post's image the same size and shape as
 * its neighbours, so the surrounding layout holds together either way.
 *
 * @package Batavia
 * @since   1.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'batavia_post_featured_image_placeholder' ) ) {
	/**
	 * Replaces an empty Featured Image block with a hairline placeholder box.
	 *
	 * The box is given the same alignment, class and size the real image would
	 * have carried, read back from the block's own attributes, so it drops
	 * into a grid or a fixed-width thumbnail slot exactly as the photo would
	 * have. A post with no featured image never fell within an aspect ratio to
	 * begin with, so one is assumed here purely to give the box a visible
	 * height -- 3:2 matches the ratio patterns already crop real photos to.
	 *
	 * @since 1.5.0
	 *
	 * @param string               $block_content The rendered image, or an empty string.
	 * @param array<string, mixed> $block         The parsed block.
	 * @return string The image, or a placeholder box the same shape.
	 */
	function batavia_post_featured_image_placeholder( $block_content, $block ) {
		if ( '' !== trim( $block_content ) ) {
			return $block_content;
		}

		$attrs   = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array();
		$classes = array( 'wp-block-post-featured-image', 'batavia-featured-image-placeholder' );

		if ( ! empty( $attrs['align'] ) && is_string( $attrs['align'] ) ) {
			$classes[] = 'align' . preg_replace( '/[^a-z]/', '', $attrs['align'] );
		}

		if ( ! empty( $attrs['className'] ) && is_string( $attrs['className'] ) ) {
			$classes[] = $attrs['className'];
		}

		$aspect_ratio = ! empty( $attrs['aspectRatio'] ) && is_string( $attrs['aspectRatio'] )
			? preg_replace( '/[^0-9.\/]/', '', $attrs['aspectRatio'] )
			: '3/2';

		$style = 'aspect-ratio:' . $aspect_ratio . ';';

		if ( ! empty( $attrs['width'] ) && is_string( $attrs['width'] ) ) {
			$width  = preg_replace( '/[^0-9a-z.%]/', '', $attrs['width'] );
			$style .= 'width:' . $width . ';flex-basis:' . $width . ';';
		}

		return sprintf(
			'<div class="%1$s" style="%2$s"></div>',
			esc_attr( implode( ' ', $classes ) ),
			esc_attr( $style )
		);
	}
}
add_filter( 'render_block_core/post-featured-image', 'batavia_post_featured_image_placeholder', 10, 2 );
