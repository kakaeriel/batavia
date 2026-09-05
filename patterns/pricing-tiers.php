<?php
/**
 * Title: Consulting rates
 * Slug: batavia/pricing-tiers
 * Categories: batavia, services, text
 * Description: Ways of working, as ruled rows with the rate set quietly beside each, and one enquiry button for all of them. Edit the list from Appearance -> Customize -> Batavia -> Consulting.
 * Keywords: pricing, rates, consulting, packages, retainer, freelance
 * Viewport Width: 1400
 *
 * The tiers themselves come from Appearance -> Customize -> Batavia -- add,
 * remove and reorder them there. Leaving every row empty keeps the three
 * example tiers below, the same way an empty text field elsewhere in the
 * theme keeps the pattern's own wording.
 *
 * This was three boxed cards with the price in display type, which read like
 * a pricing page on a SaaS site. Rates on a personal site are a fact about the
 * work, not the pitch: set them beside the description at the size of any
 * other number and the section stops shouting.
 *
 * The button reads the contact link from Appearance -> Customize -> Batavia.
 * One button, not one per tier, because a reader choosing between them has not
 * decided anything yet.
 *
 * The section title and intro are edited directly here, like any other text.
 *
 * @package Batavia
 * @since   1.0.0
 */

if ( ! batavia_get_setting_bool( 'show_consulting' ) ) {
	return;
}

$batavia_consulting_rows = batavia_get_repeater_rows( 'consulting' );

if ( empty( $batavia_consulting_rows ) ) {
	$batavia_consulting_rows = array(
		array(
			'title'       => __( 'Hourly', 'batavia' ),
			'description' => __( 'Advisory, code and design review, and the architecture questions that are quicker to answer than to write down. Billed in 30-minute blocks, no minimum commitment.', 'batavia' ),
			'price'       => __( '$225 / hour', 'batavia' ),
		),
		array(
			'title'       => __( 'Project', 'batavia' ),
			'description' => __( 'A fixed scope, agreed after a short discovery and written down before the first commit. Delivered with a handover, typically over six to ten weeks.', 'batavia' ),
			'price'       => __( 'from $18,000', 'batavia' ),
		),
		array(
			'title'       => __( 'Retainer', 'batavia' ),
			'description' => __( 'Around two days a week of standing capacity, with priority on anything asked asynchronously. Three months minimum, because less than that is a project.', 'batavia' ),
			'price'       => __( '$7,500 / month', 'batavia' ),
		),
	);
}

$batavia_last_row_index = count( $batavia_consulting_rows ) - 1;

?>
<!-- wp:group {"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},"border":{"top":{"color":"var:preset|color|rule","width":"1px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-surface-background-color has-background" style="border-top-color:var(--wp--preset--color--rule);border-top-width:1px;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","contentSize":"46rem","wideSize":"76rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":2,"align":"wide","className":"is-style-batavia-label"} -->
		<h2 class="wp-block-heading alignwide is-style-batavia-label"><?php esc_html_e( 'Consulting', 'batavia' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"large"} -->
		<p class="has-large-font-size"><?php esc_html_e( 'Three ways to work together. Whichever it is, the scope and the timeline are agreed in writing before anything starts.', 'batavia' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group alignwide">
			<?php foreach ( $batavia_consulting_rows as $batavia_index => $batavia_row ) : ?>
				<?php $batavia_row_title = isset( $batavia_row['title'] ) ? $batavia_row['title'] : ''; ?>
				<?php $batavia_row_description = isset( $batavia_row['description'] ) ? $batavia_row['description'] : ''; ?>
				<?php $batavia_row_price = isset( $batavia_row['price'] ) ? $batavia_row['price'] : ''; ?>
				<?php if ( $batavia_index === $batavia_last_row_index ) : ?>
					<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30","padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
					<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)">
						<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained","contentSize":"32rem","justifyContent":"left"}} -->
						<div class="wp-block-group">
							<!-- wp:heading {"level":3,"fontSize":"large"} -->
							<h3 class="wp-block-heading has-large-font-size"><?php echo esc_html( $batavia_row_title ); ?></h3>
							<!-- /wp:heading -->

							<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
							<p class="has-muted-color has-text-color has-small-font-size"><?php echo esc_html( $batavia_row_description ); ?></p>
							<!-- /wp:paragraph -->
						</div>
						<!-- /wp:group -->

						<!-- wp:paragraph {"style":{"typography":{"fontWeight":"500"}},"fontFamily":"mono","fontSize":"medium"} -->
						<p class="has-medium-font-size has-mono-font-family" style="font-weight:500"><?php echo esc_html( $batavia_row_price ); ?></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:group -->
				<?php else : ?>
					<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30","padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
					<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)">
						<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained","contentSize":"32rem","justifyContent":"left"}} -->
						<div class="wp-block-group">
							<!-- wp:heading {"level":3,"fontSize":"large"} -->
							<h3 class="wp-block-heading has-large-font-size"><?php echo esc_html( $batavia_row_title ); ?></h3>
							<!-- /wp:heading -->

							<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
							<p class="has-muted-color has-text-color has-small-font-size"><?php echo esc_html( $batavia_row_description ); ?></p>
							<!-- /wp:paragraph -->
						</div>
						<!-- /wp:group -->

						<!-- wp:paragraph {"style":{"typography":{"fontWeight":"500"}},"fontFamily":"mono","fontSize":"medium"} -->
						<p class="has-medium-font-size has-mono-font-family" style="font-weight:500"><?php echo esc_html( $batavia_row_price ); ?></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:group -->
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
		<div class="wp-block-group">
			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"metadata":{"bindings":{"url":{"source":"batavia/setting","args":{"key":"contact_url"}}}}} -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Ask about a project', 'batavia' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->

			<!-- wp:social-links {"iconColor":"accent","size":"has-normal-icon-size","layout":{"type":"flex"}} -->
			<ul class="wp-block-social-links has-normal-icon-size has-icon-color has-accent-color">
				<!-- wp:social-link {"service":"whatsapp","label":"WhatsApp"} /-->
			</ul>
			<!-- /wp:social-links -->

			<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
			<p class="has-muted-color has-text-color has-small-font-size"><?php esc_html_e( 'Rates are indicative and exclude tax.', 'batavia' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
