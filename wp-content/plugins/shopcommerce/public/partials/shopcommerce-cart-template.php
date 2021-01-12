<?php

/**
 * Provide a public-facing view for the plugin
 * This file is used to markup the public-facing aspects of the plugin.
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 * @package    Shopcommerce
 * @subpackage Shopcommerce/public/partials/
 *  Description: Displaying All Product which are existing on cart Session 
 * @param $_SESSION['cedstore] //Session Variable (Type Array) For Cart
 * @param int $total //Calculating $total price
 * @param int $itemTotal //Total Value of Item
 * @param int $html // Printing all Data Using Foreach
 * @param int $cart_id,$cart_productName,$cart_productPrice,$cart_productQuantity (For Saving Individual values)
 */


/**
 *Session Started
 */
session_start();

/**
 *Getting Header
 */
get_header();

if (empty($_SESSION['cedstore']) || !isset($_SESSION['cedstore'])) {
    echo "<h1>Cart is Empty, Please Add Some Product</h1>";
}


// if user logged in the update immediately current Session Value on Db for Specific user
if(is_user_logged_in(  )){
    $user_id = get_current_user_id();
    update_user_meta($user_id, 'ced_shopcommerce_cart', $_SESSION['cedstore']);
}

//if  User Logged in then Display Cart for the Specific User
if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    $userCart = get_user_meta($user_id, 'ced_shopcommerce_cart', 1);
    $_SESSION['cedstore'] = $userCart;
    if (is_array($userCart) && !empty($userCart) || !empty($userCart[0])) {
        $total = 0;
        $html = ""; //  $html variable is intialized 
        $html .= "<table>"; //Creating Table
        $html .= "<th>Product Name  </th> <th>Product Price </th>  <th>Product Quantity</th><th>Item Amount</th><th>Action</th>";
        foreach ($userCart as $element) { //Loop start for Session Variable
            $cart_id = isset($element['id']) ? $element['id'] : ''; // Getting Id of Product if product isset
            $cart_productName = isset($element['product_name']) ? $element['product_name'] : ''; //Getting Product Name if  Name is isset
            $cart_productPrice = isset($element['product_price']) ? $element['product_price'] : 0; // Getting Product Price if price is isset
            $cart_productQuantity = isset($element['quantity']) ? $element['quantity'] : 0; //Getting Product Quantity if quantity is isset
            $html .= "<tr>";
            $html .= "<td> $cart_productName </td>";
            $html .= "<td>$  $cart_productPrice </td>";
            $html .= "<td>$cart_productQuantity";
            $html .= "<a style='margin-left:10px' href='?increaseqty=$cart_id'>+</a> ";
            $html .= "<a style='margin-left:10px' href='?decreaseqty=$cart_id'>-</a> </td> ";
            $itemTotal = $cart_productQuantity * $cart_productPrice; // Calculating Price for Individual Product
            $html .= "<td>$ $itemTotal</td>";
            $total = $total + $itemTotal; // Calculating Total Price Of Cart
            $html .= "<td><a  href='?del=$cart_id'><i class='fa fa-trash-o' style='margin-left:10px;color:red;'></i> </a> </td>";
        }
        $html .= "</table>";
        $html .= "<h4> Total :-$$total</h4>";
        echo $html; // Displayng Whole Cart Product In Table
    }
    if (empty($userCart)) {
        // echo "<h1>Cart is Empty, Please Add Some Product</h1>";
    }
} else {
    if (!isset($_SESSION['cedstore'])) {
        echo "";
    } else {
        $total = 0;
        $html = "";
        $html .= "<table>"; //Creating Table
        $html .= "<th>Product Name  </th> <th>Product Price </th>  <th>Product Quantity</th><th>Item Amount</th><th>Action</th>";
        foreach ($_SESSION['cedstore'] as $element) { //Loop start for Session Variable
            $cart_id = $element['id']; // Getting Id of Product
            $cart_productName = $element['product_name']; //Getting Product Name
            $cart_productPrice = $element['product_price']; // Getting Product Price
            $cart_productQuantity = $element['quantity']; //Getting Product Quantity
            $html .= "<tr>";
            $html .= "<td> $cart_productName </td>";
            $html .= "<td>$  $cart_productPrice </td>";
            $html .= "<td>$cart_productQuantity";
            $html .= "<a style='margin-left:10px' href='?increaseqty=$cart_id'>+</a> ";
            $html .= "<a style='margin-left:10px' href='?decreaseqty=$cart_id'>-</a> </td> ";
            $itemTotal = $cart_productQuantity * $cart_productPrice; // Calculating Price for Individual Product
            $html .= "<td>$ $itemTotal</td>";
            $total = $total + $itemTotal; // Calculating Total Price Of Cart
            $html .= "<td><a  href='?del=$cart_id'><i class='fa fa-trash-o' style='margin-left:10px;color:red;'></i> </a> </td>";
        }
        $html .= "</table>";
        $html .= "<h4> Total :-$$total</h4>";
        echo $html; // Displayng Whole Cart Product In Table

    }
}


// Deleting Cart Item With isset()
if (isset($_GET['del'])) {
    $id_for_del = $_GET['del']; //Getting Id from URL
    foreach ($_SESSION['cedstore'] as $element => $data) { //Loop Start
        if ($data['id'] == $id_for_del) { // Matching Array Id for Coming Product Id
            unset($_SESSION['cedstore'][$element]); //if Matched then Product will be removed
            //If user is Logged In then The Session Data Will Be Update In User Meta
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
                update_user_meta($user_id, 'ced_shopcommerce_cart', $_SESSION['cedstore']);
            }
        }
    }

    $redirect = home_url('cart'); // Saving Redirect Path
    echo ("<script>location.href = '" . $redirect . "'</script>"); //Redirecting Path
}


// Increasing Cart Item Quantity When Increase Button Click
if (isset($_GET['increaseqty'])) {
    $id_qty_update = $_GET['increaseqty']; //Getting Id from URL for Updating a Quantity
    foreach ($_SESSION['cedstore'] as $element => $data) {  //Loop Start
        if ($data['id'] ==  $id_qty_update) { // Matching Array Id for Coming Product Id
            $_SESSION['cedstore'][$element]['quantity'] += 1; //if Matched then Product Quantity Will Increased
            //If user is Logged In then The Session Data Will Be Update In User Meta
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
                update_user_meta($user_id, 'ced_shopcommerce_cart', $_SESSION['cedstore']);
            }
        }
    }

    $redirect = home_url('cart'); // Saving Redirect Path
    echo ("<script>location.href = '" . $redirect . "'</script>");  //Redirecting Path
}

// Decreasing Cart Item Quantity When Increase Button Click
if (isset($_GET['decreaseqty'])) {
    $id_qty_update = $_GET['decreaseqty']; //Getting Id from URL for Updating a Quantity
    foreach ($_SESSION['cedstore'] as $element => $data) { //Loop Start
        if ($data['id'] ==  $id_qty_update) { // Matching Array Id for Coming Product Id
            $_SESSION['cedstore'][$element]['quantity'] -= 1; //if Matched then Product Quantity Will decreased
            //If user is Logged In then The Session Data Will Be Update In User Meta
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
                update_user_meta($user_id, 'ced_shopcommerce_cart', $_SESSION['cedstore']);
            }
            if ($_SESSION['cedstore'][$element]['quantity'] == 0) { // Checking if Quantity is greater then 0
                unset($_SESSION['cedstore'][$element]); // if Quantity will be equal to 0 then Product Will Removed
                //If user is Logged In then The Session Data Will Be Update In User Meta
                if (is_user_logged_in()) {
                    $user_id = get_current_user_id();
                    update_user_meta($user_id, 'ced_shopcommerce_cart', $_SESSION['cedstore']);
                }
            }
        }
    }

    $redirect = home_url('cart'); // Saving Redirect Path
    echo ("<script>location.href = '" . $redirect . "'</script>"); //Redirecting Path
}
/**
 *Getting Footer
 */
get_footer();
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
©