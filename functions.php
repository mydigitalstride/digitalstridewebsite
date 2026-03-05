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

    // Events CSS + JS
    if (is_post_type_archive('ds_event') || is_singular('ds_event') || is_page('events') || digitalstride_page_has_events_section()) {
        wp_enqueue_style('events-css', get_template_directory_uri() . '/styles/events.css', [], '1.2.0');
        wp_enqueue_script('events-js', get_template_directory_uri() . '/js/events.js', [], '1.2.0', true);
    }

    // March Madness Bracket CSS + JS
    if (is_page_template('page-march-madness.php')) {
        wp_enqueue_style('march-madness-css', get_template_directory_uri() . '/styles/march-madness.css', [], '1.0.0');
        wp_enqueue_script('march-madness-js', get_template_directory_uri() . '/js/march-madness.js', [], '1.0.0', true);
        wp_localize_script('march-madness-js', 'mmBracket', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('mm_bracket_nonce'),
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
    flush_rewrite_rules();
});

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
    $phone         = isset( $_POST['phone'] )        ? sanitize_text_field( wp_unslash( $_POST['phone'] ) )        : '';
    $favorite_team = isset( $_POST['favoriteTeam'] ) ? sanitize_text_field( wp_unslash( $_POST['favoriteTeam'] ) ) : '';
    $picks_raw     = isset( $_POST['picks'] )        ? wp_unslash( $_POST['picks'] )                               : '{}';

    // Basic validation
    if ( empty( $name ) || empty( $email ) || ! is_email( $email ) || empty( $favorite_team ) ) {
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
        "Email:         {$email}\n" .
        "Phone:         " . ( $phone ?: 'Not provided' ) . "\n" .
        "Favorite Team: {$favorite_team}\n" .
        "Submitted:     " . gmdate( 'M j, Y g:i A T' ) . "\n\n" .
        "Picks:\n{$picks_display}\n\n" .
        "View in WP Admin: " . admin_url( 'post.php?post=' . $post_id . '&action=edit' );

    wp_mail( $admin_email, $admin_subject, $admin_message );

    // Confirmation email to entrant
    $confirm_subject = 'Your Digital Stride March Madness Bracket is In!';
    $confirm_message =
        "Hi {$name},\n\n" .
        "Your bracket has been successfully submitted. Good luck!\n\n" .
        "Prizes:\n" .
        "  • Perfect Bracket: \$10,000\n" .
        "  • 1st Place: \$1,500 AEO Audit & Assessment\n\n" .
        "We'll be in touch with results after the tournament.\n\n" .
        "— The Digital Stride Team\n" .
        get_bloginfo( 'url' );

    wp_mail( $email, $confirm_subject, $confirm_message );

    wp_send_json_success( 'Bracket submitted successfully.' );
}
add_action( 'wp_ajax_mm_submit_bracket',        'ds_handle_mm_bracket_submission' );
add_action( 'wp_ajax_nopriv_mm_submit_bracket', 'ds_handle_mm_bracket_submission' );
