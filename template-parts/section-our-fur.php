<?php $bg = get_sub_field('fur_background'); ?>
<section class="ds-our-fur-section" style="background-image: url('<?php echo esc_url($bg['url']); ?>'); background-size: cover; background-position: center;">
  <div class="ds-fur-container">
    <h2 class="ds-section-title"><?php the_sub_field('section_title'); ?></h2>
    <?php if (have_rows('fur_members_repeater')): ?>
      <div class="ds-fur-members-grid">
        <?php while (have_rows('fur_members_repeater')): the_row(); ?>
          <div class="ds-fur-member">
            <h3 style="font-weight: bold;"><?php the_sub_field('fur_name'); ?></h3>
            <?php $photo = get_sub_field('fur_photo'); ?>
            <?php if ($photo): ?>
              <img src="<?php echo esc_url($photo['sizes']['medium']); ?>" alt="<?php echo esc_attr($photo['alt']); ?>">
            <?php endif; ?>
            <p class="ds-fur-member-title"><?php the_sub_field('fur_title'); ?></p>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
