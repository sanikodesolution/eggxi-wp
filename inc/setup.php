<?php
/**
 * Theme setup: supports, menus, widgets.
 *
 * @package Eggxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme supports and navigation menus.
 */
function eggxi_setup() {
	load_theme_textdomain( 'eggxi', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support(
		'post-formats',
		array( 'image', 'gallery', 'video', 'audio' )
	);

	register_nav_menus(
		array(
			'top-nav'     => __( 'Top Nav', 'eggxi' ),
			'primary'     => __( 'Primary Menu', 'eggxi' ),
			'footer'      => __( 'Footer Menu (short links)', 'eggxi' ),
			'footer-menu' => __( 'Footer Important Links', 'eggxi' ),
			'offcanvas'   => __( 'Off-Canvas Menu', 'eggxi' ),
		)
	);

	add_image_size( 'eggxi-hero', 800, 520, true );
}
add_action( 'after_setup_theme', 'eggxi_setup' );

/**
 * Add list-inline-item class to Top Nav / Footer menu items (matches HTML markup).
 *
 * @param string[] $classes Menu item classes.
 * @param WP_Post  $item    Menu item.
 * @param stdClass $args    wp_nav_menu args.
 * @return string[]
 */
function eggxi_nav_menu_css_class( $classes, $item, $args ) {
	if ( empty( $args->theme_location ) ) {
		return $classes;
	}

	if ( in_array( $args->theme_location, array( 'top-nav', 'footer' ), true ) ) {
		$classes[] = 'list-inline-item';
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'eggxi_nav_menu_css_class', 10, 3 );

/**
 * Register widget areas.
 */
function eggxi_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Primary Sidebar', 'eggxi' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Primary sidebar for single posts, archives, and blog pages (About, Video, Categories, Follow, Tags, Photos).', 'eggxi' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="saw_title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Header Banner', 'eggxi' ),
			'id'            => 'header-banner',
			'description'   => __( 'Optional top header promo banner. Overrides Customizer banner when active.', 'eggxi' ),
			'before_widget' => '<div id="%1$s" class="header-banner-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="screen-reader-text">',
			'after_title'   => '</span>',
		)
	);

	$footer_columns = array(
		'footer-1' => array(
			'name'        => __( 'Footer Column 1 — About / Newsletter', 'eggxi' ),
			'description' => __( 'About Us text and newsletter form (or MC4WP widget).', 'eggxi' ),
		),
		'footer-2' => array(
			'name'        => __( 'Footer Column 2 — Twitter Feed', 'eggxi' ),
			'description' => __( 'Twitter / X feed widget or embed shortcode.', 'eggxi' ),
		),
		'footer-3' => array(
			'name'        => __( 'Footer Column 3 — Latest News / Tags', 'eggxi' ),
			'description' => __( 'Recent posts and tag cloud widgets.', 'eggxi' ),
		),
		'footer-4' => array(
			'name'        => __( 'Footer Column 4 — Links / Flickr', 'eggxi' ),
			'description' => __( 'Important links menu and Flickr/Instagram photo grid.', 'eggxi' ),
		),
	);

	foreach ( $footer_columns as $id => $column ) {
		register_sidebar(
			array(
				'name'          => $column['name'],
				'id'            => $id,
				'description'   => $column['description'],
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="title">',
				'after_title'   => '</h4>',
			)
		);
	}

	// Legacy home Instagram / subscribe columns (optional overrides).
	register_sidebar(
		array(
			'name'          => __( 'Footer Instagram Column (legacy)', 'eggxi' ),
			'id'            => 'footer-instagram',
			'description'   => __( 'Optional legacy Instagram strip widget area.', 'eggxi' ),
			'before_widget' => '<div id="%1$s" class="home_instagram_feed widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="screen-reader-text">',
			'after_title'   => '</span>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Subscription Column (legacy)', 'eggxi' ),
			'id'            => 'footer-subscribe',
			'description'   => __( 'Optional legacy subscription strip widget area.', 'eggxi' ),
			'before_widget' => '<div id="%1$s" class="mc-form subscription-box bgc-thm3 ulockd-p20 ulockd-mt5 mt30-md widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="text-white ulockd-mt0">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'eggxi_widgets_init' );
