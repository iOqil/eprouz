<?php
/**
 * Front-end canvas: renders the builder layout inside the active theme's
 * header/footer (full width — no theme content container).
 *
 * @package epro-builder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$epro_builder_id = get_queried_object_id();

if ( have_posts() ) {
	the_post(); // Set up post data (title, etc.) for template tags.
}

// Renderer output is fully escaped per-widget inside the renderer.
echo EPRO_Builder_Renderer::render( $epro_builder_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

get_footer();
