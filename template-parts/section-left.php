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


