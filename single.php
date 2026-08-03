<?php
/**
 * Single post template — Elementor Theme Builder aware.
 *
 * @package Eggxi
 */

get_header();

if ( ! eggxi_elementor_location( 'single' ) ) :
	// Post built entirely in Elementor → full content, no sidebar chrome.
	if ( eggxi_is_built_with_elementor() ) :
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
		get_template_part( 'template-parts/content', 'page-header' );
		?>
		<section class="blog-single-post bgc-ghostwhite ulockd-pb15">
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<?php while ( have_posts() ) : ?>
							<?php the_post(); ?>
							<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

							<div class="row">
								<div class="col-lg-12">
									<div class="blog_singler_poster">
										<?php
										if ( comments_open() || get_comments_number() ) {
											comments_template();
										}
										?>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
					<div class="col-lg-4">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
		</section>
		<?php
		get_template_part( 'template-parts/related-posts' );
	endif;
endif;

get_footer();
