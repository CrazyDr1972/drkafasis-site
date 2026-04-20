<?php
/**
 * Enqueue parent and child theme styles.
 */
function betheme_child_enqueue_styles() {
	wp_enqueue_style(
		'betheme-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'betheme' )->get( 'Version' )
	);

	wp_enqueue_style(
		'betheme-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'betheme-parent-style' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'betheme_child_enqueue_styles' );

/**
 * Disable the block editor for posts.
 */
function betheme_child_disable_post_block_editor( $use_block_editor, $post ) {
	return false;
}
add_filter( 'use_block_editor_for_post', 'betheme_child_disable_post_block_editor', 10, 2 );

/**
 * Disable the widgets block editor.
 */
function betheme_child_disable_widgets_block_editor( $use_widgets_block_editor ) {
	return false;
}
add_filter( 'use_widgets_block_editor', 'betheme_child_disable_widgets_block_editor' );

/**
 * Remove dashicons on the frontend for unauthenticated users.
 */
function betheme_child_deregister_dashicons_for_guests() {
	if ( ! is_user_logged_in() ) {
		wp_deregister_style( 'dashicons' );
	}
}
add_action( 'wp_enqueue_scripts', 'betheme_child_deregister_dashicons_for_guests', 100 );

/**
 * Output migrated custom head additions from the parent theme.
 */
function betheme_child_output_custom_head_additions() {
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url( 'https://www.drkafasis.gr/wp-content/uploads/2022/04/apple-touch-icon.png' ) . '">' . "\n";
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url( 'https://www.drkafasis.gr/wp-content/uploads/2022/04/favicon-32x32-1.png' ) . '">' . "\n";
	echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url( 'https://www.drkafasis.gr/wp-content/uploads/2022/04/favicon-16x16-1.png' ) . '">' . "\n";
	echo '<link rel="manifest" href="' . esc_url( '/site.webmanifest' ) . '">' . "\n";
	echo '<link rel="mask-icon" href="' . esc_url( 'https://www.drkafasis.gr/wp-content/uploads/2022/04/safari-pinned-tab.svg' ) . '" color="' . esc_attr( '#5bbad5' ) . '">' . "\n";
	echo '<meta name="msapplication-TileColor" content="' . esc_attr( '#da532c' ) . '">' . "\n";
	echo '<meta name="theme-color" content="' . esc_attr( '#ffffff' ) . '">' . "\n";
	echo '<link rel="preconnect" href="' . esc_url( 'https://maps.gstatic.com/' ) . '">' . "\n";
	echo '<link rel="preconnect" href="' . esc_url( 'https://maps.googleapis.com' ) . '">' . "\n";
}
add_action( 'wp_head', 'betheme_child_output_custom_head_additions' );

/**
 * Replace the parent post signature filter with the child theme version.
 */
function betheme_child_replace_parent_post_signature_filter() {
	remove_filter( 'the_content', 'wpb_after_post_content', 10 );
	remove_filter( 'the_content', 'betheme_child_append_post_signature', 10 );
	add_filter( 'the_content', 'betheme_child_append_post_signature', 10 );
}
add_action( 'wp', 'betheme_child_replace_parent_post_signature_filter', 1 );

/**
 * Append the existing signature block after single post content.
 */
function betheme_child_append_post_signature( $content ) {
	if ( is_single() ) {
		$content .= '<div id="blog-post-footer">
    <p class="big"><i>Με εκτίμηση</i></p>

<h3>Θεόδωρος Καφάσης</h3>

<p class="big">Γενικός Οικογενειακός Iατρός</p>
<p class="big">Κουσίδη 31 - Ζωγράφου, Τ.Κ. 15772</p>
<p class="big">Τηλ: <a href="tel:2107793711" role="link">2107793711</a> - www.drkafasis.gr</p></div>';
	}

	return $content;
}

/**
 * Determine whether the current view is a blog posts archive context.
 *
 * @return bool
 */
function betheme_child_is_blog_archive_context() {
	return is_home() || is_category() || is_tag() || is_author() || is_page( 'blog' );
}

/**
 * Render the blog-only search box markup for archive-like blog views.
 *
 * @return string
 */
function betheme_child_get_blog_archive_search_markup() {
	if ( ! betheme_child_is_blog_archive_context() ) {
		return '';
	}

	$markup  = '<div class="betheme-child-blog-search">';
	$markup .= '<h3 class="betheme-child-blog-search__title">' . esc_html__( 'Αναζήτηση άρθρων', 'betheme-child' ) . '</h3>';
	$markup .= get_search_form( false );
	$markup .= '</div>';

	return $markup;
}

/**
 * Build the post-date meta HTML, including a visible update date when present.
 *
 * @return string
 */
function betheme_child_get_post_date_meta_html() {
	$published_timestamp = get_post_time( 'U' );
	$modified_timestamp  = get_post_modified_time( 'U' );
	$published_date      = get_the_date();
	$modified_date       = get_the_modified_date();

	$date_html  = '<span class="post-date published updated">' . esc_html( $published_date ) . '</span>';

	if ( $modified_timestamp && $modified_timestamp > $published_timestamp && $modified_date !== $published_date ) {
		$date_html .= '<span class="post-date-separator"> | </span>';
		$date_html .= '<span class="post-date modified">' . esc_html__( 'Ενημερώθηκε:', 'betheme-child' ) . ' ' . esc_html( $modified_date ) . '</span>';
	}

	return $date_html;
}

/**
 * Child copy of the BeTheme blog-post renderer with updated-date support.
 *
 * @param WP_Query|false $query Query object or false for global query.
 * @param string|false   $style Blog style.
 * @param array|false    $attr  Render attributes.
 * @return string
 */
function betheme_child_render_content_post( $query = false, $style = false, $attr = false ) {
	global $wp_query;
	$output = '';

	$translate['published']  = mfn_opts_get( 'translate' ) ? mfn_opts_get( 'translate-published', 'Published by' ) : __( 'Published by', 'betheme' );
	$translate['at']         = mfn_opts_get( 'translate' ) ? mfn_opts_get( 'translate-at', 'at' ) : __( 'at', 'betheme' );
	$translate['categories'] = mfn_opts_get( 'translate' ) ? mfn_opts_get( 'translate-categories', 'Categories' ) : __( 'Categories', 'betheme' );
	$translate['like']       = mfn_opts_get( 'translate' ) ? mfn_opts_get( 'translate-like', 'Do you like it?' ) : __( 'Do you like it?', 'betheme' );
	$translate['readmore']   = mfn_opts_get( 'translate' ) ? mfn_opts_get( 'translate-readmore', 'Read more' ) : __( 'Read more', 'betheme' );

	extract(
		shortcode_atts(
			array(
				'echo'           => false,
				'excerpt'        => true,
				'featured_image' => false,
				'filters'        => false,
				'title_tag'      => false,
			),
			$attr
		)
	);

	if ( ! $query ) {
		$query = $wp_query;
	}

	if ( ! $style ) {
		if ( $_GET && key_exists( 'mfn-b', $_GET ) ) {
			$style = esc_html( $_GET['mfn-b'] );
		} else {
			$style = mfn_opts_get( 'blog-layout', 'classic' );
		}
	}

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			$post_class = array( 'post-item', 'isotope-item', 'clearfix' );

			if ( ! mfn_post_thumbnail( get_the_ID() ) || post_password_required() ) {
				$post_class[] = 'no-img';
			}

			if ( in_array( $filters, array( 1, 'only-authors' ), true ) ) {
				$post_class[] = 'author-' . mfn_slug( get_the_author_meta( 'user_login' ) );
			}

			$post_class = implode( ' ', get_post_class( $post_class ) );

			$bg_color = get_post_meta( get_the_ID(), 'mfn-post-bg', true );
			if ( $bg_color && 'masonry tiles' === $style ) {
				$bg_color = 'background-color:' . $bg_color . ';';
			} else {
				$bg_color = false;
			}

			$output .= '<div class="' . esc_attr( $post_class ) . '" style="' . esc_attr( $bg_color ) . '">';

			if ( 'masonry tiles' === $style ) {
				if ( 'video' === get_post_format() ) {
					$output .= '<i class="post-format-icon icon-play"></i>';
				} elseif ( 'quote' === get_post_format() ) {
					$output .= '<i class="post-format-icon icon-quote"></i>';
				} elseif ( 'link' === get_post_format() ) {
					$output .= '<i class="post-format-icon icon-link"></i>';
				} elseif ( 'audio' === get_post_format() ) {
					$output .= '<i class="post-format-icon icon-music-line"></i>';
				} else {
					$rev_slider = get_post_meta( get_the_ID(), 'mfn-post-slider', true );
					$lay_slider = get_post_meta( get_the_ID(), 'mfn-post-slider-layer', true );

					if ( $rev_slider || $lay_slider ) {
						$output .= '<i class="post-format-icon icon-code"></i>';
					}
				}
			}

			$output .= '<div class="date_label">' . esc_html( get_the_date() ) . '</div>';

			if ( ! post_password_required() ) {
				if ( 'masonry tiles' === $style ) {
					$output .= '<div class="post-photo-wrapper scale-with-grid"><div class="image_wrapper_tiles">';
					$output .= get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'scale-with-grid', 'itemprop' => 'image' ) );
					$output .= '</div></div>';
				} else {
					$post_format = mfn_post_thumbnail_type( get_the_ID() );

					if ( 'photo2' === $style ) {
						$featured_image = 'image';
						$output        .= '<div class="button-love">' . mfn_love() . '</div>';
					}

					if ( 'image' === $featured_image ) {
						$post_format = 'images_only';
					}

					$output .= '<div class="image_frame post-photo-wrapper scale-with-grid ' . esc_attr( $post_format ) . '"><div class="image_wrapper">';
					$output .= mfn_post_thumbnail( get_the_ID(), 'blog', $style, $featured_image );
					$output .= '</div></div>';
				}
			}

			$bg_color      = get_post_meta( get_the_ID(), 'mfn-post-bg', true );
			$item_bg_class = 'bg-' . mfn_brightness( $bg_color );

			if ( 'photo2' === $style && $bg_color ) {
				$bg_color = 'background-color:' . $bg_color . ';';
			} else {
				$bg_color = false;
			}

			$output .= '<div class="post-desc-wrapper ' . $item_bg_class . '" style="' . esc_attr( $bg_color ) . '"><div class="post-desc">';
			$output .= '<div class="post-head">';

			$show_meta = false;
			$list_meta = mfn_opts_get( 'blog-meta' );

			if ( is_array( $list_meta ) ) {
				if ( isset( $list_meta['author'] ) || isset( $list_meta['date'] ) || isset( $list_meta['categories'] ) ) {
					$show_meta = true;
				}
			}

			if ( $show_meta ) {
				$output .= '<div class="post-meta clearfix"><div class="author-date">';

				if ( isset( $list_meta['author'] ) ) {
					$output .= '<span class="vcard author post-author">';
					$output .= '<span class="label">' . esc_html( $translate['published'] ) . ' </span>';
					$output .= '<i class="icon-user"></i> ';
					$output .= '<span class="fn"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a></span>';
					$output .= '</span> ';
				}

				if ( isset( $list_meta['date'] ) ) {
					$output .= '<span class="date">';
					if ( isset( $list_meta['author'] ) ) {
						$output .= '<span class="label">' . esc_html( $translate['at'] ) . ' </span>';
					}
					$output .= '<i class="icon-clock"></i> ';
					$output .= betheme_child_get_post_date_meta_html();
					$output .= '</span>';
				}

				if ( 'masonry tiles' === $style && comments_open() && mfn_opts_get( 'blog-comments' ) ) {
					$output .= '<div class="post-links"><i class="icon-comment-empty-fa"></i> <a href="' . esc_url( get_comments_link() ) . '" class="post-comments">' . esc_html( get_comments_number() ) . '</a></div>';
				}

				$output .= '</div>';

				if ( isset( $list_meta['categories'] ) ) {
					$output .= '<div class="category"><span class="cat-btn">' . esc_html( $translate['categories'] ) . ' <i class="icon-down-dir"></i></span><div class="cat-wrapper">' . get_the_category_list() . '</div></div>';
				}

				$output .= '</div>';
			}

			if ( 'photo' === $style ) {
				$output .= '<div class="post-footer">';
				$output .= '<div class="button-love"><span class="love-text">' . $translate['like'] . '</span>' . mfn_love() . '</div>';
				$output .= '<div class="post-links">';
				if ( comments_open() && mfn_opts_get( 'blog-comments' ) ) {
					$output .= '<i class="icon-comment-empty-fa"></i> <a href="' . esc_url( get_comments_link() ) . '" class="post-comments">' . esc_html( get_comments_number() ) . '</a>';
				}
				$output .= '<i class="icon-doc-text"></i> <a href="' . esc_url( get_permalink() ) . '" class="post-more">' . esc_html( $translate['readmore'] ) . '</a>';
				$output .= '</div></div>';
			}

			$output .= '</div>';
			$output .= '<div class="post-title">';

			if ( 'quote' === get_post_format() ) {
				$output .= '<blockquote><a href="' . esc_url( get_permalink() ) . '">' . wp_kses( get_the_title(), mfn_allowed_html() ) . '</a></blockquote>';
			} elseif ( 'link' === get_post_format() ) {
				$link    = get_post_meta( get_the_ID(), 'mfn-post-link', true );
				$output .= '<i class="icon-link"></i><div class="link-wrapper"><h4>' . wp_kses( get_the_title(), mfn_allowed_html() ) . '</h4><a target="_blank" href="' . esc_url( $link ) . '">' . esc_html( $link ) . '</a></div>';
			} else {
				if ( ! $title_tag ) {
					$title_tag = mfn_opts_get( 'blog-title-tag', 2 );
				}
				$output .= '<h' . esc_attr( $title_tag ) . ' class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '">' . wp_kses( get_the_title(), mfn_allowed_html() ) . '</a></h' . esc_attr( $title_tag ) . '>';
			}

			$output .= '</div>';

			if ( $excerpt ) {
				$output .= '<div class="post-excerpt">' . get_the_excerpt() . '</div>';
			}

			if ( ! in_array( $style, array( 'photo', 'photo2', 'masonry tiles' ), true ) ) {
				$output .= '<div class="post-footer">';
				$output .= '<div class="button-love"><span class="love-text">' . esc_html( $translate['like'] ) . '</span>' . mfn_love() . '</div>';
				$output .= '<div class="post-links">';
				if ( comments_open() && mfn_opts_get( 'blog-comments' ) ) {
					$output .= '<i class="icon-comment-empty-fa"></i> <a href="' . esc_url( get_comments_link() ) . '" class="post-comments">' . esc_html( get_comments_number() ) . '</a>';
				}
				$output .= '<i class="icon-doc-text"></i> <a href="' . esc_url( get_permalink() ) . '" class="post-more">' . esc_html( $translate['readmore'] ) . '</a>';
				$output .= '</div></div>';
			}

			if ( 'photo2' === $style ) {
				if ( isset( $list_meta['author'] ) || isset( $list_meta['date'] ) ) {
					$output .= '<div class="post-footer">';

					if ( isset( $list_meta['author'] ) ) {
						global $user;
						$output .= '<span class="vcard author post-author">';
						$output .= get_avatar( get_the_author_meta( 'email' ), '24', false, get_the_author_meta( 'display_name', $user['ID'] ) );
						$output .= '<span class="fn"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a></span>';
						$output .= '</span> ';
					}

					if ( isset( $list_meta['date'] ) ) {
						$output .= '<span class="date"><i class="icon-clock"></i> ' . betheme_child_get_post_date_meta_html() . '</span>';
					}

					$output .= '</div>';
				}
			}

			$output .= '</div></div></div>';

			if ( $echo ) {
				echo $output;
				$output = '';
			}
		}
	}

	return $output;
}

/**
 * Override the BeTheme blog builder item so the blog page can render
 * the child-theme search box inside the builder-driven posts list flow.
 *
 * @param array       $attr    Shortcode attributes.
 * @param string|null $content Shortcode content.
 * @return string
 */
function sc_blog( $attr, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'count'          => 2,
				'style'          => 'classic',
				'columns'        => 3,
				'title_tag'      => 'h2',
				'images'         => '',
				'category'       => '',
				'category_multi' => '',
				'orderby'        => 'date',
				'order'          => 'DESC',
				'exclude_id'     => '',
				'filters'        => '',
				'excerpt'        => true,
				'more'           => '',
				'pagination'     => '',
				'load_more'      => '',
				'greyscale'      => '',
				'margin'         => '',
				'events'         => '',
			),
			$attr
		)
	);

	$translate['filter']     = mfn_opts_get( 'translate' ) ? mfn_opts_get( 'translate-filter', 'Filter by' ) : __( 'Filter by', 'betheme' );
	$translate['tags']       = mfn_opts_get( 'translate' ) ? mfn_opts_get( 'translate-tags', 'Tags' ) : __( 'Tags', 'betheme' );
	$translate['authors']    = mfn_opts_get( 'translate' ) ? mfn_opts_get( 'translate-authors', 'Authors' ) : __( 'Authors', 'betheme' );
	$translate['all']        = mfn_opts_get( 'translate' ) ? mfn_opts_get( 'translate-item-all', 'All' ) : __( 'All', 'betheme' );
	$translate['categories'] = mfn_opts_get( 'translate' ) ? mfn_opts_get( 'translate-categories', 'Categories' ) : __( 'Categories', 'betheme' );

	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
	$args  = array(
		'posts_per_page'      => intval( $count, 10 ),
		'paged'               => $paged,
		'orderby'             => $orderby,
		'order'               => $order,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => false,
	);

	if ( is_user_logged_in() ) {
		$args['post_status'] = array( 'publish', 'private' );
	}

	if ( $events ) {
		$args['post_type'] = array( 'post', 'tribe_events' );
	}

	if ( $category_multi ) {
		$args['category_name'] = trim( $category_multi );
	} elseif ( $category ) {
		$args['category_name'] = $category;
	}

	if ( $exclude_id ) {
		$exclude_id            = str_replace( ' ', '', $exclude_id );
		$args['post__not_in'] = explode( ',', $exclude_id );
	}

	$query_blog = new WP_Query( $args );

	$classes = $style;

	if ( $greyscale ) {
		$classes .= ' greyscale';
	}
	if ( $margin ) {
		$classes .= ' margin';
	}
	if ( ! $more ) {
		$classes .= ' hide-more';
	}

	if ( $filters || in_array( $style, array( 'masonry', 'masonry tiles' ), true ) ) {
		$classes .= ' isotope';
	}

	$title_tag = intval( str_replace( 'h', '', trim( $title_tag ) ), 10 );

	$output = '<div class="column_filters">';

	if ( $filters && ( ! $category ) && ( ! $category_multi ) ) {

		$filters_class = '';
		if ( 1 != $filters ) {
			$filters_class .= ' only ' . $filters;
		}

		$output .= '<div id="Filters" class="isotope-filters ' . esc_attr( $filters_class ) . '" data-parent="column_filters">';
		$output .= '<ul class="filters_buttons">';
		$output .= '<li class="label">' . esc_html( $translate['filter'] ) . '</li>';
		$output .= '<li class="categories"><a class="open" href="#"><i class="icon-docs"></i>' . esc_html( $translate['categories'] ) . '<i class="icon-down-dir"></i></a></li>';
		$output .= '<li class="tags"><a class="open" href="#"><i class="icon-tag"></i>' . esc_html( $translate['tags'] ) . '<i class="icon-down-dir"></i></a></li>';
		$output .= '<li class="authors"><a class="open" href="#"><i class="icon-user"></i>' . esc_html( $translate['authors'] ) . '<i class="icon-down-dir"></i></a></li>';
		$output .= '</ul>';
		$output .= '<div class="filters_wrapper">';

		$output .= '<ul class="categories">';
		$output .= '<li class="reset current-cat"><a class="all" data-rel="*" href="#">' . esc_html( $translate['all'] ) . '</a></li>';
		if ( $categories = get_categories() ) {
			foreach ( $categories as $current_category ) {
				$output .= '<li class="' . esc_attr( $current_category->slug ) . '"><a data-rel=".category-' . esc_attr( $current_category->slug ) . '" href="' . esc_url( get_term_link( $current_category ) ) . '">' . esc_html( $current_category->name ) . '</a></li>';
			}
		}
		$output .= '<li class="close"><a href="#"><i class="icon-cancel"></i></a></li>';
		$output .= '</ul>';

		$output .= '<ul class="tags">';
		$output .= '<li class="reset current-cat"><a class="all" data-rel="*" href="#">' . esc_html( $translate['all'] ) . '</a></li>';
		if ( $tags = get_tags() ) {
			foreach ( $tags as $tag ) {
				$output .= '<li class="' . esc_attr( $tag->slug ) . '"><a data-rel=".tag-' . esc_attr( $tag->slug ) . '" href="' . esc_url( get_tag_link( $tag ) ) . '">' . esc_html( $tag->name ) . '</a></li>';
			}
		}
		$output .= '<li class="close"><a href="#"><i class="icon-cancel"></i></a></li>';
		$output .= '</ul>';

		$output .= '<ul class="authors">';
		$output .= '<li class="reset current-cat"><a class="all" data-rel="*" href="#">' . esc_html( $translate['all'] ) . '</a></li>';
		$authors = mfn_get_authors();
		if ( is_array( $authors ) ) {
			foreach ( $authors as $auth ) {
				$output .= '<li class="' . esc_attr( mfn_slug( $auth->data->user_login ) ) . '"><a data-rel=".author-' . esc_attr( mfn_slug( $auth->data->user_login ) ) . '" href="' . esc_url( get_author_posts_url( $auth->ID ) ) . '">' . esc_html( $auth->data->display_name ) . '</a></li>';
			}
		}
		$output .= '<li class="close"><a href="#"><i class="icon-cancel"></i></a></li>';
		$output .= '</ul>';

		$output .= '</div>';
		$output .= '</div>' . "\n";
	}

	$output .= betheme_child_get_blog_archive_search_markup();
	$output .= '<div class="blog_wrapper isotope_wrapper clearfix">';
	$output .= '<div class="posts_group lm_wrapper col-' . esc_attr( $columns ) . ' ' . esc_attr( $classes ) . '">';

	$post_attr = array(
		'excerpt'        => $excerpt,
		'featured_image' => false,
		'filters'        => $filters,
		'title_tag'      => $title_tag,
	);

	if ( $load_more ) {
		$post_attr['featured_image'] = 'no_slider';
	}
	if ( $images ) {
		$post_attr['featured_image'] = 'image';
	}

	$output .= betheme_child_render_content_post( $query_blog, $style, $post_attr );
	$output .= '</div>';

	if ( $pagination || $load_more ) {
		$output .= mfn_pagination( $query_blog, $load_more );
	}

	$output .= '</div>' . "\n";
	$output .= '</div>' . "\n";

	wp_reset_postdata();

	return $output;
}

/**
 * Add blog-search-specific hidden fields to the built-in WordPress search form.
 *
 * @param string $form The search form markup.
 * @return string
 */
function betheme_child_filter_blog_search_form( $form ) {
	if ( ! betheme_child_is_blog_archive_context() ) {
		return $form;
	}

	$hidden_fields  = '<input type="hidden" name="post_type" value="post">';
	$hidden_fields .= '<input type="hidden" name="betheme_child_blog_search" value="1">';

	return str_replace( '</form>', $hidden_fields . '</form>', $form );
}
add_filter( 'get_search_form', 'betheme_child_filter_blog_search_form' );

/**
 * Restrict blog search requests from the child-theme form to posts only.
 *
 * @param WP_Query $query The query being prepared.
 * @return void
 */
function betheme_child_limit_blog_search_to_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}

	if ( '1' !== $query->get( 'betheme_child_blog_search' ) ) {
		return;
	}

	$query->set( 'post_type', 'post' );
}
add_action( 'pre_get_posts', 'betheme_child_limit_blog_search_to_posts', 20 );
