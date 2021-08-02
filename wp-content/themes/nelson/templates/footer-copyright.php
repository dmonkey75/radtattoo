<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$nelson_copyright_scheme = nelson_get_theme_option( 'copyright_scheme' );
if ( ! empty( $nelson_copyright_scheme ) && ! nelson_is_inherit( $nelson_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $nelson_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$nelson_copyright = nelson_get_theme_option( 'copyright' );
			if ( ! empty( $nelson_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$nelson_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $nelson_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$nelson_copyright = nelson_prepare_macros( $nelson_copyright );
				// Display copyright
				echo wp_kses( nl2br( $nelson_copyright ), 'nelson_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
