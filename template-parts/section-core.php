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