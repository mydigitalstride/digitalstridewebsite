<section class="blue-bubbles-row">
  <?php if (have_rows('blue_bubble')): ?>
    <?php while (have_rows('blue_bubble')): the_row(); ?>
      <?php
        $image       = get_sub_field('blue_bubble_image');
        $heading     = get_sub_field('blue_bubble_heading');
        $button_text = get_sub_field('blue_bubble_button_text');
        $button_url  = get_sub_field('button_url')['url'] ?? '';
        $button_target = get_sub_field('button_url')['target'] ?? '_self';
      ?>
      <div class="bubble" style="position: relative;">
        <?php if ($image): ?>
          <img 
            src="<?php echo esc_url($image['url']); ?>" 
            alt="<?php echo esc_attr($image['alt']); ?>" 
            class="bubble-image" 
          />
        <?php endif; ?>

        <?php if ($heading): ?>
          <h3 class="bubble-header"><?php echo esc_html($heading); ?></h3>
        <?php endif; ?>

        <?php if (have_rows('blue_bubble_bullet')): ?>
          <ul class="bubble-list">
            <?php while (have_rows('blue_bubble_bullet')): the_row(); ?>
              <?php $bullet = get_sub_field('blue_bubble_bullet_text'); ?>
              <?php if ($bullet): ?>
                <li><?php echo esc_html($bullet); ?></li>
              <?php endif; ?>
            <?php endwhile; ?>
          </ul>
        <?php endif; ?>

        <?php if ($button_text && $button_url): ?>
          <div class="bubbles-blue-right">
            <a href="<?php echo esc_url($button_url); ?>" target="<?php echo esc_attr($button_target); ?>" class="custom-cta-button">
              <?php echo esc_html($button_text); ?>
            </a>
          </div>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="color: red;">No blue bubbles found. Check your ACF field group.</p>
  <?php endif; ?>
</section>
