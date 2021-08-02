<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.10
 */

$nelson_footer_id = nelson_get_custom_footer_id();
$nelson_footer_meta = get_post_meta( $nelson_footer_id, 'trx_addons_options', true );
if ( ! empty( $nelson_footer_meta['margin'] ) ) {
	nelson_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( nelson_prepare_css_value( $nelson_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $nelson_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $nelson_footer_id ) ) ); ?>
						<?php
						$nelson_footer_scheme = nelson_get_theme_option( 'footer_scheme' );
						if ( ! empty( $nelson_footer_scheme ) && ! nelson_is_inherit( $nelson_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $nelson_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'nelson_action_show_layout', $nelson_footer_id );
	?>
</footer><!-- /.footer_wrap -->
