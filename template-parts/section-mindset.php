<section class="ds-mindset-section">
  <div class="ds-mindset-bubble">
    <div class="ds-mindset-heading">
      <h2><?php the_sub_field('mindset_title'); ?></h2>
      <div class="ds-plus-icon">+ + + + + + +</div>
    </div>

    <div class="ds-mindset-list">
      <?php if (have_rows('bullet_points_repeater')): ?>
        <ul class="ds-mindset-items">
          <?php while (have_rows('bullet_points_repeater')): the_row(); ?>
            <?php 
              $point_title = get_sub_field('point_title'); 
              $point_content = get_sub_field('point_content');
            ?>
            <li class="ds-mindset-block">
              <div class="ds-mindset-item toggle-button">
                <div class="ds-mindset-title"><?php echo esc_html($point_title); ?></div>
              </div>
              <?php if (!empty($point_content)): ?>
                <div class="ds-point-content-outside"><?php echo wp_kses_post($point_content); ?></div>
              <?php endif; ?>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const mindsetBlocks = document.querySelectorAll(".ds-mindset-block");

    mindsetBlocks.forEach(block => {
      const button = block.querySelector(".ds-mindset-item");
      button.addEventListener("click", () => {
        // Optional: close others
        mindsetBlocks.forEach(b => {
          if (b !== block) b.classList.remove("open");
        });

        block.classList.toggle("open");
      });
    });
  });
</script>
