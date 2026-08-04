<?php
/**
 * Footer column 3 fallback — Latest News (2 posts) + Tags.
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
					<a class="footer-news-thumb" href="<?php the_permalink(); ?>">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail(
								'thumbnail',
								array(
									'class'   => 'img-fluid',
									'loading' => 'lazy',
								)
							);
						} else {
							printf(
								'<img class="img-fluid" src="%1$s" alt="%2$s">',
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
							<a href="<?php the_permalink(); ?>"><?php echo esc_html( wp_trim_words( get_the_title(), 10, '…' ) ); ?></a>
						</h5>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 6, '…' ) ); ?></p>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No recent posts yet.', 'eggxi' ); ?></p>
		<?php endif; ?>
	</div>
</div>

<?php
$footer_tags = get_tags(
	array(
		'number'     => 10,
		'orderby'    => 'count',
		'order'      => 'DESC',
		'hide_empty' => true,
	)
);
?>
<div class="footer-tag-widget">
	<h4 class="title"><?php esc_html_e( 'Tags', 'eggxi' ); ?></h4>
	<ul class="footer-tag-list ulockd-mb0">
		<?php if ( ! empty( $footer_tags ) && ! is_wp_error( $footer_tags ) ) : ?>
			<?php foreach ( $footer_tags as $footer_tag ) : ?>
				<li>
					<a href="<?php echo esc_url( get_tag_link( $footer_tag->term_id ) ); ?>" title="<?php echo esc_attr( $footer_tag->name ); ?>">
						<?php echo esc_html( wp_html_excerpt( $footer_tag->name, 18, '…' ) ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		<?php else : ?>
			<li><span class="footer-tag-empty"><?php esc_html_e( 'No tags yet.', 'eggxi' ); ?></span></li>
		<?php endif; ?>
	</ul>
</div>
