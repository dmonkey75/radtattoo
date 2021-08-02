<?php
/**
 * Theme lists
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) {
	exit; }



// Return numbers range
if ( ! function_exists( 'nelson_get_list_range' ) ) {
	function nelson_get_list_range( $from = 1, $to = 2, $prepend_inherit = false ) {
		$list = array();
		for ( $i = $from; $i <= $to; $i++ ) {
			$list[ $i ] = $i;
		}
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}



// Return styles list
if ( ! function_exists( 'nelson_get_list_styles' ) ) {
	function nelson_get_list_styles( $from = 1, $to = 2, $prepend_inherit = false ) {
		$list = array();
		for ( $i = $from; $i <= $to; $i++ ) {
			// Translators: Add number to the style name 'Style 1', 'Style 2' ...
			$list[ $i ] = sprintf( esc_html__( 'Style %d', 'nelson' ), $i );
		}
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( ! function_exists( 'nelson_get_list_yesno' ) ) {
	function nelson_get_list_yesno( $prepend_inherit = false ) {
		$list = array(
			'yes' => esc_html__( 'Yes', 'nelson' ),
			'no'  => esc_html__( 'No', 'nelson' ),
		);
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return list with 'Yes' and 'No' items for checkboxes: 'Yes' -> 1, 'No' -> 0
if ( ! function_exists( 'nelson_get_list_checkbox_values' ) ) {
	function nelson_get_list_checkbox_values( $prepend_inherit = false ) {
		$list = apply_filters(
			'nelson_filter_list_checkbox_values', array(
				1         => esc_html__( 'Yes', 'nelson' ),
				0         => esc_html__( 'No', 'nelson' ),
			)
		);
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( ! function_exists( 'nelson_get_list_onoff' ) ) {
	function nelson_get_list_onoff( $prepend_inherit = false ) {
		$list = array(
			'on'  => esc_html__( 'On', 'nelson' ),
			'off' => esc_html__( 'Off', 'nelson' ),
		);
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( ! function_exists( 'nelson_get_list_showhide' ) ) {
	function nelson_get_list_showhide( $prepend_inherit = false ) {
		$list = array(
			'show' => esc_html__( 'Show', 'nelson' ),
			'hide' => esc_html__( 'Hide', 'nelson' ),
		);
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( ! function_exists( 'nelson_get_list_directions' ) ) {
	function nelson_get_list_directions( $prepend_inherit = false ) {
		$list = array(
			'horizontal' => esc_html__( 'Horizontal', 'nelson' ),
			'vertical'   => esc_html__( 'Vertical', 'nelson' ),
		);
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return list with paddings sizes
if ( ! function_exists( 'nelson_get_list_paddings' ) ) {
	function nelson_get_list_paddings( $prepend_inherit = false ) {
		$list = apply_filters(
			'nelson_filter_list_paddings', array(
				'none'   => esc_html__( 'None', 'nelson' ),
				'small'  => esc_html__( 'Small', 'nelson' ),
				'medium' => esc_html__( 'Medium', 'nelson' ),
				'large'  => esc_html__( 'Large', 'nelson' ),
			)
		);
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return list with image's hovers
if ( ! function_exists( 'nelson_get_list_hovers' ) ) {
	function nelson_get_list_hovers( $prepend_inherit = false ) {
		$list = apply_filters(
			'nelson_filter_list_hovers', array(
				'dots'   => esc_html__( 'Dots', 'nelson' ),
				'icon'   => esc_html__( 'Icon', 'nelson' ),
				'icons'  => esc_html__( 'Icons', 'nelson' ),
				'zoom'   => esc_html__( 'Zoom', 'nelson' ),
				'fade'   => esc_html__( 'Fade', 'nelson' ),
				'slide'  => esc_html__( 'Slide', 'nelson' ),
				'pull'   => esc_html__( 'Pull', 'nelson' ),
				'border' => esc_html__( 'Border', 'nelson' ),
			)
		);
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( ! function_exists( 'nelson_get_list_sidebars' ) ) {
	function nelson_get_list_sidebars( $prepend_inherit = false, $add_hide = false ) {
		$list = nelson_storage_get( 'list_sidebars' );
		if ( '' == $list ) {
			global $wp_registered_sidebars;
			$list = array();
			if ( is_array( $wp_registered_sidebars ) ) {
				foreach ( $wp_registered_sidebars as $k => $v ) {
					$list[ $v['id'] ] = $v['name'];
				}
			}
			nelson_storage_set( 'list_sidebars', $list );
		}
		if ( $add_hide ) {
			$list = nelson_array_merge( array( 'hide' => esc_html__( '- Select widgets -', 'nelson' ) ), $list );
		}
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return sidebars positions
if ( ! function_exists( 'nelson_get_list_sidebars_positions' ) ) {
	function nelson_get_list_sidebars_positions( $prepend_inherit = false ) {
		$list = apply_filters(
			'nelson_filter_list_sidebars_positions', array(
				'hide'  => esc_html__( 'Hide', 'nelson' ),
				'left'  => esc_html__( 'Left', 'nelson' ),
				'right' => esc_html__( 'Right', 'nelson' ),
			)
		);
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return sidebars positions on the small screen
if ( ! function_exists( 'nelson_get_list_sidebars_positions_ss' ) ) {
	function nelson_get_list_sidebars_positions_ss( $prepend_inherit = false ) {
		$list = apply_filters(
			'nelson_filter_list_sidebars_positions_ss', array(
				'above' => esc_html__( 'Above the content', 'nelson' ),
				'below' => esc_html__( 'Below the content', 'nelson' ),
				'float' => esc_html__( 'Floating bar', 'nelson' ),
			)
		);
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return sidebar styles
if ( ! function_exists( 'nelson_get_list_sidebar_styles' ) ) {
	function nelson_get_list_sidebar_styles( $prepend_inherit = false ) {
		static $list = false;
		if ( ! $list ) {
			$list = apply_filters( 'nelson_filter_list_sidebar_styles', array() );
		}
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}


// Return header/footer/sidebar types
if ( ! function_exists( 'nelson_get_list_header_footer_types' ) ) {
	function nelson_get_list_header_footer_types( $prepend_inherit = false ) {
		$list = apply_filters(
			'nelson_filter_list_header_footer_types', array(
				'default' => esc_html__( 'Default', 'nelson' ),
			)
		);
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return header styles
if ( ! function_exists( 'nelson_get_list_header_styles' ) ) {
	function nelson_get_list_header_styles( $prepend_inherit = false ) {
		static $list = false;
		if ( ! $list ) {
			$list = apply_filters( 'nelson_filter_list_header_styles', array() );
		}
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return header positions
if ( ! function_exists( 'nelson_get_list_header_positions' ) ) {
	function nelson_get_list_header_positions( $prepend_inherit = false ) {
		$list = array(
			'default' => esc_html__( 'Default', 'nelson' ),
			'over'    => esc_html__( 'Over', 'nelson' ),
			'under'   => esc_html__( 'Under', 'nelson' ),
		);
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return footer styles
if ( ! function_exists( 'nelson_get_list_footer_styles' ) ) {
	function nelson_get_list_footer_styles( $prepend_inherit = false ) {
		static $list = false;
		if ( ! $list ) {
			$list = apply_filters( 'nelson_filter_list_footer_styles', array() );
		}
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return body styles list, prepended inherit
if ( ! function_exists( 'nelson_get_list_body_styles' ) ) {
	function nelson_get_list_body_styles( $prepend_inherit = false, $force_fullscreen = false ) {
		$list = array(
			'boxed' => esc_html__( 'Boxed', 'nelson' ),
			'wide'  => esc_html__( 'Wide', 'nelson' ),
		);
		if ( apply_filters( 'nelson_filter_allow_fullscreen', nelson_get_theme_setting( 'allow_fullscreen' ) || $force_fullscreen || nelson_get_edited_post_type() == 'page' ) ) {
			$list['fullwide']   = esc_html__( 'Fullwidth', 'nelson' );
			$list['fullscreen'] = esc_html__( 'Fullscreen', 'nelson' );
		}
		$list = apply_filters( 'nelson_filter_list_body_styles', $list );
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return meta parts list
if ( ! function_exists( 'nelson_get_list_meta_parts' ) ) {
	function nelson_get_list_meta_parts( $prepend_inherit = false ) {
		$list = apply_filters(
			'nelson_filter_list_meta_parts',
			array(
				'author'     => esc_html__( 'Post author', 'nelson' ),
				'date'       => esc_html__( 'Post date', 'nelson' ),
				'views'      => esc_html__( 'Views', 'nelson' ),
				'likes'      => esc_html__( 'Likes', 'nelson' ),
				'comments'   => esc_html__( 'Comments', 'nelson' ),
				'share'      => esc_html__( 'Share links', 'nelson' ),
				'categories' => esc_html__( 'Categories', 'nelson' ),
				'edit'       => esc_html__( 'Edit link', 'nelson' ),
			)
		);
		// Reorder meta_parts with last user's choise
		if ( nelson_storage_isset( 'options', 'meta_parts', 'val' ) ) {
			$parts = explode( '|', nelson_get_theme_option( 'meta_parts' ) );
			$list_new = array();
			foreach( $parts as $part ) {
				$part = explode( '=', $part );
				if ( isset( $list[ $part[0] ] ) ) {
					$list_new[ $part[0] ] = $list[ $part[0] ];
					unset( $list[ $part[0] ] );
				}
			}
			$list = count( $list ) > 0 ? array_merge( $list_new, $list ) : $list_new;
		}
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return blog styles list, prepended inherit
if ( ! function_exists( 'nelson_get_list_blog_styles' ) ) {
	function nelson_get_list_blog_styles( $prepend_inherit = false, $filter = 'arh' ) {
		$list   = array();
		$styles = nelson_storage_get( 'blog_styles' );
		if ( is_array( $styles ) ) {
			foreach ( $styles as $k => $v ) {
				if ( empty( $filter ) || empty( $v[ "{$filter}_allowed" ] ) || $v[ "{$filter}_allowed" ] ) {
					if ( 'arh' == $filter && isset( $v['columns'] ) && is_array( $v['columns'] ) ) {
						foreach ( $v['columns'] as $col ) {
							// Translators: Make blog style title: "Layout name /X columns/"
							$list[ "{$k}_{$col}" ] = sprintf( ' ' . _n( '%1$s /%2$d column/', '%1$s /%2$d columns/', $col, 'nelson' ), $v['title'], $col );
						}
					} else {
						$list[ $k ] = $v['title'];
					}
				}
			}
		}
		$list = apply_filters( 'nelson_filter_list_blog_styles', $list, $filter );
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return single styles list, prepended inherit
if ( ! function_exists( 'nelson_get_list_single_styles' ) ) {
	function nelson_get_list_single_styles( $prepend_inherit = false ) {
		$list   = array();
		$styles = nelson_storage_get( 'single_styles' );
		if ( is_array( $styles ) ) {
			foreach ( $styles as $k => $v ) {
				$list[ $k ] = $v['title'];
			}
		}
		$list = apply_filters( 'nelson_filter_list_single_styles', $list );
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}


// Return list of categories
if ( ! function_exists( 'nelson_get_list_categories' ) ) {
	function nelson_get_list_categories( $prepend_inherit = false ) {
		$list = nelson_storage_get( 'list_categories' );
		if ( '' == $list ) {
			$list       = array();
			$taxonomies = get_categories(
				array(
					'type'         => 'post',
					'orderby'      => 'name',
					'order'        => 'ASC',
					'hide_empty'   => 0,
					'hierarchical' => 1,
					'taxonomy'     => 'category',
					'pad_counts'   => false,
				)
			);
			if ( is_array( $taxonomies ) && count( $taxonomies ) > 0 ) {
				foreach ( $taxonomies as $cat ) {
					$list[ $cat->term_id ] = apply_filters( 'nelson_filter_term_name', $cat->name, $cat );
				}
			}
			nelson_storage_set( 'list_categories', $list );
		}
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}


// Return list of taxonomies
if ( ! function_exists( 'nelson_get_list_terms' ) ) {
	function nelson_get_list_terms( $prepend_inherit = false, $taxonomy = 'category' ) {
		$list = nelson_storage_get( 'list_taxonomies_' . ( $taxonomy ) );
		if ( '' == $list ) {
			$list       = array();
			$taxonomies = get_terms(
				$taxonomy, array(
					'orderby'      => 'name',
					'order'        => 'ASC',
					'hide_empty'   => 0,
					'hierarchical' => 1,
					'taxonomy'     => $taxonomy,
					'pad_counts'   => false,
				)
			);
			if ( is_array( $taxonomies ) && count( $taxonomies ) > 0 ) {
				foreach ( $taxonomies as $cat ) {
					$list[ $cat->term_id ] = apply_filters( 'nelson_filter_term_name', $cat->name, $cat );  				}
			}
			nelson_storage_set( 'list_taxonomies_' . ( $taxonomy ), $list );
		}
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return list of post's types
if ( ! function_exists( 'nelson_get_list_posts_types' ) ) {
	function nelson_get_list_posts_types( $prepend_inherit = false ) {
		$list = nelson_storage_get( 'list_posts_types' );
		if ( '' == $list ) {
			$list = apply_filters(
				'nelson_filter_list_posts_types', array(
					'post' => esc_html__( 'Post', 'nelson' ),
				)
			);
			nelson_storage_set( 'list_posts_types', $list );
		}
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( ! function_exists( 'nelson_get_list_posts' ) ) {
	function nelson_get_list_posts( $prepend_inherit = false, $opt = array() ) {
		$opt = array_merge(
			array(
				'post_type'        => 'post',
				'post_status'      => 'publish',
				'post_parent'      => '',
				'taxonomy'         => 'category',
				'taxonomy_value'   => '',
				'meta_key'         => '',
				'meta_value'       => '',
				'meta_compare'     => '',
				'suppress_filters' => false,  // Need to compatibility with WPML, because default value is true in the get_posts()
				'posts_per_page'   => -1,
				'orderby'          => 'post_date',
				'order'            => 'desc',
				'not_selected'     => true,
				'return'           => 'id',
			), is_array( $opt ) ? $opt : array( 'post_type' => $opt )
		);

		$hash = 'list_posts'
				. '_' . ( is_array( $opt['post_type'] ) ? join( '_', $opt['post_type'] ) : $opt['post_type'] )
				. '_' . ( is_array( $opt['post_parent'] ) ? join( '_', $opt['post_parent'] ) : $opt['post_parent'] )
				. '_' . ( $opt['taxonomy'] )
				. '_' . ( is_array( $opt['taxonomy_value'] ) ? join( '_', $opt['taxonomy_value'] ) : $opt['taxonomy_value'] )
				. '_' . ( $opt['meta_key'] )
				. '_' . ( $opt['meta_compare'] )
				. '_' . ( $opt['meta_value'] )
				. '_' . ( $opt['orderby'] )
				. '_' . ( $opt['order'] )
				. '_' . ( $opt['return'] )
				. '_' . ( $opt['posts_per_page'] );
		$list = nelson_storage_get( $hash );
		if ( '' == $list ) {
			$list = array();
			if ( false !== $opt['not_selected'] ) {
				$list['none'] = true === $opt['not_selected'] ? esc_html__( '- Not selected -', 'nelson' ) : $opt['not_selected'];
			}
			$args = array(
				'post_type'           => $opt['post_type'],
				'post_status'         => $opt['post_status'],
				'posts_per_page'      => -1 == $opt['posts_per_page'] ? 1000 : $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'             => $opt['orderby'],
				'order'               => $opt['order'],
			);
			if ( ! empty( $opt['post_parent'] ) ) {
				if ( is_array( $opt['post_parent'] ) ) {
					$args['post_parent__in'] = $opt['post_parent'];
				} else {
					$args['post_parent'] = $opt['post_parent'];
				}
			}
			if ( ! empty( $opt['taxonomy_value'] ) ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field'    => is_array( $opt['taxonomy_value'] )
										? ( (int) $opt['taxonomy_value'][0] > 0 ? 'term_taxonomy_id' : 'slug' )
										: ( (int) $opt['taxonomy_value'] > 0 ? 'term_taxonomy_id' : 'slug' ),
						'terms'    => is_array( $opt['taxonomy_value'] )
										? $opt['taxonomy_value']
										: ( (int) $opt['taxonomy_value'] > 0 ? (int) $opt['taxonomy_value'] : $opt['taxonomy_value'] ),
					),
				);
			}
			if ( ! empty( $opt['meta_key'] ) ) {
				$args['meta_key'] = $opt['meta_key'];
			}
			if ( ! empty( $opt['meta_value'] ) ) {
				$args['meta_value'] = $opt['meta_value'];
			}
			if ( ! empty( $opt['meta_compare'] ) ) {
				$args['meta_compare'] = $opt['meta_compare'];
			}
			$posts = get_posts( $args );
			if ( is_array( $posts ) && count( $posts ) > 0 ) {
				foreach ( $posts as $post ) {
					$list[ 'id' == $opt['return'] ? $post->ID : $post->post_title ] = $post->post_title;
				}
			}
			nelson_storage_set( $hash, $list );
		}
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}


// Return list of registered users
if ( ! function_exists( 'nelson_get_list_users' ) ) {
	function nelson_get_list_users( $prepend_inherit = false, $roles = array( 'administrator', 'editor', 'author', 'contributor', 'shop_manager' ) ) {
		$list = nelson_storage_get( 'list_users' );
		if ( '' == $list ) {
			$list         = array();
			$list['none'] = esc_html__( '- Not selected -', 'nelson' );
			$users        = get_users(
				array(
					'orderby' => 'display_name',
					'order'   => 'ASC',
				)
			);
			if ( is_array( $users ) && count( $users ) > 0 ) {
				foreach ( $users as $user ) {
					$accept = true;
					if ( is_array( $user->roles ) ) {
						if ( is_array( $user->roles ) && count( $user->roles ) > 0 ) {
							$accept = false;
							foreach ( $user->roles as $role ) {
								if ( in_array( $role, $roles ) ) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ( $accept ) {
						$list[ $user->user_login ] = $user->display_name;
					}
				}
			}
			nelson_storage_set( 'list_users', $list );
		}
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return menus list, prepended inherit
if ( ! function_exists( 'nelson_get_list_menus' ) ) {
	function nelson_get_list_menus( $prepend_inherit = false ) {
		$list = nelson_storage_get( 'list_menus' );
		if ( '' == $list ) {
			$list            = array();
			$list['default'] = esc_html__( 'Default', 'nelson' );
			$menus           = wp_get_nav_menus();
			if ( is_array( $menus ) && count( $menus ) > 0 ) {
				foreach ( $menus as $menu ) {
					$list[ $menu->slug ] = $menu->name;
				}
			}
			nelson_storage_set( 'list_menus', $list );
		}
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}


// Return list of the specified icons (font icons, svg icons or png icons)
if ( ! function_exists( 'nelson_get_list_icons' ) ) {
	function nelson_get_list_icons( $style ) {
		$lists = get_transient( 'nelson_list_icons' );
		if ( ! is_array( $lists ) || ! isset( $lists[ $style ] ) || ! is_array( $lists[ $style ] ) || count( $lists[ $style ] ) < 2 ) {
			if ( 'icons' == $style ) {
				$lists[ $style ] = nelson_array_from_list( nelson_get_list_icons_classes() );
			} elseif ( 'images' == $style ) {
				$lists[ $style ] = nelson_get_list_images();
			} else { 				$lists[ $style ] = nelson_get_list_images( false, 'svg' );
			}
			if ( is_admin() && is_array( $lists[ $style ] ) && count( $lists[ $style ] ) > 1 ) {
				set_transient( 'nelson_list_icons', $lists, 12 * 60 * 60 );       // Store to the cache for 12 hours
			}
		}
		return $lists[ $style ];
	}
}

// Return iconed classes list
if ( ! function_exists( 'nelson_get_list_icons_classes' ) ) {
	function nelson_get_list_icons_classes( $prepend_inherit = false ) {
		static $list = false;
		if ( ! is_array( $list ) ) {
			$list = ! is_admin() ? array() : nelson_parse_icons_classes( nelson_get_file_dir( 'css/font-icons/css/fontello-codes.css' ) );
		}
		$list = nelson_array_merge( array( 'none' => 'none' ), $list );
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}

// Return images list
if ( ! function_exists( 'nelson_get_list_images' ) ) {
	function nelson_get_list_images( $prepend_inherit = false, $type = 'png' ) {
		$list = function_exists( 'trx_addons_get_list_files' )
				? trx_addons_get_list_files( "css/icons.{$type}", $type )
				: array();
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}


// Additional attributes for VC and SOW
//----------------------------------------------------
if ( ! function_exists( 'nelson_get_list_sc_color_styles' ) ) {
	function nelson_get_list_sc_color_styles( $prepend_inherit = false ) {
		$list = apply_filters(
			'nelson_filter_get_list_sc_color_styles', array(
				'default' => esc_html__( 'Default', 'nelson' ),
				'link2'   => esc_html__( 'Link 2', 'nelson' ),
				'link3'   => esc_html__( 'Link 3', 'nelson' ),
				'dark'    => esc_html__( 'Dark', 'nelson' ),
			)
		);
		return $prepend_inherit ? nelson_array_merge( array( 'inherit' => esc_html__( 'Inherit', 'nelson' ) ), $list ) : $list;
	}
}
