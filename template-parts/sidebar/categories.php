<?php
/**
 * Sidebar fallback: Categories with counts.
 *
 * @package Eggxi
 */

$categories = get_categories(
	array(
		'orderby'    => 'count',
		'order'      => 'DESC',
		'hide_empty' => true,
		'number'     => 10,
	)
);

if ( empty( $categories ) || is_wp_error( $categories ) ) {
	return;
}
?>
<div class="sidebar_category_widget">
	<h4 class="saw_title"><?php esc_html_e( 'Category', 'eggxi' ); ?></h4>
	<ul class="scw_list_group ulockd-mb0">
		<?php foreach ( $categories as $category ) : ?>
			<li class="list-inline-item">
				<a class="hvr-text-thm" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
					<span><?php echo esc_html( $category->name ); ?></span>
					<span class="c_count text-thm"><?php echo esc_html( str_pad( (string) $category->count, 2, '0', STR_PAD_LEFT ) ); ?></span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
