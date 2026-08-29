<?php
/**
 * Plugin Name: Batavia dev guard
 * Description: Stops WordPress from offering to "update" the theme under development.
 * Version:     1.0.0
 * License:     GPL-2.0-or-later
 *
 * A theme in development shares its directory name with whatever is published
 * under that slug on WordPress.org. WordPress compares the two by version and
 * offers an update, and accepting it deletes the theme directory before
 * installing the download. When that directory is a bind mount or a symlink to
 * a working copy -- as it is under wp-env and under tools/dev-server.sh -- the
 * source is deleted along with it.
 *
 * There is no undo, and no warning that the theme about to be overwritten is not
 * the one being offered. So the offer is removed entirely for this theme.
 *
 * The real fix is a slug nobody else has published. This guard exists because
 * the failure is silent and total, and a slug collision can appear at any time
 * when someone else publishes first.
 *
 * Development-only. Loaded as a mu-plugin by the local environment and never
 * distributed with the theme.
 *
 * @package Batavia
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Removes the theme under development from any update offer.
 *
 * @param mixed $value The update_themes site transient.
 * @return mixed Filtered transient.
 */
function batavia_dev_block_theme_update( $value ) {
	$slug = get_stylesheet();

	if ( is_object( $value ) && isset( $value->response[ $slug ] ) ) {
		unset( $value->response[ $slug ] );
	}

	if ( is_object( $value ) && isset( $value->translations ) ) {
		foreach ( (array) $value->translations as $i => $translation ) {
			if ( isset( $translation['slug'] ) && $translation['slug'] === $slug ) {
				unset( $value->translations[ $i ] );
			}
		}
	}

	return $value;
}
add_filter( 'site_transient_update_themes', 'batavia_dev_block_theme_update', 99 );
add_filter( 'transient_update_themes', 'batavia_dev_block_theme_update', 99 );

/**
 * Refuses an upgrade of the theme under development, whatever triggered it.
 *
 * The transient filter hides the button; this catches the request itself,
 * including "update everything" and any automatic update.
 *
 * @param bool|WP_Error $reply Whether to bail without returning the package.
 * @param string        $package The package file name.
 * @param object        $upgrader The upgrader instance.
 * @param array         $hook_extra Extra arguments.
 * @return bool|WP_Error Error when the package targets the theme in development.
 */
function batavia_dev_refuse_theme_upgrade( $reply, $package, $upgrader, $hook_extra = array() ) {
	unset( $upgrader );

	$slug = get_stylesheet();

	if ( isset( $hook_extra['theme'] ) && $hook_extra['theme'] === $slug ) {
		return new WP_Error(
			'batavia_dev_guard',
			sprintf(
				/* translators: %s: Theme directory name. */
				'Refused to update "%s": this directory is a working copy, and updating would delete it. Remove tools/dev-guard.php if this is really what you want.',
				$slug
			)
		);
	}

	return $reply;
}
add_filter( 'upgrader_pre_download', 'batavia_dev_refuse_theme_upgrade', 10, 4 );
