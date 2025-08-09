<section class="hero-section">
  <div class="hero-container">

    <div class="hero-left">
      <?php if (get_sub_field('hero_heading')): ?>
        <h1><?php the_sub_field('hero_heading'); ?></h1>
      <?php endif; ?>

      <?php if (get_sub_field('hero_subheading')): ?>
        <h2><?php the_sub_field('hero_subheading'); ?></h2>
      <?php endif; ?>

      <?php if (get_sub_field('hero_text')): ?>
        <p><?php echo esc_html(get_sub_field('hero_text')); ?></p>
      <?php endif; ?>
    </div>

    <div class="hero-right">
      <?php $image = get_sub_field('hero_image'); ?>
      <?php if ($image): ?>
        <img class="section-image" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" style="max-width: 100%; height: auto;">
      <?php else: ?>
        <img class="section-image" src="https://via.placeholder.com/600x400" alt="Placeholder image" style="max-width: 100%; height: auto;">
      <?php endif; ?>
    </div>

  </div>
</section>
