<?php
// Add skin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'nelson_skin_get_css' ) ) {
	add_filter( 'nelson_filter_get_css', 'nelson_skin_get_css', 10, 2 );
	function nelson_skin_get_css( $css, $args ) {

		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS

CSS;
		}

		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			$vars         = $args['vars'];
			$css['vars'] .= <<<CSS

CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS
			
						
			blockquote > cite, blockquote > p > cite, 
			blockquote > .wp-block-pullquote__citation,
  			.wp-block-quote .wp-block-quote__citation {
				color: {$colors['text_link']};
			}			
			blockquote:not(.has-text-color):before {
				color: {$colors['text_link2']};
			}			
			
			.sticky {
				background-color: {$colors['extra_bg_color']};
			}
			.sticky .post_content {
				color: {$colors['text']};
			}
			
			.widget_instagram .widget_title:before {
				background-color: {$colors['text_link2']};
				border-color: {$colors['text_link2']} !important;
			}
			.widget_instagram .widget_instagram_wrap .widget_instagram_images_item_wrap .widget_instagram_images_item .widget_instagram_images_item_counters > span {
				border-color: {$colors['text_link2']} !important;
			}
	

			/* TRX Addons */
			.sc_layouts_row_type_compact .sc_layouts_item_details_line1,
			.sc_layouts_row_type_compact .sc_layouts_item_details_line2,
			.scheme_self.sc_layouts_row_type_compact .sc_layouts_item_details_line1,
			.scheme_self.sc_layouts_row_type_compact .sc_layouts_item_details_line2 {
				color: {$colors['text_dark']};
			}

			.sc_layouts_row_type_compact .sc_layouts_title .sc_layouts_title_breadcrumbs .breadcrumbs:before,
			.sc_layouts_row_type_compact .sc_layouts_title .sc_layouts_title_breadcrumbs .breadcrumbs:after	{
				background-color: {$colors['bg_color_01']};
			}	

			.sc_layouts_row_type_compact .sc_layouts_iconed_text:not(.sc_layouts_menu_mobile_button) .sc_layouts_item_icon {
				color: {$colors['text_link2']};
			}	

			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-item > a, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-parent > a, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-ancestor > a {				
				color: {$colors['text_dark']} !important;
			}
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-item > a span, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-parent > a span, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-ancestor > a span {	
				border-color: {$colors['text_dark_05']} !important;
			}			
			
			.sc_layouts_menu_nav > li ul ul{
			    background-color: {$colors['alter_bg_color']};
			}
			
			.sc_layouts_menu_nav > li > a{
			    color: {$colors['text_dark']} 
			}
			
			.sc_layouts_menu_nav > li.current-menu-item > a:hover span, 
			.sc_layouts_menu_nav > li.current-menu-parent > a:hover span, 
			.sc_layouts_menu_nav > li.current-menu-ancestor > a:hover span, 
			.menu_main_nav > li > a:hover span, 
			.sc_layouts_row:not(.sc_layouts_row_type_narrow) .sc_layouts_menu_nav > li > a:hover span,			
			.sc_layouts_menu_nav > li.current-menu-item > a:focus span, 
			.sc_layouts_menu_nav > li.current-menu-parent > a:focus span, 
			.sc_layouts_menu_nav > li.current-menu-ancestor > a:focus span, 
			.menu_main_nav > li > a:focus span, 
			.sc_layouts_row:not(.sc_layouts_row_type_narrow) .sc_layouts_menu_nav > li > a:focus span 	{
			    color: {$colors['text_link']} 
			}
			

			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li > a:hover, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li > a:focus, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.sfHover > a,
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-item > a:hover, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-parent > a:hover, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-ancestor > a:hover, 
			.top_panel_custom_header-over-center .menu_main_nav > li > a:hover, 
			.top_panel_custom_header-over-center .sc_layouts_row:not(.sc_layouts_row_type_narrow) .sc_layouts_menu_nav > li > a:hover,			
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-item > a:focus, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-parent > a:focus, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-ancestor > a:focus, 
			.top_panel_custom_header-over-center .menu_main_nav > li > a:focus, 
			.top_panel_custom_header-over-center .sc_layouts_row:not(.sc_layouts_row_type_narrow) .sc_layouts_menu_nav > li > a:focus{
				color: {$colors['text_dark']} !important;
			}		
			
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-item > a:hover span, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-parent > a:hover span, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-ancestor > a:hover span, 
			.top_panel_custom_header-over-center .menu_main_nav > li > a:hover span, 
			.top_panel_custom_header-over-center .sc_layouts_row:not(.sc_layouts_row_type_narrow) .sc_layouts_menu_nav > li > a:hover span,			
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-item > a:focus span, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-parent > a:focus span, 
			.top_panel_custom_header-over-center .sc_layouts_menu_nav > li.current-menu-ancestor > a:focus span, 
			.top_panel_custom_header-over-center .menu_main_nav > li > a:focus span, 
			.top_panel_custom_header-over-center .sc_layouts_row:not(.sc_layouts_row_type_narrow) .sc_layouts_menu_nav > li > a:focus span 	{
				border-color: {$colors['text_dark_05']} !important;
			}

			.slider_container.slider_controls_side .slider_controls_wrap > a {
				color: {$colors['text_link']};
				background-color: transparent;
			}
			.slider_container.slider_controls_side .slider_controls_wrap > a:hover {
				color: {$colors['text_hover']};
				background-color: transparent;
			}

			ul[class*="trx_addons_list"] > li:before {
				color: {$colors['text_link2']};
			}			
			
			.trx_addons_video_player.with_cover .video_hover,
			.post_featured.with_thumb .post_video_hover,
			.sc_layouts_blog_item_featured .post_featured.with_thumb .post_video_hover {
				color: {$colors['extra_hover2']};
				background-color: {$colors['text_link2']};
				border-color: {$colors['text_link2']};
			}
			.trx_addons_video_player.with_cover .video_hover:hover,
			.post_featured.with_thumb .post_video_hover:hover,
			.sc_layouts_blog_item_featured .post_featured.with_thumb .post_video_hover:hover {
				background-color: transparent;
				border-color: {$colors['text_link2']};
			}	
			
			.sc_action.sc_action_default .sc_action_item {
				background-color: {$colors['extra_bg_color']};
			}
			.sc_action_item_description {
				color: {$colors['text']} ;
			}	
			
			.sc_blogger.sc_blogger_list_meta_classic .sc_blogger_item .blogger_button_extra .more-link {
				color: {$colors['extra_hover2']};
				background-color: {$colors['text_dark']};
				border-color: {$colors['text_dark']} !important;
			}
			.sc_blogger.sc_blogger_list_meta_classic .sc_blogger_item .blogger_button_extra .more-link:hover {
				color: {$colors['text_dark']};
				background-color: transparent;
				border-color: {$colors['text_dark']} !important;
			}	

			.blogger_custom_control .sc_slider_controls .slider_controls_wrap > a.slider_next:before,
			.blogger_custom_control .sc_slider_controls .slider_controls_wrap > a.slider_prev:before {
				background-color: {$colors['inverse_link']};
			}			
			.blogger_custom_control .sc_slider_controls .slider_controls_wrap > a.slider_next:hover:before,
			.blogger_custom_control .sc_slider_controls .slider_controls_wrap > a.slider_prev:hover:before {
				color: {$colors['inverse_link']};
				background-color: {$colors['text_link']};
			}	
						
			/* Extra button */
			.sc_button.sc_button_extra:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image) {
				color: {$colors['extra_hover3']};
				background-color: {$colors['text_link2']};				
				border-color: {$colors['text_link2']} !important;
			}
			.sc_button.sc_button_extra:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image):hover {
				background-color: transparent;				
			}
			.sc_button.sc_button_extra:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image):not(.trx_addons_popup_link):hover {
				color: {$colors['text_link2']};				
			}				
			
			.color_style_link2 .sc_button.sc_button_extra:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image) {
				color: {$colors['extra_hover3']} !important;
				background-color: {$colors['text_link2']} !important;				
				border-color: {$colors['text_link2']} !important;
			}
			.color_style_link2 .sc_button.sc_button_extra:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image):hover {
				color: {$colors['text_link2']} !important;
				background-color: transparent !important;	
			}			
			
			.color_style_link3 .sc_button.sc_button_extra:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image) {
				color: {$colors['extra_hover3']} !important;
				background-color: {$colors['text_link3']} !important;				
				border-color: {$colors['text_link3']} !important;				
			}			
			.color_style_link3 .sc_button.sc_button_extra:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image):hover {
				color: {$colors['text_link3']} !important;
				background-color: transparent !important;	
			}			
			
			.color_style_dark .sc_button.sc_button_extra:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image) {
				color: {$colors['extra_hover3']} !important;
				background-color: {$colors['text_dark']} !important;				
				border-color: {$colors['text_dark']} !important;
			}			
			.color_style_dark .sc_button.sc_button_extra:not(.sc_button_simple):not(.sc_button_bordered):not(.sc_button_bg_image):hover {
				color: {$colors['text_dark']} !important;
				background-color: transparent !important;	
			}
			
			.sc_icons.sc_icons_modern .sc_icons_icon {
				color: {$colors['text_link2']};
			}	
			
			.sc_services_default .sc_services_item_icon {
				color: {$colors['text_link2']};
			}
			
			.sc_services.sc_services_hover .sc_services_item .sc_services_item_header:before {
				background: {$colors['alter_bg_color_08']} !important;
			}

			.sc_testimonials_item_content:before {
				color: {$colors['text_link2']};
			}
			
			.sc_title .sc_item_button:before {
				background-color: {$colors['bd_color']};
			}
			.scheme_default.sc_title .sc_item_button:before {
				background-color: {$colors['text_dark_01']};
			}	
		    .scheme_second_default .sc_title .sc_item_button:before {
				background-color: {$colors['text_dark_01']};
			}	
			.sc_title .sc_item_title_style_accent:before{
			    background-color: {$colors['extra_dark']};
			}
			
			.scheme_second_default .slider_outer_controls_bottom .slider_controls_wrap > a {
                color: {$colors['text_dark']};
                background-color: transparent;
            }
            .scheme_second_default .slider_outer_controls_bottom .slider_controls_wrap > a.slider_next {
                color: {$colors['extra_link2']};
                background-color: transparent;
            }
            .scheme_second_default .slider_outer_controls_bottom .slider_controls_wrap > a:hover{
                color: {$colors['text_link']}!important;
            }
					
			
			/* Booked */
			.booked-calendar-shortcode-wrap table.booked-calendar tbody tr td.today,
			.booked-calendar-shortcode-wrap table.booked-calendar tbody tr:not(.entryBlock) td:not(.prev-month):not(.prev-date):hover {
				background-color: {$colors['text_link2']} !important;
			}
			body table.booked-calendar .booked-appt-list .timeslot .timeslot-people button:hover .spots-available{
				color: {$colors['text_hover']} !important;
			}			
			.booked-calendar-shortcode-wrap .small table.booked-calendar th .page-left i:hover,
			.booked-calendar-shortcode-wrap .small table.booked-calendar th .page-right i:hover{
				color: {$colors['text_link']} !important;
			}	

			body .booked-calendar-wrap.small table.booked-calendar tr.week td.active .date, 
			body .booked-calendar-wrap.small table.booked-calendar td.today.active:hover .date span {
				color: {$colors['inverse_hover']} !important;
				background: {$colors['text_link']} !important;
			}	

			.booked_shortcode_custom_wrap table.booked-calendar tr.week td.active .date .number {
				color: {$colors['extra_hover3']} !important;
				background-color: {$colors['text_link2']} !important;
				border-color: {$colors['text_link2']} !important;
			}
					
			
			/* Woocommerce */
			.sc_blogger_item_price.sc_item_price,
			.woocommerce div.product p.price, .woocommerce div.product span.price,
			.woocommerce span.amount, .woocommerce-page span.amount {
				color: {$colors['text_link2']};
			}			
			aside.woocommerce del,
			.woocommerce del, .woocommerce del > span.amount, 
			.woocommerce-page del, .woocommerce-page del > span.amount {
				color: {$colors['text_link']} !important;
			}	
			.woocommerce ul.products li.product .outofstock_label {
				background-color: {$colors['text_link2']};
			}
			.woocommerce .price del:before{
			    background-color: {$colors['text_link']};
			}
			
			.woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price,
            .woocommerce ul.products li.product .price ins, .woocommerce-page ul.products li.product .price ins {
                color: {$colors['text_link2']};
            }
            .woocommerce ul.products li.product .price del, .woocommerce-page ul.products li.product .price del {
                color: {$colors['text_dark']};
            }
			
			
			.sc_layouts_cart_items_short {
				color: {$colors['text_dark']};
			}	
			.custom_style input[type="submit"]{
			    color: {$colors['extra_hover3']} !important;
				background-color: {$colors['text_link']} !important;
				border-color: {$colors['text_link']} !important;
			}	
            .custom_style input[type="submit"]:hover{
			    color: {$colors['text_link']} !important;
				background-color: {$colors['extra_hover3']} !important;
				border-color: {$colors['extra_hover3']} !important;
			}	
			.custom_style input[type="text"],
			.custom_style input[type="email"],
			.custom_style input[type="tel"]{
			    color: {$colors['extra_hover3']} 
			}
			
			.custom_style .wpcf7-list-item-label a,
			.custom_style .wpcf7-list-item-label{
			    color: {$colors['extra_hover3']} 
			}
			.custom_style input[type="checkbox"] + .wpcf7-list-item-label:before{
			    color: {$colors['text_link']}!important; 
			}
			
			
			.custom_style input[type="text"][placeholder]:-ms-input-placeholder {  color: {$colors['extra_hover3']}  }
			.custom_style input[type="text"][placeholder]::placeholder {  color: {$colors['extra_hover3']}  }
			.custom_style input[type="text"][placeholder]::-moz-placeholder {  color: {$colors['extra_hover3']}  }
			
            .custom_style input[type="email"][placeholder]:-ms-input-placeholder {  color: {$colors['extra_hover3']}  }
            .custom_style input[type="email"][placeholder]::placeholder {  color: {$colors['extra_hover3']}  }
            .custom_style input[type="email"][placeholder]::-moz-placeholder {  color: {$colors['extra_hover3']}  }
            
            .custom_style input[type="tel"][placeholder]:-ms-input-placeholder {  color: {$colors['extra_hover3']}  }
            .custom_style input[type="tel"][placeholder]::placeholder {  color: {$colors['extra_hover3']}  }
            .custom_style input[type="tel"][placeholder]::-moz-placeholder {  color: {$colors['extra_hover3']}  }
            
            button.mfp-arrow.mfp-prevent-close{
                 color: {$colors['extra_link2']}
            }
         
			
			
CSS;
		}

		return $css;
	}
}

