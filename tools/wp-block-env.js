/**
 * A browser-shaped global scope for running @wordpress/blocks under Node.
 *
 * @wordpress/block-library is built for the browser and touches `window`,
 * `document`, `matchMedia` and friends at import time. Requiring this module
 * first installs a jsdom window as the global scope, registers every core
 * block, and returns the blocks API ready to parse.
 *
 * @package Batavia
 */

'use strict';

const { JSDOM, VirtualConsole } = require( 'jsdom' );

const virtualConsole = new VirtualConsole();
virtualConsole.on( 'jsdomError', () => {} );

const dom = new JSDOM( '<!doctype html><html><body></body></html>', {
	url: 'https://example.test/',
	virtualConsole,
} );

/**
 * Assigns a global, working around read-only accessors such as Node 22's
 * built-in `navigator`.
 *
 * @param {string} name  Global name.
 * @param {*}      value Value to assign.
 * @return {void}
 */
function defineGlobal( name, value ) {
	try {
		global[ name ] = value;
	} catch {
		Object.defineProperty( global, name, { value, configurable: true, writable: true } );
	}
}

for ( const key of Object.getOwnPropertyNames( dom.window ) ) {
	if ( key in global ) {
		continue;
	}
	try {
		global[ key ] = dom.window[ key ];
	} catch {
		/* Read-only accessor on the jsdom window; nothing to do. */
	}
}

defineGlobal( 'window', dom.window );
defineGlobal( 'self', dom.window );
defineGlobal( 'document', dom.window.document );
defineGlobal( 'navigator', dom.window.navigator );

global.requestAnimationFrame = ( cb ) => setTimeout( () => cb( Date.now() ), 0 );
global.cancelAnimationFrame = ( id ) => clearTimeout( id );
global.matchMedia = () => ( {
	matches: false,
	media: '',
	onchange: null,
	addListener() {},
	removeListener() {},
	addEventListener() {},
	removeEventListener() {},
	dispatchEvent: () => false,
} );
dom.window.matchMedia = global.matchMedia;

const blocks = require( '@wordpress/blocks' );
const blockLibrary = require( '@wordpress/block-library' );

blockLibrary.registerCoreBlocks();

/**
 * Resolves a console format string against its arguments.
 *
 * The parser logs a single printf-style message whose %s placeholders carry the
 * expected and actual markup, so the placeholders have to be filled in before
 * the message is useful.
 *
 * @param {unknown[]} args Raw console arguments.
 * @return {string} The resolved message.
 */
function formatLogArgs( args ) {
	if ( ! args.length || typeof args[ 0 ] !== 'string' ) {
		return args.map( String ).join( ' ' );
	}

	const rest = args.slice( 1 );
	let index = 0;

	const message = args[ 0 ].replace( /%[sodifOjc]/g, ( token ) => {
		if ( index >= rest.length ) {
			return token;
		}
		const value = rest[ index++ ];
		if ( token === '%o' || token === '%O' || token === '%j' ) {
			return typeof value === 'object' && value !== null ? '[object]' : String( value );
		}
		return String( value );
	} );

	return [ message, ...rest.slice( index ).map( String ) ].join( ' ' ).trim();
}

/**
 * Runs a function with console output captured rather than printed.
 *
 * The block parser reports every repair it makes through the console, which is
 * the only signal that hand-written markup has drifted from what the editor
 * would save.
 *
 * @param {Function} fn Function to run.
 * @return {{result: *, logs: string[]}} Return value and captured log lines.
 */
function captureConsole( fn ) {
	const methods = [ 'log', 'info', 'warn', 'error', 'debug', 'group', 'groupCollapsed', 'groupEnd' ];
	const original = {};
	const logs = [];

	for ( const method of methods ) {
		original[ method ] = console[ method ];
		console[ method ] = ( ...args ) => {
			logs.push( formatLogArgs( args ) );
		};
	}

	try {
		return { result: fn(), logs };
	} finally {
		Object.assign( console, original );
	}
}

module.exports = { blocks, captureConsole };
