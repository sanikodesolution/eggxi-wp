<?php
/**
 * Theme Customizer settings.
 *
 * @package Eggxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer panels, sections, and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function eggxi_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'eggxi_theme_options',
		array(
			'title'    => __( 'Eggxi Theme Options', 'eggxi' ),
			'priority' => 30,
		)
	);

	// Header notice / tagline.
	$wp_customize->add_section(
		'eggxi_header_top',
		array(
			'title' => __( 'Header Top', 'eggxi' ),
			'panel' => 'eggxi_theme_options',
		)
	);

	$wp_customize->add_setting(
		'eggxi_header_notice',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'eggxi_header_notice',
		array(
			'label'       => __( 'Header notice / ticker text', 'eggxi' ),
			'description' => __( 'Shown in the top bar middle. Falls back to the site tagline if empty.', 'eggxi' ),
			'section'     => 'eggxi_header_top',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'eggxi_logo_max_height',
		array(
			'default'           => 60,
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'eggxi_logo_max_height',
		array(
			'label'       => __( 'Header logo max height (px)', 'eggxi' ),
			'description' => __( 'Controls Site Identity logo size in the header. Try 50–80px.', 'eggxi' ),
			'section'     => 'eggxi_header_top',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 24,
				'max'  => 200,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'eggxi_show_lang_switcher',
		array(
			'default'           => true,
			'sanitize_callback' => 'eggxi_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'eggxi_show_lang_switcher',
		array(
			'label'   => __( 'Show language switcher area', 'eggxi' ),
			'section' => 'eggxi_header_top',
			'type'    => 'checkbox',
		)
	);

	// Header banner.
	$wp_customize->add_section(
		'eggxi_header_banner',
		array(
			'title' => __( 'Header Banner', 'eggxi' ),
			'panel' => 'eggxi_theme_options',
		)
	);

	$wp_customize->add_setting(
		'eggxi_banner_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'eggxi_banner_image',
			array(
				'label'     => __( 'Promo banner image', 'eggxi' ),
				'section'   => 'eggxi_header_banner',
				'mime_type' => 'image',
			)
		)
	);

	$wp_customize->add_setting(
		'eggxi_banner_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'eggxi_banner_url',
		array(
			'label'   => __( 'Banner link URL', 'eggxi' ),
			'section' => 'eggxi_header_banner',
			'type'    => 'url',
		)
	);

	// Social links.
	$wp_customize->add_section(
		'eggxi_social',
		array(
			'title' => __( 'Social Media', 'eggxi' ),
			'panel' => 'eggxi_theme_options',
		)
	);

	$networks = eggxi_get_social_networks();

	foreach ( $networks as $key => $network ) {
		$wp_customize->add_setting(
			'eggxi_social_' . $key,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			'eggxi_social_' . $key,
			array(
				'label'   => $network['label'],
				'section' => 'eggxi_social',
				'type'    => 'url',
			)
		);
	}

	// Hero.
	$wp_customize->add_section(
		'eggxi_hero',
		array(
			'title' => __( 'Hero Slider', 'eggxi' ),
			'panel' => 'eggxi_theme_options',
		)
	);

	$wp_customize->add_setting(
		'eggxi_hero_count',
		array(
			'default'           => 6,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'eggxi_hero_count',
		array(
			'label'       => __( 'Number of hero slides', 'eggxi' ),
			'description' => __( 'Uses sticky posts first, then latest posts with featured images.', 'eggxi' ),
			'section'     => 'eggxi_hero',
			'type'        => 'number',
			'input_attrs' => array(
				'min' => 1,
				'max' => 12,
			),
		)
	);

	// Featured Post grid.
	$wp_customize->add_section(
		'eggxi_featured_grid',
		array(
			'title' => __( 'Featured Post Grid', 'eggxi' ),
			'panel' => 'eggxi_theme_options',
		)
	);

	$wp_customize->add_setting(
		'eggxi_featured_section_title',
		array(
			'default'           => __( 'Featured Post', 'eggxi' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'eggxi_featured_section_title',
		array(
			'label'       => __( 'Section title', 'eggxi' ),
			'description' => __( 'Decorative bordered heading above the featured grid.', 'eggxi' ),
			'section'     => 'eggxi_featured_grid',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'eggxi_featured_term_slug',
		array(
			'default'           => 'featured',
			'sanitize_callback' => 'sanitize_title',
		)
	);

	$wp_customize->add_control(
		'eggxi_featured_term_slug',
		array(
			'label'       => __( 'Featured tag/category slug', 'eggxi' ),
			'description' => __( 'Used after sticky posts. Falls back to latest posts if the term is empty or missing.', 'eggxi' ),
			'section'     => 'eggxi_featured_grid',
			'type'        => 'text',
		)
	);

	// Sidebar fallbacks (used when Main Sidebar has no widgets).
	$wp_customize->add_section(
		'eggxi_sidebar',
		array(
			'title' => __( 'Main Sidebar Content', 'eggxi' ),
			'panel' => 'eggxi_theme_options',
		)
	);

	$wp_customize->add_setting(
		'eggxi_about_name',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'eggxi_about_name',
		array(
			'label'   => __( 'About — name', 'eggxi' ),
			'section' => 'eggxi_sidebar',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'eggxi_about_bio',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'eggxi_about_bio',
		array(
			'label'   => __( 'About — bio', 'eggxi' ),
			'section' => 'eggxi_sidebar',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'eggxi_about_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'eggxi_about_image',
			array(
				'label'     => __( 'About — profile image', 'eggxi' ),
				'section'   => 'eggxi_sidebar',
				'mime_type' => 'image',
			)
		)
	);

	$wp_customize->add_setting(
		'eggxi_video_url',
		array(
			'default'           => 'https://www.youtube.com/watch?v=R7xbhKIiw4Y',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'eggxi_video_url',
		array(
			'label'   => __( 'Video promo URL (YouTube/Vimeo)', 'eggxi' ),
			'section' => 'eggxi_sidebar',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting(
		'eggxi_video_poster',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'eggxi_video_poster',
			array(
				'label'     => __( 'Video promo poster image', 'eggxi' ),
				'section'   => 'eggxi_sidebar',
				'mime_type' => 'image',
			)
		)
	);

	$wp_customize->add_setting(
		'eggxi_newsletter_shortcode',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'eggxi_newsletter_shortcode',
		array(
			'label'       => __( 'Newsletter shortcode', 'eggxi' ),
			'description' => __( 'e.g. [mc4wp_form id="123"]. Leave empty for a basic HTML form markup.', 'eggxi' ),
			'section'     => 'eggxi_sidebar',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'eggxi_social_youtube',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'eggxi_social_youtube',
		array(
			'label'   => __( 'YouTube URL (About widget)', 'eggxi' ),
			'section' => 'eggxi_sidebar',
			'type'    => 'url',
		)
	);

	// Recent And Latest section.
	$wp_customize->add_section(
		'eggxi_recent_latest',
		array(
			'title' => __( 'Recent And Latest', 'eggxi' ),
			'panel' => 'eggxi_theme_options',
		)
	);

	$wp_customize->add_setting(
		'eggxi_recent_latest_title',
		array(
			'default'           => __( 'Recent And Latest', 'eggxi' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'eggxi_recent_latest_title',
		array(
			'label'       => __( 'Section title', 'eggxi' ),
			'description' => __( 'Decorative bordered heading. Falls back to “Recent And Latest”.', 'eggxi' ),
			'section'     => 'eggxi_recent_latest',
			'type'        => 'text',
		)
	);

	// Popular News section.
	$wp_customize->add_section(
		'eggxi_popular_news',
		array(
			'title' => __( 'Popular News', 'eggxi' ),
			'panel' => 'eggxi_theme_options',
		)
	);

	$wp_customize->add_setting(
		'eggxi_popular_news_title',
		array(
			'default'           => __( 'Popular News', 'eggxi' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'eggxi_popular_news_title',
		array(
			'label'       => __( 'Section title', 'eggxi' ),
			'description' => __( 'Decorative bordered heading. Falls back to “Popular News”.', 'eggxi' ),
			'section'     => 'eggxi_popular_news',
			'type'        => 'text',
		)
	);

	// Footer.
	$wp_customize->add_section(
		'eggxi_footer',
		array(
			'title' => __( 'Footer', 'eggxi' ),
			'panel' => 'eggxi_theme_options',
		)
	);

	$wp_customize->add_setting(
		'eggxi_footer_bio',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'eggxi_footer_bio',
		array(
			'label'       => __( 'Footer about text', 'eggxi' ),
			'description' => __( 'Falls back to the site tagline if empty.', 'eggxi' ),
			'section'     => 'eggxi_footer',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'eggxi_instagram_shortcode',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'eggxi_instagram_shortcode',
		array(
			'label'       => __( 'Instagram feed shortcode', 'eggxi' ),
			'description' => __( 'e.g. [instagram-feed]. Leave empty to use latest 8 post thumbnails.', 'eggxi' ),
			'section'     => 'eggxi_footer',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'eggxi_footer_subscribe_shortcode',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'eggxi_footer_subscribe_shortcode',
		array(
			'label'       => __( 'Footer subscription shortcode', 'eggxi' ),
			'description' => __( 'MC4WP / CF7 shortcode. Leave empty for the default Name + Email form markup.', 'eggxi' ),
			'section'     => 'eggxi_footer',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'eggxi_footer_copyright',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'eggxi_footer_copyright',
		array(
			'label'       => __( 'Copyright text', 'eggxi' ),
			'description' => __( 'Optional. Supports basic HTML. Leave empty for the default © year + site name line.', 'eggxi' ),
			'section'     => 'eggxi_footer',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'eggxi_footer_email',
		array(
			'default'           => 'dummy@yourmail.com',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'eggxi_footer_email',
		array(
			'label'   => __( 'Contact email (Mail Us)', 'eggxi' ),
			'section' => 'eggxi_footer',
			'type'    => 'email',
		)
	);

	$wp_customize->add_setting(
		'eggxi_footer_phone',
		array(
			'default'           => '+99-55-66-88-526',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'eggxi_footer_phone',
		array(
			'label'   => __( 'Contact phone (Call Us)', 'eggxi' ),
			'section' => 'eggxi_footer',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'eggxi_footer_address',
		array(
			'default'           => 'Victoria 8007 Australia HQ 121 King Street, Melbourne.',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'eggxi_footer_address',
		array(
			'label'   => __( 'Address (Find Us)', 'eggxi' ),
			'section' => 'eggxi_footer',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'eggxi_footer_twitter_embed',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'eggxi_footer_twitter_embed',
		array(
			'label'       => __( 'Twitter feed embed / shortcode', 'eggxi' ),
			'description' => __( 'Paste a Twitter timeline embed HTML or shortcode. Shown when Footer Column 2 has no widgets.', 'eggxi' ),
			'section'     => 'eggxi_footer',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'eggxi_footer_payment_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'eggxi_footer_payment_image',
			array(
				'label'     => __( 'Payment methods image', 'eggxi' ),
				'section'   => 'eggxi_footer',
				'mime_type' => 'image',
			)
		)
	);

	// Inner page banner.
	$wp_customize->add_section(
		'eggxi_page_header',
		array(
			'title' => __( 'Inner Page Banner', 'eggxi' ),
			'panel' => 'eggxi_theme_options',
		)
	);

	$wp_customize->add_setting(
		'eggxi_page_banner_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'eggxi_page_banner_image',
			array(
				'label'       => __( 'Default banner background', 'eggxi' ),
				'description' => __( 'Used when the page/post has no featured image.', 'eggxi' ),
				'section'     => 'eggxi_page_header',
				'mime_type'   => 'image',
			)
		)
	);

	$wp_customize->add_setting(
		'eggxi_page_banner_subtitle_top',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'eggxi_page_banner_subtitle_top',
		array(
			'label'   => __( 'Default subtitle (above title)', 'eggxi' ),
			'section' => 'eggxi_page_header',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'eggxi_page_banner_subtitle_bottom',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'eggxi_page_banner_subtitle_bottom',
		array(
			'label'   => __( 'Default tagline (below title)', 'eggxi' ),
			'section' => 'eggxi_page_header',
			'type'    => 'text',
		)
	);
}
add_action( 'customize_register', 'eggxi_customize_register' );

/**
 * Sanitize checkbox.
 *
 * @param mixed $checked Checked value.
 * @return bool
 */
function eggxi_sanitize_checkbox( $checked ) {
	return (bool) $checked;
}
