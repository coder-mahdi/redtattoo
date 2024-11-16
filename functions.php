<?php
/**
 * redtattoo theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package redtattoo_theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function redtattoo_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on redtattoo theme, use a find and replace
		* to change 'redtattoo-theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'redtattoo-theme', get_template_directory() . '/languages' );

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
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'redtattoo-theme' ),
		)
	);

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
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'redtattoo_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'redtattoo_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function redtattoo_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'redtattoo_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'redtattoo_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function redtattoo_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'redtattoo-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'redtattoo-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'redtattoo_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function redtattoo_theme_scripts() {
	wp_enqueue_style( 'redtattoo-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'redtattoo-theme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'redtattoo-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'redtattoo_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



// Register Custom Post Type for Team Members
function readtattoo_team_cpt() {

    $labels = array(
        'name'                  => _x( 'Teams', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Team', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Teams', 'text_domain' ),
        'name_admin_bar'        => __( 'Team', 'text_domain' ),
        'archives'              => __( 'Team Archives', 'text_domain' ),
        'attributes'            => __( 'Team Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Team:', 'text_domain' ),
        'all_items'             => __( 'All Teams', 'text_domain' ),
        'add_new_item'          => __( 'Add New Team Member', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New Team Member', 'text_domain' ),
        'edit_item'             => __( 'Edit Team Member', 'text_domain' ),
        'update_item'           => __( 'Update Team Member', 'text_domain' ),
        'view_item'             => __( 'View Team Member', 'text_domain' ),
        'view_items'            => __( 'View Teams', 'text_domain' ),
        'search_items'          => __( 'Search Team', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into team member', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this team member', 'text_domain' ),
        'items_list'            => __( 'Teams list', 'text_domain' ),
        'items_list_navigation' => __( 'Teams list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter teams list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Team', 'text_domain' ),
        'description'           => __( 'Team members for Redtattoo theme', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'rewrite'               => array( 'slug' => 'teams' ),
    );
    register_post_type( 'readtattoo-team', $args );

}
add_action( 'init', 'readtattoo_team_cpt', 0 );