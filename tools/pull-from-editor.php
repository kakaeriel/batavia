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
 * @package Batavia
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	echo "This script must be run through wp eval-file.\n";
	exit( 1 );
}

$batavia_apply_styles = isset( $args ) && in_array( 'styles', (array) $args, true );
$batavia_root         = realpath( get_stylesheet_directory() );

if ( false === $batavia_root || ! is_writable( $batavia_root ) ) {
	echo "The theme directory is not writable.\n";
	exit( 1 );
}

$batavia_written   = 0;
$batavia_unchanged = 0;

/**
 * Writes content to a theme file when it differs, reporting either way.
 *
 * @param string $path     Absolute path to the file.
 * @param string $content  New content.
 * @param string $relative Path shown in output.
 * @return string One of "written", "unchanged".
 */
function batavia_pull_write( $path, $content, $relative ) {
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
function batavia_pull_paths( $data, $prefix = '' ) {
	$paths = array();

	foreach ( $data as $key => $value ) {
		$path = '' === $prefix ? (string) $key : $prefix . '.' . $key;

		if ( is_array( $value ) && $value && ! isset( $value[0] ) ) {
			$paths = array_merge( $paths, batavia_pull_paths( $value, $path ) );
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
function batavia_pull_merge( $base, $override ) {
	foreach ( $override as $key => $value ) {
		if ( is_array( $value ) && $value && ! isset( $value[0] ) && isset( $base[ $key ] ) && is_array( $base[ $key ] ) ) {
			$base[ $key ] = batavia_pull_merge( $base[ $key ], $value );
		} else {
			$base[ $key ] = $value;
		}
	}

	return $base;
}

$batavia_kinds = array(
	'wp_template'      => 'templates',
	'wp_template_part' => 'parts',
);

foreach ( $batavia_kinds as $batavia_type => $batavia_dir ) {
	$batavia_posts = get_posts(
		array(
			'post_type'      => $batavia_type,
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

	if ( ! $batavia_posts ) {
		continue;
	}

	printf( "\n%s (%d customised)\n", $batavia_dir, count( $batavia_posts ) );

	foreach ( $batavia_posts as $batavia_post ) {
		$batavia_relative = $batavia_dir . '/' . $batavia_post->post_name . '.html';
		$batavia_result   = batavia_pull_write(
			$batavia_root . '/' . $batavia_relative,
			$batavia_post->post_content,
			$batavia_relative
		);

		if ( 'written' === $batavia_result ) {
			++$batavia_written;
		} else {
			++$batavia_unchanged;
		}
	}
}

$batavia_gs_id = WP_Theme_JSON_Resolver::get_user_global_styles_post_id();
$batavia_gs    = $batavia_gs_id ? get_post( $batavia_gs_id ) : null;

if ( $batavia_gs && trim( (string) $batavia_gs->post_content ) !== '' ) {
	$batavia_user = json_decode( $batavia_gs->post_content, true );

	unset( $batavia_user['isGlobalStylesUserThemeJSON'], $batavia_user['version'] );
	$batavia_user = array_filter(
		array(
			'settings' => isset( $batavia_user['settings'] ) ? $batavia_user['settings'] : null,
			'styles'   => isset( $batavia_user['styles'] ) ? $batavia_user['styles'] : null,
		)
	);

	if ( $batavia_user ) {
		printf( "\nglobal styles (Appearance > Editor > Styles)\n" );

		foreach ( batavia_pull_paths( $batavia_user ) as $batavia_path ) {
			printf( "  %s  %s\n", $batavia_apply_styles ? 'merging  ' : 'would set', $batavia_path );
		}

		if ( $batavia_apply_styles ) {
			$batavia_theme_json = json_decode( file_get_contents( $batavia_root . '/theme.json' ), true );
			$batavia_theme_json = batavia_pull_merge( $batavia_theme_json, $batavia_user );

			$batavia_encoded = wp_json_encode( $batavia_theme_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

			// theme.json is tab-indented in this repo; json_encode uses four spaces.
			$batavia_encoded = preg_replace_callback(
				'/^(?: {4})+/m',
				static function ( $m ) {
					return str_repeat( "\t", strlen( $m[0] ) / 4 );
				},
				$batavia_encoded
			);

			batavia_pull_write( $batavia_root . '/theme.json', $batavia_encoded, 'theme.json' );
			++$batavia_written;
		} else {
			printf( "\n  Pass \"styles\" to merge these into theme.json.\n" );
		}
	}
}

if ( 0 === $batavia_written && 0 === $batavia_unchanged ) {
	echo "\nNothing has been customised in the editor.\n";
	exit( 0 );
}

printf( "\n%d file(s) written, %d already current.\n", $batavia_written, $batavia_unchanged );
echo "Run tools/reset-editor.php to clear the database copies.\n";
