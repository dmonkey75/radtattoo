<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.14
 */
$nelson_header_video = nelson_get_header_video();
$nelson_embed_video  = '';
if ( ! empty( $nelson_header_video ) && ! nelson_is_from_uploads( $nelson_header_video ) ) {
	if ( nelson_is_youtube_url( $nelson_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $nelson_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php nelson_show_layout( nelson_get_embed_video( $nelson_header_video ) ); ?></div>
		<?php
	}
}
