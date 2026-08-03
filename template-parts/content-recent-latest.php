<?php
/**
 * Recent And Latest section.
 *
 * Layout: 1 featured (.home1_post_style) + 2 columns of 4 list items (.recent_latest_post).
 * Preserves decorative background: .fasion_blog_post.ulockd_bgp7
 *
 * @package Eggxi
 */

$query = eggxi_get_recent_latest_query( 9 );

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

$posts     = array_values( $posts );
$featured  = isset( $posts[0] ) ? $posts[0] : null;
$list_a    = array_slice( $posts, 1, 4 );
$list_b    = array_slice( $posts, 5, 4 );
$title     = eggxi_get_section_title( 'eggxi_recent_latest_title', __( 'Recent And Latest', 'eggxi' ), 'recent_latest_title' );
?>
<section class="fasion_blog_post ulockd_bgp7 ulockd-pb50">
	<div class="container">
		<div class="row">
			<div class="col-xl-6 offset-xl-3 text-center">
				<div class="main-title">
					<h2 class="title"><span><?php echo esc_html( $title ); ?></span></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<?php if ( $featured ) : ?>
				<?php
				$GLOBALS['post'] = $featured; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				setup_postdata( $featured );
				?>
				<div class="col-xl-4">
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
							<h5 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
						</div>
					</div>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>

			<?php if ( ! empty( $list_a ) ) : ?>
				<div class="col-md-6 col-lg-6 col-xl-4">
					<div class="recent_latest_post">
						<?php
						$total_a = count( $list_a );
						$i       = 0;
						foreach ( $list_a as $post ) :
							$i++;
							$GLOBALS['post'] = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
							setup_postdata( $post );
							get_template_part(
								'template-parts/cards/recent',
								'list-item',
								array( 'is_last' => ( $i === $total_a ) )
							);
						endforeach;
						wp_reset_postdata();
						?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $list_b ) ) : ?>
				<div class="col-md-6 col-lg-6 col-xl-4">
					<div class="recent_latest_post">
						<?php
						$total_b = count( $list_b );
						$i       = 0;
						foreach ( $list_b as $post ) :
							$i++;
							$GLOBALS['post'] = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
							setup_postdata( $post );
							get_template_part(
								'template-parts/cards/recent',
								'list-item',
								array( 'is_last' => ( $i === $total_b ) )
							);
						endforeach;
						wp_reset_postdata();
						?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
