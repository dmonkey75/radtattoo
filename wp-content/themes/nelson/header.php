<?php
/**
 * The Header: Logo and main menu
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js
									<?php
										// Class scheme_xxx need in the <html> as context for the <body>!
										echo ' scheme_' . esc_attr( nelson_get_theme_option( 'color_scheme' ) );
									?>
										">
<head>
	<?php wp_head(); ?>
</head>

<body <?php	body_class(); ?>>

	<?php wp_body_open(); ?>

	<?php do_action( 'nelson_action_before_body' ); ?>

	<div class="body_wrap">

		<div class="page_wrap">
			
			<?php
			// Short links to fast access to the content, sidebar and footer from the keyboard
			?>
			<a class="nelson_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to content", 'nelson' ); ?></a>
			<?php if ( nelson_sidebar_present() ) { ?>
			<a class="nelson_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to sidebar", 'nelson' ); ?></a>
			<?php } ?>
			<a class="nelson_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to footer", 'nelson' ); ?></a>
			
			<?php
			// Header
			$nelson_header_type = nelson_get_theme_option( 'header_type' );
			if ( 'custom' == $nelson_header_type && ! nelson_is_layouts_available() ) {
				$nelson_header_type = 'default';
			}
			get_template_part( apply_filters( 'nelson_filter_get_template_part', "templates/header-{$nelson_header_type}" ) );

			// Side menu
			if ( in_array( nelson_get_theme_option( 'menu_style' ), array( 'left', 'right' ) ) ) {
				get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/header-navi-side' ) );
			}

			// Mobile menu
			get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/header-navi-mobile' ) );
			
			// Single posts banner after header
			nelson_show_post_banner( 'header' );
			?>

			<div class="page_content_wrap">
				<?php
				// Single posts banner on the background
				if ( is_singular( 'post' ) || is_singular( 'attachment' ) ) {
					nelson_show_post_banner( 'background' );
				}

				// Single post thumbnail and title
				get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/single-styles/' . nelson_get_theme_option( 'single_style' ) ) );

				// Widgets area above page content
				$nelson_body_style   = nelson_get_theme_option( 'body_style' );
				$nelson_widgets_name = nelson_get_theme_option( 'widgets_above_page' );
				$nelson_show_widgets = ! nelson_is_off( $nelson_widgets_name ) && is_active_sidebar( $nelson_widgets_name );
				if ( $nelson_show_widgets ) {
					if ( 'fullscreen' != $nelson_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					nelson_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $nelson_body_style ) {
						?>
						</div><!-- </.content_wrap> -->
						<?php
					}
				}

				// Content area
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $nelson_body_style ? '_fullscreen' : ''; ?>">

					<div class="content">
						<?php
						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="nelson_skip_link_anchor" href="#"></a>
						<?php
						// Widgets area inside page content
						nelson_create_widgets_area( 'widgets_above_content' );
