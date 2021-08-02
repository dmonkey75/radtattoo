<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.10
 */


// Socials
if ( nelson_is_on( nelson_get_theme_option( 'socials_in_footer' ) ) ) {
	$nelson_output = nelson_get_socials_links();
	if ( '' != $nelson_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php nelson_show_layout( $nelson_output ); ?>
			</div>
		</div>
		<?php
	}
}
