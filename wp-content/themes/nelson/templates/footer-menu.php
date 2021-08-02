<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.10
 */

// Footer menu
$nelson_menu_footer = nelson_get_nav_menu( 'menu_footer' );
if ( ! empty( $nelson_menu_footer ) ) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php
			nelson_show_layout(
				$nelson_menu_footer,
				'<nav class="menu_footer_nav_area sc_layouts_menu sc_layouts_menu_default"'
					. ' itemscope="itemscope" itemtype="' . esc_attr( nelson_get_protocol( true ) ) . '//schema.org/SiteNavigationElement"'
					. '>',
				'</nav>'
			);
			?>
		</div>
	</div>
	<?php
}
