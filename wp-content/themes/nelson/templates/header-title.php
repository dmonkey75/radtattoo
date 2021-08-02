<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */

// Page (category, tag, archive, author) title

if ( nelson_need_page_title() ) {
	nelson_sc_layouts_showed( 'title', true );
	nelson_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								nelson_show_post_meta(
									apply_filters(
										'nelson_filter_post_meta_args', array(
											'components' => nelson_array_get_keys_by_value( nelson_get_theme_option( 'meta_parts' ) ),
											'counters'   => nelson_array_get_keys_by_value( nelson_get_theme_option( 'counters' ) ),
											'seo'        => nelson_is_on( nelson_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$nelson_blog_title           = nelson_get_blog_title();
							$nelson_blog_title_text      = '';
							$nelson_blog_title_class     = '';
							$nelson_blog_title_link      = '';
							$nelson_blog_title_link_text = '';
							if ( is_array( $nelson_blog_title ) ) {
								$nelson_blog_title_text      = $nelson_blog_title['text'];
								$nelson_blog_title_class     = ! empty( $nelson_blog_title['class'] ) ? ' ' . $nelson_blog_title['class'] : '';
								$nelson_blog_title_link      = ! empty( $nelson_blog_title['link'] ) ? $nelson_blog_title['link'] : '';
								$nelson_blog_title_link_text = ! empty( $nelson_blog_title['link_text'] ) ? $nelson_blog_title['link_text'] : '';
							} else {
								$nelson_blog_title_text = $nelson_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $nelson_blog_title_class ); ?>">
								<?php
								$nelson_top_icon = nelson_get_term_image_small();
								if ( ! empty( $nelson_top_icon ) ) {
									$nelson_attr = nelson_getimagesize( $nelson_top_icon );
									?>
									<img src="<?php echo esc_url( $nelson_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'nelson' ); ?>"
										<?php
										if ( ! empty( $nelson_attr[3] ) ) {
											nelson_show_layout( $nelson_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses( $nelson_blog_title_text, 'nelson_kses_content' );
								?>
							</h1>
							<?php
							if ( ! empty( $nelson_blog_title_link ) && ! empty( $nelson_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $nelson_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $nelson_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'nelson_action_breadcrumbs' );
						$nelson_breadcrumbs = ob_get_contents();
						ob_end_clean();
						nelson_show_layout( $nelson_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
