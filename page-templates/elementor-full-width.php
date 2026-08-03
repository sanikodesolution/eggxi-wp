<?php
/**
 * Template Name: Elementor Full Width
 * Template Post Type: page,post
 *
 * Theme header + footer with a full-bleed Elementor content area (no sidebar / page banner).
 *
 * @package Eggxi
 */

get_header();
?>
<main id="primary" class="site-main eggxi-elementor-fullwidth-main">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</main>
<?php
get_footer();
