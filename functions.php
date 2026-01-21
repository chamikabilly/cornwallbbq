<?php

/**
 * Miheli Solutions functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Miheli_Solutions
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function miheli_solutions_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Miheli Solutions, use a find and replace
	 * to change 'miheli-solutions' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('miheli-solutions', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary Menu', 'miheli-solutions'),
			'menu-2' => esc_html__('Quick Links Menu', 'miheli-solutions'),
			'menu-3' => esc_html__('My Account Menu', 'miheli-solutions'),
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
			'miheli_solutions_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'miheli_solutions_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function miheli_solutions_content_width()
{
	$GLOBALS['content_width'] = apply_filters('miheli_solutions_content_width', 640);
}
add_action('after_setup_theme', 'miheli_solutions_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function miheli_solutions_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'miheli-solutions'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'miheli-solutions'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'miheli_solutions_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function miheli_solutions_scripts()
{

	// Styles
	wp_enqueue_style('miheli-solutions-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('miheli-solutions-style', 'rtl', 'replace');

	wp_enqueue_style('miheli-main-style', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0');

	wp_enqueue_style(
		'meheli-bootstrap-5-css',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css',
		array(),
		'5.0.2'
	);

	wp_enqueue_style(
		'meheli-fontawesome-6',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
		array(),
		'6.5.0'
	);

	wp_enqueue_style(
		'meheli-swiper-css',
		'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css',
		array(),
		'12.0.0'
	);

	// Use file modification time as version for cache-busting during development.
	$contact_css_path = get_template_directory() . '/assets/css/templates/contact.css';
	wp_enqueue_style(
		'contact',
		get_template_directory_uri() . '/assets/css/templates/contact.css',
		array(),
		file_exists( $contact_css_path ) ? filemtime( $contact_css_path ) : _S_VERSION
	);

	$contact_form_con_path = get_template_directory() . '/assets/css/contact-form-con.css';
	wp_enqueue_style(
		'contact-form-con',
		get_template_directory_uri() . '/assets/css/contact-form-con.css',
		array(),
		file_exists( $contact_form_con_path ) ? filemtime( $contact_form_con_path ) : _S_VERSION
	);
	



	// Scripts - Load jQuery first, then Bootstrap, then your scripts
	wp_enqueue_script('jquery'); // Make sure jQuery is loaded

	wp_enqueue_script(
		'meheli-bootstrap-5-js',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js',
		array('jquery'),
		'5.0.2',
		true
	);

	wp_enqueue_script(
		'meheli-swiper-js',
		'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js',
		array('jquery'),
		'12.0.0',
		true
	);

	wp_enqueue_script(
		'miheli-solutions-navigation',
		get_template_directory_uri() . '/assets/js/navigation.js',
		array('meheli-swiper-js'), // Add jQuery as dependency
		_S_VERSION,
		true
	);

	wp_enqueue_script(
		'miheli-solutions-swiper',
		get_template_directory_uri() . '/assets/js/swiper.js',
		array('jquery'), // Add jQuery as dependency
		_S_VERSION,
		true
	);



	wp_enqueue_script(
		'miheli-cart-drawer-js',
		get_template_directory_uri() . '/assets/js/miheli-cart-drawer.js',
		array('jquery'),
		'1.0',
		true
	);

	// localize drawer data
	$miheli_cart_data = array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('miheli_cart_nonce'),
	);
	wp_localize_script('miheli-cart-drawer-js', 'miheliCartData', $miheli_cart_data);


	wp_enqueue_script(
		'miheli-solutions-product-container',
		get_template_directory_uri() . '/assets/js/product-container.js',
		array('jquery'), // Add jQuery as dependency
		_S_VERSION,
		true
	);

	// localize product data
	$admin_url_data = array(
		'admin_url' => admin_url(),
		'ajax_url' => admin_url('admin-ajax.php'), // If you need the AJAX URL
		'nonce' => wp_create_nonce('products_nonce')
	);
	wp_localize_script('miheli-solutions-product-container', 'wpAdminData', $admin_url_data);


	wp_enqueue_script(
		'miheli-solutions-variant',
		get_template_directory_uri() . '/assets/js/variant.js',
		array('jquery'), // Add jQuery as dependency
		time(),
		true
	);

	// localize variants data
	wp_localize_script('miheli-solutions-variant', 'miheli_ajax', array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('miheli_variant_nonce')
	));


	wp_enqueue_script(
		'miheli-main-js',
		get_template_directory_uri() . '/assets/js/main.js',
		array('jquery', 'meheli-bootstrap-5-js'), // Depend on jQuery and Bootstrap
		_S_VERSION,
		true
	);



	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'miheli_solutions_scripts');


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
 * Loading screen.
 */
require get_template_directory() . '/inc/loading.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * AJAX requests file.
 */
require get_template_directory() . '/inc/ajax.php';

/**
 * Drawer  file.
 */
require_once get_template_directory() . '/inc/drawer.php';

/**
 * Variant php file.
 */
require_once get_template_directory() . '/inc/variant.php';



/**
 * Allow svg upload.
 */
function allow_svg_upload($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');

function inline_svg($filepath)
{
	$svg = file_get_contents($filepath);
	$svg = wp_kses($svg, [
		'svg' => ['xmlns' => [], 'viewBox' => [], 'width' => [], 'height' => [], 'fill' => [], 'stroke' => []],
		'path' => ['d' => [], 'fill' => [], 'stroke' => []],
		'g' => ['fill' => [], 'stroke' => []],
	]);
	return $svg;
}
// custom breadcrumbs
function custom_breadcrumbs()
{
	// Home link
	echo '<div class="breadcrumbs">';
	echo '<a href="' . home_url() . '">Home</a>';

	// If it's a page and not the homepage
	if (is_page() && !is_front_page()) {
		echo ' <span class="separator"><i class="fa-solid fa-chevron-right"></i></span> ';

		// Get parent pages
		$ancestors = get_post_ancestors(get_the_ID());
		if ($ancestors) {
			$ancestors = array_reverse($ancestors);
			foreach ($ancestors as $ancestor) {
				echo '<a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a> <span class="separator"><i class="fa-solid fa-chevron-right"></i></span> ';
			}
		}

		// Current page
		echo '<span class="current">' . get_the_title() . '</span>';
	}

	echo '</div>';
}