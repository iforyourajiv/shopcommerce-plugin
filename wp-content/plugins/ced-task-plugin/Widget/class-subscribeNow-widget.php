<?php

// Creating the widget For Custom Post Type (Portfolio)

use function PHPSTORM_META\type;

class Subscribe_Now extends WP_Widget
{

    function __construct()
    {
        parent::__construct(

            // Base ID of your widget
            'Subscribe_Now_widget',

            // Widget name will appear in UI
            __('Subscribe_Now_widget', 'Subscribe_Now_widget_domain'),

            // Widget description
            array('description' => __('Subscribe Now', 'Subscribe_Now_widget_domain'),)
        );
    }





    // Widget Backend
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'Subscribe_Now_widget_domain');
        }
        if (isset($instance['postTypes'])) {
            $postTypes = $instance['postTypes'];
        } else {
            $postTypes = "";
        }


        // Widget admin form
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            <?php
            $args = array(
                'public'   => true,
                '_builtin' => false
            );

            $output = 'names'; // 'names' or 'objects' (default: 'names')
            $operator = 'or'; // 'and' or 'or' (default: 'and')

            $post_types = get_post_types($args, $output, $operator);

            if ($post_types) { // If there are any custom public post types
                echo "<p>Post Type Where You Want to Show Subscribe Now Form</p>";
                foreach ($post_types  as $post_type) {
                    if (is_array($postTypes)) {
                        if (in_array($post_type, $postTypes)) { //check if Post Type checkbox is checked and display as check if so
                            $checked = "checked='checked'";
                        } else {
                            $checked = "";
                        }
                    } else {
                        $checked = "";
                    }
                    if ($post_type == 'attachment') {
                        continue;
                    }
            ?>
                    <input id="<?php echo $this->get_field_id('postTypes') . $post_type; ?>" name="<?php echo $this->get_field_name('postTypes[]'); ?>" type="checkbox" value="<?php echo $post_type; ?>" <?php echo $checked ?> /> <?php echo $post_type ?>
            <?php }
            } ?>



        </p>
<?php
    }


    // Printing Widget on  Front End  With Conditions Where Post is Matching with Widget Selection 
    public function widget($args, $instance)
    {
        global $post;
        $post_type = get_post_type($post->ID);
        if (is_array($instance['postTypes'])) {
            if (is_single() && in_array($post_type, $instance['postTypes'])) {
                $title = apply_filters('widget_title', $instance['title']);
                // before and after widget arguments are defined by themes
                echo $args['before_widget'];
                if (!empty($title))
                    echo $args['before_title'] . $title . $args['after_title'];

                // This is where We run the code and display Form
                $html = "<form action='' method='post'>";
                $html .= "<label>Email:</label><input type='email' name='emailsubcriber'>
                <input type='hidden' name='id' value='" . get_the_ID() . "'>
                <input type='submit' name='ced_task_plugin_subscribe' value='Subscribe Now'>";
                $html .= "</form>";

                echo $html;
            }
        }
    }



    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['postTypes'] =  isset($new_instance['postTypes']) ? $new_instance['postTypes'] : false;
        return $instance;
    }

    // Class  ends here
}


// Saving The Subscriber Email in Post Meta Table
if (isset($_POST['ced_task_plugin_subscribe'])) {
    $post_id = $_POST['id'];
    $email = $_POST['emailsubcriber'];
    $exist = get_post_meta($post_id, 'email', true);
    if (!empty($exist)) {
        $exist[] = $email;
    } else {
        $exist = array($email);
    }
    update_post_meta($post_id, 'email', $exist);
}
?>