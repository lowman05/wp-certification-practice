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
		if ( ! wp_next_scheduled( WPCP_External_API::CRON_HOOK ) ) {
			wp_schedule_event(
				time() + HOUR_IN_SECONDS,
				'twicedaily',
				WPCP_External_API::CRON_HOOK
			);
		}
		flush_rewrite_rules();
	}
}
