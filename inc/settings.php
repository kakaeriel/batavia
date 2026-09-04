<?php
/**
 * Batavia's own settings: one option, the fields inside it, the accessors.
 *
 * Theme review allows a theme to keep settings of its own on one condition --
 * exactly one database option, prefixed with the theme slug, stored as an array,
 * edited through the Customizer and sanitised on the way in. That option is
 * `batavia_settings`, and this file is the only place that knows its shape.
 *
 * One schema drives three things: the controls on the Customizer panel (see
 * inc/customizer.php), the sanitisation each of them applies, and the keys the
 * block binding source will resolve. Adding a field here makes it appear in
 * all three.
 *
 * Nothing here is required for the theme to render. Every field is optional and
 * an empty field falls back to the text written into the pattern, so a fresh
 * install looks finished before anyone opens the Customizer.
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

if ( ! defined( 'BATAVIA_EXPERIENCE_SLOTS' ) ) {
	define( 'BATAVIA_EXPERIENCE_SLOTS', 5 );
}

if ( ! defined( 'BATAVIA_CONSULTING_SLOTS' ) ) {
	define( 'BATAVIA_CONSULTING_SLOTS', 4 );
}

if ( ! function_exists( 'batavia_settings_schema' ) ) {
	/**
	 * The settings, grouped as they are presented on the Customizer panel.
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
					'tools'                   => array(
						'label'       => __( 'Tools', 'batavia' ),
						'type'        => 'tags',
						'placeholder' => __( 'WordPress, PHP, MySQL', 'batavia' ),
						'help'        => __( 'Type a name and press Enter or comma to add it.', 'batavia' ),
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
						'max'       => BATAVIA_EXPERIENCE_SLOTS,
						'fields'    => array(
							'logo'        => array(
								'label' => __( 'Logo', 'batavia' ),
								'type'  => 'media',
								'help'  => __( 'A square photo or icon, shown in the circle instead of Company\'s initials. Cropped to fill, like a profile picture.', 'batavia' ),
							),
							'mark'        => array(
								'label'       => __( 'Company', 'batavia' ),
								'type'        => 'text',
								'placeholder' => __( 'Northwind Studio', 'batavia' ),
								'help'        => __( 'Shown next to the role. Also supplies the circle\'s initials when no Logo is set.', 'batavia' ),
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
						'max'       => BATAVIA_CONSULTING_SLOTS,
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
							'exclude'  => __( 'All except one category', 'batavia' ),
						),
					),
					'notes_category'      => array(
						'label' => __( 'Category', 'batavia' ),
						'type'  => 'category',
						'help'  => __( 'Used when "One specific category" or "All except one category" is selected above.', 'batavia' ),
					),
				),
			),
			'cta'        => array(
				'label'       => __( 'Closing call to action', 'batavia' ),
				'description' => __( 'A closing invitation to get in touch, just above the footer. Reads the same contact link as Hero\'s primary button -- a booking page, WhatsApp or email, whichever is filled in under Contact.', 'batavia' ),
				'fields'      => array(
					'show_cta' => array(
						'label' => __( 'Show this section', 'batavia' ),
						'type'  => 'checkbox',
					),
				),
			),
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
	 * Unlike the other field types, a checkbox is always written on save, so
	 * a saved "off" cannot be mistaken for "never set". Only a field that has
	 * genuinely never been saved falls back to
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

		/*
		 * The Customizer stores a checkbox as a boolean. Themes updated from
		 * 1.5.x carry the '1'/'0' strings the settings screen wrote instead,
		 * so both spellings of "on" are accepted.
		 */
		return true === $stored[ $key ] || '1' === $stored[ $key ];
	}
}

if ( ! function_exists( 'batavia_get_category_scope' ) ) {
	/**
	 * Whether a category-scoped section is limited to "all", "specific" or
	 * "exclude".
	 *
	 * A radio the user has genuinely never saved is not the same as "all":
	 * on a site upgrading from before this control existed, a category may
	 * already be chosen, and treating that silently as "all" would drop a
	 * filter the site owner set on purpose. So an unsaved mode is inferred
	 * from whether a category is already stored, rather than defaulting flatly
	 * to "all" -- "exclude" is never inferred this way, since it did not exist
	 * before this control did. Once the radio is saved once, its stored value
	 * is used as-is.
	 *
	 * @since 1.4.0
	 *
	 * @param string $mode_key     Field key the scope radio is stored under.
	 * @param string $category_key Field key the category id is stored under.
	 * @return string 'all', 'specific' or 'exclude'.
	 */
	function batavia_get_category_scope( $mode_key, $category_key ) {
		$mode = batavia_get_setting( $mode_key );

		if ( '' !== $mode ) {
			return $mode;
		}

		return absint( batavia_get_setting( $category_key ) ) > 0 ? 'specific' : 'all';
	}
}

if ( ! function_exists( 'batavia_posts_page_url' ) ) {
	/**
	 * The site's posts page URL, if one is set under Settings -> Reading.
	 *
	 * `get_permalink()` treats `0` -- what `get_option( 'page_for_posts' )`
	 * returns when no posts page is chosen -- as "use the current global
	 * $post", not "no post". Called from inside a Query Loop, that silently
	 * returns whichever post the loop last touched instead of the empty
	 * string a caller checking "is one set" would expect.
	 *
	 * @since 1.4.0
	 *
	 * @return string The posts page's URL, or an empty string if none is set.
	 */
	function batavia_posts_page_url() {
		$page_id = absint( get_option( 'page_for_posts' ) );

		return $page_id > 0 ? (string) get_permalink( $page_id ) : '';
	}
}

if ( ! function_exists( 'batavia_notes_archive_url' ) ) {
	/**
	 * Where "read the notes" should actually go.
	 *
	 * Used by both Hero's "Read the notes" button and Notes' own "All notes"
	 * button, so the two always agree: the Notes category's own archive when
	 * Notes is scoped to one specific category, the site's posts page
	 * otherwise (or an empty string, if neither is set -- a caller should
	 * fall back to `#` rather than link nowhere useful).
	 *
	 * @since 1.5.0
	 *
	 * @return string A URL, or an empty string if nothing is configured.
	 */
	function batavia_notes_archive_url() {
		$scope       = batavia_get_category_scope( 'notes_category_mode', 'notes_category' );
		$category_id = absint( batavia_get_setting( 'notes_category' ) );

		if ( 'specific' === $scope && $category_id > 0 ) {
			return (string) get_category_link( $category_id );
		}

		return batavia_posts_page_url();
	}
}

if ( ! function_exists( 'batavia_category_tax_query' ) ) {
	/**
	 * The `taxQuery` value for a Query Loop scoped to one setting's category.
	 *
	 * Returned pre-encoded as JSON, meant to sit directly inside a pattern's
	 * own `<!-- wp:query {"query":{...,"taxQuery":<?php echo ...; ?>}} -->`
	 * comment, baked in before the block comment is ever parsed -- the same
	 * as a category chosen by hand in the block's own Filters panel.
	 *
	 * That is deliberate, not just convenient: filtering the query at render
	 * time instead (on `query_loop_block_query_vars`) cannot work, because
	 * that filter fires once per descendant block -- Post Template, Query No
	 * Results, Query Pagination -- and never receives the Query block itself,
	 * so it can never see the Query block's own className or attributes to
	 * key off. Baking the value into the block's own `query.taxQuery`
	 * attribute instead reaches every descendant through ordinary block
	 * context inheritance, because that is what the attribute is for.
	 *
	 * @since 1.4.0
	 *
	 * @param string      $category_key Field key the category id is stored under.
	 * @param string|null $mode_key     Field key the scope radio is stored under, if the
	 *                                  section has one. Omitted for a section with only a
	 *                                  category picker, which is always "specific" once set.
	 * @return string 'null', or a JSON-encoded `{"include":...}` / `{"exclude":...}` object.
	 */
	function batavia_category_tax_query( $category_key, $mode_key = null ) {
		$scope = null !== $mode_key ? batavia_get_category_scope( $mode_key, $category_key ) : 'specific';

		if ( 'all' === $scope ) {
			return 'null';
		}

		$term_id = absint( batavia_get_setting( $category_key ) );

		if ( $term_id <= 0 ) {
			return 'null';
		}

		$side = 'exclude' === $scope ? 'exclude' : 'include';

		return wp_json_encode( array( $side => array( 'category' => array( $term_id ) ) ) );
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
	 * Each row is stored against the numbered Customizer slot it was typed
	 * into, so the slots stay where the user left them. Ordering and the
	 * dropping of blank slots happen here instead, which is why filling in
	 * slot three without slot two shows one row on the page rather than two.
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

		$slots = $stored[ $key ];

		ksort( $slots, SORT_NUMERIC );

		$rows = array();

		foreach ( $slots as $slot ) {
			if ( ! is_array( $slot ) ) {
				continue;
			}

			$row = array_filter(
				$slot,
				static function ( $value ) {
					return '' !== $value && 0 !== $value && null !== $value;
				}
			);

			if ( ! empty( $row ) ) {
				$rows[] = $row;
			}
		}

		return $rows;
	}
}
