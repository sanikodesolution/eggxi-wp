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
