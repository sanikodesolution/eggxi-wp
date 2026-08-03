<?php
/**
 * Main blog content (left column) + sidebar shell.
 *
 * Row 1: carousel (.three-grid-slider)
 * Row 2–3: 2-column cards
 * Row 4: 3-column style5 cards
 *
 * @package Eggxi
 */

$blog_query = eggxi_get_main_blog_query( 13 );

if ( ! $blog_query->have_posts() ) {
	return;
}

$posts = array();
while ( $blog_query->have_posts() ) {
	$blog_query->the_post();
	eggxi_remember_displayed_post( get_the_ID() );
	$posts[] = get_post();
}
wp_reset_postdata();

$carousel = array_slice( $posts, 0, 6 );
$grid_two = array_slice( $posts, 6, 4 );
$grid_three = array_slice( $posts, 10, 3 );
?>
<section class="feature_blog_post ulockd-pb30">
	<div class="container">
		<div class="row">
			<div class="col-xl-8">
				<div class="row">
					<?php if ( ! empty( $carousel ) ) : ?>
						<div class="col-lg-12">
							<button type="button" class="btn btn-thm blog_sidebar_pp_button dn db-lg mb30-lg"><?php esc_html_e( 'Blog Sidebar', 'eggxi' ); ?></button>
							<div class="three-grid-slider ulockd-mb40" data-dots="true" data-loop="true" data-autoplay="true" data-margin="10" data-singleItem="true">
								<?php
								foreach ( $carousel as $post ) :
									$GLOBALS['post'] = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
									setup_postdata( $post );
									?>
									<div class="item">
										<?php
										get_template_part(
											'template-parts/cards/post',
											'style',
											array( 'extra_class' => '' )
										);
										?>
									</div>
								<?php endforeach; ?>
								<?php wp_reset_postdata(); ?>
							</div>
						</div>
					<?php endif; ?>

					<?php
					foreach ( $grid_two as $post ) :
						$GLOBALS['post'] = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
						setup_postdata( $post );
						?>
						<div class="col-md-6 col-lg-6">
							<?php
							get_template_part(
								'template-parts/cards/post',
								'style',
								array( 'extra_class' => 'ulockd-mb40' )
							);
							?>
						</div>
					<?php endforeach; ?>
					<?php wp_reset_postdata(); ?>

					<?php
					$style5_i = 0;
					$style5_total = count( $grid_three );
					foreach ( $grid_three as $post ) :
						$GLOBALS['post'] = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
						setup_postdata( $post );
						$style5_i++;
						?>
						<div class="col-md-4 col-lg-4">
							<?php
							get_template_part(
								'template-parts/cards/post',
								'style5',
								array(
									'show_explore' => ( $style5_i === $style5_total ),
								)
							);
							?>
						</div>
					<?php endforeach; ?>
					<?php wp_reset_postdata(); ?>

					<?php if ( $blog_query->max_num_pages > 1 ) : ?>
						<div class="col-lg-12">
							<nav class="eggxi-pagination ulockd-mb30" aria-label="<?php esc_attr_e( 'Posts pagination', 'eggxi' ); ?>">
								<?php
								echo wp_kses_post(
									paginate_links(
										array(
											'total'     => (int) $blog_query->max_num_pages,
											'current'   => max( 1, (int) ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 ) ) ),
											'prev_text' => '&laquo;',
											'next_text' => '&raquo;',
											'type'      => 'list',
										)
									)
								);
								?>
							</nav>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-xl-4">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</section>
