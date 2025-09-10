<section class="quote-calculator">
  <div class="quote-calculator-inner">
    
    <?php if ($quote_heading = get_sub_field('quote_heading')): ?>
      <h2 class="quote-heading"><?php echo esc_html($quote_heading); ?></h2>
    <?php endif; ?>

    <?php if ($subheading = get_sub_field('subheading')): ?>
      <p class="quote-subheading"><?php echo esc_html($subheading); ?></p>
    <?php endif; ?>

    <div class="quote-form-wrap">
      <?php if ($shortcode = get_sub_field('form_shortcode')): ?>
        <?php echo do_shortcode($shortcode); ?>
      <?php else: ?>
        <p><em>No shortcode found. Add one in ACF.</em></p>
      <?php endif; ?>
    </div>

  </div>
</section>
