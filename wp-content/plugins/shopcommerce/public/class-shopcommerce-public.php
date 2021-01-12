<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Shopcommerce
 * @subpackage Shopcommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Shopcommerce
 * @subpackage Shopcommerce/public
 * @author     Cedcommerce <rajivranjanshrivastav@cedcoss.com>
 */

if (!class_exists('Shopcommerce_Public')) {
	class Shopcommerce_Public
	{

		/**
		 * The ID of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $plugin_name    The ID of this plugin.
		 */
		private $plugin_name;

		/**
		 * The version of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $version    The current version of this plugin.
		 */
		private $version;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 * @param      string    $plugin_name       The name of the plugin.
		 * @param      string    $version    The version of this plugin.
		 */
		public function __construct($plugin_name, $version)
		{

			$this->plugin_name = $plugin_name;
			$this->version = $version;
		}


		public function enqueue_styles() {
			wp_enqueue_style( 'ced-plugin-css', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), $this->version, 'all' );
		}

		/**
		 * function Name :my_custom_template_for_single_product_page
		 * Description: Adding Our Own Custom Theme Path Whenever We Will Get Single.php with sepecific Type
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @return $template
		 * @param, int $template
		 */

		function my_custom_template_for_single_product_page($template)
		{
			$post_type = 'product';
			if (is_singular($post_type)) {
				$template = dirname(__FILE__) . '/partials/shopcommerce-product-template.php';
			}
			return $template;
		}
		// my_custom_template_for_single_product_page Ends Here


		/**
		 * function Name :my_custom_template_for_cart_product_page
		 * Description: Adding Our Own Custom Theme Path Whenever We Will Get Cart Page
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @return $template
		 * @param  $template 
		 * @var, int $pagename (For Fetching Page Name)
		 */


		function my_custom_template_for_cart_product_page($template)
		{

			$pagename = get_query_var('pagename');
			if ($pagename == 'cart') {
				$template = dirname(__FILE__) . '/partials/shopcommerce-cart-template.php';
			}
			return $template;
		}

		// my_custom_template_for_cart_product_page Ends Here


		/**
		 * function Name :my_custom_template_for_checkout_product_page
		 * Description: Adding Our Own Custom Theme Path Whenever We Will Get Checkout Page
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @return $template
		 * @param  $template 
		 * @var, int $pagename (For Fetching Page Name)
		 */


		function my_custom_template_for_checkout_product_page($template)
		{

			$pagename = get_query_var('pagename');
			if ($pagename == 'checkout') {
				$template = dirname(__FILE__) . '/partials/shopcommerce-checkout-template.php';
			}
			return $template;
		}

		//  my_custom_template_for_checkout_product_page Ends Here

		/**
		 * function Name :my_custom_template_for_thankyou_product_page
		 * Description: Adding Our Own Custom Theme Path Whenever We Will Get Checkout Page
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @return $template
		 * @param  $template 
		 * @var, int $pagename (For Fetching Page Name)
		 */


		function my_custom_template_for_thankyou_product_page($template)
		{

			$pagename = get_query_var('pagename');
			if ($pagename == 'thankyou') {
				$template = dirname(__FILE__) . '/partials/shopcommerce-thankyou-template.php';
			}
			return $template;
		}

		//  my_custom_template_for_thankyou_product_page Ends Here
	}
}
