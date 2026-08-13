<?php
/**
 * Main blog content (left column) + sidebar shell.
 *
 * Row 1: carousel (.three-grid-slider) — 3 latest
 * Row 2+: 2-column cards — remaining latest (grows with new posts)
 * Last row: 3-column style5 cards — always at the bottom
 *
 * @package Eggxi
 */

$blog_query = eggxi_get_main_blog_query();

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

$count      = count( $posts );
$carousel_n = min( 3, $count );
$bottom_n   = ( ( $count - $carousel_n ) >= 3 ) ? 3 : 0;
$middle_n   = $count - $carousel_n - $bottom_n;

$carousel   = array_slice( $posts, 0, $carousel_n );
$grid_two   = array_slice( $posts, $carousel_n, $middle_n );
$grid_three = $bottom_n ? array_slice( $posts, -$bottom_n ) : array();
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
				</div>
			</div>
			<div class="col-xl-4">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</section>
