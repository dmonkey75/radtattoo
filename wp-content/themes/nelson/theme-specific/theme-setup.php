<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.22
 */

// If this theme is a free version of premium theme
if ( ! defined( 'NELSON_THEME_FREE' ) ) {
	define( 'NELSON_THEME_FREE', false );
}
if ( ! defined( 'NELSON_THEME_FREE_WP' ) ) {
	define( 'NELSON_THEME_FREE_WP', false );
}

// If this theme is a part of Envato Elements
if ( ! defined( 'NELSON_THEME_IN_ENVATO_ELEMENTS' ) ) {
	define( 'NELSON_THEME_IN_ENVATO_ELEMENTS', false );
}

// If this theme uses multiple skins
if ( ! defined( 'NELSON_ALLOW_SKINS' ) ) {
	define( 'NELSON_ALLOW_SKINS', true);
}
if ( ! defined( 'NELSON_DEFAULT_SKIN' ) ) {
	define( 'NELSON_DEFAULT_SKIN', 'default' );
}



// Theme storage
// Attention! Must be in the global namespace to compatibility with WP CLI
//-------------------------------------------------------------------------
$GLOBALS['NELSON_STORAGE'] = array(

	// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
	'theme_pro_key'       => 'env-themerex',

	// Generate Personal token from Envato to automatic upgrade theme
	'upgrade_token_url'   => '//build.envato.com/create-token/?default=t&purchase:download=t&purchase:list=t',

	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'      => '//nelson.themerex.net/',
	'theme_doc_url'       => '//nelson.themerex.net/doc',

	'theme_upgrade_url'   => '//upgrade.themerex.net/',

	'theme_demofiles_url' => '//demofiles.themerex.net/nelson/',
	
	'theme_rate_url'      => '//themeforest.net/download',

	'theme_custom_url' => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash',

	'theme_download_url'  => '//themeforest.net/item/nelson-barbershop-tattoo-wordpress-theme/24525732',            // ThemeREX

	'theme_support_url'   => '//themerex.net/support/',                              // ThemeREX

	'theme_video_url'     => '//www.youtube.com/channel/UCnFisBimrK2aIE-hnY70kCA',   // ThemeREX

	'theme_privacy_url'   => '//themerex.net/privacy-policy/',                       // ThemeREX

	// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
	// (i.e. 'children,kindergarten')
	'theme_categories'    => '',

	// Responsive resolutions
	// Parameters to create css media query: min, max
	'responsive'          => array(
		// By size
		'xxl'        => array( 'max' => 1679 ),
		'xl'         => array( 'max' => 1439 ),
		'lg'         => array( 'max' => 1279 ),
		'md_over'    => array( 'min' => 1024 ),
		'md'         => array( 'max' => 1023 ),
		'sm'         => array( 'max' => 767 ),
		'sm_wp'      => array( 'max' => 600 ),
		'xs'         => array( 'max' => 479 ),
		// By device
		'wide'       => array(
			'min' => 2160
		),
		'desktop'    => array(
			'min' => 1680,
			'max' => 2159,
		),
		'notebook'   => array(
			'min' => 1280,
			'max' => 1679,
		),
		'tablet'     => array(
			'min' => 768,
			'max' => 1279,
		),
		'not_mobile' => array(
			'min' => 768
		),
		'mobile'     => array(
			'max' => 767
		),
	),
);


//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'nelson_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'nelson_importer_set_options', 9 );
	function nelson_importer_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Allow import/export functionality
			$options['allow_import'] = true;
			$options['allow_export'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url( nelson_get_protocol() . ':' . nelson_storage_get( 'theme_demofiles_url' ) );
			// Required plugins
			$options['required_plugins'] = array_keys( nelson_storage_get( 'required_plugins' ) );
			// Set number of thumbnails (usually 3 - 5) to regenerate at once when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 0;
			// Default demo
			$options['files']['default']['title']       = esc_html__( 'Nelson Demo', 'nelson' );
			$options['files']['default']['domain_dev']  = '';                     // Developers domain
			$options['files']['default']['domain_demo'] = esc_url( 'http:' . nelson_storage_get( 'theme_demo_url' ) );   // Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
												
			// The array with theme-specific banners, displayed during demo-content import.
			// If array with banners is empty - the banners are uploaded directly from demo-content server.
			$options['banners'] = array();
		}
		return $options;
	}
}


//------------------------------------------------------------------------
// OCDI support
//------------------------------------------------------------------------

// Set theme specific OCDI options
if ( ! function_exists( 'nelson_ocdi_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'nelson_ocdi_set_options', 9 );
	function nelson_ocdi_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Prepare demo data
			$options['demo_url'] = esc_url( nelson_get_protocol() . ':' . nelson_storage_get( 'theme_demofiles_url' ) );
			// Required plugins
			$options['required_plugins'] = array_keys( nelson_storage_get( 'required_plugins' ) );
			// Demo-site domain
			$options['files']['ocdi']['title']       = esc_html__( 'Nelson OCDI Demo', 'nelson' );
			$options['files']['ocdi']['domain_demo'] = esc_url( nelson_get_protocol() . ':' . nelson_storage_get( 'theme_demo_url' ) );
			// If theme need more demo - just copy 'default' and change required parameter
											}
		return $options;
	}
}



// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$nelson_theme_required_plugins_group = esc_html__( 'Core', 'nelson' );
$nelson_theme_required_plugins = array(
	// Section: "CORE" (required plugins)
	// DON'T COMMENT OR REMOVE NEXT LINES!
	'trx_addons'         => array(
								'title'       => esc_html__( 'ThemeREX Addons', 'nelson' ),
								'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'nelson' ),
								'required'    => true,
								'logo'        => 'logo.png',
								'group'       => $nelson_theme_required_plugins_group,
							),
);

// Section: "PAGE BUILDERS"
$nelson_theme_required_plugins_group = esc_html__( 'Page Builders', 'nelson' );
$nelson_theme_required_plugins['elementor'] = array(
	'title'       => esc_html__( 'Elementor', 'nelson' ),
	'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'nelson' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $nelson_theme_required_plugins_group,
);
$nelson_theme_required_plugins['gutenberg'] = array(
	'title'       => esc_html__( 'Gutenberg', 'nelson' ),
	'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'nelson' ),
	'required'    => false,
	'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
	'logo'        => 'logo.png',
	'group'       => $nelson_theme_required_plugins_group,
);
if ( ! NELSON_THEME_FREE ) {
	$nelson_theme_required_plugins['js_composer']          = array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'nelson' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'nelson' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'logo.jpg',
		'group'       => $nelson_theme_required_plugins_group,
	);
}
// Section: "E-COMMERCE & DONATIONS"
$nelson_theme_required_plugins_group = esc_html__( 'E-Commerce & Donations', 'nelson' );
$nelson_theme_required_plugins['woocommerce']              = array(
	'title'       => esc_html__( 'WooCommerce', 'nelson' ),
	'description' => esc_html__( "Connect the store to your website and start selling now", 'nelson' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $nelson_theme_required_plugins_group,
);
$nelson_theme_required_plugins['elegro-payment']              = array(
	'title'       => esc_html__( 'Elegro Crypto Payment', 'nelson' ),
	'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'nelson' ),
	'required'    => false,
	'logo'        => 'elegro-payment.png',
	'group'       => $nelson_theme_required_plugins_group,
);

// Section: "SOCIALS & COMMUNITIES"
$nelson_theme_required_plugins_group = esc_html__( 'Socials and Communities', 'nelson' );
$nelson_theme_required_plugins['mailchimp-for-wp'] = array(
	'title'       => esc_html__( 'MailChimp for WP', 'nelson' ),
	'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'nelson' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $nelson_theme_required_plugins_group,
);

// Section: "EVENTS & TIMELINES"
$nelson_theme_required_plugins_group = esc_html__( 'Events and Appointments', 'nelson' );
if ( ! NELSON_THEME_FREE ) {
	$nelson_theme_required_plugins['booked']                 = array(
		'title'       => esc_html__( 'Booked Appointments', 'nelson' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $nelson_theme_required_plugins_group,
	);
}

// Section: "CONTENT"
$nelson_theme_required_plugins_group = esc_html__( 'Content', 'nelson' );
$nelson_theme_required_plugins['contact-form-7'] = array(
	'title'       => esc_html__( 'Contact Form 7', 'nelson' ),
	'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'nelson' ),
	'required'    => false,
	'logo'        => 'logo.jpg',
	'group'       => $nelson_theme_required_plugins_group,
);
if ( ! NELSON_THEME_FREE ) {
	$nelson_theme_required_plugins['essential-grid']             = array(
		'title'       => esc_html__( 'Essential Grid', 'nelson' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $nelson_theme_required_plugins_group,
	);
	$nelson_theme_required_plugins['revslider']                  = array(
		'title'       => esc_html__( 'Revolution Slider', 'nelson' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $nelson_theme_required_plugins_group,
	);
	$nelson_theme_required_plugins['sitepress-multilingual-cms'] = array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'nelson' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'nelson' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'logo.png',
		'group'       => $nelson_theme_required_plugins_group,
	);
}

// Section: "OTHER"
$nelson_theme_required_plugins_group = esc_html__( 'Other', 'nelson' );
$nelson_theme_required_plugins['wp-gdpr-compliance'] = array(
	'title'       => esc_html__( 'WP GDPR Compliance', 'nelson' ),
	'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'nelson' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $nelson_theme_required_plugins_group,
);
$nelson_theme_required_plugins['date-time-picker-field'] = array(
	'title'       => esc_html__( 'Date Time Picker Field', 'nelson' ),
	'description' => esc_html__( "Convert any input field on your website into a date time picker field using CSS selectors.", 'nelson' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $nelson_theme_required_plugins_group,
);
if ( ! NELSON_THEME_FREE ) {
	$nelson_theme_required_plugins['trx_updater'] = array(
		'title' => esc_html__('ThemeREX Updater', 'nelson'),
		'description' => esc_html__("Update theme and theme-specific plugins from developer's upgrade server.", 'nelson'),
		'required' => false,
		'logo' => 'trx_updater.png',
		'group' => $nelson_theme_required_plugins_group,
	);
}


// Add plugins list to the global storage
$GLOBALS['NELSON_STORAGE']['required_plugins'] = $nelson_theme_required_plugins;



// THEME-SPECIFIC BLOG LAYOUTS
//----------------------------------------------
$nelson_theme_blog_styles = array(
	'excerpt' => array(
		'title'   => esc_html__( 'Standard', 'nelson' ),
		'archive' => 'index-excerpt',
		'item'    => 'content-excerpt',
		'styles'  => 'excerpt',
	),
	'plain' => array(
		'title'   => esc_html__( 'Plain', 'nelson' ),
		'archive' => 'index-plain',
		'item'    => 'content-plain',
		'styles'  => 'plain',
	),
	'classic' => array(
		'title'   => esc_html__( 'Classic', 'nelson' ),
		'archive' => 'index-classic',
		'item'    => 'content-classic',
		'columns' => array( 2, 3 ),
		'styles'  => 'classic',
	),
);
if ( ! NELSON_THEME_FREE ) {
	$nelson_theme_blog_styles['masonry']   = array(
		'title'   => esc_html__( 'Masonry', 'nelson' ),
		'archive' => 'index-classic',
		'item'    => 'content-classic',
		'columns' => array( 2, 3 ),
		'styles'  => 'masonry',
	);
	$nelson_theme_blog_styles['portfolio'] = array(
		'title'   => esc_html__( 'Portfolio', 'nelson' ),
		'archive' => 'index-portfolio',
		'item'    => 'content-portfolio',
		'columns' => array( 2, 3, 4 ),
		'styles'  => 'portfolio',
	);
	$nelson_theme_blog_styles['gallery']   = array(
		'title'   => esc_html__( 'Gallery', 'nelson' ),
		'archive' => 'index-portfolio',
		'item'    => 'content-portfolio-gallery',
		'columns' => array( 2, 3, 4 ),
		'styles'  => array( 'portfolio', 'gallery' ),
	);
	$nelson_theme_blog_styles['chess']     = array(
		'title'   => esc_html__( 'Chess', 'nelson' ),
		'archive' => 'index-chess',
		'item'    => 'content-chess',
		'columns' => array( 1, 2, 3 ),
		'styles'  => 'chess',
	);
}

// Add list of blog styles to the global storage
$GLOBALS['NELSON_STORAGE']['blog_styles'] = $nelson_theme_blog_styles;



// THEME-SPECIFIC SINGLE POST LAYOUTS
//----------------------------------------------
$nelson_theme_single_styles = array(
	'in-above'   => array(
		'title'  => esc_html__( 'The image inside the content area, the title above image', 'nelson' ),
		'styles' => 'in-above',
	),
	'in-below'   => array(
		'title'  => esc_html__( 'The image inside the content area, the title below image', 'nelson' ),
		'styles' => 'in-below',
	),
	'in-over'    => array(
		'title'  => esc_html__( 'The image inside the content area, the title over image', 'nelson' ),
		'styles' => 'in-over',
	),
	'in-sticky'  => array(
		'title'  => esc_html__( 'The image inside the content area, the title is stick at the bottom side of the image', 'nelson' ),
		'styles' => 'in-sticky',
	),
	'out-below-boxed'  => array(
		'title'  => esc_html__( 'Boxed image above the content area, the title below image', 'nelson' ),
		'styles' => 'out-below-boxed',
	),
	'out-over-boxed'   => array(
		'title'  => esc_html__( 'Boxed image above the content area, the title over image', 'nelson' ),
		'styles' => 'out-over-boxed',
	),
	'out-sticky-boxed' => array(
		'title'  => esc_html__( 'Boxed image above the content area, the title is stick at the bottom side of the image', 'nelson' ),
		'styles' => 'out-sticky-boxed',
	),
	'out-below-fullwidth'  => array(
		'title'  => esc_html__( 'Fullwidth image above the content area, the title below image', 'nelson' ),
		'styles' => 'out-below-fullwidth',
	),
	'out-over-fullwidth'   => array(
		'title'  => esc_html__( 'Fullwidth image above the content area, the title over image', 'nelson' ),
		'styles' => 'out-over-fullwidth',
	),
	'out-sticky-fullwidth' => array(
		'title'  => esc_html__( 'Fullwidth image above the content area, the title is stick at the bottom side of the image', 'nelson' ),
		'styles' => 'out-sticky-fullwidth',
	),
);

// Add list of single post styles to the global storage
$GLOBALS['NELSON_STORAGE']['single_styles'] = $nelson_theme_single_styles;


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( ! function_exists( 'nelson_customizer_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'nelson_customizer_theme_setup1', 1 );
	function nelson_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		nelson_storage_set(
			'settings', array(

				'duplicate_options'       => 'child',                   // none  - use separate options for the main and the child-theme
																		// child - duplicate theme options from the main theme to the child-theme only
																		// both  - sinchronize changes in the theme options between main and child themes

				'customize_refresh'       => 'auto',                    // Refresh method for preview area in the Appearance - Customize:
																		// auto - refresh preview area on change each field with Theme Options
																		// manual - refresh only obn press button 'Refresh' at the top of Customize frame

				'max_load_fonts'          => 5,                         // Max fonts number to load from Google fonts or from uploaded fonts

				'comment_after_name'      => true,                      // Place 'comment' field after the 'name' and 'email'

				'show_author_avatar'      => true,                      // Display author's avatar in the post meta

				'icons_selector'          => 'internal',                // Icons selector in the shortcodes:
																		// vc (default) - standard VC (very slow) or Elementor's icons selector (not support images and svg)
																		// internal - internal popup with plugin's or theme's icons list (fast and support images and svg)

				'icons_type'              => 'icons',                   // Type of icons (if 'icons_selector' is 'internal'):
																		// icons  - use font icons to present icons
																		// images - use images from theme's folder trx_addons/css/icons.png
																		// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'socials_type'            => 'icons',                   // Type of socials icons (if 'icons_selector' is 'internal'):
																		// icons  - use font icons to present social networks
																		// images - use images from theme's folder trx_addons/css/icons.png
																		// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'check_min_version'       => true,                      // Check if exists a .min version of .css and .js and return path to it
																		// instead the path to the original file
																		// (if debug_mode is on and modification time of the original file < time of the .min file)

				'autoselect_menu'         => false,                     // Show any menu if no menu selected in the location 'main_menu'
																		// (for example, the theme is just activated)

				'disable_jquery_ui'       => false,                     // Prevent loading custom jQuery UI libraries in the third-party plugins

				'use_mediaelements'       => true,                      // Load script "Media Elements" to play video and audio

				'tgmpa_upload'            => false,                     // Allow upload not pre-packaged plugins via TGMPA

				'allow_no_image'          => false,                     // Allow to use theme-specific image placeholder if no image present in the blog, related posts, post navigation, etc.

				'separate_schemes'        => true,                      // Save color schemes to the separate files __color_xxx.css (true) or append its to the __custom.css (false)

				'allow_fullscreen'        => false,                     // Allow cases 'fullscreen' and 'fullwide' for the body style in the Theme Options
																		// In the Page Options this styles are present always
																		// (can be removed if filter 'nelson_filter_allow_fullscreen' return false)

				'attachments_navigation'  => false,                     // Add arrows on the single attachment page to navigate to the prev/next attachment

				'gutenberg_safe_mode'     => array(),                   // 'vc', 'elementor' - Prevent simultaneous editing of posts for Gutenberg and other PageBuilders (VC, Elementor)

				'gutenberg_add_context'   => false,                     // Add context to the Gutenberg editor styles with our method (if true - use if any problem with editor styles) or use native Gutenberg way via add_editor_style() (if false - used by default)

				'modify_gutenberg_blocks' => true,                      // Modify core blocks - add our parameters and classes

				'allow_gutenberg_blocks'  => true,                      // Allow our shortcodes and widgets as blocks in the Gutenberg (not ready yet - in the development now)

				'subtitle_above_title'    => true,                      // Put subtitle above the title in the shortcodes

				'add_hide_on_xxx'         => 'replace',                 // Add our breakpoints to the Responsive section of each element
																		// 'add' - add our breakpoints after Elementor's
																		// 'replace' - add our breakpoints instead Elementor's
																		// 'none' - don't add our breakpoints (using only Elementor's)
			)
		);

		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------

		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
				nelson_storage_set(
			'load_fonts', array(
				// Google font
				array(
					'name'   => 'Teko',
					'family' => 'sans-serif',
					'styles' => '300,400,500,600,700',     // Parameter 'style' used only for the Google fonts
				),
				array(
					'name'   => 'Montserrat',
					'family' => 'sans-serif',
                    'styles' => '100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic',// Parameter 'style' used only for the Google fonts
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
					'font-family'     => '"Montserrat",sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
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
					'font-family'     => '"Teko",sans-serif',
					'font-size'       => '5.625rem',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.025em',
					'margin-top'      => '0.7em',
					'margin-bottom'   => '0.1em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'nelson' ),
					'font-family'     => '"Teko",sans-serif',
					'font-size'       => '4.375rem',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.025em',
					'margin-top'      => '0.92em',
					'margin-bottom'   => '0.3em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'nelson' ),
					'font-family'     => '"Teko",sans-serif',
					'font-size'       => '3.125rem',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.1em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.025em',
					'margin-top'      => '1.15em',
					'margin-bottom'   => '0.35em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'nelson' ),
					'font-family'     => '"Teko",sans-serif',
					'font-size'       => '2.187rem',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.142em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.025em',
					'margin-top'      => '1.37em',
					'margin-bottom'   => '0.5em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'nelson' ),
					'font-family'     => '"Teko",sans-serif',
					'font-size'       => '1.562rem',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.35em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.025em',
					'margin-top'      => '1.58em',
					'margin-bottom'   => '0.5em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'nelson' ),
					'font-family'     => '"Montserrat",sans-serif',
					'font-size'       => '1.125rem',
					'font-weight'     => '400',
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
					'font-family'     => '"Teko",sans-serif',
					'font-size'       => '2.187rem',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.025em',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'nelson' ),
					'font-family'     => '"Montserrat",sans-serif',
					'font-size'       => '14px',
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
					'font-family'     => '"Montserrat",sans-serif',
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
					'font-family'     => '"Montserrat",sans-serif',
					'font-size'       => '1.058rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.176em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'nelson' ),
					'description'     => esc_html__( 'Font settings of the dropdown menu items', 'nelson' ),
					'font-family'     => '"Montserrat",sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.75em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
			)
		);

		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		nelson_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'nelson' ),
					'description' => esc_html__( 'Colors of the main content area', 'nelson' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'nelson' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'nelson' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'nelson' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'nelson' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'nelson' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'nelson' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'nelson' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'nelson' ),
				),
			)
		);
		nelson_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'nelson' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'nelson' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'nelson' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'nelson' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'nelson' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'nelson' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'nelson' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'nelson' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'nelson' ),
					'description' => esc_html__( 'Color of the plain text inside this block', 'nelson' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'nelson' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'nelson' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'nelson' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'nelson' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'nelson' ),
					'description' => esc_html__( 'Color of the links inside this block', 'nelson' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'nelson' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'nelson' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Link 2', 'nelson' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'nelson' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Link 2 hover', 'nelson' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'nelson' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Link 3', 'nelson' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'nelson' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Link 3 hover', 'nelson' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'nelson' ),
				),
			)
		);
		$schemes = array(

            // Color scheme: 'dark'
            'dark'    => array(
                'title'    => esc_html__( 'Dark', 'nelson' ),
                'internal' => true,
                'colors'   => array(

                    // Whole block border and background
                    'bg_color'         => '#252525',//
                    'bd_color'         => '#454545',//

                    // Text and links colors
                    'text'             => '#8d8d8d',//
                    'text_light'       => '#70927b',//
                    'text_dark'        => '#e1e1e1',//
                    'text_link'        => '#96885f',//
                    'text_hover'       => '#e1e1e1',//
                    'text_link2'       => '#2c2c2c',//
                    'text_hover2'      => '#e1e1e1',//
                    'text_link3'       => '#ffffff',//
                    'text_hover3'      => '#2c2c2c',//

                    // Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                    'alter_bg_color'   => '#2c2c2c',//
                    'alter_bg_hover'   => '#323232',//
                    'alter_bd_color'   => '#454545',//
                    'alter_bd_hover'   => '#4a4a4a',
                    'alter_text'       => '#8d8d8d',//
                    'alter_light'      => '#8d8d8d',//
                    'alter_dark'       => '#e1e1e1',//
                    'alter_link'       => '#96885f',//
                    'alter_hover'      => '#e1e1e1',//
                    'alter_link2'      => '#2c2c2c',//
                    'alter_hover2'     => '#80d572',
                    'alter_link3'      => '#eec432',
                    'alter_hover3'     => '#ddb837',

                    // Extra blocks (submenu, tabs, color blocks, etc.)
                    'extra_bg_color'   => '#2c2c2c',//
                    'extra_bg_hover'   => '#28272e',
                    'extra_bd_color'   => '#343434',//
                    'extra_bd_hover'   => '#4a4a4a',
                    'extra_text'       => '#898989',//
                    'extra_light'      => '#8d8d8d',//
                    'extra_dark'       => '#e1e1e1',//
                    'extra_link'       => '#96885f',//
                    'extra_hover'      => '#e1e1e1',//
                    'extra_link2'      => '#70927b',//
                    'extra_hover2'     => '#e1e1e1',//
                    'extra_link3'      => '#96885f',//
                    'extra_hover3'     => '#ffffff',//

                    // Input fields (form's fields and textarea)
                    'input_bg_color'   => '#252525',//
                    'input_bg_hover'   => '#252525',//
                    'input_bd_color'   => '#454545',//
                    'input_bd_hover'   => '#454545',//
                    'input_text'       => '#e1e1e1',//
                    'input_light'      => '#6f6f6f',
                    'input_dark'       => '#e1e1e1',//

                    // Inverse blocks (text and links on the 'text_link' background)
                    'inverse_bd_color' => '#262626',//
                    'inverse_bd_hover' => '#cb5b47',
                    'inverse_text'     => '#8d8d8d',//
                    'inverse_light'    => '#2c2c2c',//
                    'inverse_dark'     => '#96885f',//
                    'inverse_link'     => '#e1e1e1',//
                    'inverse_hover'    => '#70927b',//
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
					'text_link'        => '#70927b',//
					'text_hover'       => '#2c2c2c',//
					'text_link2'       => '#2c2c2c',//
					'text_hover2'      => '#70927b',//
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
					'alter_link'       => '#70927b',//
					'alter_hover'      => '#2c2c2c',//
					'alter_link2'      => '#2c2c2c',//
					'alter_hover2'     => '#80d572',
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
					'extra_link'       => '#70927b',//
					'extra_hover'      => '#2c2c2c',//
					'extra_link2'      => '#70927b',//
					'extra_hover2'     => '#e1e1e1',//
					'extra_link3'      => '#96885f',//
					'extra_hover3'     => '#ffffff',//

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#ffffff',//
					'input_bg_hover'   => '#e1e1e1',//
					'input_bd_color'   => '#e1e1e1',//
					'input_bd_hover'   => '#e1e1e1',//
					'input_text'       => '#e1e1e1',//
					'input_light'      => '#a7a7a7',
					'input_dark'       => '#2c2c2c',//

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#262626',//
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#8d8d8d',//
					'inverse_light'    => '#f2f2f2',//
					'inverse_dark'     => '#70927b',//
					'inverse_link'     => '#2c2c2c',//
					'inverse_hover'    => '#ffffff',//
				),
			),
            'second_dark'    => array(
                'title'    => esc_html__( 'Second Dark', 'nelson' ),
                'internal' => true,
                'colors'   => array(

                    // Whole block border and background
                    'bg_color'         => '#252525',//
                    'bd_color'         => '#454545',//

                    // Text and links colors
                    'text'             => '#8d8d8d',//
                    'text_light'       => '#e6a87a',//
                    'text_dark'        => '#e1e1e1',//
                    'text_link'        => '#e6a87a',//
                    'text_hover'       => '#e1e1e1',//
                    'text_link2'       => '#2c2c2c',//
                    'text_hover2'      => '#e1e1e1',//
                    'text_link3'       => '#ffffff',//
                    'text_hover3'      => '#2c2c2c',//

                    // Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                    'alter_bg_color'   => '#2c2c2c',//
                    'alter_bg_hover'   => '#323232',//
                    'alter_bd_color'   => '#454545',//
                    'alter_bd_hover'   => '#4a4a4a',
                    'alter_text'       => '#8d8d8d',//
                    'alter_light'      => '#8d8d8d',//
                    'alter_dark'       => '#e1e1e1',//
                    'alter_link'       => '#e6a87a',//
                    'alter_hover'      => '#e1e1e1',//
                    'alter_link2'      => '#2c2c2c',//
                    'alter_hover2'     => '#80d572',
                    'alter_link3'      => '#eec432',
                    'alter_hover3'     => '#ddb837',

                    // Extra blocks (submenu, tabs, color blocks, etc.)
                    'extra_bg_color'   => '#2c2c2c',//
                    'extra_bg_hover'   => '#28272e',
                    'extra_bd_color'   => '#343434',//
                    'extra_bd_hover'   => '#4a4a4a',
                    'extra_text'       => '#898989',//
                    'extra_light'      => '#8d8d8d',//
                    'extra_dark'       => '#e1e1e1',//
                    'extra_link'       => '#e6a87a',//
                    'extra_hover'      => '#e1e1e1',//
                    'extra_link2'      => '#e6a87a',//
                    'extra_hover2'     => '#e1e1e1',//
                    'extra_link3'      => '#e6a87a',//
                    'extra_hover3'     => '#ffffff',//

                    // Input fields (form's fields and textarea)
                    'input_bg_color'   => '#252525',//
                    'input_bg_hover'   => '#252525',//
                    'input_bd_color'   => '#e1e1e1',//
                    'input_bd_hover'   => '#e1e1e1',//
                    'input_text'       => '#8d8d8d',//
                    'input_light'      => '#6f6f6f',
                    'input_dark'       => '#e1e1e1',//

                    // Inverse blocks (text and links on the 'text_link' background)
                    'inverse_bd_color' => '#262626',//
                    'inverse_bd_hover' => '#cb5b47',
                    'inverse_text'     => '#8d8d8d',//
                    'inverse_light'    => '#2c2c2c',//
                    'inverse_dark'     => '#e6a87a',//
                    'inverse_link'     => '#e1e1e1',//
                    'inverse_hover'    => '#e6a87a',//
                ),
            ),
		);
		nelson_storage_set( 'schemes', $schemes );
		nelson_storage_set( 'schemes_original', $schemes );
		
		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		nelson_storage_set(
			'schemes_simple', array(
				'text_link'        => array(
					'alter_hover'      => 1,
					'extra_link'       => 1,
					'inverse_bd_color' => 0.85,
					'inverse_bd_hover' => 0.7,
				),
				'text_hover'       => array(
					'alter_link'  => 1,
					'extra_hover' => 1,
				),
				'text_link2'       => array(
					'alter_hover2' => 1,
					'extra_link2'  => 1,
				),
				'text_hover2'      => array(
					'alter_link2'  => 1,
					'extra_hover2' => 1,
				),
				'text_link3'       => array(
					'alter_hover3' => 1,
					'extra_link3'  => 1,
				),
				'text_hover3'      => array(
					'alter_link3'  => 1,
					'extra_hover3' => 1,
				),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
				'inverse_bd_color' => array(),
				'inverse_bd_hover' => array(),
			)
		);

		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		nelson_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_01'       => array(
					'color' => 'bg_color',
					'alpha' => 0.1,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bg_color_08' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.8,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
                'alter_bd_color_07' => array(
                    'color' => 'alter_bd_color',
                    'alpha' => 0.7,
                ),

				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_01' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.1,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
                'extra_hover3_05'     => array(
					'color' => 'extra_hover3',
					'alpha' => 0.5,
				),
				'text_dark_01'     => array(
					'color' => 'text_dark',
					'alpha' => 0.1,
				),
                'text_dark_05'     => array(
                    'color' => 'text_dark',
                    'alpha' => 0.5,
                ),
                'text_dark_03'     => array(
                    'color' => 'text_dark',
                    'alpha' => 0.3,
                ),
                'text_dark_07'     => array(
                    'color' => 'text_dark',
                    'alpha' => 0.7,
                ),
				'text_link2_01'     => array(
					'color' => 'text_link2',
					'alpha' => 0.1,
				),
				'text_link2_03'     => array(
					'color' => 'text_link2',
					'alpha' => 0.3,
				),
                'text_link2_05'     => array(
                    'color' => 'text_link2',
                    'alpha' => 0.5,
                ),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
                'extra_hover2_05'      => array(
					'color' => 'extra_hover2',
					'alpha' => 0.5,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Parameters to set order of schemes in the css
		nelson_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		nelson_storage_set(
			'theme_thumbs', apply_filters(
				'nelson_filter_add_thumb_sizes', array(
					// Width of the image is equal to the content area width (without sidebar)
					// Height is fixed
					'nelson-thumb-huge'        => array(
						'size'  => array( 1270, 715, true ),
						'title' => esc_html__( 'Huge image', 'nelson' ),
						'subst' => 'trx_addons-thumb-huge',
					),
					// Width of the image is equal to the content area width (with sidebar)
					// Height is fixed
					'nelson-thumb-big'         => array(
						'size'  => array( 786, 443, true ),
						'title' => esc_html__( 'Large image', 'nelson' ),
						'subst' => 'trx_addons-thumb-big',
					),

					// Width of the image is equal to the 1/3 of the content area width (without sidebar)
					// Height is fixed
					'nelson-thumb-med'         => array(
						'size'  => array( 404, 267, true ),
						'title' => esc_html__( 'Medium image', 'nelson' ),
						'subst' => 'trx_addons-thumb-medium',
					),

					// Small square image (for avatars in comments, etc.)
					'nelson-thumb-tiny'        => array(
						'size'  => array( 90, 90, true ),
						'title' => esc_html__( 'Small square avatar', 'nelson' ),
						'subst' => 'trx_addons-thumb-tiny',
					),

					// Width of the image is equal to the content area width (with sidebar)
					// Height is proportional (only downscale, not crop)
					'nelson-thumb-masonry-big' => array(
						'size'  => array( 786, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry Large (scaled)', 'nelson' ),
						'subst' => 'trx_addons-thumb-masonry-big',
					),

					// Width of the image is equal to the 1/3 of the full content area width (without sidebar)
					// Height is proportional (only downscale, not crop)
					'nelson-thumb-masonry'     => array(
						'size'  => array( 404, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry (scaled)', 'nelson' ),
						'subst' => 'trx_addons-thumb-masonry',
					),

                    'nelson-thumb-more-big'         => array(
                        'size'  => array( 786, 555, true ),
                        'title' => esc_html__( 'Large image square', 'nelson' ),
                        'subst' => 'trx_addons-thumb-big',
                    ),

                    'nelson-thumb-big-team'         => array(
                        'size'  => array( 590, 660, true ),
                        'title' => esc_html__( 'Large image for team', 'nelson' ),
                        'subst' => 'trx_addons-thumb-big',
                    ),
                    'nelson-thumb-big-team-second'         => array(
                        'size'  => array( 690, 808, true ),
                        'title' => esc_html__( 'Second large image for team', 'nelson' ),
                        'subst' => 'trx_addons-thumb-big-second',
                    ),
                    'nelson-thumb-square'         => array(
                        'size'  => array( 786, 786, true ),
                        'title' => esc_html__( 'Square image', 'nelson' ),
                        'subst' => 'trx_addons-thumb-square',
                    ),
				)
			)
		);
	}
}


// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if ( ! function_exists( 'nelson_create_theme_options' ) ) {

	function nelson_create_theme_options() {

		// Message about options override.
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = __( 'Attention! Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages. If you changed such parameter and nothing happened on the page, this option may be overridden in the corresponding section or in the Page Options of this page. These options are marked with an asterisk (*) in the title.', 'nelson' );

		// Color schemes number: if < 2 - hide fields with selectors
		$hide_schemes = count( nelson_storage_get( 'schemes' ) ) < 2;

		nelson_storage_set(

			'options', array(

				// 'Logo & Site Identity'
				//---------------------------------------------
				'title_tagline'                 => array(
					'title'    => esc_html__( 'Logo & Site Identity', 'nelson' ),
					'desc'     => '',
					'priority' => 10,
					'type'     => 'section',
				),
				'logo_info'                     => array(
					'title'    => esc_html__( 'Logo Settings', 'nelson' ),
					'desc'     => '',
					'priority' => 20,
					'qsetup'   => esc_html__( 'General', 'nelson' ),
					'type'     => 'info',
				),
				'logo_text'                     => array(
					'title'    => esc_html__( 'Use Site Name as Logo', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Use the site title and tagline as a text logo if no image is selected', 'nelson' ) ),
					'class'    => 'nelson_column-1_2 nelson_new_row',
					'priority' => 30,
					'std'      => 1,
					'qsetup'   => esc_html__( 'General', 'nelson' ),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'logo_retina_enabled'           => array(
					'title'    => esc_html__( 'Allow retina display logo', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Show fields to select logo images for Retina display', 'nelson' ) ),
					'class'    => 'nelson_column-1_2',
					'priority' => 40,
					'refresh'  => false,
					'std'      => 0,
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'logo_zoom'                     => array(
					'title'   => esc_html__( 'Logo zoom', 'nelson' ),
					'desc'    => wp_kses(
									__( 'Zoom the logo (set 1 to leave original size).', 'nelson' )
									. ' <br>'
									. __( 'Attention! For this parameter to affect images, their max-height should be specified in "em" instead of "px" when creating a header.', 'nelson' )
									. ' <br>'
									. __( 'In this case maximum size of logo depends on the actual size of the picture.', 'nelson' ), 'nelson_kses_content'
								),
					'std'     => 1,
					'min'     => 0.2,
					'max'     => 2,
					'step'    => 0.1,
					'refresh' => false,
					'type'    => NELSON_THEME_FREE ? 'hidden' : 'slider',
				),
				// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
				'logo_retina'                   => array(
					'title'      => esc_html__( 'Logo for Retina', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'nelson' ) ),
					'class'      => 'nelson_column-1_2',
					'priority'   => 70,
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile_header'            => array(
					'title' => esc_html__( 'Logo for the mobile header', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'nelson' ) ),
					'class' => 'nelson_column-1_2 nelson_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_header_retina'     => array(
					'title'      => esc_html__( 'Logo for the mobile header on Retina', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'nelson' ) ),
					'class'      => 'nelson_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile'                   => array(
					'title' => esc_html__( 'Logo for the mobile menu', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile menu', 'nelson' ) ),
					'class' => 'nelson_column-1_2 nelson_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_retina'            => array(
					'title'      => esc_html__( 'Logo mobile on Retina', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'nelson' ) ),
					'class'      => 'nelson_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_side'                     => array(
					'title' => esc_html__( 'Logo for the side menu', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo (with vertical orientation) to display it in the side menu', 'nelson' ) ),
					'class' => 'nelson_column-1_2 nelson_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_side_retina'              => array(
					'title'      => esc_html__( 'Logo for the side menu on Retina', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'nelson' ) ),
					'class'      => 'nelson_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'image',
				),



				// 'General settings'
				//---------------------------------------------
				'general'                       => array(
					'title'    => esc_html__( 'General', 'nelson' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 20,
					'type'     => 'section',
				),

				'general_layout_info'           => array(
					'title'  => esc_html__( 'Layout', 'nelson' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'nelson' ),
					'type'   => 'info',
				),
				'body_style'                    => array(
					'title'    => esc_html__( 'Body style', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select width of the body content', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'qsetup'   => esc_html__( 'General', 'nelson' ),
					'refresh'  => false,
					'std'      => 'wide',
					'options'  => nelson_get_list_body_styles( false ),
					'type'     => 'select',
				),
				'page_width'                    => array(
					'title'      => esc_html__( 'Page width', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Total width of the site content and sidebar (in pixels). If empty - use default width', 'nelson' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed', 'wide' ),
					),
					'std'        => 1270,
					'min'        => 1000,
					'max'        => 1600,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'page',               // SASS variable's name to preview changes 'on fly'
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'slider',
				),
				'page_boxed_extra'             => array(
					'title'      => esc_html__( 'Boxed page extra spaces', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Width of the extra side space on boxed pages', 'nelson' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'std'        => 60,
					'min'        => 0,
					'max'        => 150,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'page_boxed_extra',   // SASS variable's name to preview changes 'on fly'
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'slider',
				),
				'boxed_bg_image'                => array(
					'title'      => esc_html__( 'Boxed bg image', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'nelson' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'std'        => '',
					'qsetup'     => esc_html__( 'General', 'nelson' ),
					'type'       => 'image',
				),
				'remove_margins'                => array(
					'title'    => esc_html__( 'Remove margins', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Remove margins above and below the content area', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'refresh'  => false,
					'std'      => 0,
					'type'     => 'checkbox',
				),

				'general_sidebar_info'          => array(
					'title' => esc_html__( 'Sidebar', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position'              => array(
					'title'    => esc_html__( 'Sidebar position', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'std'      => 'right',
					'qsetup'   => esc_html__( 'General', 'nelson' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_position_ss'       => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'nelson' ),
					'desc'     => wp_kses_data( __( "Select position to move sidebar (if it's not hidden) on the small screen - above or below the content", 'nelson' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_ss_single'
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'      => 'below',
					'qsetup'   => esc_html__( 'General', 'nelson' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_type'              => array(
					'title'    => esc_html__( 'Sidebar style', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => nelson_get_list_header_footer_types(),
					'type'     => NELSON_THEME_FREE || ! nelson_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'sidebar_style'                 => array(
					'title'      => esc_html__( 'Select custom layout', 'nelson' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'nelson' ), 'nelson_kses_content' ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
						'sidebar_type' => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets'               => array(
					'title'      => esc_html__( 'Sidebar widgets', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_widgets_single'
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
						'sidebar_type'     => array( 'default')
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'nelson' ),
					'type'       => 'select',
				),
				'sidebar_width'                 => array(
					'title'      => esc_html__( 'Sidebar width', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Width of the sidebar (in pixels). If empty - use default width', 'nelson' ) ),
					'std'        => 404,
					'min'        => 150,
					'max'        => 500,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'sidebar',      // SASS variable's name to preview changes 'on fly'
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'slider',
				),
				'sidebar_gap'                   => array(
					'title'      => esc_html__( 'Sidebar gap', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Gap between content and sidebar (in pixels). If empty - use default gap', 'nelson' ) ),
					'std'        => 80,
					'min'        => 0,
					'max'        => 100,
					'step'       => 1,
					'refresh'    => false,
					'customizer' => 'gap',          // SASS variable's name to preview changes 'on fly'
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'slider',
				),
				'expand_content'                => array(
					'title'   => esc_html__( 'Expand content', 'nelson' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'nelson' ) ),
					'refresh' => false,
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'std'     => 1,
					'type'    => 'checkbox',
				),

				'general_widgets_info'          => array(
					'title' => esc_html__( 'Additional widgets', 'nelson' ),
					'desc'  => '',
					'type'  => NELSON_THEME_FREE ? 'hidden' : 'info',
				),
				'widgets_above_page'            => array(
					'title'    => esc_html__( 'Widgets at the top of the page', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_above_content'         => array(
					'title'    => esc_html__( 'Widgets above the content', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_content'         => array(
					'title'    => esc_html__( 'Widgets below the content', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_page'            => array(
					'title'    => esc_html__( 'Widgets at the bottom of the page', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'select',
				),

				'general_effects_info'          => array(
					'title' => esc_html__( 'Design & Effects', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'border_radius'                 => array(
					'title'      => esc_html__( 'Border radius', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Specify the border radius of the form fields and buttons in pixels', 'nelson' ) ),
					'std'        => 0,
					'min'        => 0,
					'max'        => 20,
					'step'       => 1,
					'refresh'    => false,
					'customizer' => 'rad',      // SASS name to preview changes 'on fly'
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'slider',
				),

				'general_misc_info'             => array(
					'title' => esc_html__( 'Miscellaneous', 'nelson' ),
					'desc'  => '',
					'type'  => NELSON_THEME_FREE ? 'hidden' : 'info',
				),
				'seo_snippets'                  => array(
					'title' => esc_html__( 'SEO snippets', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Add structured data markup to the single posts and pages', 'nelson' ) ),
					'std'   => 0,
					'type'  => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'privacy_text' => array(
					"title" => esc_html__("Text with Privacy Policy link", 'nelson'),
					"desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'nelson') ),
					"std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'nelson'), 'nelson_kses_content' ),
					"type"  => "hidden"
				),



				// 'Header'
				//---------------------------------------------
				'header'                        => array(
					'title'    => esc_html__( 'Header', 'nelson' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 30,
					'type'     => 'section',
				),

				'header_style_info'             => array(
					'title' => esc_html__( 'Header style', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type'                   => array(
					'title'    => esc_html__( 'Header style', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nelson' ),
					),
					'std'      => 'default',
					'options'  => nelson_get_list_header_footer_types(),
					'type'     => NELSON_THEME_FREE || ! nelson_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'nelson' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'nelson' ), 'nelson_kses_content' ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nelson' ),
					),
					'dependency' => array(
						'header_type' => array( 'custom' ),
					),
					'std'        => 'header-custom-elementor-header-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position'               => array(
					'title'    => esc_html__( 'Header position', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nelson' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_fullheight'             => array(
					'title'    => esc_html__( 'Header fullheight', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill the whole screen. Used only if the header has a background image', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nelson' ),
					),
					'std'      => 0,
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_wide'                   => array(
					'title'      => esc_html__( 'Header fullwidth', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nelson' ),
					),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 1,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_zoom'                   => array(
					'title'   => esc_html__( 'Header zoom', 'nelson' ),
					'desc'    => wp_kses_data( __( 'Zoom the header title. 1 - original size', 'nelson' ) ),
					'std'     => 1,
					'min'     => 0.2,
					'max'     => 2,
					'step'    => 0.1,
					'refresh' => false,
					'type'    => NELSON_THEME_FREE ? 'hidden' : 'slider',
				),

				'header_widgets_info'           => array(
					'title' => esc_html__( 'Header widgets', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Here you can place a widget slider, advertising banners, etc.', 'nelson' ) ),
					'type'  => 'info',
				),
				'header_widgets'                => array(
					'title'    => esc_html__( 'Header widgets', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select set of widgets to show in the header on each page', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nelson' ),
						'desc'    => wp_kses_data( __( 'Select set of widgets to show in the header on this page', 'nelson' ) ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => 'select',
				),
				'header_columns'                => array(
					'title'      => esc_html__( 'Header columns', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nelson' ),
					),
					'dependency' => array(
						'header_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => nelson_get_list_range( 0, 6 ),
					'type'       => 'select',
				),

				'menu_info'                     => array(
					'title' => esc_html__( 'Main menu', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Select main menu style, position and other parameters', 'nelson' ) ),
					'type'  => NELSON_THEME_FREE ? 'hidden' : 'info',
				),
				'menu_style'                    => array(
					'title'    => esc_html__( 'Menu position', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select position of the main menu', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nelson' ),
					),
					'std'      => 'top',
					'options'  => array(
						'top'   => esc_html__( 'Top', 'nelson' ),
						'left'  => esc_html__( 'Left', 'nelson' ),
						'right' => esc_html__( 'Right', 'nelson' ),
					),
					'type'     => NELSON_THEME_FREE || ! nelson_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'menu_side_stretch'             => array(
					'title'      => esc_html__( 'Stretch sidemenu', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Stretch sidemenu to window height (if menu items number >= 5)', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nelson' ),
					),
					'dependency' => array(
						'menu_style' => array( 'left', 'right' ),
					),
					'std'        => 0,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'menu_side_icons'               => array(
					'title'      => esc_html__( 'Iconed sidemenu', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nelson' ),
					),
					'dependency' => array(
						'menu_style' => array( 'left', 'right' ),
					),
					'std'        => 1,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'menu_mobile_fullscreen'        => array(
					'title' => esc_html__( 'Mobile menu fullscreen', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'nelson' ) ),
					'std'   => 1,
					'type'  => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'header_image_info'             => array(
					'title' => esc_html__( 'Header image', 'nelson' ),
					'desc'  => '',
					'type'  => NELSON_THEME_FREE ? 'hidden' : 'info',
				),
				'header_image_override'         => array(
					'title'    => esc_html__( 'Header image override', 'nelson' ),
					'desc'     => wp_kses_data( __( "Allow override the header image with the page's/post's/product's/etc. featured image", 'nelson' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'nelson' ),
					),
					'std'      => 0,
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'header_mobile_info'            => array(
					'title'      => esc_html__( 'Mobile header', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Configure the mobile version of the header', 'nelson' ) ),
					'priority'   => 500,
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'info',
				),
				'header_mobile_enabled'         => array(
					'title'      => esc_html__( 'Enable the mobile header', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Use the mobile version of the header (if checked) or relayout the current header on mobile devices', 'nelson' ) ),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_additional_info' => array(
					'title'      => esc_html__( 'Additional info', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Additional info to show at the top of the mobile header', 'nelson' ) ),
					'std'        => '',
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'refresh'    => false,
					'teeny'      => false,
					'rows'       => 20,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'text_editor',
				),
				'header_mobile_hide_info'       => array(
					'title'      => esc_html__( 'Hide additional info', 'nelson' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_logo'       => array(
					'title'      => esc_html__( 'Hide logo', 'nelson' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => 'checkbox',
				),
				'header_mobile_hide_login'      => array(
					'title'      => esc_html__( 'Hide login/logout', 'nelson' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => 'checkbox',
				),
				'header_mobile_hide_search'     => array(
					'title'      => esc_html__( 'Hide search', 'nelson' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => 'checkbox',
				),
				'header_mobile_hide_cart'       => array(
					'title'      => esc_html__( 'Hide cart', 'nelson' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => 'checkbox',
				),



				// 'Footer'
				//---------------------------------------------
				'footer'                        => array(
					'title'    => esc_html__( 'Footer', 'nelson' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 50,
					'type'     => 'section',
				),
				'footer_type'                   => array(
					'title'    => esc_html__( 'Footer style', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'nelson' ),
					),
					'std'      => 'default',
					'options'  => nelson_get_list_header_footer_types(),
					'type'     => NELSON_THEME_FREE || ! nelson_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'footer_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'nelson' ),
					'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'nelson' ), 'nelson_kses_content' ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'nelson' ),
					),
					'dependency' => array(
						'footer_type' => array( 'custom' ),
					),
					'std'        => 'footer-custom-elementor-footer-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets'                => array(
					'title'      => esc_html__( 'Footer widgets', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'nelson' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns'                => array(
					'title'      => esc_html__( 'Footer columns', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'nelson' ),
					),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'footer_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => nelson_get_list_range( 0, 6 ),
					'type'       => 'select',
				),
				'footer_wide'                   => array(
					'title'      => esc_html__( 'Footer fullwidth', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'nelson' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'logo_in_footer'                => array(
					'title'      => esc_html__( 'Show logo', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Show logo in the footer', 'nelson' ) ),
					'refresh'    => false,
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'logo_footer'                   => array(
					'title'      => esc_html__( 'Logo for footer', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo to display it in the footer', 'nelson' ) ),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'logo_in_footer' => array( 1 ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'logo_footer_retina'            => array(
					'title'      => esc_html__( 'Logo for footer (Retina)', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'nelson' ) ),
					'dependency' => array(
						'footer_type'         => array( 'default' ),
						'logo_in_footer'      => array( 1 ),
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'image',
				),
				'socials_in_footer'             => array(
					'title'      => esc_html__( 'Show social icons', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Show social icons in the footer (under logo or footer widgets)', 'nelson' ) ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => ! nelson_exists_trx_addons() ? 'hidden' : 'checkbox',
				),
				'copyright'                     => array(
					'title'      => esc_html__( 'Copyright', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'nelson' ) ),
					'translate'  => true,
					'std'        => esc_html__( 'Copyright &copy; {Y} by ThemeREX. All rights reserved.', 'nelson' ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'refresh'    => false,
					'type'       => 'textarea',
				),



				// 'Mobile version'
				//---------------------------------------------
				'mobile'                        => array(
					'title'    => esc_html__( 'Mobile', 'nelson' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 55,
					'type'     => 'section',
				),

				'mobile_header_info'            => array(
					'title' => esc_html__( 'Header on the mobile device', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_mobile'            => array(
					'title'    => esc_html__( 'Header style', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use on mobile devices: the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
					'std'      => 'inherit',
					'options'  => nelson_get_list_header_footer_types( true ),
					'type'     => NELSON_THEME_FREE || ! nelson_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_mobile'           => array(
					'title'      => esc_html__( 'Select custom layout', 'nelson' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'nelson' ), 'nelson_kses_content' ),
					'dependency' => array(
						'header_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_mobile'        => array(
					'title'    => esc_html__( 'Header position', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'nelson' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),

				'mobile_sidebar_info'           => array(
					'title' => esc_html__( 'Sidebar on the mobile device', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_mobile'       => array(
					'title'    => esc_html__( 'Sidebar position on mobile', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar on mobile devices', 'nelson' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_type_mobile'           => array(
					'title'    => esc_html__( 'Sidebar style', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
					),
					'std'      => 'inherit',
					'options'  => nelson_get_list_header_footer_types( true ),
					'type'     => NELSON_THEME_FREE || ! nelson_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'sidebar_style_mobile'          => array(
					'title'      => esc_html__( 'Select custom layout', 'nelson' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'nelson' ), 'nelson_kses_content' ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
						'sidebar_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets_mobile'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on mobile devices', 'nelson' ) ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
						'sidebar_type_mobile' => array( 'default' )
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_mobile'         => array(
					'title'   => esc_html__( 'Expand content', 'nelson' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden on mobile devices', 'nelson' ) ),
					'refresh' => false,
					'dependency' => array(
						'sidebar_position_mobile' => array( 'hide', 'inherit' ),
					),
					'std'     => 'inherit',
					'options'  => nelson_get_list_checkbox_values( true ),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),

				'mobile_footer_info'           => array(
					'title' => esc_html__( 'Footer on the mobile device', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'footer_type_mobile'           => array(
					'title'    => esc_html__( 'Footer style', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use on mobile devices: the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
					'std'      => 'inherit',
					'options'  => nelson_get_list_header_footer_types( true ),
					'type'     => NELSON_THEME_FREE || ! nelson_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'footer_style_mobile'          => array(
					'title'      => esc_html__( 'Select custom layout', 'nelson' ),
					'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'nelson' ), 'nelson_kses_content' ),
					'dependency' => array(
						'footer_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets_mobile'        => array(
					'title'      => esc_html__( 'Footer widgets', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'nelson' ) ),
					'dependency' => array(
						'footer_type_mobile' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns_mobile'        => array(
					'title'      => esc_html__( 'Footer columns', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'nelson' ) ),
					'dependency' => array(
						'footer_type_mobile'    => array( 'default' ),
						'footer_widgets_mobile' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => nelson_get_list_range( 0, 6 ),
					'type'       => 'select',
				),



				// 'Blog'
				//---------------------------------------------
				'blog'                          => array(
					'title'    => esc_html__( 'Blog', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Options of the the blog archive', 'nelson' ) ),
					'priority' => 70,
					'type'     => 'panel',
				),


				// Blog - Posts page
				//---------------------------------------------
				'blog_general'                  => array(
					'title' => esc_html__( 'Posts page', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Style and components of the blog archive', 'nelson' ) ),
					'type'  => 'section',
				),
				'blog_general_info'             => array(
					'title'  => esc_html__( 'Posts page settings', 'nelson' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'nelson' ),
					'type'   => 'info',
				),
				'blog_style'                    => array(
					'title'      => esc_html__( 'Blog style', 'nelson' ),
					'desc'       => '',
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => 'excerpt',
					'qsetup'     => esc_html__( 'General', 'nelson' ),
					'options'    => array(),
					'type'       => 'select',
				),
				'first_post_large'              => array(
					'title'      => esc_html__( 'First post large', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Make your first post stand out by making it bigger', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array( 'classic', 'masonry' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'blog_content'                  => array(
					'title'      => esc_html__( 'Posts content', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Display either post excerpts or the full post content', 'nelson' ) ),
					'std'        => 'excerpt',
					'dependency' => array(
						'blog_style' => array( 'excerpt' ),
					),
					'options'    => array(
						'excerpt'  => esc_html__( 'Excerpt', 'nelson' ),
						'fullpost' => esc_html__( 'Full post', 'nelson' ),
					),
					'type'       => 'switch',
				),
				'excerpt_length'                => array(
					'title'      => esc_html__( 'Excerpt length', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged', 'nelson' ) ),
					'dependency' => array(
						'blog_style'   => array( 'excerpt' ),
						'blog_content' => array( 'excerpt' ),
					),
					'std'        => 38,
					'type'       => 'text',
				),
				'blog_columns'                  => array(
					'title'   => esc_html__( 'Blog columns', 'nelson' ),
					'desc'    => wp_kses_data( __( 'How many columns should be used in the blog archive (from 2 to 4)?', 'nelson' ) ),
					'std'     => 2,
					'options' => nelson_get_list_range( 2, 4 ),
					'type'    => 'hidden',      // This options is available and must be overriden only for some modes (for example, 'shop')
				),
				'post_type'                     => array(
					'title'      => esc_html__( 'Post type', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select post type to show in the blog archive', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'linked'     => 'parent_cat',
					'refresh'    => false,
					'hidden'     => true,
					'std'        => 'post',
					'options'    => array(),
					'type'       => 'select',
				),
				'parent_cat'                    => array(
					'title'      => esc_html__( 'Category to show', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select category to show in the blog archive', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'refresh'    => false,
					'hidden'     => true,
					'std'        => '0',
					'options'    => array(),
					'type'       => 'select',
				),
				'posts_per_page'                => array(
					'title'      => esc_html__( 'Posts per page', 'nelson' ),
					'desc'       => wp_kses_data( __( 'How many posts will be displayed on this page', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'hidden'     => true,
					'std'        => '',
					'type'       => 'text',
				),
				'blog_pagination'               => array(
					'title'      => esc_html__( 'Pagination style', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Show Older/Newest posts or Page numbers below the posts list', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'std'        => 'pages',
					'qsetup'     => esc_html__( 'General', 'nelson' ),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'options'    => array(
						'pages'    => esc_html__( 'Page numbers', 'nelson' ),
						'links'    => esc_html__( 'Older/Newest', 'nelson' ),
						'more'     => esc_html__( 'Load more', 'nelson' ),
						'infinite' => esc_html__( 'Infinite scroll', 'nelson' ),
					),
					'type'       => 'select',
				),
				'blog_animation'                => array(
					'title'      => esc_html__( 'Post animation', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'compare'                                  => 'or',
						'#page_template'                           => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => 'none',
					'options'    => array(),
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'select',
				),
				'disable_animation_on_mobile'   => array(
					'title'      => esc_html__( 'Disable animation on mobile', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Disable any posts animation on mobile devices', 'nelson' ) ),
					'std'        => 0,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'show_filters'                  => array(
					'title'      => esc_html__( 'Show filters', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Show categories as tabs to filter posts', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'compare'                                  => 'or',
						'#page_template'                           => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style'                               => array( 'portfolio', 'gallery' ),
					),
					'hidden'     => true,
					'std'        => 0,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'video_in_popup'                => array(
					'title'      => esc_html__( 'Open video in the popup on a blog archive', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Open the video from posts in the popup (if plugin "ThemeREX Addons" is installed) or play the video instead the cover image', 'nelson' ) ),
					'std'        => 0,
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'compare'                                  => 'or',
						'#page_template'                           => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'type'       => 'checkbox',
				),
				'open_full_post_in_blog'        => array(
					'title'      => esc_html__( 'Open full post in blog', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Allow to open the full version of the post directly in the blog feed. Attention! Applies only to 1 column layouts!', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'open_full_post_hide_author'    => array(
					'title'      => esc_html__( 'Hide author bio', 'nelson' ),
					'desc'       => wp_kses_data( __( "Hide author bio after post content when open the full version of the post directly in the blog feed.", 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'open_full_post_in_blog' => array( 1 ),
					),
					'std'        => 1,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'open_full_post_hide_related'   => array(
					'title'      => esc_html__( 'Hide related posts', 'nelson' ),
					'desc'       => wp_kses_data( __( "Hide related posts after post content when open the full version of the post directly in the blog feed.", 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'open_full_post_in_blog' => array( 1 ),
					),
					'std'        => 1,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'blog_header_info'              => array(
					'title' => esc_html__( 'Header', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_blog'              => array(
					'title'    => esc_html__( 'Header style', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
					'std'      => 'inherit',
					'options'  => nelson_get_list_header_footer_types( true ),
					'type'     => NELSON_THEME_FREE || ! nelson_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_blog'             => array(
					'title'      => esc_html__( 'Select custom layout', 'nelson' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'nelson' ), 'nelson_kses_content' ),
					'dependency' => array(
						'header_type_blog' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_blog'          => array(
					'title'    => esc_html__( 'Header position', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'nelson' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_fullheight_blog'        => array(
					'title'    => esc_html__( 'Header fullheight', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'nelson' ) ),
					'std'      => 'inherit',
					'options'  => nelson_get_list_checkbox_values( true ),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_wide_blog'              => array(
					'title'      => esc_html__( 'Header fullwidth', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'nelson' ) ),
					'dependency' => array(
						'header_type_blog' => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => nelson_get_list_checkbox_values( true ),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_sidebar_info'             => array(
					'title' => esc_html__( 'Sidebar', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_blog'         => array(
					'title'   => esc_html__( 'Sidebar position', 'nelson' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar', 'nelson' ) ),
					'std'     => 'inherit',
					'options' => array(),
					'qsetup'     => esc_html__( 'General', 'nelson' ),
					'type'    => 'switch',
				),
				'sidebar_position_ss_blog'  => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'nelson' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'      => 'inherit',
					'qsetup'   => esc_html__( 'General', 'nelson' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_type_blog'           => array(
					'title'    => esc_html__( 'Sidebar style', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => nelson_get_list_header_footer_types(),
					'type'     => NELSON_THEME_FREE || ! nelson_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'sidebar_style_blog'            => array(
					'title'      => esc_html__( 'Select custom layout', 'nelson' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'nelson' ), 'nelson_kses_content' ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
						'sidebar_type_blog'     => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets_blog'          => array(
					'title'      => esc_html__( 'Sidebar widgets', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'nelson' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
						'sidebar_type_blog'     => array( 'default' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'nelson' ),
					'type'       => 'select',
				),
				'expand_content_blog'           => array(
					'title'   => esc_html__( 'Expand content', 'nelson' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'nelson' ) ),
					'refresh' => false,
					'std'     => 'inherit',
					'options'  => nelson_get_list_checkbox_values( true ),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_widgets_info'             => array(
					'title' => esc_html__( 'Additional widgets', 'nelson' ),
					'desc'  => '',
					'type'  => NELSON_THEME_FREE ? 'hidden' : 'info',
				),
				'widgets_above_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the top of the page', 'nelson' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'nelson' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => NELSON_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_above_content_blog'    => array(
					'title'   => esc_html__( 'Widgets above the content', 'nelson' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'nelson' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => NELSON_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_content_blog'    => array(
					'title'   => esc_html__( 'Widgets below the content', 'nelson' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'nelson' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => NELSON_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the bottom of the page', 'nelson' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'nelson' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => NELSON_THEME_FREE ? 'hidden' : 'select',
				),

				'blog_advanced_info'            => array(
					'title' => esc_html__( 'Advanced settings', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'no_image'                      => array(
					'title' => esc_html__( 'Image placeholder', 'nelson' ),
					'desc'  => wp_kses_data( __( "Select or upload an image used as placeholder for posts without a featured image. Placeholder is used on the blog stream page only (no placeholder in single post), and only in those styles of it where non-using featured image doesn't seem appropriate.", 'nelson' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'time_diff_before'              => array(
					'title' => esc_html__( 'Easy Readable Date Format', 'nelson' ),
					'desc'  => wp_kses_data( __( "For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'nelson' ) ),
					'std'   => 5,
					'type'  => 'text',
				),
				'sticky_style'                  => array(
					'title'   => esc_html__( 'Sticky posts style', 'nelson' ),
					'desc'    => wp_kses_data( __( 'Select style of the sticky posts output', 'nelson' ) ),
					'std'     => 'inherit',
					'options' => array(
						'inherit' => esc_html__( 'Decorated posts', 'nelson' ),
						'columns' => esc_html__( 'Mini-cards', 'nelson' ),
					),
					'type'    => NELSON_THEME_FREE ? 'hidden' : 'select',
				),
				'meta_parts'                    => array(
					'title'      => esc_html__( 'Post meta', 'nelson' ),
					'desc'       => wp_kses_data( __( "If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'nelson' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'date=1|categories=1|comments=1|views=0|likes=0|author=0|share=0|edit=0',
					'options'    => nelson_get_list_meta_parts(),
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checklist',
				),


				// Blog - Single posts
				//---------------------------------------------
				'blog_single'                   => array(
					'title' => esc_html__( 'Single posts', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Settings of the single post', 'nelson' ) ),
					'type'  => 'section',
				),

				'blog_single_header_info'       => array(
					'title' => esc_html__( 'Header', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_single'            => array(
					'title'    => esc_html__( 'Header style', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
					'std'      => 'inherit',
					'options'  => nelson_get_list_header_footer_types( true ),
					'type'     => NELSON_THEME_FREE || ! nelson_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_single'           => array(
					'title'      => esc_html__( 'Select custom layout', 'nelson' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'nelson' ), 'nelson_kses_content' ),
					'dependency' => array(
						'header_type_single' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_single'        => array(
					'title'    => esc_html__( 'Header position', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'nelson' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_fullheight_single'      => array(
					'title'    => esc_html__( 'Header fullheight', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'nelson' ) ),
					'std'      => 'inherit',
					'options'  => nelson_get_list_checkbox_values( true ),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_wide_single'            => array(
					'title'      => esc_html__( 'Header fullwidth', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'nelson' ) ),
					'dependency' => array(
						'header_type_single' => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => nelson_get_list_checkbox_values( true ),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_single_sidebar_info'      => array(
					'title' => esc_html__( 'Sidebar', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_single'       => array(
					'title'   => esc_html__( 'Sidebar position', 'nelson' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar on the single posts', 'nelson' ) ),
					'std'     => 'right',
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'options' => array(),
					'type'    => 'switch',
				),
				'sidebar_position_ss_single'    => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the single posts on the small screen - above or below the content', 'nelson' ) ),
					'override' => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'      => 'below',
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_type_single'           => array(
					'title'    => esc_html__( 'Sidebar style', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => nelson_get_list_header_footer_types(),
					'type'     => NELSON_THEME_FREE || ! nelson_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'sidebar_style_single'            => array(
					'title'      => esc_html__( 'Select custom layout', 'nelson' ),
					'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'nelson' ), 'nelson_kses_content' ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
						'sidebar_type_single'     => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets_single'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on the single posts', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nelson' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
						'sidebar_type_single'     => array( 'default' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_single'         => array(
					'title'   => esc_html__( 'Expand content', 'nelson' ),
					'desc'    => wp_kses_data( __( 'Expand the content width on the single posts if the sidebar is hidden', 'nelson' ) ),
					'refresh' => false,
					'std'     => 'inherit',
					'options'  => nelson_get_list_checkbox_values( true ),
					'type'     => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_single_title_info'        => array(
					'title' => esc_html__( 'Featured image and title', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'single_style'                  => array(
					'title'      => esc_html__( 'Single style', 'nelson' ),
					'desc'       => '',
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'std'        => 'in-below',
					'qsetup'     => esc_html__( 'General', 'nelson' ),
					'options'    => array(),
					'type'       => 'select',
				),
				'post_subtitle'                 => array(
					'title' => esc_html__( 'Post subtitle', 'nelson' ),
					'desc'  => wp_kses_data( __( "Specify post subtitle to display it under the post title.", 'nelson' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'std'   => '',
					'hidden' => true,
					'type'  => 'text',
				),
				'show_post_meta'                => array(
					'title' => esc_html__( 'Show post meta', 'nelson' ),
					'desc'  => wp_kses_data( __( "Display block with post's meta: date, categories, counters, etc.", 'nelson' ) ),
					'std'   => 1,
					'type'  => 'checkbox',
				),
				'meta_parts_single'             => array(
					'title'      => esc_html__( 'Post meta', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Meta parts for single posts. Post counters and Share Links are available only if plugin ThemeREX Addons is active', 'nelson' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'nelson' ) ),
					'dependency' => array(
						'show_post_meta' => array( 1 ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'date=1|categories=1|comments=1|views=0|likes=0|author=0|share=0|edit=0',
					'options'    => nelson_get_list_meta_parts(),
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checklist',
				),
				'show_share_links'              => array(
					'title' => esc_html__( 'Show share links', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Display share links on the single post', 'nelson' ) ),
					'std'   => 1,
					'type'  => ! nelson_exists_trx_addons() ? 'hidden' : 'checkbox',
				),
				'show_author_info'              => array(
					'title' => esc_html__( 'Show author info', 'nelson' ),
					'desc'  => wp_kses_data( __( "Display block with information about post's author", 'nelson' ) ),
					'std'   => 1,
					'type'  => 'checkbox',
				),

				'blog_single_related_info'      => array(
					'title' => esc_html__( 'Related posts', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'show_related_posts'            => array(
					'title'    => esc_html__( 'Show related posts', 'nelson' ),
					'desc'     => wp_kses_data( __( "Show section 'Related posts' on the single post's pages", 'nelson' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'std'      => 1,
					'type'     => 'checkbox',
				),
				'related_style'                 => array(
					'title'      => esc_html__( 'Related posts style', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select style of the related posts output', 'nelson' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'classic',
					'options'    => array(
						'modern'  => esc_html__( 'Modern', 'nelson' ),
						'classic' => esc_html__( 'Classic', 'nelson' ),
						'wide'    => esc_html__( 'Wide', 'nelson' ),
						'list'    => esc_html__( 'List', 'nelson' ),
						'short'   => esc_html__( 'Short', 'nelson' ),
					),
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_position'              => array(
					'title'      => esc_html__( 'Related posts position', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Select position to display the related posts', 'nelson' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'below_content',
					'options'    => array (
						'inside'        => esc_html__( 'Inside the content (fullwidth)', 'nelson' ),
						'inside_left'   => esc_html__( 'At left side of the content', 'nelson' ),
						'inside_right'  => esc_html__( 'At right side of the content', 'nelson' ),
						'below_content' => esc_html__( 'After the content', 'nelson' ),
						'below_page'    => esc_html__( 'After the content & sidebar', 'nelson' ),
					),
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'select',
				),
				'related_position_inside'       => array(
					'title'      => esc_html__( 'Before # paragraph', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Before what paragraph should related posts appear? If 0 - randomly.', 'nelson' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'inside_left', 'inside_right' ),
					),
					'std'        => 2,
					'options'    => nelson_get_list_range( 0, 9 ),
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'select',
				),
				'related_posts'                 => array(
					'title'      => esc_html__( 'Related posts', 'nelson' ),
					'desc'       => wp_kses_data( __( 'How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'nelson' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 2,
					'min'        => 1,
					'max'        => 9,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'slider',
				),
				'related_columns'               => array(
					'title'      => esc_html__( 'Related columns', 'nelson' ),
					'desc'       => wp_kses_data( __( 'How many columns should be used to output related posts in the single page?', 'nelson' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'below_content', 'below_page' ),
					),
					'std'        => 2,
					'options'    => nelson_get_list_range( 1, 6 ),
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_slider'                => array(
					'title'      => esc_html__( 'Use slider layout', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Use slider layout in case related posts count is more than columns count', 'nelson' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 0,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'related_slider_controls'       => array(
					'title'      => esc_html__( 'Slider controls', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Show arrows in the slider', 'nelson' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'none',
					'options'    => array(
						'none'    => esc_html__('None', 'nelson'),
						'side'    => esc_html__('Side', 'nelson'),
						'outside' => esc_html__('Outside', 'nelson'),
						'top'     => esc_html__('Top', 'nelson'),
						'bottom'  => esc_html__('Bottom', 'nelson')
					),
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'select',
				),
				'related_slider_pagination'       => array(
					'title'      => esc_html__( 'Slider pagination', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Show bullets after the slider', 'nelson' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'bottom',
					'options'    => array(
						'none'    => esc_html__('None', 'nelson'),
						'bottom'  => esc_html__('Bottom', 'nelson')
					),
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_slider_space'          => array(
					'title'      => esc_html__( 'Space', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Space between slides', 'nelson' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nelson' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 30,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'text',
				),
				'posts_navigation_info'      => array(
					'title' => esc_html__( 'Posts navigation', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'posts_navigation'           => array(
					'title'   => esc_html__( 'Show posts navigation', 'nelson' ),
					'desc'    => wp_kses_data( __( "Show posts navigation on the single post's pages", 'nelson' ) ),
					'std'     => 'none',
					'options' => array(
						'none'   => esc_html__('None', 'nelson'),
						'links'  => esc_html__('Prev/Next links', 'nelson'),
						'scroll' => esc_html__('Infinite scroll', 'nelson')
					),
					'type'    => NELSON_THEME_FREE ? 'hidden' : 'switch',
				),
				'posts_navigation_fixed'     => array(
					'title'      => esc_html__( 'Fixed posts navigation', 'nelson' ),
					'desc'       => wp_kses_data( __( "Make posts navigation fixed position. Display it when the content of the article is inside the window.", 'nelson' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'links' ),
					),
					'std'        => 0,
					'type'       => 'hidden',
				),
				'posts_navigation_scroll_hide_author'  => array(
					'title'      => esc_html__( 'Hide author bio', 'nelson' ),
					'desc'       => wp_kses_data( __( "Hide author bio after post content when infinite scroll is used.", 'nelson' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 0,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'posts_navigation_scroll_hide_related'  => array(
					'title'      => esc_html__( 'Hide related posts', 'nelson' ),
					'desc'       => wp_kses_data( __( "Hide related posts after post content when infinite scroll is used.", 'nelson' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 0,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'posts_navigation_scroll_hide_comments' => array(
					'title'      => esc_html__( 'Hide comments', 'nelson' ),
					'desc'       => wp_kses_data( __( "Hide comments after post content when infinite scroll is used.", 'nelson' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 1,
					'type'       => NELSON_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'posts_banners_info'      => array(
					'title' => esc_html__( 'Posts banners', 'nelson' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_banner_link'     => array(
					'title' => esc_html__( 'Header banner link', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'   => '',
					'type'  => 'text',
				),
				'header_banner_img'     => array(
					'title' => esc_html__( 'Header banner image', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'header_banner_height'  => array(
					'title' => esc_html__( 'Header banner height', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Specify minimal height of the banner (in "px" or "em"). For example: 15em', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'        => '',
					'type'       => 'text',
				),
				'header_banner_code'     => array(
					'title'      => esc_html__( 'Header banner code', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'textarea',
				),
				'footer_banner_link'     => array(
					'title' => esc_html__( 'Footer banner link', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'   => '',
					'type'  => 'text',
				),
				'footer_banner_img'     => array(
					'title' => esc_html__( 'Footer banner image', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'footer_banner_height'  => array(
					'title' => esc_html__( 'Footer banner height', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Specify minimal height of the banner (in "px" or "em"). For example: 15em', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'        => '',
					'type'       => 'text',
				),
				'footer_banner_code'     => array(
					'title'      => esc_html__( 'Footer banner code', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'textarea',
				),
				'sidebar_banner_link'     => array(
					'title' => esc_html__( 'Sidebar banner link', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'   => '',
					'type'  => 'text',
				),
				'sidebar_banner_img'     => array(
					'title' => esc_html__( 'Sidebar banner image', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'sidebar_banner_code'     => array(
					'title'      => esc_html__( 'Sidebar banner code', 'nelson' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'textarea',
				),
				'background_banner_link'     => array(
					'title' => esc_html__( "Post's background banner link", 'nelson' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'   => '',
					'type'  => 'text',
				),
				'background_banner_img'     => array(
					'title' => esc_html__( "Post's background banner image", 'nelson' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'background_banner_code'     => array(
					'title'      => esc_html__( "Post's background banner code", 'nelson' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'nelson' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'nelson' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'textarea',
				),
				'blog_end'                      => array(
					'type' => 'panel_end',
				),



				// 'Colors'
				//---------------------------------------------
				'panel_colors'                  => array(
					'title'    => esc_html__( 'Colors', 'nelson' ),
					'desc'     => '',
					'priority' => 300,
					'type'     => 'section',
				),

				'color_schemes_info'            => array(
					'title'  => esc_html__( 'Color schemes', 'nelson' ),
					'desc'   => wp_kses_data( __( 'Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'nelson' ) ),
					'hidden' => $hide_schemes,
					'type'   => 'info',
				),
				'color_scheme'                  => array(
					'title'    => esc_html__( 'Site Color Scheme', 'nelson' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'nelson' ),
					),
					'std'      => 'dark',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'header_scheme'                 => array(
					'title'    => esc_html__( 'Header Color Scheme', 'nelson' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'nelson' ),
					),
					'std'      => 'dark',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'menu_scheme'                   => array(
					'title'    => esc_html__( 'Sidemenu Color Scheme', 'nelson' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'nelson' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes || NELSON_THEME_FREE ? 'hidden' : 'switch',
				),
				'sidebar_scheme'                => array(
					'title'    => esc_html__( 'Sidebar Color Scheme', 'nelson' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'nelson' ),
					),
					'std'      => 'dark',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'footer_scheme'                 => array(
					'title'    => esc_html__( 'Footer Color Scheme', 'nelson' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'nelson' ),
					),
					'std'      => 'dark',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),

				'color_scheme_editor_info'      => array(
					'title' => esc_html__( 'Color scheme editor', 'nelson' ),
					'desc'  => wp_kses_data( __( 'Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'nelson' ) ),
					'type'  => 'info',
				),
				'scheme_storage'                => array(
					'title'       => esc_html__( 'Color scheme editor', 'nelson' ),
					'desc'        => '',
					'std'         => '$nelson_get_scheme_storage',
					'refresh'     => false,
					'colorpicker' => 'tiny',
					'type'        => 'scheme_editor',
				),

				// Internal options.
				// Attention! Don't change any options in the section below!
				// Use huge priority to call render this elements after all options!
				'reset_options'                 => array(
					'title'    => '',
					'desc'     => '',
					'std'      => '0',
					'priority' => 10000,
					'type'     => 'hidden',
				),

				'last_option'                   => array(     // Need to manually call action to include Tiny MCE scripts
					'title' => '',
					'desc'  => '',
					'std'   => 1,
					'type'  => 'hidden',
				),

			)
		);



		// Prepare panel 'Fonts'
		// -------------------------------------------------------------
		$fonts = array(

			// 'Fonts'
			//---------------------------------------------
			'fonts'             => array(
				'title'    => esc_html__( 'Typography', 'nelson' ),
				'desc'     => '',
				'priority' => 200,
				'type'     => 'panel',
			),

			// Fonts - Load_fonts
			'load_fonts'        => array(
				'title' => esc_html__( 'Load fonts', 'nelson' ),
				'desc'  => wp_kses_data( __( 'Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'nelson' ) )
						. '<br>'
						. wp_kses_data( __( 'Attention! Press "Refresh" button to reload preview area after the all fonts are changed', 'nelson' ) ),
				'type'  => 'section',
			),
			'load_fonts_subset' => array(
				'title'   => esc_html__( 'Google fonts subsets', 'nelson' ),
				'desc'    => wp_kses_data( __( 'Specify comma separated list of the subsets which will be load from Google fonts', 'nelson' ) )
						. '<br>'
						. wp_kses_data( __( 'Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'nelson' ) ),
				'class'   => 'nelson_column-1_3 nelson_new_row',
				'refresh' => false,
				'std'     => '$nelson_get_load_fonts_subset',
				'type'    => 'text',
			),
		);

		for ( $i = 1; $i <= nelson_get_theme_setting( 'max_load_fonts' ); $i++ ) {
			if ( nelson_get_value_gp( 'page' ) != 'theme_options' ) {
				$fonts[ "load_fonts-{$i}-info" ] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					'title' => esc_html( sprintf( __( 'Font %s', 'nelson' ), $i ) ),
					'desc'  => '',
					'type'  => 'info',
				);
			}
			$fonts[ "load_fonts-{$i}-name" ]   = array(
				'title'   => esc_html__( 'Font name', 'nelson' ),
				'desc'    => '',
				'class'   => 'nelson_column-1_3 nelson_new_row',
				'refresh' => false,
				'std'     => '$nelson_get_load_fonts_option',
				'type'    => 'text',
			);
			$fonts[ "load_fonts-{$i}-family" ] = array(
				'title'   => esc_html__( 'Font family', 'nelson' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Select font family to use it if font above is not available', 'nelson' ) )
							: '',
				'class'   => 'nelson_column-1_3',
				'refresh' => false,
				'std'     => '$nelson_get_load_fonts_option',
				'options' => array(
					'inherit'    => esc_html__( 'Inherit', 'nelson' ),
					'serif'      => esc_html__( 'serif', 'nelson' ),
					'sans-serif' => esc_html__( 'sans-serif', 'nelson' ),
					'monospace'  => esc_html__( 'monospace', 'nelson' ),
					'cursive'    => esc_html__( 'cursive', 'nelson' ),
					'fantasy'    => esc_html__( 'fantasy', 'nelson' ),
				),
				'type'    => 'select',
			);
			$fonts[ "load_fonts-{$i}-styles" ] = array(
				'title'   => esc_html__( 'Font styles', 'nelson' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'nelson' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Each weight and style increase download size! Specify only used weights and styles.', 'nelson' ) )
							: '',
				'class'   => 'nelson_column-1_3',
				'refresh' => false,
				'std'     => '$nelson_get_load_fonts_option',
				'type'    => 'text',
			);
		}
		$fonts['load_fonts_end'] = array(
			'type' => 'section_end',
		);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = nelson_get_theme_fonts();
		foreach ( $theme_fonts as $tag => $v ) {
			$fonts[ "{$tag}_section" ] = array(
				'title' => ! empty( $v['title'] )
								? $v['title']
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html( sprintf( __( '%s settings', 'nelson' ), $tag ) ),
				'desc'  => ! empty( $v['description'] )
								? $v['description']
								// Translators: Add tag's name to make description
								: wp_kses( sprintf( __( 'Font settings of the "%s" tag.', 'nelson' ), $tag ), 'nelson_kses_content' ),
				'type'  => 'section',
			);

			foreach ( $v as $css_prop => $css_value ) {
				if ( in_array( $css_prop, array( 'title', 'description' ) ) ) {
					continue;
				}
				// Skip property 'text-decoration' for the main text
				if ( 'text-decoration' == $css_prop && 'p' == $tag ) {
					continue;
				}

				$options    = '';
				$type       = 'text';
				$load_order = 1;
				$title      = ucfirst( str_replace( '-', ' ', $css_prop ) );
				if ( 'font-family' == $css_prop ) {
					$type       = 'select';
					$options    = array();
					$load_order = 2;        // Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} elseif ( 'font-weight' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'nelson' ),
						'100'     => esc_html__( '100 (Light)', 'nelson' ),
						'200'     => esc_html__( '200 (Light)', 'nelson' ),
						'300'     => esc_html__( '300 (Thin)', 'nelson' ),
						'400'     => esc_html__( '400 (Normal)', 'nelson' ),
						'500'     => esc_html__( '500 (Semibold)', 'nelson' ),
						'600'     => esc_html__( '600 (Semibold)', 'nelson' ),
						'700'     => esc_html__( '700 (Bold)', 'nelson' ),
						'800'     => esc_html__( '800 (Black)', 'nelson' ),
						'900'     => esc_html__( '900 (Black)', 'nelson' ),
					);
				} elseif ( 'font-style' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'nelson' ),
						'normal'  => esc_html__( 'Normal', 'nelson' ),
						'italic'  => esc_html__( 'Italic', 'nelson' ),
					);
				} elseif ( 'text-decoration' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'      => esc_html__( 'Inherit', 'nelson' ),
						'none'         => esc_html__( 'None', 'nelson' ),
						'underline'    => esc_html__( 'Underline', 'nelson' ),
						'overline'     => esc_html__( 'Overline', 'nelson' ),
						'line-through' => esc_html__( 'Line-through', 'nelson' ),
					);
				} elseif ( 'text-transform' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'    => esc_html__( 'Inherit', 'nelson' ),
						'none'       => esc_html__( 'None', 'nelson' ),
						'uppercase'  => esc_html__( 'Uppercase', 'nelson' ),
						'lowercase'  => esc_html__( 'Lowercase', 'nelson' ),
						'capitalize' => esc_html__( 'Capitalize', 'nelson' ),
					);
				}
				$fonts[ "{$tag}_{$css_prop}" ] = array(
					'title'      => $title,
					'desc'       => '',
					'class'      => 'nelson_column-1_5',
					'refresh'    => false,
					'load_order' => $load_order,
					'std'        => '$nelson_get_theme_fonts_option',
					'options'    => $options,
					'type'       => $type,
				);
			}

			$fonts[ "{$tag}_section_end" ] = array(
				'type' => 'section_end',
			);
		}

		$fonts['fonts_end'] = array(
			'type' => 'panel_end',
		);

		// Add fonts parameters to Theme Options
		nelson_storage_set_array_before( 'options', 'panel_colors', $fonts );

		// Add Header Video if WP version < 4.7
		// -----------------------------------------------------
		if ( ! function_exists( 'get_header_video_url' ) ) {
			nelson_storage_set_array_after(
				'options', 'header_image_override', 'header_video', array(
					'title'    => esc_html__( 'Header video', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select video to use it as background for the header', 'nelson' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'nelson' ),
					),
					'std'      => '',
					'type'     => 'video',
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is not 'Customize'
		// ------------------------------------------------------
		if ( ! function_exists( 'the_custom_logo' ) || ! nelson_check_url( 'customize.php' ) ) {
			nelson_storage_set_array_before(
				'options', 'logo_retina', function_exists( 'the_custom_logo' ) ? 'custom_logo' : 'logo', array(
					'title'    => esc_html__( 'Logo', 'nelson' ),
					'desc'     => wp_kses_data( __( 'Select or upload the site logo', 'nelson' ) ),
					'class'    => 'nelson_column-1_2 nelson_new_row',
					'priority' => 60,
					'std'      => '',
					'qsetup'   => esc_html__( 'General', 'nelson' ),
					'type'     => 'image',
				)
			);
		}

	}
}


// Returns a list of options that can be overridden for CPT
if ( ! function_exists( 'nelson_options_get_list_cpt_options' ) ) {
	function nelson_options_get_list_cpt_options( $cpt, $title = '' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		return array(
			"content_info_{$cpt}"           => array(
				'title' => esc_html__( 'Content', 'nelson' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"body_style_{$cpt}"             => array(
				'title'    => esc_html__( 'Body style', 'nelson' ),
				'desc'     => wp_kses_data( __( 'Select width of the body content', 'nelson' ) ),
				'std'      => 'inherit',
				'options'  => nelson_get_list_body_styles( true ),
				'type'     => 'select',
			),
			"boxed_bg_image_{$cpt}"         => array(
				'title'      => esc_html__( 'Boxed bg image', 'nelson' ),
				'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'nelson' ) ),
				'dependency' => array(
					"body_style_{$cpt}" => array( 'boxed' ),
				),
				'std'        => 'inherit',
				'type'       => 'image',
			),
			"header_info_{$cpt}"            => array(
				'title' => esc_html__( 'Header', 'nelson' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"header_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Header style', 'nelson' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
				'std'     => 'inherit',
				'options' => nelson_get_list_header_footer_types( true ),
				'type'    => NELSON_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'nelson' ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select custom layout to display the site header on the %s pages', 'nelson' ), $title ) ),
				'dependency' => array(
					"header_type_{$cpt}" => array( 'custom' ),
				),
				'std'        => 'inherit',
				'options'    => array(),
				'type'       => NELSON_THEME_FREE ? 'hidden' : 'select',
			),
			"header_position_{$cpt}"        => array(
				'title'   => esc_html__( 'Header position', 'nelson' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to display the site header on the %s pages', 'nelson' ), $title ) ),
				'std'     => 'inherit',
				'options' => array(),
				'type'    => NELSON_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_image_override_{$cpt}"  => array(
				'title'   => esc_html__( 'Header image override', 'nelson' ),
				'desc'    => wp_kses_data( __( "Allow override the header image with the post's featured image", 'nelson' ) ),
				'std'     => 'inherit',
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'nelson' ),
					1         => esc_html__( 'Yes', 'nelson' ),
					0         => esc_html__( 'No', 'nelson' ),
				),
				'type'    => NELSON_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_widgets_{$cpt}"         => array(
				'title'   => esc_html__( 'Header widgets', 'nelson' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select set of widgets to show in the header on the %s pages', 'nelson' ), $title ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => 'select',
			),

			"sidebar_info_{$cpt}"           => array(
				'title' => esc_html__( 'Sidebar', 'nelson' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"sidebar_position_{$cpt}"       => array(
				// Translators: Add CPT name to the title
				'title'   => sprintf( __( 'Sidebar position on the %s list', 'nelson' ), $title ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to show sidebar on the %s list', 'nelson' ), $title ) ),
				'std'     => 'left',
				'options' => array(),
				'type'    => 'switch',
			),
			"sidebar_position_ss_{$cpt}"    => array(
				// Translators: Add CPT name to the title
				'title'    => sprintf( __( 'Sidebar position on the %s list on the small screen', 'nelson' ), $title ),
				'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'nelson' ) ),
				'std'      => 'below',
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'options'  => array(),
				'type'     => 'switch',
			),
			"sidebar_type_{$cpt}"           => array(
				// Translators: Add CPT name to the title
				'title'    => sprintf( __( 'Sidebar style on the %s list', 'nelson' ), $title ),
				'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'std'      => 'default',
				'options'  => nelson_get_list_header_footer_types(),
				'type'     => NELSON_THEME_FREE || ! nelson_exists_trx_addons() ? 'hidden' : 'switch',
			),
			"sidebar_style_{$cpt}"          => array(
				'title'      => esc_html__( 'Select custom layout', 'nelson' ),
				'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'nelson' ), 'nelson_kses_content' ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
					"sidebar_type_{$cpt}"     => array( 'custom' ),
				),
				'std'        => 'sidebar-custom-sidebar',
				'options'    => array(),
				'type'       => 'select',
			),
			"sidebar_widgets_{$cpt}"        => array(
				// Translators: Add CPT name to the title
				'title'      => sprintf( __( 'Sidebar widgets on the %s list', 'nelson' ), $title ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select sidebar to show on the %s list', 'nelson' ), $title ) ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
					"sidebar_type_{$cpt}"     => array( 'default' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"sidebar_position_single_{$cpt}"       => array(
				'title'   => esc_html__( 'Sidebar position on the single post', 'nelson' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to show sidebar on the single posts of the %s', 'nelson' ), $title ) ),
				'std'     => 'left',
				'options' => array(),
				'type'    => 'switch',
			),
			"sidebar_position_ss_single_{$cpt}"    => array(
				'title'    => esc_html__( 'Sidebar position on the single post on the small screen', 'nelson' ),
				'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'nelson' ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'      => 'below',
				'options'  => array(),
				'type'     => 'switch',
			),
			"sidebar_type_single_{$cpt}"           => array(
				// Translators: Add CPT name to the title
				'title'    => esc_html__( 'Sidebar style on the single post', 'nelson' ),
				'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'      => 'default',
				'options'  => nelson_get_list_header_footer_types(),
				'type'     => NELSON_THEME_FREE || ! nelson_exists_trx_addons() ? 'hidden' : 'switch',
			),
			"sidebar_style_single_{$cpt}"          => array(
				'title'      => esc_html__( 'Select custom layout', 'nelson' ),
				'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'nelson' ), 'nelson_kses_content' ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
					"sidebar_type_single_{$cpt}"     => array( 'custom' ),
				),
				'std'        => 'sidebar-custom-sidebar',
				'options'    => array(),
				'type'       => 'select',
			),
			"sidebar_widgets_single_{$cpt}"        => array(
				'title'      => esc_html__( 'Sidebar widgets on the single post', 'nelson' ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select widgets to show in the sidebar on the single posts of the %s', 'nelson' ), $title ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
					"sidebar_type_single_{$cpt}"     => array( 'default' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"expand_content_{$cpt}"         => array(
				'title'   => esc_html__( 'Expand content', 'nelson' ),
				'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'nelson' ) ),
				'refresh' => false,
				'std'     => 'inherit',
				'options'  => nelson_get_list_checkbox_values( true ),
				'type'     => NELSON_THEME_FREE ? 'hidden' : 'switch',
			),
			"expand_content_single_{$cpt}"         => array(
				'title'   => esc_html__( 'Expand content on the single post', 'nelson' ),
				'desc'    => wp_kses_data( __( 'Expand the content width on the single post if the sidebar is hidden', 'nelson' ) ),
				'refresh' => false,
				'std'     => 'inherit',
				'options'  => nelson_get_list_checkbox_values( true ),
				'type'     => NELSON_THEME_FREE ? 'hidden' : 'switch',
			),

			"footer_info_{$cpt}"            => array(
				'title' => esc_html__( 'Footer', 'nelson' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"footer_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Footer style', 'nelson' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'nelson' ) ),
				'std'     => 'inherit',
				'options' => nelson_get_list_header_footer_types( true ),
				'type'    => NELSON_THEME_FREE ? 'hidden' : 'switch',
			),
			"footer_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'nelson' ),
				'desc'       => wp_kses_data( __( 'Select custom layout to display the site footer', 'nelson' ) ),
				'std'        => 'inherit',
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'custom' ),
				),
				'options'    => array(),
				'type'       => NELSON_THEME_FREE ? 'hidden' : 'select',
			),
			"footer_widgets_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer widgets', 'nelson' ),
				'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'nelson' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 'footer_widgets',
				'options'    => array(),
				'type'       => 'select',
			),
			"footer_columns_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer columns', 'nelson' ),
				'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'nelson' ) ),
				'dependency' => array(
					"footer_type_{$cpt}"    => array( 'default' ),
					"footer_widgets_{$cpt}" => array( '^hide' ),
				),
				'std'        => 0,
				'options'    => nelson_get_list_range( 0, 6 ),
				'type'       => 'select',
			),
			"footer_wide_{$cpt}"            => array(
				'title'      => esc_html__( 'Footer fullwidth', 'nelson' ),
				'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'nelson' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 0,
				'type'       => 'checkbox',
			),

			"widgets_info_{$cpt}"           => array(
				'title' => esc_html__( 'Additional panels', 'nelson' ),
				'desc'  => '',
				'type'  => NELSON_THEME_FREE ? 'hidden' : 'info',
			),
			"widgets_above_page_{$cpt}"     => array(
				'title'   => esc_html__( 'Widgets at the top of the page', 'nelson' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'nelson' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => NELSON_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_above_content_{$cpt}"  => array(
				'title'   => esc_html__( 'Widgets above the content', 'nelson' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'nelson' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => NELSON_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_below_content_{$cpt}"  => array(
				'title'   => esc_html__( 'Widgets below the content', 'nelson' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'nelson' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => NELSON_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_below_page_{$cpt}"     => array(
				'title'   => esc_html__( 'Widgets at the bottom of the page', 'nelson' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'nelson' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => NELSON_THEME_FREE ? 'hidden' : 'select',
			),
		);
	}
}


// Return lists with choises when its need in the admin mode
if ( ! function_exists( 'nelson_options_get_list_choises' ) ) {
	add_filter( 'nelson_filter_options_get_list_choises', 'nelson_options_get_list_choises', 10, 2 );
	function nelson_options_get_list_choises( $list, $id ) {
		if ( is_array( $list ) && count( $list ) == 0 ) {
			if ( strpos( $id, 'header_style' ) === 0 ) {
				$list = nelson_get_list_header_styles( strpos( $id, 'header_style_' ) === 0 );
			} elseif ( strpos( $id, 'header_position' ) === 0 ) {
				$list = nelson_get_list_header_positions( strpos( $id, 'header_position_' ) === 0 );
			} elseif ( strpos( $id, 'header_widgets' ) === 0 ) {
				$list = nelson_get_list_sidebars( strpos( $id, 'header_widgets_' ) === 0, true );
			} elseif ( strpos( $id, '_scheme' ) > 0 ) {
				$list = nelson_get_list_schemes( 'color_scheme' != $id );
			} else if ( strpos( $id, 'sidebar_style' ) === 0 ) {
				$list = nelson_get_list_sidebar_styles( strpos( $id, 'sidebar_style_' ) === 0 );
			} elseif ( strpos( $id, 'sidebar_widgets' ) === 0 ) {
				$list = nelson_get_list_sidebars( 'sidebar_widgets_single' != $id && ( strpos( $id, 'sidebar_widgets_' ) === 0 || strpos( $id, 'sidebar_widgets_single_' ) === 0 ), true );
			} elseif ( strpos( $id, 'sidebar_position_ss' ) === 0 ) {
				$list = nelson_get_list_sidebars_positions_ss( strpos( $id, 'sidebar_position_ss_' ) === 0 );
			} elseif ( strpos( $id, 'sidebar_position' ) === 0 ) {
				$list = nelson_get_list_sidebars_positions( strpos( $id, 'sidebar_position_' ) === 0 );
			} elseif ( strpos( $id, 'widgets_above_page' ) === 0 ) {
				$list = nelson_get_list_sidebars( strpos( $id, 'widgets_above_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_above_content' ) === 0 ) {
				$list = nelson_get_list_sidebars( strpos( $id, 'widgets_above_content_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_page' ) === 0 ) {
				$list = nelson_get_list_sidebars( strpos( $id, 'widgets_below_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_content' ) === 0 ) {
				$list = nelson_get_list_sidebars( strpos( $id, 'widgets_below_content_' ) === 0, true );
			} elseif ( strpos( $id, 'footer_style' ) === 0 ) {
				$list = nelson_get_list_footer_styles( strpos( $id, 'footer_style_' ) === 0 );
			} elseif ( strpos( $id, 'footer_widgets' ) === 0 ) {
				$list = nelson_get_list_sidebars( strpos( $id, 'footer_widgets_' ) === 0, true );
			} elseif ( strpos( $id, 'blog_style' ) === 0 ) {
				$list = nelson_get_list_blog_styles( strpos( $id, 'blog_style_' ) === 0 );
			} elseif ( strpos( $id, 'single_style' ) === 0 ) {
				$list = nelson_get_list_single_styles( strpos( $id, 'single_style_' ) === 0 );
			} elseif ( strpos( $id, 'post_type' ) === 0 ) {
				$list = nelson_get_list_posts_types();
			} elseif ( strpos( $id, 'parent_cat' ) === 0 ) {
				$list = nelson_array_merge( array( 0 => esc_html__( '- Select category -', 'nelson' ) ), nelson_get_list_categories() );
			} elseif ( strpos( $id, 'blog_animation' ) === 0 ) {
				$list = nelson_get_list_animations_in();
			} elseif ( 'color_scheme_editor' == $id ) {
				$list = nelson_get_list_schemes();
			} elseif ( strpos( $id, '_font-family' ) > 0 ) {
				$list = nelson_get_list_load_fonts( true );
			}
		}
		return $list;
	}
}
