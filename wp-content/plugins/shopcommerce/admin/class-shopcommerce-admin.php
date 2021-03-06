<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Shopcommerce
 * @subpackage Shopcommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Shopcommerce
 * @subpackage Shopcommerce/admin
 * @author     Cedcommerce <rajivranjanshrivastav@cedcoss.com>
 */

if (!class_exists('Shopcommerce_Admin')) {
	class Shopcommerce_Admin {
	

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
		 * @param      string    $plugin_name       The name of this plugin.
		 * @param      string    $version    The version of this plugin.
		 */
		public function __construct( $plugin_name, $version) {

			$this->plugin_name = $plugin_name;
			$this->version     = $version;
			// Adding Shortcode For Shop Page
			add_shortcode('ced_shop_content', array($this, 'ced_shortcode_shop'));
		}

		/**
		 * function Name :ced_customPost_Product
		 * Description. Creating New Post Type Having a name with 'Product'
		 *
		 * @return void
		 * @since  :1.0.0
		 * Version :1.0.0
		 */
		public function ced_customPost_Product() {
			register_post_type(
				'Product',
				// CPT Options
				array(
					'labels' => array(
						'name' => __('Products'),
						'singular_name' => __('Product'),
						'edit_item'          => ( 'Edit Product' ),
						'add_new'        => ( 'Add New Product' ),
						'search_items'        => __('Search Product'),
					),
					'public' => true,
					'has_archive' => true,
					'menu_icon'           => 'dashicons-screenoptions',
					'supports'            => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments'),
					'rewrite' => array('slug' => 'product'),
					'show_in_rest' => true,
				)
			);
		}

		//ced_customPost_Product () Function Ends here


		/**
		 * function Name :ced_custom_meta_inventory
		 * Description. Creating New Meta Box  Having a name with 'Inventory' For Product Post Type
		 *
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @return void
		 */
		public function ced_custom_meta_inventory() {
			add_meta_box(
				'ced_metabox_inventory',          // Unique ID
				'Inventory', // Box title
				'ced_custom_meta_inventory_html',  // Content callback, must be of type callable
				'Product', // Post type
				'side' //postiton
			);


			/**
			 * function Name :ced_custom_meta_inventory_html
			 * Description. HTML for ced_custom_meta_inventory
			 *
			 * @since  :1.0.0
			 * Version :1.0.0
			 * @return void
			 * @param int $post Global Variable for Post.
			 * @param int $post->Id for getting individual Post Id.
			 */

			function ced_custom_meta_inventory_html( $post) {
				$valueforinventory = get_post_meta($post->ID, 'ced_metabox_inventory', true);
				?>
				<span style="color:red" id="massageinventory"></span>
				<label for="ced_meta_box_field">Inventory</label>
				<input type="number" id="ced_input_meta_inventory" min="0" name="ced_input_meta_inventory" value="<?php echo _e($valueforinventory); ?>">
			<?php
			}
		}

		/**
		 * function Name :ced_custom_meta_inventory_save
		 * Description:Saving Data for ced_custom_meta_inventory
		 *
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @return void
		 * @param int $post_id  //The ID of the post being saved.
		 * @var int $inventoryvalue //To take Input of inventory value 
		 */
		public function ced_custom_meta_inventory_save( int $post_id) {
			$inventoryvalue = empty($_POST['ced_input_meta_inventory']) ? 0 : $_POST['ced_input_meta_inventory'];
			if (array_key_exists('ced_input_meta_inventory', $_POST)) {
				update_post_meta(
					$post_id,
					'ced_metabox_inventory',
					sanitize_text_field($inventoryvalue)
				);
			}
		}

		// Meta box Inventory Function Ends here


		/**
		 * function Name :ced_custom_meta_pricing
		 * Description. Creating New Meta Box  Having a name with 'Pricing' For Product Post Type
		 *
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @return void
		 */
		public function ced_custom_meta_pricing() {
			add_meta_box(
				'ced_metabox_pricing',          // Unique ID
				'Price', // Box title
				'ced_custom_meta_pricing_html',  // Content callback, must be of type callable
				'Product', // Post type
				'side'
			);


			/**
			 * function Name :ced_custom_meta_pricing_html
			 * Description. HTML for ced_custom_meta_pricing_html
			 *
			 * @since  :1.0.0
			 * Version :1.0.0
			 * @return void
			 * @param int $post Global Variable for Post.
			 * @param int $post->Id for getting individual Post Id.
			 * @var int $valueforPricing  //To take Input of inventory value 
			 */

			function ced_custom_meta_pricing_html( $post) {
				$valueforPricing = get_post_meta($post->ID, 'ced_metabox_pricing', true);
				?>
			 <span style="color:red" id="massage"></span>
				<br>
				<label for="ced_meta_box_field">Discounted Price</label>
				<input type="number" id="ced_input_meta_discount" min="0" name="ced_input_meta_discount" value="<?php echo _e($valueforPricing['discountPrice']); ?>">
				<label for="ced_meta_box_field">Regular Price</label>
				<input type="number" id="ced_input_meta_regular_price" min="0" name="ced_input_meta_regular_price" value="<?php echo _e($valueforPricing['regularPrice']); ?>">

			<?php
			}
		}

		/**
		 * function Name :ced_custom_meta_inventory_save
		 * Description:Saving Data for ced_custom_meta_inventory
		 *
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @return void
		 * @param int $post_id The ID of the post being saved.
		 * @var int $finalvalue ,$discountPrice,$regularPrice for getting value of Meta Box Pricing for Product
		 */
		public function ced_custom_meta_pricing_save( int $post_id) {
			$finalvalue    = array();
			$discountPrice = isset($_POST['ced_input_meta_discount']) ? $_POST['ced_input_meta_discount'] : 0;
			$regularPrice  = isset($_POST['ced_input_meta_regular_price']) ? $_POST['ced_input_meta_regular_price'] : 0;
			$finalvalue    = array('discountPrice' => $discountPrice, 'regularPrice' => $regularPrice);

			if (array_key_exists('ced_input_meta_discount', $_POST)) {
				update_post_meta(
					$post_id,
					'ced_metabox_pricing',
					$finalvalue
				);
			}
		}


		// MetaBox Functions Ends Here

		/**
		 * function Name :ced_product_taxonomy
		 * Description:Creating Taxonomy For Product 
		 *
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @return void
		 * @var array $labels For All Label for Taxonomy
		 * @var array $args For All Arguments for Taxonomy
		 */

		public function ced_product_taxonomy() {
			$labels = array(
				'name'              => __('Product_Category'),
				'singular_name'     => __('Product_Category'),
				'search_items'      => __('Search Product Category'),
				'all_items'         => __('All Product Category'),
				'edit_item'         => __('Edit Product Category'),
				'update_item'       => __('Update Product Category'),
				'add_new_item'      => __('Add New Product Category'),
				'new_item_name'     => __('New Product Category Name'),
				'menu_name'         => __('Product Category'),
			);

			$args = [
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'show_admin_column' => true,
				'query_var' => true,
				'rewrite' => array('slug' => 'product'),
			];

			register_taxonomy('ProductCategory', ['product'], $args);
		}

		// Taxonomy Function Ends Here


		/**
		 * function Name :ced_shortcode_shop
		 * Description:Creating Short code for displaying the products in shop Page
		 *
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @return $content
		 * @param int $content
		 * @var int $wp_query (fetching Data from DB having a Post type "product")
		 */

		public function ced_shortcode_shop( $content = null) {
			$wp_query = new WP_Query(array(
				'posts_per_page' => 2,
				'post_type' => 'product',
				'paged' => get_query_var('paged') ? get_query_var('paged') : 1
			)); // Getting  from DB For Per Page Pagination
			while ($wp_query->have_posts()) :
				$wp_query->the_post();
				$price    = get_post_meta(get_the_ID(), 'ced_metabox_pricing', true);
				$content  = the_title('<h3 class="entry-title"><a href="' . get_permalink() . '">', '</a></h3>');
				$content .= the_post_thumbnail();
				echo '<h3>Price:$' . $price['discountPrice'] . '</h3>';
			endwhile;
			// Appending Pagination in $content
			$content .= paginate_links(array(
				'current' => max(1, get_query_var('paged')),
				'total' => $wp_query->max_num_pages
			));
			return $content;
		}


		/**
		 * function Name :product_admin_script
		 * Description:Enqueuing Script Whenever Post Type is Product And Check Validation
		 *
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @var int $status for current screen data
		 * @return void
		 */

		function product_admin_script() {
			$status = get_current_screen();
			if ($status->post_type == 'product') {
				wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/validate.js', array('jquery'), $this->version, false);
			}
		}


		/**
		 * function Name : Unset Session _after_logout
		 * Description:Unset session of cart when user will logout Session
		 *
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @var array $_SESSION['cedstore'] 
		 */

		function unsetSession_after_logout() {
			session_start();
			unset($_SESSION['cedstore']);
		}


		/**
		 * ced_order_menu
		 * Description : Adding Menu For Showing Orders List Using WP-List Table
		 *
		 * @return void
		 */
		function ced_order_menu() {
			add_menu_page(
				'Orders', // Menu Title
				'Orders', // Menu Name
				'manage_options', //Capabilities
				'order-menu', //Slug
				'ced_order_menu_html', //Function
				'dashicons-products', //Icon
				30
			);



			/**
			 * ced_order_menu_html
			 *	Description : Callback Function having Some html with wp-list-table For Order Menu 
			 *
			 * @return void
			 * @var	$obj //Object for Class Ced_order_List
			 */
			function ced_order_menu_html() {
				include_once PLUGIN_DIRPATH . 'admin/class-showDataorder-wp-list-table.php';
				$obj = new Ced_order_List();
				?>
				<div class="wrap">
					<h2>All Orders</h2>

					<div id="poststuff">
						<div id="post-body" class="metabox-holder columns-4">
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
<?php
			}
		}
	}
}
