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
class Shopcommerce_Admin
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		// Adding Shortcode For Shop Page
		add_shortcode('ced_shop_content',array($this, 'ced_shortcode_shop'));
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/shopcommerce-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/shopcommerce-admin.js', array('jquery'), $this->version, false);
	}



	/**
	 * function Name :ced_customPost_Product
	 * Description. Creating New Post Type Having a name with 'Product'
	 * @return void
	 * @since  :1.0.0
	 * Version :1.0.0
	 */
	public function ced_customPost_Product()
	{
		register_post_type(
			'Product',
			// CPT Options
			array(
				'labels' => array(
					'name' => __('Products'),
					'singular_name' => __('Product'),
					'edit_item'          => ('Edit Product'),
					'add_new'        => ('Add New Product'),
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
	 * @since  :1.0.0
	 * Version :1.0.0
	 * @return void
	 */
	public function ced_custom_meta_inventory()
	{
		add_meta_box(
			'ced_metabox_inventory',          // Unique ID
			'Inventory', // Box title
			'ced_custom_meta_inventory_html',  // Content callback, must be of type callable
			'Product', // Post type
			'side'
		);


		/**
		 * function Name :ced_custom_meta_inventory_html
		 * Description. HTML for ced_custom_meta_inventory
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @return void
		 * @param int $post Global Variable for Post.
		 * @param int $post->Id for getting individual Post Id.
		 */

		function ced_custom_meta_inventory_html($post)
		{
			$valueforinventory = get_post_meta($post->ID, 'ced_metabox_inventory', true);
?>
			<label for="ced_meta_box_field">Inventory</label>
			<input type="text" id="ced_input_meta_inventory" name="ced_input_meta_inventory" value="<?php echo _e($valueforinventory) ?>">
		<?php
		}
	}

	/**
	 * function Name :ced_custom_meta_inventory_save
	 * Description:Saving Data for ced_custom_meta_inventory
	 * @since  :1.0.0
	 * Version :1.0.0
	 * @return void
	 * @param int $post_id The ID of the post being saved.
	 */
	public function ced_custom_meta_inventory_save(int $post_id)
	{

		if (array_key_exists('ced_input_meta_inventory', $_POST)) {
			update_post_meta(
				$post_id,
				'ced_metabox_inventory',
				$_POST['ced_input_meta_inventory']
			);
		}
	}

	// Meta box Inventory Function Ends here


	/**
	 * function Name :ced_custom_meta_pricing
	 * Description. Creating New Meta Box  Having a name with 'Pricing' For Product Post Type
	 * @since  :1.0.0
	 * Version :1.0.0
	 * @return void
	 */
	public function ced_custom_meta_pricing()
	{
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
		 * @since  :1.0.0
		 * Version :1.0.0
		 * @return void
		 * @param int $post Global Variable for Post.
		 * @param int $post->Id for getting individual Post Id.
		 */

		function ced_custom_meta_pricing_html($post)
		{
			$valueforinventory = get_post_meta($post->ID, 'ced_metabox_pricing', true);

		?> <label for="ced_meta_box_field">Discounted Price</label>
			<input type="number" id="ced_input_meta_discount" name="ced_input_meta_discount" value="<?php echo _e($valueforinventory, 'shopcommerce') ?>">
			<label for="ced_meta_box_field">Regular Price</label>
			<input type="number" id="ced_input_meta_regular_price" name="ced_input_meta_regular_price" value="<?php echo _e($valueforinventory, 'shopcommerce') ?>">
<?php
		}
	}

	/**
	 * function Name :ced_custom_meta_inventory_save
	 * Description:Saving Data for ced_custom_meta_inventory
	 * @since  :1.0.0
	 * Version :1.0.0
	 * @return void
	 * @param int $post_id The ID of the post being saved.
	 * @param int $finalvalue ,$discountPrice,$regularPrice for getting value of Meta Box Pricing for Product
	 */
	public function ced_custom_meta_pricing_save(int $post_id)
	{
		$finalvalue = 0;
		$discountPrice = isset($_POST['ced_input_meta_discount']) ? $_POST['ced_input_meta_discount'] : false;
		$regularPrice = isset($_POST['ced_input_meta_regular_price']) ? $_POST['ced_input_meta_regular_price'] : false;
		if (empty($discountPrice) || $discountPrice == 0) {
			$finalvalue = sanitize_text_field($regularPrice);
		} else {
			$finalvalue = sanitize_text_field($discountPrice);
		}
		if (array_key_exists('ced_input_meta_discount', $_POST)) {
			update_post_meta(
				$post_id,
				'ced_metabox_pricing',
				sanitize_text_field($finalvalue)
			);
		}
	}


	// MetaBox Functions Ends Here 

	/**
	 * function Name :ced_product_taxonomy
	 * Description:Creating Taxonomy For Product 
	 * @since  :1.0.0
	 * Version :1.0.0
	 * @return void
	 * @param int $labels
	 */

	public function ced_product_taxonomy()
	{
		$labels = array(
			'name'              => __('Product_Category', 'shopcommerce'),
			'singular_name'     => __('Product_Category', 'shopcommerce'),
			'search_items'      => __('Search Product Category'),
			'all_items'         => __('All Product Category'),
			'edit_item'         => __('Edit Product Category'),
			'update_item'       => __('Update Product Category'),
			'add_new_item'      => __('Add New Product Category'),
			'new_item_name'     => __('New Product Category Name'),
			'menu_name'         => __('Product Category'),
		);

		register_taxonomy(
			'Product taxonomy', //Name
			'product', //Object
			array(
				'label' => __('Product Category'),
				'labels' => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite' => array('slug' => 'product'),
				'hierarchical' => true

			)

		);
	}

// Taxonomy Function Ends Here

	/**
	 * function Name :ced_product_taxonomy
	 * Description:Creating Taxonomy For Product 
	 * @since  :1.0.0
	 * Version :1.0.0
	 * @return $content
	 * @param int $content
	 */

	public function ced_shortcode_shop($content = null)
	{  
		$loop = new WP_Query(array('post_type' => 'product'));
		while ($loop->have_posts()) : 
			$loop->the_post();
			$content = the_title('<h3 class="entry-title"><a href="' . get_permalink() . '">', '</a></h3>');
			$content .= the_post_thumbnail();
			echo "<h3>Price:$".get_post_meta(get_the_ID(),'ced_metabox_pricing', true)."</h3>";
			$content .= "<div class='entry-content'>" . the_content() . "</div>";
		endwhile;
		return $content;
	}





}
