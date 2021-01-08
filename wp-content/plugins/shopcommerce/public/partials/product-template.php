<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Shopcommerce
 * @subpackage Shopcommerce/public/partials/
 *
 *  Description: Whenever  Page Will Get Custom Post Type 'Product' Then This Page Will Renders
 *
 *
 *
 */

get_header();
while (have_posts()) : the_post();
?>
    <h1 class="title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h1>
    <?php the_post_thumbnail() ?>
    <h2>Price $<?php echo get_post_meta($id, 'ced_metabox_pricing', true) ?></h2>
    <div class="entry">
        <h4> Description :</h4><?php the_content();
                            endwhile;
                                ?>
    <input type="submit" name="add_to_cart" value="Add To cart">
    <br>
    <br>
    <?php get_footer() ?>

    <!-- This file should primarily consist of HTML with a little bit of PHP. -->