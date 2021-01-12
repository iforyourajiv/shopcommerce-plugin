<?php

/**
 * Provide a public-facing view for the plugin
 * This file is used to markup the public-facing aspects of the plugin.
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 * @package    Shopcommerce
 * @subpackage Shopcommerce/public/partials/
 *  Description: Checkout Page for Customer Where  USer can Complete His order Detail And Place his Order
 */


/**
 *Session Started
 */
session_start();
/**
 *Getting Header
 */
get_header();

?>
<h1>Checkout</h1>
<div id="form">
<form action="" method="POST">
<lable>Name :</lable>
<input type="text" id="fullname" name="fullname" value="" placeholder="Enter Your Full Name" required><br><br>
<lable>Mobile :</lable>
<input type="number" id="number" name="mobile" value="" maxlength="12" placeholder="Mobile Number" required><br><br>
<lable>Email :</lable>
<input type="email" id="email" name="email" value=""  placeholder="Your Email" required> <br><br>
<h3>Address</h3>
<label>PIN Code :</label>
<input id="zip" id="zip" name="zip" type="text" inputmode="numeric" pattern="^(?(^00000(|-0000))|(\d{5}(|-\d{4})))$" placeholder="PIN code" required> <br><br>
<label>Flat :</label>
<input type="text" id="flat" name="flat" value="" placeholder="Flat No." required> <br><br>
<label>Street :</label>
<input type="text" id="street" name="street" value="" placeholder="Street Name" required> <br><br>
<label>Landmark :</label>
<input type="text" id="landmark" name="landmark" value="" placeholder="Landmark (ex:- Cedcoss Technologies )" required> <br><br>
<label>Town :</label>
<input type="text" id="town" name="town" value="" placeholder="Town" required> <br><br>
<label>State :</label>
<input type="text" id="town" name="town" value="" placeholder="State" required> <br><br>

-------------------------------------------------------------------------------------
<h3> Billing Address</h3>
<label>PIN Code :</label>
<input id="zip" id="zip" name="zip" type="text" inputmode="numeric" pattern="^(?(^00000(|-0000))|(\d{5}(|-\d{4})))$" placeholder="PIN code" required> <br><br>
<label>Flat :</label>
<input type="text" id="flat" name="flat" value="" placeholder="Flat No." required> <br><br>
<label>Street :</label>
<input type="text" id="street" name="street" value="" placeholder="Street Name" required> <br><br>
<label>Landmark :</label>
<input type="text" id="landmark" name="landmark" value="" placeholder="Landmark (ex:- Cedcoss Technologies )" required> <br><br>
<label>Town :</label>
<input type="text" id="town" name="town" value="" placeholder="Town" required> <br><br>
<label>State :</label>
<input type="text" id="town" name="town" value="" placeholder="State" required> <br><br>
<input type="submit" name="ced_place_order" value="Place Order">
</form>
</div>



<div id="cartitem">
    <h3>Cart Item</h3>
    <table>
  <th>Product Name  </th>
   <th>Product Price </th> 
    <th>Product Quantity</th>
    <th>Item Amount</th>
        <?php 
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $userCart = get_user_meta($user_id, 'ced_shopcommerce_cart', 1);
        $_SESSION['cedstore'] = $userCart;
        if (is_array($userCart) && !empty($userCart) || !empty($userCart[0])) {
            $total = 0;
            foreach ($userCart as $element) { //Loop start for Session Variable
                $cart_id = isset($element['id']) ? $element['id'] : ''; // Getting Id of Product if product isset
                $cart_productName = isset($element['product_name']) ? $element['product_name'] : ''; //Getting Product Name if  Name is isset
                $cart_productPrice = isset($element['product_price']) ? $element['product_price'] : 0; // Getting Product Price if price is isset
                $cart_productQuantity = isset($element['quantity']) ? $element['quantity'] : 0; //Getting Product Quantity if quantity is isset
                $itemTotal = $cart_productQuantity * $cart_productPrice;
?>
                <tr>
                 <td> <?php echo $cart_productName ?> </td>
                 <td> $<?php echo $cart_productPrice ?> </td>
                 <td> <?php echo $cart_productQuantity ?></td>
                 <td> $<?php echo  $itemTotal ?></td>
                <!-- $total = $total + $itemTotal; // Calculating Total Price Of Cart -->
  <?php          }
        }

    }

?>
    </table>
</div>




<?php
/**
 *Getting Footer
 */
get_footer();
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
