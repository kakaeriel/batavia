<?php
/**
 * Minimal stand-ins for the WordPress functions Celestine's patterns call.
 *
 * The validator executes each pattern file to capture its output. Bootstrapping
 * WordPress for that would require a database, so instead the handful of i18n,
 * escaping and URL helpers the patterns use are defined here with the same
 * signatures. Anything a pattern calls that is not defined here raises a fatal
 * error, which is the desired outcome -- patterns should not reach for
 * WordPress APIs beyond this set.
 *
 * @package Celestine
 */

declare( strict_types=1 );

const CELESTINE_STUB_THEME_URI = 'https://example.test/wp-content/themes/celestine';

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound

if ( ! function_exists( 'esc_html' ) ) {
	/**
	 * Escapes text for HTML output.
	 *
	 * @param string $text Text to escape.
	 * @return string Escaped text.
	 */
	function esc_html( $text ) {
		return htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' );
	}
}

if ( ! function_exists( 'esc_attr' ) ) {
	/**
	 * Escapes text for an HTML attribute.
	 *
	 * @param string $text Text to escape.
	 * @return string Escaped text.
	 */
	function esc_attr( $text ) {
		return htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' );
	}
}

if ( ! function_exists( 'esc_url' ) ) {
	/**
	 * Escapes a URL for output.
	 *
	 * @param string $url URL to escape.
	 * @return string Escaped URL.
	 */
	function esc_url( $url ) {
		return htmlspecialchars( (string) $url, ENT_QUOTES, 'UTF-8' );
	}
}

if ( ! function_exists( '__' ) ) {
	/**
	 * Returns a translated string.
	 *
	 * @param string $text   Text to translate.
	 * @param string $domain Text domain.
	 * @return string Translated text.
	 */
	function __( $text, $domain = 'default' ) { // phpcs:ignore Universal.NamingConventions.NoReservedKeywordParameterNames
		unset( $domain );
		return (string) $text;
	}
}

if ( ! function_exists( '_x' ) ) {
	/**
	 * Returns a translated string with context.
	 *
	 * @param string $text    Text to translate.
	 * @param string $context Disambiguating context.
	 * @param string $domain  Text domain.
	 * @return string Translated text.
	 */
	function _x( $text, $context, $domain = 'default' ) {
		unset( $context, $domain );
		return (string) $text;
	}
}

if ( ! function_exists( '_e' ) ) {
	/**
	 * Echoes a translated string.
	 *
	 * @param string $text   Text to translate.
	 * @param string $domain Text domain.
	 * @return void
	 */
	function _e( $text, $domain = 'default' ) {
		echo __( $text, $domain ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'esc_html__' ) ) {
	/**
	 * Returns a translated, HTML-escaped string.
	 *
	 * @param string $text   Text to translate.
	 * @param string $domain Text domain.
	 * @return string Escaped translated text.
	 */
	function esc_html__( $text, $domain = 'default' ) {
		return esc_html( __( $text, $domain ) );
	}
}

if ( ! function_exists( 'esc_html_e' ) ) {
	/**
	 * Echoes a translated, HTML-escaped string.
	 *
	 * @param string $text   Text to translate.
	 * @param string $domain Text domain.
	 * @return void
	 */
	function esc_html_e( $text, $domain = 'default' ) {
		echo esc_html( __( $text, $domain ) );
	}
}

if ( ! function_exists( 'esc_html_x' ) ) {
	/**
	 * Returns a translated, HTML-escaped string with context.
	 *
	 * @param string $text    Text to translate.
	 * @param string $context Disambiguating context.
	 * @param string $domain  Text domain.
	 * @return string Escaped translated text.
	 */
	function esc_html_x( $text, $context, $domain = 'default' ) {
		return esc_html( _x( $text, $context, $domain ) );
	}
}

if ( ! function_exists( 'esc_attr__' ) ) {
	/**
	 * Returns a translated, attribute-escaped string.
	 *
	 * @param string $text   Text to translate.
	 * @param string $domain Text domain.
	 * @return string Escaped translated text.
	 */
	function esc_attr__( $text, $domain = 'default' ) {
		return esc_attr( __( $text, $domain ) );
	}
}

if ( ! function_exists( 'esc_attr_e' ) ) {
	/**
	 * Echoes a translated, attribute-escaped string.
	 *
	 * @param string $text   Text to translate.
	 * @param string $domain Text domain.
	 * @return void
	 */
	function esc_attr_e( $text, $domain = 'default' ) {
		echo esc_attr( __( $text, $domain ) );
	}
}

if ( ! function_exists( 'esc_attr_x' ) ) {
	/**
	 * Returns a translated, attribute-escaped string with context.
	 *
	 * @param string $text    Text to translate.
	 * @param string $context Disambiguating context.
	 * @param string $domain  Text domain.
	 * @return string Escaped translated text.
	 */
	function esc_attr_x( $text, $context, $domain = 'default' ) {
		return esc_attr( _x( $text, $context, $domain ) );
	}
}

if ( ! function_exists( 'get_theme_file_uri' ) ) {
	/**
	 * Returns the URL of a file in the theme.
	 *
	 * @param string $file Relative path to the file.
	 * @return string Absolute URL.
	 */
	function get_theme_file_uri( $file = '' ) {
		return CELESTINE_STUB_THEME_URI . '/' . ltrim( (string) $file, '/' );
	}
}

if ( ! function_exists( 'get_template_directory_uri' ) ) {
	/**
	 * Returns the URL of the theme directory.
	 *
	 * @return string Absolute URL.
	 */
	function get_template_directory_uri() {
		return CELESTINE_STUB_THEME_URI;
	}
}

if ( ! function_exists( 'get_stylesheet_directory_uri' ) ) {
	/**
	 * Returns the URL of the stylesheet directory.
	 *
	 * @return string Absolute URL.
	 */
	function get_stylesheet_directory_uri() {
		return CELESTINE_STUB_THEME_URI;
	}
}

// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound
