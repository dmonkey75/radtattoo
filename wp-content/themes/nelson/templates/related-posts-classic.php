<?php
/**
 * The template 'Style 2' to displaying related posts
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
			'thumb_size'    => apply_filters( 'nelson_filter_related_thumb_size', nelson_get_thumb_size( (int) nelson_get_theme_option( 'related_posts' ) == 1 ? 'more-big' : 'med' ) ),
            'thumb_ratio'   => '19:13',
		)
	);
	?>
	<div class="post_header entry-header">
        <h4 class="post_title entry-title"><a href="<?php echo esc_url( $nelson_link ); ?>"><?php the_title(); ?></a></h4>
        <?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			?>
			<div class="post_meta">
				<a href="<?php echo esc_url( $nelson_link ); ?>" class="post_meta_item post_date"><?php echo wp_kses_data( nelson_get_date() ); ?></a>
			</div>
			<?php
		}
		?>
	</div>
</div>
