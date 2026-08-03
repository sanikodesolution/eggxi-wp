<?php
/**
 * Single post content — media, article, tags/share.
 *
 * @package Eggxi
 */

$permalink     = get_permalink();
$encoded_url   = rawurlencode( $permalink );
$encoded_title = rawurlencode( get_the_title() );

$gallery_ids = array();
if ( has_block( 'gallery', get_post() ) ) {
	$blocks = parse_blocks( get_the_content() );
	foreach ( $blocks as $block ) {
		if ( 'core/gallery' === $block['blockName'] && ! empty( $block['attrs']['ids'] ) ) {
			$gallery_ids = array_map( 'absint', $block['attrs']['ids'] );
			break;
		}
	}
}
if ( empty( $gallery_ids ) ) {
	$attachments = get_attached_media( 'image', get_the_ID() );
	if ( $attachments && count( $attachments ) > 1 ) {
		$gallery_ids = wp_list_pluck( $attachments, 'ID' );
	}
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog_single_post_wrap' ); ?>>
	<div class="row">
		<div class="col-lg-12">
			<?php if ( ! empty( $gallery_ids ) && count( $gallery_ids ) > 1 ) : ?>
				<div class="img_post_slider ulockd-mb20">
					<?php foreach ( $gallery_ids as $image_id ) : ?>
						<div class="item">
							<div class="blog_single_post">
								<div class="thumb">
									<?php
									echo wp_get_attachment_image(
										$image_id,
										'large',
										false,
										array( 'class' => 'img-whp' )
									);
									?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php elseif ( has_post_thumbnail() ) : ?>
				<div class="img_post_slider ulockd-mb20">
					<div class="item">
						<div class="blog_single_post">
							<div class="thumb">
								<?php
								the_post_thumbnail(
									'large',
									array( 'class' => 'img-whp' )
								);
								?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="bsp_content">
				<?php the_content(); ?>
				<?php
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eggxi' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>
		</div>

		<div class="col-lg-12">
			<div class="bsp_social_share">
				<p>
					<?php
					the_tags( 'Tag: ', ', ' );
					?>
				</p>
				<ul class="ulockd-mb0 text-end text-right">
					<li class="list-inline-item">
						<a class="color-fb" href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on Facebook', 'eggxi' ); ?>">
							<i class="fab fa-facebook"></i>
						</a>
					</li>
					<li class="list-inline-item">
						<a class="color-twtr" href="<?php echo esc_url( 'https://twitter.com/intent/tweet?url=' . $encoded_url . '&text=' . $encoded_title ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on Twitter', 'eggxi' ); ?>">
							<i class="fab fa-twitter"></i>
						</a>
					</li>
					<li class="list-inline-item">
						<a class="color-pint" href="<?php echo esc_url( 'https://pinterest.com/pin/create/button/?url=' . $encoded_url . '&description=' . $encoded_title ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on Pinterest', 'eggxi' ); ?>">
							<i class="fab fa-pinterest"></i>
						</a>
					</li>
					<li class="list-inline-item">
						<a class="color-lnkdn" href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . $encoded_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'eggxi' ); ?>">
							<i class="fab fa-linkedin-in"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</article>
