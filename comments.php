<?php
/**
 * Comments template — Eggxi `.blog_singler_poster` markup.
 *
 * @package Eggxi
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h4 class="title">
			<?php
			$count = (int) get_comments_number();
			printf(
				/* translators: %s: comment count padded */
				esc_html( _n( '%s Comment', '%s Comments', $count, 'eggxi' ) ),
				esc_html( str_pad( (string) $count, 2, '0', STR_PAD_LEFT ) )
			);
			?>
		</h4>

		<?php
		wp_list_comments(
			array(
				'style'         => 'div',
				'short_ping'    => true,
				'avatar_size'   => 80,
				'callback'      => 'eggxi_comment_callback',
				'end-callback'  => 'eggxi_comment_end_callback',
			)
		);
		?>

		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'eggxi' ); ?></p>
	<?php endif; ?>

	<?php if ( comments_open() ) : ?>
		<hr>
		<?php
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = $req ? ' required="required"' : '';

		comment_form(
			array(
				'title_reply'          => __( 'Write A Comment', 'eggxi' ),
				'title_reply_before'   => '<div class="bsp_contact_form"><h3 id="reply-title" class="form_title">',
				'title_reply_after'    => '</h3></div>',
				'class_form'           => 'bsp_contact_form',
				'class_submit'         => 'btn btn-thm',
				'label_submit'         => __( 'SUBMIT', 'eggxi' ),
				'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
				'comment_notes_before' => '',
				'comment_notes_after'  => '',
				'fields'               => array(
					'author'  => '<div class="row"><div class="col-lg-6"><div class="form-group"><input id="author" name="author" class="form-control form_bps required" placeholder="' . esc_attr__( 'Name', 'eggxi' ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . '></div></div>',
					'email'   => '<div class="col-lg-6"><div class="form-group"><input id="email" name="email" class="form-control form_bps required email" placeholder="' . esc_attr__( 'Email', 'eggxi' ) . '" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '"' . $aria_req . '></div></div>',
					'url'     => '<div class="col-lg-12"><div class="form-group"><input id="url" name="url" class="form-control form_bps" placeholder="' . esc_attr__( 'Website', 'eggxi' ) . '" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '"></div></div></div>',
					'cookies' => '',
				),
				'comment_field'        => '<div class="row"><div class="col-lg-12"><div class="form-group"><textarea id="comment" name="comment" class="form-control bps_textarea required" rows="6" placeholder="' . esc_attr__( 'Message', 'eggxi' ) . '" required="required"></textarea></div></div>',
				'submit_field'         => '<div class="col-lg-12"><div class="form-group">%1$s %2$s</div></div></div>',
			)
		);
		?>
	<?php endif; ?>
</div>
