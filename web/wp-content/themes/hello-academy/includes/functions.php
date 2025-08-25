<?php
namespace HelloAcademy;

function theme_setup() {
	if ( is_admin() ) {
		Helper::maybe_update_theme_version_in_db();
	}

	load_theme_textdomain( 'hello-academy', HELLO_ACADEMY_THEME_DIR . 'languages' );

	register_nav_menus( [ 'primary' => __( 'Header', 'hello-academy' ) ] );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support(
		'html5',
		[
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		]
	);
	add_theme_support(
		'custom-logo',
		[
			'height'      => 100,
			'width'       => 350,
			'flex-height' => true,
			'flex-width'  => true,
		]
	);

	/*
	 * Add theme support for selective refresh for widgets.
	 */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Editor Style.
	 */
	add_editor_style( 'assets/css/classic-editor.css' );

	/*
	 * Gutenberg wide images.
	 */
	add_theme_support( 'align-wide' );

	/*
	 * WooCommerce.
	 */
	add_theme_support( 'woocommerce' );
}

/**
 * Enqueue style and scripts
 */
function theme_scripts_styles() {
	wp_enqueue_style( 'hello-academy-web-fonts', Helper::theme_web_fonts_url( 'Inter:wght@300;400;500;600;700;800;900&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,500;1,600;1,700;1,800;1,900&display=swap' ), array(), HELLO_ACADEMY_THEME_VERSION );

	wp_enqueue_style(
		'font-awesome',
		HELLO_ACADEMY_THEME_URI . 'assets/css/font-awesome.min.css',
		[],
		'4.7'
	);
	wp_enqueue_style(
		'hello-academy',
		HELLO_ACADEMY_THEME_URI . 'style.css',
		[],
		HELLO_ACADEMY_THEME_VERSION
	);

	wp_enqueue_style(
		'hello-academy-theme-style',
		HELLO_ACADEMY_THEME_URI . 'assets/css/theme.css',
		[],
		HELLO_ACADEMY_THEME_VERSION
	);

	wp_enqueue_script( 'hell-academy-scripts', HELLO_ACADEMY_THEME_URI . 'assets/js/hello-academy-scripts.js', [ 'jquery' ], HELLO_ACADEMY_THEME_VERSION, true );
	wp_enqueue_script( 'hello-academy-socialshare', HELLO_ACADEMY_THEME_URI . 'assets/js/SocialShare.min.js', array( 'jquery' ), HELLO_ACADEMY_THEME_VERSION, false );

}


function theme_register_sidebar() {
	// Blog Sidebar.
	register_sidebar(
		[
			'name' => esc_html__( 'Blog Sidebar', 'hello-academy' ),
			'id' => 'blog-sidebar',
			'description' => esc_html__( 'Blog Sidebar', 'hello-academy' ),
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		]
	);
	// Footer Sidebar.
	register_sidebar(
		[
			'name' => esc_html__( 'Footer Sidebar', 'hello-academy' ),
			'id' => 'footer-sidebar',
			'description' => esc_html__( 'Add widgets here.', 'hello-academy' ),
			'before_widget' => '<div class="academy-col-lg-3 academy-col-sm-6"><div class="hello-academy-widget %2$s" id="%1$s">',
			'after_widget' => '</div></div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		]
	);

}


function theme_gutenberg_enqueue_assets() {
	wp_enqueue_style( 'hello-academy-web-fonts', Helper::theme_web_fonts_url( 'Inter:wght@300;400;500;600;700;800;900|Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' ), array(), HELLO_ACADEMY_THEME_VERSION );
	wp_enqueue_style( 'hello-academy-gutenberg-editor', HELLO_ACADEMY_THEME_URI . 'assets/css/editor.css', array(), HELLO_ACADEMY_THEME_VERSION );
}


function theme_skip_link_focus_fix() {
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		echo '<script>';
		include HELLO_ACADEMY_THEME_DIR . 'assets/js/skip-link-focus-fix.js';
		echo '</script>';
	} ?>
<script>
/(trident|msie)/i.test(navigator.userAgent) && document.getElementById && window.addEventListener && window
	.addEventListener("hashchange", (function() {
		var t, e = location.hash.substring(1);
		/^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (
			/^(?:a|select|input|button|textarea)$/i.test(t.tagName) || (t.tabIndex = -1), t.focus())
	}), !1);
</script>
	<?php
}


function custom_excerpt_length( $length ) {
	$custom_excerpt_length = get_customizer_settings( 'post_excerpt_length', 30 );
	$length = $custom_excerpt_length;
	return $length;
}


function posts_navigation() {
	global $wp_query;
	$big = 999999999;
	?>
	<div class="hello-academy-pagination">				
		<?php
			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var( 'paged' ) ),
				'total' => $wp_query->max_num_pages,
				'prev_text' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
				'next_text' => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
			) );
		?>
	</div>
	<?php
}



/**
 * Hello Academy breadcrumbs
 */
function breadcrumbs() {
	$home = '<li class="breadcrumb-item"><a href="' . esc_url( home_url() ) . '" title="' . esc_attr__( 'Home', 'hello-academy' ) . '">' . esc_html__( 'Home', 'hello-academy' ) . '</a></li>';
	$show_current = 1;

	global $post;
	$home_link = esc_url( home_url() );
	if ( is_front_page() ) {
		return;
	}    // don't display breadcrumbs on the homepage (yet).

	printf( '%s', $home );

	if ( is_category() ) {
		// category section.
		$this_cat = get_category( get_query_var( 'cat' ), false );
		if ( ! empty( $this_cat->parent ) ) {
			echo get_category_parents( $this_cat->parent, true, ' / ' );
		}
		echo '<li class="breadcrumb-item">' . esc_html__( 'Archive for category', 'hello-academy' ) . ' "' . single_cat_title( '', false ) . '"</li>';
	} elseif ( is_search() ) {
		// search section.
		echo '<li class="breadcrumb-item">' . esc_html__( 'Search results for', 'hello-academy' ) . ' "' . get_search_query() . '"</li>';
	} elseif ( is_day() ) {
		echo '<li class="breadcrumb-item"><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
		echo '<li class="breadcrumb-item"><a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a></li>';
		echo '<li class="breadcrumb-item">' . get_the_time( 'd' ) . '</li>';
	} elseif ( is_month() ) {
		// monthly archive.
		echo '<li class="breadcrumb-item"><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
		echo '<li class="breadcrumb-item">' . get_the_time( 'F' ) . '</li>';
	} elseif ( is_year() ) {
		// yearly archive.
		echo '<li class="breadcrumb-item">' . get_the_time( 'Y' ) . '</li>';
	} elseif ( is_single() && ! is_attachment() ) {
		// single post or page.
		if ( get_post_type() !== 'post' ) {
			$post_type = get_post_type_object( get_post_type() );
			$slug = $post_type->rewrite;
			echo '<li class="breadcrumb-item"><a href="' . $home_link . '/?post_type=' . $slug['slug'] . '">' . $post_type->labels->singular_name . '</a></li>';
			if ( $show_current ) {
				echo '<li class="breadcrumb-item">' . get_the_title() . '</li>';
			}
		} else {
			$cat = get_the_category();
			if ( isset( $cat[0] ) ) {
				$cat = $cat[0];
			} else {
				$cat = false;
			}
			if ( $cat ) {
				$cats = get_category_parents( $cat, true, '   ' );
			} else {
				$cats = false;
			}
			if ( ! $show_current && $cats ) {
				$cats = preg_replace( '#^(.+)\s\s$#', '$1', $cats );
			}
			echo '<li class="breadcrumb-item">' . $cats . '</li>';
			if ( $show_current ) {
				echo '<li class="breadcrumb-item">' . get_the_title() . '</li>';
			}
		}
	} elseif ( ! is_single() && ! is_page() && get_post_type() !== 'post' && ! is_404() ) {
		// some other single item.
		$post_type = get_post_type_object( get_post_type() );
		if ( ! empty( $post_type ) ) {
			echo '<li class="breadcrumb-item">' . $post_type->labels->singular_name . '</li>';
		}
	} elseif ( is_attachment() ) {
		// attachment section.
		$parent = get_post( $post->post_parent );
		$cat = get_the_category( $parent->ID );
		if ( isset( $cat[0] ) ) {
			$cat = $cat[0];
		} else {
			$cat = false;
		}
		if ( $cat ) {
			echo get_category_parents( $cat, true, '   ' );
		}
		echo '<li class="breadcrumb-item"><a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a></li>';
		if ( $show_current ) {
			echo '<li class="breadcrumb-item">' . get_the_title() . '</li>';
		}
	} elseif ( is_page() && ! $post->post_parent ) {
		if ( $show_current ) {
			echo '<li class="breadcrumb-item">' . get_the_title() . '</li>';
		}
	} elseif ( is_page() && $post->post_parent ) {
		// child page.
		$parent_id = $post->post_parent;
		$breadcrumbs = array();
		while ( $parent_id ) {
			$page = get_page( $parent_id );
			$breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>';
			$parent_id = $page->post_parent;
		}
		$breadcrumbs = array_reverse( $breadcrumbs );
		$breadcrumbs_count = count( $breadcrumbs );
		for ( $i = 0; $i < $breadcrumbs_count; $i++ ) {
			printf( '%s', $breadcrumbs[ $i ] );
			if ( $i !== $breadcrumbs_count - 1 ) {
				;
			}
		}
		if ( $show_current ) {
			echo '<li class="breadcrumb-item">' . get_the_title() . '</li>';
		}
	} elseif ( is_tag() ) {
		// tags archive.
		echo '<li class="breadcrumb-item">' . esc_html__( 'Posts tagged', 'hello-academy' ) . ' "' . single_tag_title( '', false ) . '"</li>';
	} elseif ( is_author() ) {
		// author archive.
		global $author;
		$userdata = get_userdata( $author );
		echo '<li class="breadcrumb-item">' . esc_html__( 'Articles posted by', 'hello-academy' ) . ' ' . $userdata->display_name . '</li>';
	} elseif ( is_404() ) {
		// 404.
		echo '<li class="breadcrumb-item">' . esc_html__( 'Not Found', 'hello-academy' ) . '</li>';
	}

	if ( get_query_var( 'paged' ) ) {
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
			echo '<li class="paged-page breadcrumb-item">(';
		}
		echo esc_html__( 'Page', 'hello-academy' ) . ' ' . get_query_var( 'paged' );
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
			echo ')</li>';
		}
	}
}


function get_post_thumbnail_url( $id ) {
	$url = get_the_post_thumbnail_url( $id );
	if ( ! empty( $url ) ) {
		return 'style="background-image:linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.7) 100%),url(' . $url . ')"';
	}
	return false;
}

function get_customizer_settings( $key, $default = null ) {
	$customizer_settings = get_option( 'hello_academy_customizer_settings' );
	if ( isset( $customizer_settings[ $key ] ) ) {
		return $customizer_settings[ $key ];
	}
	return $default;
}

function entry_content_wrap_classname( $classes, $sidebar_position ) {
	if ( 'sidebar-left' === $sidebar_position || 'sidebar-right' === $sidebar_position ) {
		return 'academy-col-lg-9';
	}
	return $classes;
}

function admin_notice_missing_academy_starter_template_plugin() {
	if ( class_exists( 'AcademyStarter' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	$starter_templates = 'academy-starter-templates/academy-starter-templates.php';
	if ( Helper::is_plugin_installed( $starter_templates ) ) {
		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $starter_templates . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $starter_templates );

		$message = __( 'To take full advantages of Hello Academy theme and enabling demo importer, Please activate Core Plugin to continue.', 'hello-academy' );

		$button_text = __( 'Activate Academy Starter Templates', 'hello-academy' );
	} else {
		$activation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=academy-starter-templates' ), 'install-plugin_academy-starter-templates' );

		$message = __( 'To take full advantages of Hello Academy theme and enabling demo importer, Please install Core Plugin to continue.', 'hello-academy' );
		$button_text = __( 'Install Academy Starter Templates', 'hello-academy' );
	}

	$button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';

	printf( '<div class="notice notice-warning"><h2>Thanks for choosing Hello Academy</h2><p>%1$s</p>%2$s</div>', wp_kses_post( $message ), wp_kses_post( $button ) );
}

function post_class( $classes ) {
	$blog_archive_layout = \HelloAcademy\get_customizer_settings( 'blog_archive_layout', 'list' );
	if ( is_single() ) {
		$classes[] = 'grid' === $blog_archive_layout ? 'hello-academy-blog-single-grid' : 'hello-academy-blog-single-list';
	} else {
		$classes[] = 'grid' === $blog_archive_layout ? 'hello-academy-blog-item-grid' : 'hello-academy-blog-item-list';
	}
	return $classes;
}

/**
 * Table of content
 */
function toc_content( $content, $htgs ) {

	if ( preg_match_all( '/(<h([' . $htgs . ']{1})[^>]*>).*<\/h\2>/msuU', $content, $matches, PREG_SET_ORDER ) ) {
		$index = 0;
		$content = preg_replace_callback( '#<(h[' . $htgs . '])(.*?)>(.*?)</\1>#si', function ( $matches ) use ( &$index ) {
			$tag = $matches[1];
			// $title = strip_tags($matches[3]);
			preg_match( '/id=(["\'])(.*?)\1[\s>]/si', $matches[0], $matched_ids );
			$id = ! empty( $matched_ids[2] ) ? $matched_ids[2] : $index . '-toc-title';
			$index++;

			$title_link_ctc = 0;
			if ( $title_link_ctc == 1 ) {
				$hash_link = '<a href="#' . $id . '" class="hello-academy-anchor" data-clipboard-text="' . get_permalink() . '#' . $id . '" data-title="' . esc_html__( 'Copy URL', 'hello-academy' ) . '">#</a>';
			} else {
				$hash_link = '';
			}
			return sprintf( '<%s%s class="hello-academy-content-heading" id="%s">%s %s</%s>', $tag, $matches[2], $id, $matches[3], $hash_link, $tag );
		}, $content );
	}

	return $content;
}

/**
 * Table of content headings
 */
function toc_heading_list( $post_content, $toc_hierarchy, $htag_support ) {

	preg_match_all( '/(<h([' . $htag_support . ']{1})[^>]*>).*<\/h\2>/msuU', $post_content, $matches, PREG_SET_ORDER );

	$html = '';

	if ( $matches ) {
		$html .= '
	<div class="hello-academy-toc-link-inner">
		<div class="hello-academy-toc-title-wrap">
			<h5>' . esc_html__( 'Table Of Content', 'hello-academy' ) . '</h5>
			<div class="hello-academy-toc-icons sticky-icons">
				<i class="fa fa-times" aria-hidden="true"></i>
				<i class="fa fa-bars" aria-hidden="true"></i>
			</div>
			<div class="hello-academy-toc-icons inline-icons">
				<i class="fa fa-angle-up" aria-hidden="true"></i>
				<i class="fa fa-angle-down" aria-hidden="true"></i>
			</div>
		</div>';
		$tag_arr = explode( ',', $htag_support );
		$last_tag_support = end( $tag_arr );
		$first_match = $matches[0][2];
		$current_match = $first_match;
		$numbered_items = array();
		$depth_match = array(
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0,
		);
		$numbered_items_min = null;
		$level_depth = 1;
		$depth_match[ $first_match ] = $level_depth;
		$max_match = 1;
		$max_depth = 1;
		if ( $toc_hierarchy == '1' ) {
			$html .= '<ul class="toc-list hello-academy-hierarchial-toc">';

			foreach ( $matches as $i => $match ) {
				if ( $current_match < $first_match ) {
					$current_match = $first_match;
				} elseif ( $current_match > $matches[ $i ][2] ) {
					$current_match = (int) $matches[ $i ][2];
				}
				if ( $matches[ $i ][2] > $max_match ) {
					$max_match = $matches[ $i ][2];
				}
			}

			$numbered_items[ $current_match ] = 0;
			$numbered_items_min = $current_match;
			foreach ( $matches as $i => $match ) {
				$level = $matches[ $i ][2];

				if ( $depth_match[ (int) $matches[ $i ][2] ] != 0 ) {
					$depth_match[ (int) $matches[ $i ][2] ] = $level_depth;
				}

				$depth_status = ( $last_tag_support == $level ) ? 'stop' : 'continue';

				if ( $current_match == (int) $matches[ $i ][2] ) {
					$html .= '<li class="hello-academy-toc-heading-level-' . $current_match . '">';
				}

				// start lists
				if ( $current_match != (int) $matches[ $i ][2] ) {
					$diff = $current_match - (int) $matches[ $i ][2];
					for ( $current_match; $current_match < (int) $matches[ $i ][2]; $current_match = $current_match - $diff ) {
						if ( $depth_status == 'continue' ) {
							$level_depth++;
						}
						$depth_match[ (int) $matches[ $i ][2] ] = $level_depth;
						if ( ( $matches[ $i ][2] == $max_match ) ) {
							$max_depth = $level_depth;
						}
						$numbered_items[ $current_match + 1 ] = 0;
						$html .= '<ul class="hello-academy-toc-list-level-' . $level . '"><li class="hello-academy-toc-heading-level-' . $level . '">';
					}
				}

				$title = isset( $matches[ $i ]['alternate'] ) ? $matches[ $i ]['alternate'] : $matches[ $i ][0];
				$title = strip_tags( $title );
				$has_id = preg_match( '/id=(["\'])(.*?)\1[\s>]/si', $matches[ $i ][0], $matched_ids );
				$id = $has_id ? $matched_ids[2] : $i . '-toc-title';

				$html .= '<a href="#' . $id . '">' . $title . '</a>';

				// end lists
				if ( $i != count( $matches ) - 1 ) {
					$next_match = (int) $matches[ $i + 1 ][2];
					$diff = $current_match - $next_match;
					$level_depth_diff = $level_depth - $depth_match[ $next_match ];

					if ( $current_match > $next_match && $level_depth == 1 ) {
						for ( $current_match; $current_match > $next_match; $current_match-- ) {
							$html .= '</li>';
							$numbered_items[ $current_match ] = 0;
							$level_depth--;
						}
					} elseif ( $current_match > $next_match && $diff > 1 && $level_depth > $level_depth_diff ) {
						for ( $current_match; $current_match > $next_match; $current_match = $current_match - $diff ) {
							for ( $k = 1; $k <= $level_depth_diff; $k++ ) {
								$html .= '</li></ul>';
								$numbered_items[ $current_match ] = 0;
							}
							$level_depth = $level_depth - $level_depth_diff;
						}
					} elseif ( $current_match > $next_match && $diff > $max_depth ) {
						for ( $current_match; $current_match > $next_match; $current_match = $current_match - $max_depth ) {
							$html .= '</li></ul>';
							$numbered_items[ $current_match ] = 0;
							$level_depth--;
						}
					} elseif ( $current_match > $next_match ) {
						for ( $current_match; $current_match > $next_match; $current_match-- ) {
							$html .= '</li></ul>';
							$numbered_items[ $current_match ] = 0;
							$level_depth--;
						}
					}

					if ( $level_depth < 1 ) {
						$level_depth = 1;
					}

					if ( $current_match == $next_match ) {
						$html .= '</li>';
					}
				} else {
					// this is the last item, make sure we close off all tags
					for ( $current_match; $current_match >= $numbered_items_min; $current_match-- ) {
						$html .= '</li>';
						if ( $current_match != $numbered_items_min ) {
							$html .= '</ul>';
						}
					}
				}
			}

			$html .= '</ul>';
		} else {
			$html .= '<ul class="toc-list">';

			foreach ( $matches as $i => $match ) {
				$count = $i + 1;
				$title = isset( $matches[ $i ]['alternate'] ) ? $matches[ $i ]['alternate'] : $matches[ $i ][0];
				$title = strip_tags( apply_filters( 'ez_toc_title', $title ), apply_filters( 'ez_toc_title_allowable_tags', '' ) );
				$html .= '<li>';
				$title = isset( $matches[ $i ]['alternate'] ) ? $matches[ $i ]['alternate'] : $matches[ $i ][0];
				$title = strip_tags( $title );
				$has_id = preg_match( '/id=(["\'])(.*?)\1[\s>]/si', $matches[ $i ][0], $matched_ids );
				$id = $has_id ? $matched_ids[2] : $i . '-toc-title';
				$html .= '<a href="#' . $id . '">' . $title . '</a>';
				$html .= '</li>';
			}

			$html .= '</ul>';
		}
		$html .= '</div>';
	}
	return $html;
}
