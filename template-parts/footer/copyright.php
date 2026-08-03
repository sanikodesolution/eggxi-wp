<?php
/**
 * Footer copyright bar.
 *
 * @package Eggxi
 */

$copyright = get_theme_mod( 'eggxi_footer_copyright', '' );
?>
<div class="ulockd-copy-right">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if ( $copyright ) : ?>
					<p class="color-white"><?php echo wp_kses_post( $copyright ); ?></p>
				<?php else : ?>
					<p class="color-white">
						&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?>
						<?php bloginfo( 'name' ); ?>.
						<?php esc_html_e( 'All rights reserved.', 'eggxi' ); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
