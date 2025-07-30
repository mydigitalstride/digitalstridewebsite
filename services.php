<?php
/**
 * Template Name: Services Page
 * Description: Template for the Services page with flexible content sections.
 */

get_header(); ?>

<main id="main" class="site-main">

<?php
if (have_rows('services_sections')):

    while (have_rows('services_sections')): the_row();

        // Section: Header
        if (get_row_layout() == 'section_header'): ?>
            <section class="section-container">
                <div class="hero-text">
                    <div class="hero-left">
                        <h2 class="section-title"><?php the_sub_field('section_title'); ?></h2>
                        <div class="section-content"><?php the_sub_field('content'); ?></div>
                    </div>
                    <div class="hero-right">
                        <img class="section-image" src="<?php the_sub_field('section_image'); ?>" alt="img">
                    </div>
                </div>
            </section>

        <?php
        // Section: Bubbles
        elseif (get_row_layout() == 'bubbles_section'):
            $bg_image = get_sub_field('background_image'); ?>
            <section class="bubbles-row"<?php if ($bg_image): ?> style="background-image: url('<?php echo esc_url($bg_image['url']); ?>');"<?php endif; ?>>
                <?php if (have_rows('bubbles')): ?>
                    <?php 
                        $count = 0;
                        while (have_rows('bubbles') && $count < 3): the_row(); 
                            $count++;
                    ?>
                        <div class="bubble">
    <?php $image = get_sub_field('bubble_image'); ?>
    <?php if ($image): ?>
        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="bubble-images" />
    <?php endif; ?>
    
    <h3 class="bubble-header"><?php echo esc_html(get_sub_field('bubble_header')); ?></h3>
    
    <p class="bubble-text"><?php the_sub_field('bubble_text'); ?></p>
    
    <?php if (get_sub_field('bubble_subtext')): ?>
        <p class="bubble-subtext"><?php echo esc_html(get_sub_field('bubble_subtext')); ?></p>
    <?php endif; ?>
</div>

                    <?php endwhile; ?>
                <?php endif; ?>
            </section>

        <?php
        // Section: Package
        elseif (get_row_layout() == 'package'): 
            // $package_bg_image = get_sub_field('package_background_image'); ?>
            <section class="package-section">
                <img class="package-background-image" src="<?php the_sub_field('package_background_image'); ?>" alt="img">
                <div class="package-header">
                    <h2 class="package-title"><?php the_sub_field('package_title'); ?></h2>
                    <?php if (get_sub_field('package_sub_title_')): ?>
                        <h3 class="package-subtitle"><?php the_sub_field('package_sub_title_'); ?></h3>
                    <?php endif; ?>
                </div>
                <?php if (have_rows('package_text')): ?>
                    <div class="package-items-wrapper">
                        <ul class="package-list">
                            <?php while (have_rows('package_text')): the_row(); ?>
                                <li class="package-item">
                                    <?php if (get_sub_field('package_image')): ?>
                                        <div class="package-item-image">
                                            <img src="<?php echo esc_url(get_sub_field('package_image')['url']); ?>" alt="<?php echo esc_attr(get_sub_field('package_image')['alt']); ?>" class="package-icon">
                                        </div>
                                    <?php endif; ?>
                                    <div class="package-item-content">
                                        <h4 class="package-item-header"><?php the_sub_field('package_header'); ?></h4>
                                        <p class="package-item-desc"><?php the_sub_field('package_sub'); ?></p>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </section>

        <?php
        // Section: Concept
        elseif (get_row_layout() == 'concept'): 
            $concept_title = get_sub_field('concept_title');
            $concept_subtitle = get_sub_field('concept_subtitle');
            $concept_list = get_sub_field('concept_list');
            $concept_image = get_sub_field('concept_image');
        ?>
            <section class="concept-launch-section"<?php if ($concept_image): ?> style="background-image: url('<?php echo esc_url($concept_image['url']); ?>');"<?php endif; ?>>
                <div class="container">
                    <div class="concept-layout">
                        <div class="concept-left">
                            <?php if ($concept_title): ?>
                                <h2 class="concept-title"><?php echo esc_html($concept_title); ?></h2>
                            <?php endif; ?>
                            <?php if ($concept_subtitle): ?>
                                <h4 class="concept-subtitle"><?php echo esc_html($concept_subtitle); ?></h4>
                            <?php endif; ?>
                        </div>
                        <div class="concept-right">
                            <?php if ($concept_list): ?>
                                <div class="concept-list">
                                    <?php foreach ($concept_list as $index => $row): ?>
                                        <div class="concept-step <?php echo $index === 2 ? 'highlight-step' : ''; ?>">
                                            <p><?php echo esc_html($row['concept_text']); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>

        <?php
        // Section: Timeline Scope
        elseif (get_row_layout() == 'timeline_scope'):
            $timeline_bg_image = get_sub_field('timeline_background_image');
            $timeline_title = get_sub_field('title');
            $left_duration = get_sub_field('timeline_duration_left');
            $right_duration = get_sub_field('timeline_duration_right');
            $image = get_sub_field('scope_image');
        ?>
            <section class="timeline-scope"<?php if ($timeline_bg_image): ?> style="background-image: url('<?php echo esc_url($timeline_bg_image['url']); ?>'); background-size: cover; background-position: center;"<?php endif; ?>>
                <h2 class="timeline-heading"><?php echo esc_html($timeline_title); ?></h2>

                <div class="timeline-bar">
                    <span class="circle"></span>
                    <span class="circle"></span>
                    <span class="circle"></span>
                </div>

                <div class="timeline-labels">
                    <span class="left-label"><?php echo esc_html($left_duration); ?></span>
                    <span class="right-label"><?php echo esc_html($right_duration); ?></span>
                </div>
            <div class="timeline-features-wrapper">
                <div class="timeline-features-list">
                    <ul>
                        <?php if (have_rows('timeline_features')): ?>
                            <?php while (have_rows('timeline_features')) : the_row(); ?>
                                <li><?php the_sub_field('feature_item'); ?></li>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <?php if ($image): ?>
                    <div class="timeline-features-image">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                    </div>
                <?php endif; ?>
            </div>
            </section>

        <?php
        // Section: Plus Divider Banner
        elseif (get_row_layout() == 'plus_banner'):
            $banner_text = get_sub_field('banner_text') ?: '+ + + + + + + + + + +';
        ?>
            <div class="plus-divider-banner">
                <?php echo esc_html($banner_text); ?>
            </div>

       <?php elseif (get_row_layout() == 'wordpress_services_section'): 
    $section_title = get_sub_field('section_title');
    $subheading = get_sub_field('subheading');
    $stat_value = get_sub_field('stat_value');
    $stat_subtext = get_sub_field('stat_subtext');
    $button_text = get_sub_field('button_text');
    $button_link = get_sub_field('button_link');
    $laptop_image = get_sub_field('laptop_image');
?>

<section class="wordpress-services-section">
  <div class="services-content">
    <div class="left-section">  
        <h2><?php echo esc_html($section_title); ?></h2>
        <div class="plus-divider">+ + + + + + + + + +</div>
        <p class="subheading"><?php echo esc_html($subheading); ?></p>

        <ul class="service-list">
        <?php if (have_rows('list_items')): while (have_rows('list_items')): the_row(); ?>
            <li><?php echo esc_html(get_sub_field('item_text')); ?></li>
        <?php endwhile; endif; ?>
        </ul>

        <?php if ($button_link): ?>
        <a href="<?php echo esc_url($button_link['url']); ?>" target="<?php echo esc_attr($button_link['target']); ?>" class="custom-cta-button">
            <?php echo esc_html($button_text); ?>
        </a>
        <?php endif; ?>
    </div>
    <div class="right-section">
        <div class="graphic-wrap">
            <?php if ($laptop_image): ?>
                <img src="<?php echo esc_url($laptop_image['url']); ?>" alt="Laptop Graphic" class="laptop-image" />
            <?php endif; ?>

            <div class="stat-box">
                <span class="stat-value"><?php echo esc_html($stat_value); ?></span>
                <span class="stat-subtext"><?php echo esc_html($stat_subtext); ?></span>
            </div>
        </div>
    </div>
  </div>
</section>
      <?php
        // Section: Plus Divider Banner
        elseif (get_row_layout() == 'plus_banner'):
            $banner_text = get_sub_field('banner_text') ?: '+ + + + + + + + + + +';
        ?>
            <div class="plus-divider-banner">
                <?php echo esc_html($banner_text); ?>
            </div>
<?php elseif (get_row_layout() == 'custom_website_development'): 
    $section_title = get_sub_field('custom_section_title');
    $subheading = get_sub_field('custom_subheading');
    $stat_value = get_sub_field('custom_stat_value');
    $stat_subtext = get_sub_field('custom_stat_subtext');
    $button_text = get_sub_field('custom_button_text');
    $button_link = get_sub_field('custom_button_link');
    $laptop_image = get_sub_field('custom_screw_image');
?>

<section class="custom_website_development">
  <div class="custom-services-content flipped-layout">
    
    <!-- 👈 Image on the LEFT -->
    <div class="custom-graphic-wrap">
      <?php if ($laptop_image): ?>
        <img src="<?php echo esc_url($laptop_image['url']); ?>" alt="Screw Graphic" class="custom-screw-image" />
      <?php endif; ?>

      <div class="custom-stat-box">
        <span class="custom-stat-value"><?php echo esc_html($stat_value); ?></span>
        <span class="custom-stat-subtext"><?php echo esc_html($stat_subtext); ?></span>
      </div>
    </div>

    <!-- 👉 Text on the RIGHT -->
    <div class="custom-text-wrap">
      <h2><?php echo esc_html($section_title); ?></h2>
      <div class="plus-divider">+ + + + + + + + + +</div>
      <p class="subheading"><?php echo esc_html($subheading); ?></p>

      <ul class="custom-service-list">
        <?php if (have_rows('custom_list_items')): while (have_rows('custom_list_items')): the_row(); ?>
          <li><?php echo esc_html(get_sub_field('custom_item_text')); ?></li>
        <?php endwhile; endif; ?>
      </ul>

      <?php if ($button_link): ?>
        <a href="<?php echo esc_url($button_link['url']); ?>" target="<?php echo esc_attr($button_link['target']); ?>" class="custom-cta-button">
          <?php echo esc_html($button_text); ?>
        </a>
      <?php endif; ?>
    </div>

  </div>
</section>
<?php

        // Section: Plus Divider Banner
        elseif (get_row_layout() == 'plus_banner'):
            $banner_text = get_sub_field('banner_text') ?: '+ + + + + + + + + + +';
        ?>
            <div class="plus-divider-banner">
                <?php echo esc_html($banner_text); ?>
            </div>
            <?php elseif (get_row_layout() == 'custom_website_development'): 
    $section_title = get_sub_field('section_title');
    $subheading = get_sub_field('subheading');
    $stat_value = get_sub_field('stat_value');
    $stat_subtext = get_sub_field('stat_subtext');
    $button_text = get_sub_field('button_text');
    $button_link = get_sub_field('button_link');
    $laptop_image = get_sub_field('laptop_image');
?>

<section class="custom_website_development">
  <div class="services-content">
    <div class="left-section">
        <h2><?php echo esc_html($section_title); ?></h2>
            <div class="plus-divider">+ + + + + + + + + +</div>
            <p class="subheading"><?php echo esc_html($subheading); ?></p>

            <ul class="service-list">
            <?php if (have_rows('list_items')): while (have_rows('list_items')): the_row(); ?>
                <li><?php echo esc_html(get_sub_field('item_text')); ?></li>
            <?php endwhile; endif; ?>
            </ul>

            <?php if ($button_link): ?>
            <a href="<?php echo esc_url($button_link['url']); ?>" target="<?php echo esc_attr($button_link['target']); ?>" class="custom-cta-button">
                <?php echo esc_html($button_text); ?>
            </a>
            <?php endif; ?>
    </div>
    <div class="right-section">
        <div class="graphic-wrap">
        <?php if ($laptop_image): ?>
            <img src="<?php echo esc_url($laptop_image['url']); ?>" alt="Laptop Graphic" class="laptop-image" />
        <?php endif; ?>

        <div class="stat-box">
            <span class="stat-value"><?php echo esc_html($stat_value); ?></span>
            <span class="stat-subtext"><?php echo esc_html($stat_subtext); ?></span>
        </div>
        </div>
    </div>
  </div>
</section>
<?php
        // Section: Plus Divider Banner
        elseif (get_row_layout() == 'plus_banner'):
            $banner_text = get_sub_field('banner_text') ?: '+ + + + + + + + + + +';
        ?>
            <div class="plus-divider-banner">
                <?php echo esc_html($banner_text); ?>
            </div>
            <?php
// ======= GROWTH SECTION ======= //
elseif (get_row_layout() == 'growth_section'): ?>
    <section class="growth-section">
        <div class="growth-left">
            <h2><?php the_sub_field('growth_heading'); ?></h2>
                  <?php if (get_sub_field('icon_plus')): ?>
          <span class="icon_plus">
            <?php the_sub_field('icon_plus'); ?>
          </span>
        <?php endif; ?>
            <div class="growth-sub">
                <p><?php the_sub_field('growth_subheading'); ?></p>
            </div>
        </div>
        <div class="growth-right">
            <?php
                $title = get_sub_field('growth_section_title');
                $words = explode(' ', $title);
                $first_two = array_slice($words, 0, 2);
                $rest = array_slice($words, 2);
                $highlighted_title = '<span class="highlight-orange">' . implode(' ', $first_two) . '</span> ' . implode(' ', $rest);
            ?>
            <h3><?php echo $highlighted_title; ?></h3>
            <div><?php the_sub_field('growth_section_content'); ?></div>
            <?php if ($button = get_sub_field('button_link')): ?>
                <a href="<?php echo esc_url($button['url']); ?>" class="custom-cta-button">
                    <?php the_sub_field('button_text'); ?>
                </a>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>


    <?php endwhile; // end of while have_rows
endif; // end of if have_rows
?>

</main>

<?php get_footer(); ?>