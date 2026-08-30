<?php
/**
 * Title: Sidebar: Experience
 * Slug: batavia/widget-experience
 * Categories: batavia, text
 * Description: The current (or most recent) role, for the post detail sidebar. The full history stays on the front page.
 * Keywords: sidebar, widget, experience, role, work history
 * Inserter: no
 *
 * Off whenever the front page's own Experience section is, from
 * Appearance -> Batavia -> Homepage -- see widget-notes.php for why.
 * Shows only the first row: a sidebar is a pointer back to the front page,
 * not a second copy of the whole timeline.
 *
 * @package Batavia
 * @since   1.5.0
 */

if ( ! batavia_get_setting_bool( 'show_experience' ) ) {
	return;
}

$batavia_widget_experience_rows = batavia_get_repeater_rows( 'experience' );
$batavia_widget_experience_row  = ! empty( $batavia_widget_experience_rows )
	? $batavia_widget_experience_rows[0]
	: array(
		'dates' => __( '2021 — Present', 'batavia' ),
		'title' => __( 'Lead Engineer, Northwind Studio', 'batavia' ),
	);

?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:heading {"level":3,"className":"is-style-batavia-label"} -->
	<h3 class="wp-block-heading is-style-batavia-label"><?php esc_html_e( 'Experience', 'batavia' ); ?></h3>
	<!-- /wp:heading -->

	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		<!-- wp:paragraph {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
		<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family"><?php echo esc_html( isset( $batavia_widget_experience_row['dates'] ) ? $batavia_widget_experience_row['dates'] : '' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"fontSize":"small"} -->
		<p class="has-small-font-size"><?php echo esc_html( isset( $batavia_widget_experience_row['title'] ) ? $batavia_widget_experience_row['title'] : '' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Full experience', 'batavia' ); ?></a></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
