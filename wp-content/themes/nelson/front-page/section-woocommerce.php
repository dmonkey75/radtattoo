<div class="front_page_section front_page_section_woocommerce<?php
	$nelson_scheme = nelson_get_theme_option( 'front_page_woocommerce_scheme' );
	if ( ! empty( $nelson_scheme ) && ! nelson_is_inherit( $nelson_scheme ) ) {
		echo ' scheme_' . esc_attr( $nelson_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( nelson_get_theme_option( 'front_page_woocommerce_paddings' ) );
	if ( nelson_get_theme_option( 'front_page_woocommerce_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$nelson_css      = '';
		$nelson_bg_image = nelson_get_theme_option( 'front_page_woocommerce_bg_image' );
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
	$nelson_anchor_icon = nelson_get_theme_option( 'front_page_woocommerce_anchor_icon' );
	$nelson_anchor_text = nelson_get_theme_option( 'front_page_woocommerce_anchor_text' );
if ( ( ! empty( $nelson_anchor_icon ) || ! empty( $nelson_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_woocommerce"'
									. ( ! empty( $nelson_anchor_icon ) ? ' icon="' . esc_attr( $nelson_anchor_icon ) . '"' : '' )
									. ( ! empty( $nelson_anchor_text ) ? ' title="' . esc_attr( $nelson_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner
	<?php
	if ( nelson_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
		echo ' nelson-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$nelson_css      = '';
			$nelson_bg_mask  = nelson_get_theme_option( 'front_page_woocommerce_bg_mask' );
			$nelson_bg_color_type = nelson_get_theme_option( 'front_page_woocommerce_bg_color_type' );
			if ( 'custom' == $nelson_bg_color_type ) {
				$nelson_bg_color = nelson_get_theme_option( 'front_page_woocommerce_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$nelson_caption     = nelson_get_theme_option( 'front_page_woocommerce_caption' );
			$nelson_description = nelson_get_theme_option( 'front_page_woocommerce_description' );
			if ( ! empty( $nelson_caption ) || ! empty( $nelson_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $nelson_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $nelson_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $nelson_caption, 'nelson_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description (text)
				if ( ! empty( $nelson_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $nelson_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $nelson_description ), 'nelson_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
			<?php
				$nelson_woocommerce_sc = nelson_get_theme_option( 'front_page_woocommerce_products' );
			if ( 'products' == $nelson_woocommerce_sc ) {
				$nelson_woocommerce_sc_ids      = nelson_get_theme_option( 'front_page_woocommerce_products_per_page' );
				$nelson_woocommerce_sc_per_page = count( explode( ',', $nelson_woocommerce_sc_ids ) );
			} else {
				$nelson_woocommerce_sc_per_page = max( 1, (int) nelson_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
			}
				$nelson_woocommerce_sc_columns = max( 1, min( $nelson_woocommerce_sc_per_page, (int) nelson_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
				echo do_shortcode(
					"[{$nelson_woocommerce_sc}"
									. ( 'products' == $nelson_woocommerce_sc
											? ' ids="' . esc_attr( $nelson_woocommerce_sc_ids ) . '"'
											: '' )
									. ( 'product_category' == $nelson_woocommerce_sc
											? ' category="' . esc_attr( nelson_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
											: '' )
									. ( 'best_selling_products' != $nelson_woocommerce_sc
											? ' orderby="' . esc_attr( nelson_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
												. ' order="' . esc_attr( nelson_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
											: '' )
									. ' per_page="' . esc_attr( $nelson_woocommerce_sc_per_page ) . '"'
									. ' columns="' . esc_attr( $nelson_woocommerce_sc_columns ) . '"'
					. ']'
				);
				?>
			</div>
		</div>
	</div>
</div>
