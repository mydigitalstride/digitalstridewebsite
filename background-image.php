<?php
$background_image = get_field('x_image');
if ($background_image):
?>
  <section class="x-background-wrap-section">
    <div class="x-background-image">
      <img src="<?php echo esc_url($background_image['url']); ?>" alt="<?php echo esc_attr($background_image['alt']); ?>">
    </div>
  </section>
<?php endif; ?>
