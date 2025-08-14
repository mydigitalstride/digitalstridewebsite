<section class="wordpress-services-section<?php echo get_sub_field('show_outline') ? ' has-outline' : ''; ?>">
  <div class="services-content">

    <!-- 👈 Text column -->
    <div class="services-text-wrap">
      <?php if ($title = get_sub_field('section_title')): ?>
        <h2><?php echo esc_html($title); ?></h2>
      <?php endif; ?>

      <div class="plus-divider">+ + + + + + + + + +</div>

      <?php if ($sub = get_sub_field('subheading')): ?>
        <p class="subheading"><?php echo esc_html($sub); ?></p>
      <?php endif; ?>

      <?php if (have_rows('list_items')): ?>
        <ul class="service-list">
          <?php while (have_rows('list_items')): the_row(); ?>
            <?php if ($item = get_sub_field('item_text')): ?>
              <li><?php echo esc_html($item); ?></li>
            <?php endif; ?>
          <?php endwhile; ?>
        </ul>
      <?php endif; ?>

      <?php if ($btn = get_sub_field('button_link')): ?>
        <a class="custom-cta-button"
           href="<?php echo esc_url($btn['url']); ?>"
           target="<?php echo esc_attr($btn['target'] ?: '_self'); ?>"
           rel="<?php echo !empty($btn['target']) && $btn['target'] === '_blank' ? 'noopener' : ''; ?>">
           <?php echo esc_html(get_sub_field('button_text') ?: ($btn['title'] ?? 'Learn More')); ?>
        </a>
      <?php endif; ?>
    </div>

    <!-- 👉 Image column -->
    <div class="graphic-wrap">
      <?php if ($laptop_image = get_sub_field('laptop_image')): ?>
        <img
          class="laptop-image"
          src="<?php echo esc_url($laptop_image['url']); ?>"
          alt="<?php echo esc_attr($laptop_image['alt'] ?: 'Laptop Graphic'); ?>" />
      <?php endif; ?>

      <?php
        $stat_val = get_sub_field('stat_value');
        $stat_sub = get_sub_field('stat_subtext');
        if ($stat_val || $stat_sub):
      ?>
        <div class="stat-box">
          <?php if ($stat_val): ?><span class="stat-value"><?php echo esc_html($stat_val); ?></span><?php endif; ?>
          <?php if ($stat_sub): ?><span class="stat-subtext"><?php echo esc_html($stat_sub); ?></span><?php endif; ?>
        </div>
      <?php endif; ?>
    </div>

  </div>
</section>
