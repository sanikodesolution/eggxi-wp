<?php
/**
 * Popular News section.
 *
 * Layout:
 * - Left  (.col-xl-5): large overlay card (.home1_blog_post.style2.two)
 * - Middle (.col-xl-4): 4 list items (.recent_latest_post)
 * - Right  (.col-xl-3): card + excerpt (.home1_post_style)
 *
 * @package Eggxi
 */

$query = eggxi_get_popular_news_query( 6 );

if ( ! $query->have_posts() ) {
	return;
}

$posts = array();
while ( $query->have_posts() ) {
	$query->the_post();
	eggxi_remember_displayed_post( get_the_ID() );
	$posts[] = get_post();
}
wp_reset_postdata();

$posts    = array_values( $posts );
$left     = isset( $posts[0] ) ? $posts[0] : null;
$middle   = array_slice( $posts, 1, 4 );
$right    = isset( $posts[5] ) ? $posts[5] : null;
$title    = eggxi_get_section_title( 'eggxi_popular_news_title', __( 'Popular News', 'eggxi' ), 'popular_news_title' );
?>
<section class="fasion_blog_post bgc-lightcyan ulockd-pb50">
	<div class="container">
		<div class="row">
			<div class="col-xl-6 offset-xl-3 text-center">
				<div class="main-title">
					<h2 class="title"><span><?php echo esc_html( $title ); ?></span></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<?php if ( $left ) : ?>
				<?php
				$GLOBALS['post'] = $left; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				setup_postdata( $left );
				$img       = eggxi_get_post_image_url( 'large', $left->ID );
				$author_id = (int) get_the_author_meta( 'ID' );
				?>
				<div class="col-xl-5">
					<div class="home1_blog_post style2 two mb30-lg">
						<div class="thumb" style="background-image: url(<?php echo esc_url( $img ); ?>);">
							<div class="overlay"></div>
						</div>
						<div class="details">
							<?php eggxi_the_category_badge( 'bgc-thm', $left->ID ); ?>
							<h4 class="title"><a class="fwb" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<ul class="post_meta ulockd-mb0">
								<li class="list-inline-item">
									<?php
									echo get_avatar(
										$author_id,
										40,
										'',
										get_the_author(),
										array( 'class' => 'rounded-circle' )
									);
									?>
									<span class="ulockd-pl10 fz14"><?php the_author(); ?></span>
								</li>
								<li class="list-inline-item">
									<span class="flaticon-timetable"></span>
									<span class="ulockd-pl10 fz14">
										<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
									</span>
								</li>
								<li class="list-inline-item">
									<span class="flaticon-comment-1"></span>
									<span class="ulockd-pl10 fz14"><?php echo esc_html( number_format_i18n( get_comments_number() ) ); ?></span>
								</li>
								<li class="list-inline-item">
									<span class="flaticon-heart"></span>
									<span class="ulockd-pl10 fz14"><?php echo esc_html( number_format_i18n( eggxi_get_like_count() ) ); ?></span>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>

			<?php if ( ! empty( $middle ) ) : ?>
				<div class="col-lg-6 col-xl-4">
					<div class="recent_latest_post">
						<?php
						$total_m = count( $middle );
						$i       = 0;
						foreach ( $middle as $post ) :
							$i++;
							$GLOBALS['post'] = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
							setup_postdata( $post );
							get_template_part(
								'template-parts/cards/recent',
								'list-item',
								array( 'is_last' => ( $i === $total_m ) )
							);
						endforeach;
						wp_reset_postdata();
						?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $right ) : ?>
				<?php
				$GLOBALS['post'] = $right; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				setup_postdata( $right );
				?>
				<div class="col-lg-6 col-xl-3">
					<div class="home1_post_style ulockd-mb30">
						<div class="thumb">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail(
									'large',
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
							eggxi_the_category_badge( 'bgc-thm' );
							?>
						</div>
						<div class="details">
							<a href="<?php echo esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ); ?>" class="post_admin">
								<?php
								printf(
									/* translators: %s: author display name */
									esc_html__( 'By %s', 'eggxi' ),
									esc_html( get_the_author() )
								);
								?>
							</a>
							<?php eggxi_the_post_meta_icons( get_the_ID(), 'thm' ); ?>
							<h4 class="title"><a class="fwb" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28, '&hellip;' ) ); ?></p>
						</div>
					</div>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</div>
</section>
