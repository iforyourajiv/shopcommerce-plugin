<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://cedcoss.com/
 * @since      1.0.0
 *
 * @package    Ced_Boiler_Plugin
 * @subpackage Ced_Boiler_Plugin/includes
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
 * @package    Ced_Boiler_Plugin
 * @subpackage Ced_Boiler_Plugin/includes
 * @author     Cedcommerce <rajivranjanshrivastav@cedcoss.com>
 */
class Ced_Boiler_Plugin
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ced_Boiler_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if (defined('CED_BOILER_PLUGIN_VERSION')) {
			$this->version = CED_BOILER_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ced-boiler-plugin';

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
	 * - Ced_Boiler_Plugin_Loader. Orchestrates the hooks of the plugin.
	 * - Ced_Boiler_Plugin_i18n. Defines internationalization functionality.
	 * - Ced_Boiler_Plugin_Admin. Defines all hooks for the admin area.
	 * - Ced_Boiler_Plugin_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ced-boiler-plugin-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ced-boiler-plugin-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-ced-boiler-plugin-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-ced-boiler-plugin-public.php';

		$this->loader = new Ced_Boiler_Plugin_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ced_Boiler_Plugin_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Ced_Boiler_Plugin_i18n();

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

		$plugin_admin = new Ced_Boiler_Plugin_Admin($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		//Adding New Menu
		$this->loader->add_action('admin_menu', $plugin_admin, 'Ced_new_menu'); 
		//Adding New Menu For Creating Custom Post type form
		$this->loader->add_action('admin_menu', $plugin_admin, 'Ced_custom_post_type_menu'); 
		 //Adding Meta-Box For Brand
		$this->loader->add_action('add_meta_boxes', $plugin_admin, 'add');
		 //Saving Meta-box Value for Brand
		$this->loader->add_action('save_post', $plugin_admin, 'save');
		//Adding Action hooks for adding value in color column
		$this->loader->add_action('manage_post_posts_custom_column', $plugin_admin, 'fetch_value_col_color', 10, 2);
		//Adding filter hooks for appending color column in Post Table
		$this->loader->add_filter('manage_post_posts_columns', $plugin_admin, 'add_col_color');
		//Adding Action hooks for adding value in Brand column
		$this->loader->add_action('manage_post_posts_custom_column', $plugin_admin, 'fetch_value_col_brand', 10, 2);
		//Adding filter hooks for appending brand column in Post Table
		$this->loader->add_filter('manage_post_posts_columns', $plugin_admin, 'add_col_brand');
		//Adding Action for Ajax call with call-back Function
		$this->loader->add_action('wp_ajax_save_meta_action', $plugin_admin, 'save_meta_brand');
		// Registering Post Type Via Custom Form using init hook
		$this->loader->add_action('init', $plugin_admin, 'register_custom_postType');

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

		$plugin_public = new Ced_Boiler_Plugin_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		// appending custome Meta box Data with Single post content
		$this->loader->add_filter('the_content', $plugin_public, 'show_meta_for_SinglePost');
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
	 * @return    Ced_Boiler_Plugin_Loader    Orchestrates the hooks of the plugin.
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
