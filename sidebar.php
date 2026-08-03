<?php
/**
 * Primary Sidebar.
 *
 * Front page uses desktop + mobile panel shells; other views use `.home_sidebar`.
 *
 * @package Eggxi
 */

if ( is_front_page() && ! is_home() ) :
	?>
	<div class="blog-sidebar-home dn-lg">
		<?php eggxi_render_main_sidebar_inner(); ?>
	</div>
	<div class="blog_sidebar_panel bgc-white dn db-lg">
		<button type="button" class="btn btn-thm blog_sidebar_pp_button mb20-lg" aria-label="<?php esc_attr_e( 'Close sidebar', 'eggxi' ); ?>">
			<i class="fas fa-times fz20"></i>
		</button>
		<div class="home_sidebar">
			<?php eggxi_render_main_sidebar_inner(); ?>
		</div>
	</div>
	<?php
else :
	?>
	<div class="home_sidebar">
		<?php eggxi_render_main_sidebar_inner(); ?>
	</div>
	<?php
endif;
