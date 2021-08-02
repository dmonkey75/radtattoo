<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */

$nelson_header_css   = '';
$nelson_header_image = get_header_image();
$nelson_header_video = nelson_get_header_video();
if ( ! empty( $nelson_header_image ) && nelson_trx_addons_featured_image_override( is_singular() || nelson_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$nelson_header_image = nelson_get_current_mode_image( $nelson_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $nelson_header_image ) || ! empty( $nelson_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $nelson_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $nelson_header_image ) {
		echo ' ' . esc_attr( nelson_add_inline_css_class( 'background-image: url(' . esc_url( $nelson_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( nelson_is_on( nelson_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight nelson-full-height';
	}
	$nelson_header_scheme = nelson_get_theme_option( 'header_scheme' );
	if ( ! empty( $nelson_header_scheme ) && ! nelson_is_inherit( $nelson_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $nelson_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $nelson_header_video ) ) {
		get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	if ( nelson_get_theme_option( 'menu_style' ) == 'top' ) {
		get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/header-navi' ) );
	}

	// Mobile header
	if ( nelson_is_on( nelson_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/header-title' ) );

	// Header widgets area
	get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
