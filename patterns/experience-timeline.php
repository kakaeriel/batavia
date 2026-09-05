<?php
/**
 * Title: Experience
 * Slug: batavia/experience-timeline
 * Categories: batavia, text, about
 * Description: A ruled list of roles, each with the company mark, the dates, the title and two sentences on what the job actually was. Edit the list from Appearance -> Customize -> Batavia -> Experience.
 *
 * The section title is edited directly here, like any other heading.
 * Keywords: experience, timeline, career, roles, history, resume, work
 * Viewport Width: 1400
 *
 * The rows themselves come from Appearance -> Customize -> Batavia -- add,
 * remove and reorder them there. Leaving every row empty keeps the three
 * example roles below, the same way an empty text field elsewhere in the
 * theme keeps the pattern's own wording.
 *
 * A row's circle shows its "Company" field's Logo if set; otherwise the
 * initials of the Company name; otherwise the first letter of the title. The
 * Company name itself is also printed next to the role, since a one- or
 * two-letter mark is not always enough to say who the role was at.
 *
 * @package Batavia
 * @since   1.0.0
 */

if ( ! batavia_get_setting_bool( 'show_experience' ) ) {
	return;
}

$batavia_experience_rows = batavia_get_repeater_rows( 'experience' );

if ( empty( $batavia_experience_rows ) ) {
	$batavia_experience_rows = array(
		array(
			'mark'        => 'N',
			'dates'       => __( '2021 — Present', 'batavia' ),
			'title'       => __( 'Lead Engineer, Northwind Studio', 'batavia' ),
			'description' => __( 'Rebuilt a publisher\'s editorial platform as a block theme, with the editing workflow the newsroom actually uses rather than the one the old site assumed. Page weight down by two thirds.', 'batavia' ),
		),
		array(
			'mark'        => 'H',
			'dates'       => __( '2017 — 2021', 'batavia' ),
			'title'       => __( 'Senior Developer, Halyard Digital', 'batavia' ),
			'description' => __( 'Kept forty client sites on one deployment pipeline. Wrote the update and rollback procedure, then automated the parts nobody enjoys doing at midnight.', 'batavia' ),
		),
		array(
			'mark'        => 'F',
			'dates'       => __( '2013 — 2017', 'batavia' ),
			'title'       => __( 'Developer, Ferrous Labs', 'batavia' ),
			'description' => __( 'PHP and MySQL behind a booking product that went from a handful of venues to several hundred. Learned which queries fall over first, and in what order.', 'batavia' ),
		),
	);
}

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},"border":{"top":{"color":"var:preset|color|rule","width":"1px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="border-top-color:var(--wp--preset--color--rule);border-top-width:1px;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","contentSize":"46rem","wideSize":"76rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":2,"align":"wide","className":"is-style-batavia-label"} -->
		<h2 class="wp-block-heading alignwide is-style-batavia-label"><?php esc_html_e( 'Experience', 'batavia' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
		<div class="wp-block-group alignwide">
			<?php foreach ( $batavia_experience_rows as $batavia_row ) : ?>
				<?php
				// Logo image for the mark, if one is set. The mark is rendered as a fixed
				// circle and cropped via CSS (object-fit: cover), so the attachment size
				// choice here is primarily a quality/performance trade-off.
				$batavia_logo_id  = ! empty( $batavia_row['logo'] ) ? absint( $batavia_row['logo'] ) : 0;
				$batavia_logo_url = $batavia_logo_id > 0 ? wp_get_attachment_image_url( $batavia_logo_id, 'medium' ) : '';

				$batavia_company = ! empty( $batavia_row['mark'] ) ? $batavia_row['mark'] : '';

				/*
				 * The circle's fallback initial, only ever shown when there is no
				 * Logo: from the Company name first, since that is what the circle
				 * is standing in for, otherwise from the role's own title.
				 *
				 * WordPress polyfills mb_substr() in wp-includes/compat.php but
				 * not mb_strtoupper(), and mbstring is not compiled into every
				 * PHP build, so uppercasing falls back to strtoupper(). That is
				 * ASCII-only, which is why the letters are taken first and cased
				 * second: a multibyte initial is then passed through unchanged
				 * rather than mangled.
				 */
				$batavia_initial_from = '' !== $batavia_company
					? $batavia_company
					: ( ! empty( $batavia_row['title'] ) ? $batavia_row['title'] : '' );

				$batavia_initials = '';

				if ( '' !== $batavia_initial_from ) {
					$batavia_initials = mb_substr( $batavia_initial_from, 0, '' !== $batavia_company ? 2 : 1, 'UTF-8' );

					$batavia_initials = function_exists( 'mb_strtoupper' )
						? mb_strtoupper( $batavia_initials, 'UTF-8' )
						: strtoupper( $batavia_initials );
				}
				?>
				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30","padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
				<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">
					<!-- wp:group {"className":"is-style-batavia-mark","layout":{"type":"constrained"}} -->
					<div class="wp-block-group is-style-batavia-mark">
						<?php if ( '' !== $batavia_logo_url ) : ?>
						<!-- wp:image {"sizeSlug":"medium"} -->
						<figure class="wp-block-image size-medium"><img src="<?php echo esc_url( $batavia_logo_url ); ?>" alt="<?php echo esc_attr( $batavia_company ); ?>" /></figure>
						<!-- /wp:image -->
						<?php else : ?>
							<!-- wp:paragraph {"fontFamily":"mono","fontSize":"medium"} -->
							<p class="has-medium-font-size has-mono-font-family"><?php echo esc_html( $batavia_initials ); ?></p>
							<!-- /wp:paragraph -->
						<?php endif; ?>
					</div>
					<!-- /wp:group -->

					<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
					<div class="wp-block-group">
						<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
						<div class="wp-block-group">
							<!-- wp:paragraph {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
							<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family"><?php echo esc_html( isset( $batavia_row['dates'] ) ? $batavia_row['dates'] : '' ); ?></p>
							<!-- /wp:paragraph -->

							<?php if ( '' !== $batavia_company ) : ?>
								<!-- wp:paragraph {"fontFamily":"mono","fontSize":"x-small","style":{"typography":{"fontWeight":"600"}}} -->
								<p class="has-x-small-font-size has-mono-font-family" style="font-weight:600"><?php echo esc_html( $batavia_company ); ?></p>
								<!-- /wp:paragraph -->
							<?php endif; ?>
						</div>
						<!-- /wp:group -->

						<!-- wp:heading {"level":3,"fontSize":"large"} -->
						<h3 class="wp-block-heading has-large-font-size"><?php echo esc_html( isset( $batavia_row['title'] ) ? $batavia_row['title'] : '' ); ?></h3>
						<!-- /wp:heading -->

						<!-- wp:paragraph {"textColor":"muted"} -->
						<p class="has-muted-color has-text-color"><?php echo esc_html( isset( $batavia_row['description'] ) ? $batavia_row['description'] : '' ); ?></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:group -->
				</div>
				<!-- /wp:group -->
			<?php endforeach; ?>
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
