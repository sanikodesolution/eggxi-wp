<?php
/**
 * Theme footer — Elementor Theme Builder footer location, else Eggxi footer.
 *
 * @package Eggxi
 */

if ( ! eggxi_elementor_location( 'footer' ) ) :
	?>
	<section class="ulockd-footer ulockd-p0">
		<div class="container footer-padding">
			<?php get_template_part( 'template-parts/footer/top', 'bar' ); ?>
			<hr>
			<?php get_template_part( 'template-parts/footer/widgets' ); ?>
			<hr>
			<?php get_template_part( 'template-parts/footer/contact', 'bar' ); ?>
			<hr class="ulockd-mb0">
		</div>
		<?php get_template_part( 'template-parts/footer/copyright' ); ?>
	</section>

	<a class="scrollToHome" href="#"><i class="fas fa-home"></i></a>
	<?php
endif;
?>
</div><!-- .wrapper -->
<?php wp_footer(); ?>
</body>
</html>
