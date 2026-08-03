<?php
/**
 * Footer contact quick bar — Mail / Call / Find Us.
 *
 * @package Eggxi
 */

$email   = get_theme_mod( 'eggxi_footer_email', 'dummy@yourmail.com' );
$phone   = get_theme_mod( 'eggxi_footer_phone', '+99-55-66-88-526' );
$address = get_theme_mod( 'eggxi_footer_address', 'Victoria 8007 Australia HQ 121 King Street, Melbourne.' );

if ( function_exists( 'get_field' ) ) {
	$acf_email = get_field( 'footer_email', 'option' );
	$acf_phone = get_field( 'footer_phone', 'option' );
	$acf_addr  = get_field( 'footer_address', 'option' );
	if ( is_string( $acf_email ) && $acf_email ) {
		$email = $acf_email;
	}
	if ( is_string( $acf_phone ) && $acf_phone ) {
		$phone = $acf_phone;
	}
	if ( is_string( $acf_addr ) && $acf_addr ) {
		$address = $acf_addr;
	}
}

$phone_href = preg_replace( '/[^0-9\+]/', '', (string) $phone );
?>
<div class="row">
	<div class="col-sm-4 col-lg-4">
		<div class="mail-widget text-center">
			<span class="icon fas fa-envelope"></span>
			<h4 class="title"><?php esc_html_e( 'Mail Us', 'eggxi' ); ?></h4>
			<p>
				<?php if ( $email ) : ?>
					<a href="<?php echo esc_url( 'mailto:' . antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a>
				<?php endif; ?>
			</p>
		</div>
	</div>
	<div class="col-sm-4 col-lg-4">
		<div class="call-widget text-center">
			<span class="icon fas fa-phone"></span>
			<h4 class="title"><?php esc_html_e( 'Call Us', 'eggxi' ); ?></h4>
			<p>
				<?php if ( $phone ) : ?>
					<a href="<?php echo esc_url( 'tel:' . $phone_href ); ?>"><?php echo esc_html( $phone ); ?></a>
				<?php endif; ?>
			</p>
		</div>
	</div>
	<div class="col-sm-4 col-lg-4">
		<div class="location-widget text-center">
			<span class="icon fas fa-map-signs"></span>
			<h4 class="title"><?php esc_html_e( 'Find Us', 'eggxi' ); ?></h4>
			<p><?php echo esc_html( $address ); ?></p>
		</div>
	</div>
</div>
