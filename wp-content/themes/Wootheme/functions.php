<?php


// Add Theme  CSS and Scripts

function ced_add_theme_scripts()
{
  wp_enqueue_style('style', get_stylesheet_uri());
  if (is_singular() & comments_open() &  get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'ced_add_theme_scripts',11);


// Menu Registration


function ced_register_my_menus()
{
  register_nav_menus(
    array(
      'header-menu' => __('menu')
    )
  );
}
add_action('init', 'ced_register_my_menus');


// BreadCrumb

function the_breadcrumb()
{
  if (!is_home()) {
    echo '<a href="';
    echo get_option('home');
    echo '">';
    bloginfo('name');
    echo "</a>» ";
    if (is_category() || is_single()) {
      the_category('title_li=');
      if (is_single()) {
        echo " » ";
        the_title();
      }
    } elseif (is_page()) {
      echo the_title();
    }
  }
}


//  Theme Support

function woo_theme_support()
{
  // Custom background color.
  add_theme_support(
    'custom-background',
    array(
      'default-color' => 'f5efe0',
    )
  );

  // Set content-width.
  global $content_width;
  if (!isset($content_width)) {
    $content_width = 580;
  }

  /*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
  add_theme_support('post-thumbnails');
  add_theme_support('post-formats',  array('aside', 'gallery', 'quote', 'image', 'video'));


  // Set post thumbnail size.
  set_post_thumbnail_size( 150, 150);

  // Add custom image size used in Cover Template.

  // Custom logo.
  $logo_width  = 120;
  $logo_height = 90;

  // If the retina setting is active, double the recommended width and height.
  if (get_theme_mod('retina_logo', false)) {
    $logo_width  = floor($logo_width * 2);
    $logo_height = floor($logo_height * 2);
  }

  add_theme_support(
    'custom-logo',
    array(
      'height'      => $logo_height,
      'width'       => $logo_width,
      'flex-height' => true,
      'flex-width'  => true,
    )
  );

  /*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
  add_theme_support('title-tag');

  /*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'script',
      'style',
      'navigation-widgets',
    )
  );
}

add_action('after_setup_theme', 'woo_theme_support');

function ced_sidebar_registration()
{

  // Arguments used in all register_sidebar() calls.
  $shared_args = array(
    'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
    'after_title'   => '</h2>',
    'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
    'after_widget'  => '</div></div>',
  );

  // Footer #1.
  register_sidebar(
    array_merge(
      $shared_args,
      array(
        'name'        => esc_html__('Footer #1', 'Woo theme'),
        'id'          => 'sidebar-1',
        'description' => esc_html('Widgets in this area will be displayed in the first column in the footer.', 'twentytwenty'),
      )
    )
  );
}

add_action('widgets_init', 'ced_sidebar_registration');



// Our custom post type function
function ced_create_posttype()
{

  register_post_type(
    'portfolio',
    // CPT Options
    array(
      'labels' => array(
        'name' => __('Portfolio'),
        'singular_name' => __('Portfolio'),
        'add_new'        => ('Add New Portfolio'),
      ),
      'public' => true,
      'has_archive' => true,
      'supports'            => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields'),
      'rewrite' => array('slug' => 'portfolio'),
      'show_in_rest' => true,

    )
  );
}


add_action('init', 'ced_create_posttype');





// Register and load the widget
require_once get_template_directory() . '/widget/class-portfolio-widget.php';
function portfolio_widget_widget()
{
  register_widget('portfolio_widget');
}
add_action('widgets_init', 'portfolio_widget_widget');



// Creating Custom Taxonomy For Portfolio

/**
 * ced_portfolio_taxonomy
 * 
 * @return void
 */
function ced_portfolio_taxonomy()
{
  $labels = array(
    'name'              => _x('Portfolio_Category', 'taxonomy general name'),
    'singular_name'     => _x('Portfolio_Category', 'taxonomy singular name'),
    'search_items'      => __('Search Portfolio Taxonomy'),
    'all_items'         => __('All Portfolio Taxonomy'),
    'parent_item'       => __('Parent Portfolio Taxonomy'),
    'parent_item_colon' => __('Parent Portfolio Taxonomy:'),
    'edit_item'         => __('Edit Portfolio Taxonomy'),
    'update_item'       => __('Update Portfolio Taxonomy'),
    'add_new_item'      => __('Add New Portfolio Taxonomy'),
    'new_item_name'     => __('New Portfolio Taxonomy Name'),
    'menu_name'         => __('Portfolio'),
  );

  register_taxonomy(
    'Portfolio taxonomy',
    'portfolio',
    array(
      'label' => __('Portfolio Category'),
      'labels' => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite' => array('slug' => 'portfolio'),
      'hierarchical' => true

    )

  );
}
add_action('init', 'ced_portfolio_taxonomy');
