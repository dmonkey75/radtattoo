<div class="front_page_section front_page_section_googlemap<?php
	$nelson_scheme = nelson_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $nelson_scheme ) && ! nelson_is_inherit( $nelson_scheme ) ) {
		echo ' scheme_' . esc_attr( $nelson_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( nelson_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( nelson_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$nelson_css      = '';
		$nelson_bg_image = nelson_get_theme_option( 'front_page_googlemap_bg_image' );
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
	$nelson_anchor_icon = nelson_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$nelson_anchor_text = nelson_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $nelson_anchor_icon ) || ! empty( $nelson_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $nelson_anchor_icon ) ? ' icon="' . esc_attr( $nelson_anchor_icon ) . '"' : '' )
									. ( ! empty( $nelson_anchor_text ) ? ' title="' . esc_attr( $nelson_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$nelson_layout = nelson_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $nelson_layout );
		if ( nelson_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' nelson-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$nelson_css      = '';
			$nelson_bg_mask  = nelson_get_theme_option( 'front_page_googlemap_bg_mask' );
			$nelson_bg_color_type = nelson_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $nelson_bg_color_type ) {
				$nelson_bg_color = nelson_get_theme_option( 'front_page_googlemap_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $nelson_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$nelson_caption     = nelson_get_theme_option( 'front_page_googlemap_caption' );
			$nelson_description = nelson_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $nelson_caption ) || ! empty( $nelson_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $nelson_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $nelson_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $nelson_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $nelson_caption, 'nelson_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $nelson_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $nelson_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $nelson_description ), 'nelson_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $nelson_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$nelson_content = nelson_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $nelson_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $nelson_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $nelson_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $nelson_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $nelson_content, 'nelson_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $nelson_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $nelson_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
			<?php
			if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
				dynamic_sidebar( 'front_page_googlemap_widgets' );
			} elseif ( current_user_can( 'edit_theme_options' ) ) {
				if ( ! nelson_exists_trx_addons() ) {
					nelson_customizer_need_trx_addons_message();
				} else {
					nelson_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
				}
			}
			?>
			</div>
			<?php

			if ( 'columns' == $nelson_layout && ( ! empty( $nelson_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
