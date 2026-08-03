<?php
/**
 * Sidebar fallback: Recent posts (4).
 *
 * @package Eggxi
 */

$recent = new WP_Query(
	array(
		'posts_per_page'      => 4,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'no_found_rows'       => true,
	)
);

if ( ! $recent->have_posts() ) {
	return;
}

$i     = 0;
$total = (int) $recent->post_count;
?>
<div class="sidebar_recent_post_widget">
	<h4 class="saw_title"><?php esc_html_e( 'Recent Post', 'eggxi' ); ?></h4>
	<?php
	while ( $recent->have_posts() ) :
		$recent->the_post();
		$i++;
		$wrap_class = ( $i < $total ) ? 'media ulockd-mb30' : 'media';
		$thumb      = get_the_post_thumbnail(
			get_the_ID(),
			'thumbnail',
			array(
				'class' => 'me-3 mr-3',
			)
		);
		if ( ! $thumb ) {
			$thumb = sprintf(
				'<img class="me-3 mr-3" src="%1$s" alt="%2$s">',
				esc_url( get_template_directory_uri() . '/assets/images/blog/s1.jpg' ),
				esc_attr( get_the_title() )
			);
		}
		?>
		<div class="<?php echo esc_attr( $wrap_class ); ?>">
			<?php echo $thumb; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div class="media-body">
				<?php
				$term = eggxi_get_primary_category();
				if ( $term ) :
					?>
					<span class="tag bgc-thm color-white"><?php echo esc_html( $term->name ); ?></span>
				<?php endif; ?>
				<h5 class="title"><a class="fwb" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
				<a class="post_date" href="<?php the_permalink(); ?>">
					<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				</a>
			</div>
		</div>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
</div>
