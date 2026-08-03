<?php
/**
 * Card: home1_post_style (carousel / 2-column grid).
 *
 * @package Eggxi
 */

$eggxi_extra_class = isset( $args['extra_class'] ) ? $args['extra_class'] : 'ulockd-mb40';
?>
<div class="home1_post_style <?php echo esc_attr( $eggxi_extra_class ); ?>">
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
