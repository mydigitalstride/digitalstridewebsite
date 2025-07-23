<?php if (have_rows('resource_cards')): ?>
  <section class="resource-cards-section">
    <h2 class="section-heading">Find Your Resource</h2>
    <div class="card-wrapper">
      <?php while (have_rows('resource_cards')): the_row(); ?>
        <div class="resource-card">
          <div class="card-content">
            <h3><?php the_sub_field('resource_title'); ?></h3>
            <div class="decor-line">+ + + + +</div>
            <p><?php the_sub_field('resource_description'); ?></p>
          </div>
          <?php 
            $icon = get_sub_field('resource_icon');
            if ($icon): ?>
            <div class="card-icon">
              <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr(get_sub_field('resource_title')); ?>">
            </div>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>
  </section>
<?php endif; ?>
