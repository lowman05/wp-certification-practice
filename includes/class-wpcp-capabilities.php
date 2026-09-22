<?php
/**
 * Resource capability management.
 *
 * @package WPCertificationPractice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manages plugin capabilities.
 */
class WPCP_Capabilities {

	/**
	 * Returns the Resource capabilities.
	 *
	 * @return array
	 */
	public static function get_resource_capabilities() {
		return array(
			'edit_wpcp_resources',
			'edit_others_wpcp_resources',
			'publish_wpcp_resources',
			'read_private_wpcp_resources',
			'delete_wpcp_resources',
			'delete_private_wpcp_resources',
			'delete_published_wpcp_resources',
			'delete_others_wpcp_resources',
			'edit_private_wpcp_resources',
			'edit_published_wpcp_resources',
		);
	}

	/**
	 * Adds Resource capabilities to selected roles.
	 *
	 * @return void
	 */
	public static function add_capabilities() {
		$roles = array(
			'administrator',
			'editor',
		);

		foreach ( $roles as $role_name ) {
			$role = get_role( $role_name );

			if ( ! $role ) {
				continue;
			}

			foreach ( self::get_resource_capabilities() as $capability ) {
				$role->add_cap( $capability );
			}
		}
	}
}
