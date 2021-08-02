<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.06
 */

$nelson_header_css   = '';
$nelson_header_image = get_header_image();
$nelson_header_video = nelson_get_header_video();
if ( ! empty( $nelson_header_image ) && nelson_trx_addons_featured_image_override( is_singular() || nelson_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$nelson_header_image = nelson_get_current_mode_image( $nelson_header_image );
}

$nelson_header_id = nelson_get_custom_header_id();
$nelson_header_meta = get_post_meta( $nelson_header_id, 'trx_addons_options', true );
if ( ! empty( $nelson_header_meta['margin'] ) ) {
	nelson_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( nelson_prepare_css_value( $nelson_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $nelson_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $nelson_header_id ) ) ); ?>
				<?php
				echo ! empty( $nelson_header_image ) || ! empty( $nelson_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
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

	// Custom header's layout
	do_action( 'nelson_action_show_layout', $nelson_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
