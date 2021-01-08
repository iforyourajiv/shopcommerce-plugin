<?php

if (!class_exists('WP_List_Table')) {
  require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}


class Subscriber_List extends WP_List_Table
{

  /** Class constructor */
  public function __construct()
  {

    parent::__construct([
      'singular' => __('user', 'sp'), //singular name of the listed records
      'plural'   => __('users', 'sp'), //plural name of the listed records
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


  public static function get_users()
  {

    $args = array(
      'post_type'     => 'any',
      'post_status'   => 'publish',
      'fields'        => 'ids',
      'meta_query'    => array(
        array(
          'key'        => 'email',
          'compare'    => 'exist',
          'type'       => 'CHAR',
        ),
      ),
    );

    // The Query
    $result_query = new WP_Query($args);

    $ID_array = $result_query->posts;
    // Restore original Post Data
    wp_reset_postdata();
    $post_data = array();
    foreach ($ID_array as $ids) {
      $meta = get_post_meta($ids, 'email', 1);
      foreach ($meta as $key => $value) {
        $post_data[] = array('posttitle' => get_the_title($ids), "email" => $value);
      }
    }
    return $post_data;
  }

  /**
   * Delete a customer record.
   *
   * @param int $id customer ID
   */


  /**
   * Returns the count of records in the database.
   *
   * @return null|string
   */


  /** Text displayed when no customer data is available */
  public function no_items()
  {
    _e('No users avaliable.', 'sp');
  }



  /**
   * Method for name column
   *
   * @param array $item an array of DB data
   *
   * @return string
   */
  function column_name($item)
  {
    $title = '<strong>' . $item['email'] . '</strong> ';
    // create a nonce
    $delete_nonce = wp_create_nonce('sp_delete_users');


    $actions = [
      'delete' => sprintf('<a href="?page=%s&action=%s&users=%s&_wpnonce=%s">Delete</a>', esc_attr($_REQUEST['page']), 'delete', absint($item['id']), $delete_nonce)
    ];

    return $title . $this->row_actions($actions);
  }

  /**
   * Render the bulk edit checkbox
   *
   * @param array $item
   *
   * @return string
   */



  /**
   *  Associative array of columns
   *
   * @return array
   */
  function get_columns()
  {
    $columns = [
      'email'    => __('Email', 'sp'),
      'posttitle' => __('Post-Title', 'sp')
    ];

    return $columns;
  }



  /**
   * Columns to make sortable.
   *
   * @return array
   */
  public function get_sortable_columns()
  {
    $sortable_columns = array(
      'email' => array('email', true),
      'posttitle' => array('posttitle', true)

    );

    return $sortable_columns;
  }



  /**
   * Returns an associative array containing the bulk action
   *
   * @return array
   */


  public function column_default($item, $column_name)
  {
    switch ($column_name) {
      case 'email':
      case 'posttitle':
        return $item[$column_name];
      default:
        return print_r($item, true); //Show the whole array for troubleshooting purposes
    }
  }



  /**
   * Handles data query and filter, sorting, and pagination.
   */
  public function prepare_items()
  {


    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columns();
    $this->_column_headers = array($columns, $hidden, $sortable);
    /** Process bulk action */

    $this->items = self::get_users();
  }
}
