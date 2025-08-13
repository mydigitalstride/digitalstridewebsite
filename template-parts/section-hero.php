<section class="hero-section">
  <div class="hero-container">

    <div class="hero-left">
      <div class="hero-heading-wrap">
        <?php if (get_sub_field('hero_subheading')): ?>
          <div class="hero-subheading">
            <?php the_sub_field('hero_subheading'); ?> <!-- e.g., "+" -->
          </div>
        <?php endif; ?>

        <div class="hero-title-text">
          <?php if (get_sub_field('hero_heading')): ?>
            <h1 class="hero-title"><?php the_sub_field('hero_heading'); ?></h1>
          <?php endif; ?>

          <?php if (get_sub_field('hero_text')): ?>
            <p class="hero-lede"><?php echo esc_html(get_sub_field('hero_text')); ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="hero-right">


      <?php $image = get_sub_field('hero_image'); ?>
      <?php if ($image): ?>
        <img class="section-image" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
      <?php else: ?>
        <img class="section-image" src="https://via.placeholder.com/600x400" alt="Placeholder image">
      <?php endif; ?>
      <?php $gradient_image = get_sub_field('hero_gradient_image'); ?>
    </div>
 <?php if ($gradient_image): ?>
        <img class="hero-gradient-image" src="<?php echo esc_url($gradient_image['url']); ?>" alt="<?php echo esc_attr($gradient_image['alt']); ?>">
      <?php endif; ?>
  </div>
</section>
