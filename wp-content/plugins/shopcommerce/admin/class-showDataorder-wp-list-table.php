<?php
if (!class_exists('WP_List_Table')) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}


class Ced_order_List extends WP_List_Table {


	/** Class constructor */
	public function __construct() {

		parent::__construct([
			'singular' => __('order'), //singular name of the listed records
			'plural'   => __('orders'), //plural name of the listed records
			'ajax'     => false //should this table support ajax?
		]);
	}

	/**
	 * Retrieve user’s data from the database
	 *
	 * @param int $per_page
	 * @param int $page_number
	 *
	 * @return mixed
	 */


	public static function get_orders( $per_page = 5, $page_number = 1) {

		global $wpdb;
		$table_name = $wpdb->prefix . 'ced_orderDetail';

		$sql = "SELECT * FROM $table_name";

		if (!empty($_REQUEST['orderby'])) {
			$sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
			$sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
		}
		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;

		$result = $wpdb->get_results($sql, 'ARRAY_A');
		return $result;
	}

	/**
	 * Delete a customer record.
	 *
	 * @param int $id order ID
	 */

	public static function delete_orders( $id) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'ced_orderDetail';
		$wpdb->delete(
			"$table_name",
			['order_id' => $id],
			['%d']
		);
	}


	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'ced_orderDetail';
		$sql        = "SELECT COUNT(*) FROM $table_name";

		return $wpdb->get_var($sql);
	}

	/** Text displayed when no customer data is available */
	public function no_items() {
		_e('No Orders avaliable.');
	}



	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	function column_name( $item) {
		$actions = array(
			'delete'    => sprintf('<a href="?page=%s&action=%s&orders=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['order_id'])
		);

		return sprintf('%1$s %2$s', $item['order_id'], $this->row_actions($actions));
	}

	/**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @return string
	 */
	function column_cb( $item) {
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />',
			$item['order_id']
		);
	}


	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
		$columns = [
			'cb'      => '<input type="checkbox" />',
			'order_id'    => __('Order Id'),
			'order_detail' => ( 'Order Detail' ),
			'total_amount'    => __('Total Amount'),
			'payment_method' => __('Payment Method'),
			'time'    => __('Time')
		];

		return $columns;
	}



	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'order_id' => array('order_id', true),
			'total_amount' => array('total_amount', false),
			'time' => array('time', false),

		);

		return $sortable_columns;
	}



	/**
	 * Returns an associative array containing the bulk action
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = [
			'bulk-delete' => 'Delete'
		];

		return $actions;
	}


	public function column_default( $item, $column_name) {

		switch ($column_name) {
			case 'order_id':
				return $item[$column_name];
			case 'order_detail':
				// Showing Order Detail As Order List
				$order_details = json_decode($item['order_detail']);
				$printData     = "<ol style='float:left'>";
				foreach ($order_details as $element => $data) {
					$productname     = $data->product_name;
					$productprice    = $data->product_price;
					$productquantity = $data->quantity;
					$printData      .= "<li><b>Product Name :</b><br>$productname <br><b>Product Price:</b><br>$$productprice<br><b>Quantity: </b>$productquantity" .
						'</li>';
				}
				$printData .= '</ol>';
				return $printData;
			case 'total_amount':
				return '$' . $item[$column_name];
			case 'payment_method':
				return $item[$column_name];
			case 'time':
				return $item[$column_name];
			default:
				return print_r($item, true); //Show the whole array for troubleshooting purposes
		}
	}

	public function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if ('delete' === $this->current_action()) {

			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr($_REQUEST['_wpnonce']);

			if (!wp_verify_nonce($nonce, '_nonce_delete_orders')) {
				die('Go get a life script kiddies');
			} else {
				self::delete_users(absint($_GET['orders']));

				wp_redirect(esc_url(add_query_arg()));
				exit;
			}
		}

		// If the delete bulk action is triggered
		if (( isset($_POST['action']) && $_POST['action'] == 'bulk-delete' )
			|| ( isset($_POST['action2']) && $_POST['action2'] == 'bulk-delete' )
		) {

			$delete_ids = esc_sql($_POST['bulk-delete']);

			// loop over the array of record IDs and delete them
			foreach ($delete_ids as $id) {
				self::delete_orders($id);
			}

			wp_redirect(esc_url(add_query_arg()));
			exit;
		}
	}


	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {


		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);
		/** Process bulk action */
		$this->process_bulk_action();

		$per_page     = $this->get_items_per_page('users_per_page', 4);
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args([
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $per_page //WE have to determine how many items to show on a page
		]);

		$this->items = self::get_orders($per_page, $current_page);
	}
}
