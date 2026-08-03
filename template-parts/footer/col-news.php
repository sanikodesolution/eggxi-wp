<?php
/**
 * Footer column 3 fallback — Latest News (2 posts) + Tag Cloud.
 *
 * @package Eggxi
 */

$news = new WP_Query(
	array(
		'posts_per_page'      => 2,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
?>
<div class="footer-news-widget">
	<h4 class="title"><?php esc_html_e( 'Latest News', 'eggxi' ); ?></h4>
	<div class="ulockd-media-box">
		<?php if ( $news->have_posts() ) : ?>
			<?php
			while ( $news->have_posts() ) :
				$news->the_post();
				?>
				<div class="media">
					<a href="<?php the_permalink(); ?>">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail(
								'thumbnail',
								array(
									'class'   => 'me-3 mr-3',
									'loading' => 'lazy',
								)
							);
						} else {
							printf(
								'<img class="me-3 mr-3" src="%1$s" alt="%2$s">',
								esc_url( get_template_directory_uri() . '/assets/images/blog/s1.jpg' ),
								esc_attr( get_the_title() )
							);
						}
						?>
					</a>
					<div class="media-body">
						<a href="<?php the_permalink(); ?>" class="post-date">
							<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
								<?php echo esc_html( get_the_date( 'j F, Y' ) ); ?>
							</time>
						</a>
						<h5 class="media-heading mt-0">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h5>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 8, '...' ) ); ?></p>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No recent posts yet.', 'eggxi' ); ?></p>
		<?php endif; ?>
	</div>
</div>

<div class="footer-tag-widget">
	<h4 class="title"><?php esc_html_e( 'Tag Widget', 'eggxi' ); ?></h4>
	<ul>
		<?php
		$tag_cloud = wp_tag_cloud(
			array(
				'echo'     => false,
				'number'   => 12,
				'smallest' => 12,
				'largest'  => 12,
				'unit'     => 'px',
				'format'   => 'flat',
			)
		);

		if ( $tag_cloud ) {
			// Wrap each tag link in list-inline-item for Eggxi markup.
			$tag_cloud = preg_replace( '/<a /', '<li class="list-inline-item"><a ', $tag_cloud );
			$tag_cloud = preg_replace( '/<\/a>/', '</a></li>', $tag_cloud );
			echo $tag_cloud; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			echo '<li class="list-inline-item">' . esc_html__( 'No tags yet.', 'eggxi' ) . '</li>';
		}
		?>
	</ul>
</div>
