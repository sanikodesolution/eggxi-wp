<?php
/**
 * No results partial.
 *
 * @package Eggxi
 */
?>
<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'eggxi' ); ?></h1>
	</header>
	<div class="page-content">
		<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'eggxi' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</section>
