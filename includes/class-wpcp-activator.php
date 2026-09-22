<?php
/**
 * Plugin activation functionality.
 *
 * @package WPCertificationPractice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles plugin activation.
 */
class WPCP_Activator {

	/**
	 * Runs when the plugin is activated.
	 *
	 * @return void
	 */
	public static function activate() {
		WPCP_Post_Types::register_resource();
		WPCP_Taxonomies::register_resource_type();
		WPCP_Capabilities::add_capabilities();
		flush_rewrite_rules();
	}
}
