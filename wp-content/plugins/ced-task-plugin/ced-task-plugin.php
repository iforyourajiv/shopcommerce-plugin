<?php

/**
 * @link              http://example.com
 * @since             1.0.0
 * @package           Ced-task-plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Ced-task-plugin
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       A simple Plugin For Learning Purpose
 * Version:           1.0.0
 * Author:            Cedcommerce
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Ced-task-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
// if ( ! defined( 'WPINC' ) ) {
//  die;
// }

// Defining plugin version

define('Ced-task-plugin_VERSION', '1.0.0');

//Defining Global  Path/URL
if (!defined('Ced_task_plugin_DIR')) {
	define('Ced_task_plugin_DIR', plugin_dir_url(__FILE__));
}


if (!defined("Ced-task-plugin_DIR_PATH")) {
	define("Ced_task_plugin_DIR_PATH", plugin_dir_path(__FILE__));
}

// // Creating Function For Script/style
// if (!function_exists('Ced_task_plugin_script')) {
// 	function Ced_task_plugin_script()
// 	{
// 		wp_enqueue_style('CED_task_CSS', Ced_task_plugin_DIR. 'assets/CSS/slider.css');

// 		// wp_enqueue_script('CED_JS',Ced_sample_plugin_DIR.'assets/JS/main.js','1.0.0', true);
// 	}
// }

// add_action('wp_enqueue_scripts', 'Ced-task-plugin_script', 14);

//Creating Function For Adding menu an d Submenu
if (!function_exists('Ced_subscriber_menu')) {
	function Ced_subscriber_menu()
	{
		add_menu_page(
			"Subscriber's", // Menu Title
			"Subscriber", // Menu Name
			'manage_options', //Capabilities
			"subscriber", //Slug
			"ced_subscriber_menu_html", //Function
			"dashicons-businessperson", //Icon
			30
		);
		add_submenu_page(
			"subscriber", //Parent Slug
			"CED SUB Menu", // Menu Title
			"Show Records", // Menu Name
			'manage_options', //Capabilities
			"subscriber-records", //Slug
			"ced_show_subscriber_record" //Function
		);
	}
}

add_action('admin_menu', 'Ced_subscriber_menu');

// For Printing HTML
function ced_subscriber_menu_html()
{
	$html = "<h1 style='text-align:center'>Welcome in Subsciber menu</h1>";
	echo $html;
}

//Database creation with Plugin
function ced_show_subscriber_record()
{
	require_once Ced_task_plugin_DIR_PATH  . '/includes/Ced-showData-wp-list-table.php';
	$obj = new Subscriber_List();
	$obj->prepare_items();
	$obj->display();
}


// Creating New Post type 'Blog'
function ced_create_blog_posttype()
{

	register_post_type(
		'blog',
		// CPT Options
		array(
			'labels' => array(
				'name' => __('Blog'),
				'singular_name' => __('Blog'),
				'add_new'        => ('Add New Blog'),
			),
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields'),
			'rewrite' => array('slug' => 'blog'),
			'show_in_rest' => true,

		)
	);
}


add_action('init', 'ced_create_blog_posttype');



// Creating Widget Subscribe Now

//Calling Class File from /Widget/class-subscribeNow-widget.php

require_once Ced_task_plugin_DIR_PATH  . '/Widget/class-subscribeNow-widget.php';
function Subscribe_Now_widget()
{
	register_widget('Subscribe_Now');
}
add_action('widgets_init', 'Subscribe_Now_widget');
