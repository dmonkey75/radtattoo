<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nelson_essential_grid_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'nelson_essential_grid_theme_setup9', 9 );
	function nelson_essential_grid_theme_setup9() {
		if ( nelson_exists_essential_grid() ) {
			add_action( 'wp_enqueue_scripts', 'nelson_essential_grid_frontend_scripts', 1100 );
			add_filter( 'nelson_filter_merge_styles', 'nelson_essential_grid_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'nelson_filter_tgmpa_required_plugins', 'nelson_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nelson_essential_grid_tgmpa_required_plugins' ) ) {
		function nelson_essential_grid_tgmpa_required_plugins( $list = array() ) {
		if ( nelson_storage_isset( 'required_plugins', 'essential-grid' ) && nelson_storage_get_array( 'required_plugins', 'essential-grid', 'install' ) !== false && nelson_is_theme_activated() ) {
			$path = nelson_get_plugin_source_path( 'plugins/essential-grid/essential-grid.zip' );
			if ( ! empty( $path ) || nelson_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => nelson_storage_get_array( 'required_plugins', 'essential-grid', 'title' ),
					'slug'     => 'essential-grid',
					'source'   => ! empty( $path ) ? $path : 'upload://essential-grid.zip',
					'version'  => '3.0.11',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'nelson_exists_essential_grid' ) ) {
	function nelson_exists_essential_grid() {
		return defined( 'ESG_PLUGIN_PATH' ) || defined( 'EG_PLUGIN_PATH' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'nelson_essential_grid_frontend_scripts' ) ) {
		function nelson_essential_grid_frontend_scripts() {
		if ( nelson_is_on( nelson_get_theme_option( 'debug_mode' ) ) ) {
			$nelson_url = nelson_get_file_url( 'plugins/essential-grid/essential-grid.css' );
			if ( '' != $nelson_url ) {
				wp_enqueue_style( 'nelson-essential-grid', $nelson_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'nelson_essential_grid_merge_styles' ) ) {
		function nelson_essential_grid_merge_styles( $list ) {
		$list[] = 'plugins/essential-grid/essential-grid.css';
		return $list;
	}
}

