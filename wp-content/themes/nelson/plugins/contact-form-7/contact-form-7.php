<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nelson_cf7_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'nelson_cf7_theme_setup9', 9 );
	function nelson_cf7_theme_setup9() {
		if ( nelson_exists_cf7() ) {
			add_action( 'wp_enqueue_scripts', 'nelson_cf7_frontend_scripts', 1100 );
			add_filter( 'nelson_filter_merge_scripts', 'nelson_cf7_merge_scripts' );
		}
		if ( is_admin() ) {
			add_filter( 'nelson_filter_tgmpa_required_plugins', 'nelson_cf7_tgmpa_required_plugins' );
			add_filter( 'nelson_filter_theme_plugins', 'nelson_cf7_theme_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nelson_cf7_tgmpa_required_plugins' ) ) {
		function nelson_cf7_tgmpa_required_plugins( $list = array() ) {
		if ( nelson_storage_isset( 'required_plugins', 'contact-form-7' ) && nelson_storage_get_array( 'required_plugins', 'contact-form-7', 'install' ) !== false ) {
			// CF7 plugin
			$list[] = array(
				'name'     => nelson_storage_get_array( 'required_plugins', 'contact-form-7', 'title' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			);
		}
		return $list;
	}
}

// Filter theme-supported plugins list
if ( ! function_exists( 'nelson_cf7_theme_plugins' ) ) {
		function nelson_cf7_theme_plugins( $list = array() ) {
		if ( ! empty( $list['contact-form-7']['group'] ) ) {
			foreach ( $list as $k => $v ) {
				if ( substr( $k, 0, 15 ) == 'contact-form-7-' ) {
					if ( empty( $v['group'] ) ) {
						$list[ $k ]['group'] = $list['contact-form-7']['group'];
					}
					if ( ! empty( $list['contact-form-7']['logo'] ) ) {
						$list[ $k ]['logo'] = strpos( $list['contact-form-7']['logo'], '//' ) !== false
												? $list['contact-form-7']['logo']
												: nelson_get_file_url( "plugins/contact-form-7/{$list['contact-form-7']['logo']}" );
					}
				}
			}
		}
		return $list;
	}
}

// Check if cf7 installed and activated
if ( ! function_exists( 'nelson_exists_cf7' ) ) {
	function nelson_exists_cf7() {
		return class_exists( 'WPCF7' );
	}
}

// Enqueue custom scripts
if ( ! function_exists( 'nelson_cf7_frontend_scripts' ) ) {
		function nelson_cf7_frontend_scripts() {
		if ( nelson_is_on( nelson_get_theme_option( 'debug_mode' ) ) ) {
			$nelson_url = nelson_get_file_url( 'plugins/contact-form-7/contact-form-7.js' );
			if ( '' != $nelson_url ) {
				wp_enqueue_script( 'nelson-cf7', $nelson_url, array( 'jquery' ), null, true );
			}
		}
	}
}

// Merge custom scripts
if ( ! function_exists( 'nelson_cf7_merge_scripts' ) ) {
		function nelson_cf7_merge_scripts( $list ) {
		$list[] = 'plugins/contact-form-7/contact-form-7.js';
		return $list;
	}
}
