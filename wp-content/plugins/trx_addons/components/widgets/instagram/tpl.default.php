<?php
/**
 * The style "default" of the Widget "Instagram"
 *
 * @package ThemeREX Addons
 * @since v1.6.47
 */

$args = get_query_var('trx_addons_args_widget_instagram');
extract($args);

// Before widget (defined by themes)
trx_addons_show_layout($before_widget);
			
// Widget title if one was input (before and after defined by themes)
trx_addons_show_layout($title, $before_title, $after_title);

$resp = trx_addons_widget_instagram_get_recent_photos(array(
		'demo' => ! empty($demo) ? $demo : 0,
		'media' => ! empty($media) ? $media : 'all',
		'hashtag' =>  ! empty($hashtag) ? $hashtag : '',
		'count' => max(1, (int) $count)
));

// Widget body
?><div class="widget_instagram_wrap">
	<div class="widget_instagram_images widget_instagram_images_columns_<?php
				echo esc_attr($columns);
				if ($columns_gap > 0) {
					echo ' ' . esc_attr(trx_addons_add_inline_css_class('margin-right:-'.trx_addons_prepare_css_value($columns_gap)));
				}
				?>"<?php
		// If images are not available from server side - add params to get images from client side
		if ( empty($resp['data']) || ! is_array($resp['data']) || count($resp['data']) == 0 ) {
			global $TRX_ADDONS_STORAGE;
			if ( empty($TRX_ADDONS_STORAGE['instagram_hash']) ) $TRX_ADDONS_STORAGE['instagram_hash'] = array();
			if ( empty($TRX_ADDONS_STORAGE['instagram_hash'][$hashtag]) ) $TRX_ADDONS_STORAGE['instagram_hash'][$hashtag] = 0;
			$TRX_ADDONS_STORAGE['instagram_hash'][$hashtag]++;
			$hash = md5( $hashtag . '-' . $TRX_ADDONS_STORAGE['instagram_hash'][$hashtag] );
			set_transient( sprintf( 'trx_addons_instagram_args_%s', $hash ), $args, 60 );       // Store to the cache for 60s
			?>
			data-instagram-load="1"
			data-instagram-hash="<?php echo esc_attr( $hash ); ?>"
			data-instagram-hashtag="<?php echo esc_attr( $hashtag ); ?>"
			<?php
		}
	?>><?php
		// If images are available from server side
		if ( ! empty($resp['data']) && is_array($resp['data']) && count($resp['data']) > 0 ) {
			$user = '';
			$total = 0;
			foreach( $resp['data'] as $v ) {
				$total++;
				if ( empty($user) && !empty($v['user']['username']) ) {
					$user = $v['user']['username'];
				}
				$class = trx_addons_add_inline_css_class(
								'width:'.round(100/$columns, 4).'%;'
								. ($columns_gap > 0
									? 'padding: 0 '.trx_addons_prepare_css_value($columns_gap).' '.trx_addons_prepare_css_value($columns_gap).' 0;'
									: ''
									)
								);
				$thumb_size = apply_filters( 'trx_addons_filter_instagram_thumb_size', 'standard_resolution' );
				printf( 
					apply_filters( 'trx_addons_filter_instagram_thumb_item',
						'<div class="widget_instagram_images_item_wrap %6$s">'
							. ($links != 'none' && ($v['type'] != 'video' || $links == 'instagram')
								? '<a href="%5$s"' . ( $links == 'instagram' ? ' target="_blank"' : '' )
								: '<div'
								)
							. ' title="%4$s"'
							. ' class="widget_instagram_images_item widget_instagram_images_item_type_'.esc_attr($v['type'])
								. ($v['type'] == 'video'	// && $links != 'none'
										? ' ' . trx_addons_add_inline_css_class('background-image: url('.esc_url($v['images'][$thumb_size]['url']).');')
										: ''
									)
								. '"'
						. '>'
								. ($v['type'] == 'video'
									? ($links != 'instagram'
										? trx_addons_get_video_layout(array(
																		'link' => $v['videos'][$thumb_size]['url'],
																		'cover' => $links != 'none' ? $v['images'][$thumb_size]['url'] : '',
																		'show_cover' => false,	//$links != 'none',
																		'popup' => $links == 'popup'
																		))
										: '')
									: '<img src="%1$s" width="%2$d" height="%3$d" alt="%4$s">'
									)
								. '<span class="widget_instagram_images_item_counters">'
									. '<span class="widget_instagram_images_item_counter_likes trx_addons_icon-heart' . (empty($v['likes']['count']) ? '-empty' : '') . '">'
										. esc_attr($v['likes']['count'])
									. '</span>'
									. '<span class="widget_instagram_images_item_counter_comments trx_addons_icon-comment' . (empty($v['comments']['count']) ? '-empty' : '') . '">'
										. esc_attr($v['comments']['count'])
									. '</span>'
								. '</span>'
							. ($links != 'none' && ($v['type'] != 'video' || $links == 'instagram')
								? '</a>'
								: '</div>'
								)
						. '</div>'
					),
					esc_url($v['images'][$thumb_size]['url']),
					$v['images'][$thumb_size]['width'],
					$v['images'][$thumb_size]['height'],
					$v['caption']['text'],
					esc_url( empty($demo) && $links == 'instagram' ? $v['link'] : $v['images'][$thumb_size]['url']),
					$class
				);
				if ( $total >= $count ) break;
			}
		} else {
			wp_enqueue_script( 'trx_addons-widget_instagram_load', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'instagram/instagram_load.js'), array('jquery'), null, true );
		}
	?></div><?php	

	if ( empty($demo) && $follow && !empty($hashtag) ) {
		$url = 'https://www.instagram.com/'
						. ( $hashtag[0] == '#'
							? 'explore/tags/' . substr( $hashtag, 1 )	// Get output by hashtag
							: trim( $hashtag )							// Get output by username
							)
						. '/';
		?><div class="widget_instagram_follow_link_wrap"><a href="<?php echo esc_url($url); ?>"
					class="<?php echo esc_attr(apply_filters('trx_addons_filter_widget_instagram_link_classes', 'widget_instagram_follow_link sc_button', $args)); ?>"
					target="_blank"><?php
			if ( $hashtag[0] == '#' ) {
				esc_html_e('View more', 'trx_addons');
			} else {
				esc_html_e('Follow Me', 'trx_addons');
			}
		?></a></div><?php
	}
?></div><?php	

// After widget (defined by themes)
trx_addons_show_layout($after_widget);
