<?php
/**
 * Related posts — “You May also Like” (`.fasion_blog_post` / `.fblog_post.style2`).
 *
 * @package Eggxi
 */

if ( ! is_singular( 'post' ) ) {
	return;
}

$current_id = get_the_ID();
$cat_ids    = wp_get_post_categories( $current_id );
$tag_ids    = wp_get_post_tags( $current_id, array( 'fields' => 'ids' ) );

$query_args = array(
	'post_type'           => 'post',
	'posts_per_page'      => 3,
	'post_status'         => 'publish',
	'post__not_in'        => array( $current_id ),
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
	'orderby'             => 'rand',
);

if ( ! empty( $cat_ids ) ) {
	$query_args['category__in'] = $cat_ids;
} elseif ( ! empty( $tag_ids ) ) {
	$query_args['tag__in'] = $tag_ids;
}

/**
 * Filter related posts query args.
 *
 * @param array $query_args WP_Query args.
 * @param int   $current_id Current post ID.
 */
$query_args = apply_filters( 'eggxi_related_posts_query_args', $query_args, $current_id );

$related_query = new WP_Query( $query_args );

if ( ! $related_query->have_posts() ) {
	return;
}
?>
<section class="fasion_blog_post bgc-whitef5 ulockd-pb30">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="main-title style2">
					<h2 class="title"><span><?php esc_html_e( 'You May also Like', 'eggxi' ); ?></span></h2>
				</div>
			</div>

			<?php
			while ( $related_query->have_posts() ) :
				$related_query->the_post();

				$categories = get_the_category();
				$primary    = ! empty( $categories ) ? $categories[0] : null;
				?>
				<div class="col-lg-4">
					<article <?php post_class( 'fblog_post style2' ); ?>>
						<div class="thumb">
							<a href="<?php the_permalink(); ?>">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail(
										'medium',
										array(
											'class'   => 'img-fluid w100',
											'loading' => 'lazy',
										)
									);
								} else {
									printf(
										'<img class="img-fluid w100" src="%1$s" alt="%2$s">',
										esc_url( get_template_directory_uri() . '/assets/images/blog/1.jpg' ),
										esc_attr( get_the_title() )
									);
								}
								?>
							</a>
							<div class="post_meta text-thm">
								<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
									<?php echo esc_html( get_the_date( 'j M Y' ) ); ?>
								</time>
							</div>
						</div>
						<div class="details">
							<?php if ( $primary ) : ?>
								<div class="tag text-center text-thm">
									<a href="<?php echo esc_url( get_category_link( $primary->term_id ) ); ?>">
										<?php echo esc_html( $primary->name ); ?>
									</a>
								</div>
							<?php endif; ?>
							<h5>
								<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
							</h5>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15, '...' ) ); ?></p>
							<a class="text-thm" href="<?php the_permalink(); ?>">
								<?php esc_html_e( 'Read More', 'eggxi' ); ?>
								<i class="fas fa-angle-right"></i>
							</a>
						</div>
					</article>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
