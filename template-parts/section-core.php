<section class="values-section">
  <div class="values-bubble">
    <h2><?php the_sub_field('values_title'); ?></h2>
    <div class="val-plus-icon">+ + + + + + +</div>

    <?php $side_image = get_sub_field('side_image'); ?>
    <?php if ($side_image): ?>
      <div class="values-background-image">
        <img src="<?php echo esc_url($side_image['url']); ?>" alt="<?php echo esc_attr($side_image['alt']); ?>">
      </div>
    <?php endif; ?>

    <?php $cta_link = get_sub_field('beliefs_cta_link'); ?>
    <?php if ($cta_link): ?>
      <a href="<?php echo esc_url($cta_link); ?>" class="values-cta" role="button">
        <?php the_sub_field('beliefs_cta_text'); ?>
      </a>
    <?php endif; ?>

    <div class="values-list">
      <?php if (have_rows('core_values')): ?>
        <?php while (have_rows('core_values')): the_row(); ?>
          <?php 
            $title = get_sub_field('core_value');
            $description = get_sub_field('description');
          ?>
          <div class="value-block">
            <div class="value-item toggle-button">
              <p class="value-title"><?php echo esc_html($title); ?></p>
            </div>
            <?php if ($description): ?>
              <div class="value-description"><?php echo esc_html($description); ?></div>
            <?php endif; ?>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const blocks = document.querySelectorAll(".value-block");

    blocks.forEach(block => {
      const button = block.querySelector(".value-item");
      button.addEventListener("click", () => {
        // Optional: close others
        blocks.forEach(b => {
          if (b !== block) b.classList.remove("open");
        });

        block.classList.toggle("open");
      });
    });
  });
</script>

