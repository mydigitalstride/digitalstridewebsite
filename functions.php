<?php
// Theme Support
function digitalstride_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary' => __('Primary Menu', 'digitalstride'),
    ]);
}
add_action('after_setup_theme', 'digitalstride_setup');

// Enqueue styles/scripts
function digitalstride_enqueue_assets() {
    // Main styles
    wp_enqueue_style('digitalstride-style', get_stylesheet_uri());
    wp_enqueue_style('digitalstride-template-style', get_template_directory_uri() . '/styles/template.css');
    wp_enqueue_style('digitalstride-header-style', get_template_directory_uri() . '/styles/header.css');


    // Main JS
    wp_enqueue_script('digitalstride-script', get_template_directory_uri() . '/js/main.js', [], '1.0.0', true);

    // Page-specific CSS
    if (is_front_page()) {
        wp_enqueue_style('front-page-css', get_template_directory_uri() . '/styles/front-page.css');
    }

    if (is_page('about-us-2')) {
        wp_enqueue_style('about-us-css', get_template_directory_uri() . '/styles/about-us.css');
    }

    // ACF flexible content layout: Services CSS
    if (is_page()) {
        $sections = get_field('services_sections');
        if ($sections && is_array($sections)) {
            foreach ($sections as $section) {
                if (in_array($section['acf_fc_layout'], [
                    'wordpress_services_section',
                    'custom_website_development',
                    'growth_section',
                    'bubbles_section',
                    'package',
                    'timeline_scope',
                    'plus_banner',
                    'concept'
                ])) {
                    wp_enqueue_style('services-css', get_template_directory_uri() . '/styles/services.css');
                    break;
                }
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'digitalstride_enqueue_assets');

// ACF Options Pages
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Global Elements',
        'menu_title' => 'Global Elements',
        'menu_slug'  => 'global-elements',
        'capability' => 'edit_posts',
        'redirect'   => false
    ]);

    acf_add_options_page([
        'page_title' => 'Site Settings',
        'menu_title' => 'Site Settings',
        'menu_slug'  => 'site-settings',
        'capability' => 'edit_posts',
        'redirect'   => false
    ]);
}

// ACF Fallback Helper
function digitalstride_get_option($option) {
    return function_exists('get_field') ? get_field($option, 'option') : get_theme_mod($option);
}

// Register CPT: Services
function digitalstride_services_post_type() {
    register_post_type('services', [
        'labels' => [
            'name'          => __('Services', 'digitalstride'),
            'singular_name' => __('Service', 'digitalstride'),
        ],
        'public'      => true,
        'has_archive' => true,
        'supports'    => ['title', 'editor', 'thumbnail'],
        'menu_icon'   => 'dashicons-admin-tools',
    ]);
}
add_action('init', 'digitalstride_services_post_type');

// Theme Customizer
function digitalstride_customize_register($wp_customize) {
    $wp_customize->add_section('digitalstride_header', [
        'title'    => __('Header Settings', 'digitalstride'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('header_logo');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_logo', [
        'label'    => __('Upload Header Logo', 'digitalstride'),
        'section'  => 'digitalstride_header',
        'settings' => 'header_logo',
    ]));

    $wp_customize->add_setting('header_cta_text', ['default' => 'Contact Us']);
    $wp_customize->add_control('header_cta_text', [
        'label'   => __('CTA Button Text', 'digitalstride'),
        'section' => 'digitalstride_header',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('header_cta_link', ['default' => '#contact']);
    $wp_customize->add_control('header_cta_link', [
        'label'   => __('CTA Button Link', 'digitalstride'),
        'section' => 'digitalstride_header',
        'type'    => 'text',
    ]);
}
add_action('customize_register', 'digitalstride_customize_register');

// Adjust excerpt length
add_filter('excerpt_length', function() {
    return 25;
});

// Admin notice if ACF is missing
function digitalstride_required_plugins_notice() {
    if (!function_exists('get_field')) {
        echo '<div class="error"><p>';
        _e('Advanced Custom Fields PRO is required for this theme to work properly.', 'digitalstride');
        echo '</p></div>';
    }
}
add_action('admin_notices', 'digitalstride_required_plugins_notice');
function digitalstride_enqueue_fonts() {
	wp_enqueue_style(
		'digitalstride-google-fonts',
		'https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap',
		false
	);
}
add_action('wp_enqueue_scripts', 'digitalstride_enqueue_fonts');
add_filter( 'megamenu_load_css', '__return_false' );
add_filter( 'megamenu_load_js', '__return_false' );

function my_theme_enqueue_scripts() {
  // Enqueue your mobile menu toggle script
  wp_enqueue_script(
    'mobile-menu-toggle',
    get_template_directory_uri() . '/js/menu-toggle.js',
    array(), // No dependencies
    null, // No version number
    true // Load in footer
  );
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

function enqueue_custom_accordion_script() {
    wp_enqueue_script(
        'custom-accordion', // A unique handle for your script
        get_template_directory_uri() . '/js/accordion.js', // The file path
        array(), // Dependencies (optional)
        '1.0.0', // Version number
        true // Load in the footer
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_accordion_script');
/**
 * Enqueue custom scripts and styles.
 */
function enqueue_custom_assets() {
    wp_enqueue_script( 
        'floating-sidebar', 
        get_template_directory_uri() . '/js/floating-sidebar.js',
        array(),
        null,
        true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_assets' );

?>
