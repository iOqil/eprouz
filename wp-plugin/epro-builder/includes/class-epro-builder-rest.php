<?php
/**
 * REST API: load & save a post's builder layout.
 *
 * @package epro-builder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPRO_Builder_REST {

	const NS = 'epro-builder/v1';

	/**
	 * Hook routes.
	 */
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'routes' ) );
	}

	/**
	 * Register routes.
	 */
	public static function routes() {
		register_rest_route( self::NS, '/layout/(?P<id>\d+)', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( __CLASS__, 'get_layout' ),
				'permission_callback' => array( __CLASS__, 'can_edit' ),
				'args'                => array( 'id' => array( 'validate_callback' => 'is_numeric' ) ),
			),
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( __CLASS__, 'save_layout' ),
				'permission_callback' => array( __CLASS__, 'can_edit' ),
				'args'                => array( 'id' => array( 'validate_callback' => 'is_numeric' ) ),
			),
		) );
	}

	/**
	 * Capability check.
	 *
	 * @param WP_REST_Request $request Request.
	 * @return bool|WP_Error
	 */
	public static function can_edit( $request ) {
		$id = (int) $request['id'];
		if ( ! $id || ! get_post( $id ) ) {
			return new WP_Error( 'epro_no_post', __( 'Post not found.', 'epro-builder' ), array( 'status' => 404 ) );
		}
		return current_user_can( 'edit_post', $id );
	}

	/**
	 * GET handler.
	 *
	 * @param WP_REST_Request $request Request.
	 * @return WP_REST_Response
	 */
	public static function get_layout( $request ) {
		$id = (int) $request['id'];
		return rest_ensure_response( array(
			'enabled' => EPRO_Builder_Data::is_enabled( $id ),
			'data'    => EPRO_Builder_Data::get_data( $id ),
			'title'   => get_the_title( $id ),
		) );
	}

	/**
	 * POST handler.
	 *
	 * @param WP_REST_Request $request Request.
	 * @return WP_REST_Response
	 */
	public static function save_layout( $request ) {
		$id      = (int) $request['id'];
		$body    = $request->get_json_params();
		$data    = isset( $body['data'] ) && is_array( $body['data'] ) ? $body['data'] : array( 'sections' => array() );
		$enabled = isset( $body['enabled'] ) ? (bool) $body['enabled'] : true;

		$clean = EPRO_Builder_Data::save_data( $id, $data, $enabled );

		return rest_ensure_response( array(
			'saved' => true,
			'data'  => $clean,
		) );
	}
}
