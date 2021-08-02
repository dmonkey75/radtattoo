<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nelson_booked_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'nelson_booked_theme_setup9', 9 );
	function nelson_booked_theme_setup9() {
		if ( nelson_exists_booked() ) {
			add_action( 'wp_enqueue_scripts', 'nelson_booked_frontend_scripts', 1100 );
			add_filter( 'nelson_filter_merge_styles', 'nelson_booked_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'nelson_filter_tgmpa_required_plugins', 'nelson_booked_tgmpa_required_plugins' );
			add_filter( 'nelson_filter_theme_plugins', 'nelson_booked_theme_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nelson_booked_tgmpa_required_plugins' ) ) {
		function nelson_booked_tgmpa_required_plugins( $list = array() ) {
		if ( nelson_storage_isset( 'required_plugins', 'booked' ) && nelson_storage_get_array( 'required_plugins', 'booked', 'install' ) !== false && nelson_is_theme_activated() ) {
			$path = nelson_get_plugin_source_path( 'plugins/booked/booked.zip' );
			if ( ! empty( $path ) || nelson_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => nelson_storage_get_array( 'required_plugins', 'booked', 'title' ),
					'slug'     => 'booked',
					'source'   => ! empty( $path ) ? $path : 'upload://booked.zip',
					'version'  => '2.3',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Filter theme-supported plugins list
if ( ! function_exists( 'nelson_booked_theme_plugins' ) ) {
		function nelson_booked_theme_plugins( $list = array() ) {
		if ( ! empty( $list['booked']['group'] ) ) {
			foreach ( $list as $k => $v ) {
				if ( substr( $k, 0, 6 ) == 'booked' ) {
					if ( empty( $v['group'] ) ) {
						$list[ $k ]['group'] = $list['booked']['group'];
					}
					if ( ! empty( $list['booked']['logo'] ) ) {
						$list[ $k ]['logo'] = strpos( $list['booked']['logo'], '//' ) !== false
												? $list['booked']['logo']
												: nelson_get_file_url( "plugins/booked/{$list['booked']['logo']}" );
					}
				}
			}
		}
		return $list;
	}
}



// Check if plugin installed and activated
if ( ! function_exists( 'nelson_exists_booked' ) ) {
	function nelson_exists_booked() {
		return class_exists( 'booked_plugin' );
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'nelson_booked_frontend_scripts' ) ) {
		function nelson_booked_frontend_scripts() {
		if ( nelson_is_on( nelson_get_theme_option( 'debug_mode' ) ) ) {
			$nelson_url = nelson_get_file_url( 'plugins/booked/booked.css' );
			if ( '' != $nelson_url ) {
				wp_enqueue_style( 'nelson-booked', $nelson_url, array(), null );
			}
		}
	}
}


// Merge custom styles
if ( ! function_exists( 'nelson_booked_merge_styles' ) ) {
		function nelson_booked_merge_styles( $list ) {
		$list[] = 'plugins/booked/booked.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( nelson_exists_booked() ) {
	require_once NELSON_THEME_DIR . 'plugins/booked/booked-styles.php';
}
