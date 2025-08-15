<?php
    $background_image = get_sub_field('hero_gradient_image');
    $background_url = $background_image ? esc_url($background_image['url']) : 'https://staging8.mydigitalstride.com/wp-content/uploads/2025/06/2.png';
?>

<section class="hero-section hero-background" style="--background-url: url('<?php echo $background_url; ?>');">
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
     
  </div>
</section>