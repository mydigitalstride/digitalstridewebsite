<?php
/**
 * Archive Template: Events (ds_event CPT)
 *
 * Handles the /ds-events/ archive URL by reusing the full
 * events section template (calendar + card grid + modal).
 *
 * @package DigitalStride
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php get_template_part( 'template-parts/section-events' ); ?>

    </main>
</div>

<?php get_footer(); ?>
