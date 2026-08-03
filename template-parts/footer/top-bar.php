<?php
/**
 * Footer top bar — logo, social icons, payment methods.
 *
 * @package Eggxi
 */

$payment_id = (int) get_theme_mod( 'eggxi_footer_payment_image', 0 );
?>
<div class="row">
	<div class="col-lg-4">
		<?php eggxi_the_footer_logo( true ); ?>
	</div>
	<div class="col-lg-4">
		<div class="font-icon-social text-center">
			<?php eggxi_the_footer_social_icons(); ?>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="payment-card tac-smd">
			<?php
			if ( $payment_id ) {
				echo wp_get_attachment_image(
					$payment_id,
					'medium',
					false,
					array(
						'class' => 'float-end float-right fn-smd',
						'alt'   => esc_attr__( 'Payment methods', 'eggxi' ),
					)
				);
			} else {
				printf(
					'<img class="float-end float-right fn-smd" src="%1$s" alt="%2$s">',
					esc_url( get_template_directory_uri() . '/assets/images/resource/payment.png' ),
					esc_attr__( 'Visa, MasterCard, Amex, PayPal', 'eggxi' )
				);
			}
			?>
		</div>
	</div>
</div>
