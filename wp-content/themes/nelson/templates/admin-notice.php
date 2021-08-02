<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.1
 */

$nelson_theme_obj = wp_get_theme();
?>
<div class="nelson_admin_notice nelson_welcome_notice update-nag">
	<?php
	// Theme image
	$nelson_theme_img = nelson_get_file_url( 'screenshot.jpg' );
	if ( '' != $nelson_theme_img ) {
		?>
		<div class="nelson_notice_image"><img src="<?php echo esc_url( $nelson_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'nelson' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="nelson_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'nelson' ),
				$nelson_theme_obj->name . ( NELSON_THEME_FREE ? ' ' . __( 'Free', 'nelson' ) : '' ),
				$nelson_theme_obj->version
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="nelson_notice_text">
		<p class="nelson_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $nelson_theme_obj->description ) );
			?>
		</p>
		<p class="nelson_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'nelson' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="nelson_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=nelson_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'nelson' );
			?>
		</a>
		<?php		
		// Dismiss this notice
		?>
		<a href="#" data-notice="admin" class="nelson_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="nelson_hide_notice_text"><?php esc_html_e( 'Dismiss', 'nelson' ); ?></span></a>
	</div>
</div>
