<section class="custom_website_development">
  <div class="custom-services-content flipped-layout">
    
    <!-- 👈 Image on the LEFT -->
    <div class="custom-graphic-wrap">
      <?php if ($laptop_image = get_sub_field('custom_screw_image')): ?>
        <img src="<?php echo esc_url($laptop_image['url']); ?>" alt="Screw Graphic" class="custom-screw-image" />
      <?php endif; ?>

      <div class="custom-stat-box">
        <span class="custom-stat-value"><?php echo esc_html(get_sub_field('custom_stat_value')); ?></span>
        <span class="custom-stat-subtext"><?php echo esc_html(get_sub_field('custom_stat_subtext')); ?></span>
      </div>
    </div>

    <!-- 👉 Text on the RIGHT -->
    <div class="custom-text-wrap">
      <h2><?php echo esc_html(get_sub_field('custom_section_title')); ?></h2>
      <div class="plus-divider">+ + + + + + + + + +</div>
      <p class="subheading"><?php echo esc_html(get_sub_field('custom_subheading')); ?></p>

      <ul class="custom-service-list">
        <?php if (have_rows('custom_list_items')): while (have_rows('custom_list_items')): the_row(); ?>
          <li><?php echo esc_html(get_sub_field('custom_item_text')); ?></li>
        <?php endwhile; endif; ?>
      </ul>

      <?php if ($button_link = get_sub_field('custom_button_link')): ?>
        <a href="<?php echo esc_url($button_link['url']); ?>" target="<?php echo esc_attr($button_link['target']); ?>" class="custom-cta-button">
          <?php echo esc_html(get_sub_field('custom_button_text')); ?>
        </a>
      <?php endif; ?>
    </div>

  </div>
</section>
