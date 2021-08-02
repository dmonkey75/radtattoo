<?php
/**
 * Theme functions: init, enqueue scripts and styles, include required files and widgets
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */

if ( ! defined( 'NELSON_THEME_DIR' ) ) {
	define( 'NELSON_THEME_DIR', trailingslashit( get_template_directory() ) );
}
if ( ! defined( 'NELSON_THEME_URL' ) ) {
	define( 'NELSON_THEME_URL', trailingslashit( get_template_directory_uri() ) );
}
if ( ! defined( 'NELSON_CHILD_DIR' ) ) {
	define( 'NELSON_CHILD_DIR', trailingslashit( get_stylesheet_directory() ) );
}
if ( ! defined( 'NELSON_CHILD_URL' ) ) {
	define( 'NELSON_CHILD_URL', trailingslashit( get_stylesheet_directory_uri() ) );
}

//-------------------------------------------------------
//-- Theme init
//-------------------------------------------------------

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

if ( ! function_exists( 'nelson_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'nelson_theme_setup1', 1 );
	function nelson_theme_setup1() {
		// Make theme available for translation
		// Translations can be filed in the /languages directory
		// Attention! Translations must be loaded before first call any translation functions!
		load_theme_textdomain( 'nelson', NELSON_THEME_DIR . 'languages' );
	}
}

if ( ! function_exists( 'nelson_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'nelson_theme_setup' );
	function nelson_theme_setup() {

		// Set theme content width
		$GLOBALS['content_width'] = apply_filters( 'nelson_filter_content_width', nelson_get_theme_option( 'page_width' ) );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Custom header setup
		add_theme_support( 'custom-header',
			array(
				'header-text' => false,
				'video'       => true,
			)
		);

		// Custom logo
		add_theme_support( 'custom-logo',
			array(
				'width'       => 250,
				'height'      => 60,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
		// Custom backgrounds setup
		add_theme_support( 'custom-background', array() );

		// Partial refresh support in the Customize
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Supported posts formats
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat' ) );

		// Autogenerate title tag
		add_theme_support( 'title-tag' );

		// Add theme menus
		add_theme_support( 'nav-menus' );

		// Switch default markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		// Register navigation menu
		register_nav_menus(
			array(
				'menu_main'   => esc_html__( 'Main Menu', 'nelson' ),
				'menu_mobile' => esc_html__( 'Mobile Menu', 'nelson' ),
				'menu_footer' => esc_html__( 'Footer Menu', 'nelson' ),
			)
		);

		// Register theme-specific thumb sizes
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 370, 0, false );
		$thumb_sizes = nelson_storage_get( 'theme_thumbs' );
		$mult        = nelson_get_theme_option( 'retina_ready', 1 );
		if ( $mult > 1 ) {
			$GLOBALS['content_width'] = apply_filters( 'nelson_filter_content_width', 1170 * $mult );
		}
		foreach ( $thumb_sizes as $k => $v ) {
			add_image_size( $k, $v['size'][0], $v['size'][1], $v['size'][2] );
			if ( $mult > 1 ) {
				add_image_size( $k . '-@retina', $v['size'][0] * $mult, $v['size'][1] * $mult, $v['size'][2] );
			}
		}
		// Add new thumb names
		add_filter( 'image_size_names_choose', 'nelson_theme_thumbs_sizes' );

		// Excerpt filters
		add_filter( 'excerpt_length', 'nelson_excerpt_length' );
		add_filter( 'excerpt_more', 'nelson_excerpt_more' );

		// Comment form
		add_filter( 'comment_form_fields', 'nelson_comment_form_fields' );
		add_filter( 'comment_form_fields', 'nelson_comment_form_agree', 11 );

		// Add required meta tags in the head
		add_action( 'wp_head', 'nelson_wp_head', 0 );

		// Load current page/post customization (if present)
		add_action( 'wp_footer', 'nelson_wp_footer' );
		add_action( 'admin_footer', 'nelson_wp_footer' );

		// Enqueue scripts and styles for the frontend
		add_action( 'wp_enqueue_scripts', 'nelson_wp_styles', 1000 );              // priority 1000 - load main theme styles
		add_action( 'wp_enqueue_scripts', 'nelson_wp_styles_plugins', 1100 );      // priority 1100 - load styles of the supported plugins
		add_action( 'wp_enqueue_scripts', 'nelson_wp_styles_custom', 1200 );       // priority 1200 - load styles with custom fonts and colors
		add_action( 'wp_enqueue_scripts', 'nelson_wp_styles_child', 1500 );        // priority 1500 - load styles of the child theme
		add_action( 'wp_enqueue_scripts', 'nelson_wp_styles_responsive', 2000 );   // priority 2000 - load responsive styles after all other styles

		// Enqueue scripts for the frontend
		add_action( 'wp_enqueue_scripts', 'nelson_wp_scripts', 1000 );             // priority 1000 - load main theme scripts
		add_action( 'wp_footer', 'nelson_localize_scripts' );

		// Add body classes
		add_filter( 'body_class', 'nelson_add_body_classes' );

		// Register sidebars
		add_action( 'widgets_init', 'nelson_register_sidebars' );
	}
}


//-------------------------------------------------------
//-- Theme styles
//-------------------------------------------------------

// Load frontend styles
if ( ! function_exists( 'nelson_wp_styles' ) ) {
		function nelson_wp_styles() {

		// Links to selected fonts
		$links = nelson_theme_fonts_links();
		if ( count( $links ) > 0 ) {
			foreach ( $links as $slug => $link ) {
				wp_enqueue_style( sprintf( 'nelson-font-%s', $slug ), $link, array(), null );
			}
		}

		// Font icons styles must be loaded before main stylesheet
		// This style NEED the theme prefix, because style 'fontello' in some plugin contain different set of characters
		// and can't be used instead this style!
		wp_enqueue_style( 'fontello-style', nelson_get_file_url( 'css/font-icons/css/fontello.css' ), array(), null );

		// Load main stylesheet
		$main_stylesheet = NELSON_THEME_URL . 'style.css';
		wp_enqueue_style( 'nelson-main', $main_stylesheet, array(), null );

		// Add custom bg image
		$bg_image = nelson_remove_protocol_from_url( nelson_get_theme_option( 'front_page_bg_image' ), false );
		if ( is_front_page() && ! empty( $bg_image ) && nelson_is_on( nelson_get_theme_option( 'front_page_enabled' ) ) ) {
			// Add custom bg image for the Front page
			wp_add_inline_style( 'nelson-main', 'body.frontpage, body.home-page { background-image:url(' . esc_url( $bg_image ) . ') !important }' );
		} else {
			// Add custom bg image for the body_style == 'boxed'
			$bg_image = nelson_get_theme_option( 'boxed_bg_image' );
			if ( nelson_get_theme_option( 'body_style' ) == 'boxed' && ! empty( $bg_image ) ) {
				wp_add_inline_style( 'nelson-main', '.body_style_boxed { background-image:url(' . esc_url( $bg_image ) . ') !important }' );
			}
		}

		// Add post nav background
		nelson_add_bg_in_post_nav();
	}
}

// Load styles of the supported plugins
if ( ! function_exists( 'nelson_wp_styles_plugins' ) ) {
		function nelson_wp_styles_plugins() {
		if ( nelson_is_off( nelson_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_style( 'nelson-plugins', nelson_get_file_url( 'css/__plugins.css' ), array(), null );
		}
	}
}

// Load styles with custom fonts and colors
if ( ! function_exists( 'nelson_wp_styles_custom' ) ) {
		function nelson_wp_styles_custom() {
		if ( ! is_customize_preview() && ! isset( $_GET['color_scheme'] ) && nelson_is_off( nelson_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_style( 'nelson-custom', nelson_get_file_url( 'css/__custom.css' ), array(), null );
			if ( nelson_get_theme_setting( 'separate_schemes' ) ) {
				$schemes = nelson_get_sorted_schemes();
				if ( is_array( $schemes ) ) {
					foreach ( $schemes as $scheme => $data ) {
						wp_enqueue_style( "nelson-color-{$scheme}", nelson_get_file_url( "css/__colors-{$scheme}.css" ), array(), null );
					}
				}
			}
		} else {
			wp_enqueue_style( 'nelson-custom', nelson_get_file_url( 'css/__custom-inline.css' ), array(), null );
			wp_add_inline_style( 'nelson-custom', nelson_customizer_get_css() );
		}
	}
}

// Load child-theme stylesheet (if different) after all theme styles
if ( ! function_exists( 'nelson_wp_styles_child' ) ) {
		function nelson_wp_styles_child() {
		$main_stylesheet  = NELSON_THEME_URL . 'style.css';
		$child_stylesheet = NELSON_CHILD_URL . 'style.css';
		if ( $child_stylesheet != $main_stylesheet ) {
			wp_enqueue_style( 'nelson-child', $child_stylesheet, array( 'nelson-main' ), null );
		}
	}
}

// Load responsive styles (priority 2000 - load it after main styles and plugins custom styles)
if ( ! function_exists( 'nelson_wp_styles_responsive' ) ) {
		function nelson_wp_styles_responsive() {
		if ( nelson_is_off( nelson_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_style( 'nelson-responsive', nelson_get_file_url( 'css/__responsive.css' ), array(), null );
		} else {
			wp_enqueue_style( 'nelson-responsive', nelson_get_file_url( 'css/responsive.css' ), array(), null );
		}
	}
}


//-------------------------------------------------------
//-- Theme scripts
//-------------------------------------------------------

// Load frontend scripts
if ( ! function_exists( 'nelson_wp_scripts' ) ) {
		function nelson_wp_scripts() {
		$blog_archive = nelson_storage_get( 'blog_archive' ) === true || is_home();
		$blog_style   = nelson_get_theme_option( 'blog_style' );
		if ( strpos( $blog_style, 'blog-custom-' ) === 0 ) {
			$blog_id   = nelson_get_custom_blog_id( $blog_style );
			$blog_meta = nelson_get_custom_layout_meta( $blog_id );
			if ( ! empty( $blog_meta['scripts_required'] ) && ! nelson_is_off( $blog_meta['scripts_required'] ) ) {
				$blog_style = $blog_meta['scripts_required'];
			}
		}
		$need_masonry = ( $blog_archive 
							&& in_array( substr( $blog_style, 0, 7 ), array( 'gallery', 'portfol', 'masonry' ) ) )
						|| ( is_single()
							&& str_replace( 'post-format-', '', get_post_format() ) == 'gallery' );

		// Modernizr will load in head before other scripts and styles
		if ( $need_masonry ) {
			wp_enqueue_script( 'modernizr', nelson_get_file_url( 'js/theme-gallery/modernizr.min.js' ), array(), null, false );
		}

		// Superfish Menu
		// Attention! To prevent duplicate this script in the plugin and in the menu, don't merge it!
		wp_enqueue_script( 'superfish', nelson_get_file_url( 'js/superfish/superfish.min.js' ), array( 'jquery' ), null, true );

		// Merged scripts
		if ( nelson_is_off( nelson_get_theme_option( 'debug_mode' ) ) ) {
			wp_enqueue_script( 'nelson-init', nelson_get_file_url( 'js/__scripts.js' ), array( 'jquery' ), null, true );
		} else {
			// Skip link focus
			wp_enqueue_script( 'skip-link-focus-fix', nelson_get_file_url( 'js/skip-link-focus-fix.js' ), null, true );
			// Background video
			$header_video = nelson_get_header_video();
			if ( ! empty( $header_video ) && ! nelson_is_inherit( $header_video ) ) {
				if ( nelson_is_youtube_url( $header_video ) ) {
					wp_enqueue_script( 'tubular', nelson_get_file_url( 'js/jquery.tubular.js' ), array( 'jquery' ), null, true );
				} else {
					wp_enqueue_script( 'bideo', nelson_get_file_url( 'js/bideo.js' ), array(), null, true );
				}
			}
			// Theme scripts
			wp_enqueue_script( 'nelson-utils', nelson_get_file_url( 'js/theme-utils.js' ), array( 'jquery' ), null, true );
			wp_enqueue_script( 'nelson-init', nelson_get_file_url( 'js/theme-init.js' ), array( 'jquery' ), null, true );
		}
		// Load scripts for 'Masonry' layout
		if ( $need_masonry ) {
			nelson_load_masonry_scripts();
		}
		// Load scripts for 'Portfolio' layout
		if ( $blog_archive
				&& in_array( substr( $blog_style, 0, 7 ), array( 'gallery', 'portfol' ) )
				&& ! is_customize_preview() ) {
			wp_enqueue_script( 'jquery-ui-tabs', false, array( 'jquery', 'jquery-ui-core' ), null, true );
		}

		// Comments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Media elements library
		if ( nelson_get_theme_setting( 'use_mediaelements' ) ) {
			wp_enqueue_style( 'mediaelement' );
			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_script( 'mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		}
	}
}


// Add variables to the scripts in the frontend
if ( ! function_exists( 'nelson_localize_scripts' ) ) {
		function nelson_localize_scripts() {

		$video = nelson_get_header_video();

		wp_localize_script(
			'nelson-init', 'NELSON_STORAGE', apply_filters(
				'nelson_filter_localize_script', array(
					// AJAX parameters
					'ajax_url'            => esc_url( admin_url( 'admin-ajax.php' ) ),
					'ajax_nonce'          => esc_attr( wp_create_nonce( admin_url( 'admin-ajax.php' ) ) ),

					// Site base url
					'site_url'            => get_home_url(),
					'theme_url'           => NELSON_THEME_URL,

					// Site color scheme
					'site_scheme'         => sprintf( 'scheme_%s', nelson_get_theme_option( 'color_scheme' ) ),

					// User logged in
					'user_logged_in'      => is_user_logged_in() ? true : false,

					// Window width to switch the site header to the mobile layout
					'mobile_layout_width' => 767,
					'mobile_device'       => wp_is_mobile(),

					// Sidemenu options
					'menu_side_stretch'   => nelson_get_theme_option( 'menu_side_stretch' ) > 0,
					'menu_side_icons'     => nelson_get_theme_option( 'menu_side_icons' ) > 0,

					// Video background
					'background_video'    => nelson_is_from_uploads( $video ) ? $video : '',

					// Video and Audio tag wrapper
					'use_mediaelements'   => nelson_get_theme_setting( 'use_mediaelements' ) ? true : false,

					// Allow open full post in the blog
					'open_full_post'      => nelson_get_theme_option( 'open_full_post_in_blog' ) > 0,

					// Current mode
					'admin_mode'          => false,

					// Strings for translation
					'msg_ajax_error'      => esc_html__( 'Invalid server answer!', 'nelson' ),
				)
			)
		);
	}
}

// Enqueue masonry, portfolio and gallery-specific scripts
if ( ! function_exists( 'nelson_load_masonry_scripts' ) ) {
	function nelson_load_masonry_scripts() {
		wp_enqueue_script( 'modernizr', nelson_get_file_url( 'js/theme-gallery/modernizr.min.js' ), array(), null, false );
		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( 'masonry' );
		wp_enqueue_script( 'classie', nelson_get_file_url( 'js/theme-gallery/classie.min.js' ), array(), null, true );
		wp_enqueue_script( 'nelson-gallery-script', nelson_get_file_url( 'js/theme-gallery/theme-gallery.js' ), array(), null, true );
	}
}


//-------------------------------------------------------
//-- Head, body and footer
//-------------------------------------------------------

//  Add meta tags in the header for frontend
if ( ! function_exists( 'nelson_wp_head' ) ) {
		function nelson_wp_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="format-detection" content="telephone=no">
		<link rel="profile" href="//gmpg.org/xfn/11">
		<?php
		if ( is_singular() && pings_open() ) {
			?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
			<?php
		}	
	}
}

// Add theme specified classes to the body
if ( ! function_exists( 'nelson_add_body_classes' ) ) {
		function nelson_add_body_classes( $classes ) {
		$classes[] = 'body_tag';    // Need for the .scheme_self
		$classes[] = 'scheme_' . esc_attr( nelson_get_theme_option( 'color_scheme' ) );

		$blog_mode = nelson_storage_get( 'blog_mode' );
		$classes[] = 'blog_mode_' . esc_attr( $blog_mode );
		$classes[] = 'body_style_' . esc_attr( nelson_get_theme_option( 'body_style' ) );

		if ( in_array( $blog_mode, array( 'post', 'page' ) ) ) {
			$classes[] = 'is_single';
		} else {
			$classes[] = ' is_stream';
			$classes[] = 'blog_style_' . esc_attr( nelson_get_theme_option( 'blog_style' ) );
			if ( nelson_storage_get( 'blog_template' ) > 0 ) {
				$classes[] = 'blog_template';
			}
		}

		if ( is_singular( 'post' ) || is_singular( 'attachment' ) ) {
			$classes[] = 'single_style_' . esc_attr( nelson_get_theme_option( 'single_style' ) );
		}

		if ( nelson_sidebar_present() ) {
			$classes[] = 'sidebar_show sidebar_' . esc_attr( nelson_get_theme_option( 'sidebar_position' ) );
			$classes[] = 'sidebar_small_screen_' . esc_attr( nelson_get_theme_option( 'sidebar_position_ss' ) );
		} else {
			$classes[] = 'sidebar_hide';
			if ( nelson_is_on( nelson_get_theme_option( 'expand_content' ) ) ) {
				$classes[] = 'expand_content';
			}
		}

		if ( nelson_is_on( nelson_get_theme_option( 'remove_margins' ) ) ) {
			$classes[] = 'remove_margins';
		}

		$bg_image = nelson_get_theme_option( 'front_page_bg_image' );
		if ( is_front_page() && nelson_is_on( nelson_get_theme_option( 'front_page_enabled' ) ) && ! empty( $bg_image ) ) {
			$classes[] = 'with_bg_image';
		}

		$classes[] = 'trx_addons_' . esc_attr( nelson_exists_trx_addons() ? 'present' : 'absent' );

		$classes[] = 'header_type_' . esc_attr( nelson_get_theme_option( 'header_type' ) );
		$classes[] = 'header_style_' . esc_attr( 'default' == nelson_get_theme_option( 'header_type' ) ? 'header-default' : nelson_get_theme_option( 'header_style' ) );
		$classes[] = 'header_position_' . esc_attr( nelson_get_theme_option( 'header_position' ) );

		$menu_style = nelson_get_theme_option( 'menu_style' );
		$classes[]  = 'menu_style_' . esc_attr( $menu_style ) . ( in_array( $menu_style, array( 'left', 'right' ) ) ? ' menu_style_side' : '' );
		$classes[]  = 'no_layout';

		return $classes;
	}
}

// Load current page/post customization (if present)
if ( ! function_exists( 'nelson_wp_footer' ) ) {
		//and add_action('admin_footer', 'nelson_wp_footer');
	function nelson_wp_footer() {
		// Add header zoom
		$header_zoom = max( 0.2, min( 2, (float) nelson_get_theme_option( 'header_zoom' ) ) );
		if ( 1 != $header_zoom ) {
			nelson_add_inline_css( ".sc_layouts_title_title{font-size:{$header_zoom}em}" );
		}
		// Add logo zoom
		$logo_zoom = max( 0.2, min( 2, (float) nelson_get_theme_option( 'logo_zoom' ) ) );
		if ( 1 != $logo_zoom ) {
			nelson_add_inline_css( ".custom-logo-link,.sc_layouts_logo{font-size:{$logo_zoom}em}" );
		}
		// Put inline styles to the output
		$css = nelson_get_inline_css();
		if ( ! empty( $css ) ) {
			wp_enqueue_style( 'nelson-inline-styles', nelson_get_file_url( 'css/__inline.css' ), array(), null );
			wp_add_inline_style( 'nelson-inline-styles', $css );
		}
	}
}

/**
 * Fire the wp_body_open action.
 *
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
 */
if ( ! function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		/**
		 * Triggered after the opening <body> tag.
		 */
		do_action('wp_body_open');
	}
}


//-------------------------------------------------------
//-- Sidebars and widgets
//-------------------------------------------------------

// Register widgetized areas
if ( ! function_exists( 'nelson_register_sidebars' ) ) {
		function nelson_register_sidebars() {
		$sidebars = nelson_get_sidebars();
		if ( is_array( $sidebars ) && count( $sidebars ) > 0 ) {
			$cnt = 0;
			foreach ( $sidebars as $id => $sb ) {
				$cnt++;
				register_sidebar(
					apply_filters( 'nelson_filter_register_sidebar',
						array(
							'name'          => $sb['name'],
							'description'   => $sb['description'],
							// Translators: Add the sidebar number to the id
							'id'            => ! empty( $id ) ? $id : sprintf( 'theme_sidebar_%d', $cnt),
							'before_widget' => '<aside id="%1$s" class="widget %2$s">',
							'after_widget'  => '</aside>',
							'before_title'  => '<h4 class="widget_title">',
							'after_title'   => '</h4>',
						)
					)
				);
			}
		}
	}
}

// Return theme specific widgetized areas
if ( ! function_exists( 'nelson_get_sidebars' ) ) {
	function nelson_get_sidebars() {
		$list = apply_filters(
			'nelson_filter_list_sidebars', array(
				'sidebar_widgets'       => array(
					'name'        => esc_html__( 'Sidebar Widgets', 'nelson' ),
					'description' => esc_html__( 'Widgets to be shown on the main sidebar', 'nelson' ),
				),
				'header_widgets'        => array(
					'name'        => esc_html__( 'Header Widgets', 'nelson' ),
					'description' => esc_html__( 'Widgets to be shown at the top of the page (in the page header area)', 'nelson' ),
				),
				'above_page_widgets'    => array(
					'name'        => esc_html__( 'Top Page Widgets', 'nelson' ),
					'description' => esc_html__( 'Widgets to be shown below the header, but above the content and sidebar', 'nelson' ),
				),
				'above_content_widgets' => array(
					'name'        => esc_html__( 'Above Content Widgets', 'nelson' ),
					'description' => esc_html__( 'Widgets to be shown above the content, near the sidebar', 'nelson' ),
				),
				'below_content_widgets' => array(
					'name'        => esc_html__( 'Below Content Widgets', 'nelson' ),
					'description' => esc_html__( 'Widgets to be shown below the content, near the sidebar', 'nelson' ),
				),
				'below_page_widgets'    => array(
					'name'        => esc_html__( 'Bottom Page Widgets', 'nelson' ),
					'description' => esc_html__( 'Widgets to be shown below the content and sidebar, but above the footer', 'nelson' ),
				),
				'footer_widgets'        => array(
					'name'        => esc_html__( 'Footer Widgets', 'nelson' ),
					'description' => esc_html__( 'Widgets to be shown at the bottom of the page (in the page footer area)', 'nelson' ),
				),
			)
		);
		return $list;
	}
}


//-------------------------------------------------------
//-- Theme fonts
//-------------------------------------------------------

// Return links for all theme fonts
if ( ! function_exists( 'nelson_theme_fonts_links' ) ) {
	function nelson_theme_fonts_links() {
		$links = array();

		/*
		Translators: If there are characters in your language that are not supported
		by chosen font(s), translate this to 'off'. Do not translate into your own language.
		*/
		$google_fonts_enabled = ( 'off' !== esc_attr_x( 'on', 'Google fonts: on or off', 'nelson' ) );
		$custom_fonts_enabled = ( 'off' !== esc_attr_x( 'on', 'Custom fonts (included in the theme): on or off', 'nelson' ) );

		if ( ( $google_fonts_enabled || $custom_fonts_enabled ) && ! nelson_storage_empty( 'load_fonts' ) ) {
			$load_fonts = nelson_storage_get( 'load_fonts' );
			if ( count( $load_fonts ) > 0 ) {
				$google_fonts = '';
				foreach ( $load_fonts as $font ) {
					$url = '';
					if ( $custom_fonts_enabled && empty( $font['styles'] ) ) {
						$slug = nelson_get_load_fonts_slug( $font['name'] );
						$url  = nelson_get_file_url( "css/font-face/{$slug}/stylesheet.css" );
						if ( ! empty( $url ) ) {
							$links[ $slug ] = $url;
						}
					}
					if ( $google_fonts_enabled && empty( $url ) ) {
						// Attention! Using '%7C' instead '|' damage loading second+ fonts
						$google_fonts .= ( $google_fonts ? '|' : '' )
										. str_replace( ' ', '+', $font['name'] )
										. ':'
										. ( empty( $font['styles'] ) ? '400,400italic,700,700italic' : $font['styles'] );
					}
				}
				if ( $google_fonts_enabled && ! empty( $google_fonts ) ) {
					$google_fonts_subset = nelson_get_theme_option( 'load_fonts_subset' );
					$links['google_fonts'] = esc_url( "https://fonts.googleapis.com/css?family={$google_fonts}&subset={$google_fonts_subset}" );
				}
			}
		}
		return $links;
	}
}

// Return links for WP Editor
if ( ! function_exists( 'nelson_theme_fonts_for_editor' ) ) {
	function nelson_theme_fonts_for_editor() {
		$links = array_values( nelson_theme_fonts_links() );
		if ( is_array( $links ) && count( $links ) > 0 ) {
			for ( $i = 0; $i < count( $links ); $i++ ) {
				$links[ $i ] = str_replace( ',', '%2C', $links[ $i ] );
			}
		}
		return $links;
	}
}


//-------------------------------------------------------
//-- The Excerpt
//-------------------------------------------------------
if ( ! function_exists( 'nelson_excerpt_length' ) ) {
		function nelson_excerpt_length( $length ) {
		$blog_style = explode( '_', nelson_get_theme_option( 'blog_style' ) );
		return max( 0, round( nelson_get_theme_option( 'excerpt_length' ) / ( in_array( $blog_style[0], array( 'classic', 'masonry', 'portfolio' ) ) ? 2 : 1 ) ) );
	}
}

if ( ! function_exists( 'nelson_excerpt_more' ) ) {
		function nelson_excerpt_more( $more ) {
		return '&hellip;';
	}
}


//-------------------------------------------------------
//-- Comments
//-------------------------------------------------------

// Comment form fields order
if ( ! function_exists( 'nelson_comment_form_fields' ) ) {
		function nelson_comment_form_fields( $comment_fields ) {
		if ( nelson_get_theme_setting( 'comment_after_name' ) ) {
			$keys = array_keys( $comment_fields );
			if ( 'comment' == $keys[0] ) {
				$comment_fields['comment'] = array_shift( $comment_fields );
			}
		}
		return $comment_fields;
	}
}

// Add checkbox with "I agree ..."
if ( ! function_exists( 'nelson_comment_form_agree' ) ) {
		function nelson_comment_form_agree( $comment_fields ) {
		$privacy_text = nelson_get_privacy_text();
		if ( ! empty( $privacy_text )
			&& ( ! function_exists( 'nelson_exists_gdpr_framework' ) || ! nelson_exists_gdpr_framework() )
			&& ( ! function_exists( 'nelson_exists_wp_gdpr_compliance' ) || ! nelson_exists_wp_gdpr_compliance() )
		) {
			$comment_fields['i_agree_privacy_policy'] = nelson_single_comments_field(
				array(
					'form_style'        => 'default',
					'field_type'        => 'checkbox',
					'field_req'         => '',
					'field_icon'        => '',
					'field_value'       => '1',
					'field_name'        => 'i_agree_privacy_policy',
					'field_title'       => $privacy_text,
				)
			);
		}
		return $comment_fields;
	}
}



//-------------------------------------------------------
//-- Thumb sizes
//-------------------------------------------------------
if ( ! function_exists( 'nelson_theme_thumbs_sizes' ) ) {
		function nelson_theme_thumbs_sizes( $sizes ) {
		$thumb_sizes = nelson_storage_get( 'theme_thumbs' );
		$mult        = nelson_get_theme_option( 'retina_ready', 1 );
		foreach ( $thumb_sizes as $k => $v ) {
			$sizes[ $k ] = $v['title'];
			if ( $mult > 1 ) {
				$sizes[ $k . '-@retina' ] = $v['title'] . ' ' . esc_html__( '@2x', 'nelson' );
			}
		}
		return $sizes;
	}
}


// Disable a new Widgets block editor
if (!function_exists('nelson_widgets_disable_block_editor')) {
    add_action( 'after_setup_theme', 'nelson_widgets_disable_block_editor' );
    function nelson_widgets_disable_block_editor() {
        remove_theme_support( 'widgets-block-editor' );
    }
}

//-------------------------------------------------------
//-- Include theme (or child) PHP-files
//-------------------------------------------------------

require_once NELSON_THEME_DIR . 'includes/utils.php';
require_once NELSON_THEME_DIR . 'includes/storage.php';

require_once NELSON_THEME_DIR . 'includes/lists.php';
require_once NELSON_THEME_DIR . 'includes/wp.php';

if ( is_admin() ) {
	require_once NELSON_THEME_DIR . 'includes/tgmpa/class-tgm-plugin-activation.php';
	require_once NELSON_THEME_DIR . 'includes/admin.php';
}

require_once NELSON_THEME_DIR . 'theme-options/theme-customizer.php';

require_once NELSON_THEME_DIR . 'front-page/front-page-options.php';

require_once NELSON_THEME_DIR . 'theme-specific/theme-tags.php';
require_once NELSON_THEME_DIR . 'theme-specific/theme-hovers/theme-hovers.php';
require_once NELSON_THEME_DIR . 'theme-specific/theme-about/theme-about.php';

// Free themes support
if ( NELSON_THEME_FREE ) {
	require_once NELSON_THEME_DIR . 'theme-specific/theme-about/theme-upgrade.php';
}

// Plugins support
$nelson_required_plugins = nelson_storage_get( 'required_plugins' );
if ( is_array( $nelson_required_plugins ) ) {
	foreach ( $nelson_required_plugins as $plugin_slug => $plugin_data ) {
		$plugin_slug = nelson_esc( $plugin_slug );
		$plugin_path = NELSON_THEME_DIR . sprintf( 'plugins/%1$s/%1$s.php', $plugin_slug );
		if ( file_exists( $plugin_path ) ) {
			require_once $plugin_path;
		}
	}
}

// Theme skins support
if ( defined( 'NELSON_ALLOW_SKINS' ) && NELSON_ALLOW_SKINS && file_exists( NELSON_THEME_DIR . 'skins/skins.php' ) ) {
	require_once NELSON_THEME_DIR . 'skins/skins.php';
}
