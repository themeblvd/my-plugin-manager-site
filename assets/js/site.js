(function( $ ) {

	"use strict";

	if ( 'undefined' !== typeof hljs ) {
		hljs.configure( {
			// useBR: true,
			languages: ['php']
		} );
	}

	$( document ).ready( function() {

		var $downloadSection = $( '#download' ),
			$downloadForm    = $downloadSection.find( 'form' ),
			$downloadButton  = $downloadForm.find( '.btn-primary' ),
			$codeSection     = $downloadSection.next( '.section-code' ),
			$codeBlock       = $codeSection.find( '.code-block pre' );

		/**
		 * Add code syntax highlighting to documentation.
		 */
		$( '.docs-code-block' ).each( function( i, block ) {

			if ( 'undefined' === typeof hljs ) {
				return;
			}

			hljs.highlightBlock( block );

		} );

		/**
		 * Adjust fields based on the usage type selected
		 * by the user.
		 */
		$downloadForm.find( '.field-type select' ).on( 'change', function() {

			var text  = '',
				value = $( this ).val();

			switch ( value ) {

				case 'child-theme' :
					text = 'Child Theme Name';
					break;

				case 'plugin' :
					text = 'Plugin Name';
					break;

				default :
					text = 'Theme Name';

			}

			$downloadForm.find( '.field-name label' ).text( text );

			$downloadForm.find( '.help-text' ).each( function() {

				var $element = $( this ),
					desc     = $element.html(),
					find     = 'plugin' === value ? 'theme' : 'plugin',
					find     = new RegExp( find, "g" ),
					replace  = 'plugin' === value ? 'plugin' : 'theme';

				$element.html( desc.replace( find, replace ) );

			} );

		} );

		/**
		 * After a code block is displayed, handle the action
		 * for resetting everything.
		 */
		$codeSection.on( 'click', '.code-reset', function( event ) {

			event.preventDefault();

			$codeSection.slideUp( 500 );

			$('html, body').animate( {
				scrollTop: $downloadSection.offset().top
			}, 500 );

			$codeSection.find( '.code-explain' ).html( '' );

			$codeBlock.html( '' );

			$downloadForm.find( 'input' ).val( '' );

			$downloadForm.find( 'select' ).val( 'theme' );

		} );

		/**
		 * Handles form submission.
		 */
		$downloadForm.on( 'submit', function( event ) {

			event.preventDefault();

			var ajaxurl          = '/inc/ajax.php',
				error            = null,
				args             = {
					action: 'download',
					type: $downloadForm.find( '[name="type"]' ).val(),
					name: $downloadForm.find( '[name="name"]' ).val(),
					namespace: $downloadForm.find( '[name="namespace"]' ).val(),
					text_domain: $downloadForm.find( '[name="text-domain"]' ).val()
				};

			// Form validation.
			$downloadForm.find( '.alert' ).remove();

			if ( ! args.name ) {
				error = error || {};
				error.name = 'Please enter a name for your project.';
			}

			if ( ! args.namespace ) {
				error = error || {};
				error.namespace = 'Please enter a namespace for your project';
			}

			if ( ! args.text_domain ) {
				error = error || {};
				error.text_domain = 'Please enter a text domain for your project.';
			}

			if ( error ) {

				for ( var prop in error ) {

					$downloadForm
						.find( '.field-' + prop )
						.append( '<div class="alert alert-danger" style="display:none;">' + error[prop] + '</div>' )
						.find( '.alert' )
						.fadeIn( 200 );

				}

				return;
			}

			// Tell user it's loading.
			$downloadButton.text( 'Building package and instructions...' );

			// Form is good. Wait 1 second and then send data to generate package.
			setTimeout( function() {

				$.post( ajaxurl, args, function( response ) {

					// console.log(response);

					var formSuccess = '',
						names       = [],
						isJSON      = true,
						action      = 'success.php';

					try {
						response = $.parseJSON( response) ;
					} catch( error ) {
						isJSON = false;
					}

					if ( isJSON ) {

						console.log( response );

						$downloadButton.text( 'Generate and Download' );

						$codeSection.find( '.code-explain' ).html( response.codeExplain );

						$codeBlock.html( response.codeExample );

						$codeBlock.each( function( i, block ) {
							hljs.highlightBlock( block );
						} );

						$codeSection.slideDown( 500 );

						$('html, body').animate( {
							scrollTop: $codeSection.offset().top
						}, 500 );

						window.location = response.zipURL;

					}

				} );

			}, 1000 );

		} );

		/**
		 * Toggle main menu on mobile.
		 */
		$( '.fs-menu-toggle' ).on( 'click', function( event ) {

			event.preventDefault();

			var $button = $(this);

			if ( $button.hasClass( 'collapse' ) ) {

			    $button
					.removeClass( 'collapse' )
					.closest( '.site-header' )
					.find( '.site-follow, .site-menu' )
					.removeClass( 'show' );

			} else {

				$button
					.addClass( 'collapse' )
					.closest( '.site-header' )
					.find( '.site-follow, .site-menu' )
					.addClass( 'show' );

			}

		} );

	} ); // End $document.ready()

})( jQuery );
