<section class="timeline-scope"<?php if (get_sub_field('timeline_background_image')): ?> style="background-image: url('<?php echo esc_url(get_sub_field('timeline_background_image')['url']); ?>'); background-size: cover; background-position: center;"<?php endif; ?>>
  <h2 class="timeline-heading"><?php echo esc_html(get_sub_field('title')); ?></h2>

  <div class="timeline-bar">
    <span class="circle"></span>
    <span class="circle"></span>
    <span class="circle"></span>
  </div>

  <div class="timeline-labels">
    <span class="left-label"><?php echo esc_html(get_sub_field('timeline_duration_left')); ?></span>
    <span class="right-label"><?php echo esc_html(get_sub_field('timeline_duration_right')); ?></span>
  </div>

  <div class="timeline-features-wrapper">
    <div class="timeline-features-list">
      <ul>
        <?php if (have_rows('timeline_features')): ?>
          <?php while (have_rows('timeline_features')) : the_row(); ?>
            <li><?php the_sub_field('feature_item'); ?></li>
          <?php endwhile; ?>
        <?php endif; ?>
      </ul>
    </div>

    <?php if (get_sub_field('scope_image')): ?>
      <div class="timeline-features-image">
        <img src="<?php echo esc_url(get_sub_field('scope_image')['url']); ?>" alt="<?php echo esc_attr(get_sub_field('scope_image')['alt']); ?>" />
      </div>
    <?php endif; ?>
  </div>
</section>
