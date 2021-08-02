/* global jQuery:false */
/* global NELSON_STORAGE:false */

jQuery( document ).ready( function() {

	"use strict";

	// Switch an active skin
	jQuery( '#trx_addons_theme_panel_section_skins a.trx_addons_image_block_link_choose_skin' ).on(
		'click', function(e) {
			var link = jQuery( this );
			trx_addons_msgbox_confirm(
				NELSON_STORAGE['msg_switch_skin'],
				NELSON_STORAGE['msg_switch_skin_caption'],
				function(btn) {
					if ( btn != 1 ) return;
					nelson_skins_action( 'switch', link.data( 'skin' ) );
				}
			);
			e.preventDefault();
			return false;
		}
	);

	// Download a free skin
	jQuery( '#trx_addons_theme_panel_section_skins a.trx_addons_image_block_link_download_skin' ).on(
		'click', function(e) {
			var link = jQuery( this );
			trx_addons_msgbox_confirm(
				NELSON_STORAGE['msg_download_skin'],
				NELSON_STORAGE['msg_download_skin_caption'],
				function(btn) {
					if ( btn != 1 ) return;
					nelson_skins_action( 'download', link.data( 'skin' ) );
				}
			);
			e.preventDefault();
			return false;
		}
	);

	// Download a prepaid skin
	jQuery( '#trx_addons_theme_panel_section_skins a.trx_addons_image_block_link_buy_skin' ).on(
		'click', function(e) {
			var link = jQuery( this );
			trx_addons_msgbox_dialog(
				'<p>' + NELSON_STORAGE['msg_buy_skin'].replace('#', link.data('buy')) + '</p>'
				+ '<p><label><input class="nelson_skin_code" type="text" placeholder="' + NELSON_STORAGE['msg_buy_skin_placeholder'] + '"></label></p>',
				NELSON_STORAGE['msg_buy_skin_caption'],
				null,
				function(btn, dialog) {
					if ( btn != 1 ) return;
					nelson_skins_action( 'buy', link.data( 'skin' ), dialog.find('.nelson_skin_code').val() );
				}
			);
			e.preventDefault();
			return false;
		}
	);

	// Update skin
	jQuery( '#trx_addons_theme_panel_section_skins a.trx_addons_image_block_link_update_skin' ).on(
		'click', function(e) {
			var link = jQuery( this );
			trx_addons_msgbox_confirm(
				NELSON_STORAGE['msg_update_skin'],
				NELSON_STORAGE['msg_update_skin_caption'],
				function(btn) {
					if ( btn != 1 ) return;
					nelson_skins_action( 'update', link.data( 'skin' ) );
				}
			);
			e.preventDefault();
			return false;
		}
	);


	// Callback when skin is loaded successful
	function nelson_skins_action( action, skin, code ){
		jQuery.post(
			NELSON_STORAGE['ajax_url'], {
				'action': 'nelson_'+action+'_skin',
				'skin': skin,
				'code': code === undefined ? '' : code,
				'nonce': NELSON_STORAGE['ajax_nonce']
			},
			function(response){
				var rez = {};
				if (response === '' || response === 0) {
					rez = { error: NELSON_STORAGE['msg_ajax_error'] };
				} else {
					try {
						rez = JSON.parse( response );
					} catch (e) {
						rez = { error: NELSON_STORAGE['msg_ajax_error'] };
						console.log( response );
					}
				}
				// Show result
				if ( rez.error ) {
					trx_addons_msgbox_warning( rez.error, NELSON_STORAGE['msg_'+action+'_skin_error_caption'] );
				} else {
					trx_addons_msgbox_success( NELSON_STORAGE['msg_'+action+'_skin_success'], NELSON_STORAGE['msg_'+action+'_skin_success_caption'] );
				}
				// Reload current page after the skin is switched (if success)
				if (rez.error === '') {
					if (jQuery('.trx_addons_theme_panel').length > 0) {
						if (jQuery('.trx_addons_theme_panel .trx_addons_tabs').hasClass('trx_addons_panel_wizard')) {
							trx_addons_set_cookie('trx_addons_theme_panel_wizard_section', 'trx_addons_theme_panel_section_skins');
						} else {
							if ( location.hash != 'trx_addons_theme_panel_section_skins' ) {
								nelson_document_set_location( location.href.split('#')[0] + '#' + 'trx_addons_theme_panel_section_skins' );
							}
						}
						location.reload( true );
					}
				}
			}
		);
	}

} );
