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
	$nelson_columns    = empty( $nelson_template_args['columns'] ) ? 1 : max( 1, min( 3, $nelson_template_args['columns'] ) );
	$nelson_blog_style = array( $nelson_template_args['type'], $nelson_columns );
} else {
	$nelson_blog_style = explode( '_', nelson_get_theme_option( 'blog_style' ) );
	$nelson_columns    = empty( $nelson_blog_style[1] ) ? 1 : max( 1, min( 3, $nelson_blog_style[1] ) );
}
$nelson_expanded    = ! nelson_sidebar_present() && nelson_is_on( nelson_get_theme_option( 'expand_content' ) );
$nelson_post_format = get_post_format();
$nelson_post_format = empty( $nelson_post_format ) ? 'standard' : str_replace( 'post-format-', '', $nelson_post_format );

?><article id="post-<?php the_ID(); ?>"	data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item'
		. ' post_layout_chess'
		. ' post_layout_chess_' . esc_attr( $nelson_columns )
		. ' post_format_' . esc_attr( $nelson_post_format )
		. ( ! empty( $nelson_template_args['slider'] ) ? ' slider-slide swiper-slide' : '' )
	);
	nelson_add_blog_animation( $nelson_template_args );
	?>
>

	<?php
	// Add anchor
	if ( 1 == $nelson_columns && ! is_array( $nelson_template_args ) && shortcode_exists( 'trx_sc_anchor' ) ) {
		echo do_shortcode( '[trx_sc_anchor id="post_' . esc_attr( get_the_ID() ) . '" title="'.the_title_attribute( array( 'echo' => false ) ) . '" icon="' . esc_attr( nelson_get_post_icon() ) . '"]' );
	}

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
			'class'         => 1 == $nelson_columns && ! is_array( $nelson_template_args ) ? 'nelson-full-height' : '',
			'hover'         => $nelson_hover,
			'no_links'      => ! empty( $nelson_template_args['no_links'] ),
			'show_no_image' => true,
			'thumb_ratio'   => '1:1',
			'thumb_bg'      => true,
			'thumb_size'    => nelson_get_thumb_size(
				strpos( nelson_get_theme_option( 'body_style' ), 'full' ) !== false
										? ( 1 < $nelson_columns ? 'huge' : 'original' )
										: ( 2 < $nelson_columns ? 'big' : 'huge' )
			),
		)
	);

	?>
	<div class="post_inner"><div class="post_inner_content"><div class="post_header entry-header">
		<?php
			do_action( 'nelson_action_before_post_title' );

			// Post title
			if ( empty( $nelson_template_args['no_links'] ) ) {
				the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			} else {
				the_title( '<h3 class="post_title entry-title">', '</h3>' );
			}

			do_action( 'nelson_action_before_post_meta' );

			// Post meta
			$nelson_components = ! empty( $nelson_template_args['meta_parts'] )
									? ( is_array( $nelson_template_args['meta_parts'] )
										? join( ',', $nelson_template_args['meta_parts'] )
										: $nelson_template_args['meta_parts']
										)
									: nelson_array_get_keys_by_value( nelson_get_theme_option( 'meta_parts' ) );
			$nelson_post_meta  = empty( $nelson_components ) || in_array( $nelson_hover, array( 'border', 'pull', 'slide', 'fade' ) )
										? ''
										: nelson_show_post_meta(
											apply_filters(
												'nelson_filter_post_meta_args', array(
													'components' => $nelson_components,
													'seo'  => false,
													'echo' => false,
												), $nelson_blog_style[0], $nelson_columns
											)
										);
			nelson_show_layout( $nelson_post_meta );
			?>
		</div><!-- .entry-header -->

		<div class="post_content entry-content">
			<?php
			// Post content area
			if ( empty( $nelson_template_args['hide_excerpt'] ) && nelson_get_theme_option( 'excerpt_length' ) > 0 ) {
				nelson_show_post_content( $nelson_template_args, '<div class="post_content_inner">', '</div>' );
			}
			// Post meta
			if ( in_array( $nelson_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
				nelson_show_layout( $nelson_post_meta );
			}
			// More button
			if ( empty( $nelson_template_args['no_links'] ) && ! in_array( $nelson_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
				nelson_show_post_more_link( $nelson_template_args, '<p>', '</p>' );
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
