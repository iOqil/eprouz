<?php
/**
 * Renderer: turns the layout tree into Tailwind-styled HTML for the front-end.
 * Pairs with the EPRO — Classic theme (Tailwind + dark mode already loaded).
 *
 * @package epro-builder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPRO_Builder_Renderer {

	/**
	 * Render a post's full layout.
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	public static function render( $post_id ) {
		$data = EPRO_Builder_Data::get_data( $post_id );
		if ( empty( $data['sections'] ) ) {
			return '';
		}
		$out = '<div class="epro-builder-content">';
		foreach ( $data['sections'] as $section ) {
			$out .= self::section( $section );
		}
		$out .= '</div>';
		return $out;
	}

	/**
	 * @param array $section Section node.
	 * @return string
	 */
	private static function section( $section ) {
		$s   = $section['settings'];
		$bg  = array(
			'white'    => 'bg-white dark:bg-neutral-950',
			'base'     => 'bg-neutral-50 dark:bg-neutral-900/30',
			'dark'     => 'bg-neutral-950 text-white',
			'gradient' => 'bg-gradient-to-br from-primary-600 via-primary-700 to-purple-700 text-white',
		);
		$pad = array(
			'none' => '',
			'sm'   => 'py-8',
			'md'   => 'py-16 sm:py-20',
			'lg'   => 'py-24 sm:py-32',
		);
		$inner = 'full' === $s['width'] ? 'w-full px-4 sm:px-6 lg:px-8' : 'mx-auto max-w-7xl px-4 sm:px-6 lg:px-8';

		$cols = '';
		$count = count( $section['columns'] );
		foreach ( $section['columns'] as $col ) {
			$cols .= self::column( $col, $count );
		}

		return sprintf(
			'<section class="%1$s %2$s"><div class="%3$s"><div class="flex flex-col md:flex-row flex-wrap gap-6 md:gap-8">%4$s</div></div></section>',
			esc_attr( $bg[ $s['background'] ] ?? $bg['white'] ),
			esc_attr( $pad[ $s['padding'] ] ?? $pad['md'] ),
			esc_attr( $inner ),
			$cols
		);
	}

	/**
	 * @param array $col   Column node.
	 * @param int   $count Sibling count.
	 * @return string
	 */
	private static function column( $col, $count ) {
		$widgets = '';
		foreach ( $col['widgets'] as $w ) {
			$widgets .= self::widget( $w );
		}
		// Vertical rhythm between widgets in a column.
		$inner = sprintf( '<div class="flex flex-col gap-6">%s</div>', $widgets );
		// Single column = full width. Multi-column shares the row via inline flex-basis
		// (full width on mobile where the row wraps to a column).
		if ( $count > 1 ) {
			$basis = max( 10, min( 100, (float) $col['settings']['width'] ) );
			return sprintf(
				'<div class="w-full min-w-0 md:w-auto" style="flex:1 1 0;min-width:min(100%%,%1$srem)">%2$s</div>',
				esc_attr( ( $basis / 100 ) * 70 ),
				$inner
			);
		}
		return sprintf( '<div class="w-full min-w-0">%s</div>', $inner );
	}

	/**
	 * @param array $w Widget node.
	 * @return string
	 */
	private static function widget( $w ) {
		$s     = $w['settings'];
		$align = array( 'left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right' );

		switch ( $w['type'] ) {
			case 'heading':
				$sizes = array(
					'h1' => 'text-4xl sm:text-5xl lg:text-6xl',
					'h2' => 'text-3xl sm:text-4xl',
					'h3' => 'text-xl sm:text-2xl',
					'h4' => 'text-lg sm:text-xl',
				);
				$tag = in_array( $s['level'], array( 'h1', 'h2', 'h3', 'h4' ), true ) ? $s['level'] : 'h2';
				return sprintf(
					'<%1$s class="epro-w font-display font-bold text-neutral-900 dark:text-white %2$s %3$s">%4$s</%1$s>',
					$tag,
					esc_attr( $sizes[ $tag ] ),
					esc_attr( $align[ $s['align'] ] ?? '' ),
					esc_html( $s['text'] )
				);

			case 'text':
				return sprintf(
					'<div class="epro-w prose dark:prose-invert max-w-none text-neutral-600 dark:text-neutral-400 %1$s">%2$s</div>',
					esc_attr( $align[ $s['align'] ] ?? '' ),
					wp_kses_post( $s['html'] )
				);

			case 'button':
				$variant = array(
					'primary' => 'bg-primary-500 text-white hover:bg-primary-600',
					'outline' => 'border border-neutral-300 dark:border-neutral-700 text-neutral-800 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-900',
					'ghost'   => 'text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800',
				);
				$size = array(
					'sm' => 'px-3 py-1.5 text-sm',
					'md' => 'px-3.5 py-2 text-sm',
					'lg' => 'px-4 py-2.5 text-base',
					'xl' => 'px-5 py-3 text-base',
				);
				$wrap = array( 'left' => '', 'center' => 'text-center', 'right' => 'text-right' );
				return sprintf(
					'<div class="epro-w %1$s"><a href="%2$s" class="inline-flex items-center justify-center gap-2 rounded-md font-medium transition-colors %3$s %4$s">%5$s</a></div>',
					esc_attr( $wrap[ $s['align'] ] ?? '' ),
					esc_url( $s['url'] ? $s['url'] : '#' ),
					esc_attr( $variant[ $s['variant'] ] ?? $variant['primary'] ),
					esc_attr( $size[ $s['size'] ] ?? $size['lg'] ),
					esc_html( $s['text'] )
				);

			case 'image':
				if ( ! $s['url'] && ! $s['id'] ) {
					return '';
				}
				$src     = $s['url'];
				if ( ! $src && $s['id'] ) {
					$src = wp_get_attachment_image_url( $s['id'], 'large' );
				}
				$wrap = array( 'left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right' );
				return sprintf(
					'<div class="epro-w %1$s"><img src="%2$s" alt="%3$s" loading="lazy" class="inline-block h-auto max-w-full %4$s" /></div>',
					esc_attr( $wrap[ $s['align'] ] ?? 'text-center' ),
					esc_url( $src ),
					esc_attr( $s['alt'] ),
					$s['rounded'] ? 'rounded-2xl' : ''
				);

			case 'spacer':
				return sprintf( '<div class="epro-w" style="height:%dpx" aria-hidden="true"></div>', (int) $s['height'] );

			case 'divider':
				return '<hr class="epro-w border-0 border-t border-neutral-200 dark:border-neutral-800 my-2" />';

			case 'hero':
				return self::hero( $s );

			case 'cta':
				return self::cta( $s );
		}
		return '';
	}

	/**
	 * Hero preset.
	 *
	 * @param array $s Settings.
	 * @return string
	 */
	private static function hero( $s ) {
		$badge = $s['badge'] ? sprintf(
			'<span class="inline-flex items-center rounded-full bg-primary-50 dark:bg-primary-950 text-primary-700 dark:text-primary-300 px-3 py-1 text-sm font-medium mb-6"><span class="size-2 rounded-full bg-primary-500 animate-pulse mr-2"></span>%s</span>',
			esc_html( $s['badge'] )
		) : '';

		$accent = $s['title_accent'] ? sprintf(
			' <span class="bg-gradient-to-r from-primary-500 to-purple-500 bg-clip-text text-transparent">%s</span>',
			esc_html( $s['title_accent'] )
		) : '';

		$buttons = '';
		if ( $s['primary_text'] ) {
			$buttons .= sprintf( '<a href="%1$s" class="inline-flex items-center justify-center gap-2 rounded-md font-medium bg-primary-500 text-white hover:bg-primary-600 px-5 py-3 text-base">%2$s</a>', esc_url( $s['primary_url'] ? $s['primary_url'] : '#' ), esc_html( $s['primary_text'] ) );
		}
		if ( $s['secondary_text'] ) {
			$buttons .= sprintf( '<a href="%1$s" class="inline-flex items-center justify-center gap-2 rounded-md font-medium border border-neutral-300 dark:border-neutral-700 text-neutral-800 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-900 px-5 py-3 text-base">%2$s</a>', esc_url( $s['secondary_url'] ? $s['secondary_url'] : '#' ), esc_html( $s['secondary_text'] ) );
		}
		$note = $s['note'] ? sprintf( '<p class="mt-6 text-sm text-neutral-500">%s</p>', esc_html( $s['note'] ) ) : '';

		return sprintf(
			'<div class="epro-w text-center max-w-4xl mx-auto">%1$s<h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-neutral-900 dark:text-white leading-tight">%2$s%3$s</h1><p class="mt-6 text-lg sm:text-xl text-neutral-600 dark:text-neutral-400 max-w-2xl mx-auto">%4$s</p><div class="mt-10 flex flex-col sm:flex-row gap-3 justify-center">%5$s</div>%6$s</div>',
			$badge,
			esc_html( $s['title'] ),
			$accent,
			esc_html( $s['subtitle'] ),
			$buttons,
			$note
		);
	}

	/**
	 * CTA preset.
	 *
	 * @param array $s Settings.
	 * @return string
	 */
	private static function cta( $s ) {
		$button = $s['button_text'] ? sprintf(
			'<div class="mt-8"><a href="%1$s" class="inline-flex items-center justify-center gap-2 rounded-md font-medium bg-white text-primary-700 hover:bg-neutral-100 px-5 py-3 text-base">%2$s</a></div>',
			esc_url( $s['button_url'] ? $s['button_url'] : '#' ),
			esc_html( $s['button_text'] )
		) : '';

		return sprintf(
			'<div class="epro-w relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-600 via-primary-700 to-purple-700 p-8 sm:p-16 text-center"><h2 class="font-display text-3xl sm:text-4xl font-bold text-white">%1$s</h2><p class="mt-4 text-lg text-primary-100 max-w-2xl mx-auto">%2$s</p>%3$s</div>',
			esc_html( $s['title'] ),
			esc_html( $s['subtitle'] ),
			$button
		);
	}
}
