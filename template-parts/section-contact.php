<?php
$shared_bg = get_sub_field('x_image');
$shared_bg_style = '';
if ($shared_bg) {
    $image_url = esc_url($shared_bg['url']);
    $shared_bg_style = 'style="background-image: url(\'' . $image_url . '\'); background-size: cover; background-position: center;"';
}

$btn_text = trim((string) get_sub_field('button_text_right'));
$btn_link = get_sub_field('button_link_right'); // ACF Link field (Array: url,title,target)

// Fallback: scroll to the form on the left if no link set
$anchor_id = 'book-consultation';
$href   = (is_array($btn_link) && !empty($btn_link['url'])) ? esc_url($btn_link['url']) : '#'.$anchor_id;
$target = (is_array($btn_link) && !empty($btn_link['target'])) ? $btn_link['target'] : '_self';
$label  = $btn_text ?: 'Book your consultation';
?>
<section class="contact-flex-section" <?php echo $shared_bg_style; ?>>
  <div class="contact-left">
    <h3><?php the_sub_field('section_title_left'); ?></h3>
    <p class="subtitle"><?php the_sub_field('subtitle_left'); ?></p>

    <div class="cf7-form-wrap" id="<?php echo esc_attr($anchor_id); ?>">
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

    <!-- same class name -->
    <a class="orange-button"
       href="<?php echo $href; ?>"
       target="<?php echo esc_attr($target); ?>"
       <?php echo ($target === '_blank') ? 'rel="noopener"' : ''; ?>
       aria-label="<?php echo esc_attr($label); ?>">
      <?php echo esc_html($label); ?>
    </a>
  </div>
</section>
