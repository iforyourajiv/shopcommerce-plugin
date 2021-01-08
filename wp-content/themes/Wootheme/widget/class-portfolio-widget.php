<?php

// Creating the widget For Custom Post Type (Portfolio)
class portfolio_widget extends WP_Widget
{

  function __construct()
  {
    parent::__construct(

      // Base ID of your widget
      'portfolio_widget',

      // Widget name will appear in UI
      __('portfolio_widget', 'portfolio_widget_domain'),

      // Widget description
      array('description' => __('Get All Portfolio Listing', 'portfolio_widget_domain'),)
    );
  }

  // Creating widget front-end

  public function widget($args, $instance)
  {
    $title = apply_filters('widget_title', $instance['title']);

    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if (!empty($title))
      echo $args['before_title'] . $title . $args['after_title'];

    // This is where We run the code and display the Portfolio Listing
    global $post;
    add_image_size('realty_widget_size', 85, 45, false);
    $listings = new WP_Query();
    $listings->query('post_type=portfolio');
    if ($listings->found_posts > 0) {
      echo '<ul class="realty_widget">';
      while ($listings->have_posts()) {
        $listings->the_post();
        $image = (has_post_thumbnail($post->ID)) ? get_the_post_thumbnail($post->ID, 'realty_widget_size') : '<div class="noThumb"></div>';
        $listItem = '<li>' . $image;
        $listItem .= '<a href="' . get_permalink() . '">';
        $listItem .= get_the_title() . '</a>';
        // $listItem .= '<br><span style="color:red">Added ' . get_the_date() . '</span></li>';
        echo $listItem;
      }
      echo '</ul>';
      wp_reset_postdata();
    } else {
      echo '<p style="padding:25px;">No listing found</p>';
    }
    echo $args['after_widget'];
  }

  // Widget Backend
  public function form($instance)
  {
    if (isset($instance['title'])) {
      $title = $instance['title'];
    } else {
      $title = __('New title', 'portfolio_widget_domain');
    }
    // Widget admin form
?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>
<?php
  }

  // Updating widget replacing old instances with new
  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    return $instance;
  }

  // Class  ends here
}

?>