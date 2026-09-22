<?php
/**
 * Query modifications.
 *
 * @package WPCertificationPractice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles plugin query modifications.
 */
class WPCP_Queries {

	/**
	 * Sets the number of Resources displayed on the Resource archive.
	 *
	 * @param WP_Query $query The WordPress query object.
	 * @return void
	 */
	public static function set_resources_per_page( $query ) {
		if (
			is_admin() ||
			! $query->is_main_query() ||
			! $query->is_post_type_archive( 'wpcp_resource' )
		) {
			return;
		}

		$resources_per_page = absint(
			get_option( 'wpcp_resources_per_page', 10 )
		);

		$resources_per_page = max( 1, min( 100, $resources_per_page ) );

		$query->set( 'posts_per_page', $resources_per_page );
	}
}
