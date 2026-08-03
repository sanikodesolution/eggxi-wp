<?php
/**
 * Template Name: Elementor Canvas
 * Template Post Type: page,post
 *
 * Blank canvas for Elementor — no theme header, footer, or page banner.
 *
 * @package Eggxi
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'eggxi-elementor-canvas elementor-template-canvas' ); ?>>
<?php wp_body_open(); ?>
<main id="primary" class="site-main eggxi-elementor-canvas-main">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</main>
<?php wp_footer(); ?>
</body>
</html>
