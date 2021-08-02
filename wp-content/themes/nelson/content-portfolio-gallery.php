<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */

$nelson_template_args = get_query_var( 'nelson_template_args' );
if ( is_array( $nelson_template_args ) ) {
	$nelson_columns    = empty( $nelson_template_args['columns'] ) ? 2 : max( 1, $nelson_template_args['columns'] );
	$nelson_blog_style = array( $nelson_template_args['type'], $nelson_columns );
} else {
	$nelson_blog_style = explode( '_', nelson_get_theme_option( 'blog_style' ) );
	$nelson_columns    = empty( $nelson_blog_style[1] ) ? 2 : max( 1, $nelson_blog_style[1] );
}
$nelson_post_format = get_post_format();
$nelson_post_format = empty( $nelson_post_format ) ? 'standard' : str_replace( 'post-format-', '', $nelson_post_format );
$nelson_image       = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

?><div class="
<?php
if ( ! empty( $nelson_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo 'masonry_item masonry_item-1_' . esc_attr( $nelson_columns );
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_format_' . esc_attr( $nelson_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $nelson_columns )
		. ' post_layout_gallery'
		. ' post_layout_gallery_' . esc_attr( $nelson_columns )
	);
	nelson_add_blog_animation( $nelson_template_args );
	?>
	data-size="
		<?php
		if ( ! empty( $nelson_image[1] ) && ! empty( $nelson_image[2] ) ) {
			echo intval( $nelson_image[1] ) . 'x' . intval( $nelson_image[2] );}
		?>
	"
	data-src="
		<?php
		if ( ! empty( $nelson_image[0] ) ) {
			echo esc_url( $nelson_image[0] );}
		?>
	"
>
<?php

	// Sticky label
if ( is_sticky() && ! is_paged() ) {
	?>
		<span class="post_label label_sticky"></span>
		<?php
}

	// Featured image
	$nelson_image_hover = 'icon';  if ( in_array( $nelson_image_hover, array( 'icons', 'zoom' ) ) ) {
	$nelson_image_hover = 'dots';
}
$nelson_components = nelson_array_get_keys_by_value( nelson_get_theme_option( 'meta_parts' ) );
nelson_show_post_featured(
	array(
		'hover'         => $nelson_image_hover,
		'no_links'      => ! empty( $nelson_template_args['no_links'] ),
		'thumb_size'    => nelson_get_thumb_size( strpos( nelson_get_theme_option( 'body_style' ), 'full' ) !== false || $nelson_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only'    => true,
		'show_no_image' => true,
		'post_info'     => '<div class="post_details">'
						. '<h2 class="post_title">'
							. ( empty( $nelson_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>'
								: esc_html( get_the_title() )
								)
						. '</h2>'
						. '<div class="post_description">'
							. ( ! empty( $nelson_components )
								? nelson_show_post_meta(
									apply_filters(
										'nelson_filter_post_meta_args', array(
											'components' => $nelson_components,
											'seo'      => false,
											'echo'     => false,
										), $nelson_blog_style[0], $nelson_columns
									)
								)
								: ''
								)
							. ( empty( $nelson_template_args['hide_excerpt'] )
								? '<div class="post_description_content">' . get_the_excerpt() . '</div>'
								: ''
								)
							. ( empty( $nelson_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__( 'Learn more', 'nelson' ) . '</span></a>'
								: ''
								)
						. '</div>'
					. '</div>',
	)
);
?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
