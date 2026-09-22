<?php
/**
 * Custom post type registration.
 *
 * @package WPCertificationPractice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers plugin custom post types.
 */
class WPCP_Post_Types {

	/**
	 * Registers the Resource post type.
	 *
	 * @return void
	 */
	public static function register_resource() {
		$labels = array(
			'name'               => __( 'Resources', 'wp-certification-practice' ),
			'singular_name'      => __( 'Resource', 'wp-certification-practice' ),
			'add_new'            => __( 'Add New', 'wp-certification-practice' ),
			'add_new_item'       => __( 'Add New Resource', 'wp-certification-practice' ),
			'edit_item'          => __( 'Edit Resource', 'wp-certification-practice' ),
			'new_item'           => __( 'New Resource', 'wp-certification-practice' ),
			'view_item'          => __( 'View Resource', 'wp-certification-practice' ),
			'search_items'       => __( 'Search Resources', 'wp-certification-practice' ),
			'not_found'          => __( 'No resources found.', 'wp-certification-practice' ),
			'not_found_in_trash' => __( 'No resources found in Trash.', 'wp-certification-practice' ),
			'all_items'          => __( 'All Resources', 'wp-certification-practice' ),
			'menu_name'          => __( 'Resources', 'wp-certification-practice' ),
		);

		$args = array(
			'labels'          => $labels,
			'public'          => true,
			'show_in_rest'    => true,
			'has_archive'     => true,
			'capability_type' => array( 'wpcp_resource', 'wpcp_resources' ),
			'map_meta_cap'    => true,
			'rewrite'         => array(
				'slug' => 'resources',
			),
			'supports'        => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
			),
		);

		register_post_type( 'wpcp_resource', $args );
	}
}
