<?php
/**
 * Sidebar fallback: Popular tags.
 *
 * @package Eggxi
 */

$tags = get_tags(
	array(
		'orderby'    => 'count',
		'order'      => 'DESC',
		'number'     => 10,
		'hide_empty' => true,
	)
);

if ( empty( $tags ) || is_wp_error( $tags ) ) {
	return;
}
?>
<div class="sidebar_tag_widget">
	<h4 class="saw_title"><?php esc_html_e( 'Popular Tag', 'eggxi' ); ?></h4>
	<ul class="stw_tag_widget">
		<?php foreach ( $tags as $tag ) : ?>
			<li>
				<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" title="<?php echo esc_attr( $tag->name ); ?>">
					<?php echo esc_html( $tag->name ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
