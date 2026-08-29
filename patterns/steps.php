<?php
/**
 * Title: Numbered steps
 * Slug: batavia/steps
 * Categories: batavia, text
 * Description: A procedure, each step ruled off from the next with its number set in monospace, for instructions a reader will follow with one hand on the keyboard.
 * Keywords: steps, procedure, instructions, how to, tutorial, numbered
 * Block Types: core/list
 * Viewport Width: 800
 *
 * @package Batavia
 * @since   1.2.0
 */

?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:heading {"level":2,"className":"is-style-batavia-label"} -->
	<h2 class="wp-block-heading is-style-batavia-label"><?php esc_html_e( 'Procedure', 'batavia' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:list {"ordered":true,"className":"is-style-batavia-steps"} -->
	<ol class="wp-block-list is-style-batavia-steps">
		<!-- wp:list-item -->
		<li><strong><?php esc_html_e( 'Start with the state you expect.', 'batavia' ); ?></strong> <?php esc_html_e( 'Say what should already be true before step two, so a reader who has skipped something finds out here rather than three commands later.', 'batavia' ); ?></li>
		<!-- /wp:list-item -->

		<!-- wp:list-item -->
		<li><strong><?php esc_html_e( 'One action per step.', 'batavia' ); ?></strong> <?php esc_html_e( 'If a step contains the word "and", it is usually two steps wearing one number.', 'batavia' ); ?></li>
		<!-- /wp:list-item -->

		<!-- wp:list-item -->
		<li><strong><?php esc_html_e( 'Say what success looks like.', 'batavia' ); ?></strong> <?php esc_html_e( 'The output, the status, the thing on screen. This is what turns instructions into something a reader can check themselves against.', 'batavia' ); ?></li>
		<!-- /wp:list-item -->
	</ol>
	<!-- /wp:list -->
</div>
<!-- /wp:group -->
