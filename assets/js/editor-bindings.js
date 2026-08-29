/**
 * Resolves Batavia's binding source inside the editor.
 *
 * The source is registered twice on purpose. The PHP registration in
 * inc/bindings.php produces the value on the front end; this one produces the
 * same value in the editor, so a bound heading reads the same in both places.
 * WordPress expects and merges the two registrations.
 *
 * No build step: this file is served as written, which is why it is ES5 and
 * reads the editor globals off `window` instead of importing them.
 *
 * @package Batavia
 * @since   1.2.0
 */

( function ( wp, data ) {
	'use strict';

	if ( ! wp || ! wp.blocks || ! wp.blocks.registerBlockBindingsSource ) {
		return;
	}

	var values = data.values || {};
	var fields = data.fields || [];

	wp.blocks.registerBlockBindingsSource( {
		name: 'batavia/setting',

		/**
		 * Returns a value for each bound attribute that has one.
		 *
		 * Attributes whose setting is empty are left out rather than set to an
		 * empty string, so the editor keeps showing the text the pattern
		 * shipped with -- the same fallback the front end uses.
		 *
		 * @param {Object} args          Arguments from the editor.
		 * @param {Object} args.bindings The block's bindings for this source.
		 * @return {Object} Attribute name mapped to its value.
		 */
		getValues: function ( args ) {
			var bindings = args.bindings || {};
			var resolved = {};

			Object.keys( bindings ).forEach( function ( attribute ) {
				var binding = bindings[ attribute ] || {};
				var key = binding.args ? binding.args.key : undefined;

				if ( key && values[ key ] ) {
					resolved[ attribute ] = values[ key ];
				}
			} );

			return resolved;
		},

		/**
		 * Lists the settings a user can connect a block to.
		 *
		 * Populates the editor's "Connect to" dropdown, which is how someone
		 * binds a block of their own rather than one that came from a pattern.
		 *
		 * @return {Array} Field descriptors.
		 */
		getFieldsList: function () {
			return fields;
		},

		/**
		 * Bound values are read-only here.
		 *
		 * They have one home, Appearance -> Batavia -> Settings, and letting
		 * them be overwritten from a post would quietly undo that.
		 *
		 * @return {boolean} Always false.
		 */
		canUserEditValue: function () {
			return false;
		},
	} );
} )( window.wp, window.bataviaBindings || {} );
