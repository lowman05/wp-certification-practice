<?php
/**
 * Core plugin functionality.
 *
 * @package WPCertificationPractice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class.
 */
class WPCP_Plugin {

	/**
	 * Starts the plugin.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'init', array( 'WPCP_Post_Types', 'register_resource' ) );
		add_action( 'init', array( 'WPCP_Taxonomies', 'register_resource_type' ) );
		add_action( 'admin_init', array( 'WPCP_Settings', 'register_settings' ) );
		add_action( 'admin_menu', array( 'WPCP_Settings', 'add_settings_page' ) );
		add_action( 'pre_get_posts', array( 'WPCP_Queries', 'set_resources_per_page' ) );
		add_action( 'rest_api_init', array( 'WPCP_REST_API', 'register_routes' ) );
		add_action(
			WPCP_External_API::CRON_HOOK,
			array( 'WPCP_External_API', 'refresh_latest_release' )
		);
	}
}
