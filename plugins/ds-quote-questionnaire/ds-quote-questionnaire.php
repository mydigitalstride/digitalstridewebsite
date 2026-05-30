<?php
/**
 * Plugin Name: DS Quote Questionnaire
 * Plugin URI:  https://mydigitalstride.com
 * Description: Interactive multi-step website quote questionnaire with live pricing, PDF export, and email delivery. Embed with [ds_quote_questionnaire].
 * Version:     1.0.0
 * Author:      Digital Stride
 * Author URI:  https://mydigitalstride.com
 * License:     GPL-2.0-or-later
 * Text Domain: ds-quote
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'DS_QB_VERSION',  '1.0.0' );
define( 'DS_QB_DIR',      plugin_dir_path( __FILE__ ) );
define( 'DS_QB_URL',      plugin_dir_url( __FILE__ ) );

$GLOBALS['ds_qb_config'] = require DS_QB_DIR . 'includes/config.php';

/* =============================================================
   ASSETS
   ============================================================= */

add_action( 'wp_enqueue_scripts', 'ds_qb_enqueue_assets' );

function ds_qb_enqueue_assets() {
    if ( ! ds_qb_page_has_questionnaire() ) {
        return;
    }

    wp_enqueue_style(
        'ds-qb-style',
        DS_QB_URL . 'assets/questionnaire.css',
        [],
        DS_QB_VERSION
    );

    wp_enqueue_script(
        'ds-qb-jspdf',
        'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js',
        [],
        '2.5.1',
        true
    );

    wp_enqueue_script(
        'ds-qb-script',
        DS_QB_URL . 'assets/questionnaire.js',
        [ 'ds-qb-jspdf' ],
        DS_QB_VERSION,
        true
    );

    $logo_url = '';
    if ( function_exists( 'get_field' ) ) {
        $logo_id  = get_field( 'header_logo', 'option' );
        $logo_url = $logo_id ? (string) wp_get_attachment_image_url( $logo_id, 'full' ) : '';
    }

    wp_localize_script( 'ds-qb-script', 'qbData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'qb_quote_nonce' ),
        'logoUrl' => esc_url( $logo_url ),
        'config'  => $GLOBALS['ds_qb_config'],
    ] );
}

/**
 * Returns true if the current post/page contains the questionnaire shortcode
 * or uses the page template.
 */
function ds_qb_page_has_questionnaire() {
    global $post;

    if ( is_singular() && $post instanceof WP_Post ) {
        if ( has_shortcode( $post->post_content, 'ds_quote_questionnaire' ) ) {
            return true;
        }
        // Also support the legacy page template when both plugins coexist
        if ( get_page_template_slug( $post->ID ) === 'page-questionnaire.php' ) {
            return true;
        }
    }

    return false;
}

/* =============================================================
   SHORTCODE  [ds_quote_questionnaire]
   ============================================================= */

add_shortcode( 'ds_quote_questionnaire', 'ds_qb_render_shortcode' );

function ds_qb_render_shortcode( $atts ) {
    ob_start();
    include DS_QB_DIR . 'templates/questionnaire.php';
    return ob_get_clean();
}

/* =============================================================
   AJAX HANDLER — quote submission
   ============================================================= */

add_action( 'wp_ajax_qb_quote_submit',        'ds_qb_handle_submission' );
add_action( 'wp_ajax_nopriv_qb_quote_submit', 'ds_qb_handle_submission' );

function ds_qb_handle_submission() {
    check_ajax_referer( 'qb_quote_nonce', 'nonce' );

    $name     = sanitize_text_field( $_POST['name']      ?? '' );
    $business = sanitize_text_field( $_POST['business']  ?? '' );
    $email    = sanitize_email(      $_POST['email']      ?? '' );
    $phone    = sanitize_text_field( $_POST['phone']      ?? '' );
    $notes    = sanitize_textarea_field( $_POST['notes']  ?? '' );
    $tier     = sanitize_text_field( $_POST['qb_tier']    ?? '' );
    $summary  = sanitize_textarea_field( $_POST['summary'] ?? '' );
    $pdf_b64  = $_POST['pdf_b64'] ?? '';

    if ( empty( $name ) || ! is_email( $email ) ) {
        wp_send_json_error( 'Please provide a valid name and email address.' );
    }

    $site_name  = get_bloginfo( 'name' );
    $admin_email = get_option( 'admin_email' );
    $ds_email   = apply_filters( 'ds_qb_notification_email', 'results@mydigitalstride.com' );
    $tier_label = ucfirst( str_replace( '_', ' ', $tier ) );
    $subject    = 'Website Quote — ' . ( $business ?: $name ) . ' (' . $tier_label . ' Tier)';

    // Save PDF to temp file
    $pdf_path = '';
    if ( ! empty( $pdf_b64 ) ) {
        $b64_data = preg_replace( '/^data:[^;]+;base64,/', '', $pdf_b64 );
        $pdf_data = base64_decode( $b64_data );
        if ( $pdf_data !== false ) {
            $upload_dir = wp_upload_dir();
            $pdf_path   = $upload_dir['basedir'] . '/qb-quote-' . sanitize_file_name( $name ) . '-' . time() . '.pdf';
            file_put_contents( $pdf_path, $pdf_data );
        }
    }

    $attachments = $pdf_path ? [ $pdf_path ] : [];

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

    $from_header = "From: {$site_name} <{$admin_email}>";
    $reply_to    = is_email( $email ) ? "Reply-To: {$name} <{$email}>" : '';

    $ds_headers = [ 'Content-Type: text/plain; charset=UTF-8', $from_header ];
    if ( $reply_to ) {
        $ds_headers[] = $reply_to;
    }
    $sent_ds = wp_mail( $ds_email, $subject, $body, $ds_headers, $attachments );

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

    if ( $pdf_path && file_exists( $pdf_path ) ) {
        unlink( $pdf_path );
    }

    if ( $sent_ds ) {
        wp_send_json_success( 'Quote submitted successfully.' );
    } else {
        wp_send_json_error( 'There was a problem sending your request. Please try again or call us directly.' );
    }
}
