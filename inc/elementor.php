<?php
/**
 * Elementor compatibility — Theme Builder locations, helpers, editor tweaks.
 *
 * @package Eggxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether Elementor plugin is active.
 *
 * @return bool
 */
function eggxi_is_elementor_active() {
	return did_action( 'elementor/loaded' ) || class_exists( '\Elementor\Plugin' );
}

/**
 * Whether a post is built with Elementor.
 *
 * @param int|null $post_id Post ID.
 * @return bool
 */
function eggxi_is_built_with_elementor( $post_id = null ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	if ( ! $post_id || ! class_exists( '\Elementor\Plugin' ) ) {
		return false;
	}

	$plugin = \Elementor\Plugin::$instance;

	if ( isset( $plugin->db ) && method_exists( $plugin->db, 'is_built_with_elementor' ) ) {
		return (bool) $plugin->db->is_built_with_elementor( $post_id );
	}

	if ( isset( $plugin->documents ) ) {
		$document = $plugin->documents->get( $post_id );
		if ( $document && method_exists( $document, 'is_built_with_elementor' ) ) {
			return (bool) $document->is_built_with_elementor();
		}
	}

	return ( 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true ) );
}

/**
 * Whether the current view uses an Elementor Theme Builder location override.
 *
 * @param string $location Location name (header|footer|single|archive|etc).
 * @return bool True if Elementor already rendered the location.
 */
function eggxi_elementor_location( $location ) {
	if ( ! function_exists( 'elementor_theme_do_location' ) ) {
		return false;
	}
	return elementor_theme_do_location( $location );
}

/**
 * Register Elementor Theme Builder locations (Pro) + core support.
 */
function eggxi_elementor_register_locations( $elementor_theme_manager ) {
	if ( method_exists( $elementor_theme_manager, 'register_all_core_location' ) ) {
		$elementor_theme_manager->register_all_core_location();
		return;
	}

	$locations = array( 'header', 'footer', 'single', 'archive' );
	foreach ( $locations as $location ) {
		$elementor_theme_manager->register_location( $location );
	}
}
add_action( 'elementor/theme/register_locations', 'eggxi_elementor_register_locations' );

/**
 * Theme supports that help Elementor + block editor.
 */
function eggxi_elementor_theme_support() {
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
}
add_action( 'after_setup_theme', 'eggxi_elementor_theme_support', 20 );

/**
 * One-time Elementor defaults after theme activation (does not overwrite later).
 */
function eggxi_elementor_set_default_settings() {
	if ( get_option( 'eggxi_elementor_defaults_set' ) ) {
		return;
	}
	if ( ! eggxi_is_elementor_active() && ! class_exists( '\Elementor\Plugin' ) ) {
		// Still mark kit options; Elementor may be activated later.
	}

	update_option( 'elementor_container_width', '1170' );
	update_option( 'elementor_space_between_widgets', '20' );
	update_option( 'elementor_stretched_section_container', '.wrapper' );
	update_option( 'eggxi_elementor_defaults_set', 1 );
}
add_action( 'after_switch_theme', 'eggxi_elementor_set_default_settings' );

/**
 * Body classes for Elementor views.
 *
 * @param string[] $classes Classes.
 * @return string[]
 */
function eggxi_elementor_body_class( $classes ) {
	if ( eggxi_is_built_with_elementor() ) {
		$classes[] = 'eggxi-elementor-page';
	}

	$template = get_page_template_slug();
	if ( 'page-templates/elementor-canvas.php' === $template ) {
		$classes[] = 'eggxi-elementor-canvas';
		$classes[] = 'elementor-template-canvas';
	}
	if ( 'page-templates/elementor-full-width.php' === $template ) {
		$classes[] = 'eggxi-elementor-full-width';
		$classes[] = 'elementor-template-full-width';
	}

	return $classes;
}
add_filter( 'body_class', 'eggxi_elementor_body_class' );

/**
 * Soft-disable heavy theme JS conflicts inside Elementor editor iframe.
 */
function eggxi_elementor_editor_scripts() {
	if ( ! eggxi_is_elementor_active() ) {
		return;
	}

	// Front-end preview / editor.
	if ( isset( \Elementor\Plugin::$instance ) && ( \Elementor\Plugin::$instance->preview->is_preview_mode() || \Elementor\Plugin::$instance->editor->is_edit_mode() ) ) {
		wp_dequeue_script( 'eggxi-bootsnav' );
		wp_dequeue_script( 'eggxi-preloader' );
	}
}
add_action( 'wp_enqueue_scripts', 'eggxi_elementor_editor_scripts', 100 );

/**
 * Compatibility CSS so Elementor sections sit cleanly inside Eggxi wrappers.
 */
function eggxi_elementor_compat_css() {
	$css = '
		.eggxi-elementor-page .site-main,
		.eggxi-elementor-full-width .site-main,
		.elementor-page .site-main {
			max-width: none;
			width: 100%;
			padding: 0;
			margin: 0;
		}
		.eggxi-elementor-canvas .wrapper,
		.elementor-template-canvas .wrapper {
			overflow: visible;
		}
		.eggxi-elementor-canvas #preloader,
		.eggxi-elementor-canvas .scrollToHome {
			display: none !important;
		}
		.elementor-section.elementor-section-stretched {
			left: 0 !important;
		}
		.eggxi-elementor-page .ulockd-inner-home,
		.eggxi-elementor-full-width .ulockd-inner-home {
			display: none;
		}
	';
	wp_add_inline_style( 'eggxi-theme', $css );
}
add_action( 'wp_enqueue_scripts', 'eggxi_elementor_compat_css', 40 );

/**
 * Allow Elementor to enqueue its CSS on Eggxi templates.
 *
 * @param bool $enqueue Whether to enqueue.
 * @return bool
 */
function eggxi_elementor_enqueue_styles( $enqueue ) {
	return true;
}
add_filter( 'elementor/frontend/print_google_fonts', '__return_true' );
