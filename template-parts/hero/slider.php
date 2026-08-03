<?php
/**
 * Hero / home featured post slider.
 *
 * Preserves template classes: .home1-slider, .home1_slider, and adds .hero-slider.
 *
 * @package Eggxi
 */

$count = (int) get_theme_mod( 'eggxi_hero_count', 6 );
$hero  = eggxi_get_hero_query( $count );

if ( ! $hero->have_posts() ) {
	return;
}
?>
<section class="home1-slider hero-slider ulockd-p0">
	<div class="container-fluid ulockd-p0">
		<div class="row">
			<div class="col-lg-12">
				<div class="home1_slider" data-autoplay="true" data-autoplayHoverPause="false" data-center="true" data-dots="false" data-loop="true" data-margin="20" data-nav="true" data-smartspeed="1500">
					<?php
					while ( $hero->have_posts() ) :
						$hero->the_post();
						eggxi_remember_displayed_post( get_the_ID() );
						get_template_part( 'template-parts/hero/slide' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</div>
	</div>
</section>
