<?php
/**
 * Block registration functionality.
 *
 * @package WPCertificationPractice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers plugin blocks.
 */
class WPCP_Blocks {

	/**
	 * Registers plugin block types.
	 *
	 * @return void
	 */
	public static function register_blocks() {
		register_block_type(
			dirname( __DIR__ ) . '/build/resource-list'
		);
	}
}
