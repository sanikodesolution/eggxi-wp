<?php
/**
 * Footer column 2 fallback — Twitter Feed.
 *
 * @package Eggxi
 */

$embed = get_theme_mod( 'eggxi_footer_twitter_embed', '' );
if ( ! $embed && function_exists( 'get_field' ) ) {
	$acf = get_field( 'footer_twitter_embed', 'option' );
	if ( is_string( $acf ) && $acf ) {
		$embed = $acf;
	}
}
?>
<div class="footer-twitter-widget">
	<h4 class="title"><?php esc_html_e( 'Twitter Feed', 'eggxi' ); ?></h4>
	<?php if ( $embed ) : ?>
		<div class="twitter">
			<?php echo do_shortcode( $embed ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	<?php else : ?>
		<div class="twitter">
			<p class="small mb-0">
				<?php
				printf(
					/* translators: %s: Customizer path */
					esc_html__( 'Add a Twitter embed in Appearance → Customize → Footer, or drop a widget into Footer Column 2.', 'eggxi' )
				);
				?>
			</p>
		</div>
	<?php endif; ?>
</div>
