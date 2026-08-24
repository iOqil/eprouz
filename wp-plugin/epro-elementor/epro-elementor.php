<?php
/**
 * Plugin Name:       EPRO Elementor Widgets
 * Description:        On-brand Elementor widgets that output the EPRO Tailwind design (Hero, CTA, Button, Features, Logos, Pricing). Content-first so the design stays consistent. Pairs with the EPRO — Classic theme.
 * Version:           0.1.0
 * Requires at least: 6.4
 * Requires PHP:      8.0
 * Author:            EPRO
 * License:           GPL-2.0-or-later
 * Text Domain:       epro-elementor
 *
 * @package epro-elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EPRO_EL_VERSION', '0.1.0' );
define( 'EPRO_EL_DIR', plugin_dir_path( __FILE__ ) );
define( 'EPRO_EL_URL', plugin_dir_url( __FILE__ ) );

/**
 * Boot once all plugins are loaded so we can detect Elementor.
 */
function epro_el_boot() {
	if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
		add_action( 'admin_notices', 'epro_el_missing_notice' );
		return;
	}

	// Widget category.
	add_action( 'elementor/elements/categories_registered', function ( $manager ) {
		$manager->add_category( 'epro', array(
			'title' => __( 'EPRO', 'epro-elementor' ),
			'icon'  => 'eicon-star',
		) );
	} );

	// Register widgets.
	add_action( 'elementor/widgets/register', 'epro_el_register_widgets' );

	// Ensure Tailwind is present (front-end + Elementor preview) when the active
	// theme does not already provide it (epro-classic does).
	add_action( 'wp_enqueue_scripts', 'epro_el_maybe_enqueue_tailwind', 5 );
}
add_action( 'plugins_loaded', 'epro_el_boot', 20 );

/**
 * Register all EPRO widgets.
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Manager.
 */
function epro_el_register_widgets( $widgets_manager ) {
	require_once EPRO_EL_DIR . 'includes/class-base-widget.php';
	$files = array( 'hero', 'cta', 'button', 'features', 'logos', 'pricing' );
	foreach ( $files as $file ) {
		require_once EPRO_EL_DIR . 'includes/widgets/class-' . $file . '.php';
	}
	$widgets_manager->register( new EPRO_El_Hero() );
	$widgets_manager->register( new EPRO_El_CTA() );
	$widgets_manager->register( new EPRO_El_Button() );
	$widgets_manager->register( new EPRO_El_Features() );
	$widgets_manager->register( new EPRO_El_Logos() );
	$widgets_manager->register( new EPRO_El_Pricing() );
}

/**
 * Load Tailwind (CDN) + brand config only if the theme hasn't already.
 */
function epro_el_maybe_enqueue_tailwind() {
	if ( wp_script_is( 'tailwind-cdn', 'enqueued' ) || wp_script_is( 'tailwind-cdn', 'registered' ) ) {
		return; // epro-classic already provides it.
	}
	if ( apply_filters( 'epro_el_skip_tailwind', false ) ) {
		return;
	}

	wp_enqueue_style( 'epro-el-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap', array(), null );
	wp_enqueue_script( 'tailwind-cdn', 'https://cdn.tailwindcss.com?plugins=forms,typography', array(), null, false );
	wp_add_inline_script( 'tailwind-cdn', epro_el_tailwind_config() );
}

/**
 * The brand Tailwind config (indigo primary, slate neutral, Inter/Manrope).
 *
 * @return string
 */
function epro_el_tailwind_config() {
	return "tailwind.config={darkMode:'class',theme:{extend:{colors:{"
		. "primary:{50:'#eef2ff',100:'#e0e7ff',200:'#c7d2fe',300:'#a5b4fc',400:'#818cf8',500:'#6366f1',600:'#4f46e5',700:'#4338ca',800:'#3730a3',900:'#312e81',950:'#1e1b4b'},"
		. "neutral:{50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a',950:'#020617'}"
		. "},fontFamily:{sans:['Inter','ui-sans-serif','system-ui','sans-serif'],display:['Manrope','Inter','ui-sans-serif','system-ui','sans-serif']}}}};";
}

/**
 * Admin notice when Elementor is missing.
 */
function epro_el_missing_notice() {
	echo '<div class="notice notice-warning"><p>';
	echo esc_html__( 'EPRO Elementor Widgets uchun Elementor plagini kerak. Iltimos, Elementor (bepul) ni o\'rnatib faollashtiring.', 'epro-elementor' );
	echo '</p></div>';
}
