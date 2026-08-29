<?php
/**
 * The theme's Appearance sub-page.
 *
 * A block theme has no Customizer, and the Site Editor gives no hint about what
 * a theme expects of you. This page fills that gap: it says which categories the
 * patterns are built around, where to set a static front page, and where each
 * part of the theme is edited.
 *
 * Deliberately limited to what a theme is permitted to do. Theme review forbids
 * demo importers, outbound HTTP requests and usage tracking in a theme, so there
 * are none here -- every link is either an admin screen on this site or a plain
 * link to documentation the reader chooses to follow. Anything beyond that
 * belongs in a companion plugin.
 *
 * @package Celestine
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'celestine_register_admin_page' ) ) {
	/**
	 * Registers the sub-page under Appearance.
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	function celestine_register_admin_page() {
		$page = add_theme_page(
			/* translators: Page title of the theme's Appearance sub-page. */
			__( 'Celestine', 'celestine' ),
			/* translators: Menu label of the theme's Appearance sub-page. */
			__( 'Celestine', 'celestine' ),
			'edit_theme_options',
			'celestine',
			'celestine_render_admin_page'
		);

		if ( $page ) {
			add_action( 'admin_print_styles-' . $page, 'celestine_enqueue_admin_styles' );
		}
	}
}
add_action( 'admin_menu', 'celestine_register_admin_page' );

if ( ! function_exists( 'celestine_enqueue_admin_styles' ) ) {
	/**
	 * Loads the page's stylesheet, and only on this page.
	 *
	 * Hooked to admin_print_styles-{$hook_suffix} so it cannot leak into other
	 * admin screens.
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	function celestine_enqueue_admin_styles() {
		$version = wp_get_theme()->get( 'Version' );

		wp_enqueue_style(
			'celestine-admin',
			get_theme_file_uri( 'assets/css/admin.css' ),
			array(),
			is_string( $version ) && '' !== $version ? $version : false
		);
	}
}

if ( ! function_exists( 'celestine_admin_steps' ) ) {
	/**
	 * The setup steps, in the order they should be done.
	 *
	 * Ordered because it is a real sequence: patterns filter by category, so the
	 * categories have to exist before the front page is worth editing.
	 *
	 * @since 1.1.0
	 *
	 * @return array<int, array<string, string>> Step definitions.
	 */
	function celestine_admin_steps() {
		return array(
			array(
				'title' => __( 'Create your categories', 'celestine' ),
				'body'  => __( 'Celestine separates writing from projects using the built-in Category taxonomy rather than custom post types, so your content survives a theme switch. Add a category named Blog and one named Portfolio.', 'celestine' ),
				'label' => __( 'Add categories', 'celestine' ),
				'url'   => admin_url( 'edit-tags.php?taxonomy=category' ),
			),
			array(
				'title' => __( 'Choose a static front page', 'celestine' ),
				'body'  => __( 'Create a page for your home page and another for your posts, then select them under Reading. This is what makes the composed front page appear instead of a plain list of posts.', 'celestine' ),
				'label' => __( 'Open Reading settings', 'celestine' ),
				'url'   => admin_url( 'options-reading.php' ),
			),
			array(
				'title' => __( 'Point the loops at your categories', 'celestine' ),
				'body'  => __( 'The Portfolio grid and Writing index are ordinary Query Loop blocks. Select each one, open the Filters panel in the sidebar, and choose the matching category. They ship unfiltered because a theme cannot know your category IDs in advance.', 'celestine' ),
				'label' => __( 'Edit the front page', 'celestine' ),
				'url'   => admin_url( 'site-editor.php?p=%2Ftemplate' ),
			),
			array(
				'title' => __( 'Make it yours', 'celestine' ),
				'body'  => __( 'Every colour in the theme is one of six presets, so editing a preset changes it everywhere at once, in both light and dark. Dark mode follows the visitor\'s system setting; there is no toggle by design.', 'celestine' ),
				'label' => __( 'Open Styles', 'celestine' ),
				'url'   => admin_url( 'site-editor.php?p=%2Fstyles' ),
			),
		);
	}
}

if ( ! function_exists( 'celestine_admin_shortcuts' ) ) {
	/**
	 * Deep links into the parts of the Site Editor this theme uses.
	 *
	 * @since 1.1.0
	 *
	 * @return array<int, array<string, string>> Shortcut definitions.
	 */
	function celestine_admin_shortcuts() {
		return array(
			array(
				'title' => __( 'Templates', 'celestine' ),
				'body'  => __( 'The seven page layouts: front page, blog index, single post, page, archive, search and 404.', 'celestine' ),
				'url'   => admin_url( 'site-editor.php?p=%2Ftemplate' ),
			),
			array(
				'title' => __( 'Patterns', 'celestine' ),
				'body'  => __( 'The reusable sections, plus the header and footer template parts.', 'celestine' ),
				'url'   => admin_url( 'site-editor.php?p=%2Fpattern' ),
			),
			array(
				'title' => __( 'Styles', 'celestine' ),
				'body'  => __( 'Colour presets, typography, spacing and layout widths.', 'celestine' ),
				'url'   => admin_url( 'site-editor.php?p=%2Fstyles' ),
			),
			array(
				'title' => __( 'Navigation', 'celestine' ),
				'body'  => __( 'The menus used in the header and footer.', 'celestine' ),
				'url'   => admin_url( 'site-editor.php?p=%2Fnavigation' ),
			),
		);
	}
}

if ( ! function_exists( 'celestine_admin_sections' ) ) {
	/**
	 * The front-page sections the theme ships, in the order they appear.
	 *
	 * @since 1.1.0
	 *
	 * @return array<int, array<string, string>> Section definitions.
	 */
	function celestine_admin_sections() {
		return array(
			array(
				'name' => __( 'Hero', 'celestine' ),
				'body' => __( 'Availability, name, role and two calls to action.', 'celestine' ),
			),
			array(
				'name' => __( 'Tech stack', 'celestine' ),
				'body' => __( 'A three-column specification sheet set in monospace.', 'celestine' ),
			),
			array(
				'name' => __( 'Experience timeline', 'celestine' ),
				'body' => __( 'A ruled rail of roles, companies and dates.', 'celestine' ),
			),
			array(
				'name' => __( 'Client strip', 'celestine' ),
				'body' => __( 'Companies worked with, as monospace wordmarks.', 'celestine' ),
			),
			array(
				'name' => __( 'Portfolio grid', 'celestine' ),
				'body' => __( 'A Query Loop laid out as project cards.', 'celestine' ),
			),
			array(
				'name' => __( 'Consulting rates', 'celestine' ),
				'body' => __( 'Hourly, project and retainer packages.', 'celestine' ),
			),
			array(
				'name' => __( 'Writing index', 'celestine' ),
				'body' => __( 'A ruled list of recent posts.', 'celestine' ),
			),
			array(
				'name' => __( 'Closing call to action', 'celestine' ),
				'body' => __( 'A contact section above the site footer.', 'celestine' ),
			),
		);
	}
}

if ( ! function_exists( 'celestine_render_admin_page' ) ) {
	/**
	 * Renders the page.
	 *
	 * @since 1.1.0
	 *
	 * @return void
	 */
	function celestine_render_admin_page() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to customise this site.', 'celestine' ) );
		}

		$theme   = wp_get_theme();
		$version = $theme->get( 'Version' );
		?>
		<div class="wrap celestine-admin">

			<div class="celestine-admin__masthead">
				<p class="celestine-admin__eyebrow"><?php esc_html_e( 'Block theme', 'celestine' ); ?></p>
				<h1>
					<?php echo esc_html( $theme->get( 'Name' ) ); ?>
					<?php if ( $version ) : ?>
						<span class="celestine-admin__version"><?php echo esc_html( $version ); ?></span>
					<?php endif; ?>
				</h1>
				<p class="celestine-admin__standfirst">
					<?php esc_html_e( 'A portfolio, a technical blog and a consulting rate card in one site. Everything below is edited in the Site Editor -- this theme adds no settings of its own.', 'celestine' ); ?>
				</p>
			</div>

			<h2 class="celestine-admin__heading"><?php esc_html_e( 'Set up, in order', 'celestine' ); ?></h2>

			<ol class="celestine-admin__steps">
				<?php foreach ( celestine_admin_steps() as $step ) : ?>
					<li class="celestine-admin__step">
						<h3><?php echo esc_html( $step['title'] ); ?></h3>
						<p><?php echo esc_html( $step['body'] ); ?></p>
						<a class="button button-secondary" href="<?php echo esc_url( $step['url'] ); ?>">
							<?php echo esc_html( $step['label'] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ol>

			<h2 class="celestine-admin__heading"><?php esc_html_e( 'Where things are edited', 'celestine' ); ?></h2>

			<div class="celestine-admin__grid">
				<?php foreach ( celestine_admin_shortcuts() as $shortcut ) : ?>
					<a class="celestine-admin__card" href="<?php echo esc_url( $shortcut['url'] ); ?>">
						<span class="celestine-admin__card-title"><?php echo esc_html( $shortcut['title'] ); ?></span>
						<span class="celestine-admin__card-body"><?php echo esc_html( $shortcut['body'] ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>

			<h2 class="celestine-admin__heading"><?php esc_html_e( 'Sections included', 'celestine' ); ?></h2>

			<p class="celestine-admin__note">
				<?php esc_html_e( 'These are patterns, not custom blocks. Insert one and it becomes ordinary core blocks you can take apart -- and nothing breaks if you switch themes later. Find them under the Celestine category in the block inserter.', 'celestine' ); ?>
			</p>

			<ul class="celestine-admin__sections">
				<?php foreach ( celestine_admin_sections() as $section ) : ?>
					<li>
						<strong><?php echo esc_html( $section['name'] ); ?></strong>
						<span><?php echo esc_html( $section['body'] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>

			<h2 class="celestine-admin__heading"><?php esc_html_e( 'Learn more', 'celestine' ); ?></h2>

			<ul class="celestine-admin__links">
				<li>
					<a href="https://developer.wordpress.org/themes/block-themes/" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'How block themes work', 'celestine' ); ?>
					</a>
				</li>
				<li>
					<a href="https://developer.wordpress.org/themes/patterns/" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Working with patterns', 'celestine' ); ?>
					</a>
				</li>
				<li>
					<a href="https://wordpress.org/documentation/article/site-editor/" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Using the Site Editor', 'celestine' ); ?>
					</a>
				</li>
			</ul>

		</div>
		<?php
	}
}
