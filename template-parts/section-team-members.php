<?php
/**
 * Our Team Section Template
 * Usage: Include in Flexible Content loop via get_template_part()
 */
?>

<section class="ds-our-team-section">
  <div class="ds-team-wrapper">

    <!-- Section Title -->
    <?php if (get_sub_field('section_title')): ?>
      <h2 class="ds-section-title"><?php the_sub_field('section_title'); ?></h2>
    <?php endif; ?>

    <!-- Plus Icon -->
    <div class="ds-plus-icon-teams">+ + + + + + +</div>

    <!-- Section Stars -->
    <?php if (have_rows('section_stars_repeater')): ?>
      <div class="ds-section-stars">
        <?php while (have_rows('section_stars_repeater')): the_row(); ?>
          <span class="ds-star-icon">★</span>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>

    <!-- Team Members -->
    <?php if (have_rows('team_members_repeater')): ?>
      <section class="ds-bubbles-row">
        <?php while (have_rows('team_members_repeater')): the_row(); ?>
          <div class="ds-bubble">

            <!-- Member Name -->
            <?php if (get_sub_field('member_name')): ?>
              <h3 class="ds-bubble-header"><?php the_sub_field('member_name'); ?></h3>
            <?php endif; ?>

            <!-- Member Stars -->
            <?php if (have_rows('member_star_repeater')): ?>
              <div class="ds-member-stars ds-centered-stars">
                <?php while (have_rows('member_star_repeater')): the_row(); ?>
                  <span class="ds-star-icon">★</span>
                <?php endwhile; ?>
              </div>
            <?php endif; ?>

            <!-- Member Photo -->
            <?php
              $photo = get_sub_field('member_photo');
              if ($photo):
            ?>
              <div class="ds-bubble-img-center">
                <img src="<?php echo esc_url($photo['sizes']['medium']); ?>" alt="<?php echo esc_attr($photo['alt']); ?>" class="ds-bubble-image-center">
              </div>
            <?php endif; ?>

            <!-- Member Title -->
            <?php if (get_sub_field('member_title')): ?>
              <p class="ds-bubble-text"><?php the_sub_field('member_title'); ?></p>
            <?php endif; ?>

            <!-- CTA Button -->
            <?php
              $cta_text = get_sub_field('cta_text');
              $cta_link = get_sub_field('cta_link');
              if ($cta_text && $cta_link):
            ?>
              <div class="ds-bubbles-button-wrapper">
                <a href="<?php echo esc_url($cta_link); ?>" class="ds-bubbles-main-button">
                  <?php echo esc_html($cta_text); ?>
                </a>
              </div>
            <?php endif; ?>

          </div>
        <?php endwhile; ?>
      </section>
    <?php endif; ?>

  </div>
</section>
