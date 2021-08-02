<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */

							// Widgets area inside page content
							nelson_create_widgets_area( 'widgets_below_content' );
							?>
						</div><!-- </.content> -->
					<?php

					// Show main sidebar
					get_sidebar();
					?>
					</div><!-- </.content_wrap> -->
					<?php

					// Widgets area below page content and related posts below page content
					$nelson_body_style = nelson_get_theme_option( 'body_style' );
					$nelson_widgets_name = nelson_get_theme_option( 'widgets_below_page' );
					$nelson_show_widgets = ! nelson_is_off( $nelson_widgets_name ) && is_active_sidebar( $nelson_widgets_name );
					$nelson_show_related = is_single() && nelson_get_theme_option( 'related_position' ) == 'below_page';
					if ( $nelson_show_widgets || $nelson_show_related ) {
						if ( 'fullscreen' != $nelson_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $nelson_show_related ) {
							do_action( 'nelson_action_related_posts' );
						}

						// Widgets area below page content
						if ( $nelson_show_widgets ) {
							nelson_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $nelson_body_style ) {
							?>
							</div><!-- </.content_wrap> -->
							<?php
						}
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Single posts banner before footer
			if ( is_singular( 'post' ) ) {
				nelson_show_post_banner('footer');
			}
			
			// Skip link anchor to fast access to the footer from keyboard
			?>
			<a id="footer_skip_link_anchor" class="nelson_skip_link_anchor" href="#"></a>
			<?php
			
			// Footer
			$nelson_footer_type = nelson_get_theme_option( 'footer_type' );
			if ( 'custom' == $nelson_footer_type && ! nelson_is_layouts_available() ) {
				$nelson_footer_type = 'default';
			}
			get_template_part( apply_filters( 'nelson_filter_get_template_part', "templates/footer-{$nelson_footer_type}" ) );
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php wp_footer(); ?>

</body>
</html>