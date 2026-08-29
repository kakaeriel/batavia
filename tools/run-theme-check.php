<?php
/**
 * Runs the Theme Check plugin against Celestine and reports the result.
 *
 * Theme Check is the tool the WordPress.org review team runs, but it ships only
 * as an admin screen with no command line entry point. It does expose its
 * checks programmatically, so this drives them directly and turns the result
 * into something a CI job can fail on.
 *
 * Usage: wp eval-file tools/run-theme-check.php
 *
 * Exits 0 when nothing REQUIRED is reported, 1 otherwise. WARNING and
 * RECOMMENDED notices are printed but do not fail the run.
 *
 * @package Celestine
 */

declare( strict_types=1 );

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	echo "This script must be run through wp eval-file.\n";
	exit( 1 );
}

/*
 * Theme Check only loads its check classes inside its admin screen callback, so
 * the plugin being active is not enough -- the files have to be pulled in here.
 */
if ( ! function_exists( 'run_themechecks_against_theme' ) ) {
	$celestine_tc_dir = WP_PLUGIN_DIR . '/theme-check';

	if ( ! is_file( $celestine_tc_dir . '/checkbase.php' ) ) {
		echo "The theme-check plugin is not installed. Install and activate it first:\n";
		echo "  wp plugin install theme-check --activate\n";
		exit( 1 );
	}

	add_filter(
		'extra_theme_headers',
		static function () {
			return array( 'License', 'License URI', 'Template Version' );
		}
	);

	require_once $celestine_tc_dir . '/checkbase.php';
	require_once $celestine_tc_dir . '/main.php';
}

if ( ! function_exists( 'run_themechecks_against_theme' ) ) {
	echo "Could not load the Theme Check plugin's checks.\n";
	exit( 1 );
}

/*
 * Theme Check walks every file under the theme directory. In a local install the
 * theme is symlinked straight from the repository, so it would also scan the
 * development tooling -- which never reaches a user and would report failures
 * that do not exist in the distributed theme.
 *
 * Feeding theme_scandir_exclusions the contents of .distignore means the check
 * sees precisely what tools/build-zip.sh ships, and the two cannot drift apart.
 */
add_filter(
	'theme_scandir_exclusions',
	static function ( $exclusions ) {
		$distignore = get_theme_root() . '/' . get_stylesheet() . '/.distignore';
		$extra      = array( 'tools', 'build' );

		if ( is_readable( $distignore ) ) {
			$extra = array();

			foreach ( (array) file( $distignore, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES ) as $line ) {
				$line = trim( $line );

				if ( '' === $line || '#' === $line[0] ) {
					continue;
				}

				$extra[] = $line;
			}
		}

		return array_values( array_unique( array_merge( (array) $exclusions, $extra ) ) );
	}
);

$celestine_theme = wp_get_theme( get_stylesheet() );

if ( ! $celestine_theme->exists() ) {
	echo "The theme was not found in this install.\n";
	exit( 1 );
}

run_themechecks_against_theme( $celestine_theme, get_stylesheet() );

$celestine_findings = array();

global $themechecks;

foreach ( (array) $themechecks as $celestine_check ) {
	if ( ! $celestine_check instanceof themecheck ) {
		continue;
	}

	foreach ( (array) $celestine_check->getError() as $celestine_error ) {
		$celestine_findings[] = $celestine_error;
	}
}

$celestine_findings = array_unique( $celestine_findings );

$celestine_buckets = array(
	'REQUIRED'    => array(),
	'WARNING'     => array(),
	'RECOMMENDED' => array(),
	'INFO'        => array(),
);

foreach ( $celestine_findings as $celestine_finding ) {
	$celestine_text = trim( html_entity_decode( wp_strip_all_tags( $celestine_finding ), ENT_QUOTES, 'UTF-8' ) );
	$celestine_text = (string) preg_replace( '/\s+/', ' ', $celestine_text );

	foreach ( array_keys( $celestine_buckets ) as $celestine_level ) {
		if ( 0 === strpos( $celestine_text, $celestine_level ) ) {
			$celestine_buckets[ $celestine_level ][] = trim( substr( $celestine_text, strlen( $celestine_level ) ) );
			continue 2;
		}
	}

	$celestine_buckets['INFO'][] = $celestine_text;
}

foreach ( $celestine_buckets as $celestine_level => $celestine_items ) {
	if ( ! $celestine_items ) {
		continue;
	}

	printf( "\n%s (%d)\n", $celestine_level, count( $celestine_items ) );

	foreach ( $celestine_items as $celestine_item ) {
		printf( "  - %s\n", $celestine_item );
	}
}

$celestine_required = count( $celestine_buckets['REQUIRED'] );

printf(
	"\n%d required, %d warnings, %d recommended, %d info\n",
	$celestine_required,
	count( $celestine_buckets['WARNING'] ),
	count( $celestine_buckets['RECOMMENDED'] ),
	count( $celestine_buckets['INFO'] )
);

if ( $celestine_required > 0 ) {
	echo "Theme Check reported required changes.\n";
	exit( 1 );
}

echo "Theme Check found nothing required.\n";
