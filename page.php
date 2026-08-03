<?php
/**
 * Page template — Elementor-ready.
 *
 * @package Eggxi
 */

get_header();

// Theme Builder Single template takes over when assigned.
if ( ! eggxi_elementor_location( 'single' ) ) :
	$is_elementor = eggxi_is_built_with_elementor();

	if ( ! $is_elementor ) {
		get_template_part( 'template-parts/content', 'page-header' );
	}
	?>
	<main id="primary" class="site-main<?php echo $is_elementor ? ' eggxi-elementor-content' : ''; ?>">
		<?php if ( ! $is_elementor ) : ?>
			<div class="container ulockd-pb50">
		<?php endif; ?>

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'page' );
		endwhile;
		?>

		<?php if ( ! $is_elementor ) : ?>
			</div>
		<?php endif; ?>
	</main>
	<?php
endif;

get_footer();
