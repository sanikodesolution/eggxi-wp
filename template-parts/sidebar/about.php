<?php
/**
 * Sidebar fallback: About / Author card.
 *
 * On single posts prefers the post author; otherwise Customizer about fields.
 *
 * @package Eggxi
 */

$is_single = is_singular( 'post' );

if ( $is_single ) {
	$author_id = (int) get_the_author_meta( 'ID' );
	$name      = get_the_author();
	$bio       = get_the_author_meta( 'description', $author_id );
	$avatar    = get_avatar( $author_id, 200, '', $name, array( 'class' => 'img-fluid' ) );
} else {
	$name = get_theme_mod( 'eggxi_about_name', '' );
	$bio  = get_theme_mod( 'eggxi_about_bio', '' );
	$img  = (int) get_theme_mod( 'eggxi_about_image', 0 );

	if ( '' === $name ) {
		$name = get_bloginfo( 'name' );
	}
	if ( '' === trim( wp_strip_all_tags( (string) $bio ) ) ) {
		$bio = get_bloginfo( 'description', 'display' );
	}

	if ( $img ) {
		$avatar = wp_get_attachment_image( $img, 'medium', false, array( 'class' => 'img-fluid' ) );
	} else {
		$avatar = sprintf(
			'<img class="img-fluid" src="%1$s" alt="%2$s">',
			esc_url( get_template_directory_uri() . '/assets/images/blog/i3.jpg' ),
			esc_attr( $name )
		);
	}
}

if ( ! $bio ) {
	$bio = __( 'Welcome to our blog. Follow along for the latest stories and updates.', 'eggxi' );
}

$about_socials = array(
	'facebook'  => array( 'icon' => 'fab fa-facebook-f', 'url' => get_theme_mod( 'eggxi_social_facebook', '' ) ),
	'twitter'   => array( 'icon' => 'fab fa-twitter', 'url' => get_theme_mod( 'eggxi_social_twitter', '' ) ),
	'linkedin'  => array( 'icon' => 'fab fa-linkedin', 'url' => get_theme_mod( 'eggxi_social_linkedin', '' ) ),
	'pinterest' => array( 'icon' => 'fab fa-pinterest', 'url' => get_theme_mod( 'eggxi_social_pinterest', '' ) ),
	'youtube'   => array( 'icon' => 'fab fa-youtube', 'url' => get_theme_mod( 'eggxi_social_youtube', '' ) ),
);
?>
<div class="sidebar_about_widget">
	<h4 class="saw_title"><?php echo $is_single ? esc_html__( 'About Author', 'eggxi' ) : esc_html__( 'About us', 'eggxi' ); ?></h4>
	<div class="thumb"><?php echo $avatar; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
	<p><?php echo wp_kses_post( $bio ); ?></p>
	<h5 class="name_title"><?php echo esc_html( $name ); ?></h5>
	<ul class="asw_social_widget ulockd-mb0">
		<?php foreach ( $about_socials as $network ) : ?>
			<?php if ( empty( $network['url'] ) ) : ?>
				<?php continue; ?>
			<?php endif; ?>
			<li class="list-inline-item">
				<a href="<?php echo esc_url( $network['url'] ); ?>" target="_blank" rel="noopener noreferrer">
					<i class="<?php echo esc_attr( $network['icon'] ); ?>"></i>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
