<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */

$nelson_args = get_query_var( 'nelson_logo_args' );

// Site logo
$nelson_logo_type   = isset( $nelson_args['type'] ) ? $nelson_args['type'] : '';
$nelson_logo_image  = nelson_get_logo_image( $nelson_logo_type );
$nelson_logo_text   = nelson_is_on( nelson_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$nelson_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $nelson_logo_image['logo'] ) || ! empty( $nelson_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $nelson_logo_image['logo'] ) ) {
			if ( empty( $nelson_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric( $nelson_logo_image['logo'] ) && $nelson_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$nelson_attr = nelson_getimagesize( $nelson_logo_image['logo'] );
				echo '<img src="' . esc_url( $nelson_logo_image['logo'] ) . '"'
						. ( ! empty( $nelson_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $nelson_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $nelson_logo_text ) . '"'
						. ( ! empty( $nelson_attr[3] ) ? ' ' . wp_kses_data( $nelson_attr[3] ) : '' )
						. '>';
			}
		} else {
			nelson_show_layout( nelson_prepare_macros( $nelson_logo_text ), '<span class="logo_text">', '</span>' );
			nelson_show_layout( nelson_prepare_macros( $nelson_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
