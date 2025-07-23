<!-- <?php
/**
 * Template Name: Front Page
 */
get_header(); 
$shared_bg = get_field('x_image'); 
$shared_bg_style = '';
if ($shared_bg) {
    $shared_bg_style = "style=\"background-image: url('{$shared_bg['url']}'); background-size: cover; background-position: center;\"";
}
?>
<main id="primary" class="site-main">
  <?php if (have_rows('home_page_section')): ?>
    <?php $inside_wrapper = false; ?>

    <?php while (have_rows('home_page_section')): the_row(); ?>

      <?php if (get_row_layout() == 'xwrapper'): ?>
        <?php 
          $bg = get_sub_field('x_image'); 
          $bg_style = $bg ? 'style="background-image: url(' . esc_url($bg['url']) . ');"' : '';
        ?>
        <div class="x-wrapper" <?php echo $bg_style; ?>> <-- X-WRAPPER START -->
        <?php $inside_wrapper = true; ?>

      <?php elseif (get_row_layout() == 'hero_section'): ?>
        <section class="hero-section">
  <div class="hero-content">
    
    <div class="hero-left">
      <?php if (get_sub_field('hero_subheading')): ?>
        <h2><?php the_sub_field('hero_subheading'); ?></h2>
      <?php endif; ?>

      <?php if (get_sub_field('hero_heading')): ?>
        <h1><?php the_sub_field('hero_heading'); ?></h1>
      <?php endif; ?>

      <?php if (get_sub_field('hero_text')): ?>
        <div class="hero-text">
          <p><?php echo esc_html(get_sub_field('hero_text')); ?></p>
        </div>
      <?php endif; ?>
    </div>

   <div class="hero-right">
    <?php
    $image1 = get_sub_field('hero_image');
    $image2 = get_sub_field('hero_gradient_image');
    ?>

    <?php if ($image1): ?>
      <img class="section-image" src="<?php echo esc_url($image1['url']); ?>" alt="<?php echo esc_attr($image1['alt']); ?>">
    <?php else: ?>
      <img class="section-image" src="https://via.placeholder.com/600x400" alt="Placeholder image">
    <?php endif; ?>

    <?php if ($image2): ?>
      <img class="overlay-gradient" src="<?php echo esc_url($image2['url']); ?>" alt="<?php echo esc_attr($image2['alt']); ?>">
    <?php endif; ?>
  </div>
  </div>
</section>
 <section class="background-image-section"<?php echo $shared_bg_style; ?>>
      <?php elseif (get_row_layout() == 'values_section'): ?>
        <section class="values-section">
          <?php $side_image = get_sub_field('side_image'); ?>
          <?php if ($side_image): ?>
            <div class="values-background-image">
              <img src="<?php echo esc_url($side_image['url']); ?>" alt="<?php echo esc_attr($side_image['alt']); ?>">
            </div>
          <?php endif; ?>

          <div class="values-bubble">
            <h2><?php the_sub_field('values_title'); ?></h2>
            <a href="<?php the_sub_field('beliefs_cta_link'); ?>" class="values-cta">
              <?php the_sub_field('beliefs_cta_text'); ?>
            </a>
            <div class="values-list">
              <?php if (have_rows('core_values')): ?>
                <?php while (have_rows('core_values')): the_row(); ?>
                  <div class="value-item">
                    <p><?php the_sub_field('core_value'); ?></p>
                  </div>
                <?php endwhile; ?>
              <?php endif; ?>
            </div>
          </div>
        </section>

      <?php elseif (get_row_layout() == 'mission_section'): ?>
        <section class="mission-local-section">
          <div class="mission-left">
            <h2><?php the_sub_field('mission_heading'); ?></h2>
            <div class="mission-sub"><?php the_sub_field('mission_subheading'); ?></div>
            <h4><?php the_sub_field('mission_location_text'); ?></h4>
            <div class="pa-map-img">
              <img src="<?php the_sub_field('pa_map_image'); ?>" alt="PA Map with marker">
            </div>
          </div>
          <div class="mission-right">
            <?php the_sub_field('opportunity_box'); ?>
          </div>
        </section>
</section>
      <?php elseif (get_row_layout() == 'bubbles_section'): ?>
        <?php $bg_image = get_sub_field('background_image'); ?>
        <section class="bubbles-row"<?php if ($bg_image): ?> style="background-image: url('<?php echo esc_url($bg_image['url']); ?>');"<?php endif; ?>>
          <?php if (have_rows('bubbles')): ?>
            <?php 
              $count = 0;
              while (have_rows('bubbles') && $count < 3): the_row(); $count++; 
            ?>
              <div class="bubble">
                <?php $image = get_sub_field('bubble_image'); ?>
                <?php if ($image): ?>
                  <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="bubble-images" />
                <?php endif; ?>
                <h3 class="bubble-header"><?php echo esc_html(get_sub_field('bubble_header')); ?></h3>
                <p class="bubble-text"><?php the_sub_field('bubble_text'); ?></p>
                <?php if (get_sub_field('bubble_subtext')): ?>
                  <p class="bubble-subtext"><?php echo esc_html(get_sub_field('bubble_subtext')); ?></p>
                <?php endif; ?>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>

          <?php 
            $button_text = get_sub_field('button_text');
            $button_url = get_sub_field('button_url');
            if ($button_text && $button_url): ?>
              <div class="bubbles-button-wrapper">
                <a href="<?php echo esc_url($button_url); ?>" class="bubbles-main-button">
                  <?php echo esc_html($button_text); ?>
                </a>
              </div>
          <?php endif; ?>
        </section>

      <?php elseif (get_row_layout() == 'marketing_section'): ?>
        <section class="values-section marketing-section">
          <div class="values-bubble">
            <h2><?php the_sub_field('marketing_title'); ?></h2>
            <?php if (get_sub_field('marketing_stars')): ?>
              <h3 class="marketing-stars-title"><?php the_sub_field('marketing_stars'); ?></h3>
            <?php endif; ?>

            <div class="marketing-content">
              <?php the_sub_field('marketing_content'); ?>
            </div>

            <a href="<?php the_sub_field('marketing_cta_link'); ?>" class="values-cta">
              <?php the_sub_field('marketing_cta_text'); ?>
            </a>

            <div class="marketing-video-wrapper">
              <?php 
                $marketing_video = get_sub_field('marketing_video');
                if ($marketing_video) {
                  echo wp_oembed_get($marketing_video);
                }
              ?>
            </div>
          </div>
        </section>

        <?php if ($inside_wrapper): ?>
          </div> <!-- X-WRAPPER END -->
          <?php $inside_wrapper = false; ?>
        <?php endif; ?>

      <?php elseif (get_row_layout() == 'we_also_do_section'): ?>
        <section class="we-also-do-section">
          <div class="we-also-do-wrapper">
            <h2><?php the_sub_field('we_also_do_title'); ?></h2>
            <div class="we-also-do-grid">
              <?php if (have_rows('we_also_do_item')): ?>
                <?php while (have_rows('we_also_do_item')): the_row(); ?>
                  <div class="we-also-do-item">
                    <p><?php the_sub_field('item'); ?></p>
                  </div>
                <?php endwhile; ?>
              <?php endif; ?>
            </div>
          </div>
        </section>

      <?php endif; ?>

    <?php endwhile; ?>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
