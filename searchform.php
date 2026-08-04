<?php
/**
 * Search form markup (sidebar + get_search_form()).
 *
 * @package Eggxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eggxi_search_id = 'eggxi-search-field-' . uniqid();
?>
<form role="search" method="get" class="eggxi-search-form search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $eggxi_search_id ); ?>">
		<?php echo esc_html_x( 'Search for:', 'label', 'eggxi' ); ?>
	</label>
	<input
		type="search"
		id="<?php echo esc_attr( $eggxi_search_id ); ?>"
		class="form-control search-field"
		placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'eggxi' ); ?>"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		name="s"
	/>
	<button type="submit" class="btn btn-thm search-submit">
		<?php echo esc_html_x( 'Search', 'submit button', 'eggxi' ); ?>
	</button>
</form>
