<?php
/**
 * The "Homepage" tab.
 *
 * Composition rather than content: which sections show, which category
 * Selected work and Notes pull from, and the rows that make up Experience and
 * Consulting. Wording -- section titles, the Hero tools line -- stays a Site
 * Editor job, edited directly on the block, the same way it always has been.
 * Kept apart from the Settings tab, which stays about the person -- name,
 * contact, social profiles -- rather than the page.
 *
 * Section order is still a Site Editor job: open the Front Page template and
 * drag a pattern block. Reproducing that here would mean the theme
 * reassembling its own template on the server, which is a different kind of
 * feature to the rest of this screen.
 *
 * @package Batavia
 * @since   1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'batavia_render_homepage_form' ) ) {
	/**
	 * Renders the form for the homepage-section settings.
	 *
	 * @since 1.4.0
	 *
	 * @return void
	 */
	function batavia_render_homepage_form() {
		$groups = batavia_settings_groups();
		$scope  = isset( $groups['homepage'] ) ? $groups['homepage'] : array();
		?>
		<h2 class="batavia-admin__heading"><?php esc_html_e( 'Homepage sections', 'batavia' ); ?></h2>

		<form method="post" action="<?php echo esc_url( admin_url( 'options.php' ) ); ?>">
			<?php settings_fields( 'batavia_settings_group' ); ?>
			<input type="hidden" name="<?php echo esc_attr( BATAVIA_SETTINGS_OPTION ); ?>[_scope]" value="<?php echo esc_attr( implode( ',', $scope ) ); ?>" />

			<?php batavia_render_settings_groups( $scope ); ?>

			<?php submit_button( __( 'Save homepage sections', 'batavia' ), 'primary', 'batavia_save_homepage' ); ?>
		</form>
		<?php
	}
}

if ( ! function_exists( 'batavia_render_homepage_tab' ) ) {
	/**
	 * Renders the tab.
	 *
	 * @since 1.4.0
	 *
	 * @return void
	 */
	function batavia_render_homepage_tab() {
		batavia_render_settings_notices();
		batavia_render_homepage_form();
	}
}
