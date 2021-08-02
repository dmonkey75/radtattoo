<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.50
 */

$nelson_template_args = get_query_var( 'nelson_template_args' );
if ( is_array( $nelson_template_args ) ) {
	$nelson_columns    = empty( $nelson_template_args['columns'] ) ? 2 : max( 1, $nelson_template_args['columns'] );
	$nelson_blog_style = array( $nelson_template_args['type'], $nelson_columns );
} else {
	$nelson_blog_style = explode( '_', nelson_get_theme_option( 'blog_style' ) );
	$nelson_columns    = empty( $nelson_blog_style[1] ) ? 2 : max( 1, $nelson_blog_style[1] );
}
$nelson_blog_id       = nelson_get_custom_blog_id( join( '_', $nelson_blog_style ) );
$nelson_blog_style[0] = str_replace( 'blog-custom-', '', $nelson_blog_style[0] );
$nelson_expanded      = ! nelson_sidebar_present() && nelson_is_on( nelson_get_theme_option( 'expand_content' ) );
$nelson_components    = ! empty( $nelson_template_args['meta_parts'] )
							? ( is_array( $nelson_template_args['meta_parts'] )
								? join( ',', $nelson_template_args['meta_parts'] )
								: $nelson_template_args['meta_parts']
								)
							: nelson_array_get_keys_by_value( nelson_get_theme_option( 'meta_parts' ) );
$nelson_post_format   = get_post_format();
$nelson_post_format   = empty( $nelson_post_format ) ? 'standard' : str_replace( 'post-format-', '', $nelson_post_format );

$nelson_blog_meta     = nelson_get_custom_layout_meta( $nelson_blog_id );
$nelson_custom_style  = ! empty( $nelson_blog_meta['scripts_required'] ) ? $nelson_blog_meta['scripts_required'] : 'none';

if ( ! empty( $nelson_template_args['slider'] ) || $nelson_columns > 1 || ! nelson_is_off( $nelson_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $nelson_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( nelson_is_off( $nelson_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $nelson_custom_style ) ) . "-1_{$nelson_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_format_' . esc_attr( $nelson_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $nelson_columns )
					. ' post_layout_' . esc_attr( $nelson_blog_style[0] )
					. ' post_layout_' . esc_attr( $nelson_blog_style[0] ) . '_' . esc_attr( $nelson_columns )
					. ( ! nelson_is_off( $nelson_custom_style )
						? ' post_layout_' . esc_attr( $nelson_custom_style )
							. ' post_layout_' . esc_attr( $nelson_custom_style ) . '_' . esc_attr( $nelson_columns )
						: ''
						)
		);
	nelson_add_blog_animation( $nelson_template_args );
	?>
>
	<?php
	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}
	// Custom layout
	do_action( 'nelson_action_show_layout', $nelson_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $nelson_template_args['slider'] ) || $nelson_columns > 1 || ! nelson_is_off( $nelson_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
