<?php
/**
 * The template for homepage posts with "Chess" style
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */

nelson_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	nelson_blog_archive_start();

	$nelson_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$nelson_sticky_out = nelson_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $nelson_stickies ) && count( $nelson_stickies ) > 0 && get_query_var( 'paged' ) < 1;
	if ( $nelson_sticky_out ) {
		?>
		<div class="sticky_wrap columns_wrap">
		<?php
	}
	if ( ! $nelson_sticky_out ) {
		?>
		<div class="chess_wrap posts_container">
		<?php
	}
	
	while ( have_posts() ) {
		the_post();
		if ( $nelson_sticky_out && ! is_sticky() ) {
			$nelson_sticky_out = false;
			?>
			</div><div class="chess_wrap posts_container">
			<?php
		}
		$nelson_part = $nelson_sticky_out && is_sticky() ? 'sticky' : 'chess';
		get_template_part( apply_filters( 'nelson_filter_get_template_part', 'content', $nelson_part ), $nelson_part );
	}
	?>
	</div>
	<?php

	nelson_show_pagination();

	nelson_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'nelson_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'nelson_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
