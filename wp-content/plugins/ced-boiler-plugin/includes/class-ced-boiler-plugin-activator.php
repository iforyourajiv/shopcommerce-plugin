<?php

/**
 * Fired during plugin activation
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Ced_Boiler_Plugin
 * @subpackage Ced_Boiler_Plugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ced_Boiler_Plugin
 * @subpackage Ced_Boiler_Plugin/includes
 * @author     Cedcommerce <rajivranjanshrivastav@cedcoss.com>
 */



class Ced_Boiler_Plugin_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	public static function activate()
	{
		if (is_plugin_active('Ced-sample-plugin/Ced-sample-plugin.php')) :
			return true;
		else :
			$path = ced_boiler_plugin_DIR_PATH . 'ced-boiler-plugin.php';
			deactivate_plugins($path);
			wp_die(__('Sorry Plugin Dependency not Exist', 'ced-boiler-plugin'));
		endif;
	}
}
