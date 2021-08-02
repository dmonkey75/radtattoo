<?php
/**
 * The style "featured" of the Team
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4.3
 */

$args = get_query_var('trx_addons_args_sc_team');

$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
$link = empty($args['no_links']) ? get_permalink() : '';

if ($args['slider']) {
	?><div class="slider-slide swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'], !empty($args['columns_tablet']) ? $args['columns_tablet'] : '', !empty($args['columns_mobile']) ? $args['columns_mobile'] : '')); ?>"><?php
}
?>
<div data-post-id="<?php the_ID(); ?>" <?php
	post_class( 'sc_team_item' . (empty($post_link) ? ' no_links' : '') );
	trx_addons_add_blog_animation('team', $args);
?>>
	<?php
	// Featured image
	trx_addons_get_template_part('templates/tpl.featured.php',
								'trx_addons_args_featured',
								apply_filters('trx_addons_filter_args_featured', array(
											'allow_theme_replace' => false,
											'no_links' => empty($link),
											'class' => 'sc_team_item_thumb',
											'hover' => !empty($meta['socials']) ? 'info' : 'zoomin',
											'thumb_size' => ( $args['columns'] > 3 ? nelson_get_thumb_size('big-team-second') : nelson_get_thumb_size('big-team') ),
											'post_info' => !empty($meta['socials']) 
														? '<div class="trx_addons_hover_content">'
															. '<h4 class="sc_team_item_title entry-title trx_addons_hover_title">'
																. (!empty($link) ? '<a href="' . esc_url($link) . '">' : '')
																	. get_the_title()
																. (!empty($link) ? '</a>' : '')
															. '</h4>'
															. ( has_excerpt()
																? '<div class="sc_team_item_content trx_addons_hover_text">'
                                                                        . get_the_excerpt()
																	. '</div>'
																: '' )
                                                            . (!empty($link) ? '<div class="btn_wrap">' : '')
                                                                . (!empty($link) ? '<a href="' . esc_url($link) . '" class="sc_button sc_button_simple">' : '')
                                                                . esc_html($args['more_text'])
                                                                . (!empty($link) ? '</a>' : '')
                                                            . (!empty($link) ? '</div>' : '')
															. '</div>'
														: ''
											), 'team-featured')
								);
	?>
</div>
<?php
if ($args['slider'] || $args['columns'] > 1) {
	?></div><?php
}
?>