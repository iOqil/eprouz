<?php
/**
 * Lightweight SEO / Open Graph meta output.
 *
 * Emits a minimal set of <meta> tags (description, Open Graph, Twitter Card)
 * when no dedicated SEO plugin (Yoast, Rank Math, AIOSEO) is active.
 *
 * @package epro-classic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output basic SEO / Open Graph / Twitter Card meta tags in <head>.
 *
 * Bails early if a known SEO plugin is handling meta output.
 *
 * @return void
 */
function epro_seo_meta() {
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) ) {
		return;
	}

	// Description.
	if ( is_singular() ) {
		$desc = wp_strip_all_tags( get_the_excerpt() );
	} else {
		$desc = get_bloginfo( 'description' );
	}

	if ( empty( $desc ) ) {
		$desc = get_bloginfo( 'description' );
	}

	$desc = trim( $desc );
	$desc = mb_substr( $desc, 0, 160 );

	// Canonical-ish URL for the current view.
	if ( is_front_page() ) {
		$url = home_url( '/' );
	} elseif ( is_singular() ) {
		$url = get_permalink();
	} else {
		$request = isset( $GLOBALS['wp']->request ) ? $GLOBALS['wp']->request : '';
		$url     = home_url( $request ? '/' . $request : '/' );
	}

	// Document title.
	$title = wp_get_document_title();

	// Sharing image.
	if ( is_singular() && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( null, 'large' );
	} elseif ( function_exists( 'get_site_icon_url' ) ) {
		$image = get_site_icon_url( 512 );
	} else {
		$image = '';
	}

	$og_type = is_singular() ? 'article' : 'website';

	printf( "<meta name=\"description\" content=\"%s\">\n", esc_attr( $desc ) );

	printf( "<meta property=\"og:type\" content=\"%s\">\n", esc_attr( $og_type ) );
	printf( "<meta property=\"og:title\" content=\"%s\">\n", esc_attr( $title ) );
	printf( "<meta property=\"og:description\" content=\"%s\">\n", esc_attr( $desc ) );
	printf( "<meta property=\"og:url\" content=\"%s\">\n", esc_url( $url ) );
	printf( "<meta property=\"og:site_name\" content=\"%s\">\n", esc_attr( get_bloginfo( 'name' ) ) );

	if ( $image ) {
		printf( "<meta property=\"og:image\" content=\"%s\">\n", esc_url( $image ) );
	}

	printf( "<meta name=\"twitter:card\" content=\"%s\">\n", esc_attr( 'summary_large_image' ) );
	printf( "<meta name=\"twitter:title\" content=\"%s\">\n", esc_attr( $title ) );
	printf( "<meta name=\"twitter:description\" content=\"%s\">\n", esc_attr( $desc ) );

	if ( $image ) {
		printf( "<meta name=\"twitter:image\" content=\"%s\">\n", esc_url( $image ) );
	}
}
add_action( 'wp_head', 'epro_seo_meta', 1 );
