<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cedcommerce.com/
 * @since             1.0.0
 * @package           Shopcommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Shopcommerce
 * Plugin URI:        https://cedcommerce.com/
 * Description:       This Plugin Will Add a Shop feature on Your Website
 * Version:           1.0.0
 * Author:            Cedcommerce
 * Author URI:        https://cedcommerce.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shopcommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('SHOPCOMMERCE_VERSION', '1.0.0');
define('PLUGIN_DIRPATH', plugin_dir_path(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-shopcommerce-activator.php
 */
function activate_shopcommerce() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-shopcommerce-activator.php';
	Shopcommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-shopcommerce-deactivator.php
 */
function deactivate_shopcommerce() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-shopcommerce-deactivator.php';
	Shopcommerce_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_shopcommerce');
register_deactivation_hook(__FILE__, 'deactivate_shopcommerce');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-shopcommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_shopcommerce() {

	$plugin = new Shopcommerce();
	$plugin->run();
}
run_shopcommerce();
