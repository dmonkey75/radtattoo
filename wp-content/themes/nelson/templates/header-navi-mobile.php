<?php
/**
 * The template to show mobile menu
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr( nelson_get_theme_option( 'menu_mobile_fullscreen' ) > 0 ? 'fullscreen' : 'narrow' ); ?> scheme_dark">
	<div class="menu_mobile_inner">
		<a class="menu_mobile_close theme_button_close"><span class="theme_button_close_icon"></span></a>
		<?php

		// Logo
		set_query_var( 'nelson_logo_args', array( 'type' => 'mobile' ) );
		get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/header-logo' ) );
		set_query_var( 'nelson_logo_args', array() );

		// Mobile menu
		$nelson_menu_mobile = nelson_get_nav_menu( 'menu_mobile' );
		if ( empty( $nelson_menu_mobile ) ) {
			$nelson_menu_mobile = apply_filters( 'nelson_filter_get_mobile_menu', '' );
			if ( empty( $nelson_menu_mobile ) ) {
				$nelson_menu_mobile = nelson_get_nav_menu( 'menu_main' );
				if ( empty( $nelson_menu_mobile ) ) {
					$nelson_menu_mobile = nelson_get_nav_menu();
				}
			}
		}
		if ( ! empty( $nelson_menu_mobile ) ) {
			$nelson_menu_mobile = str_replace(
				array( 'menu_main',   'id="menu-',        'sc_layouts_menu_nav', 'sc_layouts_menu ', 'sc_layouts_hide_on_mobile', 'hide_on_mobile' ),
				array( 'menu_mobile', 'id="menu_mobile-', '',                    ' ',                '',                          '' ),
				$nelson_menu_mobile
			);
			if ( strpos( $nelson_menu_mobile, '<nav ' ) === false ) {
				$nelson_menu_mobile = sprintf( '<nav class="menu_mobile_nav_area" itemscope="itemscope" itemtype="' . esc_attr( nelson_get_protocol( true ) ) . '//schema.org/SiteNavigationElement">%s</nav>', $nelson_menu_mobile );
			}
			nelson_show_layout( apply_filters( 'nelson_filter_menu_mobile_layout', $nelson_menu_mobile ) );
		}

		// Search field
		do_action(
			'nelson_action_search',
			array(
				'style' => 'normal',
				'class' => 'search_mobile',
				'ajax'  => false
			)
		);

		// Social icons
		nelson_show_layout( nelson_get_socials_links(), '<div class="socials_mobile">', '</div>' );
		?>
	</div>
</div>
