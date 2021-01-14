<?php

/**
 * Provide a public-facing view for the plugin
 * This file is used to markup the public-facing aspects of the plugin.
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 * @package    Shopcommerce
 * @subpackage Shopcommerce/public/partials/
 *  Description: Checkout Page for Customer Where  USer can Complete His order Detail And Place his Order
 * 
 * 	
 */

$plugin_name = "Shopcommerce";
$version = "1.0.0";


/**
 *Session Started
 */
session_start();
if (!isset($_SESSION['cedstore']) || empty($_SESSION['cedstore'])) {
    wp_redirect('shop');
}

$_SESSION['total'] = "";
/**
 *Getting Header
 */
get_header();

require_once PLUGIN_DIRPATH . 'public/class-shopcommerce-public.php';
$obj = new Shopcommerce_Public($plugin_name, $version);

?>
<h1>Fill Your Details</h1>
<div id="form">
    <form action="" method="POST">
        <lable>Name :</lable>
        <input type="text" id="fullname" name="fullname" value="" placeholder="Enter Your Full Name" pattern='^([A-Za-z]+ )+[A-Za-z]+$|^[A-Za-z]+$' title="please Enter Name With Single Space" required><br><br>
        <lable>Mobile :</lable>
        <input type="text" id="number" name="mobile" value="" maxlength="12" placeholder="Mobile Number" title="Please Enter Valid Mobile Number" pattern="^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$" required><br><br>
        <lable>Email :</lable>
        <input type="email" id="email" name="email" value="" placeholder="Your Email" required> <br><br>
        <h3>Shipping Address</h3>
        <label>PIN Code :</label>
        <input id="zip" name="zip" type="text" placeholder="PIN code" required> <br><br>
        <label>Flat :</label>
        <input type="text" id="flat" name="flat" value="" placeholder="Flat No." required> <br><br>
        <label>Street :</label>
        <input type="text" id="street" name="street" value="" placeholder="Street Name" required> <br><br>
        <label>Landmark :</label>
        <input type="text" id="landmark" name="landmark" value="" placeholder="Landmark (ex:- Cedcoss Technologies )" required> <br><br>
        <label>Town :</label>
        <input type="text" id="town" name="town" value="" placeholder="Town" required> <br><br>
        <label>State :</label>
        <input type="text" id="state" name="state" value="" placeholder="State" required> <br><br>
        <input type="checkbox" id="check-address"> Billing Address is Same As Shipping Address
        <!-- ------------------------------------------------------------------------------------- -->
        <h3> Billing Address</h3>
        <label>PIN Code :</label>
        <input id="zip_billing" name="zip_billing" type="text" placeholder="PIN code" required> <br><br>
        <label>Flat :</label>
        <input type="text" id="flat_billing" name="flat_billing" value="" placeholder="Flat No." required> <br><br>
        <label>Street :</label>
        <input type="text" id="street_billing" name="street_billing" value="" placeholder="Street Name" required> <br><br>
        <label>Landmark :</label>
        <input type="text" id="landmark_billing" name="landmark_billing" value="" placeholder="Landmark (ex:- Cedcoss Technologies )" required> <br><br>
        <label>Town :</label>
        <input type="text" id="town_billing" name="town_billing" value="" placeholder="Town" required> <br><br>
        <label>State :</label>
        <input type="text" id="state_billing" name="state_billing" value="" placeholder="State" required> <br><br>

</div>


<div id="cartitem">
    <h3>Cart Item</h3>
    <table>
        <th>Product Name </th>
        <th>Product Price </th>
        <th>Product Quantity</th>
        <th>Item Amount</th>
        <?php

        // Print Cart Data when User Logged in
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $userCart = get_user_meta($user_id, 'ced_shopcommerce_cart', 1);
            if (is_array($userCart) && !empty($userCart) || !empty($userCart[0])) {
                $total = 0;
                foreach ($userCart as $element) { //Loop start for array Variable
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

                    <?php $total = $total + $itemTotal; // Calculating Total Price Of Cart 
                    $_SESSION['total'] = $total;
                }
            }
        } else {
            // Print Cart Data when Guest is Trying to checkout
            $total = 0;
            if (!isset($_SESSION['cedstore'])) {
                echo "";
            } else {

                foreach ($_SESSION['cedstore'] as $element) { //Loop start for array Variable
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
                    </tr>
        <?php $total = $total + $itemTotal; // Calculating Total Price Of Cart 
                    $_SESSION['total'] = $total;
                }
            }
        }

        ?>
    </table>
    <?php echo "<p id='total_amount'>Total Amount :-$ $total</p>"; ?> <br>
    <h4>Payment Method</h4>
    <input type="radio" id="cod" name="cod" value="cod" title="Please Select Payment Method" required> Cash on Delivery <i class="fa fa-money" aria-hidden="true"></i> <br>
    <input type="submit" id="place_order" name="ced_place_order" value="Place Order">
    </form>
</div>

<?php
/**
 *Getting Footer
 */

//Saving Value in DB
if (isset($_POST['ced_place_order'])) {
    if (
        empty($_POST['fullname']) || empty($_POST['mobile']) || empty($_POST['email']) || empty($_POST['zip_billing'])
        || empty($_POST['flat_billing']) || empty($_POST['street_billing']) || empty($_POST['landmark_billing'])
        || empty($_POST['town_billing']) || empty($_POST['state_billing']) || empty($_POST['zip'])
        || empty($_POST['flat']) || empty($_POST['street']) || empty($_POST['landmark'])
        || empty($_POST['town']) || empty($_POST['state'])
    ) {
        echo "Any Input Field Is empty ,Please Fill The Form And the Place Your Order";
        return false;
    }

    // Saving All Input Field in Array Which Belongs to Customer Detail 
    $customer_detail = array(
        'customer_name' => isset($_POST['fullname']) ? sanitize_text_field($_POST['fullname']) : false,
        'customer_mobile' => isset($_POST['mobile']) ? sanitize_text_field($_POST['mobile']) : false,
        'customer_email' => isset($_POST['email']) ? sanitize_text_field($_POST['email']) : false,
        'customer_zipcode' => isset($_POST['zip_billing']) ? sanitize_text_field($_POST['zip_billing']) : false,
        'customer_flatNumber' => isset($_POST['flat_billing']) ? sanitize_text_field($_POST['flat_billing']) : false,
        'customer_streetName' => isset($_POST['street_billing']) ? sanitize_text_field($_POST['street_billing']) : false,
        'customer_landmark' => isset($_POST['landmark_billing']) ? sanitize_text_field($_POST['landmark_billing']) : false,
        'customer_town' => isset($_POST['town_billing']) ? sanitize_text_field($_POST['town_billing']) : false,
        'customer_state' => isset($_POST['state_billing']) ? sanitize_text_field($_POST['state_billing']) : false,
    );
    // Saving All Input Field in Array Which Belongs to Shipping Detail 
    $shipping_detail = array(
        'shipping_zipcode' => isset($_POST['zip']) ? sanitize_text_field($_POST['zip']) : false,
        'shipping_flatNumber' => isset($_POST['flat']) ? sanitize_text_field($_POST['flat']) : false,
        'shipping_streetName' => isset($_POST['street']) ? sanitize_text_field($_POST['street']) : false,
        'shipping_landmark' => isset($_POST['landmark']) ? sanitize_text_field($_POST['landmark']) : false,
        'shipping_town' => isset($_POST['town']) ? sanitize_text_field($_POST['town']) : false,
        'shipping_state' => isset($_POST['state']) ? sanitize_text_field($_POST['state']) : false,
    );

    // If user logged In  then this will perform action for db 
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $userCart = get_user_meta($user_id, 'ced_shopcommerce_cart', 1);
        if (!is_array($userCart) || empty($userCart) || empty($userCart[0])) {
            return false;
        } else {

            $customer_detail_encoded = json_encode($customer_detail); //encoding in json
            $shipping_detail_encoded = json_encode($shipping_detail); //encoding in json
            $order_detail_encoded = json_encode($userCart); //encoding in json
            $total_amount = $_SESSION['total'];
            $payment_method = $_POST['cod'];
            $check = true;
            //Sending Data as Parameters to Function which is available on class using object
            $check = $obj->save_order_detail($user_id, $customer_detail_encoded, $shipping_detail_encoded, $order_detail_encoded, $total_amount, $payment_method);
            if ($check) { // If Successfull data Will be saved 
                foreach ($userCart as $element) { //starting loop for Updating Inventory
                    $cart_id = $element['id'];
                    $cart_productQuantity = $element['quantity'];
                    $inventoryvalue = get_post_meta($cart_id, 'ced_metabox_inventory', true);
                    $updateInventory = $inventoryvalue - $cart_productQuantity;
                    update_post_meta($cart_id, 'ced_metabox_inventory', $updateInventory);
                }
                update_user_meta($user_id, 'ced_shopcommerce_cart', '');
                unset($_SESSION['cedstore']);
                $redirect = home_url('thankyou'); // Saving Redirect Path
                echo ("<script>location.href = '" . $redirect . "'</script>"); //Redirecting Path
            }
        }
    } else { // If Guest Wants to purchase some data
        $user_id = 'guest';
        $customer_detail_encoded = json_encode($customer_detail); //encoding in json
        $shipping_detail_encoded = json_encode($shipping_detail); //encoding in json
        $order_detail_encoded = json_encode($_SESSION['cedstore']); //encoding in json
        $total_amount = $_SESSION['total'];
        $payment_method = $_POST['cod'];
        $check = true;
        //Sending Data as Parameters to Function which is available on class using object
        $check = $obj->save_order_detail($user_id, $customer_detail_encoded, $shipping_detail_encoded, $order_detail_encoded, $total_amount, $payment_method);
        if ($check) { // If Successfull data Will be saved 
            foreach ($_SESSION['cedstore'] as $element) { //starting loop for Updating Inventory
                $cart_id = $element['id'];
                $cart_productQuantity = $element['quantity'];
                $inventoryvalue = get_post_meta($cart_id, 'ced_metabox_inventory', true);
                $updateInventory = $inventoryvalue - $cart_productQuantity;
                update_post_meta($cart_id, 'ced_metabox_inventory', $updateInventory);
            }
            unset($_SESSION['cedstore']); //Deleting Session Variable for cedstore
            $redirect = home_url('thankyou'); // Saving Redirect Path
            echo ("<script>location.href = '" . $redirect . "'</script>"); //Redirecting Path
        }
    }
}




get_footer();
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->