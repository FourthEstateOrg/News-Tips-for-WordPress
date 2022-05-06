(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$( document ).ready( function() {
		$('#pane-fourth-estate-news-tip-settings-section').show();
		$('nav.nav-section ul li:first-of-type a').addClass('active');
	} );

	$( document ).on( 'click', 'a.setting-pane-trigger', function( e ) {
		var target = $( this ).data( 'target' );
		e.preventDefault();
		$( '.section-pane' ).hide();
		$( 'a.setting-pane-trigger' ).removeClass( 'active' ); 

		$( target ).show();
		$( this ).addClass( 'active' )
	} );

})( jQuery );
