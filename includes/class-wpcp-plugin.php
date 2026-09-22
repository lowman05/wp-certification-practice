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
	}
}
