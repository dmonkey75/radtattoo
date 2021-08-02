<div class="front_page_section front_page_section_features<?php
	$nelson_scheme = nelson_get_theme_option( 'front_page_features_scheme' );
	if ( ! empty( $nelson_scheme ) && ! nelson_is_inherit( $nelson_scheme ) ) {
		echo ' scheme_' . esc_attr( $nelson_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( nelson_get_theme_option( 'front_page_features_paddings' ) );
	if ( nelson_get_theme_option( 'front_page_features_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$nelson_css      = '';
		$nelson_bg_image = nelson_get_theme_option( 'front_page_features_bg_image' );
		if ( ! empty( $nelson_bg_image ) ) {
			$nelson_css .= 'background-image: url(' . esc_url( nelson_get_attachment_url( $nelson_bg_image ) ) . ');';
		}
		if ( ! empty( $nelson_css ) ) {
			echo ' style="' . esc_attr( $nelson_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$nelson_anchor_icon = nelson_get_theme_option( 'front_page_features_anchor_icon' );
	$nelson_anchor_text = nelson_get_theme_option( 'front_page_features_anchor_text' );
if ( ( ! empty( $nelson_anchor_icon ) || ! empty( $nelson_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_features"'
									. ( ! empty( $nelson_anchor_icon ) ? ' icon="' . esc_attr( $nelson_anchor_icon ) . '"' : '' )
									. ( ! empty( $nelson_anchor_text ) ? ' title="' . esc_attr( $nelson_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_features_inner
	<?php
	if ( nelson_get_theme_option( 'front_page_features_fullheight' ) ) {
		echo ' nelson-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$nelson_css      = '';
			$nelson_bg_mask  = nelson_get_theme_option( 'front_page_features_bg_mask' );
			$nelson_bg_color_type = nelson_get_theme_option( 'front_page_features_bg_color_type' );
			if ( 'custom' == $nelson_bg_color_type ) {
				$nelson_bg_color = nelson_get_theme_option( 'front_page_features_bg_color' );
			} elseif ( 'scheme_bg_color' == $nelson_bg_color_type ) {
				$nelson_bg_color = nelson_get_scheme_color( 'bg_color', $nelson_scheme );
			} else {
				$nelson_bg_color = '';
			}
			if ( ! empty( $nelson_bg_color ) && $nelson_bg_mask > 0 ) {
				$nelson_css .= 'background-color: ' . esc_attr(
					1 == $nelson_bg_mask ? $nelson_bg_color : nelson_hex2rgba( $nelson_bg_color, $nelson_bg_mask )
				) . ';';
			}
			if ( ! empty( $nelson_css ) ) {
				echo ' style="' . esc_attr( $nelson_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_features_content_wrap content_wrap">
			<?php
			// Caption
			$nelson_caption = nelson_get_theme_option( 'front_page_features_caption' );
			if ( ! empty( $nelson_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_features_caption front_page_block_<?php echo ! empty( $nelson_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $nelson_caption, 'nelson_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$nelson_description = nelson_get_theme_option( 'front_page_features_description' );
			if ( ! empty( $nelson_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_features_description front_page_block_<?php echo ! empty( $nelson_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $nelson_description ), 'nelson_kses_content' ); ?></div>
				<?php
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_features_output">
			<?php
			if ( is_active_sidebar( 'front_page_features_widgets' ) ) {
				dynamic_sidebar( 'front_page_features_widgets' );
			} elseif ( current_user_can( 'edit_theme_options' ) ) {
				if ( ! nelson_exists_trx_addons() ) {
					nelson_customizer_need_trx_addons_message();
				} else {
					nelson_customizer_need_widgets_message( 'front_page_features_caption', 'ThemeREX Addons - Services' );
				}
			}
			?>
			</div>
		</div>
	</div>
</div>
