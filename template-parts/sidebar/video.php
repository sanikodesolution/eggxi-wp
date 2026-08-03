<?php
/**
 * Sidebar fallback: Video promo.
 *
 * Prefers post meta / ACF on single posts, then Customizer defaults.
 *
 * @package Eggxi
 */

$video_url = '';
$poster_id = 0;

if ( is_singular( 'post' ) ) {
	$post_id   = get_the_ID();
	$video_url = (string) eggxi_get_meta_or_acf( $post_id, 'eggxi_sidebar_video_url', array( 'sidebar_video_url', 'video_url' ) );

	$poster_raw = get_post_meta( $post_id, 'eggxi_sidebar_video_poster', true );
	if ( ! $poster_raw && function_exists( 'get_field' ) ) {
		foreach ( array( 'sidebar_video_poster', 'video_poster' ) as $field ) {
			$poster_raw = get_field( $field, $post_id );
			if ( $poster_raw ) {
				break;
			}
		}
	}

	if ( is_numeric( $poster_raw ) ) {
		$poster_id = (int) $poster_raw;
	} elseif ( is_array( $poster_raw ) && ! empty( $poster_raw['ID'] ) ) {
		$poster_id = (int) $poster_raw['ID'];
	}
}

if ( ! $video_url ) {
	$video_url = get_theme_mod( 'eggxi_video_url', 'https://www.youtube.com/watch?v=R7xbhKIiw4Y' );
}
if ( ! $poster_id ) {
	$poster_id = (int) get_theme_mod( 'eggxi_video_poster', 0 );
}

if ( ! $video_url ) {
	return;
}

$is_youtube = ( false !== strpos( $video_url, 'youtu' ) );
$link_class = $is_youtube ? 'mfp-iframe mfp-youtube text-thm' : 'mfp-iframe mfp-vimeo text-thm';

if ( $poster_id ) {
	$poster = wp_get_attachment_image( $poster_id, 'large', false, array( 'class' => 'img-fluid w100' ) );
} else {
	$poster = sprintf(
		'<img class="img-fluid w100" src="%1$s" alt="%2$s">',
		esc_url( get_template_directory_uri() . '/assets/images/about/1.jpg' ),
		esc_attr__( 'Video promo', 'eggxi' )
	);
}
?>
<div class="sidebar_video_widget">
	<div class="thumb">
		<?php echo $poster; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( $video_url ); ?>" aria-label="<?php esc_attr_e( 'Play video', 'eggxi' ); ?>">
			<i class="fas fa-play"></i>
		</a>
	</div>
</div>
