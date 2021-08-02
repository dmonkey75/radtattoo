<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nelson_revslider_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'nelson_revslider_theme_setup9', 9 );
	function nelson_revslider_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'nelson_filter_tgmpa_required_plugins', 'nelson_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nelson_revslider_tgmpa_required_plugins' ) ) {
		function nelson_revslider_tgmpa_required_plugins( $list = array() ) {
		if ( nelson_storage_isset( 'required_plugins', 'revslider' ) && nelson_storage_get_array( 'required_plugins', 'revslider', 'install' ) !== false && nelson_is_theme_activated() ) {
			$path = nelson_get_plugin_source_path( 'plugins/revslider/revslider.zip' );
			if ( ! empty( $path ) || nelson_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => nelson_storage_get_array( 'required_plugins', 'revslider', 'title' ),
					'slug'     => 'revslider',
					'source'   => ! empty( $path ) ? $path : 'upload://revslider.zip',
					'version'  => '6.3.6',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( ! function_exists( 'nelson_exists_revslider' ) ) {
	function nelson_exists_revslider() {
		return function_exists( 'rev_slider_shortcode' );
	}
}
