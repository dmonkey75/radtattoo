<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$nelson_footer_scheme = nelson_get_theme_option( 'footer_scheme' );
if ( ! empty( $nelson_footer_scheme ) && ! nelson_is_inherit( $nelson_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $nelson_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/footer-socials' ) );

	// Menu
	get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/footer-menu' ) );

	// Copyright area
	get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
