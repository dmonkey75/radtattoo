<?php
/**
 * The template for homepage posts with "Plain" style
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.62.1
 */

nelson_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	nelson_blog_archive_start();

	?><div class="posts_container">
		<?php

		$nelson_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
		$nelson_sticky_out = nelson_get_theme_option( 'sticky_style' ) == 'columns'
								&& is_array( $nelson_stickies ) && count( $nelson_stickies ) > 0 && get_query_var( 'paged' ) < 1;
		if ( $nelson_sticky_out ) {
			?>
			<div class="sticky_wrap columns_wrap">
			<?php
		}
		while ( have_posts() ) {
			the_post();
			if ( $nelson_sticky_out && ! is_sticky() ) {
				$nelson_sticky_out = false;
				?>
				</div>
				<?php
			}
			$nelson_part = $nelson_sticky_out && is_sticky() ? 'sticky' : 'plain';
			get_template_part( apply_filters( 'nelson_filter_get_template_part', 'content', $nelson_part ), $nelson_part );
		}
		if ( $nelson_sticky_out ) {
			$nelson_sticky_out = false;
			?>
			</div>
			<?php
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
