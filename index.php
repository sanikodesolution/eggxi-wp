<?php
/**
 * Main fallback template.
 *
 * @package Eggxi
 */

get_header();

if ( is_front_page() ) {
	get_template_part( 'template-parts/hero/slider' );
	get_template_part( 'template-parts/content', 'featured-grid' );
	get_template_part( 'template-parts/content', 'main-blog' );
	get_template_part( 'template-parts/content', 'recent-latest' );
	get_template_part( 'template-parts/content', 'popular-news' );
} else {
	?>
	<main id="primary" class="site-main">
		<div class="container">
			<div class="row">
				<div class="col-xl-8">
					<?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) : ?>
							<?php the_post(); ?>
							<?php get_template_part( 'template-parts/content' ); ?>
						<?php endwhile; ?>
						<?php the_posts_pagination(); ?>
					<?php else : ?>
						<?php get_template_part( 'template-parts/content', 'none' ); ?>
					<?php endif; ?>
				</div>
				<div class="col-xl-4">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</main>
	<?php
}

get_footer();
