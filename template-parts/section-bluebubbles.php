<section class="blue-bubbles-row">
  <?php if (have_rows('blue_bubble')): ?>
    <?php while (have_rows('blue_bubble')): the_row(); ?>
      <div class="bubble">
        <?php $image = get_sub_field('blue_bubble_image'); ?>
        <?php if ($image): ?>
          <img 
            src="<?php echo esc_url($image['url']); ?>" 
            alt="<?php echo esc_attr($image['alt']); ?>" 
            class="bubble-image" 
          />
        <?php endif; ?>

        <?php if (get_sub_field('blue_bubble_heading')): ?>
          <h3 class="bubble-header"><?php the_sub_field('blue_bubble_heading'); ?></h3>
        <?php endif; ?>

        <?php if (have_rows('blue_bubble_bullet')): ?>
          <?php while (have_rows('blue_bubble_bullet')): the_row(); ?>
            <?php if (get_sub_field('blue_bubble_bullet_text')): ?>
              <p class="bubble-text"><?php the_sub_field('blue_bubble_bullet_text'); ?></p>
            <?php endif; ?>
          <?php endwhile; ?>
        <?php endif; ?>

        <!-- Button inside each bubble -->
        <?php 
          $button_text = get_sub_field('blue_bubble_button_text'); 
          $button_url = get_sub_field('button_url'); 
          if ($button_text && $button_url): 
        ?>
          <div class="bubbles-blue-right">
            <a href="<?php echo esc_url($button_url); ?>" class="custom-cta-button">
              <?php echo esc_html($button_text); ?>
            </a>
          </div>
        <?php endif; ?>
        
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</section>
