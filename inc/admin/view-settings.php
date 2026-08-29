<?php
/**
 * The Site identity, Profile, Contact and Social media tabs.
 *
 * Four forms, kept apart on purpose, because they write to two different
 * places and the difference matters when someone changes theme:
 *
 * - Site identity writes WordPress's own settings -- site icon, logo, title,
 *   tagline, front page. Those belong to the site, not to Batavia, and they
 *   stay behind when the theme is switched. Theme review allows a theme to edit
 *   them provided the user is told what is being changed, which is what the
 *   notice above that form is for.
 * - Profile, Contact and Social media each write their own slice of
 *   Batavia's single option: the details the patterns read. Switch theme
 *   and these are left dormant, not lost, and switching back brings them
 *   straight back. Splitting the one option into three forms and three
 *   `_scope`s (see batavia_sanitize_settings()) means saving one never
 *   touches what the other two hold.
 *
 * @package Batavia
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'batavia_handle_site_identity' ) ) {
	/**
	 * Saves the WordPress settings half of the page.
	 *
	 * The theme's own option goes through options.php and the Settings API. The
	 * core options cannot: they belong to other settings groups, so they are
	 * written here, behind a capability check and a nonce, only ever in response
	 * to this form being submitted.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	function batavia_handle_site_identity() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to change these settings.', 'batavia' ) );
		}

		check_admin_referer( 'batavia_site_identity' );

		if ( isset( $_POST['blogname'] ) ) {
			update_option( 'blogname', sanitize_text_field( wp_unslash( $_POST['blogname'] ) ) );
		}

		if ( isset( $_POST['blogdescription'] ) ) {
			update_option( 'blogdescription', sanitize_text_field( wp_unslash( $_POST['blogdescription'] ) ) );
		}

		$icon = isset( $_POST['site_icon'] ) ? absint( wp_unslash( $_POST['site_icon'] ) ) : 0;

		if ( $icon > 0 && wp_attachment_is_image( $icon ) ) {
			update_option( 'site_icon', $icon );
		} else {
			delete_option( 'site_icon' );
		}

		$logo = isset( $_POST['custom_logo'] ) ? absint( wp_unslash( $_POST['custom_logo'] ) ) : 0;

		if ( $logo > 0 && wp_attachment_is_image( $logo ) ) {
			set_theme_mod( 'custom_logo', $logo );
		} else {
			remove_theme_mod( 'custom_logo' );
		}

		$show_on_front = isset( $_POST['show_on_front'] ) ? sanitize_key( wp_unslash( $_POST['show_on_front'] ) ) : 'posts';
		$page_on_front = isset( $_POST['page_on_front'] ) ? absint( wp_unslash( $_POST['page_on_front'] ) ) : 0;
		$page_for_post = isset( $_POST['page_for_posts'] ) ? absint( wp_unslash( $_POST['page_for_posts'] ) ) : 0;

		/*
		 * "A static page" with no page chosen leaves a site with a blank front
		 * page, so that combination is treated as the posts setting instead.
		 */
		if ( 'page' === $show_on_front && $page_on_front > 0 && 'page' === get_post_type( $page_on_front ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $page_on_front );
			update_option(
				'page_for_posts',
				$page_for_post > 0 && 'page' === get_post_type( $page_for_post ) ? $page_for_post : 0
			);
		} else {
			update_option( 'show_on_front', 'posts' );
		}

		wp_safe_redirect(
			add_query_arg( 'batavia-updated', 'identity', batavia_admin_page_url( 'settings' ) )
		);
		exit;
	}
}
add_action( 'admin_post_batavia_site_identity', 'batavia_handle_site_identity' );

if ( ! function_exists( 'batavia_render_media_field' ) ) {
	/**
	 * Renders a media picker: a preview, a hidden id, and two buttons.
	 *
	 * @since 1.2.0
	 *
	 * @param string $name          Field name, which is also the input's id.
	 * @param int    $attachment_id Currently selected attachment.
	 * @param string $title         Title for the media modal.
	 * @return void
	 */
	function batavia_render_media_field( $name, $attachment_id, $title ) {
		$url = $attachment_id > 0 ? wp_get_attachment_image_url( $attachment_id, 'thumbnail' ) : '';
		?>
		<div class="batavia-media" data-batavia-media data-title="<?php echo esc_attr( $title ); ?>">
			<div class="batavia-media__preview">
				<?php if ( $url ) : ?>
					<img src="<?php echo esc_url( $url ); ?>" alt="" />
				<?php endif; ?>
			</div>

			<input
				type="hidden"
				name="<?php echo esc_attr( $name ); ?>"
				id="<?php echo esc_attr( $name ); ?>"
				value="<?php echo esc_attr( (string) $attachment_id ); ?>"
			/>

			<button type="button" class="button button-secondary" data-batavia-media-choose>
				<?php echo $attachment_id > 0 ? esc_html__( 'Replace', 'batavia' ) : esc_html__( 'Choose image', 'batavia' ); ?>
			</button>

			<button
				type="button"
				class="button-link batavia-media__remove"
				data-batavia-media-remove
				<?php echo $attachment_id > 0 ? '' : 'hidden'; ?>
			>
				<?php esc_html_e( 'Remove', 'batavia' ); ?>
			</button>
		</div>
		<?php
	}
}

if ( ! function_exists( 'batavia_render_identity_form' ) ) {
	/**
	 * Renders the WordPress settings form.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	function batavia_render_identity_form() {
		if ( ! current_user_can( 'manage_options' ) ) {
			?>
			<div class="notice notice-info inline">
				<p>
					<?php esc_html_e( 'The site icon, logo, title and front page are WordPress settings, and your account cannot change them. Ask an administrator, or edit the theme details below.', 'batavia' ); ?>
				</p>
			</div>
			<?php
			return;
		}

		$show_on_front = get_option( 'show_on_front', 'posts' );
		?>
		<h2 class="batavia-admin__heading"><?php esc_html_e( 'Site identity', 'batavia' ); ?></h2>

		<div class="notice notice-info inline batavia-admin__consent">
			<p>
				<strong><?php esc_html_e( 'These are WordPress settings, not Batavia settings.', 'batavia' ); ?></strong>
				<?php esc_html_e( 'They are the same values found under Settings, they are shared with every theme, and they stay as you leave them if you switch away from Batavia. They are repeated here so that setting up a new site does not mean visiting four screens.', 'batavia' ); ?>
			</p>
		</div>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="batavia_site_identity" />
			<?php wp_nonce_field( 'batavia_site_identity' ); ?>

			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row">
							<label for="blogname"><?php esc_html_e( 'Site title', 'batavia' ); ?></label>
						</th>
						<td>
							<input
								name="blogname"
								id="blogname"
								type="text"
								class="regular-text"
								value="<?php echo esc_attr( get_option( 'blogname' ) ); ?>"
							/>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="blogdescription"><?php esc_html_e( 'Tagline', 'batavia' ); ?></label>
						</th>
						<td>
							<input
								name="blogdescription"
								id="blogdescription"
								type="text"
								class="regular-text"
								value="<?php echo esc_attr( get_option( 'blogdescription' ) ); ?>"
							/>
							<p class="description">
								<?php esc_html_e( 'Shown under the site title in the footer.', 'batavia' ); ?>
							</p>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="site_icon"><?php esc_html_e( 'Site icon', 'batavia' ); ?></label>
						</th>
						<td>
							<?php
							batavia_render_media_field(
								'site_icon',
								(int) get_option( 'site_icon', 0 ),
								__( 'Choose a site icon', 'batavia' )
							);
							?>
							<p class="description">
								<?php esc_html_e( 'The favicon: the small image shown in a browser tab and when the site is saved to a home screen. Use a square image of at least 512 by 512 pixels.', 'batavia' ); ?>
							</p>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="custom_logo"><?php esc_html_e( 'Logo', 'batavia' ); ?></label>
						</th>
						<td>
							<?php
							batavia_render_media_field(
								'custom_logo',
								(int) get_theme_mod( 'custom_logo', 0 ),
								__( 'Choose a logo', 'batavia' )
							);
							?>
							<p class="description">
								<?php esc_html_e( 'Appears wherever the header uses a Site Logo block. Batavia sets a logo in type by default, so leaving this empty is a perfectly good choice.', 'batavia' ); ?>
							</p>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php esc_html_e( 'Front page', 'batavia' ); ?></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text">
									<?php esc_html_e( 'What the front page shows', 'batavia' ); ?>
								</legend>

								<label>
									<input
										type="radio"
										name="show_on_front"
										value="posts"
										<?php checked( 'posts', $show_on_front ); ?>
									/>
									<?php esc_html_e( 'Your latest posts', 'batavia' ); ?>
								</label>
								<br />
								<label>
									<input
										type="radio"
										name="show_on_front"
										value="page"
										<?php checked( 'page', $show_on_front ); ?>
									/>
									<?php esc_html_e( 'A static page', 'batavia' ); ?>
								</label>
							</fieldset>

							<p class="batavia-admin__field">
								<label for="page_on_front"><?php esc_html_e( 'Homepage', 'batavia' ); ?></label>
								<?php
								wp_dropdown_pages(
									array(
										'name'             => 'page_on_front',
										'id'               => 'page_on_front',
										'selected'         => (int) get_option( 'page_on_front', 0 ),
										'show_option_none' => esc_html__( '— Select —', 'batavia' ),
										'option_none_value' => '0',
									)
								);
								?>
							</p>

							<p class="batavia-admin__field">
								<label for="page_for_posts"><?php esc_html_e( 'Posts page', 'batavia' ); ?></label>
								<?php
								wp_dropdown_pages(
									array(
										'name'             => 'page_for_posts',
										'id'               => 'page_for_posts',
										'selected'         => (int) get_option( 'page_for_posts', 0 ),
										'show_option_none' => esc_html__( '— Select —', 'batavia' ),
										'option_none_value' => '0',
									)
								);
								?>
							</p>

							<p class="description">
								<?php esc_html_e( 'Batavia has a front page template, so a static homepage is what the design expects. Choosing your latest posts instead is fine -- the blog index template takes over.', 'batavia' ); ?>
							</p>
						</td>
					</tr>
				</tbody>
			</table>

			<?php
			/*
			 * Both forms live on one screen, and submit_button() derives the id
			 * from the name, so each button is named -- two id="submit"
			 * attributes on a page is invalid markup and confuses anything that
			 * looks a button up by id.
			 */
			submit_button( __( 'Save WordPress settings', 'batavia' ), 'primary', 'batavia_save_identity' );
			?>
		</form>
		<?php
	}
}

if ( ! function_exists( 'batavia_render_field_input' ) ) {
	/**
	 * Renders one field's input control, dispatched by type.
	 *
	 * Shared by the Settings tab and the Homepage tab, and by repeater rows,
	 * so a field type is only ever taught how to render itself once.
	 *
	 * @since 1.4.0
	 *
	 * @param string               $name  The `name` attribute to submit under.
	 * @param string               $id    The `id` attribute.
	 * @param array<string, mixed> $field Field definition.
	 * @param string               $value Current value, ignored for checkboxes.
	 * @return void
	 */
	function batavia_render_field_input( $name, $id, $field, $value ) {
		switch ( $field['type'] ) {
			case 'checkbox':
				?>
				<input type="hidden" name="<?php echo esc_attr( $name ); ?>" value="0" />
				<label>
					<input
						type="checkbox"
						id="<?php echo esc_attr( $id ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						value="1"
						<?php checked( '1', $value ); ?>
					/>
					<?php echo esc_html( $field['label'] ); ?>
				</label>
				<?php
				break;

			case 'textarea':
				?>
				<textarea
					id="<?php echo esc_attr( $id ); ?>"
					name="<?php echo esc_attr( $name ); ?>"
					class="large-text"
					rows="3"
					<?php if ( ! empty( $field['placeholder'] ) ) : ?>
						placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"
					<?php endif; ?>
				><?php echo esc_textarea( $value ); ?></textarea>
				<?php
				break;

			case 'category':
				wp_dropdown_categories(
					array(
						'id'                => $id,
						'name'              => $name,
						'selected'          => (int) $value,
						'show_option_none'  => __( '— Not set —', 'batavia' ),
						'option_none_value' => '',
						'hide_empty'        => false,
						'hierarchical'      => true,
					)
				);
				break;

			case 'radio':
				?>
				<fieldset>
					<legend class="screen-reader-text"><?php echo esc_html( $field['label'] ); ?></legend>
					<?php foreach ( $field['options'] as $option_value => $option_label ) : ?>
						<label class="batavia-admin__radio-option">
							<input
								type="radio"
								name="<?php echo esc_attr( $name ); ?>"
								value="<?php echo esc_attr( $option_value ); ?>"
								<?php checked( $option_value, $value ); ?>
							/>
							<?php echo esc_html( $option_label ); ?>
						</label>
					<?php endforeach; ?>
				</fieldset>
				<?php
				break;

			default:
				?>
				<input
					type="<?php echo esc_attr( 'text' === $field['type'] ? 'text' : $field['type'] ); ?>"
					id="<?php echo esc_attr( $id ); ?>"
					name="<?php echo esc_attr( $name ); ?>"
					value="<?php echo esc_attr( $value ); ?>"
					class="regular-text"
					<?php if ( ! empty( $field['placeholder'] ) ) : ?>
						placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"
					<?php endif; ?>
				/>
				<?php
				break;
		}
	}
}

if ( ! function_exists( 'batavia_render_field_row' ) ) {
	/**
	 * Renders one non-repeater field as a form-table row.
	 *
	 * A checkbox carries its own label inside the input, so it skips the
	 * `<th>` column that every other type uses.
	 *
	 * @since 1.4.0
	 *
	 * @param string               $key   Field key.
	 * @param array<string, mixed> $field Field definition.
	 * @param string               $value Current value.
	 * @return void
	 */
	function batavia_render_field_row( $key, $field, $value ) {
		$id   = 'batavia-' . $key;
		$name = BATAVIA_SETTINGS_OPTION . '[' . $key . ']';
		?>
		<tr>
			<?php if ( 'checkbox' !== $field['type'] ) : ?>
				<th scope="row">
					<?php if ( 'radio' === $field['type'] ) : ?>
						<?php echo esc_html( $field['label'] ); ?>
					<?php else : ?>
						<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $field['label'] ); ?></label>
					<?php endif; ?>
				</th>
			<?php endif; ?>
			<td <?php echo 'checkbox' === $field['type'] ? 'colspan="2"' : ''; ?>>
				<?php batavia_render_field_input( $name, $id, $field, $value ); ?>
				<?php if ( ! empty( $field['help'] ) ) : ?>
					<p class="description"><?php echo esc_html( $field['help'] ); ?></p>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	}
}

if ( ! function_exists( 'batavia_render_repeater_row' ) ) {
	/**
	 * Renders one row of a repeater field.
	 *
	 * Used both for the rows already stored and for the blank `<template>`
	 * row the admin JS clones when "Add" is clicked -- `$index` is the string
	 * `__INDEX__` in that case, replaced client-side with a fresh number
	 * before the clone is inserted.
	 *
	 * @since 1.4.0
	 *
	 * @param string                              $key    Repeater field key.
	 * @param string                              $index  Row index, or `__INDEX__` for the template row.
	 * @param array<string, array<string, mixed>> $fields Sub-field definitions.
	 * @param array<string, string>               $row    Stored values for this row.
	 * @param string                              $label  Singular row label, e.g. "Role".
	 * @param int                                 $number Row number shown to the user.
	 * @return void
	 */
	function batavia_render_repeater_row( $key, $index, $fields, $row, $label, $number ) {
		?>
		<fieldset class="batavia-repeater__row">
			<div class="batavia-repeater__row-header">
				<span class="batavia-repeater__row-handle" data-batavia-repeater-handle>
					<span class="dashicons dashicons-move" aria-hidden="true"></span>
					<span class="screen-reader-text"><?php esc_html_e( 'Drag to reorder', 'batavia' ); ?></span>
				</span>

				<span class="batavia-repeater__row-number">
					<?php
					printf(
						/* translators: 1: Row label, e.g. "Role". 2: Row number. */
						esc_html__( '%1$s %2$d', 'batavia' ),
						esc_html( $label ),
						(int) $number
					);
					?>
				</span>

				<span class="batavia-repeater__row-actions">
					<button type="button" class="batavia-repeater__icon-button" data-batavia-repeater-up>
						<span class="dashicons dashicons-arrow-up-alt2" aria-hidden="true"></span>
						<span class="screen-reader-text"><?php esc_html_e( 'Move up', 'batavia' ); ?></span>
					</button>
					<button type="button" class="batavia-repeater__icon-button" data-batavia-repeater-down>
						<span class="dashicons dashicons-arrow-down-alt2" aria-hidden="true"></span>
						<span class="screen-reader-text"><?php esc_html_e( 'Move down', 'batavia' ); ?></span>
					</button>
					<button type="button" class="batavia-repeater__icon-button batavia-repeater__remove" data-batavia-repeater-remove>
						<span class="dashicons dashicons-trash" aria-hidden="true"></span>
						<span class="screen-reader-text"><?php esc_html_e( 'Remove', 'batavia' ); ?></span>
					</button>
				</span>
			</div>

			<div class="batavia-repeater__row-fields">
				<?php foreach ( $fields as $sub_key => $sub_field ) : ?>
					<p class="batavia-repeater__field">
						<label for="batavia-<?php echo esc_attr( $key . '-' . $index . '-' . $sub_key ); ?>">
							<?php echo esc_html( $sub_field['label'] ); ?>
						</label>
						<?php
						batavia_render_field_input(
							BATAVIA_SETTINGS_OPTION . '[' . $key . '][' . $index . '][' . $sub_key . ']',
							'batavia-' . $key . '-' . $index . '-' . $sub_key,
							$sub_field,
							isset( $row[ $sub_key ] ) ? $row[ $sub_key ] : ''
						);
						?>
					</p>
				<?php endforeach; ?>
			</div>
		</fieldset>
		<?php
	}
}

if ( ! function_exists( 'batavia_render_repeater_field' ) ) {
	/**
	 * Renders a repeater field: its stored rows, an "Add" button, and the
	 * blank `<template>` row the admin JS clones.
	 *
	 * @since 1.4.0
	 *
	 * @param string               $key   Repeater field key.
	 * @param array<string, mixed> $field Field definition.
	 * @return void
	 */
	function batavia_render_repeater_field( $key, $field ) {
		$rows = batavia_get_repeater_rows( $key );
		?>
		<h4 class="batavia-admin__repeater-heading"><?php echo esc_html( $field['label'] ); ?></h4>

		<div class="batavia-repeater" data-batavia-repeater data-repeater-label="<?php echo esc_attr( $field['row_label'] ); ?>">
			<div class="batavia-repeater__rows" data-batavia-repeater-rows>
				<?php if ( empty( $rows ) ) : ?>
					<?php batavia_render_repeater_row( $key, 0, $field['fields'], array(), $field['row_label'], 1 ); ?>
				<?php else : ?>
					<?php foreach ( array_values( $rows ) as $i => $row ) : ?>
						<?php batavia_render_repeater_row( $key, $i, $field['fields'], $row, $field['row_label'], $i + 1 ); ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<template data-batavia-repeater-template>
				<?php batavia_render_repeater_row( $key, '__INDEX__', $field['fields'], array(), $field['row_label'], 0 ); ?>
			</template>

			<button type="button" class="button" data-batavia-repeater-add>
				<?php
				printf(
					/* translators: %s: Row label, e.g. "Role". */
					esc_html__( 'Add %s', 'batavia' ),
					esc_html( $field['row_label'] )
				);
				?>
			</button>
		</div>
		<?php
	}
}

if ( ! function_exists( 'batavia_render_settings_groups' ) ) {
	/**
	 * Renders every group's fields for a form.
	 *
	 * @since 1.4.0
	 *
	 * @param array<int, string> $group_keys Schema group keys to render.
	 * @return void
	 */
	function batavia_render_settings_groups( $group_keys ) {
		$schema = batavia_settings_schema();

		foreach ( $group_keys as $group_key ) {
			if ( ! isset( $schema[ $group_key ] ) ) {
				continue;
			}

			$group = $schema[ $group_key ];
			?>
			<h3 class="batavia-admin__subheading"><?php echo esc_html( $group['label'] ); ?></h3>
			<?php if ( ! empty( $group['description'] ) ) : ?>
				<p class="batavia-admin__note"><?php echo esc_html( $group['description'] ); ?></p>
			<?php endif; ?>
			<?php
			batavia_render_group_fields( $group_key, $group );
		}
	}
}

if ( ! function_exists( 'batavia_render_group_fields' ) ) {
	/**
	 * Renders one schema group's fields: a table for plain fields, then any
	 * repeaters, then the social group's extra note.
	 *
	 * Shared by the multi-group Homepage tab and the single-group Profile,
	 * Contact and Social media tabs, so a group's fields are only ever taught
	 * how to render themselves once.
	 *
	 * @since 1.4.0
	 *
	 * @param string               $group_key Schema group key.
	 * @param array<string, mixed> $group     Group definition.
	 * @return void
	 */
	function batavia_render_group_fields( $group_key, $group ) {
		$settings        = batavia_get_settings();
		$table_fields    = array();
		$repeater_fields = array();

		foreach ( $group['fields'] as $key => $field ) {
			if ( 'repeater' === $field['type'] ) {
				$repeater_fields[ $key ] = $field;
			} else {
				$table_fields[ $key ] = $field;
			}
		}

		if ( ! empty( $table_fields ) ) :
			?>
			<table class="form-table batavia-admin__table" role="presentation">
				<tbody>
					<?php foreach ( $table_fields as $key => $field ) : ?>
						<?php
						if ( 'checkbox' === $field['type'] ) {
							$value = batavia_get_setting_bool( $key ) ? '1' : '0';
						} elseif ( 'radio' === $field['type'] && ! empty( $field['infer_from'] ) ) {
							$value = batavia_get_category_scope( $key, $field['infer_from'] );
						} else {
							$value = isset( $settings[ $key ] ) ? $settings[ $key ] : '';
						}
						batavia_render_field_row( $key, $field, $value );
						?>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php
		endif;

		foreach ( $repeater_fields as $key => $field ) {
			batavia_render_repeater_field( $key, $field );
		}

		if ( 'social' === $group_key ) :
			?>
			<p class="batavia-admin__note">
				<?php esc_html_e( 'Need a service that is not listed? Add a Social Icon block for it in the Site Editor and type the address there. This screen only fills in icons that have been left empty.', 'batavia' ); ?>
			</p>
			<?php
		endif;
	}
}

if ( ! function_exists( 'batavia_render_settings_group_tab' ) ) {
	/**
	 * Renders a tab for exactly one schema group: Profile, Contact or Social
	 * media. Each is its own form and its own `_scope`, so saving one never
	 * touches the values the other two hold.
	 *
	 * @since 1.4.0
	 *
	 * @param string $group_key    Schema group key.
	 * @param string $submit_label Label for the submit button.
	 * @return void
	 */
	function batavia_render_settings_group_tab( $group_key, $submit_label ) {
		$schema = batavia_settings_schema();
		$group  = isset( $schema[ $group_key ] ) ? $schema[ $group_key ] : array();

		batavia_render_settings_notices();
		?>
		<h2 class="batavia-admin__heading"><?php echo esc_html( $group['label'] ); ?></h2>

		<p class="batavia-admin__note">
			<?php esc_html_e( 'Everything below is optional. A field left empty keeps whatever the pattern already says, so nothing here can break a page -- and a pattern used in ten posts reads the same value in all ten.', 'batavia' ); ?>
		</p>

		<p class="batavia-admin__note"><?php echo esc_html( $group['description'] ); ?></p>

		<form method="post" action="<?php echo esc_url( admin_url( 'options.php' ) ); ?>">
			<?php settings_fields( 'batavia_settings_group' ); ?>
			<input type="hidden" name="<?php echo esc_attr( BATAVIA_SETTINGS_OPTION ); ?>[_scope]" value="<?php echo esc_attr( $group_key ); ?>" />

			<?php batavia_render_group_fields( $group_key, $group ); ?>

			<?php submit_button( $submit_label, 'primary', 'batavia_save_' . $group_key ); ?>
		</form>
		<?php
	}
}

if ( ! function_exists( 'batavia_render_settings_notices' ) ) {
	/**
	 * Confirms a save.
	 *
	 * The redirect from options.php carries `settings-updated`, and the
	 * WordPress settings form carries a flag of its own, so a save of one is
	 * never reported as a save of the other.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	function batavia_render_settings_notices() {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Reading a redirect flag in order to print a confirmation, with no side effects.
		$theme_saved    = isset( $_GET['settings-updated'] );
		$identity_saved = isset( $_GET['batavia-updated'] )
			&& 'identity' === sanitize_key( wp_unslash( $_GET['batavia-updated'] ) );
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		if ( ! $theme_saved && ! $identity_saved ) {
			return;
		}
		?>
		<div class="notice notice-success is-dismissible">
			<p>
				<?php
				if ( $identity_saved ) {
					esc_html_e( 'WordPress settings saved.', 'batavia' );
				} else {
					esc_html_e( 'Theme details saved.', 'batavia' );
				}
				?>
			</p>
		</div>
		<?php
	}
}

if ( ! function_exists( 'batavia_render_identity_tab' ) ) {
	/**
	 * Renders the Site identity tab.
	 *
	 * @since 1.4.0
	 *
	 * @return void
	 */
	function batavia_render_identity_tab() {
		batavia_render_settings_notices();
		batavia_render_identity_form();
	}
}
