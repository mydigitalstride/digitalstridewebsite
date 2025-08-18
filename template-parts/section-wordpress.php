<section class="wordpress-services-section<?php echo get_sub_field('show_outline') ? ' has-outline' : ''; ?>">
  <div class="services-content">

    <!-- 👈 Text column -->
    <div class="services-text-wrap">
      <h2><?php echo esc_html(get_sub_field('section_title')); ?> </h2>
      <div class="plus-divider">+ + + + + + + + + +</div>
 <p class="subheading"><?php echo esc_html(get_sub_field('subheading')); ?></p>

        <ul class="service-list">
          <?php if (have_rows('list_items')): while (have_rows('list_items')):the_row(); ?>
              <li><?php echo esc_html(get_sub_field('item_text')); ?></li>
            <?php endwhile; endif; ?>
        </ul>


   <?php if ($button_link = get_sub_field('button_link')): ?>
  <a href="<?php echo esc_url($button_link['url']); ?>"
     target="<?php echo esc_attr($button_link['target']); ?>"
     class="custom-cta-button">
    <?php echo esc_html(get_sub_field('button_text')); ?>
  </a>
<?php endif; ?>
</div>

    <!-- 👉 Image column -->
    <div class="graphic-wrap">
      <?php if ($laptop_image = get_sub_field('laptop_image')): ?>
        <img src= "<?php echo esc_url($laptop_image['url']); ?>"
          alt="Laptop Graphic" class="laptop-image" />
      <?php endif; ?>
 <div class="stat-box">
        <span class="stat-value"><?php echo esc_html(get_sub_field('stat_value')); ?></span>
        <span class="custom-stat-subtext"><?php echo esc_html(get_sub_field('stat_subtext')); ?></span>
      </div>
    </div>
  </div>
</section>
