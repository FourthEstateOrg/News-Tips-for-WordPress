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
		$( '.online-form-container' ).show();
		$( '.news-tip-notice' ).remove();
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
		var submitButton = $(this).find('button');
		submitButton.attr('disabled', true);
		submitButton.addClass('loading');

		var data = {
			'action': 'send_news_tip',
			'message': $('textarea#message').val(),
			'full_name': $('input#full_name').val(),
			'email': $('input#email').val(),
			'contact_number': $('input#contact_number').val(),
		};
		$.post(newstip.admin_ajax, data, function(response) {
			setTimeout(function() {
				$('div#online-form').append('<span class="news-tip-notice success">Tip Sent Successfully!</span>');
				$('.online-form-container').hide();
				submitButton.attr('disabled', false);
				submitButton.removeClass('loading');
			}, 2000);
		});
	});

})( jQuery );
