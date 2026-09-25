<?php
/**
 * External API functionality.
 *
 * @package WPCertificationPractice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles external API requests and caching.
 */
class WPCP_External_API {

	/**
	 * WordPress.org version API endpoint.
	 *
	 * @var string
	 */
	const API_URL = 'https://api.wordpress.org/core/version-check/1.7/';

	/**
	 * Transient cache key.
	 *
	 * @var string
	 */
	const CACHE_KEY = 'wpcp_latest_wordpress_release';

	/**
 * Option containing the last successful API response.
 *
 * @var string
 */
	const LAST_GOOD_OPTION = 'wpcp_latest_wordpress_release_last_good';

	/**
 * Cron hook used to refresh release data.
 *
 * @var string
 */
	const CRON_HOOK = 'wpcp_refresh_wordpress_release';

	/**
	 * Returns the latest WordPress release information.
	 *
	 * Uses the transient cache when available.
	 *
	 * @return array|WP_Error
	 */
	public static function get_latest_release() {
		$cached_data = get_transient( self::CACHE_KEY );

		if ( false !== $cached_data ) {
			return $cached_data;
		}

		$fresh_data = self::fetch_latest_release();

		if ( ! is_wp_error( $fresh_data ) ) {
			return $fresh_data;
		}

		$last_good_data = get_option( self::LAST_GOOD_OPTION, false );

		if ( is_array( $last_good_data ) ) {
			$last_good_data['stale'] = true;

			return $last_good_data;
		}

		return $fresh_data;
	}
	/**
	 * Refreshes the cached WordPress release data.
	 *
	 * @return void
	 */
	public static function refresh_latest_release() {
		self::fetch_latest_release();
	}

	/**
	 * Fetches the latest WordPress release information.
	 *
	 * @return array|WP_Error
	 */
	public static function fetch_latest_release() {
		/**
 * Filters the WordPress.org version API URL.
 *
 * @param string $api_url WordPress.org version API URL.
 */
		$api_url  = apply_filters(
			'wpcp_wordpress_version_api_url',
			self::API_URL
		);
		$response = wp_remote_get(
			$api_url,
			array(
				'timeout' => 5,
			)
		);

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$status_code = wp_remote_retrieve_response_code( $response );

		if ( 200 !== $status_code ) {
			return new WP_Error(
				'wpcp_external_api_error',
				__( 'The WordPress.org API returned an unexpected response.', 'wp-certification-practice' ),
				array(
					'status' => $status_code,
				)
			);
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		if (
			! is_array( $body ) ||
			empty( $body['offers'] ) ||
			empty( $body['offers'][0]['version'] )
		) {
			return new WP_Error(
				'wpcp_invalid_api_response',
				__( 'The WordPress.org API response was invalid.', 'wp-certification-practice' )
			);
		}

		$data = array(
			'version'    => sanitize_text_field( $body['offers'][0]['version'] ),
			'fetched_at' => time(),
			'stale'      => false,
		);

		set_transient(
			self::CACHE_KEY,
			$data,
			DAY_IN_SECONDS
		);
		update_option(
			self::LAST_GOOD_OPTION,
			$data,
			false
		);

		return $data;
	}
}
