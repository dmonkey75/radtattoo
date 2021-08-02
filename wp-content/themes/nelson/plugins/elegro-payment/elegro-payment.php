<?php
/* Elegro Crypto Payment support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nelson_elegro_payment_theme_setup9' ) ) {
    add_action( 'after_setup_theme', 'nelson_elegro_payment_theme_setup9', 9 );
    function nelson_elegro_payment_theme_setup9() {
        if ( nelson_exists_elegro_payment() ) {
			add_action( 'wp_enqueue_scripts', 'nelson_elegro_payment_frontend_scripts', 1100 );
            add_filter( 'nelson_filter_merge_styles', 'nelson_elegro_payment_merge_styles' );
        }
        if ( is_admin() ) {
            add_filter( 'nelson_filter_tgmpa_required_plugins', 'nelson_elegro_payment_tgmpa_required_plugins' );
        }
    }
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nelson_elegro_payment_tgmpa_required_plugins' ) ) {

    function nelson_elegro_payment_tgmpa_required_plugins( $list = array() ) {
        if ( nelson_storage_isset( 'required_plugins', 'elegro-payment' ) && nelson_storage_get_array( 'required_plugins', 'elegro-payment', 'install' ) !== false ) {
            // Elegro plugin
            $list[] = array(
                'name'     => nelson_storage_get_array( 'required_plugins', 'elegro-payment', 'title' ),
                'slug'     => 'elegro-payment',
                'required' => false,
            );

        }
        return $list;
    }
}

// Check if this plugin installed and activated
if ( ! function_exists( 'nelson_exists_elegro_payment' ) ) {
    function nelson_exists_elegro_payment() {
        return class_exists( 'WC_Elegro_Payment' );
    }
}


// Enqueue styles for frontend
if ( ! function_exists( 'nelson_elegro_payment_frontend_scripts' ) ) {
	function nelson_elegro_payment_frontend_scripts() {
	if ( nelson_is_on( nelson_get_theme_option( 'debug_mode' ) ) ) {
		$nelson_url = nelson_get_file_url( 'plugins/elegro-payment/elegro-payment.css' );
		if ( '' != $nelson_url ) {
			wp_enqueue_style( 'elegro-payment', $nelson_url, array(), null );
		}
	}
}
}

// Merge custom styles
if ( ! function_exists( 'nelson_elegro_payment_merge_styles' ) ) {
	function nelson_elegro_payment_merge_styles( $list ) {
	$list[] = 'plugins/elegro-payment/elegro-payment.css';
	return $list;
}
}