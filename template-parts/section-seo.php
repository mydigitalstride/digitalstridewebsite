<?php
$bg_color = get_sub_field('background_color');
$section_style = '';
if ($bg_color) {
    $section_style = 'style="background-color:' . esc_attr($bg_color) . ';"';
}
?>

<section class="web-audit-section" <?php echo $section_style; ?>>
  <div class="web-audit-inner">

    <!-- Left Side: Web Audit Form -->
    <div class="audit-form">
      <h3><?php the_sub_field('section_title_left'); ?></h3>
      <p class="description-text"><?php the_sub_field('section_text'); ?></p>

      <div class="cf7-form-wrap">
        <?php echo do_shortcode(get_sub_field('form_shortcode')); ?>
      </div>
    </div>

    <!-- Right Side: Benefits List -->
    <div class="audit-benefits">
      <h3><?php the_sub_field('benefits_title'); ?></h3>
      <div class="benefits-list">
        <?php if (have_rows('benefits')) : ?>
          <ul>
            <?php while (have_rows('benefits')) : the_row(); 
              $icon = get_sub_field('icon');
              $benefit = get_sub_field('benefit');
            ?>
              <li class="benefit-item">
                <?php if ($icon): ?>
                  <img src="<?php echo esc_url($icon['url']); ?>" alt="Icon" />
                <?php endif; ?>
                <span><?php echo esc_html($benefit); ?></span>
              </li>
            <?php endwhile; ?>
          </ul>
        <?php endif; ?>
      </div>

      <!-- Static Logo (or dynamic if needed) -->
      <div class="audit-logo">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-digital-stride.png" alt="Digital Stride" />
      </div>
    </div>

  </div>
</section>
