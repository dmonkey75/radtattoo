/**
 * Get images from Instagram
 *
 * @package ThemeREX Addons
 * @since v1.85.1
 */

/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

(function() {

	"use strict";
	
	jQuery(document).on('action.init_hidden_elements', function() {

		jQuery('.widget_instagram_images[data-instagram-load="1"]:not(.widget_instagram_loader_inited)').each( function() {

			var wrap = jQuery(this).addClass('widget_instagram_loader_inited'),
				hash = wrap.data('instagram-hash'),
				hashtag = wrap.data('instagram-hashtag');
			if ( hash && hashtag ) {
				jQuery
					.get( 'https://www.instagram.com/' + ( hashtag.substring(0, 1) != '#'
															? hashtag.toLowerCase()
															: 'explore/tags/' + hashtag.substring(1)
															)
														+ '/'
						)
					.done( function( output ) {
						if ( output ) {
							jQuery.post(
								TRX_ADDONS_STORAGE['ajax_url'],
								{
									'action': 'trx_addons_instagram_load_images',
									'nonce': TRX_ADDONS_STORAGE['ajax_nonce'],
									'output': output,
									'hash': hash
								},
								function(response) {
									var rez = {};
									try {
										rez = JSON.parse(response);
									} catch (e) {
										rez = { error: TRX_ADDONS_STORAGE['msg_ajax_error'] };
										console.log(response);
									}
									if (rez.error === '') {
										var parent = wrap.parent();
										parent.html( jQuery( rez.data ).find('.widget_instagram_images') );
										// To prevent recursive calls
										parent
											.find('.widget_instagram_images[data-instagram-load="1"]:not(.widget_instagram_loader_inited)')
											.addClass('widget_instagram_loader_inited');
									}
								}
							);
						}
					} );
			}

		} );

	} );

})();