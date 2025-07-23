<aside class="floating-sidebar">
  <div class="sidebar-inner">
    <div class="sidebar-intro">
      <h3><?php the_sub_field('heading'); ?></h3>
      <p><?php the_sub_field('subheading'); ?></p>
    </div>

    <div class="sidebar-search">
      <input type="text" placeholder="<?php the_sub_field('search'); ?>" />
      <button><i class="fas fa-search"></i></button>
    </div>

    <div class="sidebar-social">
      <?php if ($fb = get_sub_field('facebook_link')): ?>
        <a href="<?php echo esc_url($fb); ?>" class="social-icon fb" target="_blank"></a>
      <?php endif; ?>
      <?php if ($ig = get_sub_field('instagram_link')): ?>
        <a href="<?php echo esc_url($ig); ?>" class="social-icon ig" target="_blank"></a>
      <?php endif; ?>
      <?php if ($li = get_sub_field('linkedin_link')): ?>
        <a href="<?php echo esc_url($li); ?>" class="social-icon li" target="_blank"></a>
      <?php endif; ?>
    </div>

    <div class="sidebar-posts">
<?php while (have_rows('post_buttons')): the_row(); ?>
        <?php 
          $text = get_sub_field('button_text');
          $link = get_sub_field('button_link');
          $color = get_sub_field('button_color');
        ?>
        <a href="<?php echo esc_url($link); ?>" class="post-button <?php echo esc_attr($color); ?>">
          <?php echo esc_html($text); ?>
        </a>
      <?php endwhile; ?>
    </div>

    <div class="sidebar-footer">
      <p><?php the_sub_field('footer_text'); ?></p>
    </div>
  </div>
</aside>
