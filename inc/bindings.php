<?php
/**
 * Connects the theme's settings to core blocks.
 *
 * A theme may not register blocks of its own, so the usual way to show a value
 * the user typed into the Customizer -- a block that reads it -- is closed.
 * The Block Bindings API opens a different one: a core Paragraph, Heading,
 * Button or Image can be told to take one of its attributes from a named source,
 * and a theme is allowed to register the source.
 *
 * That is what makes the patterns reusable rather than disposable. A pattern
 * inserted into ten posts reads the same settings in all ten, so changing an
 * email address once changes it everywhere -- without synced patterns, and
 * without the patterns knowing anything about each other.
 *
 * Three rules hold this together:
 *
 * 1. An empty setting resolves to null, and core then leaves the block's own
 *    text alone. Patterns therefore ship readable and stay readable.
 * 2. Bound values are not editable in the editor. There is one place to change
 *    them, and the editor points at it rather than competing with it.
 * 3. Social icons cannot be bound -- the Social Icon block is not on core's
 *    list of bindable blocks -- so they are handled separately, further down.
 *
 * @package Batavia
 * @since   1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'batavia_binding_value' ) ) {
	/**
	 * Resolves one bound attribute.
	 *
	 * Returning null tells WordPress to keep the value already written into the
	 * block, which is what makes a half-filled Customizer panel harmless.
	 *
	 * @since 1.2.0
	 *
	 * @param array<string, mixed> $source_args    Arguments from the block's binding.
	 * @param WP_Block             $block_instance The block being rendered. Unused.
	 * @param string               $attribute_name The attribute being bound. Unused.
	 * @return string|null The value, or null to leave the block's own content in place.
	 */
	function batavia_binding_value( $source_args, $block_instance = null, $attribute_name = '' ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter -- The signature is fixed by register_block_bindings_source(); one key is all this source needs.
		$key = isset( $source_args['key'] ) && is_string( $source_args['key'] )
			? $source_args['key']
			: '';

		if ( '' === $key ) {
			return null;
		}

		$email = batavia_get_setting( 'email' );
		$mail  = '' === $email ? '' : 'mailto:' . $email;

		$digits = preg_replace( '/\D/', '', batavia_get_setting( 'whatsapp' ) );
		$chat   = '' === $digits ? '' : 'https://wa.me/' . $digits;

		/*
		 * Some keys are derived rather than stored. A button needs a URL, but
		 * asking someone to type "mailto:" in front of their own address, or to
		 * work out what wa.me wants, is a good way to collect broken links.
		 */
		if ( 'email_url' === $key ) {
			return '' === $mail ? null : $mail;
		}

		if ( 'whatsapp_url' === $key ) {
			return '' === $chat ? null : $chat;
		}

		/*
		 * The primary button on every pattern. It tries the three in the order
		 * someone is most likely to want to be reached, so a site with only a
		 * phone number filled in still has a button that works.
		 */
		if ( 'contact_url' === $key ) {
			$booking = batavia_get_setting( 'booking_url' );

			foreach ( array( $booking, $chat, $mail ) as $candidate ) {
				if ( '' !== $candidate ) {
					return $candidate;
				}
			}

			return null;
		}

		if ( 'booking_url' === $key ) {
			$url = batavia_get_setting( 'booking_url' );

			if ( '' !== $url ) {
				return $url;
			}

			foreach ( array( $chat, $mail ) as $candidate ) {
				if ( '' !== $candidate ) {
					return $candidate;
				}
			}

			return null;
		}

		$value = batavia_get_setting( $key );

		return '' === $value ? null : $value;
	}
}

if ( ! function_exists( 'batavia_binding_fields' ) ) {
	/**
	 * The fields offered in the editor's "Connect to" dropdown.
	 *
	 * Social profiles are left out: they reach the page through the Social Icon
	 * block, and listing fourteen services here would bury the four fields
	 * somebody actually wants to connect.
	 *
	 * @since 1.2.0
	 *
	 * @return array<int, array<string, mixed>> Field descriptors for the editor.
	 */
	function batavia_binding_fields() {
		$bindable_types = array( 'text', 'email', 'url', 'tel', 'textarea' );
		$fields         = array();

		foreach ( batavia_settings_fields() as $key => $field ) {
			if ( 0 === strpos( $key, 'social_' ) ) {
				continue;
			}

			if ( ! in_array( $field['type'], $bindable_types, true ) ) {
				continue;
			}

			$fields[] = array(
				'label' => $field['label'],
				'type'  => 'string',
				'args'  => array( 'key' => $key ),
			);
		}

		/*
		 * The derived link keys, offered after the plain fields because these
		 * are what a button wants and the fields above are what a heading
		 * wants.
		 */
		$links = array(
			'contact_url'  => __( 'Best way to reach you (as a link)', 'batavia' ),
			'whatsapp_url' => __( 'WhatsApp chat (as a link)', 'batavia' ),
			'email_url'    => __( 'Email address (as a link)', 'batavia' ),
		);

		foreach ( $links as $key => $label ) {
			$fields[] = array(
				'label' => $label,
				'type'  => 'string',
				'args'  => array( 'key' => $key ),
			);
		}

		return $fields;
	}
}

if ( ! function_exists( 'batavia_register_bindings' ) ) {
	/**
	 * Registers the theme's binding source.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	function batavia_register_bindings() {
		if ( ! function_exists( 'register_block_bindings_source' ) ) {
			return;
		}

		register_block_bindings_source(
			'batavia/setting',
			array(
				'label'              => __( 'Batavia settings', 'batavia' ),
				'get_value_callback' => 'batavia_binding_value',
			)
		);
	}
}
add_action( 'init', 'batavia_register_bindings' );

if ( ! function_exists( 'batavia_enqueue_binding_script' ) ) {
	/**
	 * Teaches the editor to resolve the same source.
	 *
	 * Registering on the server covers the front end only; without this the
	 * editor would show the pattern's placeholder text while the published page
	 * showed the real value, which looks like a bug. The values are inlined
	 * because they are already public on the front end.
	 *
	 * This is the theme's only JavaScript, and it loads in the editor alone.
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	function batavia_enqueue_binding_script() {
		$version = wp_get_theme()->get( 'Version' );
		$handle  = 'batavia-bindings';

		wp_enqueue_script(
			$handle,
			get_theme_file_uri( 'assets/js/editor-bindings.js' ),
			array( 'wp-blocks' ),
			is_string( $version ) && '' !== $version ? $version : false,
			true
		);

		$values = array();

		foreach ( array_keys( batavia_settings_fields() ) as $key ) {
			$value = batavia_binding_value( array( 'key' => $key ) );

			if ( null !== $value ) {
				$values[ $key ] = $value;
			}
		}

		foreach ( array( 'contact_url', 'whatsapp_url', 'email_url' ) as $key ) {
			$value = batavia_binding_value( array( 'key' => $key ) );

			if ( null !== $value ) {
				$values[ $key ] = $value;
			}
		}

		wp_add_inline_script(
			$handle,
			'window.bataviaBindings = ' . wp_json_encode(
				array(
					'values' => $values,
					'fields' => batavia_binding_fields(),
				)
			) . ';',
			'before'
		);
	}
}
add_action( 'enqueue_block_editor_assets', 'batavia_enqueue_binding_script' );

if ( ! function_exists( 'batavia_fill_social_link' ) ) {
	/**
	 * Gives a Social Icon block the address stored for its service.
	 *
	 * The Social Icon block is not bindable, so the settings reach it here
	 * instead. Only icons left empty are filled: a URL typed into the editor is
	 * the user being specific, and wins.
	 *
	 * WhatsApp is a special case: it reads the wa.me link derived from the
	 * Contact tab's WhatsApp number (the same one `whatsapp_url` resolves to
	 * for a bound button), rather than a `social_whatsapp` setting -- there is
	 * no such field, since a second WhatsApp field under Social media would
	 * just be the same number typed twice.
	 *
	 * @since 1.2.0
	 *
	 * @param array<string, mixed> $parsed_block The block about to be rendered.
	 * @return array<string, mixed> The block, possibly with a URL.
	 */
	function batavia_fill_social_link( $parsed_block ) {
		if ( ! isset( $parsed_block['blockName'] ) || 'core/social-link' !== $parsed_block['blockName'] ) {
			return $parsed_block;
		}

		if ( ! empty( $parsed_block['attrs']['url'] ) ) {
			return $parsed_block;
		}

		$service = isset( $parsed_block['attrs']['service'] ) ? $parsed_block['attrs']['service'] : '';

		if ( ! is_string( $service ) || '' === $service ) {
			return $parsed_block;
		}

		$url = 'whatsapp' === $service
			? (string) batavia_binding_value( array( 'key' => 'whatsapp_url' ) )
			: batavia_get_setting( 'social_' . $service );

		if ( '' !== $url ) {
			$parsed_block['attrs']['url'] = $url;
		}

		return $parsed_block;
	}
}
add_filter( 'render_block_data', 'batavia_fill_social_link' );

if ( ! function_exists( 'batavia_hide_empty_social_link' ) ) {
	/**
	 * Drops a Social Icon that still has nowhere to go.
	 *
	 * Core renders an icon with an empty href rather than omitting it, so a
	 * theme that ships a row of icons for services the user does not use would
	 * ship a row of links to the current page. Removing them means the footer
	 * shows exactly the profiles that were filled in.
	 *
	 * @since 1.2.0
	 *
	 * @param string               $content The rendered icon.
	 * @param array<string, mixed> $block   The parsed block.
	 * @return string The icon, or nothing.
	 */
	function batavia_hide_empty_social_link( $content, $block ) {
		if ( empty( $block['attrs']['url'] ) ) {
			return '';
		}

		return $content;
	}
}
add_filter( 'render_block_core/social-link', 'batavia_hide_empty_social_link', 10, 2 );

if ( ! function_exists( 'batavia_hide_empty_social_links' ) ) {
	/**
	 * Drops the surrounding list when every icon in it was removed.
	 *
	 * Otherwise the footer of a site with no social profiles keeps the empty
	 * list's margins, leaving a gap with nothing in it.
	 *
	 * @since 1.2.0
	 *
	 * @param string $content The rendered list.
	 * @return string The list, or nothing.
	 */
	function batavia_hide_empty_social_links( $content ) {
		if ( false === strpos( $content, '<li' ) ) {
			return '';
		}

		return $content;
	}
}
add_filter( 'render_block_core/social-links', 'batavia_hide_empty_social_links' );
