<?php
/**
 * Featured Post grid section (exact Eggxi HTML structure).
 *
 * Layout:
 * - [0] Big left card  (.home1_blog_post.style2)
 * - [1] Middle tall    (.home1_blog_post.style3)
 * - [2]+[3] Right stack (.home1_blog_post.style4)
 *
 * @package Eggxi
 */

$featured = eggxi_get_featured_grid_query();

if ( ! $featured->have_posts() ) {
	return;
}

$posts = array();
while ( $featured->have_posts() ) {
	$featured->the_post();
	eggxi_remember_displayed_post( get_the_ID() );
	$posts[] = get_post();
}
wp_reset_postdata();

$posts = array_values( $posts );

if ( count( $posts ) < 1 ) {
	return;
}

$section_title = get_theme_mod( 'eggxi_featured_section_title', __( 'Featured Post', 'eggxi' ) );
if ( '' === trim( (string) $section_title ) ) {
	$section_title = __( 'Featured Post', 'eggxi' );
}
?>
<section class="feature_blog_post bgc-aliceblue">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<div class="main-title text-center">
					<h2 class="title"><span><?php echo esc_html( $section_title ); ?></span></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<?php
			// —— First post: big left card ——
			if ( ! empty( $posts[0] ) ) :
				$post = $posts[0];
				$GLOBALS['post'] = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				setup_postdata( $post );
				$img = eggxi_get_post_image_url( 'large', $post->ID );
				?>
				<div class="col-xl-6">
					<div class="home1_blog_post style2 mb30-lg">
						<div class="thumb" style="background-image: url(<?php echo esc_url( $img ); ?>);">
							<div class="overlay"></div>
						</div>
						<div class="details">
							<?php eggxi_the_category_badge( 'bgc-thm', $post->ID ); ?>
							<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<ul class="post_meta ulockd-mb0">
								<li class="list-inline-item">
									<?php
									echo get_avatar(
										(int) get_the_author_meta( 'ID' ),
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
			<?php endif; ?>

			<?php
			// —— Second post: middle tall card ——
			if ( ! empty( $posts[1] ) ) :
				$post = $posts[1];
				$GLOBALS['post'] = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				setup_postdata( $post );
				$img = eggxi_get_post_image_url( 'large', $post->ID );
				?>
				<div class="col-md-6 col-xl-3">
					<div class="home1_blog_post style3 mb30-sm">
						<div class="thumb bgsz-cover" style="background-image: url(<?php echo esc_url( $img ); ?>);">
							<div class="overlay"></div>
						</div>
						<div class="details">
							<?php eggxi_the_category_badge( 'bgc-thm', $post->ID ); ?>
							<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<?php eggxi_the_post_meta_icons( $post->ID ); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $posts[2] ) || ! empty( $posts[3] ) ) : ?>
				<div class="col-md-6 col-xl-3">
					<?php
					// —— Third post: top of right stack ——
					if ( ! empty( $posts[2] ) ) :
						$post = $posts[2];
						$GLOBALS['post'] = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
						setup_postdata( $post );
						$img = eggxi_get_post_image_url( 'medium_large', $post->ID );
						?>
						<div class="home1_blog_post style4 ulockd-mb30">
							<div class="thumb bgsz-cover" style="background-image: url(<?php echo esc_url( $img ); ?>);">
								<div class="overlay"></div>
							</div>
							<div class="details">
								<?php eggxi_the_category_badge( 'bgc-thm', $post->ID ); ?>
								<h5 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
								<?php eggxi_the_post_meta_icons( $post->ID ); ?>
							</div>
						</div>
					<?php endif; ?>

					<?php
					// —— Fourth post: bottom of right stack ——
					if ( ! empty( $posts[3] ) ) :
						$post = $posts[3];
						$GLOBALS['post'] = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
						setup_postdata( $post );
						$img = eggxi_get_post_image_url( 'medium_large', $post->ID );
						?>
						<div class="home1_blog_post style4">
							<div class="thumb bgsz-cover" style="background-image: url(<?php echo esc_url( $img ); ?>);">
								<div class="overlay"></div>
							</div>
							<div class="details">
								<?php eggxi_the_category_badge( 'bgc-thm', $post->ID ); ?>
								<h5 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
								<?php eggxi_the_post_meta_icons( $post->ID ); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php
wp_reset_postdata();
