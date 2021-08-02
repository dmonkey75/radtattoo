<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */

$nelson_link        = get_permalink();
$nelson_post_format = get_post_format();
$nelson_post_format = empty( $nelson_post_format ) ? 'standard' : str_replace( 'post-format-', '', $nelson_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $nelson_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php
	nelson_show_post_featured(
		array(
			'thumb_size'    => apply_filters( 'nelson_filter_related_thumb_size', nelson_get_thumb_size( (int) nelson_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
			'post_info'     => '<div class="post_header entry-header">'
									. '<div class="post_categories">' . wp_kses( nelson_get_post_categories( '' ), 'nelson_kses_content' ) . '</div>'
									. '<h6 class="post_title entry-title"><a href="' . esc_url( $nelson_link ) . '">' . wp_kses_data( get_the_title() ) . '</a></h6>'
									. ( in_array( get_post_type(), array( 'post', 'attachment' ) )
											? '<div class="post_meta"><a href="' . esc_url( $nelson_link ) . '" class="post_meta_item post_date">' . wp_kses_data( nelson_get_date() ) . '</a></div>'
											: '' )
								. '</div>',
		)
	);
	?>
</div>
