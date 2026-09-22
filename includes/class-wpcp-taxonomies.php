<?php
/**
 * Custom taxonomy registration.
 *
 * @package WPCertificationPractice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers plugin taxonomies.
 */
class WPCP_Taxonomies {

	/**
	 * Registers the Resource Type taxonomy.
	 *
	 * @return void
	 */
	public static function register_resource_type() {
		$labels = array(
			'name'              => __( 'Resource Types', 'wp-certification-practice' ),
			'singular_name'     => __( 'Resource Type', 'wp-certification-practice' ),
			'search_items'      => __( 'Search Resource Types', 'wp-certification-practice' ),
			'all_items'         => __( 'All Resource Types', 'wp-certification-practice' ),
			'parent_item'       => __( 'Parent Resource Type', 'wp-certification-practice' ),
			'parent_item_colon' => __( 'Parent Resource Type:', 'wp-certification-practice' ),
			'edit_item'         => __( 'Edit Resource Type', 'wp-certification-practice' ),
			'update_item'       => __( 'Update Resource Type', 'wp-certification-practice' ),
			'add_new_item'      => __( 'Add New Resource Type', 'wp-certification-practice' ),
			'new_item_name'     => __( 'New Resource Type Name', 'wp-certification-practice' ),
			'menu_name'         => __( 'Resource Types', 'wp-certification-practice' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug' => 'resource-type',
			),
		);

		register_taxonomy(
			'wpcp_resource_type',
			array( 'wpcp_resource' ),
			$args
		);
	}
}
