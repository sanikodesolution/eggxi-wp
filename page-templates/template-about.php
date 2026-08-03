<?php
/**
 * Template Name: About Me Page
 * Template Post Type: page
 *
 * About page layout: video hero, intro content, mission/hobbies sidebar.
 *
 * @package Eggxi
 */

get_header();
get_template_part( 'template-parts/content', 'page-header' );

while ( have_posts() ) :
	the_post();

	$post_id = get_the_ID();
	$permalink = get_permalink();

	$hero_image = get_the_post_thumbnail_url( $post_id, 'full' );
	if ( ! $hero_image ) {
		$hero_image = get_template_directory_uri() . '/assets/images/about/2.jpg';
	}

	$video_url = eggxi_get_meta_or_acf(
		$post_id,
		'eggxi_about_video_url',
		array( 'about_video_url', 'video_url', 'banner_video_url' )
	);
	if ( ! $video_url ) {
		$video_url = 'https://www.youtube.com/watch?v=oqNZOOWF8qM';
	}

	$badge = eggxi_get_meta_or_acf(
		$post_id,
		'eggxi_about_badge',
		array( 'about_badge', 'personal_info_badge' )
	);
	if ( ! $badge ) {
		$badge = __( 'Personal Info', 'eggxi' );
	}

	$hero_title = eggxi_get_meta_or_acf(
		$post_id,
		'eggxi_about_hero_title',
		array( 'about_hero_title', 'about_main_title' )
	);
	if ( ! $hero_title ) {
		$hero_title = get_the_title();
	}

	$intro_heading = eggxi_get_meta_or_acf(
		$post_id,
		'eggxi_about_intro_heading',
		array( 'about_intro_heading' )
	);
	if ( ! $intro_heading ) {
		$intro_heading = __( 'About Me', 'eggxi' );
	}

	$mission_title = eggxi_get_meta_or_acf(
		$post_id,
		'eggxi_about_mission_title',
		array( 'about_mission_title', 'my_mission_title' )
	);
	if ( ! $mission_title ) {
		$mission_title = __( 'My Mission', 'eggxi' );
	}

	$mission_text = eggxi_get_meta_or_acf(
		$post_id,
		'eggxi_about_mission_text',
		array( 'about_mission_text', 'my_mission' ),
		true
	);
	if ( ! $mission_text ) {
		$mission_text = __( 'Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit fames ac ante.', 'eggxi' );
	}

	$hobbies_title = eggxi_get_meta_or_acf(
		$post_id,
		'eggxi_about_hobbies_title',
		array( 'about_hobbies_title', 'my_hobbies_title' )
	);
	if ( ! $hobbies_title ) {
		$hobbies_title = __( 'My Hobbies', 'eggxi' );
	}

	$hobbies_text = eggxi_get_meta_or_acf(
		$post_id,
		'eggxi_about_hobbies_text',
		array( 'about_hobbies_text', 'my_hobbies' ),
		true
	);
	if ( ! $hobbies_text ) {
		$hobbies_text = __( 'Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.', 'eggxi' );
	}

	$share_label = eggxi_get_meta_or_acf(
		$post_id,
		'eggxi_about_share_label',
		array( 'about_share_label' )
	);
	if ( ! $share_label ) {
		$share_label = __( 'Share Me', 'eggxi' );
	}

	$is_youtube = ( false !== strpos( $video_url, 'youtu' ) );
	$video_class = $is_youtube
		? 'video_popup_btn popup-youtube mfp-iframe mfp-youtube'
		: 'video_popup_btn popup-vimeo mfp-iframe mfp-vimeo';

	$encoded_url   = rawurlencode( $permalink );
	$encoded_title = rawurlencode( get_the_title() );
	?>

<section class="about-us bgc-ghostwhite ulockd-pb50">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				<div class="home1_blog_post about_page_main_post ulockd-mb30">
					<div class="thumb">
						<img class="img-fluid w100" src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
						<div class="overlay">
							<div class="home_post_overlay_icon bgc-orange">
								<a class="<?php echo esc_attr( $video_class ); ?>" href="<?php echo esc_url( $video_url ); ?>" aria-label="<?php esc_attr_e( 'Play video', 'eggxi' ); ?>">
									<span class="flaticon-play"></span>
								</a>
							</div>
						</div>
					</div>
					<div class="details">
						<div class="tag bgc-thm"><?php echo esc_html( $badge ); ?></div>
						<h4 class="title">
							<a href="<?php the_permalink(); ?>"><?php echo esc_html( $hero_title ); ?></a>
						</h4>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-8">
				<div class="about-intro">
					<h3 class="text-center"><?php echo esc_html( $intro_heading ); ?></h3>
					<?php
					$content = apply_filters( 'the_content', get_the_content() );
					$content = eggxi_add_dropcap_to_first_paragraph( $content );
					echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
			</div>

			<div class="col-lg-4">
				<div class="ulockd-mt15">
					<div class="share-button btn-xl bgc-white bdrs40">
						<span class="bgc-thm bdrs40"><?php echo esc_html( $share_label ); ?></span>
						<a class="hvr-bgc-fb" href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on Facebook', 'eggxi' ); ?>">
							<i class="fab fa-facebook-f"></i>
						</a>
						<a class="hvr-bgc-twtr" href="<?php echo esc_url( 'https://twitter.com/intent/tweet?url=' . $encoded_url . '&text=' . $encoded_title ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on Twitter', 'eggxi' ); ?>">
							<i class="fab fa-twitter"></i>
						</a>
						<a class="hvr-bgc-inst" href="<?php echo esc_url( get_theme_mod( 'eggxi_social_instagram', '#' ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'eggxi' ); ?>">
							<i class="fab fa-instagram"></i>
						</a>
						<a class="hvr-bgc-lnkdn" href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . $encoded_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'eggxi' ); ?>">
							<i class="fab fa-linkedin-in"></i>
						</a>
					</div>
				</div>

				<div class="ulockd-pt30 ulockd-pl30 ulockd-pr30">
					<h4 class="saw_title"><?php echo esc_html( $mission_title ); ?></h4>
					<?php if ( false !== strpos( $mission_text, '<' ) ) : ?>
						<?php echo wp_kses_post( $mission_text ); ?>
					<?php else : ?>
						<p><?php echo esc_html( $mission_text ); ?></p>
					<?php endif; ?>
				</div>

				<div class="ulockd-pt30 ulockd-pl30 ulockd-pr30">
					<h4 class="saw_title"><?php echo esc_html( $hobbies_title ); ?></h4>
					<?php if ( false !== strpos( $hobbies_text, '<' ) ) : ?>
						<?php echo wp_kses_post( $hobbies_text ); ?>
					<?php else : ?>
						<p><?php echo esc_html( $hobbies_text ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

	<?php
endwhile;

get_footer();
