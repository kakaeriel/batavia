<?php
/**
 * Title: Consulting rates
 * Slug: celestine/pricing-tiers
 * Categories: celestine, services, columns
 * Description: Three consulting packages -- hourly, fixed-scope project and monthly retainer -- each with a rate, what it covers, and an enquiry button.
 * Keywords: pricing, rates, consulting, packages, retainer, freelance
 * Viewport Width: 1400
 *
 * @package Celestine
 * @since   1.0.0
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained","contentSize":"46rem","wideSize":"76rem","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":2,"align":"wide","className":"is-style-celestine-label"} -->
		<h2 class="wp-block-heading alignwide is-style-celestine-label"><?php esc_html_e( 'Consulting', 'celestine' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
		<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Three ways to work together. Rates are indicative; scope and timeline are agreed in writing before anything starts.', 'celestine' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30"}}}} -->
		<div class="wp-block-columns alignwide">
			<!-- wp:column -->
			<div class="wp-block-column">
				<!-- wp:group {"className":"is-style-celestine-panel","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group is-style-celestine-panel">
					<!-- wp:heading {"level":3,"textColor":"muted","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"500"}},"fontFamily":"mono","fontSize":"x-small"} -->
					<h3 class="wp-block-heading has-muted-color has-text-color has-x-small-font-size has-mono-font-family" style="font-weight:500;letter-spacing:0.1em;text-transform:uppercase"><?php esc_html_e( 'Hourly', 'celestine' ); ?></h3>
					<!-- /wp:heading -->

					<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
					<div class="wp-block-group">
						<!-- wp:paragraph {"className":"is-style-celestine-figure"} -->
						<p class="is-style-celestine-figure"><?php esc_html_e( '$225', 'celestine' ); ?></p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
						<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family"><?php esc_html_e( 'per hour, billed in 30-minute blocks', 'celestine' ); ?></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:group -->

					<!-- wp:list {"className":"is-style-celestine-ruled","fontSize":"small"} -->
					<ul class="wp-block-list is-style-celestine-ruled has-small-font-size">
						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Ad-hoc advisory', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Code and design review', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Architecture questions', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'No minimum commitment', 'celestine' ); ?></li>
						<!-- /wp:list-item -->
					</ul>
					<!-- /wp:list -->

					<!-- wp:buttons -->
					<div class="wp-block-buttons">
						<!-- wp:button {"className":"is-style-outline"} -->
						<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Enquire', 'celestine' ); ?></a></div>
						<!-- /wp:button -->
					</div>
					<!-- /wp:buttons -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column">
				<!-- wp:group {"className":"is-style-celestine-panel","style":{"border":{"color":"var:preset|color|ink","width":"1px"},"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group is-style-celestine-panel has-border-color" style="border-color:var(--wp--preset--color--ink);border-width:1px">
					<!-- wp:heading {"level":3,"textColor":"muted","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"500"}},"fontFamily":"mono","fontSize":"x-small"} -->
					<h3 class="wp-block-heading has-muted-color has-text-color has-x-small-font-size has-mono-font-family" style="font-weight:500;letter-spacing:0.1em;text-transform:uppercase"><?php esc_html_e( 'Project', 'celestine' ); ?></h3>
					<!-- /wp:heading -->

					<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
					<div class="wp-block-group">
						<!-- wp:paragraph {"className":"is-style-celestine-figure"} -->
						<p class="is-style-celestine-figure"><?php esc_html_e( 'from $18,000', 'celestine' ); ?></p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
						<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family"><?php esc_html_e( 'fixed fee, agreed up front', 'celestine' ); ?></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:group -->

					<!-- wp:list {"className":"is-style-celestine-ruled","fontSize":"small"} -->
					<ul class="wp-block-list is-style-celestine-ruled has-small-font-size">
						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Fixed-scope build', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Discovery and written spec', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Delivery and handover', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Typically 6 to 10 weeks', 'celestine' ); ?></li>
						<!-- /wp:list-item -->
					</ul>
					<!-- /wp:list -->

					<!-- wp:buttons -->
					<div class="wp-block-buttons">
						<!-- wp:button -->
						<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Enquire', 'celestine' ); ?></a></div>
						<!-- /wp:button -->
					</div>
					<!-- /wp:buttons -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column">
				<!-- wp:group {"className":"is-style-celestine-panel","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group is-style-celestine-panel">
					<!-- wp:heading {"level":3,"textColor":"muted","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"500"}},"fontFamily":"mono","fontSize":"x-small"} -->
					<h3 class="wp-block-heading has-muted-color has-text-color has-x-small-font-size has-mono-font-family" style="font-weight:500;letter-spacing:0.1em;text-transform:uppercase"><?php esc_html_e( 'Retainer', 'celestine' ); ?></h3>
					<!-- /wp:heading -->

					<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
					<div class="wp-block-group">
						<!-- wp:paragraph {"className":"is-style-celestine-figure"} -->
						<p class="is-style-celestine-figure"><?php esc_html_e( '$7,500', 'celestine' ); ?></p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph {"textColor":"muted","fontFamily":"mono","fontSize":"x-small"} -->
						<p class="has-muted-color has-text-color has-x-small-font-size has-mono-font-family"><?php esc_html_e( 'per month, three-month minimum', 'celestine' ); ?></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:group -->

					<!-- wp:list {"className":"is-style-celestine-ruled","fontSize":"small"} -->
					<ul class="wp-block-list is-style-celestine-ruled has-small-font-size">
						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Ongoing capacity', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Around two days a week', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Priority async access', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Standing review slot', 'celestine' ); ?></li>
						<!-- /wp:list-item -->
					</ul>
					<!-- /wp:list -->

					<!-- wp:buttons -->
					<div class="wp-block-buttons">
						<!-- wp:button {"className":"is-style-outline"} -->
						<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Enquire', 'celestine' ); ?></a></div>
						<!-- /wp:button -->
					</div>
					<!-- /wp:buttons -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->
		</div>
		<!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
