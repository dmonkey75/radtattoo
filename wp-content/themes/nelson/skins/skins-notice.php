<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.64
 */

$nelson_theme_obj  = wp_get_theme();
$nelson_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$nelson_skins_args = get_query_var( 'nelson_skins_notice_args' );

?>
<div class="nelson_admin_notice nelson_skins_notice update-nag">
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
		<?php esc_html_e( 'New skins available', 'nelson' ); ?>
	</h3>
	<?php

	// Description
	$nelson_total      = $nelson_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$nelson_skins_msg  = $nelson_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $nelson_total, 'nelson' ), $nelson_total ) . '</strong>'
							: '';
	$nelson_total      = $nelson_skins_args['free'];
	$nelson_skins_msg .= $nelson_total > 0
							? ( ! empty( $nelson_skins_msg ) ? ' ' . esc_html__( 'and', 'nelson' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $nelson_total, 'nelson' ), $nelson_total ) . '</strong>'
							: '';
	$nelson_total      = $nelson_skins_args['pay'];
	$nelson_skins_msg .= $nelson_skins_args['pay'] > 0
							? ( ! empty( $nelson_skins_msg ) ? ' ' . esc_html__( 'and', 'nelson' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $nelson_total, 'nelson' ), $nelson_total ) . '</strong>'
							: '';
	?>
	<div class="nelson_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'nelson' ), $nelson_skins_msg ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="nelson_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $nelson_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'nelson' );
			?>
		</a>
		<?php
		// Dismiss
		?>
		<a href="#" data-notice="skins" class="nelson_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="nelson_hide_notice_text"><?php esc_html_e( 'Dismiss', 'nelson' ); ?></span></a>
	</div>
</div>
