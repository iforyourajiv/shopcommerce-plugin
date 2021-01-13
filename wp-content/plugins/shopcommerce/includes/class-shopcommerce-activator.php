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
	 * Short Description. Creating New Page as Well As New Table in Db When Plugin Will Be Activated
	 * Version :1.0.0
	 * @since  :1.0.0
	 * @return void
	 */
	public static function activate()
	{
		// Creating new Page "Shop" when Plugin Activated
		$page = get_page_by_title('Shop');
		if (!$page) {
			$my_page = array(
				'post_title'    => wp_strip_all_tags('Shop'),
				'post-name'		=> wp_strip_all_tags('Shop'),
				'post_content'  => '[ced_shop_content]',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			);

			// Inserting the page into the database
			wp_insert_post($my_page);
		}

		// Creating new Page "Cart" when Plugin Activated
		$page = get_page_by_title('cart');
		if (!$page) {
			$my_page = array(
				'post_title'    => wp_strip_all_tags('Cart'),
				'post-name'		=> wp_strip_all_tags('Cart'),
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			);

			// Inserting the page into the database
			wp_insert_post($my_page);
		}

		// Creating new Page "Checkout" when Plugin Activated
		$page = get_page_by_title('checkout');
		if (!$page) {
			$my_page = array(
				'post_title'    => wp_strip_all_tags('checkout'),
				'post-name'		=> wp_strip_all_tags('Checkout'),
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			);

			// Inserting the page into the database
			wp_insert_post($my_page);
		}

		// Creating new Page "Thankyou" when Plugin Activated
		$page = get_page_by_title('thankyou');
		if (!$page) {
			$my_page = array(
				'post_title'    => wp_strip_all_tags('thankyou'),
				'post-name'		=> wp_strip_all_tags('Thankyou'),
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			);

			// Inserting the Page into the database
			wp_insert_post($my_page);
		}



		/**
		 * creating_table_for_order
		 * Description : Using This Function We are Creating New Table For Order Detail in Database
		 * Version :1.0.0
		 * @since  :1.0.0
		 * @return void
		 * @var $wpdb               Global variable
		 * @var $table_name         Accepting Table Name With Prefix
		 * @var $charset_collate    for Charset
		 * @var $sql 				Creating a New Table in Db 
		 */

		global $wpdb;

		$table_name = $wpdb->prefix . 'ced_orderDetail';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
					order_id int(9) NOT NULL AUTO_INCREMENT,
					user_id varchar(50) NOT NULL,
					customer_detail longtext NOT NULL,
					shipping_detail longtext NOT NULL,
					order_detail longtext NOT NULL,
					total_amount int(200) NOT NULL,
					payment_method varchar(50) NOT NULL,
					time timestamp NOT NULL,
					PRIMARY KEY  (order_id)
					) $charset_collate";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
}
