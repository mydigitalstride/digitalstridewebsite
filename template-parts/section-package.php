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