<?php
/**
 * Blog grid loop section (3 columns).
 *
 * Expects the main query or a custom $eggxi_grid_query in scope via $args['query'].
 *
 * @package Eggxi
 */

$query = null;
if ( ! empty( $args['query'] ) && $args['query'] instanceof WP_Query ) {
	$query = $args['query'];
}

$use_main = ( null === $query );
?>
<section class="inner-page-blog-post ulockd-pb50">
	<div class="container">
		<div class="row">
			<?php
			$i = 0;
			if ( $use_main ) :
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						$i++;
						?>
						<div class="col-6 col-md-6 col-lg-4">
							<?php
							get_template_part(
								'template-parts/content',
								'grid',
								array( 'wow' => 300 + ( ( $i - 1 ) % 6 ) * 200 )
							);
							?>
						</div>
						<?php
					endwhile;
				else :
					?>
					<div class="col-12">
						<?php get_template_part( 'template-parts/content', 'none' ); ?>
					</div>
					<?php
				endif;
			else :
				if ( $query->have_posts() ) :
					while ( $query->have_posts() ) :
						$query->the_post();
						$i++;
						?>
						<div class="col-6 col-md-6 col-lg-4">
							<?php
							get_template_part(
								'template-parts/content',
								'grid',
								array( 'wow' => 300 + ( ( $i - 1 ) % 6 ) * 200 )
							);
							?>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<div class="col-12">
						<?php get_template_part( 'template-parts/content', 'none' ); ?>
					</div>
					<?php
				endif;
			endif;
			?>
		</div>

		<?php
		$max_pages = $use_main ? (int) $GLOBALS['wp_query']->max_num_pages : (int) $query->max_num_pages;
		$current   = max( 1, (int) ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 ) ) );

		if ( $max_pages > 1 ) :
			?>
			<div class="row">
				<div class="col-lg-12">
					<nav class="eggxi-pagination text-center ulockd-mt30" aria-label="<?php esc_attr_e( 'Posts pagination', 'eggxi' ); ?>">
						<?php
						if ( $use_main ) {
							the_posts_pagination(
								array(
									'mid_size'  => 2,
									'prev_text' => '&laquo;',
									'next_text' => '&raquo;',
								)
							);
						} else {
							echo wp_kses_post(
								paginate_links(
									array(
										'total'     => $max_pages,
										'current'   => $current,
										'prev_text' => '&laquo;',
										'next_text' => '&raquo;',
										'type'      => 'list',
									)
								)
							);
						}
						?>
					</nav>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
