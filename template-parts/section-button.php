<section class="cta-button-section">
  <?php
    $cta_text = get_sub_field('cta_button_text');
    $cta_url  = get_sub_field('cta_button_url');
  ?>

  <?php if ($cta_text && $cta_url): ?>
    <a class="cta-button" href="<?php echo esc_url($cta_url); ?>">
      <?php echo esc_html($cta_text); ?>
    </a>
  <?php endif; ?>
</section>
