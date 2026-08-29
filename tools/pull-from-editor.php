<?php
/**
 * Writes Site Editor customisations back into the theme's files.
 *
 * Everything changed in Appearance > Editor is saved to the database, not to
 * the theme. WordPress then serves the database copy and ignores the file, so
 * the work is invisible to git and absent from the distributed zip.
 *
 *   wp_template       -> templates/<slug>.html
 *   wp_template_part  -> parts/<slug>.html
 *   wp_global_styles  -> theme.json  (only with the "styles" argument)
 *
 * Usage:
 *   wp eval-file tools/pull-from-editor.php            templates and parts
 *   wp eval-file tools/pull-from-editor.php styles     also merge theme.json
 *
 * @package Celestine
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	echo "This script must be run through wp eval-file.\n";
	exit( 1 );
}

$celestine_apply_styles = isset( $args ) && in_array( 'styles', (array) $args, true );
$celestine_root         = realpath( get_stylesheet_directory() );

if ( false === $celestine_root || ! is_writable( $celestine_root ) ) {
	echo "The theme directory is not writable.\n";
	exit( 1 );
}

$celestine_written   = 0;
$celestine_unchanged = 0;

/**
 * Writes content to a theme file when it differs, reporting either way.
 *
 * @param string $path     Absolute path to the file.
 * @param string $content  New content.
 * @param string $relative Path shown in output.
 * @return string One of "written", "unchanged".
 */
function celestine_pull_write( $path, $content, $relative ) {
	$content = rtrim( $content, "\n" ) . "\n";

	if ( is_file( $path ) && file_get_contents( $path ) === $content ) {
		printf( "  unchanged  %s\n", $relative );
		return 'unchanged';
	}

	if ( ! is_dir( dirname( $path ) ) ) {
		mkdir( dirname( $path ), 0755, true );
	}

	file_put_contents( $path, $content );
	printf( "  written    %s\n", $relative );

	return 'written';
}

/**
 * Lists the leaf paths present in a nested array.
 *
 * @param array  $data   Nested array.
 * @param string $prefix Path accumulated so far.
 * @return string[] Dot-separated paths.
 */
function celestine_pull_paths( $data, $prefix = '' ) {
	$paths = array();

	foreach ( $data as $key => $value ) {
		$path = '' === $prefix ? (string) $key : $prefix . '.' . $key;

		if ( is_array( $value ) && $value && ! isset( $value[0] ) ) {
			$paths = array_merge( $paths, celestine_pull_paths( $value, $path ) );
		} else {
			$paths[] = $path;
		}
	}

	return $paths;
}

/**
 * Merges user values over theme values.
 *
 * Lists such as the colour palette are replaced wholesale rather than merged
 * item by item, which is how the editor treats them too.
 *
 * @param array $base     Theme values.
 * @param array $override User values.
 * @return array Merged result.
 */
function celestine_pull_merge( $base, $override ) {
	foreach ( $override as $key => $value ) {
		if ( is_array( $value ) && $value && ! isset( $value[0] ) && isset( $base[ $key ] ) && is_array( $base[ $key ] ) ) {
			$base[ $key ] = celestine_pull_merge( $base[ $key ], $value );
		} else {
			$base[ $key ] = $value;
		}
	}

	return $base;
}

$celestine_kinds = array(
	'wp_template'      => 'templates',
	'wp_template_part' => 'parts',
);

foreach ( $celestine_kinds as $celestine_type => $celestine_dir ) {
	$celestine_posts = get_posts(
		array(
			'post_type'      => $celestine_type,
			'post_status'    => array( 'publish', 'draft' ),
			'posts_per_page' => -1,
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => 'wp_theme',
					'field'    => 'name',
					'terms'    => get_stylesheet(),
				),
			),
		)
	);

	if ( ! $celestine_posts ) {
		continue;
	}

	printf( "\n%s (%d customised)\n", $celestine_dir, count( $celestine_posts ) );

	foreach ( $celestine_posts as $celestine_post ) {
		$celestine_relative = $celestine_dir . '/' . $celestine_post->post_name . '.html';
		$celestine_result   = celestine_pull_write(
			$celestine_root . '/' . $celestine_relative,
			$celestine_post->post_content,
			$celestine_relative
		);

		if ( 'written' === $celestine_result ) {
			++$celestine_written;
		} else {
			++$celestine_unchanged;
		}
	}
}

$celestine_gs_id = WP_Theme_JSON_Resolver::get_user_global_styles_post_id();
$celestine_gs    = $celestine_gs_id ? get_post( $celestine_gs_id ) : null;

if ( $celestine_gs && trim( (string) $celestine_gs->post_content ) !== '' ) {
	$celestine_user = json_decode( $celestine_gs->post_content, true );

	unset( $celestine_user['isGlobalStylesUserThemeJSON'], $celestine_user['version'] );
	$celestine_user = array_filter(
		array(
			'settings' => isset( $celestine_user['settings'] ) ? $celestine_user['settings'] : null,
			'styles'   => isset( $celestine_user['styles'] ) ? $celestine_user['styles'] : null,
		)
	);

	if ( $celestine_user ) {
		printf( "\nglobal styles (Appearance > Editor > Styles)\n" );

		foreach ( celestine_pull_paths( $celestine_user ) as $celestine_path ) {
			printf( "  %s  %s\n", $celestine_apply_styles ? 'merging  ' : 'would set', $celestine_path );
		}

		if ( $celestine_apply_styles ) {
			$celestine_theme_json = json_decode( file_get_contents( $celestine_root . '/theme.json' ), true );
			$celestine_theme_json = celestine_pull_merge( $celestine_theme_json, $celestine_user );

			$celestine_encoded = wp_json_encode( $celestine_theme_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

			// theme.json is tab-indented in this repo; json_encode uses four spaces.
			$celestine_encoded = preg_replace_callback(
				'/^(?: {4})+/m',
				static function ( $m ) {
					return str_repeat( "\t", strlen( $m[0] ) / 4 );
				},
				$celestine_encoded
			);

			celestine_pull_write( $celestine_root . '/theme.json', $celestine_encoded, 'theme.json' );
			++$celestine_written;
		} else {
			printf( "\n  Pass \"styles\" to merge these into theme.json.\n" );
		}
	}
}

if ( 0 === $celestine_written && 0 === $celestine_unchanged ) {
	echo "\nNothing has been customised in the editor.\n";
	exit( 0 );
}

printf( "\n%d file(s) written, %d already current.\n", $celestine_written, $celestine_unchanged );
echo "Run tools/reset-editor.php to clear the database copies.\n";
