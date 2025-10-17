<?php

//Need a file path? Theme URI, Images, Css, and JS
define( 'THEME_URI', get_template_directory_uri() );
define( 'THEME_DIR', get_template_directory() );
define( 'THEME_IMAGES', THEME_URI . '/assets/img' );
define( 'THEME_CSS', THEME_URI . '/assets/css' );
define( 'THEME_JS', THEME_URI . '/assets/js' );
define( 'MENU_CHOICE', 'hamburger--squeeze' );
//https://github.com/jonsuh/hamburgers/tree/master/dist is about 22KB too much
//Grab the applicable CSS, and replace it in the style.less stylesheet.
define( 'MENU_HOVER_EFFECT', 'hvr-underline-from-center');
//Okay here's the deal, we are not loading the entire hover.css minified file, its still about 100KB
//Define the hover effect you want here, but go to https://github.com/IanLunn/Hover/tree/master/css
//Grab the applicable CSS, and replace it in the style.less stylesheet.

require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

// Compile the less files via PHP and then served the cached file.
add_action( 'wp_print_styles', 'compile_less_files_to_css' );
function compile_less_files_to_css() {
    require(THEME_DIR . '/lib/less.php-master/lessc.inc.php');

    if (get_template_directory() === get_stylesheet_directory()) {
      // No Child theme
      $to_cache = array( THEME_DIR . "/assets/css/less/style.less" => get_bloginfo('wpurl'));
    } else {
      // Child theme installed!
      $child_style_path = get_stylesheet_directory() . "/assets/css/less/style.less";
      if (!file_exists($child_style_path)) {
        // child style.less does not exist, quick go fix!
        $to_cache = array( THEME_DIR . "/assets/css/less/style.less" => get_bloginfo('wpurl'));
      } else {
        $to_cache = array( THEME_DIR . "/assets/css/less/style.less" => get_bloginfo('wpurl'), $child_style_path => 'child');
      }
    }
    Less_Cache::$cache_dir = THEME_DIR . "/assets/css/less/cache/";
    Less_Cache::CleanCache();
    $parser_options['compress'] = true;
    $css_file_name = Less_Cache::Get( $to_cache, $parser_options );
    wp_enqueue_style( 'less-style', THEME_URI . "/assets/css/less/cache/" . $css_file_name, array( 'font-awesome5', 'bootstrap4' ) );
}
    
    
// Require, include files ---------------------------------------------------------------------
require THEME_DIR . '/inc/basicUtilities.php';

// Call to actions/filters of the theme to enable features, register sidebars, enqueue scripts and styles.
$FlitchBasicWP5 = new \FlitchBasicWP5\FlitchBasicWP5();
$FlitchBasicWP5->addActionsFilters();
unset($FlitchBasicWP5);

//Use hamburger.css library for hamburger menu instead of default
if (!function_exists('fl_menu_button')) {
    function fl_menu_button( $theme_location, $button_text='', $classes = '' ) {
        if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
            $button = '<button data-toggle="collapse" href="#main-menu" class="' . $classes . ' hamburger ' . MENU_CHOICE . '" type="button" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">' ."\n";
            if ($button_text) { $button .= $button_text; }
            $button .= '<span class="hamburger-box">' ."\n";
            $button .= '<span class="hamburger-inner"></span>' ."\n";
            $button .= '</span>' . "\n";
            $button .= '</button>' . "\n";
        } else {
            $button = '<span> No menu defined in location "'.$theme_location.'" </span>';
        }
        echo $button;
    }
}

// General Site Options (logo, social media, address, phone, etc.)
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
		'page_title' 	=> 'Site Settings',
		'menu_title'	=> 'Site Settings',
		'menu_slug' 	=> 'site-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

// Allow SVG Uploads
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// Wordpress dashboard full width editors.
add_action('admin_head', 'block_editor_full_width');
function block_editor_full_width() {
  echo '<style>
  .wp-block {
      width: 100% !important;
      max-width: none !important;}
  .editor-styles-wrapper .editor-writing-flow {  
      max-width: none !important;
      margin: 0 !important;}
}
  </style>';
}

// Write to log
if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}
function fc_enqueue_justified_gallery() {
    wp_enqueue_script('justified-gallery', 'https://cdnjs.cloudflare.com/ajax/libs/justifiedGallery/3.8.1/js/jquery.justifiedGallery.min.js', array('jquery'), null, true);
    wp_enqueue_style('justified-gallery-css', 'https://cdnjs.cloudflare.com/ajax/libs/justifiedGallery/3.8.1/css/justifiedGallery.min.css');
}
add_action('wp_enqueue_scripts', 'fc_enqueue_justified_gallery');

function enqueue_lightbox_assets() {
    wp_enqueue_style('lightbox-css', 'https://cdn.jsdelivr.net/npm/lightbox2@2/dist/css/lightbox.min.css');
    wp_enqueue_script('lightbox-js', 'https://cdn.jsdelivr.net/npm/lightbox2@2/dist/js/lightbox.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_lightbox_assets');


function fc_custom_gallery_assets() {
    wp_enqueue_script('fc-custom-gallery-js', get_template_directory_uri() . '/js/fc-custom-gallery.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'fc_custom_gallery_assets');

// Add new ACF Block
// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'register_acf_block_types');
}
function register_acf_block_types() {
    
    // register fc Header Video block
    acf_register_block_type(array(
        'name'              => 'fc-header-video',
        'title'             => __('FC Header Video'),
        'description'       => __('A custom block to show featured video.'),
        'render_template'   => 'template-blocks/fc-header-video-block.php',
        'category'          => 'formatting',
        'icon'              => 'video-alt2',
        'keywords'          => array( 'header', 'video', 'featured', 'connect'),
    ));
    
    
    // register fc Primary block
    acf_register_block_type(array(
        'name'              => 'fc-primary',
        'title'             => __('FC Primary'),
        'description'       => __('A custom block to show ...'),
        'render_template'   => 'template-blocks/fc-primary-block.php',
        'category'          => 'formatting',
        'icon'              => 'video-alt2',
        'keywords'          => array( 'image', 'text', 'example'),
    ));

    // register fc Rotating Banner block
    acf_register_block_type(array(
      'name'              => 'fc-rotating-banner',
      'title'             => __('FC Rotating Banner'),
      'description'       => __('A custom block to show ...'),
      'render_template'   => 'template-blocks/fc-rotating-banner.php',
      'category'          => 'formatting',
      'icon'              => 'video-alt2',
      'keywords'          => array( 'image', 'text', 'banner'),
  ));
    
  // register fc Homepage Attractions block
  acf_register_block_type(array(
    'name'              => 'fc-homepage-attractions',
    'title'             => __('FC Homepage Attractions'),
    'description'       => __('A custom block to show ...'),
    'render_template'   => 'template-blocks/fc-homepage-attractions.php',
    'category'          => 'formatting',
    'icon'              => 'video-alt2',
    'keywords'          => array( 'image', 'text', 'attractions'),
    ));

    // register fc Homepage Attractions block
    acf_register_block_type(array(
        'name'              => 'fc-custom_gallery',
        'title'             => __('Fiesta Fun Center Gallery'),
        'description'       => __('A custom gallery block with filtering.'),
        'render_template'   => 'template-blocks/fc-custom_gallery.php',
        'category'          => 'formatting',
        'icon'              => 'images-alt2',
        'keywords'          => array( 'image', 'text', 'gallery'),
    ));

    acf_register_block_type(array(
        'name'              => 'mobile-slider',
        'title'             => __('FC Mobile Slider'),
        'description'       => __('A custom block to show a mobile-only image slider with title, description, and link.'),
        'render_template'   => '/template-blocks/mobile-slider.php',
        'category'          => 'formatting',
        'icon'              => 'video-alt2',
        'keywords'          => array('slider', 'mobile', 'carousel', 'image', 'acf'),
        'mode'              => 'preview',
        'supports'          => array('align' => false),
    ));
}

function register_my_menus() {
  register_nav_menus(
      array(
          'quick-links-menu' => __('Quick Links Menu'),
          'get-in-touch-menu' => __('Get In Touch Menu'),
          'support-menu' => __('Support Menu'),
          'mobile-secondary' => __('Mobile Secondary Menu'),
      )
  );
}
add_action('after_setup_theme', 'register_my_menus');

function filter_packages_ajax() {
  $categories = isset($_POST['categories']) ? $_POST['categories'] : array();

  $args = array(
      'post_type'      => 'package',
      'posts_per_page' => -1,
      'order'          => 'ASC',
      'orderby'        => 'date',
  );

  if (!empty($categories)) {
      $tax_query = array('relation' => 'AND'); // Require all selected categories

      foreach ($categories as $category) {
          $tax_query[] = array(
              'taxonomy' => 'package-category',
              'field'    => 'term_id',
              'terms'    => $category,
              'operator' => 'AND', // Ensures package has all selected categories
          );
      }

      $args['tax_query'] = $tax_query;
  }

  $query = new WP_Query($args);

  if ($query->have_posts()) :
      while ($query->have_posts()) : $query->the_post();
          $price = get_field('price');
          $additional_guests_price = get_field('additional_guests_price');
          $value = get_field('value');
          $button = get_field('button');
          $includes = get_field('includes');
          ?>

          <div class="package-item">
              <div class="package-details">
                  <div class="default-flex">
                      <div class="inner">
                          <h2><?php the_title(); ?></h2>
                          <p><?php echo esc_html($price); ?> | <?php echo esc_html($additional_guests_price); ?></p>
                      </div>
                      <div class="inner alignright">
                          <?php if ($button) : ?>
                              <span class="btn-purple">
                                  <a href="<?php echo esc_url($button['url']); ?>" target="<?php echo esc_attr($button['target']); ?>" class="package-button">
                                      <?php echo esc_html($button['title']); ?>
                                  </a>
                              </span>
                          <?php endif; ?>
                      </div>
                  </div>

                  <?php if ($includes) : ?>
                        <?php $total_items = count($includes); ?>
                        <div class="package-includes-container">
                            <strong>Includes:</strong>
                            <div class="package-includes">
                                <ul>
                                    <?php for ($i = 0; $i < ceil($total_items / 2); $i++) : ?>
                                        <li><?php echo esc_html($includes[$i]['included_item']); ?></li>
                                    <?php endfor; ?>
                                </ul>
                                <ul>
                                    <?php for ($i = ceil($total_items / 2); $i < $total_items; $i++) : ?>
                                        <li><?php echo esc_html($includes[$i]['included_item']); ?></li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>

                  <p class="alignright"><strong>Value:</strong> <?php echo esc_html($value); ?></p>
              </div>
              <div class="package-image">
                  <?php if (has_post_thumbnail()) {
                      the_post_thumbnail('full');
                  } ?>
              </div>
          </div>

      <?php endwhile;
      wp_reset_postdata();
  else :
      echo '<p>No packages found.</p>';
  endif;

  wp_die();
}
add_action('wp_ajax_filter_packages', 'filter_packages_ajax');
add_action('wp_ajax_nopriv_filter_packages', 'filter_packages_ajax');


function add_ajax_url() {
  ?>
  <script type="text/javascript">
      var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
  </script>
  <?php
}
add_action('wp_head', 'add_ajax_url');

class Mobile_Menu_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $has_children = in_array('menu-item-has-children', $item->classes) ? 'has-children' : '';
  
        $output .= '<li class="menu-item ' . $has_children . '">';
        $output .= '<a href="' . $item->url . '">' . $item->title . '</a>';
    }
  
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="submenu">';
    }
  }

function custom_mobile_menu() {
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'walker' => new Mobile_Menu_Walker(),
    ));
  }

  function enqueue_mobile_slider_assets() {
    if (is_admin()) return;

    wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);

    wp_enqueue_script('mobile-slider-init', get_template_directory_uri() . '/js/mobile-slider.js', array('swiper-js'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_mobile_slider_assets');