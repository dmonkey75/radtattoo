<div class="front_page_section front_page_section_contacts<?php
	$nelson_scheme = nelson_get_theme_option( 'front_page_contacts_scheme' );
	if ( ! empty( $nelson_scheme ) && ! nelson_is_inherit( $nelson_scheme ) ) {
		echo ' scheme_' . esc_attr( $nelson_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( nelson_get_theme_option( 'front_page_contacts_paddings' ) );
	if ( nelson_get_theme_option( 'front_page_contacts_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$nelson_css      = '';
		$nelson_bg_image = nelson_get_theme_option( 'front_page_contacts_bg_image' );
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
	$nelson_anchor_icon = nelson_get_theme_option( 'front_page_contacts_anchor_icon' );
	$nelson_anchor_text = nelson_get_theme_option( 'front_page_contacts_anchor_text' );
if ( ( ! empty( $nelson_anchor_icon ) || ! empty( $nelson_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_contacts"'
									. ( ! empty( $nelson_anchor_icon ) ? ' icon="' . esc_attr( $nelson_anchor_icon ) . '"' : '' )
									. ( ! empty( $nelson_anchor_text ) ? ' title="' . esc_attr( $nelson_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_contacts_inner
	<?php
	if ( nelson_get_theme_option( 'front_page_contacts_fullheight' ) ) {
		echo ' nelson-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$nelson_css      = '';
			$nelson_bg_mask  = nelson_get_theme_option( 'front_page_contacts_bg_mask' );
			$nelson_bg_color_type = nelson_get_theme_option( 'front_page_contacts_bg_color_type' );
			if ( 'custom' == $nelson_bg_color_type ) {
				$nelson_bg_color = nelson_get_theme_option( 'front_page_contacts_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$nelson_caption     = nelson_get_theme_option( 'front_page_contacts_caption' );
			$nelson_description = nelson_get_theme_option( 'front_page_contacts_description' );
			if ( ! empty( $nelson_caption ) || ! empty( $nelson_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $nelson_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo ! empty( $nelson_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $nelson_caption, 'nelson_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description
				if ( ! empty( $nelson_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo ! empty( $nelson_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $nelson_description ), 'nelson_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$nelson_content = nelson_get_theme_option( 'front_page_contacts_content' );
			$nelson_layout  = nelson_get_theme_option( 'front_page_contacts_layout' );
			if ( 'columns' == $nelson_layout && ( ! empty( $nelson_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ( ( ! empty( $nelson_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo ! empty( $nelson_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $nelson_content, 'nelson_kses_content' );
				?>
				</div>
				<?php
			}

			if ( 'columns' == $nelson_layout && ( ! empty( $nelson_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div><div class="column-2_3">
				<?php
			}

			// Shortcode output
			$nelson_sc = nelson_get_theme_option( 'front_page_contacts_shortcode' );
			if ( ! empty( $nelson_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo ! empty( $nelson_sc ) ? 'filled' : 'empty'; ?>">
				<?php
					nelson_show_layout( do_shortcode( $nelson_sc ) );
				?>
				</div>
				<?php
			}

			if ( 'columns' == $nelson_layout && ( ! empty( $nelson_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>

		</div>
	</div>
</div>
