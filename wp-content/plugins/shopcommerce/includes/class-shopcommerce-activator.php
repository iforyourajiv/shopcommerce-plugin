<?php

/**
 * Fired during plugin activation
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Shopcommerce
 * @subpackage Shopcommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Shopcommerce
 * @subpackage Shopcommerce/includes
 * @author     Cedcommerce <rajivranjanshrivastav@cedcoss.com>
 */
class Shopcommerce_Activator
{

	/**
	 * function name : Activate
	 * Short Description. Creating New Page When Plugin Will Be Activated
	 * Version :1.0.0
	 * @since  :1.0.0
	 * @return void
	 */
	public static function activate()
	{
		// Creating new Page "Shop" when Plugin Activated
		$page = get_page_by_title('Shop');
		if (!$page) {
			$my_post = array(
				'post_title'    => wp_strip_all_tags('Shop'),
				'post-name'		=> wp_strip_all_tags('Shop'),
				'post_content'  => '[ced_shop_content]',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			);

			// Inserting the post into the database
			wp_insert_post($my_post);
		}

		// Creating new Page "Cart" when Plugin Activated
		$page = get_page_by_title('cart');
		if (!$page) {
			$my_post = array(
				'post_title'    => wp_strip_all_tags('Cart'),
				'post-name'		=> wp_strip_all_tags('Cart'),
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			);

			// Inserting the post into the database
			wp_insert_post($my_post);
		}
	}
}
