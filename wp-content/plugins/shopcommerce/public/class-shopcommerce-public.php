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

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Shopcommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Shopcommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/shopcommerce-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Shopcommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Shopcommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/shopcommerce-public.js', array('jquery'), $this->version, false);
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
	 * @param, int $pagename (For Fetching Page Name)
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
}
