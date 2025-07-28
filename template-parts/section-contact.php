<?php
$shared_bg = get_sub_field('x_image');
$shared_bg_style = '';
if ($shared_bg) {
    $image_url = esc_url($shared_bg['url']);
    $shared_bg_style = 'style="background-image: url(\'' . $image_url . '\'); background-size: cover; background-position: center;"';
}
?>
<section class="contact-flex-section" <?php echo $shared_bg_style; ?>>
  <div class="contact-left">
    <h3><?php the_sub_field('section_title_left'); ?></h3>
    <p class="subtitle"><?php the_sub_field('subtitle_left'); ?></p>

    <div class="cf7-form-wrap">
      <?php echo do_shortcode(get_sub_field('form_shortcode')); ?>
    </div>
  </div>

  <div class="contact-right">
    <h3><?php the_sub_field('section_title_right'); ?></h3>
    <p class="subtitle"><?php the_sub_field('subtitle_right'); ?></p>

    <ul class="contact-info">
      <li><strong>✚</strong> <?php the_sub_field('contact_email'); ?></li>
      <li><strong>✚</strong> <?php the_sub_field('contact_phone'); ?></li>
      <li><strong>✚</strong> <?php the_sub_field('contact_address'); ?></li>
    </ul>

    <button class="orange-button"><?php the_sub_field('button_text_right'); ?></button>
  </div>
</section>
