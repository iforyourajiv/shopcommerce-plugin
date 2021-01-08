<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cedcoss.com/
 * @since             1.0.0
 * @package           Ced_Boiler_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       ced-boiler-plugin
 * Plugin URI:        https://cedcoss.com/
 * Description:       This is a short description of what the plugin does.Boilerplate Example
 * Version:           1.0.0
 * Author:            Cedcommerce
 * Author URI:        https://cedcoss.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ced-boiler-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CED_BOILER_PLUGIN_VERSION', '1.0.0' );

if (!defined("ced-boiler-plugin_DIR_PATH")) {
	define("ced_boiler_plugin_DIR_PATH", plugin_dir_path(__FILE__));
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ced-boiler-plugin-activator.php
 */
function activate_ced_boiler_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ced-boiler-plugin-activator.php';
	Ced_Boiler_Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ced-boiler-plugin-deactivator.php
 */
function deactivate_ced_boiler_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ced-boiler-plugin-deactivator.php';
	Ced_Boiler_Plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ced_boiler_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_ced_boiler_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ced-boiler-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ced_boiler_plugin() {

	$plugin = new Ced_Boiler_Plugin();
	$plugin->run();

}
run_ced_boiler_plugin();
