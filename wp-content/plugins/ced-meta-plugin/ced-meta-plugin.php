<?php

/**
 * @link              http://example.com
 * @since             1.0.0
 * @package           ced-meta-plugin
 *
 * @wordpress-plugin
 * Plugin Name:       ced-meta-plugin
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       A simple Plugin For Learning Purpose
 * Version:           1.0.0
 * Author:            Cedcommerce
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ced-meta-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
// if ( ! defined( 'WPINC' ) ) {
//  die;
// }

// Defining plugin version

define('ced-meta-plugin_VERSION', '1.0.0');

//Defining Global  Path/URL
if (!defined('Ced_meta_plugin_DIR')) {
	define('Ced_meta_plugin_DIR', plugin_dir_url(__FILE__));
}


if (!defined("ced-meta-plugin_DIR_PATH")) {
	define("Ced_meta_plugin_DIR_PATH", plugin_dir_path(__FILE__));
}



//Creating Function For Adding menu 
if (!function_exists('Ced_custom_meta_menu')) {
	function Ced_custom_meta_menu()
	{
		add_menu_page(
			"Meta", // Menu Title
			"Custom Meta Setting", // Menu Name
			'manage_options', //Capabilities
			"custom-meta", //Slug
			"ced_custom_meta_menu_html", //Function
			"dashicons-admin-tools", //Icon
			30
		);
	}
}

add_action('admin_menu', 'Ced_custom_meta_menu');

// For Printing HTML in Meta Menu
function ced_custom_meta_menu_html()
{
	$args = array(
		'public'   => true,
		'_builtin' => false
	);

	$output = 'names'; // 'names' or 'objects' (default: 'names')
	$operator = 'or'; // 'and' or 'or' (default: 'and')

	$post_types = get_post_types($args, $output, $operator);
	$html = "<h1>Select Post Types Where You Want To show Color Meta Box</h1>";
	$html .= "<form action=''method='post'>";
	foreach ($post_types as $post_type) {
		$post_option = get_option('custom_meta_option');
		$checked = '';
		if (is_array($post_option)) {
			if (in_array($post_type, $post_option)) {
				$checked = 'checked';
			} else {
				$checked = '';
			}
		} else {
			$checked = '';
		}
		$html .= "<br><input type='checkbox' id='posttypecheck$post_type' value='$post_type' name='posttypecheck[]' $checked>$post_type
			";
	}
	$html .= "<br><br><input type='submit'  name='save_custome_meta_selection' value='Save Options'>";
	$html .= "</form>";
	echo $html;
}

// Saving the selected Choice in Meta Option
if (isset($_POST['save_custome_meta_selection'])) {

	$choice = isset($_POST['posttypecheck']) ? $_POST['posttypecheck'] : false;
	update_option('custom_meta_option', $choice);
}


// Creating custom meta box
abstract class ced_meta_box
{

	/**
	 * Set up and add the meta box.
	 */
	public static function add()
	{
		$post_option = get_option('custom_meta_option');
		$screens = [$post_option, 'ced_meta_box'];
		foreach ($screens as $screen) {
			add_meta_box(
				'ced_metabox',          // Unique ID
				'Color', // Box title
				[self::class, 'html'],  // Content callback, must be of type callable
				$screen, // Post type
				'side'
			);
			add_option('custom_meta_option', '', '', 'yes');
		}
	}


	/**
	 * Save the meta box selections.
	 *
	 * @param int $post_id  The post ID.
	 */
	public static function save(int $post_id)
	{
		if (array_key_exists('ced_meta_color', $_POST)) {
			update_post_meta(
				$post_id,
				'ced_meta_box_metakey',
				$_POST['ced_meta_color']
			);
		}
	}


	/**
	 * Display the meta box HTML to the user.
	 *
	 * @param \WP_Post $post   Post object.
	 */
	public static function html($post)
	{
		$value = get_post_meta($post->ID, 'ced_meta_box_metakey', true);
?>
		<label for="ced_meta_box_field">Color</label>
		<input type="text" id="ced_meta_color" name="ced_meta_color" value="<?php echo $value ?>">
<?php
	}
}

add_action('add_meta_boxes', ['ced_meta_box', 'add']);
add_action('save_post', ['ced_meta_box', 'save']);
