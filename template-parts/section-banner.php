<section class="plus-divider-banner">
  <?php 
    $banner_text = get_sub_field('banner_text');
    $display_text = $banner_text ? $banner_text : '+ + + + + + + + + + +';
  ?>
  <div class="plus-banner-text">
    <?php echo esc_html($display_text); ?>
  </div>
</section>
