<?php
/**
 * Template for the /events page (slug: events)
 *
 * WordPress automatically uses this file for any page with the slug "events".
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
