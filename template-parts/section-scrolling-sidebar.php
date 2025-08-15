<?php
/**
 * Scrolling Sidebar — matches your ACF:
 * heading (text), subheading (text), search (true_false or text),
 * facebook_link (url), instagram_link (url), linkedin_link (url),
 * post_buttons (repeater: button_text (text), button_link (url), color_style (select)),
 * footer_text (text)
 */

// helper: cast mixed truthy to bool (supports true_false or text like "1","true")
$to_bool = function($v) {
  if (is_bool($v)) return $v;
  return filter_var((string)$v, FILTER_VALIDATE_BOOLEAN);
};

// fields
$heading     = get_sub_field('heading');
$subheading  = get_sub_field('subheading');
$show_search = $to_bool(get_sub_field('search'));

$fb_url = esc_url((string) get_sub_field('facebook_link'));
$ig_url = esc_url((string) get_sub_field('instagram_link'));
$li_url = esc_url((string) get_sub_field('linkedin_link'));

$footer_text = get_sub_field('footer_text');
?>

<aside class="floating-sidebar" aria-label="Latest posts, links and updates">
  <div class="sidebar-inner">

    <?php if ($heading): ?>
      <h3 class="sb-h"><?php echo esc_html($heading); ?></h3>
    <?php endif; ?>

    <?php if ($subheading): ?>
      <p class="sb-sub"><?php echo esc_html($subheading); ?></p>
    <?php endif; ?>

    <?php if ($show_search): ?>
      <div class="sb-search"><?php get_search_form(); ?></div>
    <?php endif; ?>

    <?php if ($fb_url || $ig_url || $li_url): ?>
      <div class="sb-social">
        <?php if ($fb_url): ?><a class="sb-ico sb-ico-fb" href="<?php echo $fb_url; ?>" aria-label="Facebook"></a><?php endif; ?>
        <?php if ($ig_url): ?><a class="sb-ico sb-ico-ig" href="<?php echo $ig_url; ?>" aria-label="Instagram"></a><?php endif; ?>
        <?php if ($li_url): ?><a class="sb-ico sb-ico-in" href="<?php echo $li_url; ?>" aria-label="LinkedIn"></a><?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="sb-latest">
      <div class="sb-label"></div>
      <?php
      $latest = new WP_Query([
        'post_type'           => 'post',
        'posts_per_page'      => 5,
        'ignore_sticky_posts' => true,
        'orderby'             => 'date',
        'order'               => 'DESC',
      ]);
      if ($latest->have_posts()):
        echo '<ul class="sb-list">';
        while ($latest->have_posts()): $latest->the_post();
          echo '<li><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></li>';
        endwhile;
        echo '</ul>';
        wp_reset_postdata();
      endif;
      ?>
    </div>

    <?php if ($footer_text): ?>
      <p class="sb-foot"><?php echo esc_html($footer_text); ?></p>
    <?php endif; ?>

  </div>
</aside>
