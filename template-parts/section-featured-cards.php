<section class="featured-cards-section">
  <div class="featured-cards-wrap">
    <?php if (have_rows('featured_cards')): ?>
      <?php while (have_rows('featured_cards')): the_row(); ?>
        <?php
          $title = get_sub_field('card_title');
          $desc = get_sub_field('card_description');
          $icon = get_sub_field('card_icon');
          $button_text = get_sub_field('card_button_text');
          $button_link = get_sub_field('card_button_link');
        ?>
        <div class="featured-card">
          <?php if ($icon): ?>
            <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>" class="featured-card-icon" />
          <?php endif; ?>

          <?php if ($title): ?>
            <h3 class="card-title"><?php echo esc_html($title); ?></h3>
          <?php endif; ?>

          <?php if ($desc): ?>
            <p class="card-description"><?php echo esc_html($desc); ?></p>
          <?php endif; ?>

          <?php if ($button_link && $button_text): ?>
            <a href="<?php echo esc_url($button_link['url']); ?>" class="card-button" target="<?php echo esc_attr($button_link['target']); ?>">
              <?php echo esc_html($button_text); ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</section>
