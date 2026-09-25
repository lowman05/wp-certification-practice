<?php
/**
 * Plugin deactivation functionality.
 *
 * @package WPCertificationPractice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles plugin deactivation.
 */
class WPCP_Deactivator {

	/**
	 * Runs when the plugin is deactivated.
	 *
	 * @return void
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook( WPCP_External_API::CRON_HOOK );

		flush_rewrite_rules();
	}
}
