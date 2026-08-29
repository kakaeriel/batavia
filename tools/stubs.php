<?php
/**
 * Minimal stand-ins for the WordPress functions Batavia's patterns call.
 *
 * The validator executes each pattern file to capture its output. Bootstrapping
 * WordPress for that would require a database, so instead the handful of i18n,
 * escaping and URL helpers the patterns use are defined here with the same
 * signatures. Anything a pattern calls that is not defined here raises a fatal
 * error, which is the desired outcome -- patterns should not reach for
 * WordPress APIs beyond this set.
 *
 * Patterns also call the theme's own `batavia_get_setting*()` functions from
 * `inc/settings.php`. That is real theme logic, not a WordPress API, so it is
 * required for real rather than stubbed -- with just enough of `add_action()`
 * and `get_option()` beneath it to load without a database, reading back as
 * the empty options of a fresh install.
 *
 * @package Batavia
 */

declare( strict_types=1 );

const BATAVIA_STUB_THEME_URI = 'https://example.test/wp-content/themes/batavia';

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
		return BATAVIA_STUB_THEME_URI . '/' . ltrim( (string) $file, '/' );
	}
}

if ( ! function_exists( 'get_template_directory_uri' ) ) {
	/**
	 * Returns the URL of the theme directory.
	 *
	 * @return string Absolute URL.
	 */
	function get_template_directory_uri() {
		return BATAVIA_STUB_THEME_URI;
	}
}

if ( ! function_exists( 'get_stylesheet_directory_uri' ) ) {
	/**
	 * Returns the URL of the stylesheet directory.
	 *
	 * @return string Absolute URL.
	 */
	function get_stylesheet_directory_uri() {
		return BATAVIA_STUB_THEME_URI;
	}
}

if ( ! function_exists( 'add_action' ) ) {
	/**
	 * No-op stand-in for the hooks API.
	 *
	 * `inc/settings.php` registers `batavia_register_settings` on `admin_init`
	 * at the top level of the file; nothing here ever fires that hook, so
	 * this only needs to exist, not do anything.
	 *
	 * @param string   $hook_name Hook name.
	 * @param callable $callback  Callback.
	 * @param int      $priority  Priority.
	 * @param int      $args      Accepted argument count.
	 * @return true Always.
	 */
	function add_action( $hook_name, $callback, $priority = 10, $args = 1 ) {
		unset( $hook_name, $callback, $priority, $args );
		return true;
	}
}

if ( ! function_exists( 'absint' ) ) {
	/**
	 * Casts a value to a non-negative integer.
	 *
	 * @param mixed $value Value to convert.
	 * @return int A non-negative integer.
	 */
	function absint( $value ) {
		return abs( (int) $value );
	}
}

if ( ! function_exists( 'wp_json_encode' ) ) {
	/**
	 * Encodes a value as JSON.
	 *
	 * @param mixed $value Value to encode.
	 * @return string|false JSON string, or false on failure.
	 */
	function wp_json_encode( $value ) {
		return json_encode( $value ); // phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode
	}
}

if ( ! function_exists( 'get_option' ) ) {
	/**
	 * Reads a database option.
	 *
	 * There is no database here, so every option reads as never having been
	 * saved -- the same state as a fresh install, which is what
	 * `batavia_get_setting_bool()` is written to render as a finished page.
	 *
	 * @param string $option  Option name.
	 * @param mixed  $default Value to return.
	 * @return mixed The default value.
	 */
	function get_option( $option, $default = false ) { // phpcs:ignore Universal.NamingConventions.NoReservedKeywordParameterNames
		unset( $option );
		return $default;
	}
}

// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', BATAVIA_THEME_DIR . '/' );
}

require_once BATAVIA_THEME_DIR . '/inc/settings.php';
