<section class="bubbles-row">
    <?php if (have_rows('bubbles')): ?>
      <?php while (have_rows('bubbles')): the_row(); ?>
        <div class="bubble">
          <?php $image = get_sub_field('bubble_image'); ?>
          <?php if ($image): ?>
            <img 
              src="<?php echo esc_url($image['url']); ?>" 
              alt="<?php echo esc_attr($image['alt']); ?>" 
              class="bubble-image" 
            />
          <?php endif; ?>
          <?php if (get_sub_field('bubble_header')): ?>
            <h3 class="bubble-header"><?php the_sub_field('bubble_header'); ?></h3>
          <?php endif; ?>
        <?php if (get_sub_field('plus_icon')): ?>
          <span class="bubble-plus-icon">
            <?php the_sub_field('plus_icon'); ?>
          </span>
        <?php endif; ?>
          <?php if (get_sub_field('bubble_text')): ?>
            <p class="bubble-text"><?php the_sub_field('bubble_text'); ?></p>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>

    <?php
      $button_text = get_sub_field('button_text');
      $button_url = get_sub_field('button_url');
      if ($button_text && $button_url):
    ?>
      <div class="bubbles-button-wrapper">
        <a href="<?php echo esc_url($button_url); ?>" class="bubbles-main-button">
          <?php echo esc_html($button_text); ?>
        </a>
      </div>
    <?php endif; ?>
  </section>

