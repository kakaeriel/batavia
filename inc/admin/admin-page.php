<?php
/**
 * The theme's Appearance sub-page.
 *
 * Five tabs, one menu entry. Site identity, Profile, Contact and Social media
 * are the short lists of details that would otherwise have to be retyped into
 * every pattern that mentions them, split apart so saving one kind of detail
 * never means scrolling past every other kind first. Homepage chooses what
 * the front page shows.
 *
 * Deliberately limited to what a theme is permitted to do: no demo importer, no
 * outbound requests, no tracking, and nothing that writes to the database
 * without being asked. Anything beyond that belongs in a companion plugin.
 *
 * @package Batavia
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_theme_file_path( 'inc/admin/view-settings.php' );
require_once get_theme_file_path( 'inc/admin/view-homepage.php' );

if ( ! function_exists( 'batavia_admin_tabs' ) ) {
	/**
	 * The tabs on the page, in order.
	 *
	 * @since 1.2.0
	 *
	 * @return array<string, string> Tab slug mapped to its label.
	 */
	function batavia_admin_tabs() {
		return array(
			'identity' => __( 'Site identity', 'batavia' ),
			'profile'  => __( 'Profile', 'batavia' ),
			'contact'  => __( 'Contact', 'batavia' ),
			'social'   => __( 'Social media', 'batavia' ),
			'homepage' => __( 'Homepage', 'batavia' ),
		);
	}
}

if ( ! function_exists( 'batavia_current_admin_tab' ) ) {
	/**
	 * The tab being viewed, falling back to the first one.
	 *
	 * @since 1.2.0
	 *
	 * @return string Tab slug.
	 */
	function batavia_current_admin_tab() {
		$tabs = batavia_admin_tabs();

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Reading which tab to display, not processing a submission.
		$requested = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : '';

		return isset( $tabs[ $requested ] ) ? $requested : (string) array_key_first( $tabs );
	}
}

if ( ! function_exists( 'batavia_admin_page_url' ) ) {
	/**
	 * The URL of one tab of this page.
	 *
	 * @since 1.2.0
	 *
	 * @param string $tab Tab slug.
	 * @return string Admin URL.
	 */
	function batavia_admin_page_url( $tab = 'identity' ) {
		return add_query_arg(
			array(
				'page' => 'batavia',
				'tab'  => $tab,
			),
			admin_url( 'themes.php' )
		);
	}
}

if ( ! function_exists( 'batavia_register_admin_page' ) ) {
	/**
	 * Registers the sub-page under Appearance.
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	function batavia_register_admin_page() {
		add_theme_page(
			/* translators: Page title of the theme's Appearance sub-page. */
			__( 'Batavia', 'batavia' ),
			/* translators: Menu label of the theme's Appearance sub-page. */
			__( 'Batavia', 'batavia' ),
			'edit_theme_options',
			'batavia',
			'batavia_render_admin_page'
		);
	}
}
add_action( 'admin_menu', 'batavia_register_admin_page' );

if ( ! function_exists( 'batavia_enqueue_admin_assets' ) ) {
	/**
	 * Loads the page's assets, and only on this page.
	 *
	 * The hook suffix is checked rather than trusted, so nothing here can leak
	 * into another admin screen. The media library and the picker script load
	 * only on the tab that needs them.
	 *
	 * @since 1.1.0
	 *
	 * @param string $hook_suffix The current admin page.
	 * @return void
	 */
	function batavia_enqueue_admin_assets( $hook_suffix ) {
		if ( 'appearance_page_batavia' !== $hook_suffix ) {
			return;
		}

		$theme   = wp_get_theme();
		$version = $theme->get( 'Version' );
		$version = is_string( $version ) && '' !== $version ? $version : false;

		wp_enqueue_style(
			'batavia-admin',
			get_theme_file_uri( 'assets/css/admin.css' ),
			array(),
			$version
		);

		$tab = batavia_current_admin_tab();

		if ( ! in_array( $tab, array( 'identity', 'homepage' ), true ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( 'identity' === $tab ) {
			wp_enqueue_media();
		}

		wp_enqueue_script(
			'batavia-admin',
			get_theme_file_uri( 'assets/js/settings-page.js' ),
			array( 'jquery' ),
			$version,
			true
		);

		wp_localize_script(
			'batavia-admin',
			'bataviaAdmin',
			array(
				'useImage' => __( 'Use this image', 'batavia' ),
				'choose'   => __( 'Choose image', 'batavia' ),
				'replace'  => __( 'Replace', 'batavia' ),
			)
		);
	}
}
add_action( 'admin_enqueue_scripts', 'batavia_enqueue_admin_assets' );

if ( ! function_exists( 'batavia_render_admin_page' ) ) {
	/**
	 * Renders the page: masthead, tabs, then the current tab.
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	function batavia_render_admin_page() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to customise this site.', 'batavia' ) );
		}

		$theme   = wp_get_theme();
		$version = $theme->get( 'Version' );
		$current = batavia_current_admin_tab();
		?>
		<div class="wrap batavia-admin">

			<div class="batavia-admin__masthead">
				<p class="batavia-admin__eyebrow"><?php esc_html_e( 'Block theme', 'batavia' ); ?></p>
				<h1>
					<?php echo esc_html( $theme->get( 'Name' ) ); ?>
					<?php if ( $version ) : ?>
						<span class="batavia-admin__version"><?php echo esc_html( $version ); ?></span>
					<?php endif; ?>
				</h1>
				<p class="batavia-admin__standfirst">
					<?php esc_html_e( 'A portfolio, a technical blog and a rate card in one site. Layout is edited in the Site Editor; the handful of details that appear in more than one place are edited here.', 'batavia' ); ?>
				</p>
			</div>

			<nav class="nav-tab-wrapper wp-clearfix" aria-label="<?php esc_attr_e( 'Batavia sections', 'batavia' ); ?>">
				<?php foreach ( batavia_admin_tabs() as $slug => $label ) : ?>
					<a
						href="<?php echo esc_url( batavia_admin_page_url( $slug ) ); ?>"
						class="nav-tab <?php echo $slug === $current ? 'nav-tab-active' : ''; ?>"
						<?php echo $slug === $current ? 'aria-current="page"' : ''; ?>
					>
						<?php echo esc_html( $label ); ?>
					</a>
				<?php endforeach; ?>
			</nav>

			<?php
			switch ( $current ) {
				case 'homepage':
					batavia_render_homepage_tab();
					break;

				case 'profile':
					batavia_render_settings_group_tab( 'profile', __( 'Save profile', 'batavia' ) );
					break;

				case 'contact':
					batavia_render_settings_group_tab( 'contact', __( 'Save contact', 'batavia' ) );
					break;

				case 'social':
					batavia_render_settings_group_tab( 'social', __( 'Save social media', 'batavia' ) );
					break;

				default:
					batavia_render_identity_tab();
					break;
			}
			?>

		</div>
		<?php
	}
}
