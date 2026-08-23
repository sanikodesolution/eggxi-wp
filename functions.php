<?php
/**
 * Eggxi theme functions.
 *
 * @package Eggxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EGGXI_VERSION', '1.1.22' );
define( 'EGGXI_DIR', get_template_directory() );
define( 'EGGXI_URI', get_template_directory_uri() );

require EGGXI_DIR . '/inc/setup.php';
require EGGXI_DIR . '/inc/enqueue.php';
require EGGXI_DIR . '/inc/customizer.php';
require EGGXI_DIR . '/inc/colors.php';
require EGGXI_DIR . '/inc/template-tags.php';
require EGGXI_DIR . '/inc/elementor.php';
require EGGXI_DIR . '/inc/class-eggxi-nav-walker.php';

/**
 * Replace [year] and %currentyear% with the current year (WordPress timezone).
 *
 * %currentyear% matches Rank Math SEO variable syntax.
 *
 * @param string $text Text that may contain year placeholders.
 * @return string
 */
function eggxi_replace_year_placeholder( $text ) {
	if ( ! is_string( $text ) ) {
		return $text;
	}

	if ( false === strpos( $text, '[year]' ) && false === strpos( $text, '%currentyear%' ) ) {
		return $text;
	}

	$year = (string) wp_date( 'Y' );

	return str_replace(
		array( '[year]', '%currentyear%' ),
		array( $year, $year ),
		$text
	);
}

/**
 * Show current year in post, page, and menu titles.
 *
 * @param string $title Post title.
 * @return string
 */
function eggxi_year_in_title( $title ) {
	if ( is_admin() ) {
		return $title;
	}

	return eggxi_replace_year_placeholder( $title );
}
add_filter( 'the_title', 'eggxi_year_in_title' );
add_filter( 'single_post_title', 'eggxi_year_in_title' );
add_filter( 'widget_title', 'eggxi_year_in_title' );

/**
 * Show current year in the browser / SEO document title.
 *
 * @param array $parts Title parts (title, page, tagline, site).
 * @return array
 */
function eggxi_year_in_document_title( $parts ) {
	foreach ( $parts as $key => $part ) {
		$parts[ $key ] = eggxi_replace_year_placeholder( $part );
	}

	return $parts;
}
add_filter( 'document_title_parts', 'eggxi_year_in_document_title' );

/**
 * Show current year in post and page content.
 *
 * @param string $content Post content.
 * @return string
 */
function eggxi_year_in_content( $content ) {
	if ( is_admin() ) {
		return $content;
	}

	return eggxi_replace_year_placeholder( $content );
}
add_filter( 'the_content', 'eggxi_year_in_content' );

/**
 * Show current year in Customizer footer copyright text.
 *
 * @param string $value Copyright text from theme mod.
 * @return string
 */
function eggxi_year_in_footer_copyright( $value ) {
	return eggxi_replace_year_placeholder( $value );
}
add_filter( 'theme_mod_eggxi_footer_copyright', 'eggxi_year_in_footer_copyright' );

/**
 * [year] and [currentyear] shortcodes for content, widgets, and Customizer text.
 *
 * @return string Current year.
 */
function eggxi_year_shortcode() {
	return (string) wp_date( 'Y' );
}
add_shortcode( 'year', 'eggxi_year_shortcode' );
add_shortcode( 'currentyear', 'eggxi_year_shortcode' );
