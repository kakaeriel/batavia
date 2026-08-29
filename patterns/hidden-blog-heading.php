<?php
/**
 * Title: Hidden blog heading
 * Slug: celestine/hidden-blog-heading
 * Inserter: no
 * Description: A level-one heading for the posts index, available to assistive technology but not shown on screen.
 *
 * @package Celestine
 * @since   1.0.0
 */

?>
<!-- wp:heading {"level":1,"className":"screen-reader-text"} -->
<h1 class="wp-block-heading screen-reader-text"><?php esc_html_e( 'Posts', 'celestine' ); ?></h1>
<!-- /wp:heading -->
