<?php
/**
 * Data layer: stores & sanitizes the builder layout tree in post meta.
 *
 * Layout shape:
 *   { "version":1, "sections":[
 *       { "id":"s1","type":"section","settings":{...},"columns":[
 *           { "id":"c1","type":"column","settings":{"width":100},"widgets":[
 *               { "id":"w1","type":"heading","settings":{...} }, ...
 *           ]}
 *       ]}
 *   ]}
 *
 * @package epro-builder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPRO_Builder_Data {

	const META_ENABLED = '_epro_builder_enabled';
	const META_DATA    = '_epro_builder_data';

	/**
	 * Register meta.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_meta' ) );
	}

	/**
	 * Post types the builder can edit.
	 *
	 * @return string[]
	 */
	public static function post_types() {
		return apply_filters( 'epro_builder_post_types', array( 'page', 'post' ) );
	}

	/**
	 * Register the meta keys (auth-gated, not exposed raw to REST — we handle REST ourselves).
	 */
	public static function register_meta() {
		foreach ( self::post_types() as $type ) {
			register_post_meta( $type, self::META_ENABLED, array(
				'type'          => 'boolean',
				'single'        => true,
				'show_in_rest'  => false,
				'auth_callback' => function ( $allowed, $meta, $post_id ) {
					return current_user_can( 'edit_post', $post_id );
				},
			) );
		}
	}

	/**
	 * Is the builder enabled for this post?
	 *
	 * @param int $post_id Post ID.
	 * @return bool
	 */
	public static function is_enabled( $post_id ) {
		return (bool) get_post_meta( $post_id, self::META_ENABLED, true );
	}

	/**
	 * Get the decoded layout tree (always returns a well-formed array).
	 *
	 * @param int $post_id Post ID.
	 * @return array
	 */
	public static function get_data( $post_id ) {
		$raw = get_post_meta( $post_id, self::META_DATA, true );
		$data = is_string( $raw ) && '' !== $raw ? json_decode( $raw, true ) : $raw;
		if ( ! is_array( $data ) || empty( $data['sections'] ) || ! is_array( $data['sections'] ) ) {
			return array( 'version' => 1, 'sections' => array() );
		}
		return array(
			'version'  => 1,
			'sections' => array_values( array_filter( array_map( array( __CLASS__, 'sanitize_section' ), $data['sections'] ) ) ),
		);
	}

	/**
	 * Persist layout + enabled flag.
	 *
	 * @param int   $post_id Post ID.
	 * @param array $data    Raw layout from the editor.
	 * @param bool  $enabled Whether the builder owns this page.
	 */
	public static function save_data( $post_id, $data, $enabled = true ) {
		$clean = array(
			'version'  => 1,
			'sections' => array(),
		);
		if ( isset( $data['sections'] ) && is_array( $data['sections'] ) ) {
			$clean['sections'] = array_values( array_filter( array_map( array( __CLASS__, 'sanitize_section' ), $data['sections'] ) ) );
		}
		update_post_meta( $post_id, self::META_DATA, wp_slash( wp_json_encode( $clean ) ) );
		update_post_meta( $post_id, self::META_ENABLED, $enabled ? 1 : 0 );
		return $clean;
	}

	/* --------------------------------------------------------------------- *
	 * Sanitization (recursive, type-whitelisted)
	 * --------------------------------------------------------------------- */

	/**
	 * Allowed widget types.
	 *
	 * @return string[]
	 */
	public static function widget_types() {
		return array( 'heading', 'text', 'button', 'image', 'spacer', 'divider', 'hero', 'cta' );
	}

	/**
	 * @param mixed $section Raw section.
	 * @return array|null
	 */
	public static function sanitize_section( $section ) {
		if ( ! is_array( $section ) ) {
			return null;
		}
		$columns = array();
		if ( isset( $section['columns'] ) && is_array( $section['columns'] ) ) {
			$columns = array_values( array_filter( array_map( array( __CLASS__, 'sanitize_column' ), $section['columns'] ) ) );
		}
		if ( empty( $columns ) ) {
			$columns = array( array( 'id' => self::id( 'c' ), 'type' => 'column', 'settings' => array( 'width' => 100 ), 'widgets' => array() ) );
		}
		$s = isset( $section['settings'] ) && is_array( $section['settings'] ) ? $section['settings'] : array();
		return array(
			'id'       => self::id( 's', $section ),
			'type'     => 'section',
			'settings' => array(
				'background' => self::enum( $s['background'] ?? 'white', array( 'white', 'base', 'dark', 'gradient' ), 'white' ),
				'padding'    => self::enum( $s['padding'] ?? 'md', array( 'none', 'sm', 'md', 'lg' ), 'md' ),
				'width'      => self::enum( $s['width'] ?? 'boxed', array( 'boxed', 'full' ), 'boxed' ),
			),
			'columns'  => $columns,
		);
	}

	/**
	 * @param mixed $column Raw column.
	 * @return array|null
	 */
	public static function sanitize_column( $column ) {
		if ( ! is_array( $column ) ) {
			return null;
		}
		$widgets = array();
		if ( isset( $column['widgets'] ) && is_array( $column['widgets'] ) ) {
			$widgets = array_values( array_filter( array_map( array( __CLASS__, 'sanitize_widget' ), $column['widgets'] ) ) );
		}
		$width = isset( $column['settings']['width'] ) ? (float) $column['settings']['width'] : 100;
		$width = max( 10, min( 100, $width ) );
		return array(
			'id'       => self::id( 'c', $column ),
			'type'     => 'column',
			'settings' => array( 'width' => $width ),
			'widgets'  => $widgets,
		);
	}

	/**
	 * @param mixed $widget Raw widget.
	 * @return array|null
	 */
	public static function sanitize_widget( $widget ) {
		if ( ! is_array( $widget ) || empty( $widget['type'] ) ) {
			return null;
		}
		$type = sanitize_key( $widget['type'] );
		if ( ! in_array( $type, self::widget_types(), true ) ) {
			return null;
		}
		$in = isset( $widget['settings'] ) && is_array( $widget['settings'] ) ? $widget['settings'] : array();

		switch ( $type ) {
			case 'heading':
				$settings = array(
					'text'  => sanitize_text_field( $in['text'] ?? '' ),
					'level' => self::enum( $in['level'] ?? 'h2', array( 'h1', 'h2', 'h3', 'h4' ), 'h2' ),
					'align' => self::enum( $in['align'] ?? 'left', array( 'left', 'center', 'right' ), 'left' ),
				);
				break;
			case 'text':
				$settings = array(
					'html'  => wp_kses_post( $in['html'] ?? '' ),
					'align' => self::enum( $in['align'] ?? 'left', array( 'left', 'center', 'right' ), 'left' ),
				);
				break;
			case 'button':
				$settings = array(
					'text'    => sanitize_text_field( $in['text'] ?? '' ),
					'url'     => esc_url_raw( $in['url'] ?? '' ),
					'variant' => self::enum( $in['variant'] ?? 'primary', array( 'primary', 'outline', 'ghost' ), 'primary' ),
					'size'    => self::enum( $in['size'] ?? 'lg', array( 'sm', 'md', 'lg', 'xl' ), 'lg' ),
					'align'   => self::enum( $in['align'] ?? 'left', array( 'left', 'center', 'right' ), 'left' ),
				);
				break;
			case 'image':
				$settings = array(
					'id'      => isset( $in['id'] ) ? absint( $in['id'] ) : 0,
					'url'     => esc_url_raw( $in['url'] ?? '' ),
					'alt'     => sanitize_text_field( $in['alt'] ?? '' ),
					'rounded' => ! empty( $in['rounded'] ) ? 1 : 0,
					'align'   => self::enum( $in['align'] ?? 'center', array( 'left', 'center', 'right' ), 'center' ),
				);
				break;
			case 'spacer':
				$settings = array( 'height' => max( 0, min( 400, absint( $in['height'] ?? 40 ) ) ) );
				break;
			case 'divider':
				$settings = array();
				break;
			case 'hero':
				$settings = array(
					'badge'          => sanitize_text_field( $in['badge'] ?? '' ),
					'title'          => sanitize_text_field( $in['title'] ?? '' ),
					'title_accent'   => sanitize_text_field( $in['title_accent'] ?? '' ),
					'subtitle'       => sanitize_textarea_field( $in['subtitle'] ?? '' ),
					'primary_text'   => sanitize_text_field( $in['primary_text'] ?? '' ),
					'primary_url'    => esc_url_raw( $in['primary_url'] ?? '' ),
					'secondary_text' => sanitize_text_field( $in['secondary_text'] ?? '' ),
					'secondary_url'  => esc_url_raw( $in['secondary_url'] ?? '' ),
					'note'           => sanitize_text_field( $in['note'] ?? '' ),
				);
				break;
			case 'cta':
				$settings = array(
					'title'       => sanitize_text_field( $in['title'] ?? '' ),
					'subtitle'    => sanitize_textarea_field( $in['subtitle'] ?? '' ),
					'button_text' => sanitize_text_field( $in['button_text'] ?? '' ),
					'button_url'  => esc_url_raw( $in['button_url'] ?? '' ),
				);
				break;
			default:
				$settings = array();
		}

		return array(
			'id'       => self::id( 'w', $widget ),
			'type'     => $type,
			'settings' => $settings,
		);
	}

	/**
	 * Whitelist helper.
	 *
	 * @param mixed    $value   Value.
	 * @param string[] $allowed Allowed values.
	 * @param string   $default Default.
	 * @return string
	 */
	private static function enum( $value, $allowed, $default ) {
		$value = is_string( $value ) ? $value : '';
		return in_array( $value, $allowed, true ) ? $value : $default;
	}

	/**
	 * Keep a sanitized existing id, else generate one.
	 *
	 * @param string $prefix Id prefix.
	 * @param array  $node   Optional node carrying an id.
	 * @return string
	 */
	private static function id( $prefix, $node = array() ) {
		if ( is_array( $node ) && ! empty( $node['id'] ) ) {
			$clean = preg_replace( '/[^a-zA-Z0-9_-]/', '', (string) $node['id'] );
			if ( $clean ) {
				return $clean;
			}
		}
		return $prefix . '_' . wp_generate_uuid4();
	}
}
