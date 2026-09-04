<?php
/**
 * Batavia's settings, in the Customizer.
 *
 * The theme keeps a short list of details -- who the site is about, how to
 * reach you, which social profiles you keep, and what the front page shows --
 * that the bundled patterns read through the Block Bindings API. The theme
 * directory requires a theme's own options to live in the Customizer, so that
 * is where they are: one "Batavia" panel, one section per group in
 * batavia_settings_schema(), and one control per field.
 *
 * Core hides the Customizer on a block theme unless a theme or plugin hooks
 * `customize_register` (wp-admin/menu.php). Registering here is therefore also
 * what puts Appearance > Customize back on the menu.
 *
 * Storage is exactly the shape the rest of the theme already expects: every
 * control writes into the single `batavia_settings` option, scalars at
 * `batavia_settings[key]` and repeater rows at
 * `batavia_settings[key][index][sub_key]` -- multidimensional option settings
 * the Customizer supports natively, so no accessor downstream had to change.
 *
 * @package Batavia
 * @since   1.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'batavia_customize_field_for_setting' ) ) {
	/**
	 * The schema field a Customizer setting id refers to.
	 *
	 * Setting ids carry their own address: `batavia_settings[email]` is a
	 * scalar field, `batavia_settings[experience][0][mark]` is one sub-field
	 * of one repeater row. Reading the field back out of the id is what lets
	 * a single sanitise callback serve every control on the panel.
	 *
	 * @since 1.6.0
	 *
	 * @param string $setting_id Customizer setting id.
	 * @return array<string, mixed>|null The field definition, or null if the id is not one of ours.
	 */
	function batavia_customize_field_for_setting( $setting_id ) {
		if ( ! preg_match_all( '/\[([^\]]+)\]/', (string) $setting_id, $matches ) ) {
			return null;
		}

		$keys   = $matches[1];
		$fields = batavia_settings_fields();

		if ( 1 === count( $keys ) ) {
			return isset( $fields[ $keys[0] ] ) ? $fields[ $keys[0] ] : null;
		}

		if ( 3 === count( $keys ) && isset( $fields[ $keys[0] ]['fields'][ $keys[2] ] ) ) {
			return $fields[ $keys[0] ]['fields'][ $keys[2] ];
		}

		return null;
	}
}

if ( ! function_exists( 'batavia_sanitize_field_value' ) ) {
	/**
	 * Sanitises one value according to its field's type.
	 *
	 * An empty string is stored rather than rejected: emptying a field is how
	 * a user says "go back to whatever the pattern says", so it has to be a
	 * value the binding source can see.
	 *
	 * @since 1.6.0
	 *
	 * @param mixed                $value Raw submitted value.
	 * @param array<string, mixed> $field Field definition.
	 * @return mixed Sanitised value.
	 */
	function batavia_sanitize_field_value( $value, $field ) {
		$type = isset( $field['type'] ) ? $field['type'] : 'text';

		if ( 'checkbox' === $type ) {
			return (bool) $value;
		}

		if ( 'media' === $type ) {
			return absint( $value );
		}

		if ( ! is_scalar( $value ) ) {
			return '';
		}

		$raw = trim( (string) $value );

		if ( '' === $raw ) {
			return '';
		}

		switch ( $type ) {
			case 'email':
				return sanitize_email( $raw );

			case 'url':
				return esc_url_raw( $raw );

			case 'tel':
				/*
				 * Kept as typed, minus anything that cannot belong to a phone
				 * number, so the control shows the spaced form a person
				 * recognises. The digits-only form the wa.me link needs is
				 * derived when the link is built.
				 */
				return trim( (string) preg_replace( '/[^0-9+()\-. ]/', '', $raw ) );

			case 'textarea':
				return sanitize_textarea_field( $raw );

			case 'category':
				$term_id = absint( $raw );

				return ( $term_id > 0 && term_exists( $term_id, 'category' ) ) ? (string) $term_id : '';

			case 'radio':
				return isset( $field['options'][ $raw ] ) ? $raw : '';

			case 'tags':
				$items = array_filter( array_map( 'trim', explode( ',', $raw ) ) );

				return implode( ', ', array_map( 'sanitize_text_field', $items ) );

			default:
				return sanitize_text_field( $raw );
		}
	}
}

if ( ! function_exists( 'batavia_sanitize_setting_value' ) ) {
	/**
	 * The sanitise callback every control on the panel shares.
	 *
	 * A setting whose id the schema does not describe sanitises to an empty
	 * string, so nothing outside the schema can be written through it.
	 *
	 * @since 1.6.0
	 *
	 * @param mixed                $value   Raw submitted value.
	 * @param WP_Customize_Setting $setting The setting being saved.
	 * @return mixed Sanitised value.
	 */
	function batavia_sanitize_setting_value( $value, $setting ) {
		$field = batavia_customize_field_for_setting( $setting->id );

		return null === $field ? '' : batavia_sanitize_field_value( $value, $field );
	}
}

if ( ! function_exists( 'batavia_customize_category_choices' ) ) {
	/**
	 * The site's categories, as choices for a select control.
	 *
	 * @since 1.6.0
	 *
	 * @return array<string, string> Term id mapped to name, prefixed by an empty choice.
	 */
	function batavia_customize_category_choices() {
		$choices = array( '' => __( '— None —', 'batavia' ) );

		$categories = get_categories(
			array(
				'hide_empty' => false,
				'number'     => 200,
			)
		);

		foreach ( $categories as $category ) {
			$choices[ (string) $category->term_id ] = $category->name;
		}

		return $choices;
	}
}

if ( ! function_exists( 'batavia_customize_add_field' ) ) {
	/**
	 * Registers one setting and the control that edits it.
	 *
	 * Everything refreshes rather than posting a message: the values reach the
	 * page through block bindings and server-side render filters, so there is
	 * no markup a preview script could usefully rewrite in place.
	 *
	 * @since 1.6.0
	 *
	 * @param WP_Customize_Manager $wp_customize The manager.
	 * @param string               $section      Section the control belongs to.
	 * @param string               $setting_id   Setting id, including its option brackets.
	 * @param array<string, mixed> $field        Field definition.
	 * @param string               $label        Control label.
	 * @return void
	 */
	function batavia_customize_add_field( $wp_customize, $section, $setting_id, $field, $label ) {
		$type = isset( $field['type'] ) ? $field['type'] : 'text';

		$wp_customize->add_setting(
			$setting_id,
			array(
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => 'checkbox' === $type ? true : '',
				'sanitize_callback' => 'batavia_sanitize_setting_value',
			)
		);

		$description = isset( $field['help'] ) ? $field['help'] : '';

		if ( 'media' === $type ) {
			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					$setting_id,
					array(
						'label'       => $label,
						'description' => $description,
						'section'     => $section,
						'mime_type'   => 'image',
					)
				)
			);

			return;
		}

		$args = array(
			'label'       => $label,
			'description' => $description,
			'section'     => $section,
			'settings'    => $setting_id,
			'type'        => 'text',
		);

		switch ( $type ) {
			case 'checkbox':
			case 'textarea':
			case 'email':
			case 'url':
			case 'tel':
				$args['type'] = $type;
				break;

			case 'radio':
				$args['type']    = 'radio';
				$args['choices'] = $field['options'];
				break;

			case 'category':
				$args['type']    = 'select';
				$args['choices'] = batavia_customize_category_choices();
				break;
		}

		if ( ! empty( $field['placeholder'] ) && in_array( $args['type'], array( 'text', 'email', 'url', 'tel', 'textarea' ), true ) ) {
			$args['input_attrs'] = array( 'placeholder' => $field['placeholder'] );
		}

		$wp_customize->add_control( $setting_id, $args );
	}
}

if ( ! function_exists( 'batavia_customize_add_repeater' ) ) {
	/**
	 * Registers a repeater as a fixed number of slots.
	 *
	 * The Customizer has no repeating control, so each row is laid out as an
	 * ordinary group of controls under a numbered label. A slot left entirely
	 * empty is dropped when the rows are read, not when they are stored, so
	 * filling in slot three without slot two never renumbers the two on
	 * screen while the front end still shows one row rather than two.
	 *
	 * @since 1.6.0
	 *
	 * @param WP_Customize_Manager $wp_customize The manager.
	 * @param string               $section      Section the controls belong to.
	 * @param string               $key          Repeater field key.
	 * @param array<string, mixed> $field        Repeater field definition.
	 * @return void
	 */
	function batavia_customize_add_repeater( $wp_customize, $section, $key, $field ) {
		$slots = isset( $field['max'] ) ? (int) $field['max'] : 1;

		for ( $index = 0; $index < $slots; $index++ ) {
			foreach ( $field['fields'] as $sub_key => $sub_field ) {
				batavia_customize_add_field(
					$wp_customize,
					$section,
					sprintf( '%s[%s][%d][%s]', BATAVIA_SETTINGS_OPTION, $key, $index, $sub_key ),
					$sub_field,
					sprintf(
						/* translators: 1: row label, for example "Role". 2: row number. 3: field label, for example "Company". */
						__( '%1$s %2$d — %3$s', 'batavia' ),
						$field['row_label'],
						$index + 1,
						$sub_field['label']
					)
				);
			}
		}
	}
}

if ( ! function_exists( 'batavia_customize_register' ) ) {
	/**
	 * Builds the panel: one section per schema group, in schema order.
	 *
	 * Site title, tagline, logo, site icon and the front page are core's own
	 * settings and already have Customizer sections of their own, so nothing
	 * here repeats them.
	 *
	 * @since 1.6.0
	 *
	 * @param WP_Customize_Manager $wp_customize The manager.
	 * @return void
	 */
	function batavia_customize_register( $wp_customize ) {
		$wp_customize->add_panel(
			'batavia',
			array(
				'title'       => __( 'Batavia', 'batavia' ),
				'description' => __( 'The details the bundled patterns read, entered once. Every field is optional: an empty field leaves the pattern\'s own text in place.', 'batavia' ),
				'priority'    => 130,
			)
		);

		$priority = 10;

		foreach ( batavia_settings_schema() as $group_key => $group ) {
			$section_id = 'batavia_' . $group_key;

			$wp_customize->add_section(
				$section_id,
				array(
					'title'       => $group['label'],
					'description' => $group['description'],
					'panel'       => 'batavia',
					'priority'    => $priority,
				)
			);

			$priority += 10;

			foreach ( $group['fields'] as $key => $field ) {
				if ( 'repeater' === $field['type'] ) {
					batavia_customize_add_repeater( $wp_customize, $section_id, $key, $field );
					continue;
				}

				batavia_customize_add_field(
					$wp_customize,
					$section_id,
					sprintf( '%s[%s]', BATAVIA_SETTINGS_OPTION, $key ),
					$field,
					$field['label']
				);
			}
		}
	}
}
add_action( 'customize_register', 'batavia_customize_register' );
