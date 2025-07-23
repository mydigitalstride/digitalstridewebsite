  <section class="acf-404-section">
    <div class="acf-404-wrapper">
 <?php $image = get_sub_field('error_heading'); ?>
      <?php if ($image): ?>
        <img 
          src="<?php echo esc_url($image['url']); ?>" 
          alt="<?php echo esc_attr($image['alt']); ?>" 
          class="acf-404-heading-image"
        />
      <?php endif; ?>

      <p class="acf-404-message"><?php the_sub_field('error_message'); ?></p>

      <p class="acf-404-subtext">
        <?php the_sub_field('sub_message'); ?>
      </p>

      <?php if ($button = get_sub_field('404_button_link')): ?>
        <a href="<?php echo esc_url($button['url']); ?>" class="acf-404-button">
          <?php the_sub_field('404_button_text'); ?>
        </a>
      <?php endif; ?>
    </div>
  </section>
