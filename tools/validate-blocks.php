<?php
/**
 * Static validator for Celestine's block markup.
 *
 * Block themes fail in quiet ways: a mistyped block name renders as nothing, a
 * malformed attribute JSON blob silently drops the attribute, and raw HTML that
 * sits outside a block comment turns into a freeform chunk the editor flags as
 * invalid. None of that raises a PHP error. This script drives WordPress's own
 * WP_Block_Parser over every template, template part and pattern in the theme
 * and reports those cases.
 *
 * Patterns are PHP, so they are executed with stubbed i18n and escaping
 * functions and their output is parsed -- which also proves each pattern file
 * runs without notices and emits the markup it is supposed to.
 *
 * Usage:
 *   php tools/validate-blocks.php --core=/path/to/wordpress
 *   WP_CORE_PATH=/path/to/wordpress php tools/validate-blocks.php
 *
 * @package Celestine
 */

declare( strict_types=1 );

if ( PHP_SAPI !== 'cli' ) {
	exit( 1 );
}

const CELESTINE_THEME_DIR = __DIR__ . '/..';

/**
 * Resolves the path to a WordPress core checkout.
 *
 * @param array<int, string> $argv Command line arguments.
 * @return string Absolute path to WordPress core.
 */
function celestine_resolve_core( array $argv ): string {
	$path = getenv( 'WP_CORE_PATH' );

	foreach ( $argv as $arg ) {
		if ( 0 === strpos( $arg, '--core=' ) ) {
			$path = substr( $arg, 7 );
		}
	}

	if ( ! is_string( $path ) || '' === $path ) {
		fwrite( STDERR, "error: WordPress core path not given.\n" );
		fwrite( STDERR, "       pass --core=/path/to/wordpress or set WP_CORE_PATH.\n" );
		exit( 1 );
	}

	$real = realpath( $path );

	if ( false === $real || ! is_file( $real . '/wp-includes/class-wp-block-parser.php' ) ) {
		fwrite( STDERR, "error: not a WordPress core directory: {$path}\n" );
		exit( 1 );
	}

	return $real;
}

/**
 * Expresses a path relative to the theme root, for readable output.
 *
 * @param string $file Absolute or relative path to a theme file.
 * @return string Path relative to the theme root.
 */
function celestine_relative_path( string $file ): string {
	$root = realpath( CELESTINE_THEME_DIR );
	$real = realpath( $file );

	if ( false === $root || false === $real ) {
		return $file;
	}

	return ltrim( str_replace( $root, '', $real ), '/' );
}

/**
 * Collects the names of every block bundled with WordPress core.
 *
 * @param string $core Path to WordPress core.
 * @return array<string, array<int, string>> Block name mapped to its declared attribute names.
 */
function celestine_core_blocks( string $core ): array {
	$blocks = array();

	foreach ( glob( $core . '/wp-includes/blocks/*/block.json' ) as $file ) {
		$json = json_decode( (string) file_get_contents( $file ), true );

		if ( ! is_array( $json ) || ! isset( $json['name'] ) ) {
			continue;
		}

		$attrs = isset( $json['attributes'] ) && is_array( $json['attributes'] )
			? array_keys( $json['attributes'] )
			: array();

		$blocks[ $json['name'] ] = $attrs;
	}

	return $blocks;
}

/*
 * Attributes contributed by block supports rather than declared in block.json.
 */
const CELESTINE_SUPPORT_ATTRS = array(
	'align',
	'backgroundColor',
	'borderColor',
	'className',
	'fontFamily',
	'fontSize',
	'gradient',
	'layout',
	'lock',
	'metadata',
	'style',
	'textColor',
);

/**
 * Loads the theme's pattern files and returns their rendered markup.
 *
 * @return array<string, string> File path mapped to rendered block markup.
 */
function celestine_render_patterns(): array {
	$rendered = array();

	foreach ( glob( CELESTINE_THEME_DIR . '/patterns/*.php' ) as $file ) {
		ob_start();
		include $file;
		$rendered[ $file ] = (string) ob_get_clean();
	}

	return $rendered;
}

/**
 * Walks a parsed block tree, invoking a callback for every block.
 *
 * @param array<int, array<string, mixed>> $blocks   Parsed blocks.
 * @param callable                         $callback Receives each block and its depth.
 * @param int                              $depth    Current depth.
 * @return void
 */
function celestine_walk( array $blocks, callable $callback, int $depth = 0 ): void {
	foreach ( $blocks as $block ) {
		$callback( $block, $depth );

		if ( ! empty( $block['innerBlocks'] ) ) {
			celestine_walk( $block['innerBlocks'], $callback, $depth + 1 );
		}
	}
}

$core = celestine_resolve_core( $argv );

require_once $core . '/wp-includes/class-wp-block-parser-block.php';
require_once $core . '/wp-includes/class-wp-block-parser-frame.php';
require_once $core . '/wp-includes/class-wp-block-parser.php';
require_once __DIR__ . '/stubs.php';

$core_blocks = celestine_core_blocks( $core );
$parser      = new WP_Block_Parser();

$problems = array();
$warnings = array();
$stats    = array(
	'files'  => 0,
	'blocks' => 0,
);

/*
 * Every document to check, keyed by file path. Templates and parts are read
 * straight from disk; patterns are executed first so their PHP runs.
 */
$documents = array();

foreach ( array( 'templates', 'parts' ) as $dir ) {
	foreach ( glob( CELESTINE_THEME_DIR . '/' . $dir . '/*.html' ) as $file ) {
		$documents[ $file ] = (string) file_get_contents( $file );
	}
}

$documents += celestine_render_patterns();

$part_slugs = array_map(
	static fn( string $f ): string => basename( $f, '.html' ),
	glob( CELESTINE_THEME_DIR . '/parts/*.html' )
);

$pattern_slugs = array();
foreach ( glob( CELESTINE_THEME_DIR . '/patterns/*.php' ) as $file ) {
	$head = (string) file_get_contents( $file );
	if ( preg_match( '/^\s*\*\s*Slug:\s*(\S+)\s*$/m', $head, $m ) ) {
		$pattern_slugs[] = $m[1];
	}
}

foreach ( $documents as $file => $markup ) {
	++$stats['files'];

	$relative = celestine_relative_path( $file );
	$blocks   = $parser->parse( $markup );
	$is_part  = false !== strpos( $relative, 'parts/' );
	$is_tpl   = false !== strpos( $relative, 'templates/' );

	celestine_walk(
		$blocks,
		function ( array $block ) use ( $relative, $core_blocks, $part_slugs, $pattern_slugs, &$problems, &$warnings, &$stats ): void {
			$name = $block['blockName'];

			if ( null === $name ) {
				if ( '' !== trim( (string) $block['innerHTML'] ) ) {
					$snippet    = trim( preg_replace( '/\s+/', ' ', (string) $block['innerHTML'] ) ?? '' );
					$problems[] = sprintf(
						'%s: raw HTML outside a block comment -- "%s"',
						$relative,
						substr( $snippet, 0, 70 )
					);
				}
				return;
			}

			++$stats['blocks'];

			if ( ! isset( $core_blocks[ $name ] ) ) {
				$problems[] = sprintf( '%s: unknown block "%s"', $relative, $name );
				return;
			}

			$allowed = array_merge( $core_blocks[ $name ], CELESTINE_SUPPORT_ATTRS );

			foreach ( array_keys( (array) $block['attrs'] ) as $attr ) {
				if ( ! in_array( $attr, $allowed, true ) ) {
					$warnings[] = sprintf(
						'%s: block "%s" has attribute "%s" that is not in its block.json or block supports',
						$relative,
						$name,
						$attr
					);
				}
			}

			if ( 'core/template-part' === $name && isset( $block['attrs']['slug'] ) ) {
				if ( ! in_array( $block['attrs']['slug'], $part_slugs, true ) ) {
					$problems[] = sprintf(
						'%s: references template part "%s" which does not exist in parts/',
						$relative,
						$block['attrs']['slug']
					);
				}
			}

			if ( 'core/pattern' === $name && isset( $block['attrs']['slug'] ) ) {
				if ( ! in_array( $block['attrs']['slug'], $pattern_slugs, true ) ) {
					$problems[] = sprintf(
						'%s: references pattern "%s" which this theme does not register',
						$relative,
						$block['attrs']['slug']
					);
				}
			}
		}
	);

	/*
	 * WordPress 7.0+ only emits the skip link when the rendered template
	 * contains a MAIN element, so every full template needs one.
	 */
	if ( $is_tpl && ! preg_match( '/"tagName"\s*:\s*"main"/', $markup ) ) {
		$problems[] = sprintf(
			'%s: no <main> landmark -- WordPress will not render a skip link for this template',
			$relative
		);
	}

	if ( $is_part && preg_match( '/"tagName"\s*:\s*"main"/', $markup ) ) {
		$problems[] = sprintf( '%s: template part declares a <main> landmark; that belongs in the template', $relative );
	}
}

// Patterns must carry the headers WordPress reads when auto-registering them.
foreach ( glob( CELESTINE_THEME_DIR . '/patterns/*.php' ) as $file ) {
	$head     = (string) file_get_contents( $file );
	$relative = 'patterns/' . basename( $file );

	// Categories only matter for patterns that appear in the inserter.
	$hidden   = (bool) preg_match( '/^\s*\*\s*Inserter:\s*no\s*$/mi', $head );
	$required = $hidden ? array( 'Title', 'Slug' ) : array( 'Title', 'Slug', 'Categories' );

	foreach ( $required as $header ) {
		if ( ! preg_match( '/^\s*\*\s*' . $header . ':\s*\S/m', $head ) ) {
			$problems[] = sprintf( '%s: missing required pattern header "%s"', $relative, $header );
		}
	}

	if ( preg_match( '/^\s*\*\s*Slug:\s*(\S+)\s*$/m', $head, $m ) && 0 !== strpos( $m[1], 'celestine/' ) ) {
		$problems[] = sprintf( '%s: pattern slug "%s" is not namespaced to the theme', $relative, $m[1] );
	}
}

$red    = "\033[31m";
$yellow = "\033[33m";
$green  = "\033[32m";
$dim    = "\033[2m";
$reset  = "\033[0m";

foreach ( $warnings as $warning ) {
	fwrite( STDOUT, $yellow . 'warn  ' . $reset . $warning . "\n" );
}

foreach ( $problems as $problem ) {
	fwrite( STDOUT, $red . 'error ' . $reset . $problem . "\n" );
}

printf(
	"%s%d files, %d blocks parsed%s\n",
	$dim,
	$stats['files'],
	$stats['blocks'],
	$reset
);

if ( $problems ) {
	printf( "%s%d error(s)%s\n", $red, count( $problems ), $reset );
	exit( 1 );
}

printf( "%sblock markup OK%s\n", $green, $reset );
exit( 0 );
