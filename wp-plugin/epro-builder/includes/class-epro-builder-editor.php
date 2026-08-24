<?php
/**
 * Editor integration: full-screen builder route, asset enqueue, entry points
 * (meta box + row action), and front-end rendering of builder pages.
 *
 * @package epro-builder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPRO_Builder_Editor {

	const PAGE = 'epro-builder';

	/**
	 * Hook suffix returned by add_submenu_page (avoids guessing the screen id).
	 *
	 * @var string|false
	 */
	private static $hook = '';

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'register_page' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
		add_filter( 'admin_body_class', array( __CLASS__, 'body_class' ) );

		add_action( 'add_meta_boxes', array( __CLASS__, 'meta_box' ) );
		add_filter( 'page_row_actions', array( __CLASS__, 'row_action' ), 10, 2 );
		add_filter( 'post_row_actions', array( __CLASS__, 'row_action' ), 10, 2 );

		add_filter( 'template_include', array( __CLASS__, 'template_include' ) );
		add_filter( 'body_class', array( __CLASS__, 'front_body_class' ) );
	}

	/**
	 * URL to open the builder for a post.
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	public static function edit_url( $post_id ) {
		return admin_url( 'admin.php?page=' . self::PAGE . '&post=' . absint( $post_id ) );
	}

	/* ----------------------------------------------------------- Full-screen page */

	/**
	 * Register the hidden full-screen admin page.
	 */
	public static function register_page() {
		self::$hook = add_submenu_page(
			'',
			__( 'EPRO Builder', 'epro-builder' ),
			__( 'EPRO Builder', 'epro-builder' ),
			'edit_posts',
			self::PAGE,
			array( __CLASS__, 'render_page' )
		);
	}

	/**
	 * Render the app root.
	 */
	public static function render_page() {
		$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! $post_id || ! current_user_can( 'edit_post', $post_id ) ) {
			wp_die( esc_html__( 'Bu sahifani tahrirlashga ruxsat yo\'q.', 'epro-builder' ) );
		}
		echo '<div id="epro-builder-root" class="epro-builder-root"></div>';
	}

	/**
	 * Is the current admin screen our builder page?
	 *
	 * @param string $hook Current admin page hook.
	 * @return bool
	 */
	private static function is_builder_screen( $hook ) {
		return self::$hook && $hook === self::$hook;
	}

	/**
	 * Enqueue the editor app on the builder screen.
	 *
	 * @param string $hook Admin page hook.
	 */
	public static function enqueue( $hook ) {
		if ( ! self::is_builder_screen( $hook ) ) {
			return;
		}
		$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		wp_enqueue_style( 'wp-components' );
		wp_enqueue_style(
			'epro-builder-editor',
			EPRO_BUILDER_URL . 'assets/css/editor.css',
			array( 'wp-components' ),
			EPRO_BUILDER_VERSION
		);
		wp_enqueue_media();

		wp_enqueue_script(
			'epro-builder-app',
			EPRO_BUILDER_URL . 'assets/js/app.js',
			array( 'wp-element', 'wp-components', 'wp-api-fetch', 'wp-i18n' ),
			EPRO_BUILDER_VERSION,
			true
		);

		$preview = get_preview_post_link( $post_id );
		if ( ! $preview ) {
			$preview = get_permalink( $post_id );
		}

		wp_localize_script( 'epro-builder-app', 'eproBuilder', array(
			'postId'     => $post_id,
			'title'      => get_the_title( $post_id ),
			'restBase'   => esc_url_raw( rest_url( EPRO_Builder_REST::NS ) ),
			'nonce'      => wp_create_nonce( 'wp_rest' ),
			'previewUrl' => $preview ? $preview : home_url( '/?page_id=' . $post_id ),
			'exitUrl'    => get_edit_post_link( $post_id, 'raw' ),
		) );
	}

	/**
	 * Full-screen body class on the builder page.
	 *
	 * @param string $classes Existing classes.
	 * @return string
	 */
	public static function body_class( $classes ) {
		$screen = get_current_screen();
		if ( $screen && self::$hook && $screen->id === self::$hook ) {
			$classes .= ' epro-builder-fullscreen';
		}
		return $classes;
	}

	/* ----------------------------------------------------------- Entry points */

	/**
	 * Meta box with the "Edit with EPRO Builder" button.
	 */
	public static function meta_box() {
		foreach ( EPRO_Builder_Data::post_types() as $type ) {
			add_meta_box(
				'epro_builder_box',
				__( 'EPRO Builder', 'epro-builder' ),
				array( __CLASS__, 'render_meta_box' ),
				$type,
				'side',
				'high'
			);
		}
	}

	/**
	 * @param WP_Post $post Current post.
	 */
	public static function render_meta_box( $post ) {
		$enabled = EPRO_Builder_Data::is_enabled( $post->ID );
		echo '<p>';
		echo $enabled
			? '<strong style="color:#16a34a;">' . esc_html__( '✓ Builder yoqilgan', 'epro-builder' ) . '</strong>'
			: esc_html__( 'Bu sahifani vizual builderda tahrirlang.', 'epro-builder' );
		echo '</p>';
		printf(
			'<a href="%1$s" class="button button-primary button-large" style="width:100%%;text-align:center;">%2$s</a>',
			esc_url( self::edit_url( $post->ID ) ),
			esc_html__( '✎ EPRO Builder bilan tahrirlash', 'epro-builder' )
		);
		if ( $enabled ) {
			echo '<p style="margin-top:8px;font-size:11px;color:#646970;">' . esc_html__( 'Builder yoqilganda sahifa kontenti builder bilan chiziladi.', 'epro-builder' ) . '</p>';
		}
	}

	/**
	 * Row action link in the posts/pages list.
	 *
	 * @param array   $actions Existing actions.
	 * @param WP_Post $post    Post.
	 * @return array
	 */
	public static function row_action( $actions, $post ) {
		if ( in_array( $post->post_type, EPRO_Builder_Data::post_types(), true ) && current_user_can( 'edit_post', $post->ID ) ) {
			$actions['epro_builder'] = sprintf(
				'<a href="%1$s">%2$s</a>',
				esc_url( self::edit_url( $post->ID ) ),
				esc_html__( 'EPRO Builder', 'epro-builder' )
			);
		}
		return $actions;
	}

	/* ----------------------------------------------------------- Front-end render */

	/**
	 * Swap in the builder canvas template when enabled.
	 *
	 * @param string $template Resolved template.
	 * @return string
	 */
	public static function template_include( $template ) {
		if ( is_singular() && EPRO_Builder_Data::is_enabled( get_queried_object_id() ) ) {
			$canvas = EPRO_BUILDER_DIR . 'templates/canvas.php';
			if ( file_exists( $canvas ) ) {
				return $canvas;
			}
		}
		return $template;
	}

	/**
	 * Body class for builder-rendered pages.
	 *
	 * @param string[] $classes Classes.
	 * @return string[]
	 */
	public static function front_body_class( $classes ) {
		if ( is_singular() && EPRO_Builder_Data::is_enabled( get_queried_object_id() ) ) {
			$classes[] = 'epro-builder-page';
		}
		return $classes;
	}
}
