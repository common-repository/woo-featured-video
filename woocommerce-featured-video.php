<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://figarts.co
 * @since             1.0.0
 * @package           Woofv
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Featured Video
 * Plugin URI:        https://figarts.co
 * Description:       Replaces WooCommerce featured image with embedded video
 * Version:           2.0.0
 * Author:            David Towoju
 * Author URI:        https://figarts.co
 * Text Domain:       woofv
 * Domain Path:       /languages
 * 
 * WC requires at least: 3.5
 * WC tested up to: 3.9
 * 
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Definitions
 */
define( 'WOOFV_SLUG', 'woofv' );
define( 'WOOFV_PATH', plugin_dir_path( __FILE__ ) );
define( 'WOOFV_VIEWS', WOOFV_PATH . 'views/' );
define( 'WOOFV_URL', plugin_dir_url( __FILE__ ) );
define( 'WOOFV_VERSION', '2.0.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woofv-ctrl.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_woofv() {

	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	// Languages
	load_plugin_textdomain(
		'woofv', false, WOOFV_PATH . 'languages'
	);

	// Start
	new Woofv_Ctrl( WOOFV_VIEWS . 'video.php' );
}
add_action( 'plugins_loaded', 'run_woofv', 1 );
