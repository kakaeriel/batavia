<?php
/**
 * Deletes Site Editor customisations so the theme's files are authoritative.
 *
 * WordPress prefers a customised template stored in the database over the file
 * of the same name. That is correct for a running site and wrong for theme
 * development: once a template is customised, editing templates/<slug>.html has
 * no visible effect.
 *
 * Pull anything worth keeping first with tools/pull-from-editor.php.
 *
 * Usage:
 *   wp eval-file tools/reset-editor.php          list what would be deleted
 *   wp eval-file tools/reset-editor.php delete   delete it
 *
 * @package Batavia
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	echo "This script must be run through wp eval-file.\n";
	exit( 1 );
}

$batavia_confirmed = isset( $args ) && in_array( 'delete', (array) $args, true );
$batavia_found     = 0;

foreach ( array( 'wp_template', 'wp_template_part' ) as $batavia_type ) {
	$batavia_posts = get_posts(
		array(
			'post_type'      => $batavia_type,
			'post_status'    => array( 'publish', 'draft', 'trash', 'auto-draft' ),
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

	foreach ( $batavia_posts as $batavia_post ) {
		++$batavia_found;
		printf(
			"  %s  %s/%s\n",
			$batavia_confirmed ? 'deleted ' : 'would delete',
			'wp_template' === $batavia_type ? 'templates' : 'parts',
			$batavia_post->post_name
		);

		if ( $batavia_confirmed ) {
			wp_delete_post( $batavia_post->ID, true );
		}
	}
}

$batavia_gs_id = WP_Theme_JSON_Resolver::get_user_global_styles_post_id();

if ( $batavia_gs_id ) {
	$batavia_gs = get_post( $batavia_gs_id );

	/*
	 * get_user_global_styles_post_id() creates the post on first call, so its
	 * existence means nothing. Only settings or styles actually being present
	 * counts as a customisation.
	 */
	$batavia_gs_data = $batavia_gs ? json_decode( (string) $batavia_gs->post_content, true ) : null;
	$batavia_gs_used = is_array( $batavia_gs_data )
		&& ( ! empty( $batavia_gs_data['settings'] ) || ! empty( $batavia_gs_data['styles'] ) );

	if ( $batavia_gs_used ) {
		++$batavia_found;
		printf( "  %s  global styles\n", $batavia_confirmed ? 'reset   ' : 'would reset' );

		if ( $batavia_confirmed ) {
			wp_update_post(
				array(
					'ID'           => $batavia_gs_id,
					'post_content' => '{"version":3,"isGlobalStylesUserThemeJSON":true}',
				)
			);
		}
	}
}

if ( 0 === $batavia_found ) {
	echo "Nothing customised. The theme's files are already authoritative.\n";
	exit( 0 );
}

if ( ! $batavia_confirmed ) {
	printf( "\n%d item(s). Pass \"delete\" to remove them.\n", $batavia_found );
	exit( 0 );
}

wp_cache_flush();
printf( "\n%d item(s) removed. The theme's files are authoritative again.\n", $batavia_found );
