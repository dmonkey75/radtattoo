<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.10
 */

// Logo
if ( nelson_is_on( nelson_get_theme_option( 'logo_in_footer' ) ) ) {
	$nelson_logo_image = nelson_get_logo_image( 'footer' );
	$nelson_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $nelson_logo_image['logo'] ) || ! empty( $nelson_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $nelson_logo_image['logo'] ) ) {
					$nelson_attr = nelson_getimagesize( $nelson_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $nelson_logo_image['logo'] ) . '"'
								. ( ! empty( $nelson_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $nelson_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'nelson' ) . '"'
								. ( ! empty( $nelson_attr[3] ) ? ' ' . wp_kses_data( $nelson_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $nelson_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $nelson_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
