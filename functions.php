<?php
/**
 * Wordify functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Wordify
 */

if ( ! function_exists( 'wordify_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wordify_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Wordify, use a find and replace
	 * to change 'wordify' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'wordify', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'wordify' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wordify_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'wordify_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wordify_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wordify_content_width', 640 );
}
add_action( 'after_setup_theme', 'wordify_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wordify_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wordify' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wordify' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wordify_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wordify_scripts() {
	wp_enqueue_style( 'wordify-style', get_stylesheet_uri() );

	wp_enqueue_style( 'wordify-main_style', get_template_directory_uri().'/assets/css/main.min.css', array(), '1.0.0', 'all' );

	wp_enqueue_script( 'wordify-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'wordify-bundle', get_template_directory_uri() . '/assets/js/bundle.js', array(), '20151215', true );

	wp_enqueue_script( 'wordify-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script('theme-script', get_template_directory_uri() . '/assets/js/bundle.js',array(),'1.0.0', 'all');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wordify_scripts' );


////////////////////////////////////////////////////////////////////
// Add support for Advcanced Customs Field Options Page
////////////////////////////////////////////////////////////////////
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Wordify General Settings',
        'menu_title'    => 'Wordify Settings',
        'menu_slug'     => 'wordify-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

}


////////////////////////////////////////////////////////////////////
// Thumbnail size
////////////////////////////////////////////////////////////////////
    add_action( 'after_setup_theme', 'thumb_setup' );
    function thumb_setup() {
        add_image_size( 'sample-thumb', 50, 50, true );
    }

////////////////////////////////////////////////////////////////////
// Add option for custom post type
////////////////////////////////////////////////////////////////////
    function custom_post_gallery() {
      $labels = array(
        'name'               => _x( 'Gallery', 'wordify gallery' ),
        'singular_name'      => _x( 'Gallery', 'wordify gallery' ),
        'add_new'            => _x( 'Add New', 'gallery' ),
        'add_new_item'       => __( 'Add New Item' ),
        'edit_item'          => __( 'Edit Item' ),
        'new_item'           => __( 'New Item' ),
        'all_items'          => __( 'All Items' ),
        'view_item'          => __( 'View Item' ),
        'search_items'       => __( 'Search Items' ),
        'not_found'          => __( 'No item found' ),
        'not_found_in_trash' => __( 'No items found in the Trash' ),
        'parent_item_colon'  => '',
        'menu_name'          => 'Gallery'
      );
      $args = array(
        'labels'        => $labels,
        'description'   => 'Holds our gallery specific data',
        'public'        => true,
        'menu_position' => 2,
        'menu_icon'     => 'dashicons-palmtree',
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'has_archive'   => true,
        'rewrite' => array( 'slug' => 'gallery'),
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true
      );
      register_post_type( 'gallery', $args );
    }
    //uncomment to add custom post type galler
    // add_action( 'init', 'custom_post_gallery' ); 

////////////////////////////////////////////////////////////////////
// Add OpenGraph Meta Info to header
////////////////////////////////////////////////////////////////////
function add_opengraph_doctype( $output ) {
        return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
    }
add_filter('language_attributes', 'add_opengraph_doctype');

//Lets add Open Graph Meta Info

function insert_fb_in_head() {
    global $post;
    if ( !is_singular()) //if it is not a post or a page
        return;
        echo '<meta property="og:title" content="' . get_the_title() . ' | mokpo - creative cakes"/>';
        echo '<meta property="og:description" content="'. get_the_excerpt() .'"/>';
        echo '<meta property="og:type" content="article"/>';
        echo '<meta property="og:url" content="' . get_permalink() . '"/>';
        echo '<meta property="og:site_name" content="mokpo - creative cakes"/>';
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'facebook-thumb' );
        echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );

 
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
