<?php
/**
 * The Classic template to display the content
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
$nelson_expanded   = ! nelson_sidebar_present() && nelson_is_on( nelson_get_theme_option( 'expand_content' ) );

$nelson_components = ! empty( $nelson_template_args['meta_parts'] )
						? ( is_array( $nelson_template_args['meta_parts'] )
							? join( ',', $nelson_template_args['meta_parts'] )
							: $nelson_template_args['meta_parts']
							)
						: nelson_array_get_keys_by_value( nelson_get_theme_option( 'meta_parts' ) );

$nelson_post_format = get_post_format();
$nelson_post_format = empty( $nelson_post_format ) ? 'standard' : str_replace( 'post-format-', '', $nelson_post_format );

?><div class="<?php
	if ( ! empty( $nelson_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( 'classic' == $nelson_blog_style[0] ? 'column' : 'masonry_item masonry_item' ) . '-1_' . esc_attr( $nelson_columns );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_format_' . esc_attr( $nelson_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $nelson_columns )
				. ' post_layout_' . esc_attr( $nelson_blog_style[0] )
				. ' post_layout_' . esc_attr( $nelson_blog_style[0] ) . '_' . esc_attr( $nelson_columns )
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

	// Featured image
	$nelson_hover = ! empty( $nelson_template_args['hover'] ) && ! nelson_is_inherit( $nelson_template_args['hover'] )
						? $nelson_template_args['hover']
						: nelson_get_theme_option( 'image_hover' );
	nelson_show_post_featured(
		array(
			'thumb_size' => nelson_get_thumb_size(
				'classic' == $nelson_blog_style[0]
						? ( strpos( nelson_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $nelson_columns > 2 ? 'big' : 'huge' )
								: ( $nelson_columns > 2
									? ( $nelson_expanded ? 'med' : 'small' )
									: ( $nelson_expanded ? 'big' : 'med' )
									)
							)
						: ( strpos( nelson_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $nelson_columns > 2 ? 'masonry-big' : 'full' )
								: ( $nelson_columns <= 2 && $nelson_expanded ? 'masonry-big' : 'masonry' )
							)
			),
			'hover'      => $nelson_hover,
			'no_links'   => ! empty( $nelson_template_args['no_links'] ),
		)
	);

	if ( ! in_array( $nelson_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		?>
		<div class="post_header entry-header">
			<?php
			do_action( 'nelson_action_before_post_title' );

			// Post title
			if ( empty( $nelson_template_args['no_links'] ) ) {
				the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
			} else {
				the_title( '<h4 class="post_title entry-title">', '</h4>' );
			}

			do_action( 'nelson_action_before_post_meta' );

			// Post meta
			if ( ! empty( $nelson_components ) && ! in_array( $nelson_hover, array( 'border', 'pull', 'slide', 'fade' ) ) ) {
				nelson_show_post_meta(
					apply_filters(
						'nelson_filter_post_meta_args', array(
							'components' => $nelson_components,
							'seo'        => false,
						), $nelson_blog_style[0], $nelson_columns
					)
				);
			}

			do_action( 'nelson_action_after_post_meta' );
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content area
	ob_start();

	// Post content
	if ( empty( $nelson_template_args['hide_excerpt'] ) && nelson_get_theme_option( 'excerpt_length' ) > 0 ) {
        $nelson_template_args['excerpt_length'] = 15;
		nelson_show_post_content( $nelson_template_args, '<div class="post_content_inner">', '</div>' );
	}

	// Post meta
	if ( in_array( $nelson_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		if ( ! empty( $nelson_components ) ) {
			nelson_show_post_meta(
				apply_filters(
					'nelson_filter_post_meta_args', array(
						'components' => $nelson_components,
					), $nelson_blog_style[0], $nelson_columns
				)
			);
		}
	}
		
	// More button
	if ( empty( $nelson_template_args['no_links'] ) && ! empty( $nelson_template_args['more_text'] ) && ! in_array( $nelson_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		nelson_show_post_more_link( $nelson_template_args, '<p>', '</p>' );
	}

	$nelson_content = ob_get_contents();
	ob_end_clean();

	nelson_show_layout( $nelson_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->' );
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
