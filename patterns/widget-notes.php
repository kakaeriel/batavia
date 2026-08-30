<?php
/**
 * Title: Sidebar: Recent notes
 * Slug: batavia/widget-notes
 * Categories: batavia, query
 * Description: A compact list of recent notes for the post detail sidebar. Reads the same category scoping as the front page's Notes section.
 * Keywords: sidebar, widget, notes, recent
 * Block Types: core/query
 * Inserter: no
 *
 * Off whenever the front page's own Notes section is, from Appearance ->
 * Batavia -> Homepage -- a sidebar promoting a section the site owner
 * turned off would be a stray link to nowhere they meant to send anyone.
 *
 * @package Batavia
 * @since   1.5.0
 */

if ( ! batavia_get_setting_bool( 'show_notes' ) ) {
	return;
}

$batavia_widget_notes_tax_query = batavia_category_tax_query( 'notes_category', 'notes_category_mode' );
$batavia_current_post_id        = (int) get_the_ID();

?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:heading {"level":3,"className":"is-style-batavia-label"} -->
	<h3 class="wp-block-heading is-style-batavia-label"><?php esc_html_e( 'Recent notes', 'batavia' ); ?></h3>
	<!-- /wp:heading -->

	<!-- wp:query {"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[<?php echo $batavia_current_post_id; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Cast to int above, not user input. */ ?>],"sticky":"ignore","inherit":false,"taxQuery":<?php echo $batavia_widget_notes_tax_query; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already JSON-encoded by batavia_category_tax_query(), and only ever `null` or a filtered category id, never user input. */ ?>,"parents":[]},"layout":{"type":"default"}} -->
	<div class="wp-block-query">
		<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}}} -->
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
		<div class="wp-block-group">
			<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1","width":"3rem"} /-->

			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group">
				<!-- wp:post-date {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} /-->

				<!-- wp:post-title {"level":4,"isLink":true,"fontSize":"small"} /-->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
		<!-- /wp:post-template -->

		<!-- wp:query-no-results -->
		<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
		<p class="has-muted-color has-text-color has-small-font-size"><?php esc_html_e( 'Nothing published yet.', 'batavia' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( batavia_notes_archive_url() ? batavia_notes_archive_url() : '#' ); ?>"><?php esc_html_e( 'All notes', 'batavia' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
