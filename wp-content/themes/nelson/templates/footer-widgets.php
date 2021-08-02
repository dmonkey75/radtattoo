<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.10
 */

// Footer sidebar
$nelson_footer_name    = nelson_get_theme_option( 'footer_widgets' );
$nelson_footer_present = ! nelson_is_off( $nelson_footer_name ) && is_active_sidebar( $nelson_footer_name );
if ( $nelson_footer_present ) {
	nelson_storage_set( 'current_sidebar', 'footer' );
	$nelson_footer_wide = nelson_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $nelson_footer_name ) ) {
		dynamic_sidebar( $nelson_footer_name );
	}
	$nelson_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $nelson_out ) ) {
		$nelson_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $nelson_out );
		$nelson_need_columns = true;   //or check: strpos($nelson_out, 'columns_wrap')===false;
		if ( $nelson_need_columns ) {
			$nelson_columns = max( 0, (int) nelson_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $nelson_columns ) {
				$nelson_columns = min( 4, max( 1, nelson_tags_count( $nelson_out, 'aside' ) ) );
			}
			if ( $nelson_columns > 1 ) {
				$nelson_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $nelson_columns ) . ' widget', $nelson_out );
			} else {
				$nelson_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $nelson_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $nelson_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $nelson_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'nelson_action_before_sidebar' );
				nelson_show_layout( $nelson_out );
				do_action( 'nelson_action_after_sidebar' );
				if ( $nelson_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $nelson_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
