<?php

/**
 * @link              http://example.com
 * @since             1.0.0
 * @package           Ced-sample-plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Ced-sample-plugin
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       A simple Plugin For Learning Purpose
 * Version:           1.0.0
 * Author:            Cedcommerce
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Ced-sample-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
// if ( ! defined( 'WPINC' ) ) {
//  die;
// }

// Defining plugin version

define('Ced-sample-plugin_VERSION', '1.0.0');

//Defining Global  Path/URL
if (!defined('Ced_sample_plugin_DIR')) {
	define('Ced_sample_plugin_DIR', plugin_dir_url(__FILE__));
}


if (!defined("CED_PLUGIN_DIR_PATH")) {
	define("Ced_sample_plugin_DIR_PATH", plugin_dir_path(__FILE__));
}

// Creating Function For Script/style
if (!function_exists('Ced_sample_plugin_script')) {
	function Ced_sample_plugin_script()
	{
		wp_enqueue_style('CED_CSS', Ced_sample_plugin_DIR . 'assets/CSS/slider.css');

		// wp_enqueue_script('CED_JS',Ced_sample_plugin_DIR.'assets/JS/main.js','1.0.0', true);
	}
}

add_action('wp_enqueue_scripts', 'Ced_sample_plugin_script', 13);

//Creating Function For Adding menu an d Submenu
if (!function_exists('Ced_menu')) {
	function Ced_menu()
	{
		add_menu_page(
			"CED MENU", // Menu Title
			"CED SETTING", // Menu Name
			'manage_options', //Capabilities
			"ced-setting", //Slug
			"ced_menu_html", //Function
			"dashicons-hammer", //Icon
			30
		);
		add_submenu_page(
			"ced-setting", //Parent Slug
			"CED SUB Menu", // Menu Title
			"Show Records", // Menu Name
			'manage_options', //Capabilities
			"show-records", //Slug
			"ced_show_record" //Function
		);
	}
}

add_action('admin_menu', 'Ced_menu');

// For Printing HTML
function ced_menu_html()
{
	$html = "<h1 style='text-align:center'>Welcome in CED-SETTING menu</h1>";
	echo $html;
}



//Database creation with Plugin

global $cedDb_version;
$cedDb_version = '1.0';
function cedDB_install()
{
	global $wpdb;
	global $cedDb_version;

	$table_name = $wpdb->prefix . 'cedContact';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id int(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name tinytext NOT NULL,
		email varchar(50) NOT NULL,
		mobile varchar(50) NOT NULL,
		message text NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

	add_option('cedDb_version', $cedDb_version);
}

register_activation_hook(__FILE__, 'cedDB_install');



// Contact Form Shortcode

function ced_contactform_shortcode($content = null)
{
	$content = "<div style='padding:10px;text-align:center'>
	<div>
		<form action='' method='post'>
			<h3>Contact Us</h3>
			<h4>Please Enter Detail</h4>
			    <span >Your Name</span>
				<input style='margin-bottom:10px' type='text' name='fullname' class='form-control'  required>
				<br>
			<span for=''>Your Mail</span>
				<input style='margin-bottom:10px' type='email' name='email' class='form-control'  required>
				<br>
			<span for=''>Your Mobile Number</span>
				<input style='margin-bottom:10px' type='number' maxlength='12' name='mobile' class='form-control'  required>
				<br>
			<span for=''>Your Message</span>
				<textarea style='margin-bottom:10px' name='message' id='' class='form-control' required></textarea>
			   <br>

			<input type='submit' name='submit' value='Contact Us' style='margin-bottom:10px; background:#007BFF;color:white'>
				<i class='zmdi zmdi-arrow-right'></i>
			</input>
		</form>
	</div>
</div>";
	return $content;
}
add_shortcode('ced_contactform', 'ced_contactform_shortcode');



// Function for Save a Form Data In DB

if (isset($_POST['submit'])) {
	function ced_saveContact_formData()
	{
		$name = $_POST['fullname'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
		$message = $_POST['message'];
		global $wpdb;
		$table_name = $wpdb->prefix . 'cedContact';

		$wpdb->insert(
			$table_name,
			array(
				'time' => current_time('mysql'),
				'name' => $name,
				'email' => $email,
				'mobile' => $mobile,
				'message' => $message,
			)
		);
	}
	ced_saveContact_formData();
}




// For Printing Data in Table on Admin Menu

function ced_show_record()
{
	include_once Ced_sample_plugin_DIR_PATH . "includes/showData-wp-list-table.php";
	$obj = new Users_List();


?>
	<div class="wrap">
		<h2>All Records</h2>

		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
						<form method="post">
							<?php

							$obj->prepare_items();
							$obj->display();

							?>
						</form>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>
	</div>

<?php }

?>