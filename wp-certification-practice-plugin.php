<?php
/**
 * Plugin Name: WP Certification Practice
 * Description: A practice plugin for advanced WordPress development concepts.
 * Version: 0.1.0
 * Author: Daniel French
 * Text Domain: wp-certification-practice
 *
 * @package WPCertificationPractice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcp-activator.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcp-deactivator.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcp-plugin.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcp-post-types.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcp-taxonomies.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcp-capabilities.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/class-wpcp-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcp-queries.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcp-rest-api.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcp-external-api.php';

register_activation_hook( __FILE__, array( 'WPCP_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WPCP_Deactivator', 'deactivate' ) );

$wpcp_plugin = new WPCP_Plugin();
$wpcp_plugin->run();
