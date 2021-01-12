<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Shopcommerce
 * @subpackage Shopcommerce/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Shopcommerce
 * @subpackage Shopcommerce/includes
 * @author     Cedcommerce <rajivranjanshrivastav@cedcoss.com>
 */
class Shopcommerce
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Shopcommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('SHOPCOMMERCE_VERSION')) {
			$this->version = SHOPCOMMERCE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'shopcommerce';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Shopcommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Shopcommerce_i18n. Defines internationalization functionality.
	 * - Shopcommerce_Admin. Defines all hooks for the admin area.
	 * - Shopcommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-shopcommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-shopcommerce-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-shopcommerce-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-shopcommerce-public.php';

		$this->loader = new Shopcommerce_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Shopcommerce_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Shopcommerce_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Shopcommerce_Admin($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'product_admin_script');
		// Creating Custom Post Type Having a Name with 'Product' using init hook
		$this->loader->add_action('init', $plugin_admin, 'ced_customPost_Product');
		//Adding Meta-Box Inventory for Product using add_meta_box hook
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'ced_custom_meta_inventory');
		//Saving Meta-box Inventory Value for Product using save_post hook 
		$this->loader->add_action('save_post', $plugin_admin, 'ced_custom_meta_inventory_save');
		//Adding Meta-Box Pricing for Product using add_meta_box hook
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'ced_custom_meta_pricing');
		//Saving Meta-box Pricing Value for Product using save_post hook 
		$this->loader->add_action('save_post', $plugin_admin, 'ced_custom_meta_pricing_save');
		//Adding Custom Taxonomy For Product using init hook
		$this->loader->add_action('init', $plugin_admin, 'ced_product_taxonomy');
		//Adding Function for Deleting Session  when user will log out using wp_logout hook
		$this->loader->add_action('wp_logout', $plugin_admin, 'unsetSession_after_logout');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Shopcommerce_Public($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		//Including Our Own Template For Single Product Page In Theme 
		$this->loader->add_action('template_include', $plugin_public, 'my_custom_template_for_single_product_page');
		//Including Our Own Template For cart  Page In Theme 
		$this->loader->add_action('template_include', $plugin_public, 'my_custom_template_for_cart_product_page');
		//Including Our Own Template For Checkout  Page In Theme 
		$this->loader->add_action('template_include', $plugin_public, 'my_custom_template_for_checkout_product_page');
		//Including Our Own Template For thankyou  Page In Theme 
		$this->loader->add_action('template_include', $plugin_public, 'my_custom_template_for_thankyou_product_page');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Shopcommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
