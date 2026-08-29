<?php
/**
 * Title: Note
 * Slug: batavia/note
 * Categories: batavia, text
 * Description: An aside on a tinted panel, for the caveat, prerequisite or warning that would otherwise end up in brackets in the middle of a sentence.
 * Keywords: note, callout, aside, warning, tip, caveat, panel
 * Viewport Width: 800
 *
 * @package Batavia
 * @since   1.2.0
 */

?>
<!-- wp:group {"className":"is-style-batavia-panel","backgroundColor":"surface","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-batavia-panel has-surface-background-color has-background">
	<!-- wp:paragraph {"className":"is-style-batavia-label"} -->
	<p class="is-style-batavia-label"><?php esc_html_e( 'Note', 'batavia' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size"><?php esc_html_e( 'The thing the reader needs to know before they run the command, not after. Change the label to Warning, Prerequisite or Version if that is what this is — the label is a Spec label paragraph, so it keeps its rule either way.', 'batavia' ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
