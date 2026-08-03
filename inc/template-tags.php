<?php
/**
 * Template helper functions.
 *
 * @package Eggxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * In-request registry of post IDs already shown (hero, featured, etc.).
 *
 * @var int[]
 */
global $eggxi_displayed_post_ids;
$eggxi_displayed_post_ids = array();

/**
 * Remember a post ID as already displayed on the current page.
 *
 * @param int $post_id Post ID.
 */
function eggxi_remember_displayed_post( $post_id ) {
	global $eggxi_displayed_post_ids;
	$post_id = absint( $post_id );
	if ( ! $post_id ) {
		return;
	}
	if ( ! is_array( $eggxi_displayed_post_ids ) ) {
		$eggxi_displayed_post_ids = array();
	}
	$eggxi_displayed_post_ids[] = $post_id;
	$eggxi_displayed_post_ids   = array_values( array_unique( $eggxi_displayed_post_ids ) );
}

/**
 * Get all post IDs already displayed this request.
 *
 * @return int[]
 */
function eggxi_get_displayed_post_ids() {
	global $eggxi_displayed_post_ids;
	return is_array( $eggxi_displayed_post_ids ) ? $eggxi_displayed_post_ids : array();
}

/**
 * Social network definitions for Customizer + output.
 *
 * @return array<string, array{label:string,icon:string,class:string}>
 */
function eggxi_get_social_networks() {
	return array(
		'facebook'  => array(
			'label' => __( 'Facebook URL', 'eggxi' ),
			'icon'  => 'fab fa-facebook-f',
			'class' => 'color-fb',
		),
		'linkedin'  => array(
			'label' => __( 'LinkedIn URL', 'eggxi' ),
			'icon'  => 'fab fa-linkedin-in',
			'class' => 'color-lnkdn',
		),
		'twitter'   => array(
			'label' => __( 'Twitter / X URL', 'eggxi' ),
			'icon'  => 'fab fa-twitter',
			'class' => 'color-twtr',
		),
		'pinterest' => array(
			'label' => __( 'Pinterest URL', 'eggxi' ),
			'icon'  => 'fab fa-pinterest',
			'class' => 'color-pint',
		),
		'instagram' => array(
			'label' => __( 'Instagram URL', 'eggxi' ),
			'icon'  => 'fab fa-instagram',
			'class' => 'color-inst',
		),
		'vk'        => array(
			'label' => __( 'VK URL', 'eggxi' ),
			'icon'  => 'fab fa-vk',
			'class' => 'color-green',
		),
	);
}

/**
 * Header top notice text with fallbacks.
 *
 * Priority: Customizer → ACF field `header_notice` (if present) → blog description.
 *
 * @return string
 */
function eggxi_get_header_notice() {
	$notice = get_theme_mod( 'eggxi_header_notice', '' );

	if ( '' === trim( wp_strip_all_tags( (string) $notice ) ) && function_exists( 'get_field' ) ) {
		$acf = get_field( 'header_notice', 'option' );
		if ( is_string( $acf ) && '' !== trim( wp_strip_all_tags( $acf ) ) ) {
			$notice = $acf;
		}
	}

	if ( '' === trim( wp_strip_all_tags( (string) $notice ) ) ) {
		$notice = get_bloginfo( 'description', 'display' );
	}

	return (string) $notice;
}

/**
 * Print site logo or site title fallback.
 */
function eggxi_the_logo() {
	if ( has_custom_logo() ) {
		$logo_id = get_theme_mod( 'custom_logo' );
		$logo    = wp_get_attachment_image(
			$logo_id,
			'full',
			false,
			array(
				'class' => 'custom-logo img-fluid',
				'alt'   => get_bloginfo( 'name', 'display' ),
			)
		);
		printf(
			'<a href="%1$s" class="ulockd-main-logo custom-logo-link" rel="home">%2$s</a>',
			esc_url( home_url( '/' ) ),
			$logo // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image is safe.
		);
		return;
	}

	printf(
		'<a href="%1$s" class="ulockd-main-logo site-title-link" rel="home"><span class="site-title">%2$s</span></a>',
		esc_url( home_url( '/' ) ),
		esc_html( get_bloginfo( 'name' ) )
	);
}

/**
 * Footer logo (custom logo or theme footer-logo.png) plus optional tagline.
 *
 * @param bool $show_tagline Whether to print blog description under the logo.
 */
function eggxi_the_footer_logo( $show_tagline = true ) {
	echo '<div class="logo-widget tac-xxsd">';

	if ( has_custom_logo() ) {
		$logo_id = get_theme_mod( 'custom_logo' );
		echo wp_get_attachment_image(
			$logo_id,
			'full',
			false,
			array(
				'class' => 'db-smd m0a-smd custom-logo img-fluid',
				'alt'   => get_bloginfo( 'name', 'display' ),
			)
		);
	} else {
		printf(
			'<a href="%1$s" class="site-title-link" rel="home"><img class="db-smd m0a-smd" src="%2$s" alt="%3$s"></a>',
			esc_url( home_url( '/' ) ),
			esc_url( get_template_directory_uri() . '/assets/images/footer-logo.png' ),
			esc_attr( get_bloginfo( 'name', 'display' ) )
		);
	}

	if ( $show_tagline ) {
		$description = get_bloginfo( 'description', 'display' );
		if ( $description ) {
			printf( '<p class="ulockd-mt10 site-description">%s</p>', esc_html( $description ) );
		}
	}

	echo '</div>';
}

/**
 * Print footer social icon list from Customizer / ACF.
 */
function eggxi_the_footer_social_icons() {
	$networks = eggxi_get_social_networks();
	$items    = array();

	foreach ( $networks as $key => $network ) {
		$url = get_theme_mod( 'eggxi_social_' . $key, '' );
		if ( ! $url && function_exists( 'get_field' ) ) {
			$acf = get_field( 'social_' . $key, 'option' );
			if ( is_string( $acf ) && $acf ) {
				$url = $acf;
			}
		}
		if ( $url ) {
			$items[] = array(
				'url'   => $url,
				'icon'  => $network['icon'],
				'label' => $network['label'],
			);
		}
	}

	// Always offer RSS when nothing else is set (matches HTML demo icons).
	if ( empty( $items ) ) {
		$items[] = array(
			'url'   => get_bloginfo( 'rss2_url' ),
			'icon'  => 'fas fa-rss',
			'label' => __( 'RSS', 'eggxi' ),
		);
	}

	echo '<ul class="footer-font-icon">';
	foreach ( $items as $item ) {
		printf(
			'<li class="list-inline-item"><a href="%1$s" target="_blank" rel="noopener noreferrer" aria-label="%2$s"><i class="%3$s"></i></a></li>',
			esc_url( $item['url'] ),
			esc_attr( $item['label'] ),
			esc_attr( $item['icon'] )
		);
	}
	echo '</ul>';
}

/**
 * Header promo banner: widget area wins, else Customizer image/link, else default asset.
 */
function eggxi_the_header_banner() {
	if ( is_active_sidebar( 'header-banner' ) ) {
		dynamic_sidebar( 'header-banner' );
		return;
	}

	$image_id = (int) get_theme_mod( 'eggxi_banner_image', 0 );
	$url      = get_theme_mod( 'eggxi_banner_url', '' );
	$link     = $url ? $url : home_url( '/' );

	if ( $image_id ) {
		$img = wp_get_attachment_image(
			$image_id,
			'full',
			false,
			array(
				'class' => 'img-fluid',
				'alt'   => __( 'Header promo banner', 'eggxi' ),
			)
		);
		printf(
			'<a href="%1$s" class="header_banner">%2$s</a>',
			esc_url( $link ),
			$img // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
		return;
	}

	$fallback = get_template_directory_uri() . '/assets/images/about/hader-banner1.png';
	printf(
		'<a href="%1$s" class="header_banner"><img src="%2$s" alt="%3$s" class="img-fluid"></a>',
		esc_url( $link ),
		esc_url( $fallback ),
		esc_attr__( 'Header promo banner', 'eggxi' )
	);
}

/**
 * Query posts for the hero slider (sticky first, then latest with thumbnails).
 *
 * @param int $count Number of slides.
 * @return WP_Query
 */
function eggxi_get_hero_query( $count = 6 ) {
	$count = max( 1, min( 12, absint( $count ) ) );

	$sticky     = get_option( 'sticky_posts', array() );
	$sticky     = is_array( $sticky ) ? array_map( 'absint', $sticky ) : array();
	$post_ids   = array();
	$found      = 0;

	if ( ! empty( $sticky ) ) {
		$sticky_q = new WP_Query(
			array(
				'post__in'            => $sticky,
				'posts_per_page'      => $count,
				'ignore_sticky_posts' => 1,
				'post_status'         => 'publish',
				'meta_query'          => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'     => '_thumbnail_id',
						'compare' => 'EXISTS',
					),
				),
			)
		);

		if ( $sticky_q->have_posts() ) {
			$post_ids = wp_list_pluck( $sticky_q->posts, 'ID' );
			$found    = count( $post_ids );
		}
		wp_reset_postdata();
	}

	if ( $found < $count ) {
		$latest = new WP_Query(
			array(
				'posts_per_page'      => $count - $found,
				'post__not_in'        => $post_ids,
				'ignore_sticky_posts' => 1,
				'post_status'         => 'publish',
				'meta_query'          => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'     => '_thumbnail_id',
						'compare' => 'EXISTS',
					),
				),
			)
		);

		if ( $latest->have_posts() ) {
			$post_ids = array_merge( $post_ids, wp_list_pluck( $latest->posts, 'ID' ) );
		}
		wp_reset_postdata();
	}

	if ( empty( $post_ids ) ) {
		return new WP_Query(
			array(
				'posts_per_page'      => $count,
				'ignore_sticky_posts' => 1,
				'post_status'         => 'publish',
			)
		);
	}

	return new WP_Query(
		array(
			'post__in'            => $post_ids,
			'posts_per_page'      => $count,
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1,
			'post_status'         => 'publish',
		)
	);
}

/**
 * Primary category label for a post.
 *
 * @param int|null $post_id Post ID.
 * @return string
 */
function eggxi_get_post_category_name( $post_id = null ) {
	$term = eggxi_get_primary_category( $post_id );
	return $term ? $term->name : '';
}

/**
 * Primary category term for a post.
 *
 * @param int|null $post_id Post ID.
 * @return WP_Term|null
 */
function eggxi_get_primary_category( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$cats    = get_the_category( $post_id );

	if ( empty( $cats ) || is_wp_error( $cats ) ) {
		return null;
	}

	return $cats[0];
}

/**
 * Print primary category badge (linked).
 *
 * @param string   $tag_class Extra badge classes (e.g. bgc-thm).
 * @param int|null $post_id   Post ID.
 */
function eggxi_the_category_badge( $tag_class = 'bgc-thm', $post_id = null ) {
	$term = eggxi_get_primary_category( $post_id );
	if ( ! $term ) {
		return;
	}

	printf(
		'<div class="tag %1$s"><a href="%2$s">%3$s</a></div>',
		esc_attr( $tag_class ),
		esc_url( get_category_link( $term->term_id ) ),
		esc_html( $term->name )
	);
}

/**
 * Featured image URL with theme fallback asset.
 *
 * @param string   $size    Image size.
 * @param int|null $post_id Post ID.
 * @return string
 */
function eggxi_get_post_image_url( $size = 'large', $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$url     = get_the_post_thumbnail_url( $post_id, $size );

	if ( ! $url ) {
		$url = get_template_directory_uri() . '/assets/images/blog/fp1.jpg';
	}

	return $url;
}

/**
 * Like / view count from post meta (filterable key).
 *
 * @param int|null $post_id Post ID.
 * @return int
 */
function eggxi_get_like_count( $post_id = null ) {
	$post_id  = $post_id ? $post_id : get_the_ID();
	$meta_key = apply_filters( 'eggxi_like_count_meta_key', 'eggxi_likes' );
	$count    = get_post_meta( $post_id, $meta_key, true );

	if ( '' === $count || false === $count ) {
		// Common alternate keys used by like plugins.
		foreach ( array( '_post_like_count', 'likes', 'post_views_count' ) as $alt ) {
			$alt_val = get_post_meta( $post_id, $alt, true );
			if ( '' !== $alt_val && false !== $alt_val ) {
				$count = $alt_val;
				break;
			}
		}
	}

	return absint( $count );
}

/**
 * Collect up to $limit unique post IDs: sticky → featured tag/cat → latest.
 *
 * @param int   $limit  Max posts.
 * @param int[] $exclude IDs to skip.
 * @return int[]
 */
function eggxi_collect_post_ids( $limit, $exclude = array() ) {
	$limit     = max( 1, absint( $limit ) );
	$exclude   = array_filter( array_map( 'absint', (array) $exclude ) );
	$post_ids  = array();
	$need      = $limit;

	$append = static function ( $ids ) use ( &$post_ids, &$need, $exclude ) {
		foreach ( $ids as $id ) {
			$id = absint( $id );
			if ( ! $id || in_array( $id, $post_ids, true ) || in_array( $id, $exclude, true ) ) {
				continue;
			}
			$post_ids[] = $id;
			$need--;
			if ( $need <= 0 ) {
				break;
			}
		}
	};

	// 1) Sticky posts.
	$sticky = get_option( 'sticky_posts', array() );
	if ( is_array( $sticky ) && ! empty( $sticky ) && $need > 0 ) {
		$q = new WP_Query(
			array(
				'post__in'            => array_map( 'absint', $sticky ),
				'posts_per_page'      => $need,
				'ignore_sticky_posts' => 1,
				'post_status'         => 'publish',
				'fields'              => 'ids',
				'no_found_rows'       => true,
			)
		);
		$append( $q->posts );
		wp_reset_postdata();
	}

	// 2) Featured tag or category (Customizer slug, default "featured").
	$slug = sanitize_title( get_theme_mod( 'eggxi_featured_term_slug', 'featured' ) );
	if ( $slug && $need > 0 ) {
		$tax_query = array( 'relation' => 'OR' );
		if ( term_exists( $slug, 'post_tag' ) ) {
			$tax_query[] = array(
				'taxonomy' => 'post_tag',
				'field'    => 'slug',
				'terms'    => $slug,
			);
		}
		if ( term_exists( $slug, 'category' ) ) {
			$tax_query[] = array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $slug,
			);
		}

		if ( count( $tax_query ) > 1 ) {
			$q = new WP_Query(
				array(
					'posts_per_page'      => $need,
					'post__not_in'        => array_merge( $post_ids, $exclude ),
					'ignore_sticky_posts' => 1,
					'post_status'         => 'publish',
					'fields'              => 'ids',
					'no_found_rows'       => true,
					'tax_query'           => $tax_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				)
			);
			$append( $q->posts );
			wp_reset_postdata();
		}
	}

	// 3) Latest posts fallback.
	if ( $need > 0 ) {
		$q = new WP_Query(
			array(
				'posts_per_page'      => $need,
				'post__not_in'        => array_merge( $post_ids, $exclude ),
				'ignore_sticky_posts' => 1,
				'post_status'         => 'publish',
				'fields'              => 'ids',
				'no_found_rows'       => true,
			)
		);
		$append( $q->posts );
		wp_reset_postdata();
	}

	return $post_ids;
}

/**
 * Print date / comments / likes meta list (shared card footer).
 *
 * @param int|null $post_id Post ID.
 * @param string   $style   `default` or `thm` (text-thm icon class).
 * @param bool     $show_date Whether to show date.
 */
function eggxi_the_post_meta_icons( $post_id = null, $style = 'default', $show_date = true ) {
	$post_id   = $post_id ? $post_id : get_the_ID();
	$likes     = eggxi_get_like_count( $post_id );
	$icon_mod  = ( 'thm' === $style ) ? ' text-thm' : '';
	$span_mod  = ( 'thm' === $style ) ? 'ulockd-pl10' : 'ulockd-pl10 fz14';
	?>
	<ul class="post_meta ulockd-mb0">
		<?php if ( $show_date ) : ?>
			<li class="list-inline-item">
				<span class="flaticon-timetable<?php echo esc_attr( $icon_mod ); ?>"></span>
				<span class="<?php echo esc_attr( $span_mod ); ?>">
					<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $post_id ) ); ?>"><?php echo esc_html( get_the_date( '', $post_id ) ); ?></time>
				</span>
			</li>
		<?php endif; ?>
		<li class="list-inline-item">
			<span class="flaticon-comment-1<?php echo esc_attr( $icon_mod ); ?>"></span>
			<span class="<?php echo esc_attr( $span_mod ); ?>"><?php echo esc_html( number_format_i18n( get_comments_number( $post_id ) ) ); ?></span>
		</li>
		<li class="list-inline-item">
			<span class="flaticon-heart<?php echo esc_attr( $icon_mod ); ?>"></span>
			<span class="<?php echo esc_attr( $span_mod ); ?>"><?php echo esc_html( number_format_i18n( $likes ) ); ?></span>
		</li>
	</ul>
	<?php
}

/**
 * Custom comment list callback matching Eggxi media layout.
 *
 * Leaves `.media-body` open so nested replies render inside it (HTML `media style2`).
 *
 * @param WP_Comment $comment Comment object.
 * @param array      $args    Callback args.
 * @param int        $depth   Depth.
 */
function eggxi_comment_callback( $comment, $args, $depth ) {
	$tag       = ( 'div' === $args['style'] ) ? 'div' : 'li';
	$classes   = ( $depth > 0 ) ? 'media style2 ulockd-mt35' : 'media ulockd-mb40';
	?>
	<<?php echo tag_escape( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $classes, $comment ); ?>>
		<?php
		echo get_avatar(
			$comment,
			$args['avatar_size'],
			'',
			get_comment_author( $comment ),
			array( 'class' => 'me-4 mr-4 rounded-circle' )
		);
		?>
		<div class="media-body">
			<h4 class="mt-0">
				<?php echo esc_html( get_comment_author( $comment ) ); ?>
				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below'  => 'comment',
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
							'before'     => '<div class="bps_reply text-thm float-end float-right">',
							'after'      => '</div>',
							'reply_text' => '<i class="fa fa-mail-forward"></i> ' . esc_html__( 'Reply', 'eggxi' ),
						)
					)
				);
				?>
			</h4>
			<a class="reply_date" href="<?php echo esc_url( get_comment_link( $comment ) ); ?>">
				<time datetime="<?php comment_time( 'c' ); ?>">
					<?php echo esc_html( get_comment_date( 'd F, Y', $comment ) ); ?>
				</time>
			</a>
			<?php if ( '0' === (string) $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'eggxi' ); ?></p>
			<?php endif; ?>
			<div class="ulockd-mt15 ulockd-mb0">
				<?php comment_text(); ?>
			</div>
	<?php
}

/**
 * Close comment media-body + wrapper (after nested children).
 *
 * @param WP_Comment $comment Comment.
 * @param array      $args    Args.
 * @param int        $depth   Depth.
 */
function eggxi_comment_end_callback( $comment, $args, $depth ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	echo '</div></' . tag_escape( $tag ) . '>';
}

/**
 * Render Main/Primary Sidebar inner markup once.
 */
function eggxi_render_main_sidebar_inner() {
	static $html = null;

	if ( null === $html ) {
		ob_start();
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			dynamic_sidebar( 'sidebar-1' );
		} else {
			get_template_part( 'template-parts/sidebar/about' );
			get_template_part( 'template-parts/sidebar/video' );
			get_template_part( 'template-parts/sidebar/categories' );
			get_template_part( 'template-parts/sidebar/follow' );
			get_template_part( 'template-parts/sidebar/tags' );
			get_template_part( 'template-parts/sidebar/photos' );
			if ( ! is_singular( 'post' ) ) {
				get_template_part( 'template-parts/sidebar/newsletter' );
				get_template_part( 'template-parts/sidebar/recent' );
			}
		}
		$html = ob_get_clean();
	}

	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Resolve inner page banner data (title, subtitles, background URL).
 *
 * @return array{title:string,subtitle_top:string,subtitle_bottom:string,bg_url:string}
 */
function eggxi_get_page_header_data() {
	$title           = '';
	$subtitle_top    = '';
	$subtitle_bottom = '';
	$bg_url          = '';
	$object_id       = 0;

	if ( is_singular() ) {
		$object_id = get_queried_object_id();
		$title     = single_post_title( '', false );

		$subtitle_top = eggxi_get_meta_or_acf( $object_id, 'eggxi_banner_subtitle_top', array( 'banner_subtitle_top', 'page_header_subtitle_top' ) );
		$subtitle_bottom = eggxi_get_meta_or_acf( $object_id, 'eggxi_banner_subtitle_bottom', array( 'banner_subtitle_bottom', 'page_header_subtitle_bottom' ) );

		if ( ! $subtitle_top && is_singular( 'post' ) ) {
			$cats = get_the_category( $object_id );
			if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
				$subtitle_top = implode( ', ', wp_list_pluck( $cats, 'name' ) );
			}
		}

		$bg_url = get_the_post_thumbnail_url( $object_id, 'full' );
	} elseif ( is_home() && ! is_front_page() ) {
		$posts_page = (int) get_option( 'page_for_posts' );
		$title      = $posts_page ? get_the_title( $posts_page ) : __( 'Blog', 'eggxi' );
		$object_id  = $posts_page;
		if ( $posts_page ) {
			$bg_url = get_the_post_thumbnail_url( $posts_page, 'full' );
			$subtitle_top = eggxi_get_meta_or_acf( $posts_page, 'eggxi_banner_subtitle_top', array( 'banner_subtitle_top', 'page_header_subtitle_top' ) );
			$subtitle_bottom = eggxi_get_meta_or_acf( $posts_page, 'eggxi_banner_subtitle_bottom', array( 'banner_subtitle_bottom', 'page_header_subtitle_bottom' ) );
		}
	} elseif ( function_exists( 'is_woocommerce' ) && function_exists( 'woocommerce_page_title' ) && ( is_shop() || is_product_taxonomy() ) ) {
		$title = woocommerce_page_title( false );
		if ( is_shop() ) {
			$shop_id   = (int) wc_get_page_id( 'shop' );
			$object_id = $shop_id;
			$bg_url    = $shop_id ? get_the_post_thumbnail_url( $shop_id, 'full' ) : '';
		}
	} elseif ( is_archive() ) {
		$title = get_the_archive_title();
		$title = wp_strip_all_tags( $title );
		$term  = get_queried_object();
		if ( $term && ! empty( $term->name ) ) {
			$subtitle_top = $term->name;
		}
		if ( $term && ! empty( $term->description ) ) {
			$subtitle_bottom = wp_trim_words( wp_strip_all_tags( $term->description ), 12, '&hellip;' );
		}
	} elseif ( is_search() ) {
		$title = sprintf(
			/* translators: %s: search query */
			__( 'Search Results for: %s', 'eggxi' ),
			get_search_query()
		);
		$subtitle_top = __( 'Search', 'eggxi' );
	} elseif ( is_404() ) {
		$title           = __( 'Page Not Found', 'eggxi' );
		$subtitle_top    = __( 'Error 404', 'eggxi' );
		$subtitle_bottom = __( 'Nothing found here', 'eggxi' );
	} else {
		$title = get_bloginfo( 'name' );
	}

	if ( ! $subtitle_top ) {
		$subtitle_top = get_theme_mod( 'eggxi_page_banner_subtitle_top', '' );
	}
	if ( ! $subtitle_bottom ) {
		$subtitle_bottom = get_theme_mod( 'eggxi_page_banner_subtitle_bottom', '' );
	}
	if ( ! $subtitle_top ) {
		$subtitle_top = get_bloginfo( 'name' );
	}
	if ( ! $subtitle_bottom ) {
		$subtitle_bottom = get_bloginfo( 'description', 'display' );
	}

	if ( ! $bg_url ) {
		$banner_id = (int) get_theme_mod( 'eggxi_page_banner_image', 0 );
		if ( $banner_id ) {
			$bg_url = wp_get_attachment_image_url( $banner_id, 'full' );
		}
	}
	if ( ! $bg_url ) {
		$bg_url = get_template_directory_uri() . '/assets/images/background/inner-pagebg.jpg';
	}

	return array(
		'title'           => $title,
		'subtitle_top'    => $subtitle_top,
		'subtitle_bottom' => $subtitle_bottom,
		'bg_url'          => $bg_url,
	);
}

/**
 * Read post meta or ACF field with fallbacks.
 *
 * @param int      $post_id   Post ID.
 * @param string   $meta_key  Primary post meta key.
 * @param string[] $acf_keys  ACF field name candidates.
 * @param bool     $allow_html Whether to allow HTML (ACF WYSIWYG).
 * @return string
 */
function eggxi_get_meta_or_acf( $post_id, $meta_key, $acf_keys = array(), $allow_html = false ) {
	$post_id = absint( $post_id );
	if ( ! $post_id ) {
		return '';
	}

	$value = get_post_meta( $post_id, $meta_key, true );
	if ( is_string( $value ) && '' !== trim( wp_strip_all_tags( $value ) ) ) {
		return $allow_html ? $value : $value;
	}

	if ( function_exists( 'get_field' ) ) {
		foreach ( (array) $acf_keys as $field ) {
			$acf = get_field( $field, $post_id );
			if ( is_string( $acf ) && '' !== trim( wp_strip_all_tags( $acf ) ) ) {
				return $acf;
			}
		}
	}

	return '';
}

/**
 * Add drop-cap class to the first paragraph of HTML content.
 *
 * @param string $html Content HTML.
 * @return string
 */
function eggxi_add_dropcap_to_first_paragraph( $html ) {
	if ( ! $html || false !== strpos( $html, 'dropcaps' ) ) {
		return $html;
	}

	return preg_replace(
		'/<p(\s[^>]*)?>/',
		'<p$1 class="dropcaps xl ulockd-mt50 ulockd-mb20">',
		$html,
		1
	);
}

/**
 * WP_Query for Popular News (views meta, else comment_count).
 *
 * @param int $count Number of posts (default 6).
 * @return WP_Query
 */
function eggxi_get_popular_news_query( $count = 6 ) {
	$count   = max( 1, absint( $count ) );
	$exclude = eggxi_get_displayed_post_ids();
	$meta    = apply_filters( 'eggxi_popular_views_meta_key', 'post_views_count' );

	$args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $count,
		'post__not_in'        => $exclude,
		'ignore_sticky_posts' => 1,
		'no_found_rows'       => true,
	);

	// Prefer posts that have a view-count meta key.
	$view_q = new WP_Query(
		array_merge(
			$args,
			array(
				'meta_key'       => $meta, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'orderby'        => 'meta_value_num',
				'order'          => 'DESC',
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'     => $meta,
						'compare' => 'EXISTS',
					),
				),
			)
		)
	);

	if ( $view_q->have_posts() && count( $view_q->posts ) >= $count ) {
		return $view_q;
	}

	wp_reset_postdata();

	// Fallback: most commented, then date.
	return new WP_Query(
		array_merge(
			$args,
			array(
				'orderby' => array(
					'comment_count' => 'DESC',
					'date'          => 'DESC',
				),
			)
		)
	);
}

/**
 * WP_Query for Recent And Latest (9 posts, excluding already shown).
 *
 * @param int $count Number of posts (default 9).
 * @return WP_Query
 */
function eggxi_get_recent_latest_query( $count = 9 ) {
	$count = max( 1, absint( $count ) );

	return new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $count,
			'post__not_in'        => eggxi_get_displayed_post_ids(),
			'ignore_sticky_posts' => 1,
			'no_found_rows'       => true,
		)
	);
}

/**
 * Section title with Customizer → ACF → fallback.
 *
 * @param string $mod_key  Theme mod key.
 * @param string $acf_key  Optional ACF option field.
 * @param string $fallback Default title.
 * @return string
 */
function eggxi_get_section_title( $mod_key, $fallback, $acf_key = '' ) {
	$title = get_theme_mod( $mod_key, $fallback );

	if ( '' === trim( (string) $title ) && $acf_key && function_exists( 'get_field' ) ) {
		$acf = get_field( $acf_key, 'option' );
		if ( is_string( $acf ) && '' !== trim( $acf ) ) {
			$title = $acf;
		}
	}

	if ( '' === trim( (string) $title ) ) {
		$title = $fallback;
	}

	return (string) $title;
}

/**
 * Main blog content query: excludes hero/featured IDs, supports pagination.
 *
 * Layout budget per page: 6 carousel + 4 two-col + 3 three-col = 13.
 *
 * @param int $per_page Posts per page.
 * @return WP_Query
 */
function eggxi_get_main_blog_query( $per_page = 13 ) {
	$per_page = max( 1, absint( $per_page ) );
	$paged    = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? (int) get_query_var( 'page' ) : 1 );
	$exclude  = eggxi_get_displayed_post_ids();

	return new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $per_page,
			'paged'               => max( 1, $paged ),
			'post__not_in'        => $exclude,
			'ignore_sticky_posts' => 1,
		)
	);
}

/**
 * WP_Query for the Featured Post grid (exactly up to 4 posts).
 *
 * @return WP_Query
 */
function eggxi_get_featured_grid_query() {
	$post_ids = eggxi_collect_post_ids( 4 );

	if ( empty( $post_ids ) ) {
		return new WP_Query( array( 'post__in' => array( 0 ) ) );
	}

	return new WP_Query(
		array(
			'post__in'            => $post_ids,
			'posts_per_page'      => 4,
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1,
			'post_status'         => 'publish',
		)
	);
}

/**
 * Resolve raw video URL / iframe HTML from ACF or post meta.
 *
 * @param int|null $post_id Post ID.
 * @return string
 */
function eggxi_get_post_video_source_raw( $post_id = null ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	if ( ! $post_id ) {
		return '';
	}

	$acf_keys = array( 'embed_video_url', 'video_url', 'video_embed', 'eggxi_embed_video_url' );

	if ( function_exists( 'get_field' ) ) {
		foreach ( $acf_keys as $key ) {
			$value = get_field( $key, $post_id );
			if ( is_string( $value ) && '' !== trim( $value ) ) {
				return trim( $value );
			}
		}
	}

	foreach ( array( 'embed_video_url', 'eggxi_embed_video_url', 'video_url' ) as $meta_key ) {
		$value = get_post_meta( $post_id, $meta_key, true );
		if ( is_string( $value ) && '' !== trim( $value ) ) {
			return trim( $value );
		}
	}

	return '';
}

/**
 * Convert a video URL or iframe snippet into embed HTML.
 *
 * @param string $raw URL or HTML.
 * @return string
 */
function eggxi_video_raw_to_html( $raw ) {
	$raw = trim( (string) $raw );
	if ( '' === $raw ) {
		return '';
	}

	if ( preg_match( '/<(iframe|video|embed|object)\b/i', $raw ) ) {
		return $raw;
	}

	$embed = wp_oembed_get( esc_url_raw( $raw ) );
	return $embed ? $embed : '';
}

/**
 * Get video embed for a post (ACF → content media → empty).
 *
 * @param int|null $post_id Post ID.
 * @return array{html:string,source:string,content:string}
 */
function eggxi_get_post_video_embed( $post_id = null ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	$result  = array(
		'html'    => '',
		'source'  => '',
		'content' => '',
	);

	if ( ! $post_id ) {
		return $result;
	}

	$raw = eggxi_get_post_video_source_raw( $post_id );
	if ( $raw ) {
		$html = eggxi_video_raw_to_html( $raw );
		if ( $html ) {
			$result['html']   = $html;
			$result['source'] = 'acf';
			return $result;
		}
	}

	$content = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
	$result['content'] = $content;

	$media = get_media_embedded_in_content(
		$content,
		array( 'video', 'object', 'embed', 'iframe' )
	);

	if ( ! empty( $media[0] ) ) {
		$result['html']   = $media[0];
		$result['source'] = 'content';
	}

	return $result;
}

/**
 * Remove the first matching video embed HTML from content.
 *
 * @param string $content Filtered post content HTML.
 * @param string $embed   Embed HTML to strip.
 * @return string
 */
function eggxi_strip_video_embed_from_content( $content, $embed ) {
	if ( ! $content || ! $embed ) {
		return $content;
	}

	$stripped = str_replace( $embed, '', $content );

	// Also strip empty paragraph / figure wrappers left behind.
	$stripped = preg_replace( '/<(p|div|figure)[^>]*>\s*<\/\1>/i', '', $stripped );

	return $stripped;
}

/**
 * Allowed HTML for video embeds in templates.
 *
 * @return array
 */
function eggxi_video_embed_allowed_html() {
	return array_merge(
		wp_kses_allowed_html( 'post' ),
		array(
			'iframe' => array(
				'src'             => true,
				'height'          => true,
				'width'           => true,
				'frameborder'     => true,
				'allowfullscreen' => true,
				'allow'           => true,
				'title'           => true,
				'class'           => true,
				'id'              => true,
				'loading'         => true,
				'referrerpolicy'  => true,
				'scrolling'       => true,
				'style'           => true,
			),
			'video'  => array(
				'src'      => true,
				'controls' => true,
				'autoplay' => true,
				'loop'     => true,
				'muted'    => true,
				'poster'   => true,
				'width'    => true,
				'height'   => true,
				'class'    => true,
			),
			'audio'  => array(
				'src'      => true,
				'controls' => true,
				'autoplay' => true,
				'loop'     => true,
				'muted'    => true,
				'preload'  => true,
				'class'    => true,
				'style'    => true,
			),
			'source' => array(
				'src'  => true,
				'type' => true,
			),
		)
	);
}

/**
 * Allowed HTML for audio embeds (iframe / HTML5 audio / oEmbed).
 *
 * @return array
 */
function eggxi_audio_embed_allowed_html() {
	return eggxi_video_embed_allowed_html();
}

/**
 * Resolve raw audio URL / embed HTML from ACF or post meta.
 *
 * @param int|null $post_id Post ID.
 * @return string
 */
function eggxi_get_post_audio_source_raw( $post_id = null ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	if ( ! $post_id ) {
		return '';
	}

	$acf_keys = array( 'audio_embed_code', 'audio_url', 'embed_audio_url', 'eggxi_audio_embed' );

	if ( function_exists( 'get_field' ) ) {
		foreach ( $acf_keys as $key ) {
			$value = get_field( $key, $post_id );
			if ( is_array( $value ) && ! empty( $value['url'] ) ) {
				return trim( (string) $value['url'] );
			}
			if ( is_string( $value ) && '' !== trim( $value ) ) {
				return trim( $value );
			}
			if ( is_numeric( $value ) ) {
				$url = wp_get_attachment_url( (int) $value );
				if ( $url ) {
					return $url;
				}
			}
		}
	}

	foreach ( array( 'audio_embed_code', 'audio_url', 'eggxi_audio_embed' ) as $meta_key ) {
		$value = get_post_meta( $post_id, $meta_key, true );
		if ( is_string( $value ) && '' !== trim( $value ) ) {
			return trim( $value );
		}
	}

	return '';
}

/**
 * Convert an audio URL, file path, or iframe snippet into player HTML.
 *
 * @param string $raw URL or HTML.
 * @return string
 */
function eggxi_audio_raw_to_html( $raw ) {
	$raw = trim( (string) $raw );
	if ( '' === $raw ) {
		return '';
	}

	if ( preg_match( '/<(iframe|audio|embed|object)\b/i', $raw ) ) {
		return $raw;
	}

	$url = esc_url_raw( $raw );
	if ( ! $url ) {
		return '';
	}

	// Direct media files → native WordPress audio shortcode / player.
	if ( preg_match( '/\.(mp3|m4a|ogg|wav|wma)(\?.*)?$/i', $url ) ) {
		$player = wp_audio_shortcode( array( 'src' => $url ) );
		return $player ? $player : sprintf( '<audio class="w100" controls preload="none" src="%s"></audio>', esc_url( $url ) );
	}

	$embed = wp_oembed_get( $url );
	return $embed ? $embed : '';
}

/**
 * Get audio embed for a post (ACF → content media → empty).
 *
 * @param int|null $post_id Post ID.
 * @return array{html:string,source:string,content:string}
 */
function eggxi_get_post_audio_embed( $post_id = null ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	$result  = array(
		'html'    => '',
		'source'  => '',
		'content' => '',
	);

	if ( ! $post_id ) {
		return $result;
	}

	$raw = eggxi_get_post_audio_source_raw( $post_id );
	if ( $raw ) {
		$html = eggxi_audio_raw_to_html( $raw );
		if ( $html ) {
			$result['html']   = $html;
			$result['source'] = 'acf';
			return $result;
		}
	}

	$content           = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
	$result['content'] = $content;

	$media = get_media_embedded_in_content(
		$content,
		array( 'audio', 'iframe', 'object', 'embed' )
	);

	if ( ! empty( $media[0] ) ) {
		$result['html']   = $media[0];
		$result['source'] = 'content';
	}

	return $result;
}
