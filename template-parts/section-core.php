<?php
    $background_image = get_sub_field('side_image');
    $side_image_url = $background_image ? esc_url($background_image['url']) : 'https://staging8.mydigitalstride.com/wp-content/uploads/2024/10/Treasure-Chest-Sketch.png';
?>

<section class="values-section">
  <div class="values-bubble">
    <div class="values-left" style="--dynamic-background-url: url('<?php echo $side_image_url; ?>');">
        <h2><?php the_sub_field('values_title'); ?></h2>
        <div class="val-plus-icon">+ + + + + + +</div>

        <?php $cta_link = get_sub_field('beliefs_cta_link'); ?>
        <?php if ($cta_link): ?>
            <a href="<?php echo esc_url($cta_link); ?>" class="values-cta" role="button">
                <?php the_sub_field('beliefs_cta_text'); ?>
            </a>
        <?php endif; ?>
    </div>
    <div class="values-right">
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

