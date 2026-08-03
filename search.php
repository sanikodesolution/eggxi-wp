<?php
/**
 * Search results — Elementor Theme Builder aware.
 *
 * @package Eggxi
 */

get_header();

if ( ! eggxi_elementor_location( 'archive' ) ) :
	get_template_part( 'template-parts/content', 'page-header' );
	get_template_part( 'template-parts/content', 'blog-grid' );
endif;

get_footer();
