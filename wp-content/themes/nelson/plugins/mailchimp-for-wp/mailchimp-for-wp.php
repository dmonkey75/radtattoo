<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nelson_mailchimp_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'nelson_mailchimp_theme_setup9', 9 );
	function nelson_mailchimp_theme_setup9() {
		if ( nelson_exists_mailchimp() ) {
			add_action( 'wp_enqueue_scripts', 'nelson_mailchimp_frontend_scripts', 1100 );
			add_filter( 'nelson_filter_merge_styles', 'nelson_mailchimp_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'nelson_filter_tgmpa_required_plugins', 'nelson_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nelson_mailchimp_tgmpa_required_plugins' ) ) {
		function nelson_mailchimp_tgmpa_required_plugins( $list = array() ) {
		if ( nelson_storage_isset( 'required_plugins', 'mailchimp-for-wp' ) && nelson_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'install' ) !== false ) {
			$list[] = array(
				'name'     => nelson_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'title' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'nelson_exists_mailchimp' ) ) {
	function nelson_exists_mailchimp() {
		return function_exists( '__mc4wp_load_plugin' ) || defined( 'MC4WP_VERSION' );
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue styles for frontend
if ( ! function_exists( 'nelson_mailchimp_frontend_scripts' ) ) {
		function nelson_mailchimp_frontend_scripts() {
		if ( nelson_is_on( nelson_get_theme_option( 'debug_mode' ) ) ) {
			$nelson_url = nelson_get_file_url( 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' );
			if ( '' != $nelson_url ) {
				wp_enqueue_style( 'nelson-mailchimp', $nelson_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'nelson_mailchimp_merge_styles' ) ) {
		function nelson_mailchimp_merge_styles( $list ) {
		$list[] = 'plugins/mailchimp-for-wp/mailchimp-for-wp.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( nelson_exists_mailchimp() ) {
	require_once NELSON_THEME_DIR . 'plugins/mailchimp-for-wp/mailchimp-for-wp-styles.php'; }

