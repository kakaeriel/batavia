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
 * @package Celestine
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	echo "This script must be run through wp eval-file.\n";
	exit( 1 );
}

$celestine_confirmed = isset( $args ) && in_array( 'delete', (array) $args, true );
$celestine_found     = 0;

foreach ( array( 'wp_template', 'wp_template_part' ) as $celestine_type ) {
	$celestine_posts = get_posts(
		array(
			'post_type'      => $celestine_type,
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

	foreach ( $celestine_posts as $celestine_post ) {
		++$celestine_found;
		printf(
			"  %s  %s/%s\n",
			$celestine_confirmed ? 'deleted ' : 'would delete',
			'wp_template' === $celestine_type ? 'templates' : 'parts',
			$celestine_post->post_name
		);

		if ( $celestine_confirmed ) {
			wp_delete_post( $celestine_post->ID, true );
		}
	}
}

$celestine_gs_id = WP_Theme_JSON_Resolver::get_user_global_styles_post_id();

if ( $celestine_gs_id ) {
	$celestine_gs = get_post( $celestine_gs_id );

	/*
	 * get_user_global_styles_post_id() creates the post on first call, so its
	 * existence means nothing. Only settings or styles actually being present
	 * counts as a customisation.
	 */
	$celestine_gs_data = $celestine_gs ? json_decode( (string) $celestine_gs->post_content, true ) : null;
	$celestine_gs_used = is_array( $celestine_gs_data )
		&& ( ! empty( $celestine_gs_data['settings'] ) || ! empty( $celestine_gs_data['styles'] ) );

	if ( $celestine_gs_used ) {
		++$celestine_found;
		printf( "  %s  global styles\n", $celestine_confirmed ? 'reset   ' : 'would reset' );

		if ( $celestine_confirmed ) {
			wp_update_post(
				array(
					'ID'           => $celestine_gs_id,
					'post_content' => '{"version":3,"isGlobalStylesUserThemeJSON":true}',
				)
			);
		}
	}
}

if ( 0 === $celestine_found ) {
	echo "Nothing customised. The theme's files are already authoritative.\n";
	exit( 0 );
}

if ( ! $celestine_confirmed ) {
	printf( "\n%d item(s). Pass \"delete\" to remove them.\n", $celestine_found );
	exit( 0 );
}

wp_cache_flush();
printf( "\n%d item(s) removed. The theme's files are authoritative again.\n", $celestine_found );
