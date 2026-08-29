<?php
/**
 * Title: Questions and answers
 * Slug: batavia/faq
 * Categories: batavia, text
 * Description: Collapsible questions built from the core Details block, which browsers can search inside and screen readers announce as expandable.
 * Keywords: faq, questions, answers, details, accordion, help
 * Block Types: core/details
 * Viewport Width: 800
 *
 * @package Batavia
 * @since   1.2.0
 */

?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:heading {"level":2,"className":"is-style-batavia-label"} -->
	<h2 class="wp-block-heading is-style-batavia-label"><?php esc_html_e( 'Questions', 'batavia' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:details {"className":"is-style-batavia-ruled"} -->
	<details class="wp-block-details is-style-batavia-ruled"><summary><?php esc_html_e( 'How long does this take?', 'batavia' ); ?></summary>
		<!-- wp:paragraph -->
		<p><?php esc_html_e( 'Answer the question in the first sentence, then add the detail. A reader who opened this wants the number, not the reasoning that produced it.', 'batavia' ); ?></p>
		<!-- /wp:paragraph -->
	</details>
	<!-- /wp:details -->

	<!-- wp:details {"className":"is-style-batavia-ruled"} -->
	<details class="wp-block-details is-style-batavia-ruled"><summary><?php esc_html_e( 'What do you need from me?', 'batavia' ); ?></summary>
		<!-- wp:paragraph -->
		<p><?php esc_html_e( 'A short list is more useful than a paragraph here. Say what to send, in what form, and what happens once you have it.', 'batavia' ); ?></p>
		<!-- /wp:paragraph -->
	</details>
	<!-- /wp:details -->

	<!-- wp:details {"className":"is-style-batavia-ruled"} -->
	<details class="wp-block-details is-style-batavia-ruled"><summary><?php esc_html_e( 'What if it does not work out?', 'batavia' ); ?></summary>
		<!-- wp:paragraph -->
		<p><?php esc_html_e( 'The awkward question, answered plainly. Leaving it out does not stop anyone wondering — it just means they wonder somewhere you cannot answer.', 'batavia' ); ?></p>
		<!-- /wp:paragraph -->
	</details>
	<!-- /wp:details -->
</div>
<!-- /wp:group -->
