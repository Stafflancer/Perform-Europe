<?php
/**
 * Plugin Name:       WPForms Zapier
 * Plugin URI:        https://wpforms.com
 * Description:       Zapier integration with WPForms.
 * Requires at least: 5.2
 * Requires PHP:      5.6
 * Author:            WPForms
 * Author URI:        https://wpforms.com
 * Version:           1.5.0
 * Text Domain:       wpforms-zapier
 * Domain Path:       languages
 *
 * WPForms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WPForms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WPForms. If not, see <https://www.gnu.org/licenses/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:disable WPForms.Comments.PHPDocDefine.MissPHPDoc
// Plugin constants.
define( 'WPFORMS_ZAPIER_VERSION', '1.5.0' );
define( 'WPFORMS_ZAPIER_FILE', __FILE__ );
define( 'WPFORMS_ZAPIER_PATH', plugin_dir_path( WPFORMS_ZAPIER_FILE ) );
define( 'WPFORMS_ZAPIER_URL', plugin_dir_url( WPFORMS_ZAPIER_FILE ) );
// phpcs:enable WPForms.Comments.PHPDocDefine.MissPHPDoc

/**
 * Check requirements and load the addon.
 *
 * @since 1.4.0
 */
function wpforms_zapier_load() {

	// Check requirements.
	if ( ! wpforms_zapier_required() ) {
		return;
	}

	// Load the addon.
	wpforms_zapier();
}

add_action( 'wpforms_loaded', 'wpforms_zapier_load' );

/**
 * Check addon requirements.
 *
 * @since 1.4.0
 *
 * @return bool
 */
function wpforms_zapier_required() {

	if ( PHP_VERSION_ID < 50600 ) {
		add_action( 'admin_init', 'wpforms_zapier_deactivate' );
		add_action( 'admin_notices', 'wpforms_zapier_fail_php_version' );

		return false;
	}

	if ( version_compare( wpforms()->version, '1.7.5.5', '<' ) ) {
		add_action( 'admin_init', 'wpforms_zapier_deactivate' );
		add_action( 'admin_notices', 'wpforms_zapier_fail_wpforms_version' );

		return false;
	}

	// WPForms Pro is required.
	if (
		! function_exists( 'wpforms' ) ||
		! function_exists( 'wpforms_get_license_type' ) ||
		! in_array( wpforms_get_license_type(), [ 'pro', 'elite', 'agency', 'ultimate' ], true )
	) {
		return false;
	}

	return true;
}

/**
 * Deactivate the addon.
 *
 * @since 1.4.0
 */
function wpforms_zapier_deactivate() {

	deactivate_plugins( plugin_basename( WPFORMS_ZAPIER_FILE ) );
}

/**
 * Admin notice for a minimum PHP version.
 *
 * @since 1.4.0
 */
function wpforms_zapier_fail_php_version() {

	echo '<div class="notice notice-error"><p>';
	printf(
		wp_kses( /* translators: %s - WPForms.com documentation page URI. */
			__( 'The WPForms Zapier plugin has been deactivated. Your site is running an outdated version of PHP that is no longer supported and is not compatible with the Zapier addon. <a href="%s" target="_blank" rel="noopener noreferrer">Read more</a> for additional information.', 'wpforms-zapier' ),
			[
				'a' => [
					'href'   => [],
					'rel'    => [],
					'target' => [],
				],
			]
		),
		'https://wpforms.com/docs/supported-php-version/'
	);
	echo '</p></div>';

	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended
}

/**
 * Admin notice for a minimum WPForms version.
 *
 * @since 1.4.0
 */
function wpforms_zapier_fail_wpforms_version() {

	echo '<div class="notice notice-error"><p>';
	printf( /* translators: minimum required WPForms version. */
		esc_html__( 'The WPForms Zapier plugin has been deactivated, because it requires WPForms v%s or later to work.', 'wpforms-zapier' ),
		'1.7.5.5'
	);
	echo '</p></div>';

	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended
}

/**
 * Load the provider class.
 *
 * @since 1.0.0
 */
function wpforms_zapier() {

	require_once WPFORMS_ZAPIER_PATH . 'class-zapier.php';
}

/**
 * Load the plugin updater.
 *
 * @since 1.0.0
 *
 * @param string $key License key.
 */
function wpforms_zapier_updater( $key ) {

	new WPForms_Updater(
		[
			'plugin_name' => 'WPForms Zapier',
			'plugin_slug' => 'wpforms-zapier',
			'plugin_path' => plugin_basename( WPFORMS_ZAPIER_FILE ),
			'plugin_url'  => trailingslashit( WPFORMS_ZAPIER_URL ),
			'remote_url'  => WPFORMS_UPDATER_API,
			'version'     => WPFORMS_ZAPIER_VERSION,
			'key'         => $key,
		]
	);
}

add_action( 'wpforms_updater', 'wpforms_zapier_updater' );
