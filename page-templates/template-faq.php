<?php
/**
 * Template Name: FAQ Page
 * Template Post Type: page
 *
 * FAQ accordion (ACF repeater `faq_items`) + Activity video sidebar
 * (`activity_video_url` oEmbed). Matches Eggxi `page-faq.html`.
 *
 * @package Eggxi
 */

get_header();
get_template_part( 'template-parts/content', 'page-header' );

while ( have_posts() ) :
	the_post();

	$post_id = get_the_ID();

	// Section headings (ACF optional overrides).
	$faq_title_plain = eggxi_get_meta_or_acf(
		$post_id,
		'eggxi_faq_title',
		array( 'faq_title', 'faq_heading' )
	);
	$activity_title_plain = eggxi_get_meta_or_acf(
		$post_id,
		'eggxi_activity_title',
		array( 'activity_title', 'eggxi_activity_heading' )
	);

	// Activity video — ACF oEmbed may return HTML or a URL string.
	$activity_video_html = '';
	$activity_video_raw  = '';

	if ( function_exists( 'get_field' ) ) {
		$activity_video_raw = get_field( 'activity_video_url', $post_id );
	}
	if ( ! $activity_video_raw ) {
		$activity_video_raw = get_post_meta( $post_id, 'activity_video_url', true );
	}

	if ( is_string( $activity_video_raw ) && '' !== trim( $activity_video_raw ) ) {
		$activity_video_raw = trim( $activity_video_raw );
		if ( preg_match( '/<(iframe|video|embed|object)\b/i', $activity_video_raw ) ) {
			$activity_video_html = $activity_video_raw;
		} else {
			$oembed = wp_oembed_get( esc_url_raw( $activity_video_raw ) );
			$activity_video_html = $oembed ? $oembed : '';
		}
	}

	if ( ! $activity_video_html ) {
		$activity_video_html = '<iframe width="100%" height="465" src="https://www.youtube.com/embed/tFC3jE34ilc?autoplay=0" allowfullscreen loading="lazy" title="' . esc_attr__( 'Eggxi Activity', 'eggxi' ) . '"></iframe>';
	}

	// FAQ items from ACF repeater, else static HTML fallbacks.
	$faq_items = array();

	if ( function_exists( 'have_rows' ) && have_rows( 'faq_items', $post_id ) ) {
		while ( have_rows( 'faq_items', $post_id ) ) {
			the_row();
			$question = get_sub_field( 'question' );
			$answer   = get_sub_field( 'answer' );
			if ( $question || $answer ) {
				$faq_items[] = array(
					'question' => $question ? $question : '',
					'answer'   => $answer ? $answer : '',
				);
			}
		}
	}

	if ( empty( $faq_items ) ) {
		$faq_items = array(
			array(
				'question' => __( 'How Can I Contact For Support?', 'eggxi' ),
				'answer'   => __( 'Go to Our Profile Page, Mail Us. As Soon As Possible In Our Supported Schedule We will reply you.', 'eggxi' ),
			),
			array(
				'question' => __( 'Contact Form Active?', 'eggxi' ),
				'answer'   => __( 'Sure, You Will Get Contact Form Active In Our All Templates. Configure your email in the contact form settings, then run your site.', 'eggxi' ),
			),
			array(
				'question' => __( 'About Eggxi Personal Template?', 'eggxi' ),
				'answer'   => __( 'Yes. Administrations are accessible for as meager as a couple of hours a visit up to 24 hours, 7 days seven days, 365 days a year.', 'eggxi' ),
			),
			array(
				'question' => __( 'What is Primary Care?', 'eggxi' ),
				'answer'   => __( 'The term essential care alludes to the sort of restorative care you require first — before you become ill, before you have to see a master, before you have to go to a healing facility.', 'eggxi' ),
			),
			array(
				'question' => __( 'What if my Comfort Keeper is sick or on vacation?', 'eggxi' ),
				'answer'   => __( 'Each Comfort Keepers office utilizes a group of parental figures so that your care administration won\'t be hindered in the event that somebody becomes ill or takes some time off.', 'eggxi' ),
			),
			array(
				'question' => __( 'Is long term care expensive?', 'eggxi' ),
				'answer'   => __( 'It can be. Americans burn through billions of dollars a year on different administrations. How much an individual pays relies upon the sort and measure of administrations gave.', 'eggxi' ),
			),
		);
	}
	?>
	<section class="ulockd-ap-faq">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7">
					<div class="ulockd-faq-box">
						<div class="ulockd-faq-title clearfix">
							<h3>
								<?php
								if ( $faq_title_plain ) {
									echo esc_html( $faq_title_plain );
								} else {
									esc_html_e( 'Frequently Asked', 'eggxi' );
									echo ' <span class="text-thm">' . esc_html__( 'Questions', 'eggxi' ) . '</span>';
								}
								?>
							</h3>
						</div>

						<div class="ulockd-faq-content">
							<div class="panel-group" id="eggxi-faq-accordion" role="tablist" aria-multiselectable="true">
								<?php foreach ( $faq_items as $index => $item ) : ?>
									<?php
									$i          = $index + 1;
									$heading_id = 'faq-heading-' . $i;
									$collapse_id = 'faq-collapse-' . $i;
									$is_first   = ( 0 === $index );
									?>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="<?php echo esc_attr( $heading_id ); ?>">
											<h5 class="panel-title">
												<a
													class="<?php echo $is_first ? '' : 'collapsed'; ?>"
													role="button"
													data-bs-toggle="collapse"
													data-bs-parent="#eggxi-faq-accordion"
													data-parent="#eggxi-faq-accordion"
													href="#<?php echo esc_attr( $collapse_id ); ?>"
													aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>"
													aria-controls="<?php echo esc_attr( $collapse_id ); ?>"
												>
													<i class="icon-Down-2 icon-1"></i>
													<i class="icon-Right-2 icon-2"></i>
													<?php echo esc_html( $item['question'] ); ?>
												</a>
											</h5>
										</div>
										<div
											id="<?php echo esc_attr( $collapse_id ); ?>"
											class="panel-collapse collapse<?php echo $is_first ? ' show' : ''; ?>"
											role="tabpanel"
											aria-labelledby="<?php echo esc_attr( $heading_id ); ?>"
											data-bs-parent="#eggxi-faq-accordion"
										>
											<div class="panel-body">
												<?php echo wp_kses_post( wpautop( $item['answer'] ) ); ?>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-5">
					<h3 class="ulockd-mt0">
						<?php
						if ( $activity_title_plain ) {
							echo esc_html( $activity_title_plain );
						} else {
							esc_html_e( 'Eggxi', 'eggxi' );
							echo ' <span class="text-thm">' . esc_html__( 'Activity', 'eggxi' ) . '</span>';
						}
						?>
					</h3>
					<div class="ulockd-about-video ulockd-mt25">
						<div class="ulockd-avdo-thumb responsive-video-container">
							<?php echo wp_kses( $activity_video_html, eggxi_video_embed_allowed_html() ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
