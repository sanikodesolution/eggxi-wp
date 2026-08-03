<?php
/**
 * Main navigation: Bootsnav primary menu, search, off-canvas (no cart).
 *
 * @package Eggxi
 */
?>
<header class="header-nav main-navigation">
	<div class="main-header-nav navbar-scrolltofixed bgc-ghostwhite">
		<div class="container ulockd-p0">
			<nav class="navbar bootsnav navbar-expand-lg navbar-light menu-style1 bgc-ghostwhite" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'eggxi' ); ?>">
				<div class="top-search bgc-thm">
					<div class="container">
						<form role="search" method="get" class="input-group search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<span class="input-group-addon"><i class="fas fa-search"></i></span>
							<input type="search" class="form-control" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'eggxi' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
							<span class="input-group-addon close-search"><i class="fas fa-times color-white"></i></span>
						</form>
					</div>
				</div>

				<div class="container ulockd-p0">
					<div class="navbar-header">
						<button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'eggxi' ); ?>">
							<i class="navbar-toggler-icon fas fa-bars"></i>
						</button>
					</div>

					<div class="collapse navbar-collapse" id="navbar-menu">
						<?php
						if ( has_nav_menu( 'primary' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'container'      => false,
									'menu_class'     => 'nav navbar-nav navbar-left',
									'menu_id'        => 'primary-menu',
									'depth'          => 3,
									'fallback_cb'    => false,
									'walker'         => new Eggxi_Nav_Walker(),
									'items_wrap'     => '<ul id="%1$s" class="%2$s" data-in="fadeIn">%3$s</ul>',
								)
							);
						}
						?>
					</div>

					<div class="attr-nav">
						<ul>
							<li class="search"><a href="#" aria-label="<?php esc_attr_e( 'Open search', 'eggxi' ); ?>"><i class="fas fa-search"></i></a></li>
							<li class="side-menu"><a href="#" aria-label="<?php esc_attr_e( 'Open side menu', 'eggxi' ); ?>"><i class="fas fa-bars"></i></a></li>
						</ul>
					</div>
				</div>

				<div class="side bgc-thm">
					<a href="#" class="close-side" aria-label="<?php esc_attr_e( 'Close side menu', 'eggxi' ); ?>"><i class="fas fa-times"></i></a>
					<div class="widget">
						<h5 class="title"><?php esc_html_e( 'Menu', 'eggxi' ); ?></h5>
						<?php
						$offcanvas_location = has_nav_menu( 'offcanvas' ) ? 'offcanvas' : ( has_nav_menu( 'primary' ) ? 'primary' : '' );
						if ( $offcanvas_location ) {
							wp_nav_menu(
								array(
									'theme_location' => $offcanvas_location,
									'container'      => false,
									'menu_class'     => 'link',
									'depth'          => 1,
									'fallback_cb'    => false,
								)
							);
						}
						?>
					</div>
					<div class="widget">
						<ul class="footer-font-icon ulockd-mt20">
							<?php
							foreach ( eggxi_get_social_networks() as $key => $network ) :
								$url = get_theme_mod( 'eggxi_social_' . $key, '' );
								if ( ! $url ) {
									continue;
								}
								?>
								<li class="list-inline-item">
									<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $network['label'] ); ?>">
										<i class="<?php echo esc_attr( $network['icon'] ); ?>"></i>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</nav>
		</div>
	</div>
</header>
