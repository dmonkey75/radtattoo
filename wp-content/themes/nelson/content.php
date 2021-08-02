<?php
/**
 * The default template to display the content of the single post or attachment
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */
?>
<article id="post-<?php the_ID(); ?>"
	<?php
	post_class( 'post_item_single'
		. ' post_type_' . esc_attr( get_post_type() ) 
		. ' post_format_' . esc_attr( str_replace( 'post-format-', '', get_post_format() ) )
	);
	nelson_add_seo_itemprops();
	?>
>
<?php

	do_action( 'nelson_action_before_post_data' );

	nelson_add_seo_snippets();

	do_action( 'nelson_action_before_post_content' );

	// Post content
	?>
	<div class="post_content post_content_single entry-content" itemprop="mainEntityOfPage">
		<?php
		the_content();

		do_action( 'nelson_action_before_post_pagination' );

		wp_link_pages(
			array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'nelson' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'nelson' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			)
		);

		// Taxonomies and share
		if ( is_single() && ! is_attachment() ) {

			ob_start();

			// Post taxonomies
			the_tags( '<span class="post_meta_item post_tags"><span class="post_meta_label">' . esc_html__( 'Tags:', 'nelson' ) . '</span> ', ', ', '</span>' );

			// Share
			if ( nelson_is_on( nelson_get_theme_option( 'show_share_links' ) ) ) {
				nelson_show_share_links(
					array(
						'type'    => 'block',
						'caption' => '',
						'before'  => '<span class="post_meta_item post_share"><span class="label_share">' . esc_html__('share this:', 'nelson') . '</span>',
						'after'   => '</span>',
					)
				);
			}

			$nelson_tags_output = ob_get_contents();

			ob_end_clean();

			if ( ! empty( $nelson_tags_output ) ) {

				do_action( 'nelson_action_before_post_meta' );

				nelson_show_layout( $nelson_tags_output, '<div class="post_meta post_meta_single">', '</div>' );

				do_action( 'nelson_action_after_post_meta' );

			}
		}
		?>
	</div><!-- .entry-content -->


	<?php
	do_action( 'nelson_action_after_post_content' );

	do_action( 'nelson_action_after_post_data' );
	?>
</article>
