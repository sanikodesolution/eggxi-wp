<?php
/**
 * 404 template — Elementor Theme Builder aware.
 *
 * @package Eggxi
 */

get_header();

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) :
	get_template_part( 'template-parts/content', 'page-header' );
	?>
	<main id="primary" class="site-main">
		<section class="error-404 not-found">
			<div class="container">
				<div class="page-content text-center ulockd-pt50 ulockd-pb50">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Try a search.', 'eggxi' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			</div>
		</section>
	</main>
	<?php
endif;

get_footer();
