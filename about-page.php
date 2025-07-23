<?php
/**
 * Template Name: About Us Page
 * Description: Template for the About Us page with flexible content sections.
 */

get_header(); 
$shared_bg = get_field('background_image');
$shared_bg_style = '';
if ($shared_bg) {
    $shared_bg_style = "style=\"background-image: url('{$shared_bg['url']}'); background-size: cover; background-position: center;\"";
}
?>
<div id="primary" class="content-area about-us-page">
    <main id="main" class="site-main">

        <?php
        // ✅ FIXED: Use correct flexible content field name
        if (have_rows('about_page_sections')):
            while (have_rows('about_page_sections')): the_row();
        // About Digital Stride Section
       if (get_row_layout() == 'about_digital_stride'): ?>
  <section class="about-digital-stride-section">
    <div class="container">
      <span class="bubble-plus-icon">+</span>
      <div class="hero-text">
        <div class="hero-left">
          <h2 class="section-title"><?php the_sub_field('section_title'); ?></h2>
          <div class="section-content"><?php the_sub_field('content'); ?></div>
        </div>
        <div class="hero-right">
          <img class="section-image" src="<?php the_sub_field('section_image'); ?>" alt="img">
        </div>
      </div>
    </div>
  </section>
  <section class="background-image-section"<?php echo $shared_bg_style; ?>>
   <?php elseif (get_row_layout() == 'strategy'): ?>
    <section class="strategy-local-section">
          <div class="strategy-left">
           <img class="strategy-image" src="<?php the_sub_field('strategy_image'); ?>" alt="image">
          </div>
          <div class="strategy-right">
            <?php the_sub_field('people_first'); ?>
          </div>
        </section>
<?php elseif (get_row_layout() == 'mindset'): ?>
<section class="mindset-section">
  <div class="mindset-bubble">
    <h2><?php the_sub_field('mindset_title'); ?></h2>
    
    <div class="mindset-list">
      <?php if (have_rows('bullet_points_repeater')): ?>
        <ul class="mindset-items">
          <?php while (have_rows('bullet_points_repeater')): the_row(); ?>
<?php 
  $point_title = get_sub_field('point_title'); 
  $point_content = get_sub_field('point_content');
?>
<li class="mindset-item">
  <div class="mindset-title"><?php echo esc_html($point_title); ?></div>
</li>
<?php if (!empty($point_content)): ?>
  <div class="point-content-outside"><?php echo wp_kses_post($point_content); ?></div>
<?php endif; ?>

          <?php endwhile; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php elseif (get_row_layout() == 'our_team_section'): ?>
  <section class="our-team-section">
    <div class="team-wrapper">
      <h2 class="section-title"><?php the_sub_field('section_title'); ?></h2>

      <div class="section-stars">
        <?php if (have_rows('section_stars_repeater')): ?>
          <?php while (have_rows('section_stars_repeater')): the_row(); ?>
            <span class="star-icon">★</span>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>

      <?php if (have_rows('team_members_repeater')): ?>
        <section class="bubbles-row">
          <?php while (have_rows('team_members_repeater')): the_row(); ?>
            <div class="bubble">
              <h3 class="bubble-header"><?php the_sub_field('member_name'); ?></h3>
              <div class="member-stars centered-stars">
                <?php if (have_rows('member_star_repeater')): ?>
                  <?php while (have_rows('member_star_repeater')): the_row(); ?>
                    <span class="star-icon">★</span>
                  <?php endwhile; ?>
                <?php endif; ?>
              </div>

              <?php $photo = get_sub_field('member_photo'); ?>
              <?php if ($photo): ?>
                <div class="bubble-img-center">
                  <img src="<?php echo esc_url($photo['sizes']['medium']); ?>" alt="<?php echo esc_attr($photo['alt']); ?>" class="bubble-image-center">
                </div>
              <?php endif; ?>

              <p class="bubble-text"><?php the_sub_field('member_title'); ?></p>

              <?php if (get_sub_field('cta_text') && get_sub_field('cta_link')): ?>
                <div class="bubbles-button-wrapper">
                  <a href="<?php the_sub_field('cta_link'); ?>" class="bubbles-main-button">
                    <?php the_sub_field('cta_text'); ?>
                  </a>
                </div>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>
        </section>
      <?php endif; ?>
    </div>
              </section>
  </section>
  <?php elseif (get_row_layout() == 'plus_banner'): ?>
    <?php 
    // Get the banner text or use default
    $banner_text = get_sub_field('banner_text'); 
    if (empty($banner_text)) {
        $banner_text = '+ + + + + + + + + + +'; // Default value
    }
    ?>
    <section class="plus-banner-section">
        <div class="plus-divider-banner">
            <?php echo esc_html($banner_text); ?>
        </div>
    </section>
<?php elseif (get_row_layout() == 'our_fur_section'): ?>
  <?php $bg = get_sub_field('fur_background'); ?>
  <section class="our-fur-section" style="background-image: url('<?php echo esc_url($bg['url']); ?>'); background-size: cover; background-position: center;">
    <div class="fur-container">
      <h2 class="section-title"><?php the_sub_field('section_title'); ?></h2>
      <?php if (have_rows('fur_members_repeater')): ?>
        <div class="fur-members-grid">
          <?php while (have_rows('fur_members_repeater')): the_row(); ?>
            <div class="fur-member">
              <h3 style="font-weight: bold;"><?php the_sub_field('fur_name'); ?></h3>
              <?php $photo = get_sub_field('fur_photo'); ?>
              <?php if ($photo): ?>
                <img src="<?php echo esc_url($photo['sizes']['medium']); ?>" alt="<?php echo esc_attr($photo['alt']); ?>">
              <?php endif; ?>
            <p><?php the_sub_field('fur_title'); ?></p>

            </div>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>
  <?php elseif (get_row_layout() == 'call_to_action_section'): ?>
<section class="call-to-action-section">
    <div class="cta-container">
        <?php $image = get_sub_field('section_image'); ?>
        <?php if ($image): ?>
            <div class="cta-image-wrapper">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="cta-main-image">
            </div>
        <?php endif; ?>

   <h2 class="cta-title" style="color: white;"><?php the_sub_field('main_title'); ?></h2>

        <?php if (have_rows('star_icons_repeater')): ?>
            <div class="cta-stars">
                <?php while (have_rows('star_icons_repeater')): the_row(); ?>
                    <span class="star-icon">+</span>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <p class="cta-text"><?php the_sub_field('sub_text'); ?></p>

        <?php 
        $button_text = get_sub_field('button_text');
        $button_link = get_sub_field('button_link');
        if ($button_text && $button_link): ?>
            <div class="cta-button-wrapper">
                <a href="<?php echo esc_url($button_link); ?>" class="cta-button">
                    <?php echo esc_html($button_text); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>



    <?php endwhile; ?>
  <?php endif; ?>
  
</main>

<?php get_footer(); ?>
