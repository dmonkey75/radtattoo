<?php
/**
 * 'Plain' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.62
 */

$nelson_template_args = get_query_var( 'nelson_template_args' );
$nelson_columns = 1;
if ( is_array( $nelson_template_args ) ) {
	$nelson_columns    = empty( $nelson_template_args['columns'] ) ? 1 : max( 1, $nelson_template_args['columns'] );
	$nelson_blog_style = array( $nelson_template_args['type'], $nelson_columns );
	if ( ! empty( $nelson_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $nelson_columns > 1 ) {
		?>
		<div class="column-1_<?php echo esc_attr( $nelson_columns ); ?>">
		<?php
	}
}
$nelson_expanded    = ! nelson_sidebar_present() && nelson_is_on( nelson_get_theme_option( 'expand_content' ) );
$nelson_post_format = get_post_format();
$nelson_post_format = empty( $nelson_post_format ) ? 'standard' : str_replace( 'post-format-', '', $nelson_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_layout_plain post_format_' . esc_attr( $nelson_post_format ) );
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
			'no_links'   => ! empty( $nelson_template_args['no_links'] ),
			'hover'      => $nelson_hover,
			'thumb_bg'   => true,
			'thumb_size' => nelson_get_thumb_size( 
								in_array( $nelson_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( nelson_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $nelson_expanded 
											? 'huge' 
											: 'big'
											)
										)
									: 'masonry-big'
								)
		)
	);

	?><div class="post_content_wrap"><?php

		// Title and post meta
		if ( ! in_array( $nelson_post_format, array( 'aside', 'status', 'link', 'quote' ) ) ) {
			$nelson_show_title = get_the_title() != '';
			$nelson_components = ! empty( $nelson_template_args['meta_parts'] )
									? ( is_array( $nelson_template_args['meta_parts'] )
										? join( ',', $nelson_template_args['meta_parts'] )
										: $nelson_template_args['meta_parts']
										)
									: nelson_array_get_keys_by_value( nelson_get_theme_option( 'meta_parts' ) );
			$nelson_show_meta  = ! empty( $nelson_components ) && ! in_array( $nelson_hover, array( 'border', 'pull', 'slide', 'fade' ) );
			if ( $nelson_show_title || $nelson_show_meta ) {
				?>
				<div class="post_header entry-header">
					<?php
					// Post title
					if ( $nelson_show_title ) {
						do_action( 'nelson_action_before_post_title' );
						if ( empty( $nelson_template_args['no_links'] ) ) {
							the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
						} else {
							the_title( '<h3 class="post_title entry-title">', '</h3>' );
						}
					}
					
					// Post meta
					if ( $nelson_show_meta ) {
						do_action( 'nelson_action_before_post_meta' );
						nelson_show_post_meta(
							apply_filters(
								'nelson_filter_post_meta_args', array(
									'components' => $nelson_components,
									'seo'        => false,
								), 'excerpt', 1
							)
						);
					}
					?>
				</div><!-- .post_header -->
				<?php
			}
		}

		// Post content
		if ( ! isset( $nelson_template_args['excerpt_length'] ) && ! in_array( $nelson_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$nelson_template_args['excerpt_length'] = 30;
		}
		if ( empty( $nelson_template_args['hide_excerpt'] ) && nelson_get_theme_option( 'excerpt_length' ) > 0 ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				nelson_show_post_content( $nelson_template_args, '<div class="post_content_inner">', '</div>' );
				// More button
				if ( empty( $nelson_template_args['no_links'] ) && ! in_array( $nelson_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
					nelson_show_post_more_link( $nelson_template_args, '<p>', '</p>' );
				}
				?>
			</div><!-- .entry-content -->
			<?php
		}
		?>
	</div>
</article>
<?php

if ( is_array( $nelson_template_args ) ) {
	if ( ! empty( $nelson_template_args['slider'] ) || $nelson_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
