<?php
/**
 * Single hero slider item.
 *
 * @package Eggxi
 */

$category_name = eggxi_get_post_category_name();
$tag_class     = ( get_the_ID() % 2 === 0 ) ? 'bgc-thm' : 'bgc-orange';
$author_id     = (int) get_the_author_meta( 'ID' );
?>
<div class="item">
	<div class="home1_blog_post">
		<div class="thumb">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail(
					'eggxi-hero',
					array(
						'class'   => 'img-fluid',
						'loading' => 'lazy',
					)
				);
			} else {
				printf(
					'<img class="img-fluid" src="%1$s" alt="%2$s">',
					esc_url( get_template_directory_uri() . '/assets/images/home/slider1.jpg' ),
					esc_attr( get_the_title() )
				);
			}
			?>
			<div class="overlay"></div>
		</div>
		<div class="details">
			<?php if ( $category_name ) : ?>
				<div class="tag <?php echo esc_attr( $tag_class ); ?>"><?php echo esc_html( $category_name ); ?></div>
			<?php endif; ?>
			<h4 class="title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h4>
			<ul class="post_meta ulockd-mb0">
				<li class="list-inline-item">
					<?php echo get_avatar( $author_id, 40, '', get_the_author(), array( 'class' => 'rounded-circle' ) ); ?>
					<span class="ulockd-pl10 fz14"><?php the_author(); ?></span>
				</li>
				<li class="list-inline-item">
					<span class="flaticon-timetable"></span>
					<span class="ulockd-pl10 fz14">
						<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					</span>
				</li>
			</ul>
		</div>
	</div>
</div>
