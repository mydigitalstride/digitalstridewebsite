<?php
if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ds_qb_config', [

    /* ── Branding ─────────────────────────────────────── */
    'hero' => [
        'eyebrow'  => 'Free &amp; no-obligation',
        'title'    => 'Get Your Custom Website Quote',
        'subtitle' => 'Answer 9 quick questions and get a real price range — broken down by platform, with flexible payment plans and a downloadable PDF.',
    ],

    /* ── Step 1 ───────────────────────────────────────── */
    'step1' => [
        'heading' => 'What type of business do you run?',
        'sub'     => 'This shapes our starting point for your website\'s goals and pricing.',
        'options' => [
            [ 'value' => 'trades',       'icon' => '🔧', 'label' => 'Home Services / Trades',      'hint' => 'Plumbing, HVAC, electrical, cleaning, landscaping' ],
            [ 'value' => 'contractor',   'icon' => '🏗️', 'label' => 'Specialty Contractor',        'hint' => 'Construction, roofing, concrete, remodeling' ],
            [ 'value' => 'industrial',   'icon' => '🏭', 'label' => 'Industrial / Commercial',     'hint' => 'B2B services, manufacturing, logistics' ],
            [ 'value' => 'ecommerce',    'icon' => '🛒', 'label' => 'eCommerce / Products',        'hint' => 'Online store, physical goods, subscriptions' ],
            [ 'value' => 'trade_school', 'icon' => '🎓', 'label' => 'Trade School / Vocational',   'hint' => 'Enrollment-based, courses, certification programs' ],
            [ 'value' => 'other',        'icon' => '💼', 'label' => 'Other Service Business',      'hint' => 'Professional services, healthcare, real estate' ],
        ],
    ],

    /* ── Step 2 ───────────────────────────────────────── */
    'step2' => [
        'heading' => 'What\'s the #1 job your new website needs to do?',
        'sub'     => 'Focus on the single most important outcome for your business.',
        'options' => [
            [ 'value' => 'calls_leads',    'icon' => '📞', 'label' => 'Generate phone calls &amp; inbound leads',          'hint' => '' ],
            [ 'value' => 'estimates',      'icon' => '📋', 'label' => 'Capture estimate requests &amp; form submissions',  'hint' => '' ],
            [ 'value' => 'sell_products',  'icon' => '🛍️', 'label' => 'Sell products or services directly online',         'hint' => 'Starts at <strong>$5,000–$18,000</strong>' ],
            [ 'value' => 'enroll_students','icon' => '🎓', 'label' => 'Enroll students or course participants',            'hint' => 'Starts at <strong>$12,000–$28,000</strong>' ],
            [ 'value' => 'credibility',    'icon' => '⭐', 'label' => 'Build brand credibility &amp; online presence',    'hint' => '' ],
        ],
    ],

    /* ── Step 2b (eCommerce product count) ────────────── */
    'step2b' => [
        'heading'    => 'Approximately how many products will you sell?',
        'sub'        => 'This helps us estimate catalog setup, variant management, and product photography scope.',
        'hint'       => 'Each product adds approximately <strong>$50–$100</strong> to your estimate for setup, photography coordination, and content.',
        'presets'    => [
            [ 'value' => 10,  'label' => '1–10 products' ],
            [ 'value' => 25,  'label' => '10–50 products' ],
            [ 'value' => 100, 'label' => '50–200 products' ],
            [ 'value' => 300, 'label' => '200+ products' ],
        ],
    ],

    /* ── Step 3 ───────────────────────────────────────── */
    'step3' => [
        'heading' => 'How large is your website project?',
        'sub'     => 'Estimate the number of pages and complexity. We\'ll scope it together.',
        'options' => [
            [ 'value' => 'small',   'icon' => '📄', 'label' => 'Small — 1 to 5 pages',                        'hint' => 'Home, About, Services, Contact &amp; one more',             'badge' => 'No add-on',          'badge_style' => 'starter' ],
            [ 'value' => 'medium',  'icon' => '📑', 'label' => 'Medium — 6 to 15 pages',                      'hint' => 'Multiple service pages, blog, location pages',              'badge' => '+$1,000–$2,500',     'badge_style' => 'professional' ],
            [ 'value' => 'large',   'icon' => '📚', 'label' => 'Large — 15 to 30 pages',                      'hint' => 'eCommerce catalog, multi-location, rich content',           'badge' => '+$2,000–$5,000',     'badge_style' => 'ecommerce' ],
            [ 'value' => 'complex', 'icon' => '🏢', 'label' => 'Complex — 30+ pages or custom functionality', 'hint' => 'LMS, enrollment systems, custom features, multi-site',      'badge' => '+$5,000–$10,000',    'badge_style' => 'enterprise' ],
        ],
    ],

    /* ── Step 4 ───────────────────────────────────────── */
    'step4' => [
        'heading' => 'What area do you serve?',
        'sub'     => 'This affects local SEO architecture and location page strategy.',
        'options' => [
            [ 'value' => 'single',         'icon' => '📍', 'label' => 'Single location',       'hint' => 'One city or town' ],
            [ 'value' => 'multi_location', 'icon' => '🗺️', 'label' => 'Multi-location',        'hint' => 'Multiple cities, regions, or storefronts' ],
            [ 'value' => 'mobile',         'icon' => '🚐', 'label' => 'Mobile / dispatched',   'hint' => 'Service area-based, no fixed location' ],
            [ 'value' => 'national',       'icon' => '🌐', 'label' => 'National / Online only','hint' => 'No geographic restrictions' ],
        ],
    ],

    /* ── Step 5 ───────────────────────────────────────── */
    'step5' => [
        'heading' => 'Who will handle content and copy?',
        'sub'     => 'Great copy is the single biggest difference between a website that sits there and one that converts.',
        'options' => [
            [ 'value' => 'client_provides', 'icon' => '✍️', 'label' => 'I\'ll provide all content',                      'hint' => 'You supply all text, photos, and video' ],
            [ 'value' => 'copy_ds',         'icon' => '📝', 'label' => 'Digital Stride writes the copy',                 'hint' => 'Professional copywriting optimised for conversions&nbsp; <strong>+$1,200–$3,500</strong>' ],
            [ 'value' => 'copy_photo',      'icon' => '📸', 'label' => 'Copy + professional photography / video',        'hint' => 'Full written and visual content production&nbsp; <strong>+$2,000–$6,500</strong>' ],
        ],
    ],

    /* ── Step 6 ───────────────────────────────────────── */
    'step6' => [
        'heading'      => 'What integrations does your website need?',
        'sub'          => 'Select all that apply — these connect your website to the tools you already use.',
        'integrations' => [
            [ 'value' => 'booking',         'icon' => '📅', 'label' => 'Online booking / appointment scheduler',             'hint' => 'Calendly, Acuity, or a custom booking widget&nbsp; <strong>+$150–$500</strong>' ],
            [ 'value' => 'crm',             'icon' => '⚙️',  'label' => 'CRM / dispatch software (Jobber, ServiceTitan)',    'hint' => 'Connect leads directly to your field management system&nbsp; <strong>+$1,500–$4,000</strong>' ],
            [ 'value' => 'customer_portal', 'icon' => '🎓', 'label' => 'Customer Portal',                                   'hint' => 'Client login, account management, member access&nbsp; <strong>+$600–$3,000</strong>' ],
            [ 'value' => 'email_mktg',      'icon' => '📧', 'label' => 'Email marketing integration',                       'hint' => 'Mailchimp, Klaviyo, ActiveCampaign, etc.&nbsp; <strong>+$150–$500</strong>' ],
        ],
    ],

    /* ── Step 7 ───────────────────────────────────────── */
    'step7' => [
        'heading' => 'Any additional services?',
        'sub'     => 'Optional add-ons that enhance reach, accessibility, and visibility.',
        'addons'  => [
            [ 'value' => 'local_seo', 'icon' => '📍', 'label' => 'Local SEO setup (GMB, schema, citations)',    'hint' => 'Price scales with site size: <strong>$300–$4,500</strong> depending on scope' ],
            [ 'value' => 'ada',       'icon' => '♿', 'label' => 'ADA / WCAG accessibility compliance',         'hint' => 'Full audit and remediation to meet standards&nbsp; <strong>+$300–$800</strong>' ],
            [ 'value' => 'multilang', 'icon' => '🌐', 'label' => 'Multi-language support',                      'hint' => 'Reach additional language markets&nbsp; <strong>+$500–$1,500</strong>' ],
        ],
    ],

    /* ── Step 8 ───────────────────────────────────────── */
    'step8' => [
        'heading' => 'Do you have a platform preference?',
        'sub'     => 'Each platform has different strengths. Your quote will show all three options side by side.',
    ],

    /* ── Step 9 ───────────────────────────────────────── */
    'step9' => [
        'heading' => 'What\'s your timeline?',
        'sub'     => 'Is there a hard deadline driving this project?',
        'options' => [
            [ 'value' => 'flexible', 'icon' => '🗓️', 'label' => 'Flexible', 'hint' => '3–5 months, standard pacing' ],
            [ 'value' => 'normal',   'icon' => '📅', 'label' => 'Soon',     'hint' => '2–3 months, moderate urgency' ],
            [ 'value' => 'rush',     'icon' => '⚡', 'label' => 'Rush',     'hint' => 'Under 6 weeks' ],
        ],
    ],

    /* ── Step 10 (contact) ────────────────────────────── */
    'step10' => [
        'heading' => 'Ready to lock in your price?',
        'body'    => 'This estimate is your starting point. Share your details below and we\'ll follow up with a detailed proposal — or book a free discovery call to talk through your project.',
        'perks'   => [
            'No sales pressure, no commitment',
            'Full scope and pricing in writing',
            'Response within 1 business day',
        ],
        'submit_label' => 'Get My Full Proposal',
    ],

    /* ── Pricing ──────────────────────────────────────── */
    'pricing' => [
        'base' => [
            'trades'       => [ 'min' => 2500,  'max' => 5500  ],
            'contractor'   => [ 'min' => 2500,  'max' => 5500  ],
            'industrial'   => [ 'min' => 2500,  'max' => 5500  ],
            'other'        => [ 'min' => 2500,  'max' => 5500  ],
            'ecommerce'    => [ 'min' => 5000,  'max' => 18000 ],
            'trade_school' => [ 'min' => 12000, 'max' => 28000 ],
        ],
        'goal_overrides' => [
            'sell_products'   => [ 'min' => 5000,  'max' => 18000 ],
            'enroll_students' => [ 'min' => 12000, 'max' => 28000 ],
        ],
        'size_addons' => [
            'small'   => [ 'min' => 0,    'max' => 0     ],
            'medium'  => [ 'min' => 1000, 'max' => 2500  ],
            'large'   => [ 'min' => 2000, 'max' => 5000  ],
            'complex' => [ 'min' => 5000, 'max' => 10000 ],
        ],
        'per_product' => [ 'min' => 50, 'max' => 100 ],
        'integrations' => [
            'booking'         => [ 'min' => 150,  'max' => 500  ],
            'crm'             => [ 'min' => 1500, 'max' => 4000 ],
            'customer_portal' => [ 'min' => 600,  'max' => 3000 ],
            'email_mktg'      => [ 'min' => 150,  'max' => 500  ],
        ],
        'addons' => [
            'multilang' => [ 'min' => 500, 'max' => 1500 ],
            'ada'       => [ 'min' => 300, 'max' => 800  ],
        ],
        'local_seo_by_size' => [
            'small'   => [ 'min' => 300,  'max' => 800  ],
            'medium'  => [ 'min' => 500,  'max' => 1000 ],
            'large'   => [ 'min' => 500,  'max' => 1500 ],
            'complex' => [ 'min' => 2500, 'max' => 4500 ],
        ],
        'content' => [
            'copy_ds'    => [ 'min' => 1200, 'max' => 3500 ],
            'copy_photo' => [ 'min' => 2000, 'max' => 6500 ],
        ],
        'platform_mult' => [
            'elementor' => 1.0,
            'custom'    => 1.25,
            'shopify'   => 0.95,
        ],
        'payment_plans' => [
            [ 'months' => 3,  'fee' => 0,    'fee_label' => '0% finance fee'  ],
            [ 'months' => 6,  'fee' => 0.05, 'fee_label' => '5% finance fee'  ],
            [ 'months' => 12, 'fee' => 0.10, 'fee_label' => '10% finance fee' ],
        ],
    ],

    /* ── CTA links ────────────────────────────────────── */
    'cta' => [
        'booking_url'   => 'https://meetings.hubspot.com/exp1st/website-cost-estimator',
        'booking_label' => 'Book a Discovery Call',
    ],

] );
