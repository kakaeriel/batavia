<?php
/**
 * Batavia theme setup.
 *
 * Batavia is a block theme: presentation lives in theme.json, layout lives in
 * the template and pattern files. This file is deliberately small -- it declares
 * theme support, enqueues two stylesheets, registers the custom block styles and
 * the pattern category, and loads the four files under inc/.
 *
 * It intentionally registers no post types, no taxonomies and no meta boxes.
 * Content is separated using the built-in Category taxonomy so the theme stays
 * within the WordPress.org theme scope and a user's content survives a theme
 * switch.
 *
 * @package Batavia
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * The theme's own settings, and the binding source that carries them into core
 * blocks. Both are needed on the front end, so neither is behind is_admin().
 */
require_once get_theme_file_path( 'inc/settings.php' );
require_once get_theme_file_path( 'inc/bindings.php' );

/*
 * The Appearance sub-page. Loaded only in the admin, so the front end carries
 * none of its weight.
 */
if ( is_admin() ) {
	require_once get_theme_file_path( 'inc/admin/admin-page.php' );
}

if ( ! function_exists( 'batavia_setup' ) ) {
	/**
	 * Declare theme support.
	 *
	 * Several of these are added automatically for block themes; they are
	 * declared explicitly so the theme's capabilities are readable in one
	 * place and remain correct on older supported versions of WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function batavia_setup() {
		load_theme_textdomain( 'batavia', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );

		add_theme_support(
			'custom-logo',
			array(
				'height'               => 96,
				'width'                => 96,
				'flex-height'          => true,
				'flex-width'           => true,
				'unlink-homepage-logo' => false,
			)
		);

		add_theme_support(
			'html5',
			array(
				'caption',
				'comment-form',
				'comment-list',
				'gallery',
				'navigation-widgets',
				'script',
				'search-form',
				'style',
			)
		);

		/*
		 * Load the theme stylesheet into the block editor canvas so custom
		 * block styles preview correctly while editing. The dark-mode
		 * stylesheet is deliberately excluded: the editor keeps the canonical
		 * light palette so colour choices in Styles stay legible.
		 */
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style.css' );
	}
}
add_action( 'after_setup_theme', 'batavia_setup' );

if ( ! function_exists( 'batavia_enqueue_assets' ) ) {
	/**
	 * Enqueue front-end styles.
	 *
	 * Two small stylesheets and no front-end JavaScript. Fonts are declared in
	 * theme.json and served from assets/fonts, so nothing is fetched from a
	 * third party.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function batavia_enqueue_assets() {
		$version = wp_get_theme()->get( 'Version' );

		if ( ! is_string( $version ) || '' === $version ) {
			$version = false;
		}

		wp_enqueue_style(
			'batavia-style',
			get_stylesheet_uri(),
			array(),
			$version
		);

		wp_enqueue_style(
			'batavia-color-scheme',
			get_theme_file_uri( 'assets/css/color-scheme.css' ),
			array( 'batavia-style' ),
			$version
		);
	}
}
add_action( 'wp_enqueue_scripts', 'batavia_enqueue_assets' );

if ( ! function_exists( 'batavia_preload_fonts' ) ) {
	/**
	 * Preloads the two font files every page needs.
	 *
	 * WordPress emits the @font-face rules from theme.json but does not preload
	 * the files, so a browser only discovers them after the stylesheet parses.
	 * The regular weights of Plex Sans and Plex Mono are on the critical path on
	 * every view -- the first for body text, the second for the site title and
	 * dates. The remaining weights and the Latin Extended subsets are left to be
	 * fetched on demand.
	 *
	 * @since 1.0.0
	 *
	 * @param array $preload_resources Resources to preload.
	 * @return array Filtered resources.
	 */
	function batavia_preload_fonts( $preload_resources ) {
		if ( ! is_array( $preload_resources ) ) {
			return $preload_resources;
		}

		$fonts = array(
			'assets/fonts/ibm-plex-sans-latin-400-normal.woff2',
			'assets/fonts/ibm-plex-mono-latin-400-normal.woff2',
		);

		foreach ( $fonts as $font ) {
			$preload_resources[] = array(
				'href'          => get_theme_file_uri( $font ),
				'as'            => 'font',
				'type'          => 'font/woff2',
				'crossorigin'   => 'anonymous',
				'fetchpriority' => 'high',
			);
		}

		return $preload_resources;
	}
}
add_filter( 'wp_preload_resources', 'batavia_preload_fonts' );

if ( ! function_exists( 'batavia_register_block_styles' ) ) {
	/**
	 * Register Batavia's custom block styles.
	 *
	 * Each style's CSS lives in style.css under section 4. Registering them
	 * here rather than hard-coding classes in patterns means users can apply
	 * the same treatments to their own blocks from the editor sidebar.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function batavia_register_block_styles() {
		$styles = array(
			'core/group'     => array(
				'batavia-panel'    => __( 'Panel', 'batavia' ),
				'batavia-timeline' => __( 'Timeline', 'batavia' ),
				'batavia-mark'     => __( 'Company mark', 'batavia' ),
				'batavia-entry'    => __( 'Article entry', 'batavia' ),
			),
			'core/columns'   => array(
				'batavia-panel' => __( 'Panel', 'batavia' ),
			),
			'core/heading'   => array(
				'batavia-label' => __( 'Spec label', 'batavia' ),
			),
			'core/paragraph' => array(
				'batavia-label'  => __( 'Spec label', 'batavia' ),
				'batavia-figure' => __( 'Figure', 'batavia' ),
			),
			'core/list'      => array(
				'batavia-mono'  => __( 'Monospaced', 'batavia' ),
				'batavia-ruled' => __( 'Ruled', 'batavia' ),
				'batavia-steps' => __( 'Numbered steps', 'batavia' ),
			),
			'core/table'     => array(
				'batavia-spec' => __( 'Spec sheet', 'batavia' ),
			),
			'core/details'   => array(
				'batavia-ruled' => __( 'Ruled', 'batavia' ),
			),
			'core/separator' => array(
				'batavia-dotted' => __( 'Dotted', 'batavia' ),
			),
			'core/image'     => array(
				'batavia-logo' => __( 'Logo mark', 'batavia' ),
			),
		);

		foreach ( $styles as $block_name => $block_styles ) {
			foreach ( $block_styles as $style_name => $style_label ) {
				register_block_style(
					$block_name,
					array(
						'name'  => $style_name,
						'label' => $style_label,
					)
				);
			}
		}
	}
}
add_action( 'init', 'batavia_register_block_styles' );

if ( ! function_exists( 'batavia_register_pattern_category' ) ) {
	/**
	 * Register the pattern category used by the bundled patterns.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function batavia_register_pattern_category() {
		register_block_pattern_category(
			'batavia',
			array(
				'label'       => _x( 'Batavia', 'Block pattern category', 'batavia' ),
				'description' => __( 'Sections for an engineering portfolio: hero, tech stack, experience, clients, projects, pricing and calls to action.', 'batavia' ),
			)
		);
	}
}
add_action( 'init', 'batavia_register_pattern_category' );
