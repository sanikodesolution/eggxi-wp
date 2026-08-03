<?php
/**
 * Sidebar fallback: Photo / Flickr-style grid.
 *
 * @package Eggxi
 */

$shortcode = get_theme_mod( 'eggxi_instagram_shortcode', '' );
?>
<div class="sidebar_tag_widget ulockd-pb20">
	<h4 class="saw_title"><?php esc_html_e( 'Flickr Feed', 'eggxi' ); ?></h4>
	<?php if ( $shortcode ) : ?>
		<div class="flickr-photo">
			<?php echo do_shortcode( $shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	<?php else : ?>
		<div class="flickr-photo">
			<ul class="ulockd-mb0">
				<?php
				$photos = new WP_Query(
					array(
						'posts_per_page'      => 6,
						'post_status'         => 'publish',
						'ignore_sticky_posts' => 1,
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
									<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-whp' ) ); ?>
								</a>
							</div>
						</li>
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</ul>
		</div>
	<?php endif; ?>
</div>
