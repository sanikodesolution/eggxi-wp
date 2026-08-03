<?php
/**
 * Footer column 4 fallback — Important Links + Flickr/Instagram grid.
 *
 * @package Eggxi
 */

$menu_location = has_nav_menu( 'footer-menu' ) ? 'footer-menu' : ( has_nav_menu( 'footer' ) ? 'footer' : '' );
$shortcode     = get_theme_mod( 'eggxi_instagram_shortcode', '' );
?>
<div class="footer-link-widget ulockd-mb30">
	<h4 class="title"><?php esc_html_e( 'Important Link', 'eggxi' ); ?></h4>
	<?php
	if ( $menu_location ) {
		wp_nav_menu(
			array(
				'theme_location' => $menu_location,
				'container'      => false,
				'menu_class'     => 'list-style-square',
				'depth'          => 1,
				'fallback_cb'    => false,
			)
		);
	} else {
		?>
		<ul class="list-style-square">
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'eggxi' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About Licences', 'eggxi' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Help & Conditions', 'eggxi' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'eggxi' ); ?></a></li>
		</ul>
		<?php
	}
	?>
</div>

<div class="footer-flickr-widget">
	<h4 class="title"><?php esc_html_e( 'Flickr Feed', 'eggxi' ); ?></h4>
	<?php if ( $shortcode ) : ?>
		<?php echo do_shortcode( $shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php else : ?>
		<ul>
			<?php
			$photos = new WP_Query(
				array(
					'posts_per_page'      => 6,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
					'meta_query'          => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
						array(
							'key'     => '_thumbnail_id',
							'compare' => 'EXISTS',
						),
					),
				)
			);

			if ( $photos->have_posts() ) :
				while ( $photos->have_posts() ) :
					$photos->the_post();
					?>
					<li class="list-inline-item">
						<div class="thumb">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-whp', 'loading' => 'lazy' ) ); ?>
								<div class="overlay"><span class="flaticon-add"></span></div>
							</a>
						</div>
					</li>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				for ( $i = 1; $i <= 6; $i++ ) :
					?>
					<li class="list-inline-item">
						<div class="thumb">
							<img class="img-whp" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/blog/s' . $i . '.jpg' ); ?>" alt="<?php echo esc_attr( sprintf( /* translators: %d: index */ __( 'Gallery %d', 'eggxi' ), $i ) ); ?>">
							<div class="overlay"><span class="flaticon-add"></span></div>
						</div>
					</li>
					<?php
				endfor;
			endif;
			?>
		</ul>
	<?php endif; ?>
</div>
