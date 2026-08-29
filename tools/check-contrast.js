/**
 * Contrast audit for Batavia's colour presets.
 *
 * The theme claims accessibility-ready, which means every combination it
 * actually paints has to clear WCAG 2.1 AA. Both palettes are checked: the
 * light one declared in theme.json and the dark one that assets/css/
 * color-scheme.css swaps in under prefers-color-scheme. The colours are read
 * from those files rather than restated here, so the check cannot drift away
 * from what ships.
 *
 * Usage: node tools/check-contrast.js
 * Exits 0 when every required pair passes, 1 otherwise.
 *
 * @package Batavia
 */

'use strict';

const fs = require( 'fs' );
const path = require( 'path' );

const THEME_DIR = path.resolve( __dirname, '..' );

const RED = '\x1b[31m';
const GREEN = '\x1b[32m';
const DIM = '\x1b[2m';
const RESET = '\x1b[0m';

/**
 * Converts a hex colour to its relative luminance, per WCAG 2.1.
 *
 * @param {string} hex Colour in #rrggbb form.
 * @return {number} Relative luminance between 0 and 1.
 */
function luminance( hex ) {
	const channels = [ 1, 3, 5 ].map( ( i ) => parseInt( hex.slice( i, i + 2 ), 16 ) / 255 );

	const [ r, g, b ] = channels.map( ( c ) =>
		c <= 0.03928 ? c / 12.92 : Math.pow( ( c + 0.055 ) / 1.055, 2.4 )
	);

	return 0.2126 * r + 0.7152 * g + 0.0722 * b;
}

/**
 * Contrast ratio between two hex colours.
 *
 * @param {string} a First colour.
 * @param {string} b Second colour.
 * @return {number} Ratio between 1 and 21.
 */
function contrast( a, b ) {
	const [ lo, hi ] = [ luminance( a ), luminance( b ) ].sort( ( x, y ) => x - y );
	return ( hi + 0.05 ) / ( lo + 0.05 );
}

/**
 * Reads the light palette out of theme.json.
 *
 * @return {Object<string, string>} Slug to hex.
 */
function lightPalette() {
	const themeJson = JSON.parse( fs.readFileSync( path.join( THEME_DIR, 'theme.json' ), 'utf8' ) );
	const palette = {};

	for ( const entry of themeJson.settings.color.palette ) {
		palette[ entry.slug ] = entry.color.toUpperCase();
	}

	return palette;
}

/**
 * Reads the dark palette out of the prefers-color-scheme override.
 *
 * @return {Object<string, string>} Slug to hex.
 */
function darkPalette() {
	const css = fs.readFileSync( path.join( THEME_DIR, 'assets/css/color-scheme.css' ), 'utf8' );
	const palette = {};

	for ( const [ , slug, hex ] of css.matchAll( /--wp--preset--color--([a-z-]+):\s*(#[0-9A-Fa-f]{6})/g ) ) {
		palette[ slug ] = hex.toUpperCase();
	}

	return palette;
}

/*
 * Every pair the theme actually renders.
 *
 * `min` is the ratio the pair must reach. 4.5 is the AA threshold for body
 * text. 3.0 applies to large text and to borders that carry meaning. The
 * hairline rule is listed at 1.5: it is a decorative divider, exempt from
 * 1.4.11 because no content depends on seeing it, but it still has to be
 * visible rather than theoretical.
 */
const PAIRS = [
	{ fg: 'ink', bg: 'base', min: 4.5, note: 'body text' },
	{ fg: 'ink', bg: 'surface', min: 4.5, note: 'body text on tinted bands' },
	{ fg: 'muted', bg: 'base', min: 4.5, note: 'dates, excerpts, captions' },
	{ fg: 'muted', bg: 'surface', min: 4.5, note: 'muted text on tinted bands' },
	{ fg: 'accent', bg: 'base', min: 4.5, note: 'links' },
	{ fg: 'accent', bg: 'surface', min: 4.5, note: 'links on tinted bands' },
	{ fg: 'base', bg: 'accent', min: 4.5, note: 'primary button label' },
	{ fg: 'base', bg: 'ink', min: 4.5, note: 'button label on hover' },
	{ fg: 'ink', bg: 'base', min: 3.0, note: 'outline button border' },
	{ fg: 'rule', bg: 'base', min: 1.5, note: 'hairline rule (decorative)' },
	{ fg: 'rule', bg: 'surface', min: 1.5, note: 'hairline rule on tinted bands' },
];

let failures = 0;

for ( const [ label, palette ] of [
	[ 'light', lightPalette() ],
	[ 'dark', darkPalette() ],
] ) {
	process.stdout.write( `\n${ label }\n` );

	for ( const { fg, bg, min, note } of PAIRS ) {
		if ( ! palette[ fg ] || ! palette[ bg ] ) {
			process.stdout.write( `  ${ RED }missing${ RESET } ${ fg } on ${ bg }\n` );
			failures++;
			continue;
		}

		const ratio = contrast( palette[ fg ], palette[ bg ] );
		const pass = ratio >= min;

		if ( ! pass ) {
			failures++;
		}

		process.stdout.write(
			`  ${ pass ? GREEN + '  ok  ' : RED + ' FAIL ' }${ RESET }` +
				`${ ( fg + ' on ' + bg ).padEnd( 20 ) }` +
				`${ ratio.toFixed( 2 ).padStart( 6 ) }:1  ` +
				`${ DIM }min ${ min.toFixed( 1 ) } — ${ note }${ RESET }\n`
		);
	}
}

process.stdout.write( '\n' );

if ( failures ) {
	process.stdout.write( `${ RED }${ failures } pair(s) below threshold${ RESET }\n` );
	process.exit( 1 );
}

process.stdout.write( `${ GREEN }every colour pair meets its threshold${ RESET }\n` );
