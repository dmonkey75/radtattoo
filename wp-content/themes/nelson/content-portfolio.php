<?php
/**
 * The Portfolio template to display the content
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
		. ( is_sticky() && ! is_paged() ? ' sticky' : '' )
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

	$nelson_image_hover = ! empty( $nelson_template_args['hover'] ) && ! nelson_is_inherit( $nelson_template_args['hover'] )
								? $nelson_template_args['hover']
								: nelson_get_theme_option( 'image_hover' );
	// Featured image
	nelson_show_post_featured(
		array(
			'hover'         => $nelson_image_hover,
			'no_links'      => ! empty( $nelson_template_args['no_links'] ),
			'thumb_size'    => nelson_get_thumb_size(
									strpos( nelson_get_theme_option( 'body_style' ), 'full' ) !== false || $nelson_columns < 3
										? 'masonry-big'
										: 'masonry'
								),
			'show_no_image' => true,
			'class'         => 'icon' == $nelson_image_hover ? 'hover_with_info' : '',
			'post_info'     => 'icon' == $nelson_image_hover ? '<div class="post_info">' . esc_html( get_the_title() ) . '</div>' : '',
		)
	);
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!