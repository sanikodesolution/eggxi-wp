<?php
/**
 * Compact recent/latest list row (.media inside .recent_latest_post).
 *
 * @package Eggxi
 */

$eggxi_is_last = ! empty( $args['is_last'] );
$wrap_class    = $eggxi_is_last ? 'media' : 'media ulockd-mb30';

$thumb = '';
if ( has_post_thumbnail() ) {
	$thumb = get_the_post_thumbnail(
		get_the_ID(),
		'thumbnail',
		array(
			'class' => 'me-3 mr-3',
			'alt'   => the_title_attribute( array( 'echo' => false ) ),
		)
	);
} else {
	$thumb = sprintf(
		'<img class="me-3 mr-3" src="%1$s" alt="%2$s">',
		esc_url( get_template_directory_uri() . '/assets/images/blog/s1.jpg' ),
		esc_attr( get_the_title() )
	);
}

$term = eggxi_get_primary_category();
?>
<div class="<?php echo esc_attr( $wrap_class ); ?>">
	<?php echo $thumb; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div class="media-body">
		<?php if ( $term ) : ?>
			<span class="tag bgc-thm color-white"><?php echo esc_html( $term->name ); ?></span>
		<?php endif; ?>
		<h5 class="title"><a class="fwb" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
		<a class="post_date" href="<?php the_permalink(); ?>">
			<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		</a>
	</div>
</div>
