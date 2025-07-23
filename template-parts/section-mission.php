<section class="mission-local-section">
  <div class="mission-left">
    <h2><?php the_sub_field('mission_heading'); ?></h2>
    <div class="mission-sub"><?php the_sub_field('mission_subheading'); ?></div>
    <h4><?php the_sub_field('mission_location_text'); ?></h4>
    <div class="pa-map-img">
      <img src="<?php the_sub_field('pa_map_image'); ?>" alt="PA Map with marker">
    </div>
  </div>
  <div class="mission-right">
    <?php the_sub_field('opportunity_box'); ?>
  </div>
</section>