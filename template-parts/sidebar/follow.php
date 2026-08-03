<?php
/**
 * Sidebar fallback: Follow Us.
 *
 * @package Eggxi
 */

$networks = array(
	'facebook'  => array(
		'label' => __( 'Facebook', 'eggxi' ),
		'class' => 'bgc-fb',
		'url'   => get_theme_mod( 'eggxi_social_facebook', '' ),
	),
	'twitter'   => array(
		'label' => __( 'Twitter', 'eggxi' ),
		'class' => 'bgc-twtr',
		'url'   => get_theme_mod( 'eggxi_social_twitter', '' ),
	),
	'pinterest' => array(
		'label' => __( 'Pinterest', 'eggxi' ),
		'class' => 'bgc-pint',
		'url'   => get_theme_mod( 'eggxi_social_pinterest', '' ),
	),
	'youtube'   => array(
		'label' => __( 'Youtube', 'eggxi' ),
		'class' => 'bgc-utube',
		'url'   => get_theme_mod( 'eggxi_social_youtube', '' ),
	),
	'linkedin'  => array(
		'label' => __( 'LinkedIn', 'eggxi' ),
		'class' => 'bgc-lnkdn',
		'url'   => get_theme_mod( 'eggxi_social_linkedin', '' ),
	),
	'instagram' => array(
		'label' => __( 'Instagram', 'eggxi' ),
		'class' => 'bgc-inst',
		'url'   => get_theme_mod( 'eggxi_social_instagram', '' ),
	),
);

$has_any = false;
foreach ( $networks as $network ) {
	if ( ! empty( $network['url'] ) ) {
		$has_any = true;
		break;
	}
}
if ( ! $has_any ) {
	return;
}
?>
<div class="sidebar_follow_widget">
	<h4 class="saw_title"><?php esc_html_e( 'Follow Us', 'eggxi' ); ?></h4>
	<ul class="sfw_social_widget">
		<?php foreach ( $networks as $network ) : ?>
			<?php if ( empty( $network['url'] ) ) : ?>
				<?php continue; ?>
			<?php endif; ?>
			<li class="list-inline-item <?php echo esc_attr( $network['class'] ); ?> text-center">
				<a href="<?php echo esc_url( $network['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $network['label'] ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
