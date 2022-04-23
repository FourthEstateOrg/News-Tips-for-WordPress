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

	window.onloadCallback = function() {
		window.news_tip_captcha = grecaptcha.render('news-tip-captcha', {
			'sitekey' : newstip.site_key,
		});
	};


	 var submitButton = '.online-form-container button[type="submit"]';

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
		
		showFormLoadingState();
		
		clearErrors();

		var data = new FormData(this);

		if ( newstip.is_v3 == "1" ) {
			grecaptcha.ready(function() {
				grecaptcha.execute(newstip.site_key, {action: 'submit'}).then(function(token) {
					data.append('g-recaptcha-response', token)
					sendForm( data );
				});
			});
		} else {
			sendForm( data );
		}
	});

	function sendForm( data ) {
		$.ajax({
			url: newstip.admin_ajax,
			type:"POST",
			processData: false,
			contentType: false,
			data:  data,
			success: function(response) {
				setTimeout(function() {
					response = JSON.parse( response );
					if ( response.success == 0 ) {
						if ( response.errors ) {
							console.log(response.errors)
							for ( var error in response.errors ) {
								if ( error == 'g-recaptcha-response' ) {
									$('div#news-tip-captcha iframe').css('border', '1px solid red' );
									$('div#news-tip-captcha').append('<span class="error-message">' + response.errors[error] + '</span>');
								} else {
									var field = $("#" + error);
									field.parent().addClass('has-error');
									field.parent().append('<span class="error-message">' + response.errors[error] + '</span>')
								}
							}
						}
					} else {
						$('div#online-form').append('<span class="news-tip-notice success">Tip Sent Successfully!<br />Please use the tracking number <strong>' + response.tracking_id + '</strong> when communicating with us about your news tip.</span>');
						$('.online-form-container').hide();
					}
					
					hideFormLoadingState();
				}, 2000);
			}
		});
	}

	function clearErrors() {
		$('.nt-form-group.has-error .error-message').remove();
		$('.nt-form-group.has-error').removeClass('has-error');
		$('div#news-tip-captcha iframe').css('border', 'none' );
		$('div#news-tip-captcha .error-message').remove();
	}

	function showFormLoadingState() {
		$(submitButton).attr('disabled', true);
		$(submitButton).addClass('loading');
	}

	function hideFormLoadingState() {
		$(submitButton).attr('disabled', false);
		$(submitButton).removeClass('loading');
	}
})( jQuery );
