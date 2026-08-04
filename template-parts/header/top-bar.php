<?php
/**
 * Header top bar: Top Nav, notice, social + language area.
 *
 * @package Eggxi
 */
?>
<div class="header-top bgc-ghostwhite">
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<div class="welcm-ht">
					<?php
					if ( has_nav_menu( 'top-nav' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'top-nav',
								'container'      => false,
								'menu_class'     => 'ulockd-mb0',
								'depth'          => 1,
								'fallback_cb'    => false,
								'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'link_before'    => '',
								'link_after'     => '',
								'walker'         => '',
							)
						);
					}
					?>
				</div>
			</div>
			<div class="col-lg-6">
				<?php
				$notice = eggxi_get_header_notice();
				if ( $notice ) :
					?>
					<div class="ht_text_slider text-center">
						<div class="item">
							<p><?php echo wp_kses_post( $notice ); ?></p>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="col-lg-3">
				<div class="header_top_social_widget tac-smd text-end text-right">
					<ul class="ulockd-mb0">
						<?php
						foreach ( eggxi_get_social_networks() as $key => $network ) :
							$url = get_theme_mod( 'eggxi_social_' . $key, '' );
							if ( ! $url ) {
								continue;
							}
							?>
							<li class="list-inline-item">
								<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $network['label'] ); ?>">
									<i class="<?php echo esc_attr( $network['icon'] . ' ' . $network['class'] ); ?>"></i>
								</a>
							</li>
						<?php endforeach; ?>

						<?php if ( get_theme_mod( 'eggxi_show_lang_switcher', true ) ) : ?>
							<li class="list-inline-item">
								<div class="dropdown lang-button text-center">
									<?php
									/**
									 * Hook for Polylang / WPML / custom language switcher markup.
									 * Falls back to a static Lang label if nothing is printed.
									 */
									ob_start();
									do_action( 'eggxi_language_switcher' );
									$lang_html = trim( ob_get_clean() );

									if ( $lang_html ) {
										echo $lang_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									} else {
										// No Polylang/WPML output yet — show label only (no empty 85px popup).
										?>
										<button
											class="dropbtn"
											type="button"
											aria-haspopup="false"
											title="<?php esc_attr_e( 'Install Polylang or WPML to enable languages.', 'eggxi' ); ?>"
										>
											<i class="fas fa-globe-americas text-thm" aria-hidden="true"></i>
											<?php esc_html_e( 'Lang', 'eggxi' ); ?>
										</button>
										<?php
									}
									?>
								</div>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
