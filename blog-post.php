<?php
/**
 * Template Name: Blog Post Page 
 * Description: Custom listing for the “Blog Post” page that pulls real posts into your bubble cards.
 */

get_header(); ?>

<main id="primary" class="site-main blog-landing">

 
  <section class="blog-hero">
    <div class="container hero-grid">
      <div class="hero-left">
        <h1 class="hero-title"><?php echo esc_html( get_the_title() ); ?></h1>
        <p class="hero-subtitle">Insights, tutorials, and spotlights from our team.</p>
      </div>
      <div class="hero-right">
        <img class="hero-image" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/default-hero.jpg' ); ?>" alt="">
      </div>
    </div>
  </section>

  <section class="blog-cta-band">
    <div class="container cta-grid">
      <div class="cta-left">
        <h2 class="stay-updated">Stay Updated</h2>
        <div class="plus-row">+++++++++</div>
        <p>Get the latest posts and project spotlights in your inbox.</p>
      </div>
      <div class="cta-right">
        <h3>Want to hear more from us?</h3>
        <p>Join our community and get inspired by what we’re building.</p>
        <a class="btn btn-accent" href="/newsletter/">Subscribe to Our Newsletter</a>
      </div>
    </div>
  </section>

  <!--  intro box -->
  <section class="blog-intro">
    <div class="container">
      <div class="intro-card">
        <h3>Blog Post Text</h3>
        <p>What readers can expect: practical tips, design ideas, and growth tactics.</p>
      </div>
    </div>
  </section>

  <!-- Featured heading -->
  <section class="blog-featured-head">
    <div class="container">
      <h2 class="featured-title">Featured</h2>
      <div class="plus-row center">+++++++++</div>
    </div>
  </section>

  <!-- The posts grid -->
  <?php get_template_part('template-parts/section-featured-cards'); ?>

</main>

<?php get_footer(); ?>
