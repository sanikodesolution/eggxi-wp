<?php
/**
 * Mobile mmenu shell using Primary Menu.
 *
 * @package Eggxi
 */
?>
<div id="page" class="stylehome1">
	<div class="mobile-menu">
		<div class="header stylehome1">
			<div class="main_logo_home2">
				<?php
				if ( has_custom_logo() ) {
					$logo_id = get_theme_mod( 'custom_logo' );
					echo wp_get_attachment_image(
						$logo_id,
						'full',
						false,
						array(
							'class' => 'nav_logo_img dn-md img-fluid ulockd-mt20',
							'alt'   => get_bloginfo( 'name', 'display' ),
						)
					);
				} else {
					printf(
						'<a class="nav_logo_img dn-md img-fluid ulockd-mt20 site-title" href="%1$s">%2$s</a>',
						esc_url( home_url( '/' ) ),
						esc_html( get_bloginfo( 'name' ) )
					);
				}
				?>
			</div>
			<ul class="menu_bar_home2">
				<li class="list-inline-item"></li>
				<li class="list-inline-item"><a href="#menu" aria-label="<?php esc_attr_e( 'Open mobile menu', 'eggxi' ); ?>"><span></span></a></li>
			</ul>
		</div>
	</div>

	<nav id="menu" class="stylehome1" aria-label="<?php esc_attr_e( 'Mobile Menu', 'eggxi' ); ?>">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => '',
					'depth'          => 3,
					'fallback_cb'    => false,
					'items_wrap'     => '<ul>%3$s</ul>',
				)
			);
		}
		?>
	</nav>
</div>
