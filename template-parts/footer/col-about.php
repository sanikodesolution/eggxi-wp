<?php
/**
 * Footer column 1 fallback — About Us + Newsletter.
 *
 * @package Eggxi
 */

$about = get_theme_mod( 'eggxi_footer_bio', '' );
if ( '' === trim( wp_strip_all_tags( (string) $about ) ) && function_exists( 'get_field' ) ) {
	$acf = get_field( 'footer_bio', 'option' );
	if ( is_string( $acf ) && '' !== trim( wp_strip_all_tags( $acf ) ) ) {
		$about = $acf;
	}
}
if ( '' === trim( wp_strip_all_tags( (string) $about ) ) ) {
	$about = __( 'Regardless of whether you need to stay in your own house, are searching for help with a more established relative, looking for exhortation on paying for development, we can help you.', 'eggxi' );
}

$subscribe = get_theme_mod( 'eggxi_footer_subscribe_shortcode', '' );
if ( ! $subscribe ) {
	$subscribe = get_theme_mod( 'eggxi_newsletter_shortcode', '' );
}
?>
<div class="footer-about-widget">
	<h4 class="title"><?php esc_html_e( 'About Us', 'eggxi' ); ?></h4>
	<p><?php echo wp_kses_post( $about ); ?></p>
</div>
<div class="footer-newsletter-widget">
	<h4 class="title"><?php esc_html_e( 'News Letter', 'eggxi' ); ?></h4>
	<?php if ( $subscribe ) : ?>
		<div class="ulockd-mailchimp">
			<?php echo do_shortcode( $subscribe ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	<?php elseif ( shortcode_exists( 'mc4wp_form' ) ) : ?>
		<div class="ulockd-mailchimp">
			<?php echo do_shortcode( '[mc4wp_form]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	<?php else : ?>
		<form class="ulockd-mailchimp" action="#" method="post" onsubmit="return false;">
			<div class="input-group">
				<input type="email" class="form-control input-md" placeholder="<?php esc_attr_e( 'Your email', 'eggxi' ); ?>" name="EMAIL" value="" required>
				<span class="input-group-btn">
					<button type="submit" class="btn btn-md" aria-label="<?php esc_attr_e( 'Subscribe', 'eggxi' ); ?>">
						<i class="icon fas fa-chevron-right"></i>
					</button>
				</span>
			</div>
		</form>
	<?php endif; ?>
</div>
