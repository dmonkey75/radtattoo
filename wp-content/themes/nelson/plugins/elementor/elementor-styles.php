<?php
// Add plugin-specific vars to the custom CSS
if ( ! function_exists( 'nelson_elm_add_theme_vars' ) ) {
	add_filter( 'nelson_filter_add_theme_vars', 'nelson_elm_add_theme_vars', 10, 2 );
	function nelson_elm_add_theme_vars( $rez, $vars ) {
		foreach ( array( 10, 20, 30, 40, 60 ) as $m ) {
			if ( substr( $vars['page'], 0, 2 ) != '{{' ) {
				$rez[ "page{$m}" ]    = ( $vars['page'] + $m ) . 'px';
				$rez[ "content{$m}" ] = ( $vars['page'] - $vars['gap'] - $vars['sidebar'] + $m ) . 'px';
			} else {
				$rez[ "page{$m}" ]    = "{{ data.page{$m} }}";
				$rez[ "content{$m}" ] = "{{ data.content{$m} }}";
			}
		}
		return $rez;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'nelson_elm_get_css' ) ) {
	add_filter( 'nelson_filter_get_css', 'nelson_elm_get_css', 10, 2 );
	function nelson_elm_get_css( $css, $args ) {

		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			extract( $args['vars'] );
			$css['vars'] .= <<<CSS
/* No gap */
.elementor-section.elementor-section-boxed > .elementor-container.elementor-column-gap-no {
	max-width: $page;
}
/* Narrow: 5px */
.elementor-section.elementor-section-boxed > .elementor-container.elementor-column-gap-narrow {
	max-width: $page10;
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow {
	width: $page10; 
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow {
	width: $content10; 
}

/* Default: 10px */
.elementor-section.elementor-section-boxed > .elementor-container.elementor-column-gap-default {
	max-width: $page20;
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default {
	width: $page20;
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default {
	width: $content20;
}

/* Extended: 15px */
.elementor-section.elementor-section-boxed > .elementor-container.elementor-column-gap-extended {
	max-width: $page30;
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended {
	width: $page30; 
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended {
	width: $content30; 
}

/* Wide: 20px */
.elementor-section.elementor-section-boxed > .elementor-container.elementor-column-gap-wide {
	max-width: $page40;
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide {
	width: $page40; 
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide {
	width: $content40; 
}

/* Wider: 30px */
.elementor-section.elementor-section-boxed > .elementor-container.elementor-column-gap-wider {
	max-width: $page60;
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider {
	width: $page60; 
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider {
	width: $content60; 
}

CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS

/* Shape above and below rows */
.elementor-shape .elementor-shape-fill {
	fill: {$colors['bg_color']};
}

/* Divider */
.elementor-divider-separator {
	border-color: {$colors['bd_color']};
}
.elementor-widget-tabs .elementor-widget-container .elementor-tabs .elementor-tab-title a {
    color: {$colors['text_dark']};
}
.elementor-widget-tabs .elementor-widget-container .elementor-tabs .elementor-tab-title {
    color: {$colors['text_dark']};
	background-color: transparent;
	border-color: {$colors['text_link']} !important;
}
.elementor-widget-tabs .elementor-widget-container .elementor-tabs .elementor-tab-title.elementor-active a,
.elementor-widget-tabs .elementor-widget-container .elementor-tabs .elementor-tab-title a:hover {
    color: {$colors['extra_hover2']};
}

.elementor-widget-tabs .elementor-widget-container .elementor-tabs .elementor-tab-title.elementor-active,
.elementor-widget-tabs .elementor-widget-container .elementor-tabs .elementor-tab-title:hover {
    color: {$colors['extra_hover2']};
	background-color: {$colors['text_link']};
	border-color: {$colors['text_link']} !important;
}

.elementor-widget-image-carousel .elementor-image-carousel .slick-arrow:before {
    color: {$colors['extra_link2']};
}

.elementor-widget-image-carousel .elementor-image-carousel .slick-arrow:hover:before {
    color: {$colors['extra_hover3']};
}

.elementor-accordion .elementor-accordion-item .elementor-tab-title {
    color: {$colors['text_dark']};
	border-color: {$colors['text_link']};
}
.elementor-accordion .elementor-accordion-item .elementor-tab-title a {
    color: {$colors['text_dark']};
}
.elementor-accordion .elementor-accordion-item .elementor-tab-title a:hover {
    color: {$colors['text_link']};
}
.elementor-accordion .elementor-tab-title .elementor-accordion-icon {
    color: {$colors['text_link']};
}
/* Progress bar */
.elementor-widget-progress .elementor-progress-wrapper {
    background-color: {$colors['alter_bg_color']};
}
.elementor-widget-progress .elementor-progress-bar {
    background-color: {$colors['text_link']};
}
.elementor-widget-progress .elementor-progress-percentage,
.elementor-widget-progress .elementor-title {
    color: {$colors['text_dark']};
}

CSS;
		}

		return $css;
	}
}

