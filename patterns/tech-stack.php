<?php
/**
 * Title: Tech stack
 * Slug: celestine/tech-stack
 * Categories: celestine, columns, about
 * Description: A three-column specification sheet of languages, data stores and infrastructure, set in monospace.
 * Keywords: stack, skills, tools, languages, technology
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
		<h2 class="wp-block-heading alignwide is-style-celestine-label"><?php esc_html_e( 'Stack', 'celestine' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|50"}}}} -->
		<div class="wp-block-columns alignwide">
			<!-- wp:column -->
			<div class="wp-block-column">
				<!-- wp:group {"style":{"border":{"top":{"color":"var:preset|color|ink","width":"2px"}},"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--ink);border-top-width:2px;padding-top:var(--wp--preset--spacing--20)">
					<!-- wp:heading {"level":3,"fontSize":"x-small","fontFamily":"mono","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em","fontWeight":"500"}}} -->
					<h3 class="wp-block-heading has-x-small-font-size has-mono-font-family" style="font-weight:500;letter-spacing:0.08em;text-transform:uppercase"><?php esc_html_e( 'Languages', 'celestine' ); ?></h3>
					<!-- /wp:heading -->

					<!-- wp:list {"className":"is-style-celestine-mono"} -->
					<ul class="wp-block-list is-style-celestine-mono">
						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Go', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Rust', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'TypeScript', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Python', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'SQL', 'celestine' ); ?></li>
						<!-- /wp:list-item -->
					</ul>
					<!-- /wp:list -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column">
				<!-- wp:group {"style":{"border":{"top":{"color":"var:preset|color|ink","width":"2px"}},"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--ink);border-top-width:2px;padding-top:var(--wp--preset--spacing--20)">
					<!-- wp:heading {"level":3,"fontSize":"x-small","fontFamily":"mono","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em","fontWeight":"500"}}} -->
					<h3 class="wp-block-heading has-x-small-font-size has-mono-font-family" style="font-weight:500;letter-spacing:0.08em;text-transform:uppercase"><?php esc_html_e( 'Data & runtime', 'celestine' ); ?></h3>
					<!-- /wp:heading -->

					<!-- wp:list {"className":"is-style-celestine-mono"} -->
					<ul class="wp-block-list is-style-celestine-mono">
						<!-- wp:list-item -->
						<li><?php esc_html_e( 'PostgreSQL', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Redis', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Kafka', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'ClickHouse', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Node.js', 'celestine' ); ?></li>
						<!-- /wp:list-item -->
					</ul>
					<!-- /wp:list -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column">
				<!-- wp:group {"style":{"border":{"top":{"color":"var:preset|color|ink","width":"2px"}},"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--ink);border-top-width:2px;padding-top:var(--wp--preset--spacing--20)">
					<!-- wp:heading {"level":3,"fontSize":"x-small","fontFamily":"mono","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em","fontWeight":"500"}}} -->
					<h3 class="wp-block-heading has-x-small-font-size has-mono-font-family" style="font-weight:500;letter-spacing:0.08em;text-transform:uppercase"><?php esc_html_e( 'Infrastructure', 'celestine' ); ?></h3>
					<!-- /wp:heading -->

					<!-- wp:list {"className":"is-style-celestine-mono"} -->
					<ul class="wp-block-list is-style-celestine-mono">
						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Kubernetes', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Terraform', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'AWS', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'OpenTelemetry', 'celestine' ); ?></li>
						<!-- /wp:list-item -->

						<!-- wp:list-item -->
						<li><?php esc_html_e( 'Prometheus', 'celestine' ); ?></li>
						<!-- /wp:list-item -->
					</ul>
					<!-- /wp:list -->
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
