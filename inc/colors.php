<?php
/**
 * Theme color Customizer + dynamic CSS overrides.
 *
 * @package Eggxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default Eggxi accent (from assets/css/theme-color.css).
 *
 * @return string
 */
function eggxi_default_primary_color() {
	return '#427882';
}

/**
 * Get sanitized primary theme color.
 *
 * @return string Hex color.
 */
function eggxi_get_primary_color() {
	$color = get_theme_mod( 'eggxi_primary_color', eggxi_default_primary_color() );
	$color = sanitize_hex_color( $color );
	return $color ? $color : eggxi_default_primary_color();
}

/**
 * Convert hex to "r, g, b" for rgba() usage.
 *
 * @param string $hex Hex color.
 * @return string
 */
function eggxi_hex_to_rgb_csv( $hex ) {
	$hex = ltrim( (string) $hex, '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	if ( 6 !== strlen( $hex ) ) {
		return '66, 120, 130';
	}
	return sprintf(
		'%d, %d, %d',
		hexdec( substr( $hex, 0, 2 ) ),
		hexdec( substr( $hex, 2, 2 ) ),
		hexdec( substr( $hex, 4, 2 ) )
	);
}

/**
 * Build CSS that applies Customizer colors everywhere `.text-thm` / `.bgc-thm` / theme-color.css use the accent.
 *
 * @return string
 */
function eggxi_get_dynamic_color_css() {
	$primary   = eggxi_get_primary_color();
	$default   = eggxi_default_primary_color();
	$secondary = get_theme_mod( 'eggxi_secondary_color', '' );
	$secondary = sanitize_hex_color( $secondary );
	$text      = get_theme_mod( 'eggxi_text_color', '' );
	$text      = sanitize_hex_color( $text );
	$heading   = get_theme_mod( 'eggxi_heading_color', '' );
	$heading   = sanitize_hex_color( $heading );

	$rgb = eggxi_hex_to_rgb_csv( $primary );

	$css  = ':root{';
	$css .= '--eggxi-primary:' . $primary . ';';
	$css .= '--eggxi-thm:' . $primary . ';';
	$css .= '--eggxi-primary-rgb:' . $rgb . ';';
	if ( $secondary ) {
		$css .= '--eggxi-secondary:' . $secondary . ';';
	}
	if ( $text ) {
		$css .= '--eggxi-text:' . $text . ';';
	}
	if ( $heading ) {
		$css .= '--eggxi-heading:' . $heading . ';';
	}
	$css .= '}';

	// Remap the compiled theme-color.css accent when the user picks a new primary.
	$path = EGGXI_DIR . '/assets/css/theme-color.css';
	if ( is_readable( $path ) && strtolower( $primary ) !== strtolower( $default ) ) {
		$file = file_get_contents( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		if ( is_string( $file ) && $file ) {
			$remapped = str_ireplace( $default, $primary, $file );
			$css     .= "\n" . $remapped;
		}
	}

	// Extra utility hooks for custom / Elementor CSS.
	$css .= '.text-thm,.hvr-text-thm:hover{color:var(--eggxi-primary)!important;}';
	$css .= '.bgc-thm,.hvr-bgc-thm:hover,.btn-thm{background-color:var(--eggxi-primary)!important;border-color:var(--eggxi-primary)!important;}';
	$css .= '.btn-thm{color:#fff!important;}';
	$css .= '.ulockd-bdr-thm,.bsp_note.ulockd-bdr-thm{border-color:var(--eggxi-primary)!important;}';

	if ( $secondary ) {
		$css .= '.bgc-thm2,.bgc-thm3{background-color:var(--eggxi-secondary)!important;}';
	}
	if ( $text ) {
		$css .= 'body,p,.bsp_content{color:var(--eggxi-text);}';
	}
	if ( $heading ) {
		$css .= 'h1,h2,h3,h4,h5,h6,.title,.main-title .title{color:var(--eggxi-heading);}';
	}

	/**
	 * Filter dynamic color CSS.
	 *
	 * @param string $css      Generated CSS.
	 * @param string $primary  Primary hex.
	 */
	return apply_filters( 'eggxi_dynamic_color_css', $css, $primary );
}

/**
 * Print / attach dynamic color CSS on the front end.
 */
function eggxi_enqueue_dynamic_colors() {
	$primary = eggxi_get_primary_color();
	$default = eggxi_default_primary_color();

	// Avoid shipping two copies of theme-color.css when remapping the accent.
	if ( strtolower( $primary ) !== strtolower( $default ) ) {
		wp_dequeue_style( 'eggxi-theme-color' );
		wp_deregister_style( 'eggxi-theme-color' );
	}

	$css = eggxi_get_dynamic_color_css();
	if ( ! $css ) {
		return;
	}
	wp_add_inline_style( 'eggxi-theme', $css );
}
add_action( 'wp_enqueue_scripts', 'eggxi_enqueue_dynamic_colors', 30 );

/**
 * Also apply colors in the Customizer preview / block editor when useful.
 */
function eggxi_admin_dynamic_colors() {
	if ( ! is_customize_preview() ) {
		return;
	}
	$css = eggxi_get_dynamic_color_css();
	if ( $css ) {
		echo '<style id="eggxi-dynamic-colors">' . $css . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
add_action( 'wp_head', 'eggxi_admin_dynamic_colors', 100 );

/**
 * Register Colors section in the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function eggxi_customize_register_colors( $wp_customize ) {
	$wp_customize->add_section(
		'eggxi_colors',
		array(
			'title'       => __( 'Colors', 'eggxi' ),
			'description' => __( 'Change the Eggxi accent color used for buttons, links, badges, and .text-thm / .bgc-thm classes site-wide. Optional text colors apply globally too.', 'eggxi' ),
			'panel'       => 'eggxi_theme_options',
			'priority'    => 5,
		)
	);

	$wp_customize->add_setting(
		'eggxi_primary_color',
		array(
			'default'           => eggxi_default_primary_color(),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'eggxi_primary_color',
			array(
				'label'       => __( 'Primary accent color', 'eggxi' ),
				'description' => __( 'Replaces the default teal (#427882) everywhere the theme accent is used.', 'eggxi' ),
				'section'     => 'eggxi_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'eggxi_secondary_color',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'eggxi_secondary_color',
			array(
				'label'       => __( 'Secondary color (optional)', 'eggxi' ),
				'description' => __( 'Used for .bgc-thm2 / .bgc-thm3 backgrounds when set.', 'eggxi' ),
				'section'     => 'eggxi_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'eggxi_heading_color',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'eggxi_heading_color',
			array(
				'label'   => __( 'Heading color (optional)', 'eggxi' ),
				'section' => 'eggxi_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'eggxi_text_color',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'eggxi_text_color',
			array(
				'label'   => __( 'Body text color (optional)', 'eggxi' ),
				'section' => 'eggxi_colors',
			)
		)
	);
}
add_action( 'customize_register', 'eggxi_customize_register_colors', 20 );
