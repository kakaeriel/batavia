<?php
/**
 * Batavia's own settings: one option, the fields inside it, the accessors.
 *
 * Theme review allows a theme to keep settings of its own on one condition --
 * exactly one database option, prefixed with the theme slug, stored as an array,
 * written through the Settings API and sanitised on the way in. That option is
 * `batavia_settings`, and this file is the only place that knows its shape.
 *
 * One schema drives three things: the fields on the settings screen, the
 * sanitisation callback, and the keys the block binding source will resolve.
 * Adding a field here makes it appear in all three.
 *
 * Nothing here is required for the theme to render. Every field is optional and
 * an empty field falls back to the text written into the pattern, so a fresh
 * install looks finished before anyone opens this screen.
 *
 * @package Batavia
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'BATAVIA_SETTINGS_OPTION' ) ) {
	define( 'BATAVIA_SETTINGS_OPTION', 'batavia_settings' );
}

if ( ! defined( 'BATAVIA_REPEATER_MAX_ROWS' ) ) {
	define( 'BATAVIA_REPEATER_MAX_ROWS', 20 );
}

if ( ! function_exists( 'batavia_settings_schema' ) ) {
	/**
	 * The settings, grouped as they are presented on the settings screens.
	 *
	 * Field types: `text`, `tel`, `email`, `url` and `textarea` need a
	 * sanitiser, an input and (all but `textarea`) a binding, and cover
	 * everything the patterns ask for as a single value. `checkbox` is a
	 * section or element on or off, always written so an unchecked box stays
	 * unchecked. `category` stores a term id. `repeater` stores a list of
	 * rows, each row itself a small set of `text`/`textarea` fields -- used
	 * for the Experience and Consulting sections, which are lists rather than
	 * single values.
	 *
	 * Social keys are named `social_{service}` where `{service}` is a service
	 * recognised by the core Social Icon block. That is not decoration: it is
	 * how an icon with no URL of its own finds the URL to use.
	 *
	 * @since 1.2.0
	 *
	 * @return array<string, array<string, mixed>> Groups of field definitions.
	 */
	function batavia_settings_schema() {
		return array(
			'profile'    => array(
				'label'       => __( 'Profile', 'batavia' ),
				'description' => __( 'Who the site is about. The bundled patterns read these, so a change here reaches every pattern and every post that uses one.', 'batavia' ),
				'fields'      => array(
					'name'           => array(
						'label'       => __( 'Name', 'batavia' ),
						'type'        => 'text',
						'placeholder' => __( 'Ada Lovelace', 'batavia' ),
						'help'        => __( 'The headline of the Intro pattern. Leave empty to keep whatever the pattern already says.', 'batavia' ),
					),
					'role'           => array(
						'label'       => __( 'Role', 'batavia' ),
						'type'        => 'text',
						'placeholder' => __( 'Software engineer — distributed systems', 'batavia' ),
						'help'        => __( 'One line under the name, set in monospace.', 'batavia' ),
					),
					'availability'   => array(
						'label'       => __( 'Status line', 'batavia' ),
						'type'        => 'text',
						'placeholder' => __( 'A short status line', 'batavia' ),
						'help'        => __( 'The small ruled label above the name. It can say anything -- availability, a tagline, whatever is worth leading with -- and you can change it as often as you like.', 'batavia' ),
					),
					'location'       => array(
						'label'       => __( 'Location', 'batavia' ),
						'type'        => 'text',
						'placeholder' => __( 'Jakarta, Indonesia', 'batavia' ),
						'help'        => __( 'Shown in the colophon at the foot of the page.', 'batavia' ),
					),
					'copyright_text' => array(
						'label'       => __( 'Footer copyright', 'batavia' ),
						'type'        => 'text',
						'placeholder' => __( '© 2026', 'batavia' ),
						'help'        => __( 'Leave empty for the current year alone. Fill in to replace it entirely -- for example with a name, or a company.', 'batavia' ),
					),
				),
			),
			'contact'    => array(
				'label'       => __( 'Contact', 'batavia' ),
				'description' => __( 'Where a reader who wants to reach you ends up. Batavia ships without a contact page on purpose: a form is one more thing to maintain, and most people would rather open the app they already use. Fill in whichever of these you actually read.', 'batavia' ),
				'fields'      => array(
					'whatsapp'    => array(
						'label'       => __( 'WhatsApp number', 'batavia' ),
						'type'        => 'tel',
						'placeholder' => '+62 812 3456 7890',
						'help'        => __( 'In international form, country code first. Buttons bound to WhatsApp open a chat with you; spaces, dashes and brackets are ignored.', 'batavia' ),
					),
					'email'       => array(
						'label'       => __( 'Email address', 'batavia' ),
						'type'        => 'email',
						'placeholder' => 'you@example.com',
						'help'        => __( 'Buttons bound to the email link become mailto: links to this address.', 'batavia' ),
					),
					'booking_url' => array(
						'label'       => __( 'Booking page', 'batavia' ),
						'type'        => 'url',
						'placeholder' => 'https://cal.com/username',
						'help'        => __( 'A scheduling page, if you keep one. Optional: the primary button falls back to WhatsApp, then to your email address.', 'batavia' ),
					),
				),
			),
			'social'     => array(
				'label'       => __( 'Social profiles', 'batavia' ),
				'description' => __( 'Paste the full address of each profile you keep. An icon whose field is empty is left out of the page entirely, so there are no dead links and no empty rows.', 'batavia' ),
				'fields'      => array(
					'social_github'    => array(
						'label'       => 'GitHub',
						'type'        => 'url',
						'service'     => 'github',
						'placeholder' => 'https://github.com/username',
					),
					'social_x'         => array(
						'label'       => 'X',
						'type'        => 'url',
						'service'     => 'x',
						'placeholder' => 'https://x.com/username',
					),
					'social_bluesky'   => array(
						'label'       => 'Bluesky',
						'type'        => 'url',
						'service'     => 'bluesky',
						'placeholder' => 'https://bsky.app/profile/username',
					),
					'social_mastodon'  => array(
						'label'       => 'Mastodon',
						'type'        => 'url',
						'service'     => 'mastodon',
						'placeholder' => 'https://mastodon.social/@username',
					),
					'social_linkedin'  => array(
						'label'       => 'LinkedIn',
						'type'        => 'url',
						'service'     => 'linkedin',
						'placeholder' => 'https://linkedin.com/in/username',
					),
					'social_instagram' => array(
						'label'       => 'Instagram',
						'type'        => 'url',
						'service'     => 'instagram',
						'placeholder' => 'https://instagram.com/username',
					),
					'social_youtube'   => array(
						'label'       => 'YouTube',
						'type'        => 'url',
						'service'     => 'youtube',
						'placeholder' => 'https://youtube.com/@username',
					),
					'social_facebook'  => array(
						'label'       => 'Facebook',
						'type'        => 'url',
						'service'     => 'facebook',
						'placeholder' => 'https://facebook.com/username',
					),
					'social_threads'   => array(
						'label'       => 'Threads',
						'type'        => 'url',
						'service'     => 'threads',
						'placeholder' => 'https://threads.net/@username',
					),
					'social_tiktok'    => array(
						'label'       => 'TikTok',
						'type'        => 'url',
						'service'     => 'tiktok',
						'placeholder' => 'https://tiktok.com/@username',
					),
					'social_telegram'  => array(
						'label'       => 'Telegram',
						'type'        => 'url',
						'service'     => 'telegram',
						'placeholder' => 'https://t.me/username',
					),
					'social_codepen'   => array(
						'label'       => 'CodePen',
						'type'        => 'url',
						'service'     => 'codepen',
						'placeholder' => 'https://codepen.io/username',
					),
					'social_dribbble'  => array(
						'label'       => 'Dribbble',
						'type'        => 'url',
						'service'     => 'dribbble',
						'placeholder' => 'https://dribbble.com/username',
					),
					'social_medium'    => array(
						'label'       => 'Medium',
						'type'        => 'url',
						'service'     => 'medium',
						'placeholder' => 'https://medium.com/@username',
					),
				),
			),
			'hero'       => array(
				'label'       => __( 'Hero', 'batavia' ),
				'description' => __( 'The opening section. Everything here is on by default; turn off whatever you do not want, individually.', 'batavia' ),
				'fields'      => array(
					'show_hero_availability'  => array(
						'label' => __( 'Show the status line', 'batavia' ),
						'type'  => 'checkbox',
					),
					'show_hero_name'          => array(
						'label' => __( 'Show the name', 'batavia' ),
						'type'  => 'checkbox',
					),
					'show_hero_role'          => array(
						'label' => __( 'Show the role', 'batavia' ),
						'type'  => 'checkbox',
					),
					'show_hero_description'   => array(
						'label' => __( 'Show the summary paragraph', 'batavia' ),
						'type'  => 'checkbox',
					),
					'show_hero_cta_primary'   => array(
						'label' => __( 'Show the "Get in touch" button', 'batavia' ),
						'type'  => 'checkbox',
					),
					'show_hero_cta_secondary' => array(
						'label' => __( 'Show the "Read the notes" button', 'batavia' ),
						'type'  => 'checkbox',
					),
					'show_hero_tools'         => array(
						'label' => __( 'Show the tools line', 'batavia' ),
						'type'  => 'checkbox',
					),
				),
			),
			'portfolio'  => array(
				'label'       => __( 'Selected work', 'batavia' ),
				'description' => __( 'A grid of cards built from a Query Loop: featured image, category and title. Point it at a category here instead of opening the block\'s Filters panel.', 'batavia' ),
				'fields'      => array(
					'show_portfolio'     => array(
						'label' => __( 'Show this section', 'batavia' ),
						'type'  => 'checkbox',
					),
					'portfolio_category' => array(
						'label' => __( 'Category', 'batavia' ),
						'type'  => 'category',
						'help'  => __( 'Leave unset to use whatever category the block itself is already filtered to.', 'batavia' ),
					),
				),
			),
			'experience' => array(
				'label'       => __( 'Experience', 'batavia' ),
				'description' => '',
				'fields'      => array(
					'show_experience' => array(
						'label' => __( 'Show this section', 'batavia' ),
						'type'  => 'checkbox',
					),
					'experience'      => array(
						'label'     => __( 'Roles', 'batavia' ),
						'type'      => 'repeater',
						'row_label' => __( 'Role', 'batavia' ),
						'max'       => BATAVIA_REPEATER_MAX_ROWS,
						'fields'    => array(
							'mark'        => array(
								'label'       => __( 'Mark', 'batavia' ),
								'type'        => 'text',
								'placeholder' => __( 'N', 'batavia' ),
								'help'        => __( 'One or two characters for the square. Leave empty to use the first letter of the title.', 'batavia' ),
							),
							'dates'       => array(
								'label'       => __( 'Dates', 'batavia' ),
								'type'        => 'text',
								'placeholder' => __( '2021 — Present', 'batavia' ),
							),
							'title'       => array(
								'label'       => __( 'Title', 'batavia' ),
								'type'        => 'text',
								'placeholder' => __( 'Lead Engineer, Northwind Studio', 'batavia' ),
							),
							'description' => array(
								'label'       => __( 'Description', 'batavia' ),
								'type'        => 'textarea',
								'placeholder' => __( 'Two sentences on what the job actually was.', 'batavia' ),
							),
						),
					),
				),
			),
			'consulting' => array(
				'label'       => __( 'Consulting', 'batavia' ),
				'description' => '',
				'fields'      => array(
					'show_consulting' => array(
						'label' => __( 'Show this section', 'batavia' ),
						'type'  => 'checkbox',
					),
					'consulting'      => array(
						'label'     => __( 'Tiers', 'batavia' ),
						'type'      => 'repeater',
						'row_label' => __( 'Tier', 'batavia' ),
						'max'       => BATAVIA_REPEATER_MAX_ROWS,
						'fields'    => array(
							'title'       => array(
								'label'       => __( 'Title', 'batavia' ),
								'type'        => 'text',
								'placeholder' => __( 'Hourly', 'batavia' ),
							),
							'description' => array(
								'label'       => __( 'Description', 'batavia' ),
								'type'        => 'textarea',
								'placeholder' => __( 'Advisory, code and design review, billed in 30-minute blocks.', 'batavia' ),
							),
							'price'       => array(
								'label'       => __( 'Rate', 'batavia' ),
								'type'        => 'text',
								'placeholder' => __( '$225 / hour', 'batavia' ),
							),
						),
					),
				),
			),
			'notes'      => array(
				'label'       => __( 'Notes', 'batavia' ),
				'description' => __( 'The writing index. Choose which posts it lists instead of opening the block\'s Filters panel.', 'batavia' ),
				'fields'      => array(
					'show_notes'          => array(
						'label' => __( 'Show this section', 'batavia' ),
						'type'  => 'checkbox',
					),
					'notes_category_mode' => array(
						'label'      => __( 'Which posts', 'batavia' ),
						'type'       => 'radio',
						'infer_from' => 'notes_category',
						'options'    => array(
							'all'      => __( 'All categories', 'batavia' ),
							'specific' => __( 'One specific category', 'batavia' ),
						),
					),
					'notes_category'      => array(
						'label' => __( 'Category', 'batavia' ),
						'type'  => 'category',
						'help'  => __( 'Only used when "One specific category" is selected above.', 'batavia' ),
					),
				),
			),
		);
	}
}

if ( ! function_exists( 'batavia_settings_groups' ) ) {
	/**
	 * Which schema groups belong on which admin tab.
	 *
	 * @since 1.4.0
	 *
	 * @return array<string, array<int, string>> Tab slug mapped to group keys.
	 */
	function batavia_settings_groups() {
		return array(
			'homepage' => array( 'hero', 'portfolio', 'experience', 'consulting', 'notes' ),
		);
	}
}

if ( ! function_exists( 'batavia_settings_fields' ) ) {
	/**
	 * Every field in the schema, flattened to `key => definition`.
	 *
	 * @since 1.2.0
	 *
	 * @return array<string, array<string, mixed>> Field definitions by key.
	 */
	function batavia_settings_fields() {
		$fields = array();

		foreach ( batavia_settings_schema() as $group ) {
			foreach ( $group['fields'] as $key => $field ) {
				$fields[ $key ] = $field;
			}
		}

		return $fields;
	}
}

if ( ! function_exists( 'batavia_get_settings' ) ) {
	/**
	 * The stored scalar settings, with every known key present as a string.
	 *
	 * Repeater fields are left out -- their value is a list of rows, not a
	 * string, so a caller that wants one uses batavia_get_repeater_rows()
	 * instead. Callers of this function never have to test whether a key
	 * exists, only whether it is empty, and an unrecognised key stored by an
	 * older version of the theme is dropped rather than passed on.
	 *
	 * @since 1.2.0
	 *
	 * @return array<string, string> Settings keyed by field name.
	 */
	function batavia_get_settings() {
		$stored = get_option( BATAVIA_SETTINGS_OPTION, array() );

		if ( ! is_array( $stored ) ) {
			$stored = array();
		}

		$settings = array();

		foreach ( batavia_settings_fields() as $key => $field ) {
			if ( 'repeater' === $field['type'] ) {
				continue;
			}

			$settings[ $key ] = isset( $stored[ $key ] ) && is_string( $stored[ $key ] )
				? $stored[ $key ]
				: '';
		}

		return $settings;
	}
}

if ( ! function_exists( 'batavia_get_setting' ) ) {
	/**
	 * One scalar setting, or an empty string when it is unset or unknown.
	 *
	 * @since 1.2.0
	 *
	 * @param string $key Field key.
	 * @return string Stored value.
	 */
	function batavia_get_setting( $key ) {
		$settings = batavia_get_settings();

		return isset( $settings[ $key ] ) ? $settings[ $key ] : '';
	}
}

if ( ! function_exists( 'batavia_get_setting_bool' ) ) {
	/**
	 * One checkbox setting.
	 *
	 * Unlike the other field types, a checkbox is always written on save --
	 * '1' or '0' -- so a saved "off" cannot be mistaken for "never set".
	 * Only a field that has genuinely never been saved falls back to
	 * `$default_value`, which is why every show_* field defaults to visible:
	 * a fresh install has an empty option and should still look finished.
	 *
	 * @since 1.4.0
	 *
	 * @param string $key           Field key.
	 * @param bool   $default_value Value to use when the option has never been saved.
	 * @return bool Whether the thing should show.
	 */
	function batavia_get_setting_bool( $key, $default_value = true ) {
		$stored = get_option( BATAVIA_SETTINGS_OPTION, array() );

		if ( ! is_array( $stored ) || ! isset( $stored[ $key ] ) ) {
			return $default_value;
		}

		return '1' === $stored[ $key ];
	}
}

if ( ! function_exists( 'batavia_get_category_scope' ) ) {
	/**
	 * Whether a category-scoped section is limited to "all" or "specific".
	 *
	 * A radio the user has genuinely never saved is not the same as "all":
	 * on a site upgrading from before this control existed, a category may
	 * already be chosen, and treating that silently as "all" would drop a
	 * filter the site owner set on purpose. So an unsaved mode is inferred
	 * from whether a category is already stored, rather than defaulting flatly
	 * to "all". Once the radio is saved once, its stored value is used as-is.
	 *
	 * @since 1.4.0
	 *
	 * @param string $mode_key     Field key the scope radio is stored under.
	 * @param string $category_key Field key the category id is stored under.
	 * @return string 'all' or 'specific'.
	 */
	function batavia_get_category_scope( $mode_key, $category_key ) {
		$mode = batavia_get_setting( $mode_key );

		if ( '' !== $mode ) {
			return $mode;
		}

		return absint( batavia_get_setting( $category_key ) ) > 0 ? 'specific' : 'all';
	}
}

if ( ! function_exists( 'batavia_get_repeater_rows' ) ) {
	/**
	 * The sanitised rows stored for one repeater field.
	 *
	 * An empty array means the setting has never been filled in; the pattern
	 * that reads it supplies its own example rows in that case, the same way
	 * an empty text field leaves the pattern's own wording in place.
	 *
	 * @since 1.4.0
	 *
	 * @param string $key Repeater field key.
	 * @return array<int, array<string, string>> Rows, each keyed by sub-field.
	 */
	function batavia_get_repeater_rows( $key ) {
		$stored = get_option( BATAVIA_SETTINGS_OPTION, array() );

		if ( ! is_array( $stored ) || ! isset( $stored[ $key ] ) || ! is_array( $stored[ $key ] ) ) {
			return array();
		}

		return $stored[ $key ];
	}
}

if ( ! function_exists( 'batavia_sanitize_repeater_rows' ) ) {
	/**
	 * Sanitises one repeater field's posted rows.
	 *
	 * Rows are kept in the order they were submitted, which -- because
	 * nothing in the admin JS ever re-indexes a row's name attributes --
	 * matches whatever order they were arranged in on screen. A row with
	 * every sub-field empty is dropped rather than stored as a blank row.
	 *
	 * @since 1.4.0
	 *
	 * @param mixed                               $raw_rows  Posted value for the repeater.
	 * @param array<string, array<string, mixed>> $row_fields Sub-field definitions.
	 * @param int                                 $max       Maximum rows to keep.
	 * @return array<int, array<string, string>> Sanitised rows.
	 */
	function batavia_sanitize_repeater_rows( $raw_rows, $row_fields, $max ) {
		$rows = array();

		if ( ! is_array( $raw_rows ) ) {
			return $rows;
		}

		foreach ( $raw_rows as $raw_row ) {
			if ( count( $rows ) >= $max ) {
				break;
			}

			if ( ! is_array( $raw_row ) ) {
				continue;
			}

			$clean_row = array();

			foreach ( $row_fields as $sub_key => $sub_field ) {
				if ( ! isset( $raw_row[ $sub_key ] ) || ! is_scalar( $raw_row[ $sub_key ] ) ) {
					continue;
				}

				$raw = trim( (string) $raw_row[ $sub_key ] );

				if ( '' === $raw ) {
					continue;
				}

				$clean_row[ $sub_key ] = 'textarea' === $sub_field['type']
					? sanitize_textarea_field( $raw )
					: sanitize_text_field( $raw );
			}

			if ( ! empty( $clean_row ) ) {
				$rows[] = $clean_row;
			}
		}

		return $rows;
	}
}

if ( ! function_exists( 'batavia_sanitize_settings' ) ) {
	/**
	 * Sanitises the option on its way into the database.
	 *
	 * Keys the schema does not describe are discarded, so a stray field in a
	 * submitted form cannot add anything to the option. Profile, Contact,
	 * Social media and Homepage are four separate forms writing the same
	 * single option, so each carries a `_scope` field naming the schema
	 * group(s) it owns (see batavia_settings_groups() for Homepage's, and
	 * batavia_render_settings_group_tab() for the other three); a field
	 * outside that scope is copied through from whatever is already stored
	 * rather than dropped, so saving one form can never erase another's
	 * values. A submission with no `_scope` at all -- direct API use, not any
	 * shipped form -- sanitises every field present, the original
	 * single-form behaviour.
	 *
	 * @since 1.2.0
	 *
	 * @param mixed $value Raw submitted value.
	 * @return array<string, mixed> Sanitised settings.
	 */
	function batavia_sanitize_settings( $value ) {
		$clean = array();

		if ( ! is_array( $value ) ) {
			return $clean;
		}

		$stored = get_option( BATAVIA_SETTINGS_OPTION, array() );

		if ( ! is_array( $stored ) ) {
			$stored = array();
		}

		$scope_fields = null;

		if ( isset( $value['_scope'] ) && is_string( $value['_scope'] ) && '' !== $value['_scope'] ) {
			$schema       = batavia_settings_schema();
			$scope_fields = array();

			foreach ( array_filter( explode( ',', $value['_scope'] ) ) as $group_key ) {
				if ( isset( $schema[ $group_key ]['fields'] ) ) {
					$scope_fields = array_merge( $scope_fields, array_keys( $schema[ $group_key ]['fields'] ) );
				}
			}
		}

		foreach ( batavia_settings_fields() as $key => $field ) {
			if ( null !== $scope_fields && ! in_array( $key, $scope_fields, true ) ) {
				if ( isset( $stored[ $key ] ) ) {
					$clean[ $key ] = $stored[ $key ];
				}

				continue;
			}

			if ( 'repeater' === $field['type'] ) {
				$rows = batavia_sanitize_repeater_rows(
					isset( $value[ $key ] ) ? $value[ $key ] : null,
					$field['fields'],
					isset( $field['max'] ) ? (int) $field['max'] : BATAVIA_REPEATER_MAX_ROWS
				);

				if ( ! empty( $rows ) ) {
					$clean[ $key ] = $rows;
				}

				continue;
			}

			if ( 'checkbox' === $field['type'] ) {
				$clean[ $key ] = ! empty( $value[ $key ] ) ? '1' : '0';
				continue;
			}

			if ( ! isset( $value[ $key ] ) || ! is_scalar( $value[ $key ] ) ) {
				continue;
			}

			$raw = trim( (string) $value[ $key ] );

			if ( '' === $raw ) {
				continue;
			}

			switch ( $field['type'] ) {
				case 'email':
					$clean[ $key ] = sanitize_email( $raw );
					break;

				case 'url':
					$clean[ $key ] = esc_url_raw( $raw );
					break;

				case 'tel':
					/*
					 * Kept as typed, minus anything that cannot belong to a
					 * phone number, so the screen shows the spaced form a
					 * person recognises. The digits-only form the wa.me link
					 * needs is derived when the link is built.
					 */
					$clean[ $key ] = trim( (string) preg_replace( '/[^0-9+()\-. ]/', '', $raw ) );
					break;

				case 'textarea':
					$clean[ $key ] = sanitize_textarea_field( $raw );
					break;

				case 'category':
					$term_id       = absint( $raw );
					$clean[ $key ] = ( $term_id > 0 && term_exists( $term_id, 'category' ) ) ? (string) $term_id : '';
					break;

				case 'radio':
					$clean[ $key ] = isset( $field['options'][ $raw ] ) ? $raw : '';
					break;

				default:
					$clean[ $key ] = sanitize_text_field( $raw );
					break;
			}

			if ( '' === $clean[ $key ] ) {
				unset( $clean[ $key ] );
			}
		}

		return $clean;
	}
}

if ( ! function_exists( 'batavia_register_settings' ) ) {
	/**
	 * Registers the single option with the Settings API.
	 *
	 * `show_in_rest` is off deliberately: these values are already visible in
	 * the rendered page, and a theme has no reason to add an endpoint.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	function batavia_register_settings() {
		register_setting(
			'batavia_settings_group',
			BATAVIA_SETTINGS_OPTION,
			array(
				'type'              => 'array',
				'description'       => __( 'Profile, contact, social and homepage-section details the Batavia patterns read.', 'batavia' ),
				'sanitize_callback' => 'batavia_sanitize_settings',
				'default'           => array(),
				'show_in_rest'      => false,
			)
		);
	}
}
add_action( 'admin_init', 'batavia_register_settings' );
