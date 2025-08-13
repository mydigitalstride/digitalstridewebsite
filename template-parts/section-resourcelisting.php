<section class="resource-listing-section">
  
  <!-- Header -->
  <?php if ($header = get_sub_field('listing_header')): ?>
    <h3 class="listing-header"><?php echo esc_html($header); ?></h3>
  <?php endif; ?>

  <!-- Plus Icons -->
  <?php if ($icons = get_sub_field('listing_plus_icons')): ?>
    <div class="plus-icon-listing"><?php echo esc_html($icons); ?></div>
  <?php endif; ?>

  <!-- Repeater Items -->
  <?php if (have_rows('resource_listing')): ?>
    <div class="listing-wrapper">
      <?php while (have_rows('resource_listing')): the_row(); 
        $link = get_sub_field('listing_button_link');
        $title = get_sub_field('listing_title');
      ?>
        <?php if ($link): ?>
          <a href="<?php echo esc_url($link); ?>" class="listing-card">
        <?php else: ?>
          <div class="listing-card">
        <?php endif; ?>

          <h3><?php echo esc_html($title); ?></h3>
          <p><?php the_sub_field('listing_description'); ?></p>
          <?php if (get_sub_field('listing_button_text')): ?>
            <span class="listing-btn">
              <?php the_sub_field('listing_button_text'); ?>
            </span>
          <?php endif; ?>

        <?php if ($link): ?>
          </a>
        <?php else: ?>
          </div>
        <?php endif; ?>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>

</section>
