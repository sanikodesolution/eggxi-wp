<?php
/**
 * Default page content — Elementor-friendly `the_content()` wrapper.
 *
 * @package Eggxi
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'eggxi-page-content' ); ?>>
	<div class="entry-content">
		<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eggxi' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>
</article>
