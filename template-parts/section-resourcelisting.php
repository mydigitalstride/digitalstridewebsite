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
            <?php while (have_rows('resource_listing')): the_row(); ?>
              <div class="listing-card">
                <h3><?php the_sub_field('listing_title'); ?></h3>
                <p><?php the_sub_field('listing_description'); ?></p>
                <a href="<?php echo esc_url(get_sub_field('listing_button_link')); ?>" class="listing-btn">
                  <?php the_sub_field('listing_button_text'); ?>
                </a>
              </div>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>

      </section>
