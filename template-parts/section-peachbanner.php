<?php if (get_row_layout() == 'peach_banner'): ?>
  <?php $banner_text = get_sub_field('banner_text'); ?>
  <section class="peach-banner">
    <div class="peach-banner-text">
      <?php echo esc_html($banner_text); ?>
    </div>
  </section>
<?php endif; ?>
