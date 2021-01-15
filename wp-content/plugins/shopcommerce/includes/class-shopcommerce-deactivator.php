<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Shopcommerce
 * @subpackage Shopcommerce/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Shopcommerce
 * @subpackage Shopcommerce/includes
 * @author     Cedcommerce <rajivranjanshrivastav@cedcoss.com>
 */
class Shopcommerce_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		wp_delete_post('Shop', 1);

	}

}
