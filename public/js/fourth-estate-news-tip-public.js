(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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

	$( document ).on( 'click', '.open-news-tip-modal', function(e) {
		e.preventDefault();
		$( '.news-tip-modal' ).show();
	});
	$( document ).on( 'click', 'a.news-tip-close', function(e) {
		e.preventDefault();
		$( '.news-tip-modal' ).hide();
	});
	$( document ).on( 'click', '.news-tip-tabs li.tab-menu a', function(e) {
		e.preventDefault();
		var targetTabContent = $( this ).data( 'target' );
		$( '.tab-content' ).hide();
		$( '.news-tip-tabs li.tab-menu' ).removeClass( 'active' );
		$( targetTabContent ).show();
		$( this ).parent().addClass( 'active' );
	});

	$( document ).on('submit', '#news-tip-form', function(e) {
		e.preventDefault();
		var data = {
			'action': 'send_news_tip',
			'message': $('textarea#message').val(),
			'full_name': $('input#full_name').val(),
			'email': $('input#email').val(),
		};
		$.post(newstip.admin_ajax, data, function(response) {
			console.log(response);
		});
	});

})( jQuery );
