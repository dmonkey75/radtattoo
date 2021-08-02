<?php
/**
 * Skins support: Main skin file for the skin 'Default'
 *
 * Setup skin-dependent fonts and colors, load scripts and styles,
 * and other operations that affect the appearance and behavior of the theme
 * when the skin is activated
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.46
 */


// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'nelson_skin_theme_setup3' ) ) {
	add_action( 'after_setup_theme', 'nelson_skin_theme_setup3', 3 );
	function nelson_skin_theme_setup3() {
		// ToDo: Add / Modify theme options, color schemes, required plugins, etc.
	}
}

// Filter to add in the required plugins list
// Priority 11 to add new plugins to the end of the list
if ( ! function_exists( 'nelson_skin_tgmpa_required_plugins' ) ) {
	add_filter( 'nelson_filter_tgmpa_required_plugins', 'nelson_skin_tgmpa_required_plugins', 11 );
	function nelson_skin_tgmpa_required_plugins( $list = array() ) {
		// ToDo: Check if plugin is in the 'required_plugins' and add his parameters to the TGMPA-list
		//       Replace 'skin-specific-plugin-slug' to the real slug of the plugin
		if ( nelson_storage_isset( 'required_plugins', 'skin-specific-plugin-slug' ) ) {
			$list[] = array(
				'name'     => nelson_storage_get_array( 'required_plugins', 'skin-specific-plugin-slug', 'title' ),
				'slug'     => 'skin-specific-plugin-slug',
				'required' => false,
			);
		}
		return $list;
	}
}

// Enqueue skin-specific styles and scripts
// Priority 1150 - after plugins-specific (1100), but before child theme (1500)
if ( ! function_exists( 'nelson_skin_frontend_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'nelson_skin_frontend_scripts', 1150 );
	function nelson_skin_frontend_scripts() {
		$nelson_url = nelson_get_file_url( NELSON_SKIN_DIR . 'skin.css' );
		if ( '' != $nelson_url ) {
			wp_enqueue_style( 'nelson-skin-' . esc_attr( NELSON_SKIN_NAME ), $nelson_url, array(), null );
		}
		if ( nelson_is_on( nelson_get_theme_option( 'debug_mode' ) ) ) {
			$nelson_url = nelson_get_file_url( NELSON_SKIN_DIR . 'skin.js' );
			if ( '' != $nelson_url ) {
				wp_enqueue_script( 'nelson-skin-' . esc_attr( NELSON_SKIN_NAME ), $nelson_url, array( 'jquery' ), null, true );
			}
		}
	}
}

// Enqueue skin-specific responsive styles
// Priority 2150 - after theme responsive 2000
if ( ! function_exists( 'nelson_skin_styles_responsive' ) ) {
	add_action( 'wp_enqueue_scripts', 'nelson_skin_styles_responsive', 2150 );
	function nelson_skin_styles_responsive() {
		$nelson_url = nelson_get_file_url( NELSON_SKIN_DIR . 'skin-responsive.css' );
		if ( '' != $nelson_url ) {
			wp_enqueue_style( 'nelson-skin-' . esc_attr( NELSON_SKIN_NAME ) . '-responsive', $nelson_url, array(), null );
		}
	}
}

// Merge custom scripts
if ( ! function_exists( 'nelson_skin_merge_scripts' ) ) {
	add_filter( 'nelson_filter_merge_scripts', 'nelson_skin_merge_scripts' );
	function nelson_skin_merge_scripts( $list ) {
		if ( nelson_get_file_dir( NELSON_SKIN_DIR . 'skin.js' ) != '' ) {
			$list[] = NELSON_SKIN_DIR . 'skin.js';
		}
		return $list;
	}
}

// Set theme specific importer options
if (
	false &&
	! function_exists( 'nelson_skin_importer_set_options' ) ) {
	add_filter('trx_addons_filter_importer_options', 'nelson_skin_importer_set_options', 9);
	function nelson_skin_importer_set_options($options = array()) {
		if ( is_array( $options ) ) {
			$options['demo_type'] = 'skin_slug';
			$options['files']['skin_slug'] = $options['files']['default'];
			$options['files']['skin_slug']['title'] = esc_html__('Skin Title Demo', 'nelson');
			$options['files']['skin_slug']['domain_dev'] = esc_url( nelson_get_protocol() . '://skin_slug.theme_slug.themerex.dnw' );    // Developers domain
			$options['files']['skin_slug']['domain_demo'] = esc_url( nelson_get_protocol() . '://skin_slug.theme_slug.themerex.net' );   // Demo-site domain
			unset($options['files']['default']);
		}
		return $options;
	}
}

// Add slin-specific colors and fonts to the custom CSS
require_once NELSON_THEME_DIR . NELSON_SKIN_DIR . 'skin-styles.php';
