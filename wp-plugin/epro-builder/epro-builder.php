<?php
/**
 * Plugin Name:       EPRO Builder
 * Plugin URI:        https://epro.uz
 * Description:        A full-screen, section→column→widget visual page builder for EPRO (Elementor-style model). Pairs with the EPRO — Classic theme. v0.1 foundation: add/edit/reorder widgets, save, live preview.
 * Version:           0.1.0
 * Requires at least: 6.4
 * Requires PHP:      8.0
 * Author:            EPRO
 * Author URI:        https://epro.uz
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       epro-builder
 *
 * @package epro-builder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EPRO_BUILDER_VERSION', '0.1.0' );
define( 'EPRO_BUILDER_FILE', __FILE__ );
define( 'EPRO_BUILDER_DIR', plugin_dir_path( __FILE__ ) );
define( 'EPRO_BUILDER_URL', plugin_dir_url( __FILE__ ) );

require_once EPRO_BUILDER_DIR . 'includes/class-epro-builder-data.php';
require_once EPRO_BUILDER_DIR . 'includes/class-epro-builder-renderer.php';
require_once EPRO_BUILDER_DIR . 'includes/class-epro-builder-rest.php';
require_once EPRO_BUILDER_DIR . 'includes/class-epro-builder-editor.php';

/**
 * Boot the plugin.
 */
function epro_builder_init() {
	EPRO_Builder_Data::init();
	EPRO_Builder_REST::init();
	EPRO_Builder_Editor::init();
}
add_action( 'plugins_loaded', 'epro_builder_init' );

/**
 * Load translations.
 */
function epro_builder_load_textdomain() {
	load_plugin_textdomain( 'epro-builder', false, dirname( plugin_basename( EPRO_BUILDER_FILE ) ) . '/languages' );
}
add_action( 'init', 'epro_builder_load_textdomain' );
