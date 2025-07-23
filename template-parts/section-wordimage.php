<section class="growth-section">
  <div class="growth-left">
      <h2><?php the_sub_field('left_heading'); ?></h2>
      <?php if (get_sub_field('icon_plus')): ?>
        <span class="icon_plus"><?php the_sub_field('icon_plus'); ?></span>
      <?php endif; ?>
      <div class="growth-sub">
          <p><?php the_sub_field('left_subheading'); ?></p>
      </div>
      <?php if ($button = get_sub_field('button_link')): ?>
                <a href="<?php echo esc_url($button['url']); ?>" class="custom-cta-button">
                    <?php the_sub_field('button_text'); ?>
                </a>
            <?php endif; ?>
  </div>
  <div class="right">
      <?php if ($right_image = get_sub_field('right_image')): ?>
        <img src="<?php echo esc_url($right_image['url']); ?>" alt="<?php echo esc_attr($right_image['alt']); ?>" style="width:100%; border-radius:12px;" />
      <?php endif; ?>
  </div>
  
</section>
