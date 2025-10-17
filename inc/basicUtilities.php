<?php

namespace FlitchBasicWP5;

if (!class_exists('\\FlitchBasicWP5\\FlitchBasicWP5')) {
    /**
     * main functional in class style.
     * 
     * This class will be handle all the main hooks that work with theme features such as add theme support features, register widgets area or sidebar, enqueue scripts and styles.<br>
     * To use, just code as follows:
     * 
     * $FlitchBasicWP5 = new \FlitchBasicWP5\FlitchBasicWP5();
     * $FlitchBasicWP5->addActionsFilters();
     * 
     * That's it.
     */
    class FlitchBasicWP5
    {

        /**
         * Add actions and filters to make main theme functional works.
         */
        public function addActionsFilters()
        {
            // Register sidebars.
            add_action('widgets_init', array(&$this, 'registerSidebars'));
            // Enqueue scripts and styles.
            add_action('wp_enqueue_scripts', array(&$this, 'enqueueScriptsAndStyles'));
            // Add theme feature.
            add_action('after_setup_theme', array(&$this, 'themeSetup'));
        }// addActionsFilters
        
        /**
         * Enqueue scripts and styles.
         * 
         * @access private Do not access this method directly. This is for hook callback not for direct call.
         */
        public function enqueueScriptsAndStyles()
        {
            wp_enqueue_style('font-awesome5', 'https://use.fontawesome.com/releases/v5.6.3/css/all.css', array(), '5.6.3');
            wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css', array(), '4.2.1');
            
            
            wp_enqueue_script('jquery');
            $js_ver  = date("ymd-Gis", filemtime( THEME_DIR . '/assets/js/main.js' ));
            wp_enqueue_script('main-js', THEME_JS . '/main.js', array(), $js_ver );
            wp_enqueue_script('bootstrap4', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.min.js', array(), '4.2.1' );
            wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js', array(), '1.14.6' );
            
            
            
            // adobe fonts
            wp_enqueue_style("adobe-fonts", "https://use.typekit.net/viz0xqe.css");
            
            
            // slick library
            wp_enqueue_script('slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js', array(), '1.9.0');
            wp_enqueue_style('slick-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css', array(), '1.9.0');
            wp_enqueue_style('slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css', array(), '1.9.0');
            
            
        }// enqueueScriptsAndStyles

        /**
         * Register sidebars
         * 
         * @access private Do not access this method directly. This is for hook callback not for direct call.
         */
        public function registerSidebars()
        {
            register_sidebar(array(
                'name'          => __('Footer Copyright', 'FlitchBasicWP5'),
                'id'            => 'footer-copyright',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h1 class="widget-title">',
                'after_title'   => '</h1>',
            ));
            register_sidebar(array(
                'name'          => __('Left Sidebar', 'FlitchBasicWP5'),
                'id'            => 'sidebar-left',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h1 class="widget-title">',
                'after_title'   => '</h1>',
            ));
        }// registerSidebars

        /**
         * Add theme feature.
         * 
         * @access private Do not access this method directly. This is for hook callback not for direct call.
         */
        public function themeSetup()
        {
            // add theme support for WooCommerce
            add_theme_support( 'woocommerce' );

            // allow the use of html5 markup
            // @link https://codex.wordpress.org/Theme_Markup
            add_theme_support('html5', array('caption', 'comment-form', 'comment-list', 'gallery', 'search-form'));

            // add support menu
            register_nav_menus(array(
                'primary' => __('Primary Menu', 'flitch_wp5'),
            ));

    		//title tag
    		add_theme_support( 'title-tag' );
    		
            // add post formats support
            add_theme_support('post-formats', array('standard'));

            // add post thumbnails support. **This is REQUIRED for post editor to show featured image field.**
            // To display featured image, please use post thumbnail functions.
            // See https://codex.wordpress.org/Post_Thumbnails for reference.
            add_theme_support('post-thumbnails');

            //GUTENBERG SPECIFIC
    		// Add support for responsive embedded content.
    		add_theme_support( 'responsive-embeds' );

    		// Add support for Block Styles.
    		add_theme_support( 'wp-block-styles' );
    
    		// Add support for full and wide align images.
    		add_theme_support( 'align-wide' );
    
    		// Add support for editor styles.
    		add_theme_support( 'editor-styles' );
    
    		// Enqueue editor styles.
    		add_editor_style( 'style-editor.css' );
    		
    		// Editor color palette.
    		add_theme_support(
    			'editor-color-palette',
    			array(
    				array(
    					'name'  => __( 'Primary', 'flitch_wp5' ),
    					'slug'  => 'primary',
    					'color' => '#8dc63f',
    				),
    				array(
    					'name'  => __( 'Secondary', 'flitch_wp5' ),
    					'slug'  => 'secondary',
    					'color' => '#333333',
    				),
    				array(
    					'name'  => __( 'Dark Gray', 'flitch_wp5' ),
    					'slug'  => 'dark-gray',
    					'color' => '#111',
    				),
    				array(
    					'name'  => __( 'Light Gray', 'flitch_wp5' ),
    					'slug'  => 'light-gray',
    					'color' => '#767676',
    				),
    				array(
    					'name'  => __( 'White', 'flitch_wp5' ),
    					'slug'  => 'white',
    					'color' => '#FFF',
    				),
    			)
    		);
        }// themeSetup

    }
}