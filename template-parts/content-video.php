<?php
/**
 * Video post format — Eggxi `.ulockd-project-sm-thumb` embed header.
 *
 * Priority: ACF/meta URL → first content embed → featured image.
 *
 * @package Eggxi
 */

$permalink     = get_permalink();
$encoded_url   = rawurlencode( $permalink );
$encoded_title = rawurlencode( get_the_title() );
$video         = eggxi_get_post_video_embed();
$has_video     = ( '' !== $video['html'] );
$body_content  = '';

if ( $has_video ) {
	$filtered = ( 'content' === $video['source'] && $video['content'] )
		? $video['content']
		: apply_filters( 'the_content', get_the_content() );

	$body_content = eggxi_strip_video_embed_from_content( $filtered, $video['html'] );

	// Also strip any other first-party embeds so ACF header isn't duplicated from the body.
	$other_media = get_media_embedded_in_content(
		$body_content,
		array( 'video', 'object', 'embed', 'iframe' )
	);
	if ( ! empty( $other_media[0] ) ) {
		$body_content = eggxi_strip_video_embed_from_content( $body_content, $other_media[0] );
	}
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog_single_post_wrap format-video' ); ?>>
	<div class="row">
		<div class="col-lg-12">
			<?php if ( $has_video ) : ?>
				<div class="ulockd-project-sm-thumb responsive-video-container ulockd-mb20">
					<?php echo wp_kses( $video['html'], eggxi_video_embed_allowed_html() ); ?>
				</div>
			<?php elseif ( has_post_thumbnail() ) : ?>
				<div class="ulockd-project-sm-thumb ulockd-mb20">
					<?php
					the_post_thumbnail(
						'large',
						array( 'class' => 'img-whp w100' )
					);
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="bsp_content">
				<?php
				if ( $has_video ) {
					echo $body_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already filtered via the_content.
				} else {
					the_content();
				}

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
					<?php the_tags( 'Tag: ', ', ' ); ?>
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
