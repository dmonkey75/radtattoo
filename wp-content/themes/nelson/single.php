<?php
/**
 * The template to display single post
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */

// Full post loading
$full_post_loading        = nelson_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading        = nelson_get_value_gp( 'action' ) == 'prev_post_loading';

// Position of the related posts
$nelson_related_position = nelson_get_theme_option( 'related_position' );

// Type of the prev/next posts navigation
$nelson_posts_navigation = nelson_get_theme_option( 'posts_navigation' );
$nelson_prev_post        = false;

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading || $prev_post_loading ) && ! in_array( nelson_get_theme_option( 'single_style' ), array( 'in-above', 'in-below', 'in-over', 'in-sticky' ) ) ) {
	nelson_storage_set_array( 'options_meta', 'single_style', 'in-below' );
}

get_header();

while ( have_posts() ) {
	the_post();

	// Type of the prev/next posts navigation
	if ( 'scroll' == $nelson_posts_navigation ) {
		$nelson_prev_post = get_previous_post( true );         // Get post from same category
		if ( ! $nelson_prev_post ) {
			$nelson_prev_post = get_previous_post( false );    // Get post from any category
			if ( ! $nelson_prev_post ) {
				$nelson_posts_navigation = 'links';
			}
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $nelson_prev_post ) ) {
		nelson_sc_layouts_showed( 'featured', false );
		nelson_sc_layouts_showed( 'title', false );
		nelson_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $nelson_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'nelson_filter_get_template_part', 'content', 'single-' . nelson_get_theme_option( 'single_style' ) ), 'single-' . nelson_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $nelson_related_position, 'inside' ) === 0 ) {
		$nelson_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'nelson_action_related_posts' );
		$nelson_related_content = ob_get_contents();
		ob_end_clean();

		$nelson_related_position_inside = max( 0, min( 9, nelson_get_theme_option( 'related_position_inside' ) ) );
		if ( 0 == $nelson_related_position_inside ) {
			$nelson_related_position_inside = mt_rand( 1, 9 );
		}

		$nelson_p_number = 0;
		$nelson_related_inserted = false;
		for ( $i = 0; $i < strlen( $nelson_content ) - 3; $i++ ) {
			if ( '<' == $nelson_content[ $i ] && 'p' == $nelson_content[ $i + 1 ] && in_array( $nelson_content[ $i + 2 ], array( '>', ' ' ) ) ) {
				$nelson_p_number++;
				if ( $nelson_related_position_inside == $nelson_p_number ) {
					$nelson_related_inserted = true;
					$nelson_content = ( $i > 0 ? substr( $nelson_content, 0, $i ) : '' )
										. $nelson_related_content
										. substr( $nelson_content, $i );
				}
			}
		}
		if ( ! $nelson_related_inserted ) {
			$nelson_content .= $nelson_related_content;
		}

		nelson_show_layout( $nelson_content );
	}

	// Author bio
	if ( nelson_get_theme_option( 'show_author_info' ) == 1
		&& ! is_attachment()
		&& get_the_author_meta( 'description' )
		&& ( 'scroll' != $nelson_posts_navigation || nelson_get_theme_option( 'posts_navigation_scroll_hide_author' ) == 0 )
		&& ( ! $full_post_loading || nelson_get_theme_option( 'open_full_post_hide_author' ) == 0 )
	) {
		do_action( 'nelson_action_before_post_author' );
		get_template_part( apply_filters( 'nelson_filter_get_template_part', 'templates/author-bio' ) );
		do_action( 'nelson_action_after_post_author' );
	}

	// Previous/next post navigation.
	if ( 'links' == $nelson_posts_navigation && ! $full_post_loading ) {
		do_action( 'nelson_action_before_post_navigation' );
		?>
		<div class="nav-links-single<?php
			if ( ! nelson_is_off( nelson_get_theme_option( 'posts_navigation_fixed' ) ) ) {
				echo ' nav-links-fixed fixed';
			}
		?>">
			<?php
			the_post_navigation(
				array(
					'next_text' => '<span class="nav-arrow"></span>'
						. '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'nelson' ) . '</span> '
						. '<h6 class="post-title">%title</h6>'
						. '<span class="post_date">%date</span>',
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'nelson' ) . '</span> '
						. '<h6 class="post-title">%title</h6>'
						. '<span class="post_date">%date</span>',
				)
			);
			?>
		</div>
		<?php
		do_action( 'nelson_action_after_post_navigation' );
	}

	// Related posts
	if ( 'below_content' == $nelson_related_position
		&& ( 'scroll' != $nelson_posts_navigation || nelson_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || nelson_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'nelson_action_related_posts' );
	}

	// If comments are open or we have at least one comment, load up the comment template.
	$nelson_comments_number = get_comments_number();
	if ( comments_open() || $nelson_comments_number > 0 ) {
		if ( nelson_get_value_gp( 'show_comments' ) == 1 || ( ! $full_post_loading && ( 'scroll' != $nelson_posts_navigation || nelson_get_theme_option( 'posts_navigation_scroll_hide_comments' ) == 0 || nelson_check_url( '#comment' ) ) ) ) {
			do_action( 'nelson_action_before_comments' );
			comments_template();
			do_action( 'nelson_action_after_comments' );
		} else {
			?>
			<div class="show_comments_single">
				<a href="<?php echo esc_url( add_query_arg( array( 'show_comments' => 1 ), get_comments_link() ) ); ?>" class="theme_button show_comments_button">
					<?php
					if ( $nelson_comments_number > 0 ) {
						echo esc_html( sprintf( _n( 'Show comment', 'Show comments ( %d )', $nelson_comments_number, 'nelson' ), $nelson_comments_number ) );
					} else {
						esc_html_e( 'Leave a comment', 'nelson' );
					}
					?>
				</a>
			</div>
			<?php
		}
	}

	if ( 'scroll' == $nelson_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $nelson_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $nelson_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $nelson_prev_post ) ); ?>">
		</div>
		<?php
	}
}

get_footer();
