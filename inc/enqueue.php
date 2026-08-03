<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Eggxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue front-end assets from /assets.
 */
function eggxi_scripts() {
	$uri = get_template_directory_uri() . '/assets';
	$ver = EGGXI_VERSION;

	// Styles.
	wp_enqueue_style( 'eggxi-bootstrap', $uri . '/css/bootstrap.min.css', array(), '5.3.8' );
	wp_enqueue_style( 'eggxi-bs4-compat', $uri . '/css/bs4-compat.css', array( 'eggxi-bootstrap' ), $ver );
	wp_enqueue_style( 'eggxi-plugins', $uri . '/css/all-plugins.css', array( 'eggxi-bs4-compat' ), $ver );
	wp_enqueue_style( 'eggxi-main', $uri . '/css/style.css', array( 'eggxi-plugins' ), $ver );
	wp_enqueue_style( 'eggxi-theme-color', $uri . '/css/theme-color.css', array( 'eggxi-main' ), $ver );
	wp_enqueue_style( 'eggxi-responsive', $uri . '/css/responsive.css', array( 'eggxi-theme-color' ), $ver );
	wp_enqueue_style( 'eggxi-theme', get_stylesheet_uri(), array( 'eggxi-responsive' ), $ver );

	// Scripts (bundle includes Popper).
	wp_enqueue_script( 'eggxi-bootstrap', $uri . '/js/bootstrap.bundle.min.js', array( 'jquery' ), '5.3.8', true );
	wp_enqueue_script( 'eggxi-bootsnav', $uri . '/js/bootsnav.js', array( 'jquery', 'eggxi-bootstrap' ), $ver, true );
	wp_enqueue_script( 'eggxi-mmenu', $uri . '/js/jquery.mmenu.all.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-scrolltofixed', $uri . '/js/jquery-scrolltofixed-min.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-gallery', $uri . '/js/gallery.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-wow', $uri . '/js/wow.min.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'eggxi-slider', $uri . '/js/slider.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script(
		'eggxi-script',
		$uri . '/js/script.js',
		array( 'jquery', 'eggxi-bootstrap', 'eggxi-bootsnav', 'eggxi-slider', 'eggxi-gallery', 'eggxi-wow' ),
		$ver,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'eggxi_scripts' );
