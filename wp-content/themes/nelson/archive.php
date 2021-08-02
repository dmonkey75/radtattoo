<?php
/**
 * The template file to display taxonomies archive
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0.57
 */

// Redirect to the template page (if exists) for output current taxonomy
if ( is_category() || is_tag() || is_tax() ) {
	$nelson_term = get_queried_object();
	global $wp_query;
	if ( ! empty( $nelson_term->taxonomy ) && ! empty( $wp_query->posts[0]->post_type ) ) {
		$nelson_taxonomy  = nelson_get_post_type_taxonomy( $wp_query->posts[0]->post_type );
		if ( $nelson_taxonomy == $nelson_term->taxonomy ) {
			$nelson_template_page_id = nelson_get_template_page_id( array(
				'post_type'  => $wp_query->posts[0]->post_type,
				'parent_cat' => $nelson_term->term_id
			) );
			if ( 0 < $nelson_template_page_id ) {
				wp_safe_redirect( get_permalink( $nelson_template_page_id ) );
				exit;
			}
		}
	}
}
// If template page is not exists - display default blog archive template
get_template_part( apply_filters( 'nelson_filter_get_template_part', nelson_blog_archive_get_template() ) );
