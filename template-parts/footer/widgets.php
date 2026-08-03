<?php
/**
 * Footer multi-column widget grid.
 *
 * @package Eggxi
 */
?>
<div class="row">
	<div class="col-sm-6 col-lg-3">
		<?php
		if ( is_active_sidebar( 'footer-1' ) ) {
			dynamic_sidebar( 'footer-1' );
		} else {
			get_template_part( 'template-parts/footer/col', 'about' );
		}
		?>
	</div>
	<div class="col-sm-6 col-lg-3">
		<?php
		if ( is_active_sidebar( 'footer-2' ) ) {
			dynamic_sidebar( 'footer-2' );
		} else {
			get_template_part( 'template-parts/footer/col', 'twitter' );
		}
		?>
	</div>
	<div class="col-sm-6 col-lg-3">
		<?php
		if ( is_active_sidebar( 'footer-3' ) ) {
			dynamic_sidebar( 'footer-3' );
		} else {
			get_template_part( 'template-parts/footer/col', 'news' );
		}
		?>
	</div>
	<div class="col-sm-6 col-lg-3">
		<?php
		if ( is_active_sidebar( 'footer-4' ) ) {
			dynamic_sidebar( 'footer-4' );
		} else {
			get_template_part( 'template-parts/footer/col', 'links' );
		}
		?>
	</div>
</div>
