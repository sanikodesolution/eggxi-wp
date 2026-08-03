<?php
/**
 * Card: home1_blog_post style5 (3-column bottom cards).
 *
 * @package Eggxi
 */

$eggxi_show_explore = ! empty( $args['show_explore'] );
$img                = eggxi_get_post_image_url( 'large' );
?>
<div class="home1_blog_post style5 ulockd-mb40">
	<div class="thumb bgsz-cover" style="background-image: url(<?php echo esc_url( $img ); ?>);">
		<div class="overlay"></div>
		<?php if ( $eggxi_show_explore ) : ?>
			<a href="<?php the_permalink(); ?>" class="btn btn-thm readmore-btn"><?php esc_html_e( 'Explore', 'eggxi' ); ?></a>
		<?php endif; ?>
	</div>
	<div class="details">
		<?php eggxi_the_category_badge( 'bgc-thm' ); ?>
		<h4 class="title"><a class="fw500" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		<?php eggxi_the_post_meta_icons( get_the_ID(), 'default', false ); ?>
	</div>
</div>
