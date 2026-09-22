<?php
/**
 * Plugin settings functionality.
 *
 * @package WPCertificationPractice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manages plugin settings.
 */
class WPCP_Settings {
	/**
	 * Registers plugin settings.
	 *
	 * @return void
	 */
	public static function register_settings() {
		register_setting(
			'wpcp_settings',
			'wpcp_resources_per_page',
			array(
				'type'              => 'integer',
				'sanitize_callback' => array( __CLASS__, 'sanitize_resources_per_page' ),
				'default'           => 10,
			)
		);

		add_settings_section(
			'wpcp_resource_settings',
			__( 'Resource Settings', 'wp-certification-practice' ),
			array( __CLASS__, 'render_resource_settings_section' ),
			'wpcp-settings'
		);

		add_settings_field(
			'wpcp_resources_per_page',
			__( 'Resources Per Page', 'wp-certification-practice' ),
			array( __CLASS__, 'render_resources_per_page_field' ),
			'wpcp-settings',
			'wpcp_resource_settings'
		);
	}

	/**
	 * Sanitizes the Resources Per Page setting.
	 *
	 * @param mixed $value Submitted setting value.
	 * @return int
	 */
	public static function sanitize_resources_per_page( $value ) {
		$value = absint( $value );

		return max( 1, min( 100, $value ) );
	}

	/**
	 * Renders the Resource Settings section description.
	 *
	 * @return void
	 */
	public static function render_resource_settings_section() {
		echo '<p>' .
		esc_html__(
			'Configure how Resources behave on the site.',
			'wp-certification-practice'
		) .
		'</p>';
	}

	/**
	 * Renders the Resources Per Page field.
	 *
	 * @return void
	 */
	public static function render_resources_per_page_field() {
		$value = get_option( 'wpcp_resources_per_page', 10 );
		?>
	<input
		type="number"
		name="wpcp_resources_per_page"
		value="<?php echo esc_attr( $value ); ?>"
		min="1"
		max="100"
		step="1"
	>
		<?php
	}

	/**
	 * Adds the plugin settings page.
	 *
	 * @return void
	 */
	public static function add_settings_page() {
		add_options_page(
			__( 'WP Certification Practice', 'wp-certification-practice' ),
			__( 'WP Certification Practice', 'wp-certification-practice' ),
			'manage_options',
			'wpcp-settings',
			array( __CLASS__, 'render_settings_page' )
		);
	}

	/**
	 * Renders the plugin settings page.
	 *
	 * @return void
	 */
	public static function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
	<div class="wrap">
		<h1><?php echo esc_html__( 'WP Certification Practice', 'wp-certification-practice' ); ?></h1>

		<form action="options.php" method="post">
			<?php
			settings_fields( 'wpcp_settings' );
			do_settings_sections( 'wpcp-settings' );
			submit_button();
			?>
		</form>
	</div>
		<?php
	}
}
