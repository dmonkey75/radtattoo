<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */

// Header sidebar
$nelson_header_name    = nelson_get_theme_option( 'header_widgets' );
$nelson_header_present = ! nelson_is_off( $nelson_header_name ) && is_active_sidebar( $nelson_header_name );
if ( $nelson_header_present ) {
	nelson_storage_set( 'current_sidebar', 'header' );
	$nelson_header_wide = nelson_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $nelson_header_name ) ) {
		dynamic_sidebar( $nelson_header_name );
	}
	$nelson_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $nelson_widgets_output ) ) {
		$nelson_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $nelson_widgets_output );
		$nelson_need_columns   = strpos( $nelson_widgets_output, 'columns_wrap' ) === false;
		if ( $nelson_need_columns ) {
			$nelson_columns = max( 0, (int) nelson_get_theme_option( 'header_columns' ) );
			if ( 0 == $nelson_columns ) {
				$nelson_columns = min( 6, max( 1, nelson_tags_count( $nelson_widgets_output, 'aside' ) ) );
			}
			if ( $nelson_columns > 1 ) {
				$nelson_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $nelson_columns ) . ' widget', $nelson_widgets_output );
			} else {
				$nelson_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $nelson_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $nelson_header_wide ) {
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
				nelson_show_layout( $nelson_widgets_output );
				do_action( 'nelson_action_after_sidebar' );
				if ( $nelson_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $nelson_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
