<?php
/**
 * Inner page header / banner.
 *
 * Markup mirrors Eggxi `.ulockd-inner-home` + `.inner-conraimer-details`.
 * Overlay darkening comes from `.ulockd-inner-home:before` in style.css.
 *
 * Usage:
 *   get_template_part( 'template-parts/content', 'page-header' );
 *
 * @package Eggxi
 */

$data = eggxi_get_page_header_data();

if ( empty( $data['title'] ) ) {
	return;
}

$style = sprintf( 'background-image: url(%s);', esc_url( $data['bg_url'] ) );
?>
<div class="ulockd-inner-home" style="<?php echo esc_attr( $style ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="inner-conraimer-details">
					<div class="icd_content">
						<?php if ( ! empty( $data['subtitle_top'] ) ) : ?>
							<p class="fz18"><?php echo esc_html( $data['subtitle_top'] ); ?></p>
						<?php endif; ?>
						<h2 class="title"><?php echo esc_html( $data['title'] ); ?></h2>
						<?php if ( ! empty( $data['subtitle_bottom'] ) ) : ?>
							<p><?php echo esc_html( $data['subtitle_bottom'] ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
