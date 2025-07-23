<section class="centered-bubbles-section">
  <?php if (have_rows('bubbles_image')): ?>
    <?php while (have_rows('bubbles_image')): the_row(); ?>
      <div class="centered-bubbles-container">
        <?php $image = get_sub_field('bubble_image'); ?>
        <?php if ($image): ?>
          <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="centered-bubble-image" />
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</section>
