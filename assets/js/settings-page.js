/**
 * The Settings and Homepage tabs' interactive fields.
 *
 * Three independent pieces, all admin-only: media pickers for the site icon
 * and logo on the Site identity tab; the add/remove/reorder controls --
 * buttons and drag-and-drop alike -- for the Experience and Consulting
 * repeater fields on Homepage; and the chip-style entry for Hero's Tools
 * field, also on Homepage. Everything past the media pickers only needs
 * jQuery, since not every tab this file loads on has enqueued wp.media.
 *
 * Loads on these tabs, and only for users who may change these settings.
 * The theme itself ships no front-end JavaScript.
 *
 * @package Batavia
 * @since   1.2.0
 */

( function ( $, wp, strings ) {
	'use strict';

	if ( ! $ || ! wp || ! wp.media ) {
		return;
	}

	/**
	 * Reflects a chosen attachment in a field: preview, id, button labels.
	 *
	 * @param {Object} $field      The field wrapper.
	 * @param {Object} attachment  The selected attachment, or null to clear.
	 * @return {void}
	 */
	function render( $field, attachment ) {
		var $preview = $field.find( '.batavia-media__preview' );
		var size =
			attachment &&
			attachment.sizes &&
			( attachment.sizes.thumbnail || attachment.sizes.full );

		$field.find( 'input[type="hidden"]' ).val( attachment ? attachment.id : '' );
		$preview.empty();

		if ( size ) {
			$preview.append( $( '<img />', { src: size.url, alt: '' } ) );
		}

		$field
			.find( '[data-batavia-media-choose]' )
			.text( attachment ? strings.replace : strings.choose );

		$field
			.find( '[data-batavia-media-remove]' )
			.prop( 'hidden', ! attachment );
	}

	$( document ).on( 'click', '[data-batavia-media-choose]', function ( event ) {
		event.preventDefault();

		var $field = $( event.currentTarget ).closest( '[data-batavia-media]' );
		var frame = $field.data( 'bataviaFrame' );

		if ( ! frame ) {
			frame = wp.media( {
				title: $field.data( 'title' ),
				button: { text: strings.useImage },
				library: { type: 'image' },
				multiple: false,
			} );

			frame.on( 'select', function () {
				render( $field, frame.state().get( 'selection' ).first().toJSON() );
			} );

			$field.data( 'bataviaFrame', frame );
		}

		frame.open();
	} );

	$( document ).on( 'click', '[data-batavia-media-remove]', function ( event ) {
		event.preventDefault();

		render( $( event.currentTarget ).closest( '[data-batavia-media]' ), null );
	} );
} )( window.jQuery, window.wp, window.bataviaAdmin || {} );

( function ( $ ) {
	'use strict';

	if ( ! $ ) {
		return;
	}

	/**
	 * Relabels every row in a repeater after it changes shape or order.
	 *
	 * Field names are never touched here -- only the number shown to the
	 * user -- so this is safe to call after an add, a remove, or a move.
	 *
	 * @param {Object} $repeater The repeater wrapper.
	 * @return {void}
	 */
	function renumberRows( $repeater ) {
		var label = $repeater.data( 'repeaterLabel' ) || '';

		$repeater
			.find( '> [data-batavia-repeater-rows] > .batavia-repeater__row' )
			.each( function ( index ) {
				$( this )
					.find( '.batavia-repeater__row-number' )
					.first()
					.text( label + ' ' + ( index + 1 ) );
			} );
	}

	$( document ).on( 'click', '[data-batavia-repeater-add]', function ( event ) {
		event.preventDefault();

		var $repeater = $( event.currentTarget ).closest( '.batavia-repeater' );
		var $rows = $repeater.find( '> [data-batavia-repeater-rows]' ).first();
		var template = $repeater.find( '> [data-batavia-repeater-template]' ).get( 0 );

		if ( ! template || ! template.content ) {
			return;
		}

		var nextIndex = $repeater.data( 'bataviaNextIndex' );

		if ( ! nextIndex ) {
			nextIndex = Date.now();
		}

		$repeater.data( 'bataviaNextIndex', nextIndex + 1 );

		var wrapper = document.createElement( 'div' );
		wrapper.appendChild( template.content.cloneNode( true ) );

		var html = wrapper.innerHTML.split( '__INDEX__' ).join( String( nextIndex ) );

		$rows.append( html );
		renumberRows( $repeater );
	} );

	$( document ).on( 'click', '[data-batavia-repeater-remove]', function ( event ) {
		event.preventDefault();

		var $repeater = $( event.currentTarget ).closest( '.batavia-repeater' );

		$( event.currentTarget ).closest( '.batavia-repeater__row' ).remove();
		renumberRows( $repeater );
	} );

	$( document ).on( 'click', '[data-batavia-repeater-up]', function ( event ) {
		event.preventDefault();

		var $row = $( event.currentTarget ).closest( '.batavia-repeater__row' );
		var $prev = $row.prev( '.batavia-repeater__row' );

		if ( $prev.length ) {
			$row.insertBefore( $prev );
			renumberRows( $row.closest( '.batavia-repeater' ) );
		}
	} );

	$( document ).on( 'click', '[data-batavia-repeater-down]', function ( event ) {
		event.preventDefault();

		var $row = $( event.currentTarget ).closest( '.batavia-repeater__row' );
		var $next = $row.next( '.batavia-repeater__row' );

		if ( $next.length ) {
			$row.insertAfter( $next );
			renumberRows( $row.closest( '.batavia-repeater' ) );
		}
	} );

	/*
	 * Drag-and-drop reordering, arming only from the handle so grabbing text
	 * inside a field never picks up the whole row. The up/down buttons stay
	 * as the keyboard- and screen-reader-reachable way to do the same thing.
	 */
	var $draggingRow = null;

	$( document ).on( 'mousedown', '[data-batavia-repeater-handle]', function ( event ) {
		event.currentTarget.closest( '.batavia-repeater__row' ).draggable = true;
	} );

	$( document ).on( 'mouseup', function () {
		$( '.batavia-repeater__row[draggable="true"]' ).prop( 'draggable', false );
	} );

	$( document ).on( 'dragstart', '.batavia-repeater__row', function ( event ) {
		$draggingRow = $( event.currentTarget );
		$draggingRow.addClass( 'is-dragging' );

		if ( event.originalEvent && event.originalEvent.dataTransfer ) {
			event.originalEvent.dataTransfer.effectAllowed = 'move';
			event.originalEvent.dataTransfer.setData( 'text/plain', '' );
		}
	} );

	$( document ).on( 'dragend', '.batavia-repeater__row', function ( event ) {
		$( event.currentTarget ).removeClass( 'is-dragging' ).prop( 'draggable', false );
		$draggingRow = null;
	} );

	$( document ).on( 'dragover', '.batavia-repeater__row', function ( event ) {
		if ( ! $draggingRow || $draggingRow.is( event.currentTarget ) ) {
			return;
		}

		var $target = $( event.currentTarget );

		if ( ! $target.closest( '.batavia-repeater' ).is( $draggingRow.closest( '.batavia-repeater' ) ) ) {
			return;
		}

		event.preventDefault();

		if ( $draggingRow.index() < $target.index() ) {
			$draggingRow.insertAfter( $target );
		} else {
			$draggingRow.insertBefore( $target );
		}

		renumberRows( $target.closest( '.batavia-repeater' ) );
	} );

	$( document ).on( 'drop', '.batavia-repeater__row', function ( event ) {
		event.preventDefault();
	} );
} )( window.jQuery );

( function ( $ ) {
	'use strict';

	if ( ! $ ) {
		return;
	}

	/**
	 * Reads the chip list back into the underlying field's comma-separated
	 * value, so the field submits the same way with or without this running.
	 *
	 * @param {Object} $field The original text input, kept hidden.
	 * @param {Object} $list  The chip list built in front of it.
	 * @return {void}
	 */
	function sync( $field, $list ) {
		var names = $list
			.find( '.batavia-tags__chip' )
			.map( function () {
				return $( this ).data( 'name' );
			} )
			.get();

		$field.val( names.join( ', ' ) );
	}

	/**
	 * Adds one chip, unless its name is empty or already present.
	 *
	 * @param {Object} $field The original text input.
	 * @param {Object} $list  The chip list to append to.
	 * @param {string} name   The name to add.
	 * @return {void}
	 */
	function addChip( $field, $list, name ) {
		name = name.trim().replace( /,+$/, '' );

		if ( ! name ) {
			return;
		}

		var exists = $list.find( '.batavia-tags__chip' ).toArray().some( function ( chip ) {
			return $( chip ).data( 'name' ).toLowerCase() === name.toLowerCase();
		} );

		if ( exists ) {
			return;
		}

		var $chip = $( '<li class="batavia-tags__chip"></li>' ).text( name ).data( 'name', name );
		var $remove = $( '<button type="button" class="batavia-tags__remove"><span aria-hidden="true">&times;</span></button>' );

		$remove.attr( 'aria-label', name );
		$chip.append( $remove );
		$list.append( $chip );
		sync( $field, $list );
	}

	/**
	 * Replaces one `[data-batavia-tags-field]` input with a chip entry UI.
	 *
	 * The original input is kept in the page, hidden rather than removed, so
	 * its name and value keep submitting normally -- this only changes how a
	 * person fills it in, not what the form sends.
	 *
	 * @param {Object} $field The text input to enhance.
	 * @return {void}
	 */
	function enhance( $field ) {
		var $list = $( '<ul class="batavia-tags__list"></ul>' );
		var $entry = $( '<input type="text" class="batavia-tags__entry" />' );
		var placeholder = $field.attr( 'placeholder' );

		if ( placeholder ) {
			$entry.attr( 'placeholder', placeholder );
		}

		( $field.val() || '' ).split( ',' ).forEach( function ( name ) {
			addChip( $field, $list, name );
		} );

		$list.on( 'click', '.batavia-tags__remove', function () {
			$( this ).closest( '.batavia-tags__chip' ).remove();
			sync( $field, $list );
			$entry.trigger( 'focus' );
		} );

		$entry.on( 'keydown', function ( event ) {
			if ( 'Enter' === event.key || ',' === event.key ) {
				event.preventDefault();
				addChip( $field, $list, $entry.val() );
				$entry.val( '' );
			} else if ( 'Backspace' === event.key && ! $entry.val() ) {
				$list.find( '.batavia-tags__chip' ).last().remove();
				sync( $field, $list );
			}
		} );

		$entry.on( 'blur', function () {
			addChip( $field, $list, $entry.val() );
			$entry.val( '' );
		} );

		$field
			.hide()
			.after(
				$( '<div class="batavia-tags"></div>' )
					.append( $list )
					.append( $entry )
			);
	}

	$( function () {
		$( '[data-batavia-tags-field]' ).each( function () {
			enhance( $( this ) );
		} );
	} );
} )( window.jQuery );
