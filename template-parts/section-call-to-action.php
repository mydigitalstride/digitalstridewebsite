<section class="ds-call-to-action-section">
    <div class="ds-cta-container">
        <?php $image = get_sub_field('section_image'); ?>
        <?php if ($image): ?>
            <div class="ds-cta-image-wrapper">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="ds-cta-main-image">
            </div>
        <?php endif; ?>

        <h2 class="ds-cta-title" style="color: white;"><?php the_sub_field('main_title'); ?></h2>

  <?php if (have_rows('star_icon_repeater')): ?>
  <div class="ds-cta-stars" role="img" aria-label="Rating">
    <?php while (have_rows('star_icon_repeater')): the_row(); 
      $icon = trim((string) get_sub_field('star_icon'));
      if ($icon === '') { $icon = '★'; } 
    ?>
      <span class="ds-star-icon"><?php echo esc_html($icon); ?></span>
    <?php endwhile; ?>
  </div>
<?php endif; ?>


        <p class="ds-cta-text"><?php the_sub_field('sub_text'); ?></p>

        <?php 
        $button_text = get_sub_field('button_text');
        $button_link = get_sub_field('button_link');
        if ($button_text && $button_link): ?>
            <div class="ds-cta-button-wrapper">
                <a href="<?php echo esc_url($button_link); ?>" class="ds-cta-button">
                    <?php echo esc_html($button_text); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
