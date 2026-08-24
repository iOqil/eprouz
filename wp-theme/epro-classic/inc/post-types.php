<?php
/**
 * Dynamic content types for repeatable sections:
 *  - epro_logo    : trusted-by logos (each = a post with a Media Library image).
 *  - epro_feature : feature cards (title + description + an icon).
 *
 * These replace the old fixed-count Customizer fields so items can be added,
 * removed and reordered freely from the WordPress admin.
 *
 * @package epro-classic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Logo and Feature post types.
 */
function epro_register_post_types() {
	register_post_type(
		'epro_logo',
		array(
			'labels'              => array(
				'name'                  => __( 'Logotiplar', 'epro-classic' ),
				'singular_name'         => __( 'Logotip', 'epro-classic' ),
				'add_new'               => __( 'Yangi qo\'shish', 'epro-classic' ),
				'add_new_item'          => __( 'Yangi logotip', 'epro-classic' ),
				'edit_item'             => __( 'Logotipni tahrirlash', 'epro-classic' ),
				'new_item'              => __( 'Yangi logotip', 'epro-classic' ),
				'view_item'             => __( 'Logotipni ko\'rish', 'epro-classic' ),
				'all_items'             => __( 'Barcha logotiplar', 'epro-classic' ),
				'search_items'          => __( 'Logotip qidirish', 'epro-classic' ),
				'not_found'             => __( 'Logotip topilmadi.', 'epro-classic' ),
				'featured_image'        => __( 'Logotip rasmi', 'epro-classic' ),
				'set_featured_image'    => __( 'Logotip rasmini tanlash', 'epro-classic' ),
				'use_featured_image'    => __( 'Logotip sifatida ishlatish', 'epro-classic' ),
				'menu_name'             => __( 'Logotiplar', 'epro-classic' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-images-alt2',
			'menu_position'       => 21,
			'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
			'has_archive'         => false,
			'rewrite'             => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
		)
	);

	register_post_type(
		'epro_feature',
		array(
			'labels'             => array(
				'name'           => __( 'Imkoniyatlar', 'epro-classic' ),
				'singular_name'  => __( 'Imkoniyat', 'epro-classic' ),
				'add_new'        => __( 'Yangi qo\'shish', 'epro-classic' ),
				'add_new_item'   => __( 'Yangi imkoniyat', 'epro-classic' ),
				'edit_item'      => __( 'Imkoniyatni tahrirlash', 'epro-classic' ),
				'new_item'       => __( 'Yangi imkoniyat', 'epro-classic' ),
				'all_items'      => __( 'Barcha imkoniyatlar', 'epro-classic' ),
				'search_items'   => __( 'Imkoniyat qidirish', 'epro-classic' ),
				'not_found'      => __( 'Imkoniyat topilmadi.', 'epro-classic' ),
				'menu_name'      => __( 'Imkoniyatlar', 'epro-classic' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-screenoptions',
			'menu_position'       => 22,
			'supports'            => array( 'title', 'editor', 'page-attributes' ),
			'has_archive'         => false,
			'rewrite'             => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
		)
	);
}
add_action( 'init', 'epro_register_post_types' );

/**
 * Register the feature-icon meta (stored per feature post).
 */
function epro_register_feature_meta() {
	register_post_meta(
		'epro_feature',
		'_epro_feature_icon',
		array(
			'type'              => 'string',
			'single'            => true,
			'default'           => 'graduation-cap',
			'sanitize_callback' => 'sanitize_key',
			'show_in_rest'      => false,
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);
}
add_action( 'init', 'epro_register_feature_meta' );

/**
 * Get a feature's icon name, falling back to a sensible default.
 *
 * @param int $post_id Feature post ID.
 * @return string
 */
function epro_feature_icon( $post_id ) {
	$icon    = get_post_meta( $post_id, '_epro_feature_icon', true );
	$choices = epro_icon_choices();
	return ( $icon && isset( $choices[ $icon ] ) ) ? $icon : 'graduation-cap';
}

/**
 * Add the icon picker meta box to the feature editor.
 */
function epro_add_feature_meta_box() {
	add_meta_box(
		'epro_feature_icon',
		__( 'Ikona', 'epro-classic' ),
		'epro_render_feature_meta_box',
		'epro_feature',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'epro_add_feature_meta_box' );

/**
 * Render the icon picker.
 *
 * @param WP_Post $post Current feature post.
 */
function epro_render_feature_meta_box( $post ) {
	wp_nonce_field( 'epro_save_feature_icon', 'epro_feature_icon_nonce' );
	$current = epro_feature_icon( $post->ID );
	echo '<p>' . esc_html__( 'Karta uchun ikonani tanlang:', 'epro-classic' ) . '</p>';
	echo '<select name="epro_feature_icon" style="width:100%;">';
	foreach ( epro_icon_choices() as $value => $label ) {
		printf(
			'<option value="%1$s" %2$s>%3$s</option>',
			esc_attr( $value ),
			selected( $current, $value, false ),
			esc_html( $label )
		);
	}
	echo '</select>';
}

/**
 * Persist the chosen icon.
 *
 * @param int $post_id Post being saved.
 */
function epro_save_feature_icon( $post_id ) {
	if ( ! isset( $_POST['epro_feature_icon_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['epro_feature_icon_nonce'] ) ), 'epro_save_feature_icon' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['epro_feature_icon'] ) ) {
		update_post_meta( $post_id, '_epro_feature_icon', sanitize_key( wp_unslash( $_POST['epro_feature_icon'] ) ) );
	}
}
add_action( 'save_post_epro_feature', 'epro_save_feature_icon' );

/**
 * Admin column showing the feature's icon name for quick scanning.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function epro_feature_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['epro_icon'] = __( 'Ikona', 'epro-classic' );
		}
	}
	return $new;
}
add_filter( 'manage_epro_feature_posts_columns', 'epro_feature_columns' );

/**
 * Render the icon admin column.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function epro_feature_column_content( $column, $post_id ) {
	if ( 'epro_icon' === $column ) {
		echo esc_html( epro_feature_icon( $post_id ) );
	}
}
add_action( 'manage_epro_feature_posts_custom_column', 'epro_feature_column_content', 10, 2 );
