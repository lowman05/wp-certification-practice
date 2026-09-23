<?php
/**
 * REST API functionality.
 *
 * @package WPCertificationPractice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles custom REST API endpoints.
 */
class WPCP_REST_API {

	/**
	 * Registers custom REST API routes.
	 *
	 * @return void
	 */
	public static function register_routes() {
		register_rest_route(
			'wpcp/v1',
			'/resources',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( __CLASS__, 'get_resources' ),
				'permission_callback' => array( __CLASS__, 'permissions_check' ),
				'args'                => array(
					'per_page'      => array(
						'description'       => __( 'Number of Resources to return.', 'wp-certification-practice' ),
						'type'              => 'integer',
						'default'           => 10,
						'sanitize_callback' => 'absint',
						'validate_callback' => array( __CLASS__, 'validate_per_page' ),
					),
					'page'          => array(
						'description'       => __( 'Current page of the Resource collection.', 'wp-certification-practice' ),
						'type'              => 'integer',
						'default'           => 1,
						'sanitize_callback' => 'absint',
						'validate_callback' => array( __CLASS__, 'validate_page' ),
					),
					'resource_type' => array(
						'description'       => __( 'Resource Type term slug.', 'wp-certification-practice' ),
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_key',
					),
				),
			)
		);
	}

	/**
	 * Validates the Resources per page parameter.
	 *
	 * @param mixed           $value   Parameter value.
	 * @param WP_REST_Request $request REST request object.
	 * @param string          $param   Parameter name.
	 * @return bool
	 */
	public static function validate_per_page( $value, $request, $param ) {
		unset( $request, $param );

		return is_numeric( $value ) && $value >= 1 && $value <= 100;
	}

	/**
	 * Validates the page parameter.
	 *
	 * @param mixed           $value   Parameter value.
	 * @param WP_REST_Request $request REST request object.
	 * @param string          $param   Parameter name.
	 * @return bool
	 */
	public static function validate_page( $value, $request, $param ) {
		unset( $request, $param );

		return is_numeric( $value ) && $value >= 1;
	}

	/**
	 * Checks whether the current user can access the endpoint.
	 *
	 * @return bool
	 */
	public static function permissions_check() {
		return current_user_can( 'edit_wpcp_resources' );
	}

	/**
	 * Returns Resources.
	 *
	 * @param WP_REST_Request $request REST request object.
	 * @return WP_REST_Response
	 */
	public static function get_resources( $request ) {
		$args = array(
			'post_type'      => 'wpcp_resource',
			'post_status'    => 'publish',
			'posts_per_page' => $request->get_param( 'per_page' ),
			'paged'          => $request->get_param( 'page' ),
		);

		$resource_type = $request->get_param( 'resource_type' );

		if ( $resource_type ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'wpcp_resource_type',
					'field'    => 'slug',
					'terms'    => $resource_type,
				),
			);
		}

		$query = new WP_Query( $args );

		$resources = array();

		foreach ( $query->posts as $resource ) {
			$resource_types = wp_get_post_terms(
				$resource->ID,
				'wpcp_resource_type',
				array(
					'fields' => 'names',
				)
			);

			$resources[] = array(
				'id'             => $resource->ID,
				'title'          => get_the_title( $resource ),
				'excerpt'        => get_the_excerpt( $resource ),
				'url'            => get_permalink( $resource ),
				'resource_types' => $resource_types,
			);
		}

		$response = new WP_REST_Response(
			array(
				'resources' => $resources,
				'total'     => (int) $query->found_posts,
			),
			200
		);

		$response->header( 'X-WP-Total', (int) $query->found_posts );
		$response->header( 'X-WP-TotalPages', (int) $query->max_num_pages );

		return $response;
	}
}
