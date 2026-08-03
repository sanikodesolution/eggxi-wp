<?php
/**
 * Sidebar fallback: Newsletter.
 *
 * @package Eggxi
 */

$shortcode = get_theme_mod( 'eggxi_newsletter_shortcode', '' );
?>
<div class="sidebar_newslatter_widget">
	<?php if ( $shortcode ) : ?>
		<div class="subscriber-form">
			<?php echo do_shortcode( $shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	<?php else : ?>
		<form class="subscriber-form" action="#" method="post" onsubmit="return false;">
			<label class="screen-reader-text" for="eggxi-sidebar-newsletter-email"><?php esc_html_e( 'Email address', 'eggxi' ); ?></label>
			<input id="eggxi-sidebar-newsletter-email" type="email" name="email" placeholder="<?php esc_attr_e( 'Enter Your Email', 'eggxi' ); ?>" required>
			<button type="submit" class="btn bgc-thm"><?php esc_html_e( 'Submit', 'eggxi' ); ?></button>
		</form>
	<?php endif; ?>
</div>
