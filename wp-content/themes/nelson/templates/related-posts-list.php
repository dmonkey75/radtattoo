<?php
/**
 * The template 'Style 4' to displaying related posts
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.54
 */

$nelson_link        = get_permalink();
$nelson_post_format = get_post_format();
$nelson_post_format = empty( $nelson_post_format ) ? 'standard' : str_replace( 'post-format-', '', $nelson_post_format );

?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $nelson_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<div class="post_header entry-header">
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $nelson_link ); ?>"><?php the_title(); ?></a></h6>
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			?>
			<div class="post_meta">
				<a href="<?php echo esc_url( $nelson_link ); ?>" class="post_meta_item post_date"><span class="icon-clock"></span><?php echo wp_kses_data( nelson_get_date() ); ?></a>
			</div>
			<?php
		}
		?>
	</div>
</div>
