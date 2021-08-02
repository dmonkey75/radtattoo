<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */

if ( nelson_sidebar_present() ) {
	
	$nelson_sidebar_type = nelson_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $nelson_sidebar_type && ! nelson_is_layouts_available() ) {
		$nelson_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $nelson_sidebar_type ) {
		// Default sidebar with widgets
		$nelson_sidebar_name = nelson_get_theme_option( 'sidebar_widgets' );
		nelson_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $nelson_sidebar_name ) ) {
			dynamic_sidebar( $nelson_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$nelson_sidebar_id = nelson_get_custom_sidebar_id();
		do_action( 'nelson_action_show_layout', $nelson_sidebar_id );
	}
	$nelson_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $nelson_out ) ) {
		$nelson_sidebar_position    = nelson_get_theme_option( 'sidebar_position' );
		$nelson_sidebar_position_ss = nelson_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $nelson_sidebar_position );
			echo ' sidebar_' . esc_attr( $nelson_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $nelson_sidebar_type );

			if ( 'float' == $nelson_sidebar_position_ss ) {
				echo ' sidebar_float';
			}
			$nelson_sidebar_scheme = nelson_get_theme_option( 'sidebar_scheme' );
			if ( ! empty( $nelson_sidebar_scheme ) && ! nelson_is_inherit( $nelson_sidebar_scheme ) ) {
				echo ' scheme_' . esc_attr( $nelson_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php
			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="nelson_skip_link_anchor" href="#"></a>
			<?php
			// Single posts banner before sidebar
			nelson_show_post_banner( 'sidebar' );
			// Button to show/hide sidebar on mobile
			if ( in_array( $nelson_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$nelson_title = apply_filters( 'nelson_filter_sidebar_control_title', 'float' == $nelson_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'nelson' ) : '' );
				$nelson_text  = apply_filters( 'nelson_filter_sidebar_control_text', 'above' == $nelson_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'nelson' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $nelson_title ); ?>"><?php echo esc_html( $nelson_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'nelson_action_before_sidebar' );
				nelson_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $nelson_out ) );
				do_action( 'nelson_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<div class="clearfix"></div>
		<?php
	}
}
