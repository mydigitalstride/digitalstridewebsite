<?php
/* =============================================================
   SITEGROUND HOSTING — HTTPS REVERSE-PROXY FIX
   SiteGround routes HTTPS traffic through a load balancer that
   strips the HTTPS flag before it reaches PHP.  WordPress reads
   $_SERVER['HTTPS'] via is_ssl() to decide whether to generate
   HTTPS login/admin URLs and whether to enforce SSL for admin.
   When is_ssl() incorrectly returns false the WordPress Manager
   auto-login in SiteGround's control panel fails because
   WordPress either produces HTTP redirect URLs or creates a
   redirect loop.

   The actual protocol is always forwarded in the standard
   HTTP_X_FORWARDED_PROTO header.  Setting $_SERVER['HTTPS']
   from that header here (functions.php is loaded by wp-login.php
   via wp-load.php → wp-settings.php, before the SSL-redirect
   checks run) makes is_ssl() reliable on SiteGround hosting.
   ============================================================= */
if (
    isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) &&
    'https' === strtolower( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) &&
    ( empty( $_SERVER['HTTPS'] ) || 'off' === strtolower( $_SERVER['HTTPS'] ) )
) {
    $_SERVER['HTTPS'] = 'on';
}

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

    // Events CSS + JS
    if (is_post_type_archive('ds_event') || is_singular('ds_event') || is_page('events') || digitalstride_page_has_events_section()) {
        wp_enqueue_style('events-css', get_template_directory_uri() . '/styles/events.css', [], '1.2.0');
        wp_enqueue_script('events-js', get_template_directory_uri() . '/js/events.js', [], '1.2.0', true);
    }

    // March Madness Bracket CSS + JS
    if (is_page_template('page-march-madness.php')) {
        // Resolve logo URL from ACF options (falls back to empty string gracefully)
        $mm_logo_url = '';
        if (function_exists('get_field')) {
            $mm_logo_id  = get_field('header_logo', 'option');
            $mm_logo_url = $mm_logo_id ? (string) wp_get_attachment_image_url($mm_logo_id, 'medium') : '';
        }

        wp_enqueue_style('march-madness-css', get_template_directory_uri() . '/styles/march-madness.css', [], '1.0.7');

        // jsPDF (CDN) must load before march-madness-js
        wp_enqueue_script(
            'jspdf',
            'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js',
            [],
            '2.5.1',
            true
        );
        wp_enqueue_script('march-madness-js', get_template_directory_uri() . '/js/march-madness.js', ['jspdf'], '1.0.1', true);
        wp_localize_script('march-madness-js', 'mmBracket', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('mm_bracket_nonce'),
            'logoUrl' => esc_url($mm_logo_url),
            'siteUrl' => esc_url(get_bloginfo('url')),
        ]);
    }

    // Google Review landing page CSS + JS data
    if (is_page_template('page-google-review.php')) {
        wp_enqueue_style('google-review-css', get_template_directory_uri() . '/styles/google-review.css', [], filemtime(get_template_directory() . '/styles/google-review.css'));
        // Inline script to expose ajaxUrl + nonce to the page's inline JS
        wp_add_inline_script(
            'jquery-core',
            'var grData = ' . wp_json_encode([
                'ajaxUrl'       => admin_url('admin-ajax.php'),
                'nonce'         => wp_create_nonce('gr_referral_nonce'),
                'feedbackNonce' => wp_create_nonce('gr_feedback_nonce'),
            ]) . ';'
        );
    }

    // Educational Review landing page CSS + JS data
    if (is_page_template('page-educational-review.php')) {
        wp_enqueue_style('educational-review-css', get_template_directory_uri() . '/styles/educational-review.css', [], filemtime(get_template_directory() . '/styles/educational-review.css'));
        wp_add_inline_script(
            'jquery-core',
            'var erData = ' . wp_json_encode([
                'ajaxUrl'       => admin_url('admin-ajax.php'),
                'feedbackNonce' => wp_create_nonce('er_feedback_nonce'),
            ]) . ';'
        );
    }

    // Referral Landing page CSS + JS data
    if (is_page_template('page-referral-landing.php')) {
        wp_enqueue_style('referral-landing-css', get_template_directory_uri() . '/styles/referral-landing.css', [], '1.0.0');
        wp_add_inline_script(
            'jquery-core',
            'var rlData = ' . wp_json_encode([
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('rl_referral_nonce'),
            ]) . ';'
        );
    }

    // Quote Questionnaire page CSS + JS
    if (is_page_template('page-questionnaire.php')) {
        wp_enqueue_style('questionnaire-css', get_template_directory_uri() . '/styles/questionnaire.css', [], '1.1.0');
        // jsPDF for client-side PDF generation (loaded before questionnaire.js)
        wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', [], '2.5.1', true);
        wp_enqueue_script('questionnaire-js', get_template_directory_uri() . '/js/questionnaire.js', ['jspdf'], '1.1.0', true);
        $qb_logo_url = '';
        if (function_exists('get_field')) {
            $qb_logo_id  = get_field('header_logo', 'option');
            $qb_logo_url = $qb_logo_id ? (string) wp_get_attachment_image_url($qb_logo_id, 'full') : '';
        }
        wp_localize_script('questionnaire-js', 'qbData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('qb_quote_nonce'),
            'logoUrl' => esc_url($qb_logo_url),
        ]);
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

// Helper: detect if the current page uses the events section template part
function digitalstride_page_has_events_section() {
    if (!is_page()) return false;
    $sections = get_field('services_sections');
    if (!$sections || !is_array($sections)) return false;
    foreach ($sections as $section) {
        if (!empty($section['acf_fc_layout']) && $section['acf_fc_layout'] === 'events_section') {
            return true;
        }
    }
    return false;
}

// ACF Fallback Helper
function digitalstride_get_option($option) {
    return function_exists('get_field') ? get_field($option, 'option') : get_theme_mod($option);
}

// Register Event Details ACF fields programmatically so they always appear on
// the ds_event edit screen regardless of ACF JSON sync state or file upload.
add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) return;
    acf_add_local_field_group([
        'key'    => 'group_ds_events_fields',
        'title'  => 'Event Details',
        'fields' => [
            [
                'key'          => 'field_ds_evt_description',
                'label'        => 'Description',
                'name'         => 'event_description',
                'type'         => 'wysiwyg',
                'required'     => 0,
                'tabs'         => 'all',
                'toolbar'      => 'full',
                'media_upload' => 0,
            ],
            [
                'key'            => 'field_ds_evt_date',
                'label'          => 'Event Date',
                'name'           => 'event_date',
                'type'           => 'date_picker',
                'required'       => 1,
                'display_format' => 'F j, Y',
                'return_format'  => 'Ymd',
                'first_day'      => 0,
            ],
            [
                'key'          => 'field_ds_evt_time',
                'label'        => 'Event Time',
                'name'         => 'event_time',
                'type'         => 'text',
                'required'     => 0,
                'instructions' => 'Optional. E.g. 10:00 AM – 2:00 PM',
                'placeholder'  => '10:00 AM – 2:00 PM',
            ],
            [
                'key'           => 'field_ds_evt_loc_type',
                'label'         => 'Location Type',
                'name'          => 'location_type',
                'type'          => 'radio',
                'required'      => 1,
                'choices'       => ['in_person' => 'In-Person', 'virtual' => 'Virtual'],
                'default_value' => 'in_person',
                'layout'        => 'horizontal',
                'return_format' => 'value',
            ],
            [
                'key'               => 'field_ds_evt_location',
                'label'             => 'Address',
                'name'              => 'event_location',
                'type'              => 'text',
                'required'          => 0,
                'instructions'      => 'Full address for Google Maps directions, e.g. Digital Stride 410 Kings Mill Rd, York, PA 17401',
                'conditional_logic' => [[
                    ['field' => 'field_ds_evt_loc_type', 'operator' => '==', 'value' => 'in_person'],
                ]],
            ],
            [
                'key'               => 'field_ds_evt_virtual_link',
                'label'             => 'Virtual Meeting Link',
                'name'              => 'event_virtual_link',
                'type'              => 'url',
                'required'          => 0,
                'instructions'      => 'Zoom, Teams, Google Meet, or other video call URL.',
                'conditional_logic' => [[
                    ['field' => 'field_ds_evt_loc_type', 'operator' => '==', 'value' => 'virtual'],
                ]],
            ],
            [
                'key'          => 'field_ds_evt_reg_link',
                'label'        => 'Registration Link',
                'name'         => 'event_registration_link',
                'type'         => 'url',
                'required'     => 0,
                'instructions' => 'Optional.',
            ],
            [
                'key'           => 'field_ds_evt_photo',
                'label'         => 'Event Photo',
                'name'          => 'event_photo',
                'type'          => 'image',
                'required'      => 0,
                'instructions'  => 'Optional. Recommended 2:1 ratio (e.g. 1200×600px).',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ],
        ],
        'location' => [[
            ['param' => 'post_type', 'operator' => '==', 'value' => 'ds_event'],
        ]],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ]);
});

// Register CPT: Events
function digitalstride_events_post_type() {
    register_post_type('ds_event', [
        'labels' => [
            'name'               => __('Events', 'digitalstride'),
            'singular_name'      => __('Event', 'digitalstride'),
            'add_new'            => __('Add New', 'digitalstride'),
            'add_new_item'       => __('Add New Event', 'digitalstride'),
            'edit_item'          => __('Edit Event', 'digitalstride'),
            'view_item'          => __('View Event', 'digitalstride'),
            'search_items'       => __('Search Events', 'digitalstride'),
            'not_found'          => __('No events found.', 'digitalstride'),
            'menu_name'          => __('Events', 'digitalstride'),
        ],
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'publicly_queryable' => true,
        'has_archive'        => true,
        'supports'           => ['title', 'thumbnail'],
        'menu_icon'          => 'dashicons-calendar-alt',
        'menu_position'      => 25,
        'capability_type'    => 'post',
        'rewrite'            => ['slug' => 'ds-events', 'with_front' => false],
    ]);
}
add_action('init', 'digitalstride_events_post_type');

// Flush rewrite rules once after CPT is added (stores a flag in the DB).
// Increment the version suffix (e.g. _v2, _v3) to force a re-flush after changes.
add_action('admin_init', function () {
    if (get_option('ds_events_flushed_v3') !== '1') {
        flush_rewrite_rules();
        update_option('ds_events_flushed_v3', '1');
    }
});

// Flush rewrite rules when the theme is switched
add_action('after_switch_theme', function () {
    digitalstride_events_post_type();
    ds_create_rl_referral_table();
    flush_rewrite_rules();
});

// Create the referral submissions table if it doesn't exist yet
function ds_create_rl_referral_table() {
    global $wpdb;
    $table   = $wpdb->prefix . 'rl_referral_submissions';
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS {$table} (
        id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        submitter_name  VARCHAR(255)    NOT NULL DEFAULT '',
        submitter_email VARCHAR(255)    NOT NULL DEFAULT '',
        referrals_json  LONGTEXT        NOT NULL,
        referral_count  TINYINT UNSIGNED NOT NULL DEFAULT 0,
        submitted_at    DATETIME        NOT NULL,
        PRIMARY KEY (id)
    ) {$charset};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}
add_action( 'init', function () {
    if ( ! get_option( 'ds_rl_referral_table_v1' ) ) {
        ds_create_rl_referral_table();
        update_option( 'ds_rl_referral_table_v1', true );
    }
} );

// Force the events page template regardless of the Page Attributes selection in WP Admin.
// This ensures page-events.php always loads for the page with slug "events".
add_filter('template_include', function ($template) {
    if (is_page('events')) {
        $events_tpl = get_template_directory() . '/page-events.php';
        if (file_exists($events_tpl)) {
            return $events_tpl;
        }
    }
    return $template;
});

// Admin sidebar: remove Services CPT regardless of what registered it (theme or plugin),
// and ensure Events CPT appears.
add_action('admin_menu', function () {
    remove_menu_page('edit.php?post_type=services');
}, 999);

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

// Fix canonical tags: always self-reference the current page's own URL
function digitalstride_self_canonical() {
    $canonical_url = '';

    if ( is_singular() ) {
        $canonical_url = get_permalink();
    } elseif ( is_front_page() ) {
        $canonical_url = home_url( '/' );
    } elseif ( is_home() ) {
        $page_for_posts = get_option( 'page_for_posts' );
        $canonical_url  = $page_for_posts ? get_permalink( $page_for_posts ) : home_url( '/' );
    } elseif ( is_category() || is_tag() || is_tax() ) {
        $term = get_queried_object();
        if ( $term && ! is_wp_error( $term ) ) {
            $canonical_url = get_term_link( $term );
        }
    } elseif ( is_post_type_archive() ) {
        $canonical_url = get_post_type_archive_link( get_post_type() );
    } elseif ( is_author() ) {
        $canonical_url = get_author_posts_url( get_queried_object_id() );
    } elseif ( is_search() ) {
        $canonical_url = get_search_link();
    }

    if ( $canonical_url && ! is_wp_error( $canonical_url ) ) {
        echo '<link rel="canonical" href="' . esc_url( $canonical_url ) . '">' . "\n";
    }
}
// Replace WordPress default canonical with our self-referencing one
remove_action( 'wp_head', 'rel_canonical' );
add_action( 'wp_head', 'digitalstride_self_canonical' );

// Suppress Yoast SEO canonical — we manage canonical centrally above.
add_filter( 'wpseo_canonical', '__return_false' );

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
// functions.php
function ds_enqueue_fontawesome() {
  wp_enqueue_style(
    'font-awesome',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
    [],
    '6.5.1'
  );
}
add_action('wp_enqueue_scripts', 'ds_enqueue_fontawesome');

// Rewrite legacy URLs to new URLs in post content.
// Ordered longest-to-shortest to prevent partial-path replacements.
function digitalstride_update_legacy_urls( $content ) {
    $url_map = [
        // Deep /services/ paths (must come before shallower ones)
        'https://mydigitalstride.com/services/create-a-digital-foundation-with-digital-marketing/analytics-services/' => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/services/create-a-digital-foundation-with-digital-marketing/website-design/'    => 'https://mydigitalstride.com/web-design/',
        'https://mydigitalstride.com/services/digital-marketing/search-engine-optimization/local-seo/'               => 'https://mydigitalstride.com/search-engine-optimization/',
        'https://mydigitalstride.com/services/digital-marketing/search-marketing/local-seo/'                         => 'https://mydigitalstride.com/search-engine-optimization/',
        'https://mydigitalstride.com/services/revenue-generation-2/search-engine-optimization/'                      => 'https://mydigitalstride.com/search-engine-optimization/',
        'https://mydigitalstride.com/services/revenue-generation-2/digital-advertising/'                             => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/services/digital-marketing/social-media-advertising/'                           => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/services/digital-marketing/google-ads/'                                         => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/services/digital-marketing/search-marketing/'                                   => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/services/digital-marketing/'                                                    => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/services/analytics-services/'                                                   => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/services/smb-consulting/'                                                       => 'https://mydigitalstride.com/web-design/',
        'https://mydigitalstride.com/services/website-design/'                                                       => 'https://mydigitalstride.com/web-design/',
        'https://mydigitalstride.com/services/search-marketing/'                                                     => 'https://mydigitalstride.com/web-design/',
        'https://mydigitalstride.com/services/consulting/'                                                           => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/services/'                                                                      => 'https://mydigitalstride.com/our-services/',
        // Other legacy URLs
        'https://mydigitalstride.com/accessibility-statement/Mydigitalstride.com'                                    => 'https://mydigitalstride.com/accessibility-statement/',
        'https://mydigitalstride.com/industries/real-estate-2/'                                                      => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/performance-or-brand-advertising/'                                              => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/marketing-persona-template-download/'                                           => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/social-media-platform-finder/'                                                  => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/revenue-generation/'                                                            => 'https://mydigitalstride.com/revenue-generation-service/',
        'https://mydigitalstride.com/website-design/'                                                                => 'https://mydigitalstride.com/web-design/',
        'https://mydigitalstride.com/digital-marketing/'                                                             => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/smb-consulting/'                                                                => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/social-marketing/'                                                              => 'https://mydigitalstride.com/digital-advertising/',
        'https://mydigitalstride.com/home-page-2/'                                                                   => 'https://mydigitalstride.com/',
    ];

    return str_replace( array_keys( $url_map ), array_values( $url_map ), $content );
}
add_filter( 'the_content', 'digitalstride_update_legacy_urls' );
add_filter( 'the_excerpt', 'digitalstride_update_legacy_urls' );

/* =============================================================
   301 REDIRECTS
   ============================================================= */

function digitalstride_301_redirects() {
    $path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

    $redirects = [
        '/digital-marketing'                           => '/digital-advertising/',
        '/digital-marketing/'                          => '/digital-advertising/',
        '/accessibility-statement/Mydigitalstride.com' => '/accessibility-statement/',
    ];

    if ( isset( $redirects[ $path ] ) ) {
        wp_redirect( home_url( $redirects[ $path ] ), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'digitalstride_301_redirects' );

/* =============================================================
   FALLBACK META DESCRIPTIONS (SEO + AEO)
   Fills in Yoast meta descriptions only when none has been set
   in the Yoast admin panel for that post/page.
   ============================================================= */

function digitalstride_fallback_metadesc( $desc ) {
    if ( ! empty( $desc ) ) {
        return $desc;
    }

    $descriptions = [
        // Blog posts (/marketing/ category)
        'whats-the-best-way-to-pick-seo-keywords-for-my-business'
            => 'Learn how to pick the best SEO keywords for your business. Our guide covers keyword research, search intent, and tools to help you rank higher on Google.',
        'why-small-businesses-in-york-pa-need-professional-website-design'
            => 'York, PA small businesses need a professional website to attract local customers. Learn why expert web design is essential for competing and growing online.',
        'gamification-tactics-to-try-and-avoid'
            => 'Learn which gamification tactics boost customer engagement and which to avoid. Explore proven marketing strategies that reward loyalty and drive conversions.',
        'assisted-living-marketing-ideas-2'
            => 'Discover more assisted living marketing ideas to attract residents and families. Proven digital strategies to grow your senior care community\'s online presence.',
        'assisted-living-marketing-ideas'
            => 'Discover top assisted living marketing ideas to attract families and fill vacancies. Learn proven digital strategies tailored for senior care communities.',
        'last-minute-holiday-promotion-tips-for-small-businesses'
            => 'Running out of time? These last-minute holiday promotion tips help small businesses drive seasonal sales fast with quick, effective marketing ideas.',
        'make-your-website-work-smarter-not-harder-a-guide-for-digital-marketers'
            => 'Make your website work smarter with this guide for digital marketers. Learn optimization tips that generate leads and conversions without the extra effort.',
        'why-mobile-friendly-website-design-matters-in-2025'
            => 'Find out why mobile-friendly website design matters in 2025. Responsive design boosts SEO, improves user experience, and converts more mobile visitors.',
        'how-load-times-impact-website-usability'
            => 'Slow load times hurt your website\'s usability and rankings. Learn how page speed affects bounce rates and conversions—and how to fix it for better results.',
        'how-website-optimization-can-boost-your-online-sales'
            => 'Website optimization can significantly boost your online sales. Discover how speed, UX, and SEO improvements turn more visitors into paying customers.',
        'transform-your-online-presence-with-digital-strides-website-design-services'
            => 'Transform your online presence with Digital Stride\'s website design services. Expert web design in York, PA that drives traffic, leads, and real conversions.',
        'how-do-i-find-the-best-website-designer-near-me'
            => 'Find the best website designer near you with our expert tips. Learn what to look for, what questions to ask, and how to choose the right design partner.',
        'what-makes-a-great-e-commerce-website-design-in-2026'
            => 'What makes a great e-commerce website design in 2026? Explore key features, UX best practices, and design trends that drive online sales and customer trust.',
        'what-to-look-for-in-a-web-design-company-near-you'
            => 'Looking for a web design company near you? Learn what to look for, key questions to ask, and how to choose the right partner to build your perfect website.',
        'how-can-i-dominate-local-seo-and-rank-higher-on-google'
            => 'Learn how to dominate local SEO and rank higher on Google. Discover proven strategies to appear in local searches, attract nearby customers, and grow fast.',
        'do-i-need-a-google-my-business-profile-for-local-seo'
            => 'Yes—a Google Business Profile is essential for local SEO. Learn why optimizing your listing helps you rank higher on Google and attract more local customers.',
        // Guide posts (/guides/ category)
        'when-is-it-time-to-redesign-your-website'
            => 'Not sure if it\'s time to redesign your website? Discover the key signs your site is hurting your business—and what a modern redesign can do for growth.',
        // Pages
        'https-staging8-mydigitalstride-com-home-page'
            => 'Digital Stride helps businesses grow online through expert web design, SEO, and digital marketing services based in York, PA.',
        'lunch-learn-feedback-quiz'
            => 'Share your feedback from our Lunch & Learn event. Complete this quick quiz to help Digital Stride improve future sessions and better serve our community.',
    ];

    $obj = get_queried_object();

    // Singular posts and pages — match by slug
    if ( $obj && ! empty( $obj->post_name ) && isset( $descriptions[ $obj->post_name ] ) ) {
        return $descriptions[ $obj->post_name ];
    }

    // Events archive (/events/)
    if ( is_post_type_archive( 'ds_event' ) || ( is_page() && $obj && $obj->post_name === 'events' ) ) {
        return 'Browse upcoming events hosted by Digital Stride. From lunch-and-learns to marketing workshops, find events to grow your business in York, PA.';
    }

    return $desc;
}
add_filter( 'wpseo_metadesc', 'digitalstride_fallback_metadesc' );

/* =============================================================
   MARCH MADNESS — BRACKET ENTRY CPT
   ============================================================= */

function ds_register_bracket_entry_cpt() {
    register_post_type( 'ds_bracket_entry', [
        'labels' => [
            'name'               => __( 'Bracket Entries', 'digitalstride' ),
            'singular_name'      => __( 'Bracket Entry', 'digitalstride' ),
            'add_new'            => __( 'Add New', 'digitalstride' ),
            'add_new_item'       => __( 'Add New Entry', 'digitalstride' ),
            'edit_item'          => __( 'Edit Entry', 'digitalstride' ),
            'view_item'          => __( 'View Entry', 'digitalstride' ),
            'search_items'       => __( 'Search Entries', 'digitalstride' ),
            'not_found'          => __( 'No entries found.', 'digitalstride' ),
            'menu_name'          => __( 'Bracket Entries', 'digitalstride' ),
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'publicly_queryable' => false,
        'has_archive'        => false,
        'supports'           => [ 'title', 'custom-fields' ],
        'menu_icon'          => 'dashicons-awards',
        'menu_position'      => 26,
        'capability_type'    => 'post',
        'map_meta_cap'       => true,
    ] );
}
add_action( 'init', 'ds_register_bracket_entry_cpt' );

/* =============================================================
   MARCH MADNESS — AJAX: SUBMIT BRACKET
   ============================================================= */

function ds_handle_mm_bracket_submission() {
    // Verify nonce
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'mm_bracket_nonce' ) ) {
        wp_send_json_error( 'Security check failed. Please refresh the page and try again.' );
    }

    // Collect & sanitize fields
    $name          = isset( $_POST['name'] )         ? sanitize_text_field( wp_unslash( $_POST['name'] ) )         : '';
    $email         = isset( $_POST['email'] )        ? sanitize_email( wp_unslash( $_POST['email'] ) )             : '';
    $company       = isset( $_POST['company'] )      ? sanitize_text_field( wp_unslash( $_POST['company'] ) )      : '';
    $phone         = isset( $_POST['phone'] )        ? sanitize_text_field( wp_unslash( $_POST['phone'] ) )        : '';
    $favorite_team = isset( $_POST['favoriteTeam'] ) ? sanitize_text_field( wp_unslash( $_POST['favoriteTeam'] ) ) : '';
    $picks_raw     = isset( $_POST['picks'] )        ? wp_unslash( $_POST['picks'] )                               : '{}';

    // Basic validation
    if ( empty( $name ) || empty( $email ) || ! is_email( $email ) || empty( $company ) || empty( $favorite_team ) ) {
        wp_send_json_error( 'Please fill in all required fields.' );
    }

    // Decode and sanitize picks JSON
    $picks_arr = json_decode( $picks_raw, true );
    if ( ! is_array( $picks_arr ) ) {
        wp_send_json_error( 'Invalid bracket data. Please try again.' );
    }
    $picks_clean = [];
    foreach ( $picks_arr as $game_id => $team ) {
        $picks_clean[ sanitize_key( $game_id ) ] = sanitize_text_field( $team );
    }

    // Check for duplicate submission (same email)
    $existing = get_posts( [
        'post_type'      => 'ds_bracket_entry',
        'post_status'    => 'publish',
        'meta_key'       => '_mm_email',
        'meta_value'     => $email,
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ] );
    if ( ! empty( $existing ) ) {
        wp_send_json_error( 'A bracket has already been submitted for this email address.' );
    }

    // Save as CPT post
    $post_id = wp_insert_post( [
        'post_title'  => sanitize_text_field( $name ) . ' — ' . gmdate( 'M j, Y g:i A' ),
        'post_type'   => 'ds_bracket_entry',
        'post_status' => 'publish',
    ] );

    if ( is_wp_error( $post_id ) ) {
        wp_send_json_error( 'Could not save your bracket. Please try again.' );
    }

    update_post_meta( $post_id, '_mm_name',          $name );
    update_post_meta( $post_id, '_mm_email',         $email );
    update_post_meta( $post_id, '_mm_company',       $company );
    update_post_meta( $post_id, '_mm_phone',         $phone );
    update_post_meta( $post_id, '_mm_favorite_team', $favorite_team );
    update_post_meta( $post_id, '_mm_picks',         wp_json_encode( $picks_clean ) );
    update_post_meta( $post_id, '_mm_submitted_at',  gmdate( 'Y-m-d H:i:s' ) );

    // Email admin
    $admin_email   = get_option( 'admin_email' );
    $picks_display = '';
    foreach ( $picks_clean as $game => $team ) {
        $picks_display .= '  ' . $game . ': ' . $team . "\n";
    }

    $admin_subject = 'New March Madness Bracket: ' . $name;
    $admin_message =
        "A new bracket entry was submitted.\n\n" .
        "Name:          {$name}\n" .
        "Company:       {$company}\n" .
        "Email:         {$email}\n" .
        "Phone:         " . ( $phone ?: 'Not provided' ) . "\n" .
        "Favorite Team: {$favorite_team}\n" .
        "Submitted:     " . gmdate( 'M j, Y g:i A T' ) . "\n\n" .
        "Picks:\n{$picks_display}\n\n" .
        "View in WP Admin: " . admin_url( 'post.php?post=' . $post_id . '&action=edit' );

    wp_mail( $admin_email, $admin_subject, $admin_message );

    // Confirmation email to entrant (HTML)
    $confirm_subject  = 'Your Digital Stride March Madness Bracket is In!';
    $confirm_html     = ds_mm_build_confirmation_email( $name, $email, $company, $phone, $favorite_team, $picks_clean );
    $confirm_headers  = [ 'Content-Type: text/html; charset=UTF-8' ];

    wp_mail( $email, $confirm_subject, $confirm_html, $confirm_headers );

    wp_send_json_success( 'Bracket submitted successfully.' );
}
add_action( 'wp_ajax_mm_submit_bracket',        'ds_handle_mm_bracket_submission' );
add_action( 'wp_ajax_nopriv_mm_submit_bracket', 'ds_handle_mm_bracket_submission' );

/* =============================================================
   GOOGLE REVIEW — REFERRAL FORM SUBMISSION
   ============================================================= */

/**
 * Handles the referral form AJAX submission from the Google Review landing page.
 * Validates nonce, sanitises fields, emails the team, and returns JSON.
 */
function ds_handle_gr_referral_submission() {
    // Verify nonce
    if ( ! check_ajax_referer( 'gr_referral_nonce', 'nonce', false ) ) {
        wp_send_json_error( 'Security check failed. Please refresh the page and try again.' );
    }

    // Sanitise & validate required fields (referral 1 name + email required; phone optional)
    $referral_name  = sanitize_text_field( wp_unslash( $_POST['referral_name']    ?? '' ) );
    $referral_email = sanitize_email( wp_unslash( $_POST['referral_email']        ?? '' ) );
    $referral_phone = sanitize_text_field( wp_unslash( $_POST['referral_phone']   ?? '' ) );
    $ref2_name      = sanitize_text_field( wp_unslash( $_POST['referral_2_name']  ?? '' ) );
    $ref2_email     = sanitize_email( wp_unslash( $_POST['referral_2_email']      ?? '' ) );
    $ref2_phone     = sanitize_text_field( wp_unslash( $_POST['referral_2_phone'] ?? '' ) );
    $ref3_name      = sanitize_text_field( wp_unslash( $_POST['referral_3_name']  ?? '' ) );
    $ref3_email     = sanitize_email( wp_unslash( $_POST['referral_3_email']      ?? '' ) );
    $ref3_phone     = sanitize_text_field( wp_unslash( $_POST['referral_3_phone'] ?? '' ) );
    $sub_name       = sanitize_text_field( wp_unslash( $_POST['submitter_name']   ?? '' ) );
    $sub_email      = sanitize_email( wp_unslash( $_POST['submitter_email']       ?? '' ) );
    $sub_phone      = sanitize_text_field( wp_unslash( $_POST['submitter_phone']  ?? '' ) );

    $errors = [];
    if ( empty( $referral_name ) )                                    { $errors[] = 'Referral 1 name is required.'; }
    if ( empty( $referral_email ) || ! is_email( $referral_email ) )  { $errors[] = 'A valid email for Referral 1 is required.'; }
    if ( empty( $sub_name ) )                                         { $errors[] = 'Your name is required.'; }
    if ( empty( $sub_email ) || ! is_email( $sub_email ) )            { $errors[] = 'Your valid email is required.'; }
    if ( empty( $sub_phone ) )                                        { $errors[] = 'Your phone number is required.'; }

    if ( ! empty( $errors ) ) {
        wp_send_json_error( implode( ' ', $errors ) );
    }

    // Helper to build a referral row block
    $ref_row = function ( $label, $name, $email, $phone ) {
        if ( empty( $name ) && empty( $email ) && empty( $phone ) ) { return ''; }
        $out  = '<tr style="background:#dae3ff;"><th colspan="2" style="text-align:left;padding:10px 12px;font-size:14px;color:#1d4382;">' . esc_html( $label ) . '</th></tr>';
        $out .= '<tr><td style="border-bottom:1px solid #eee;width:140px;font-weight:bold;">Name</td><td style="border-bottom:1px solid #eee;">' . esc_html( $name ) . '</td></tr>';
        $out .= '<tr><td style="border-bottom:1px solid #eee;font-weight:bold;">Email</td><td style="border-bottom:1px solid #eee;">' . esc_html( $email ) . '</td></tr>';
        if ( ! empty( $phone ) ) {
            $out .= '<tr><td style="border-bottom:1px solid #eee;font-weight:bold;">Phone</td><td style="border-bottom:1px solid #eee;">' . esc_html( $phone ) . '</td></tr>';
        }
        return $out;
    };

    // Build the notification email to the DS team
    $to      = 'hello@mydigitalstride.com';
    $subject = 'New Referral Submission — Digital Stride';

    $headers  = [ 'Content-Type: text/html; charset=UTF-8' ];
    $headers[] = 'Reply-To: ' . $sub_name . ' <' . $sub_email . '>';

    $body  = '<html><body style="font-family:Arial,sans-serif;color:#020b24;">';
    $body .= '<h2 style="color:#1d4382;">New Referral Submission</h2>';
    $body .= '<table cellpadding="8" cellspacing="0" style="border-collapse:collapse;width:100%;max-width:560px;">';
    $body .= $ref_row( 'Referral 1', $referral_name, $referral_email, $referral_phone );
    $body .= $ref_row( 'Referral 2', $ref2_name, $ref2_email, $ref2_phone );
    $body .= $ref_row( 'Referral 3', $ref3_name, $ref3_email, $ref3_phone );
    $body .= '<tr style="background:#dae3ff;"><th colspan="2" style="text-align:left;padding:10px 12px;font-size:14px;color:#1d4382;">Submitted By</th></tr>';
    $body .= '<tr><td style="border-bottom:1px solid #eee;font-weight:bold;">Name</td><td style="border-bottom:1px solid #eee;">' . esc_html( $sub_name ) . '</td></tr>';
    $body .= '<tr><td style="border-bottom:1px solid #eee;font-weight:bold;">Email</td><td style="border-bottom:1px solid #eee;">' . esc_html( $sub_email ) . '</td></tr>';
    $body .= '<tr><td style="border-bottom:1px solid #eee;font-weight:bold;">Phone</td><td style="border-bottom:1px solid #eee;">' . esc_html( $sub_phone ) . '</td></tr>';
    $body .= '</table>';
    $body .= '<p style="margin-top:20px;font-size:12px;color:#888;">Submitted via the Digital Stride Google Review &amp; Referral page.</p>';
    $body .= '</body></html>';

    wp_mail( $to, $subject, $body, $headers );

    wp_send_json_success( 'Referral submitted successfully.' );
}
add_action( 'wp_ajax_gr_referral_submit',        'ds_handle_gr_referral_submission' );
add_action( 'wp_ajax_nopriv_gr_referral_submit', 'ds_handle_gr_referral_submission' );

/* =============================================================
   REFERRAL LANDING PAGE — FORM SUBMISSION
   ============================================================= */

/**
 * Handles the referral form AJAX submission from the Referral Landing page.
 * Accepts submitter name + email, plus up to 20 referrals (name, email, phone).
 */
function ds_handle_rl_referral_submission() {
    if ( ! check_ajax_referer( 'rl_referral_nonce', 'nonce', false ) ) {
        wp_send_json_error( 'Security check failed. Please refresh the page and try again.' );
    }

    // Submitter info (name + email required; no phone needed)
    $sub_name  = sanitize_text_field( wp_unslash( $_POST['submitter_name']  ?? '' ) );
    $sub_email = sanitize_email( wp_unslash( $_POST['submitter_email']      ?? '' ) );

    $errors = [];
    if ( empty( $sub_name ) )                                { $errors[] = 'Your name is required.'; }
    if ( empty( $sub_email ) || ! is_email( $sub_email ) )  { $errors[] = 'A valid email address is required.'; }

    // Referrals array: referrals[n][name], referrals[n][email], referrals[n][phone]
    $raw_referrals = isset( $_POST['referrals'] ) && is_array( $_POST['referrals'] )
        ? $_POST['referrals']
        : [];

    $referrals = [];
    foreach ( $raw_referrals as $key => $ref ) {
        $r_name  = sanitize_text_field( wp_unslash( $ref['name']  ?? '' ) );
        $r_email = sanitize_email( wp_unslash( $ref['email']      ?? '' ) );
        $r_phone = sanitize_text_field( wp_unslash( $ref['phone'] ?? '' ) );

        if ( empty( $r_name ) && empty( $r_email ) ) continue; // skip fully blank rows

        if ( empty( $r_name ) )                              { $errors[] = 'Name is required for each referral (row ' . intval( $key ) . ').'; }
        if ( empty( $r_email ) || ! is_email( $r_email ) )  { $errors[] = 'A valid email is required for each referral (row ' . intval( $key ) . ').'; }

        $referrals[] = [ 'name' => $r_name, 'email' => $r_email, 'phone' => $r_phone ];

        if ( count( $referrals ) >= 20 ) break; // hard cap at 20
    }

    if ( empty( $referrals ) ) {
        $errors[] = 'Please add at least one referral.';
    }

    if ( ! empty( $errors ) ) {
        wp_send_json_error( implode( ' ', $errors ) );
    }

    // Save submission to database
    global $wpdb;
    $table = $wpdb->prefix . 'rl_referral_submissions';

    $wpdb->insert( $table, [
        'submitter_name'  => $sub_name,
        'submitter_email' => $sub_email,
        'referrals_json'  => wp_json_encode( $referrals ),
        'referral_count'  => count( $referrals ),
        'submitted_at'    => current_time( 'mysql' ),
    ], [ '%s', '%s', '%s', '%d', '%s' ] );

    // Build notification email to DS team
    $to      = 'Results@mydigitalstride.com';
    $subject = 'New Professional Referral Submission (' . count( $referrals ) . ' contact' . ( count( $referrals ) !== 1 ? 's' : '' ) . ') — Digital Stride';
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $sub_name . ' <' . $sub_email . '>',
    ];

    $body  = '<html><body style="font-family:Arial,sans-serif;color:#020b24;">';
    $body .= '<h2 style="color:#1d4382;">New Referral Landing Page Submission</h2>';
    $body .= '<p style="font-size:14px;"><strong>Submitted by:</strong> ' . esc_html( $sub_name ) . ' &lt;' . esc_html( $sub_email ) . '&gt;</p>';
    $body .= '<p style="font-size:14px;"><strong>Total contacts submitted:</strong> ' . count( $referrals ) . '</p>';
    $body .= '<table cellpadding="8" cellspacing="0" style="border-collapse:collapse;width:100%;max-width:620px;margin-top:16px;">';
    $body .= '<tr style="background:#1d4382;color:#fff;"><th style="text-align:left;padding:10px 12px;">#</th><th style="text-align:left;padding:10px 12px;">Name</th><th style="text-align:left;padding:10px 12px;">Email</th><th style="text-align:left;padding:10px 12px;">Phone</th></tr>';

    foreach ( $referrals as $i => $ref ) {
        $row_bg = ( $i % 2 === 0 ) ? '#f9fafc' : '#fff';
        $body .= '<tr style="background:' . $row_bg . ';">';
        $body .= '<td style="border-bottom:1px solid #eee;padding:8px 12px;font-size:13px;">' . ( $i + 1 ) . '</td>';
        $body .= '<td style="border-bottom:1px solid #eee;padding:8px 12px;font-size:13px;">' . esc_html( $ref['name'] ) . '</td>';
        $body .= '<td style="border-bottom:1px solid #eee;padding:8px 12px;font-size:13px;">' . esc_html( $ref['email'] ) . '</td>';
        $body .= '<td style="border-bottom:1px solid #eee;padding:8px 12px;font-size:13px;">' . ( ! empty( $ref['phone'] ) ? esc_html( $ref['phone'] ) : '&mdash;' ) . '</td>';
        $body .= '</tr>';
    }

    $body .= '</table>';
    $body .= '<p style="margin-top:20px;font-size:12px;color:#888;">Submitted via the Digital Stride Referral Landing Page. Reward: $5 per contact submitted, $300 Amazon gift card per new customer.</p>';
    $body .= '</body></html>';

    wp_mail( $to, $subject, $body, $headers );

    wp_send_json_success( 'Referrals submitted successfully.' );
}
add_action( 'wp_ajax_rl_referral_submit',        'ds_handle_rl_referral_submission' );
add_action( 'wp_ajax_nopriv_rl_referral_submit', 'ds_handle_rl_referral_submission' );

/**
 * Handles the feedback form AJAX submission from the Google Review landing page (low NPS).
 */
function ds_handle_gr_feedback_submission() {
    if ( ! check_ajax_referer( 'gr_feedback_nonce', 'nonce', false ) ) {
        wp_send_json_error( 'Security check failed. Please refresh the page and try again.' );
    }

    $name    = sanitize_text_field( wp_unslash( $_POST['fb_name']    ?? '' ) );
    $email   = sanitize_email( wp_unslash( $_POST['fb_email']        ?? '' ) );
    $message = sanitize_textarea_field( wp_unslash( $_POST['fb_message'] ?? '' ) );

    $errors = [];
    if ( empty( $name ) )                          { $errors[] = 'Your name is required.'; }
    if ( empty( $email ) || ! is_email( $email ) ) { $errors[] = 'A valid email address is required.'; }
    if ( empty( $message ) )                       { $errors[] = 'Please enter your feedback.'; }

    if ( ! empty( $errors ) ) {
        wp_send_json_error( implode( ' ', $errors ) );
    }

    $to      = 'hello@mydigitalstride.com';
    $subject = 'Client Feedback — Digital Stride';
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    ];

    $body  = '<html><body style="font-family:Arial,sans-serif;color:#020b24;">';
    $body .= '<h2 style="color:#1d4382;">Client Feedback Submission</h2>';
    $body .= '<table cellpadding="8" cellspacing="0" style="border-collapse:collapse;width:100%;max-width:560px;">';
    $body .= '<tr><td style="border-bottom:1px solid #eee;width:100px;font-weight:bold;">Name</td><td style="border-bottom:1px solid #eee;">' . esc_html( $name ) . '</td></tr>';
    $body .= '<tr><td style="border-bottom:1px solid #eee;font-weight:bold;">Email</td><td style="border-bottom:1px solid #eee;">' . esc_html( $email ) . '</td></tr>';
    $body .= '<tr><td style="border-bottom:1px solid #eee;font-weight:bold;vertical-align:top;">Feedback</td><td style="border-bottom:1px solid #eee;">' . nl2br( esc_html( $message ) ) . '</td></tr>';
    $body .= '</table>';
    $body .= '<p style="margin-top:20px;font-size:12px;color:#888;">Submitted via the Digital Stride Google Review page (low NPS score).</p>';
    $body .= '</body></html>';

    wp_mail( $to, $subject, $body, $headers );

    wp_send_json_success( 'Feedback submitted successfully.' );
}
add_action( 'wp_ajax_gr_feedback_submit',        'ds_handle_gr_feedback_submission' );
add_action( 'wp_ajax_nopriv_gr_feedback_submit', 'ds_handle_gr_feedback_submission' );

/* =============================================================
   EDUCATIONAL REVIEW — FEEDBACK FORM SUBMISSION (low NPS)
   ============================================================= */

/**
 * Handles the feedback form AJAX submission from the Educational Review page (low NPS).
 */
function ds_handle_er_feedback_submission() {
    if ( ! check_ajax_referer( 'er_feedback_nonce', 'nonce', false ) ) {
        wp_send_json_error( 'Security check failed. Please refresh the page and try again.' );
    }

    $name    = sanitize_text_field( wp_unslash( $_POST['fb_name']    ?? '' ) );
    $email   = sanitize_email( wp_unslash( $_POST['fb_email']        ?? '' ) );
    $message = sanitize_textarea_field( wp_unslash( $_POST['fb_message'] ?? '' ) );

    $errors = [];
    if ( empty( $name ) )                          { $errors[] = 'Your name is required.'; }
    if ( empty( $email ) || ! is_email( $email ) ) { $errors[] = 'A valid email address is required.'; }
    if ( empty( $message ) )                       { $errors[] = 'Please enter your feedback.'; }

    if ( ! empty( $errors ) ) {
        wp_send_json_error( implode( ' ', $errors ) );
    }

    $to      = 'hello@mydigitalstride.com';
    $subject = 'Educational Program Feedback — Digital Stride';
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    ];

    $body  = '<html><body style="font-family:Arial,sans-serif;color:#020b24;">';
    $body .= '<h2 style="color:#1d4382;">Educational Program Feedback</h2>';
    $body .= '<table cellpadding="8" cellspacing="0" style="border-collapse:collapse;width:100%;max-width:560px;">';
    $body .= '<tr><td style="border-bottom:1px solid #eee;width:100px;font-weight:bold;">Name</td><td style="border-bottom:1px solid #eee;">' . esc_html( $name ) . '</td></tr>';
    $body .= '<tr><td style="border-bottom:1px solid #eee;font-weight:bold;">Email</td><td style="border-bottom:1px solid #eee;">' . esc_html( $email ) . '</td></tr>';
    $body .= '<tr><td style="border-bottom:1px solid #eee;font-weight:bold;vertical-align:top;">Feedback</td><td style="border-bottom:1px solid #eee;">' . nl2br( esc_html( $message ) ) . '</td></tr>';
    $body .= '</table>';
    $body .= '<p style="margin-top:20px;font-size:12px;color:#888;">Submitted via the Educational Review page (low NPS score).</p>';
    $body .= '</body></html>';

    wp_mail( $to, $subject, $body, $headers );

    wp_send_json_success( 'Feedback submitted successfully.' );
}
add_action( 'wp_ajax_er_feedback_submit',        'ds_handle_er_feedback_submission' );
add_action( 'wp_ajax_nopriv_er_feedback_submit', 'ds_handle_er_feedback_submission' );

/* =============================================================
   QUOTE QUESTIONNAIRE — FORM SUBMISSION
   ============================================================= */

/**
 * Handles the AJAX quote submission from the website questionnaire tool.
 *
 * - Saves the PDF (base64) to a temp file and attaches it to both emails.
 * - Sends to: (1) results@mydigitalstride.com  (2) the client's email address.
 * - Temp file is deleted after sending.
 */
function ds_handle_qb_quote_submission() {
    check_ajax_referer( 'qb_quote_nonce', 'nonce' );

    $name      = sanitize_text_field( $_POST['name']          ?? '' );
    $business  = sanitize_text_field( $_POST['business']      ?? '' );
    $email     = sanitize_email(      $_POST['email']         ?? '' );
    $phone     = sanitize_text_field( $_POST['phone']         ?? '' );
    $notes     = sanitize_textarea_field( $_POST['notes']     ?? '' );
    $tier      = sanitize_text_field( $_POST['qb_tier']       ?? '' );
    $summary   = sanitize_textarea_field( $_POST['summary']   ?? '' );
    $pdf_b64   = $_POST['pdf_b64'] ?? '';  // raw data URI from jsPDF

    // Basic validation
    if ( empty( $name ) || ! is_email( $email ) ) {
        wp_send_json_error( 'Please provide a valid name and email address.' );
    }

    $site_name   = get_bloginfo( 'name' );
    $admin_email = get_option( 'admin_email' );
    $ds_email    = 'results@mydigitalstride.com';
    $tier_label  = ucfirst( str_replace( '_', ' ', $tier ) );
    $subject     = 'Website Quote — ' . ( $business ?: $name ) . ' (' . $tier_label . ' Tier)';

    // ── Save PDF temp file (if provided) ────────────────────────────
    $pdf_path = '';
    if ( ! empty( $pdf_b64 ) ) {
        // Strip data URI prefix: "data:application/pdf;base64,<data>"
        $b64_data = preg_replace( '/^data:[^;]+;base64,/', '', $pdf_b64 );
        $pdf_data = base64_decode( $b64_data );
        if ( $pdf_data !== false ) {
            $upload_dir = wp_upload_dir();
            $pdf_path   = $upload_dir['basedir'] . '/qb-quote-' . sanitize_file_name( $name ) . '-' . time() . '.pdf';
            file_put_contents( $pdf_path, $pdf_data );
        }
    }

    $attachments = $pdf_path ? [ $pdf_path ] : [];

    // ── Email body ──────────────────────────────────────────────────
    $body  = "New website quote request via the Digital Stride questionnaire.\n\n";
    $body .= "=== CONTACT ===\n";
    $body .= "Name:     {$name}\n";
    $body .= "Business: {$business}\n";
    $body .= "Email:    {$email}\n";
    $body .= "Phone:    {$phone}\n\n";
    if ( $notes ) {
        $body .= "=== NOTES ===\n{$notes}\n\n";
    }
    $body .= $summary . "\n\n";
    $body .= "---\nSubmitted via the Website Quote Questionnaire on {$site_name}";

    $from_header    = "From: {$site_name} <{$admin_email}>";
    $reply_to       = is_email( $email ) ? "Reply-To: {$name} <{$email}>" : '';

    // ── Send to Digital Stride team ─────────────────────────────────
    $ds_headers = [ 'Content-Type: text/plain; charset=UTF-8', $from_header ];
    if ( $reply_to ) $ds_headers[] = $reply_to;
    $sent_ds = wp_mail( $ds_email, $subject, $body, $ds_headers, $attachments );

    // ── Send confirmation copy to client ────────────────────────────
    $client_body  = "Hi {$name},\n\n";
    $client_body .= "Thank you for requesting a quote from Digital Stride! We've received your information and will follow up within 1 business day with a detailed proposal.\n\n";
    $client_body .= "Your quote summary is attached as a PDF for your records.\n\n";
    $client_body .= $summary . "\n\n";
    $client_body .= "---\nDigital Stride | results@mydigitalstride.com";

    $client_subject = 'Your Digital Stride Website Quote — ' . ( $business ?: $name );
    $client_headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "From: Digital Stride <{$ds_email}>",
    ];
    wp_mail( $email, $client_subject, $client_body, $client_headers, $attachments );

    // ── Clean up temp PDF ────────────────────────────────────────────
    if ( $pdf_path && file_exists( $pdf_path ) ) {
        unlink( $pdf_path );
    }

    if ( $sent_ds ) {
        wp_send_json_success( 'Quote submitted successfully.' );
    } else {
        wp_send_json_error( 'There was a problem sending your request. Please try again or call us directly.' );
    }
}
add_action( 'wp_ajax_qb_quote_submit',        'ds_handle_qb_quote_submission' );
add_action( 'wp_ajax_nopriv_qb_quote_submit', 'ds_handle_qb_quote_submission' );

/* =============================================================
   MARCH MADNESS — HTML CONFIRMATION EMAIL BUILDER
   ============================================================= */

/**
 * Builds a single round's picks table (4 region columns).
 *
 * @param string   $round_label  Display label for the round.
 * @param string[] $regions      Region slugs, e.g. ['south', 'east', ...].
 * @param string[] $labels       Display labels, e.g. ['South', 'East', ...].
 * @param array    $picks        The full picks array (game_id => team).
 * @param string   $prefix       Game-ID prefix, e.g. 'r1', 'r2'.
 * @param int      $count        Games per region in this round.
 * @return string  HTML fragment.
 */
function ds_mm_round_table( $round_label, $regions, $labels, $picks, $prefix, $count ) {
    $header_style = 'font-size:10px;text-transform:uppercase;letter-spacing:0.06em;'
                  . 'color:#189da7;text-align:left;padding:5px 8px;background:#f2f5fb;'
                  . 'border-bottom:2px solid #dae3ff;font-weight:700';
    $cell_style_odd  = 'font-size:12px;color:#020b24;padding:4px 8px;border-bottom:1px solid #f0f3ff';
    $cell_style_even = $cell_style_odd . ';background:#f9fafc';

    $html  = '<div style="margin-bottom:20px">';
    $html .= '<h3 style="font-size:12px;font-weight:700;color:#1d4382;letter-spacing:0.06em;'
           . 'text-transform:uppercase;border-bottom:2px solid #dae3ff;padding-bottom:5px;margin:0 0 8px">'
           . esc_html( $round_label ) . '</h3>';
    $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse">';

    // Header row
    $html .= '<tr>';
    foreach ( $labels as $lbl ) {
        $html .= '<th style="' . $header_style . '">' . esc_html( $lbl ) . '</th>';
    }
    $html .= '</tr>';

    // Pick rows
    for ( $i = 1; $i <= $count; $i++ ) {
        $cs   = ( $i % 2 === 0 ) ? $cell_style_even : $cell_style_odd;
        $html .= '<tr>';
        foreach ( $regions as $reg ) {
            $gid  = $prefix . '_' . $reg . '_g' . $i;
            $pick = isset( $picks[ $gid ] ) ? esc_html( $picks[ $gid ] ) : '&mdash;';
            $html .= '<td style="' . $cs . '">'
                   . ( $pick !== '&mdash;' ? '<span style="color:#189da7;font-weight:700">&#10003;</span> ' : '' )
                   . $pick . '</td>';
        }
        $html .= '</tr>';
    }

    $html .= '</table></div>';
    return $html;
}

/* =============================================================
   IMAGE ALT TAG FALLBACKS
   Ensures known site images carry descriptive alt text for
   accessibility (WCAG 2.1 Success Criterion 1.1.1).
   ============================================================= */

/**
 * Returns a map of URL path fragments to descriptive alt text for known site images.
 * Keys are substrings that uniquely identify each image within its upload URL.
 */
function digitalstride_get_image_alt_map() {
    return [
        '2025/07/Origami.png'               => 'Colorful paper origami crane',
        '2026/01/Artboard-3-1'              => 'Digital Stride design artwork',
        '2023/12/702300.png'                => 'X (formerly Twitter) social media icon',
        '2023/12/Facebook_icon.svg.png'     => 'Facebook social media icon',
        'PXL_20240821_002849092'            => 'Digital Stride team member photo',
        '2025/06/2.png'                     => 'Digital Stride hero background gradient',
        '2025/07/Website-Sketches-3'        => 'Website design wireframe sketch',
        '2025/07/3-e1752770229938'          => 'Digital Stride design illustration',
        '2024/10/Ship-Sketch.png'           => 'Hand-drawn ship sketch illustration',
        '2024/10/Treasure-Chest-Sketch.png' => 'Hand-drawn treasure chest sketch illustration',
        '2024/10/Hot-Air-Balloon-Sketch.png'=> 'Hand-drawn hot air balloon sketch illustration',
        '2024/10/Cheetah-Sketch.png'        => 'Hand-drawn cheetah sketch illustration',
        '2025/07/4-1.png'                   => 'Digital Stride creative illustration',
        '2026/01/Three-Lightbulbs-hanging'  => 'Three hanging light bulbs',
        '2026/01/Eye.webp'                  => 'Eye graphic illustration',
        '2025/06/2-3'                       => 'Digital Stride team member profile photo',
        '2025/06/4-300x300'                 => 'Digital Stride team member profile photo',
        '2026/02/Debbie-Photo'              => 'Debbie, Digital Stride team member',
        '2026/02/Sara-Nguyen'               => 'Sara Nguyen, Digital Stride team member',
        '2025/08/5.png'                     => 'Digital Stride creative illustration',
        '2025/08/2-1.png'                   => 'Digital Stride design illustration',
        '2026/03/image.webp'                => 'Digital Stride featured post image',
        '2026/02/PXL_20260205_221901227'    => 'Digital Stride event photo',
        '2023/01/image-1.png'               => 'Digital Stride featured image',
        '2023/01/image-2.png'               => 'Digital Stride featured image',
        '2022/11/Business-Manager'          => 'Facebook Business Manager interface screenshot',
        '2022/11/Page-access.png'           => 'Facebook Page access settings screenshot',
        '2024/10/FB-DS-post.png'            => 'Digital Stride Facebook post example',
        '2024/12/image.png'                 => 'Digital Stride featured post image',
    ];
}

/**
 * Adds descriptive alt text to attachment images rendered via WordPress functions
 * when the alt meta field is empty.
 *
 * @param array      $attr       HTML attributes for the image.
 * @param WP_Post    $attachment Attachment post object.
 * @param string|int $size       Requested image size.
 * @return array
 */
function digitalstride_fix_attachment_image_alt( $attr, $attachment, $size ) {
    if ( ! empty( $attr['alt'] ) ) {
        return $attr;
    }

    $src = isset( $attr['src'] ) ? $attr['src'] : '';
    if ( empty( $src ) ) {
        return $attr;
    }

    foreach ( digitalstride_get_image_alt_map() as $fragment => $alt_text ) {
        if ( strpos( $src, $fragment ) !== false ) {
            $attr['alt'] = $alt_text;
            break;
        }
    }

    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'digitalstride_fix_attachment_image_alt', 10, 3 );

/**
 * Adds descriptive alt text to inline <img> tags in post content
 * when the alt attribute is absent or empty.
 *
 * @param string $content Post content HTML.
 * @return string
 */
function digitalstride_fix_content_image_alts( $content ) {
    if ( empty( $content ) || strpos( $content, '<img' ) === false ) {
        return $content;
    }

    $alt_map = digitalstride_get_image_alt_map();

    return preg_replace_callback(
        '/<img\b[^>]*>/i',
        function ( $matches ) use ( $alt_map ) {
            $tag = $matches[0];

            // Already has a non-empty alt — leave it alone.
            if ( preg_match( '/\balt=["\']([^"\']+)["\']/', $tag ) ) {
                return $tag;
            }

            // Require a src attribute to look up alt text.
            if ( ! preg_match( '/\bsrc=["\']([^"\']*)["\']/', $tag, $src_match ) ) {
                return $tag;
            }
            $src = $src_match[1];

            // Find the first matching alt text for this URL.
            $alt_text = '';
            foreach ( $alt_map as $fragment => $alt ) {
                if ( strpos( $src, $fragment ) !== false ) {
                    $alt_text = $alt;
                    break;
                }
            }

            if ( empty( $alt_text ) ) {
                return $tag;
            }

            $escaped_alt = esc_attr( $alt_text );

            // Replace an empty alt="", or insert a missing alt attribute.
            if ( preg_match( '/\balt=["\']["\']/', $tag ) ) {
                return preg_replace( '/\balt=["\']["\']/', 'alt="' . $escaped_alt . '"', $tag );
            }

            return preg_replace( '/(\s*\/?>)$/', ' alt="' . $escaped_alt . '"$1', $tag );
        },
        $content
    );
}
add_filter( 'the_content', 'digitalstride_fix_content_image_alts' );

/* =============================================================
   END IMAGE ALT TAG FALLBACKS
   ============================================================= */

/**
 * Assembles the full HTML confirmation email.
 */
function ds_mm_build_confirmation_email( $name, $email, $company, $phone, $favorite_team, $picks ) {
    $regions       = [ 'south', 'east', 'west', 'midwest' ];
    $region_labels = [ 'South', 'East', 'West', 'Midwest' ];
    $site_url      = get_bloginfo( 'url' );
    $site_name     = get_bloginfo( 'name' );
    $submitted     = gmdate( 'F j, Y \a\t g:i A T' );
    $champion      = isset( $picks['champ_g1'] ) ? esc_html( $picks['champ_g1'] ) : 'Not Selected';

    // Logo
    $logo_html = '';
    if ( function_exists( 'get_field' ) ) {
        $logo_id = get_field( 'header_logo', 'option' );
        if ( $logo_id ) {
            $logo_src = wp_get_attachment_image_url( $logo_id, 'medium' );
            if ( $logo_src ) {
                $logo_html = '<img src="' . esc_url( $logo_src ) . '" alt="' . esc_attr( $site_name ) . '" '
                           . 'style="max-height:44px;max-width:180px;display:block;margin:0 auto 16px" />';
            }
        }
    }

    // Build round pick tables
    $rounds_html  = ds_mm_round_table( 'Round 1 &mdash; First Round', $regions, $region_labels, $picks, 'r1', 8 );
    $rounds_html .= ds_mm_round_table( 'Round of 32',                 $regions, $region_labels, $picks, 'r2', 4 );
    $rounds_html .= ds_mm_round_table( 'Sweet 16',                    $regions, $region_labels, $picks, 'r3', 2 );
    $rounds_html .= ds_mm_round_table( 'Elite Eight',                 $regions, $region_labels, $picks, 'r4', 1 );

    // Final Four
    $ff1 = isset( $picks['ff_g1'] ) ? esc_html( $picks['ff_g1'] ) : '&mdash;';
    $ff2 = isset( $picks['ff_g2'] ) ? esc_html( $picks['ff_g2'] ) : '&mdash;';

    $rounds_html .= '<div style="margin-bottom:20px">'
        . '<h3 style="font-size:12px;font-weight:700;color:#1d4382;letter-spacing:0.06em;'
        . 'text-transform:uppercase;border-bottom:2px solid #dae3ff;padding-bottom:5px;margin:0 0 8px">Final Four</h3>'
        . '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse">'
        . '<tr>'
        . '<th style="font-size:10px;text-transform:uppercase;letter-spacing:0.06em;color:#189da7;text-align:left;padding:5px 8px;background:#f2f5fb;border-bottom:2px solid #dae3ff;font-weight:700">South / East</th>'
        . '<th style="font-size:10px;text-transform:uppercase;letter-spacing:0.06em;color:#189da7;text-align:left;padding:5px 8px;background:#f2f5fb;border-bottom:2px solid #dae3ff;font-weight:700">West / Midwest</th>'
        . '</tr>'
        . '<tr>'
        . '<td style="font-size:12px;color:#020b24;padding:5px 8px"><span style="color:#189da7;font-weight:700">&#10003;</span> ' . $ff1 . '</td>'
        . '<td style="font-size:12px;color:#020b24;padding:5px 8px"><span style="color:#189da7;font-weight:700">&#10003;</span> ' . $ff2 . '</td>'
        . '</tr>'
        . '</table></div>';

    ob_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Your March Madness Bracket</title>
</head>
<body style="margin:0;padding:0;background:#f2f5fb;font-family:'Helvetica Neue',Arial,sans-serif">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f2f5fb;padding:32px 16px">
  <tr><td align="center">
  <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(29,67,130,0.12)">

    <!-- ── Header ── -->
    <tr>
      <td style="background:linear-gradient(90deg,#189da7,#1d4382);padding:32px 40px 28px;text-align:center">
        <?php echo wp_kses_post( $logo_html ); ?>
        <h1 style="color:#ffffff;font-size:22px;font-weight:700;margin:0 0 6px;line-height:1.2">Your 2026 March Madness Bracket</h1>
        <p style="color:rgba(255,255,255,0.82);font-size:13px;margin:0">Digital Stride Competition</p>
      </td>
    </tr>

    <!-- ── Body ── -->
    <tr>
      <td style="padding:32px 40px 24px">
        <p style="color:#020b24;font-size:16px;margin:0 0 10px">Hi <strong><?php echo esc_html( $name ); ?></strong>,</p>
        <p style="color:#555;font-size:14px;line-height:1.65;margin:0 0 28px">
          Your bracket is locked in! Here&rsquo;s a full summary of all your picks. Good luck &mdash; we hope your bracket is perfect! &#127936;
        </p>

        <!-- Prizes -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px">
          <!-- Grand Prize -->
          <tr>
            <td colspan="5" style="background:#f36e21;border:3px solid #f2c814;border-radius:10px;padding:18px 16px;text-align:center">
              <div style="font-size:10px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.8);margin-bottom:4px">Grand Prize &mdash; Perfect Bracket</div>
              <div style="font-size:30px;line-height:1;margin-bottom:6px">&#127942;</div>
              <div style="font-size:26px;font-weight:700;color:#ffffff;line-height:1">$10,000 <span style="color:#f2c814">CASH!</span></div>
            </td>
          </tr>
          <tr><td colspan="5" style="height:12px"></td></tr>
          <!-- 1st / 2nd / 3rd -->
          <tr>
            <td width="32%" style="background:#dae3ff;border:2px solid #1d4382;border-radius:8px;padding:14px 10px;text-align:center;vertical-align:top">
              <div style="font-size:20px;font-weight:700;color:#f2c814;line-height:1">1<sup style="font-size:12px">st</sup></div>
              <div style="font-size:13px;font-weight:700;color:#1d4382;margin-top:4px;line-height:1.3">AEO Audit &amp; Assessment</div>
              <div style="font-size:11px;color:#666;margin-top:4px">$1,500 value</div>
            </td>
            <td width="2%">&nbsp;</td>
            <td width="32%" style="background:#f2f5fb;border:2px solid #c6c6c6;border-radius:8px;padding:14px 10px;text-align:center;vertical-align:top">
              <div style="font-size:20px;font-weight:700;color:#c6c6c6;line-height:1">2<sup style="font-size:12px">nd</sup></div>
              <div style="font-size:13px;font-weight:700;color:#1d4382;margin-top:4px;line-height:1.3">Website Performance Audit</div>
              <div style="font-size:11px;color:#666;margin-top:4px">$350 value</div>
            </td>
            <td width="2%">&nbsp;</td>
            <td width="32%" style="background:#fff5ee;border:2px solid #cd7f32;border-radius:8px;padding:14px 10px;text-align:center;vertical-align:top">
              <div style="font-size:20px;font-weight:700;color:#cd7f32;line-height:1">3<sup style="font-size:12px">rd</sup></div>
              <div style="font-size:13px;font-weight:700;color:#1d4382;margin-top:4px;line-height:1.3">Local Listing Sync of 40+</div>
              <div style="font-size:11px;color:#666;margin-top:4px">$150 value</div>
            </td>
          </tr>
        </table>

        <!-- Champion highlight -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f36e21;border-radius:8px;margin-bottom:28px">
          <tr>
            <td style="padding:18px 24px;text-align:center">
              <div style="font-size:11px;font-weight:700;letter-spacing:0.1em;color:rgba(255,255,255,0.8);text-transform:uppercase;margin-bottom:6px">Your 2026 Champion</div>
              <div style="font-size:22px;font-weight:700;color:#ffffff"><?php echo esc_html( $champion ); ?></div>
            </td>
          </tr>
        </table>

        <!-- Bracket picks by round -->
        <?php echo wp_kses_post( $rounds_html ); ?>

        <!-- Entrant details -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f2f5fb;border-radius:8px;margin-top:12px">
          <tr>
            <td style="padding:14px 18px">
              <p style="font-size:11px;color:#888;margin:0 0 4px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em">Entry Details</p>
              <p style="font-size:12px;color:#444;margin:0 0 2px"><strong>Name:</strong> <?php echo esc_html( $name ); ?></p>
              <p style="font-size:12px;color:#444;margin:0 0 2px"><strong>Company:</strong> <?php echo esc_html( $company ); ?></p>
              <p style="font-size:12px;color:#444;margin:0 0 2px"><strong>Email:</strong> <?php echo esc_html( $email ); ?></p>
              <?php if ( $phone ) : ?><p style="font-size:12px;color:#444;margin:0 0 2px"><strong>Phone:</strong> <?php echo esc_html( $phone ); ?></p><?php endif; ?>
              <p style="font-size:12px;color:#444;margin:0"><strong>Favorite Team:</strong> <?php echo esc_html( $favorite_team ); ?></p>
            </td>
          </tr>
        </table>

      </td>
    </tr>

    <!-- ── Footer ── -->
    <tr>
      <td style="background:#f2f5fb;padding:18px 40px;border-top:1px solid #dae3ff;text-align:center">
        <p style="color:#020b24;font-size:13px;font-weight:700;margin:0 0 4px"><?php echo esc_html( $site_name ); ?></p>
        <p style="color:#888;font-size:11px;margin:0 0 2px">
          <a href="<?php echo esc_url( $site_url ); ?>" style="color:#189da7;text-decoration:none"><?php echo esc_html( preg_replace( '#^https?://#', '', $site_url ) ); ?></a>
        </p>
        <p style="color:#aaa;font-size:10px;margin:8px 0 0">Submitted <?php echo esc_html( $submitted ); ?></p>
        <p style="color:#bbb;font-size:10px;margin:4px 0 0">You&rsquo;re receiving this because you entered the Digital Stride March Madness competition.</p>
      </td>
    </tr>

  </table>
  </td></tr>
</table>
</body>
</html>
    <?php
    return ob_get_clean();
}
