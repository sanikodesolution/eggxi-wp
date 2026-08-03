<?php
/**
 * Blog grid card — Eggxi `.blog-post` (3-column grid).
 *
 * @package Eggxi
 */

$wow_ms = isset( $args['wow'] ) ? absint( $args['wow'] ) : 300;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post ulockd-mb30 text-left wow fadeInUp' ); ?> data-wow-duration="<?php echo esc_attr( $wow_ms . 'ms' ); ?>">
	<div class="post-thumb">
		<a href="<?php the_permalink(); ?>">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail(
					'medium_large',
					array(
						'class'   => 'img-whp',
						'loading' => 'lazy',
					)
				);
			} else {
				printf(
					'<img class="img-whp" src="%1$s" alt="%2$s">',
					esc_url( get_template_directory_uri() . '/assets/images/blog/1.jpg' ),
					esc_attr( get_the_title() )
				);
			}
			?>
		</a>
		<div class="post_date bgc-white text-thm">
			<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
				<?php echo esc_html( get_the_date( 'j M' ) ); ?>
			</time>
		</div>
	</div>
	<div class="bp-details">
		<h5 class="post-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h5>
		<ul>
			<li class="list-inline-item">
				<a href="<?php echo esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ); ?>">
					<span class="icon-Administrator text-thm"></span>
					<?php
					printf(
						/* translators: %s: author name */
						esc_html__( 'By %s', 'eggxi' ),
						esc_html( get_the_author() )
					);
					?>
				</a>
			</li>
			<li class="list-inline-item">
				<a href="<?php comments_link(); ?>">
					<span class="icon-Speach-Bubble2 text-thm"></span>
					<?php
					$comments = (int) get_comments_number();
					printf(
						/* translators: %s: comment count */
						esc_html( _n( '%s Comment', '%s Comments', $comments, 'eggxi' ) ),
						esc_html( number_format_i18n( $comments ) )
					);
					?>
				</a>
			</li>
			<li class="list-inline-item">
				<span class="icon-Heart text-thm"></span>
				<?php echo esc_html( number_format_i18n( eggxi_get_like_count() ) ); ?>
			</li>
		</ul>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, '&hellip;' ) ); ?></p>
		<a href="<?php the_permalink(); ?>" class="btn btn-default btn-thm">
			<?php esc_html_e( 'Read More', 'eggxi' ); ?>
		</a>
	</div>
</article>
