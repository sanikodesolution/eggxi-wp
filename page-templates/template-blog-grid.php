<?php
/**
 * Template Name: Blog Grid (3 Columns)
 * Template Post Type: page
 *
 * Full-width 3-column blog grid with pagination.
 *
 * @package Eggxi
 */

get_header();
get_template_part( 'template-parts/content', 'page-header' );

$paged = max( 1, (int) ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 ) ) );

$grid_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 9,
		'paged'               => $paged,
		'ignore_sticky_posts' => 1,
	)
);

get_template_part(
	'template-parts/content',
	'blog-grid',
	array( 'query' => $grid_query )
);

get_footer();
