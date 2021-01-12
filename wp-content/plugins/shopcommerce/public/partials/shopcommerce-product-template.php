<?php

/**
 * Provide a public-facing view for the plugin
 * This file is used to markup the public-facing aspects of the plugin.
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 * @package    Shopcommerce
 * @subpackage Shopcommerce/public/partials/
 *  Description: Whenever  Page Will Get Custom Post Type 'Product' Then This Page Will Renders and List
 *               all Products
 *
 */


/**
 *Session Started
 */
session_start();

/**
 *Getting Header 
 */
get_header();


/**
 *
 * Description:Runnong While Loop For Listing A Product ON Shop Page
 * @since  :1.0.0
 * Version :1.0.0
 */

while (have_posts()) : the_post();
?>

    <h1 class="title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h1>
    <?php the_post_thumbnail();
    $price = get_post_meta($id, 'ced_metabox_pricing', true);
    ?>
    <h2>Price $<?php echo $price['discountPrice']; ?></h2>
    <div class="entry">
        <h4> Description :</h4><?php the_content();
                            endwhile; //loop ends here
                                ?>
    <form action="" method="post">
        <input type="hidden" name="ced_post_id_forCart" value="<?php echo $id ?>">
        <input type="submit" name="ced_add_to_cart" value="Add To cart">
        <br>
        <br>
    </form>
    <?php


    // If Session is Empty then Create new Session Variable Of Type Array 
    if (empty($_SESSION['cedstore'])) {
        $_SESSION['cedstore'] = array();
    }


// if user logged in the update immediately current Session Value on Db for Specific user
    if(is_user_logged_in(  )){
        $user_id = get_current_user_id();
        update_user_meta($user_id, 'ced_shopcommerce_cart', $_SESSION['cedstore']);
    }

    // If Anyone Click Add to Cart Button then This Block Will Run
    if (isset($_POST['ced_add_to_cart'])) { // Checking if Button is set or not
        $post_id_for_cart = $_POST['ced_post_id_forCart']; // Getting Product Id
        $post_item_cart = get_post($post_id_for_cart); // Getting Single Product from DB With ID
        $ced_product_name = $post_item_cart->post_title; // Getting Product Title
        $price = get_post_meta($post_id_for_cart, 'ced_metabox_pricing', true);
        $ced_product_price = $price['discountPrice']; // Getting Price for Product With Post meta
        $quantity = 1; //Default Quantity For Product
        $found = false;
        foreach ($_SESSION['cedstore'] as $element => $data) { // Runing Loop for checking Uniqeness of Product
            if ($data['id'] == $post_id_for_cart) { // Matching Array Id with Post Id
                $_SESSION['cedstore'][$element]['quantity'] += 1; //If id is match  Quantity Will Increase
                $found = true; // Value is chamge True to False
                echo "Product Quantity Increased"; //Printing Message
                //If user is Logged In then The Session Data Will Be Update In User Meta
                if (is_user_logged_in()) {
                    $user_id = get_current_user_id();
                    update_user_meta($user_id, 'ced_shopcommerce_cart', $_SESSION['cedstore']);
                }
            }
        }
        if (!$found) { //if Product Not Found
            //Creating a array for adding Product in Array
            $item = array('id' => $post_id_for_cart, 'product_name' =>   $ced_product_name, 'product_price' =>  $ced_product_price, 'quantity' => $quantity);
            array_push($_SESSION['cedstore'], $item); // Push the current array in Session Array
            //If user is Logged In then new User Meta will created and Session Data Will Be Store in Permanently In User Meta 
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
                add_user_meta($user_id, 'ced_shopcommerce_cart', '', 1);
                $userCart = get_user_meta($user_id, 'ced_shopcommerce_cart', 1);
                update_user_meta($user_id, 'ced_shopcommerce_cart', $_SESSION['cedstore']);
            }
            echo "Product Added In Cart";
        }
    }

    ?>

    <?php
    /**
     *Getting Footer
     */
    get_footer() ?>




    <!-- This file should primarily consist of HTML with a little bit of PHP. -->