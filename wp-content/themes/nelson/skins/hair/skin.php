<?php
/**
 * Skins support: Main skin file for the skin 'Hair Salon'
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

		nelson_storage_set(

			'schemes', array(

				// Color scheme: 'dark'
				'dark'    => array(
					'title'    => esc_html__( 'Dark', 'nelson' ),
					'internal' => true,
					'colors'   => array(

						// Whole block border and background
						'bg_color'         => '#0c1011',//
						'bd_color'         => '#3b4146',//

						// Text and links colors
						'text'             => '#798a8a',//
						'text_light'       => '#9e49a3',//
						'text_dark'        => '#ffffff',//
						'text_link'        => '#659498',//
						'text_hover'       => '#ffffff',//
						'text_link2'       => '#9e49a3',//
						'text_hover2'      => '#0c1011',//
						'text_link3'       => '#ffffff',//
						'text_hover3'      => '#2c2c2c',//

						// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
						'alter_bg_color'   => '#1d2223',//
						'alter_bg_hover'   => '#131718',//
						'alter_bd_color'   => '#3b4146',//
						'alter_bd_hover'   => '#4a4a4a',
						'alter_text'       => '#798a8a',//
						'alter_light'      => '#798a8a',//
						'alter_dark'       => '#ffffff',//
						'alter_link'       => '#659498',//
						'alter_hover'      => '#ffffff',//
						'alter_link2'      => '#2c2c2c',//
						'alter_hover2'     => '#80d572',
						'alter_link3'      => '#eec432',
						'alter_hover3'     => '#ddb837',

						// Extra blocks (submenu, tabs, color blocks, etc.)
						'extra_bg_color'   => '#1d2223',//
						'extra_bg_hover'   => '#1d2223',
						'extra_bd_color'   => '#3b4146',//
						'extra_bd_hover'   => '#3b4146',
						'extra_text'       => '#798a8a',//
						'extra_light'      => '#798a8a',//
						'extra_dark'       => '#ffffff',//
						'extra_link'       => '#659498',//
						'extra_hover'      => '#e1e1e1',//
						'extra_link2'      => '#659498',//
						'extra_hover2'     => '#e1e1e1',//
						'extra_link3'      => '#9e49a3',//
						'extra_hover3'     => '#ffffff',//

						// Input fields (form's fields and textarea)
						'input_bg_color'   => '#0c1011',//
						'input_bg_hover'   => '#0c1011',//
						'input_bd_color'   => '#3b4146',//
						'input_bd_hover'   => '#3b4146',//
						'input_text'       => '#ffffff',//
						'input_light'      => '#6f6f6f',
						'input_dark'       => '#ffffff',//

						// Inverse blocks (text and links on the 'text_link' background)
						'inverse_bd_color' => '#262626',//
						'inverse_bd_hover' => '#cb5b47',
						'inverse_text'     => '#798a8a',//
						'inverse_light'    => '#1d2223',//
						'inverse_dark'     => '#659498',//
						'inverse_link'     => '#ffffff',//
						'inverse_hover'    => '#9e49a3',//
					),
				),

				// Color scheme: 'default'
				'default' => array(
					'title'    => esc_html__( 'Default', 'nelson' ),
					'internal' => true,
					'colors'   => array(

						// Whole block border and background
						'bg_color'         => '#ffffff',//
						'bd_color'         => '#e1e1e1',//

						// Text and links colors
						'text'             => '#8d8d8d',//
						'text_light'       => '#8d8d8d',//
						'text_dark'        => '#2c2c2c',//
						'text_link'        => '#9e49a3',//
						'text_hover'       => '#2c2c2c',//
						'text_link2'       => '#9e49a3',//
						'text_hover2'      => '#9e49a3',//
						'text_link3'       => '#2c2c2c',//
						'text_hover3'      => '#ffffff',//

						// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
						'alter_bg_color'   => '#f2f2f2',//
						'alter_bg_hover'   => '#eaeaea',//
						'alter_bd_color'   => '#e1e1e1',//
						'alter_bd_hover'   => '#dadada',
						'alter_text'       => '#8d8d8d',//
						'alter_light'      => '#8d8d8d',//
						'alter_dark'       => '#2c2c2c',//
						'alter_link'       => '#9e49a3',//
						'alter_hover'      => '#2c2c2c',//
						'alter_link2'      => '#2c2c2c',//
						'alter_hover2'     => '#9e49a3',
						'alter_link3'      => '#eec432',
						'alter_hover3'     => '#ddb837',

						// Extra blocks (submenu, tabs, color blocks, etc.)
						'extra_bg_color'   => '#f2f2f2',//
						'extra_bg_hover'   => '#ffffff',//
						'extra_bd_color'   => '#e1e1e1',//
						'extra_bd_hover'   => '#3d3d3d',
						'extra_text'       => '#2c2c2c',//
						'extra_light'      => '#8d8d8d',//
						'extra_dark'       => '#2c2c2c',//
						'extra_link'       => '#9e49a3',//
						'extra_hover'      => '#2c2c2c',//
						'extra_link2'      => '#9e49a3',//
						'extra_hover2'     => '#e1e1e1',//
						'extra_link3'      => '#96885f',//
						'extra_hover3'     => '#ffffff',//

						// Input fields (form's fields and textarea)
						'input_bg_color'   => '#ffffff',//
						'input_bg_hover'   => '#e1e1e1',//
						'input_bd_color'   => '#e1e1e1',//
						'input_bd_hover'   => '#e1e1e1',//
						'input_text'       => '#2c2c2c',//
						'input_light'      => '#a7a7a7',
						'input_dark'       => '#2c2c2c',//

						// Inverse blocks (text and links on the 'text_link' background)
						'inverse_bd_color' => '#262626',//
						'inverse_bd_hover' => '#5aa4a9',
						'inverse_text'     => '#8d8d8d',//
						'inverse_light'    => '#f2f2f2',//
						'inverse_dark'     => '#9e49a3',//
						'inverse_link'     => '#2c2c2c',//
						'inverse_hover'    => '#ffffff',//
					),
				),
                // Color scheme: 'second default'
                'second_default' => array(
                    'title'    => esc_html__( 'Second Default', 'nelson' ),
                    'internal' => true,
                    'colors'   => array(

                        // Whole block border and background
                        'bg_color'         => '#ffffff',//
                        'bd_color'         => '#e1e1e1',//

                        // Text and links colors
                        'text'             => '#3F4648',// +
                        'text_light'       => '#8d8d8d',//
                        'text_dark'        => '#0C1011',// +
                        'text_link'        => '#008AB4',// +
                        'text_hover'       => '#2c2c2c',//
                        'text_link2'       => '#008AB4',//
                        'text_hover2'      => '#9e49a3',//
                        'text_link3'       => '#2c2c2c',//
                        'text_hover3'      => '#ffffff',//

                        // Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                        'alter_bg_color'   => '#F4F1EA',// +
                        'alter_bg_hover'   => '#eaeaea',//
                        'alter_bd_color'   => '#e1e1e1',//
                        'alter_bd_hover'   => '#dadada',
                        'alter_text'       => '#8d8d8d',//
                        'alter_light'      => '#8d8d8d',//
                        'alter_dark'       => '#2c2c2c',//
                        'alter_link'       => '#9e49a3',//
                        'alter_hover'      => '#2c2c2c',//
                        'alter_link2'      => '#2c2c2c',//
                        'alter_hover2'     => '#9e49a3',
                        'alter_link3'      => '#eec432',
                        'alter_hover3'     => '#ddb837',

                        // Extra blocks (submenu, tabs, color blocks, etc.)
                        'extra_bg_color'   => '#f2f2f2',//
                        'extra_bg_hover'   => '#ffffff',//
                        'extra_bd_color'   => '#e1e1e1',//
                        'extra_bd_hover'   => '#3B4146', //+
                        'extra_text'       => '#2c2c2c',//
                        'extra_light'      => '#8d8d8d',//
                        'extra_dark'       => '#3B4146',// +
                        'extra_link'       => '#9e49a3',//
                        'extra_hover'      => '#2c2c2c',//
                        'extra_link2'      => '#B18E73',// +
                        'extra_hover2'     => '#e1e1e1',//
                        'extra_link3'      => '#96885f',//
                        'extra_hover3'     => '#ffffff',//

                        // Input fields (form's fields and textarea)
                        'input_bg_color'   => '#ffffff',//
                        'input_bg_hover'   => '#e1e1e1',//
                        'input_bd_color'   => '#e1e1e1',//
                        'input_bd_hover'   => '#e1e1e1',//
                        'input_text'       => '#2c2c2c',//
                        'input_light'      => '#a7a7a7',
                        'input_dark'       => '#2c2c2c',//

                        // Inverse blocks (text and links on the 'text_link' background)
                        'inverse_bd_color' => '#262626',//
                        'inverse_bd_hover' => '#5aa4a9',
                        'inverse_text'     => '#8d8d8d',//
                        'inverse_light'    => '#f2f2f2',//
                        'inverse_dark'     => '#9e49a3',//
                        'inverse_link'     => '#2c2c2c',//
                        'inverse_hover'    => '#ffffff',//
                    ),
                ),

			)
		);

		nelson_storage_set(
			'load_fonts', array(
				// Google font
				array(
					'name'   => 'Montserrat',
					'family' => 'sans-serif',
					'styles' => '100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic',// Parameter 'style' used only for the Google fonts
				),
				// Font-face packed with theme
				array(
					'name'   => 'Gilroy',
					'family' => 'sans-serif',
				),
			)
		);


		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		nelson_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags
		// Attention! Font name in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!

		nelson_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'nelson' ),
					'description'     => esc_html__( 'Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'nelson' ),
					'font-family'     => '"Gilroy",sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.75em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '0em',
					'margin-bottom'   => '0.95em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'nelson' ),
					'font-family'     => '"Gilroy",sans-serif',
					'font-size'       => '5.625rem',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '0.7em',
					'margin-bottom'   => '0.1em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'nelson' ),
					'font-family'     => '"Gilroy",sans-serif',
					'font-size'       => '4.375rem',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '0.92em',
					'margin-bottom'   => '0.3em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'nelson' ),
					'font-family'     => '"Gilroy",sans-serif',
					'font-size'       => '3.125rem',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.1em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '1.15em',
					'margin-bottom'   => '0.35em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'nelson' ),
					'font-family'     => '"Gilroy",sans-serif',
					'font-size'       => '2.187rem',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.142em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '1.37em',
					'margin-bottom'   => '0.5em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'nelson' ),
					'font-family'     => '"Gilroy",sans-serif',
					'font-size'       => '1.562rem',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.35em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '1.58em',
					'margin-bottom'   => '0.5em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'nelson' ),
					'font-family'     => '"Gilroy",sans-serif',
					'font-size'       => '1.125rem',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.875em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '2em',
					'margin-bottom'   => '0.4em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'nelson' ),
					'description'     => esc_html__( 'Font settings of the text case of the logo', 'nelson' ),
					'font-family'     => '"Gilroy",sans-serif',
					'font-size'       => '2.187rem',
					'font-weight'     => '800',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.025em',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'nelson' ),
					'font-family'     => '"Gilroy",sans-serif',
					'font-size'       => '13px',
					'font-weight'     => '800',
					'font-style'      => 'normal',
					'line-height'     => '20px',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.05em',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'nelson' ),
					'description'     => esc_html__( 'Font settings of the input fields, dropdowns and textareas', 'nelson' ),
					'font-family'     => 'inherit',
					'font-size'       => '14px',
					'font-weight'     => '800',
					'font-style'      => 'normal',
					'line-height'     => '20px', // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.05em',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'nelson' ),
					'description'     => esc_html__( 'Font settings of the post meta: date, counters, share, etc.', 'nelson' ),
					'font-family'     => '"Gilroy",sans-serif',
					'font-size'       => '14px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '800',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.5px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'nelson' ),
					'description'     => esc_html__( 'Font settings of the main menu items', 'nelson' ),
					'font-family'     => '"Gilroy",sans-serif',
					'font-size'       => '1.058rem',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.176em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'nelson' ),
					'description'     => esc_html__( 'Font settings of the dropdown menu items', 'nelson' ),
					'font-family'     => '"Gilroy",sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.75em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
			)
		);
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


// Shortcodes support
//------------------------------------------------------------------------

// Add new output types (layouts) in the shortcodes
if ( ! function_exists( 'nelson_skin_trx_addons_sc_type' ) ) {
    add_filter( 'trx_addons_sc_type', 'nelson_skin_trx_addons_sc_type', 10, 2 );
    function nelson_skin_trx_addons_sc_type( $list, $sc ) {
        // To do: check shortcode slug and if correct - add new 'key' => 'title' to the list
        if ( 'trx_sc_button' == $sc ) {
            $list['extra'] = 'Extra';
        }
        return $list;
    }
}

// Set theme specific importer options
if ( ! function_exists( 'nelson_skin_importer_set_options' ) ) {
	add_filter('trx_addons_filter_importer_options', 'nelson_skin_importer_set_options', 9);
	function nelson_skin_importer_set_options($options = array()) {
		if ( is_array( $options ) ) {
			$options['demo_type'] = 'hair';
			$options['files']['hair'] = $options['files']['default'];
			$options['files']['hair']['title'] = esc_html__('Hair Salon Demo', 'nelson');
			$options['files']['hair']['domain_dev'] = '';    // Developers domain
			$options['files']['hair']['domain_demo'] = 'http://hair.nelson.themerex.net';   // Demo-site domain
			unset($options['files']['default']);
		}
		return $options;
	}
}

// Section: "CONTENT"
if ( ! NELSON_THEME_FREE ) {
	$GLOBALS['NELSON_STORAGE']['required_plugins']['revslider'] = array(
		'title' => esc_html__('Revolution Slider', 'nelson'),
		'description' => '',
		'required' => false,
		'install' => false,
		'logo' => 'logo.png',
		'group' => esc_html__('Content', 'nelson'),
	);
}

// Add slin-specific colors and fonts to the custom CSS
require_once NELSON_THEME_DIR . NELSON_SKIN_DIR . 'skin-styles.php';
