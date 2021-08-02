<?php
/**
 * The template for homepage posts with "Portfolio" style
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

	// Show filters
	$nelson_cat          = nelson_get_theme_option( 'parent_cat' );
	$nelson_post_type    = nelson_get_theme_option( 'post_type' );
	$nelson_taxonomy     = nelson_get_post_type_taxonomy( $nelson_post_type );
	$nelson_show_filters = nelson_get_theme_option( 'show_filters' );
	$nelson_tabs         = array();
	if ( ! nelson_is_off( $nelson_show_filters ) ) {
		$nelson_args           = array(
			'type'         => $nelson_post_type,
			'child_of'     => $nelson_cat,
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hide_empty'   => 1,
			'hierarchical' => 0,
			'taxonomy'     => $nelson_taxonomy,
			'pad_counts'   => false,
		);
		$nelson_portfolio_list = get_terms( $nelson_args );
		if ( is_array( $nelson_portfolio_list ) && count( $nelson_portfolio_list ) > 0 ) {
			$nelson_tabs[ $nelson_cat ] = esc_html__( 'All', 'nelson' );
			foreach ( $nelson_portfolio_list as $nelson_term ) {
				if ( isset( $nelson_term->term_id ) ) {
					$nelson_tabs[ $nelson_term->term_id ] = $nelson_term->name;
				}
			}
		}
	}
	if ( count( $nelson_tabs ) > 0 ) {
		$nelson_portfolio_filters_ajax   = true;
		$nelson_portfolio_filters_active = $nelson_cat;
		$nelson_portfolio_filters_id     = 'portfolio_filters';
		?>
		<div class="portfolio_filters nelson_tabs nelson_tabs_ajax">
			<ul class="portfolio_titles nelson_tabs_titles">
				<?php
				foreach ( $nelson_tabs as $nelson_id => $nelson_title ) {
					?>
					<li><a href="<?php echo esc_url( nelson_get_hash_link( sprintf( '#%s_%s_content', $nelson_portfolio_filters_id, $nelson_id ) ) ); ?>" data-tab="<?php echo esc_attr( $nelson_id ); ?>"><?php echo esc_html( $nelson_title ); ?></a></li>
					<?php
				}
				?>
			</ul>
			<?php
			$nelson_ppp = nelson_get_theme_option( 'posts_per_page' );
			if ( nelson_is_inherit( $nelson_ppp ) ) {
				$nelson_ppp = '';
			}
			foreach ( $nelson_tabs as $nelson_id => $nelson_title ) {
				$nelson_portfolio_need_content = $nelson_id == $nelson_portfolio_filters_active || ! $nelson_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr( sprintf( '%s_%s_content', $nelson_portfolio_filters_id, $nelson_id ) ); ?>"
					class="portfolio_content nelson_tabs_content"
					data-blog-template="<?php echo esc_attr( nelson_storage_get( 'blog_template' ) ); ?>"
					data-blog-style="<?php echo esc_attr( nelson_get_theme_option( 'blog_style' ) ); ?>"
					data-posts-per-page="<?php echo esc_attr( $nelson_ppp ); ?>"
					data-post-type="<?php echo esc_attr( $nelson_post_type ); ?>"
					data-taxonomy="<?php echo esc_attr( $nelson_taxonomy ); ?>"
					data-cat="<?php echo esc_attr( $nelson_id ); ?>"
					data-parent-cat="<?php echo esc_attr( $nelson_cat ); ?>"
					data-need-content="<?php echo ( false === $nelson_portfolio_need_content ? 'true' : 'false' ); ?>"
				>
					<?php
					if ( $nelson_portfolio_need_content ) {
						nelson_show_portfolio_posts(
							array(
								'cat'        => $nelson_id,
								'parent_cat' => $nelson_cat,
								'taxonomy'   => $nelson_taxonomy,
								'post_type'  => $nelson_post_type,
								'page'       => 1,
								'sticky'     => $nelson_sticky_out,
							)
						);
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		nelson_show_portfolio_posts(
			array(
				'cat'        => $nelson_cat,
				'parent_cat' => $nelson_cat,
				'taxonomy'   => $nelson_taxonomy,
				'post_type'  => $nelson_post_type,
				'page'       => 1,
				'sticky'     => $nelson_sticky_out,
			)
		);
	}

	nelson_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'nelson_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'nelson_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
