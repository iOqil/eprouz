<?php
/**
 * Shared template tags: breadcrumbs, reading time, post meta and post
 * navigation. These helpers keep the singular and archive templates lean and
 * give the blog a consistent, accessible chrome across the theme.
 *
 * @package epro-classic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'epro_breadcrumbs' ) ) :
	/**
	 * Echo an accessible breadcrumb trail for the current view.
	 *
	 * @return void
	 */
	function epro_breadcrumbs() {
		$sep = epro_icon( 'arrow-right', 'size-3 text-neutral-400' );

		// Build the trail as [ label, url|null ]; the last crumb is the current page.
		$crumbs   = array();
		$crumbs[] = array(
			'label' => __( 'Bosh sahifa', 'epro-classic' ),
			'url'   => home_url( '/' ),
		);

		if ( is_singular( 'post' ) ) {
			$posts_page = (int) get_option( 'page_for_posts' );
			$blog_url   = $posts_page ? get_permalink( $posts_page ) : home_url( '/blog' );
			$crumbs[]   = array(
				'label' => __( 'Blog', 'epro-classic' ),
				'url'   => $blog_url,
			);
			$crumbs[] = array(
				'label' => get_the_title(),
				'url'   => null,
			);
		} elseif ( is_page() ) {
			$crumbs[] = array(
				'label' => get_the_title(),
				'url'   => null,
			);
		} elseif ( is_category() || is_tag() || is_archive() ) {
			$crumbs[] = array(
				'label' => wp_strip_all_tags( get_the_archive_title() ),
				'url'   => null,
			);
		} elseif ( is_search() ) {
			$crumbs[] = array(
				'label' => __( 'Qidiruv', 'epro-classic' ),
				'url'   => null,
			);
		}

		echo '<nav aria-label="' . esc_attr__( 'Breadcrumb', 'epro-classic' ) . '" class="text-sm text-neutral-500 mb-8">';
		echo '<ol class="inline-flex items-center gap-2">';

		$last = count( $crumbs ) - 1;
		foreach ( $crumbs as $i => $crumb ) {
			echo '<li class="inline-flex items-center gap-2">';

			if ( $i > 0 ) {
				echo $sep; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted inline SVG.
			}

			if ( ! empty( $crumb['url'] ) && $i !== $last ) {
				echo '<a href="' . esc_url( $crumb['url'] ) . '" class="hover:text-primary-600 dark:hover:text-primary-400">' . esc_html( $crumb['label'] ) . '</a>';
			} else {
				echo '<span class="text-neutral-700 dark:text-neutral-300" aria-current="page">' . esc_html( $crumb['label'] ) . '</span>';
			}

			echo '</li>';
		}

		echo '</ol>';
		echo '</nav>';
	}
endif;

if ( ! function_exists( 'epro_reading_time' ) ) :
	/**
	 * Estimate the reading time of a post in minutes (>= 1).
	 *
	 * @param int|null $post_id Optional post ID; defaults to the current post.
	 * @return int Minutes to read.
	 */
	function epro_reading_time( $post_id = null ) {
		$content = wp_strip_all_tags( get_post_field( 'post_content', $post_id ) );
		// Unicode-aware word count so Cyrillic / Uzbek content is measured too.
		$words = preg_match_all( '/[\p{L}\p{N}]+/u', $content );
		return max( 1, (int) round( $words / 200 ) );
	}
endif;

if ( ! function_exists( 'epro_post_meta' ) ) :
	/**
	 * Echo the publish date and reading time for the current post.
	 *
	 * @return void
	 */
	function epro_post_meta() {
		echo '<div class="flex items-center gap-3 text-sm text-neutral-500">';

		echo '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" class="inline-flex items-center gap-1.5">';
		echo epro_icon( 'clock', 'size-4 text-neutral-400' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted inline SVG.
		echo esc_html( get_the_date() );
		echo '</time>';

		echo '<span aria-hidden="true">&middot;</span>';

		echo '<span>';
		printf(
			/* translators: %d: estimated reading time in minutes. */
			esc_html__( '%d daq o\'qish', 'epro-classic' ),
			(int) epro_reading_time()
		);
		echo '</span>';

		echo '</div>';
	}
endif;

if ( ! function_exists( 'epro_post_navigation' ) ) :
	/**
	 * Echo the previous/next single-post navigation, styled for the theme.
	 *
	 * @return void
	 */
	function epro_post_navigation() {
		echo '<div class="mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-800 text-sm">';
		the_post_navigation(
			array(
				/* translators: %s: left arrow glyph. */
				'prev_text' => sprintf( esc_html__( '%s Oldingi maqola', 'epro-classic' ), "\xE2\x86\x90" ),
				/* translators: %s: right arrow glyph. */
				'next_text' => sprintf( esc_html__( 'Keyingi maqola %s', 'epro-classic' ), "\xE2\x86\x92" ),
			)
		);
		echo '</div>';
	}
endif;
