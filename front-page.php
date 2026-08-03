<?php
/**
 * Front page — Elementor page / Theme Builder, else Eggxi homepage sections.
 *
 * @package Eggxi
 */

get_header();

if ( ! eggxi_elementor_location( 'single' ) && ! eggxi_elementor_location( 'archive' ) ) :
	if ( is_page() && eggxi_is_built_with_elementor() ) :
		?>
		<main id="primary" class="site-main eggxi-elementor-content">
			<?php
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
			?>
		</main>
		<?php
	else :
		get_template_part( 'template-parts/hero/slider' );
		get_template_part( 'template-parts/content', 'featured-grid' );
		get_template_part( 'template-parts/content', 'main-blog' );
		get_template_part( 'template-parts/content', 'recent-latest' );
		get_template_part( 'template-parts/content', 'popular-news' );
	endif;
endif;

get_footer();
