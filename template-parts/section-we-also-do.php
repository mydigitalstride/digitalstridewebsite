<section class="we-also-do-section">
  <div class="we-also-do-wrapper">
    <h2><?php the_sub_field('we_also_do_title'); ?></h2>
    <div class="we-also-do-grid">
      <?php if (have_rows('we_also_do_item')): ?>
        <?php while (have_rows('we_also_do_item')): the_row(); 
          $item_text = get_sub_field('item');
          $icon = get_sub_field('icon'); // image array
        ?>
          <div class="we-also-do-item">
            <?php if ($icon): ?>
              <img class="we-also-do-icon" src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($item_text); ?>">
            <?php endif; ?>
            <p><?php echo esc_html($item_text); ?></p>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>
</section>
