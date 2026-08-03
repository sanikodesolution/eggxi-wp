<?php
/**
 * Theme header.
 *
 * @package Eggxi
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="wrapper ovh">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'eggxi' ); ?></a>

	<?php if ( ! eggxi_elementor_location( 'header' ) ) : ?>
		<div id="preloader" class="preloader">
			<div id="pre" class="preloader_container">
				<div class="preloader_disabler btn btn-default"><?php esc_html_e( 'Disable Preloader', 'eggxi' ); ?></div>
			</div>
		</div>

		<?php get_template_part( 'template-parts/header/top-bar' ); ?>
		<?php get_template_part( 'template-parts/header/middle' ); ?>
		<?php get_template_part( 'template-parts/header/navigation' ); ?>
		<?php get_template_part( 'template-parts/header/mobile' ); ?>
	<?php endif; ?>
