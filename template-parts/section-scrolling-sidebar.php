<?php
/**
 * Scrolling Sidebar (latest 3 posts; colors from repeater; chip links to newest post)
 */

$heading = get_sub_field('heading');
$sub     = get_sub_field('subheading');
$fb      = get_sub_field('facebook_link');
$ig      = get_sub_field('instagram_link');
$li      = get_sub_field('linkedin_link');
$desc    = get_sub_field('description');   // optional
$footer  = get_sub_field('footer_text');   // optional

// Read only color_style from repeater (row order matters)
$color_styles = [];
if (have_rows('post_buttons')) {
  while (have_rows('post_buttons')) { the_row();
    $c = strtolower((string) get_sub_field('color_style'));
    $c = $c ? preg_replace('/[^a-z0-9\-]/', '', $c) : '';
    if ($c) { $color_styles[] = $c; }
  }
}
$fallback_colors = ['teal','blue','peach'];

// Latest 3 posts (we'll also use the first one for the chip link)
$q = new WP_Query([
  'post_type'           => 'post',
  'posts_per_page'      => 3,
  'ignore_sticky_posts' => 1,
  'no_found_rows'       => true,
]);

// Compute "latest post" URL for the chip
$latest_url = '';
if (!empty($q->posts) && isset($q->posts[0]->ID)) {
  $latest_url = get_permalink($q->posts[0]->ID);
} else {
  // Fallback to Posts page if set, otherwise home
  $blog_page_id = (int) get_option('page_for_posts');
  $latest_url   = $blog_page_id ? get_permalink($blog_page_id) : home_url('/');
}
?>

<aside class="resources-sidebar" aria-label="Resources quick actions">
  <div class="sidebar-inner">

    <?php if ($heading): ?>
      <h4 class="sidebar-title"><?php echo esc_html($heading); ?></h4>
    <?php endif; ?>

    <?php if ($sub): ?>
      <p class="sidebar-sub"><?php echo esc_html($sub); ?></p>
    <?php endif; ?>

    <!-- Latest posts chip → links directly to newest post -->
    <a class="latest-posts-chip" href="<?php echo esc_url($latest_url); ?>">
      <span>Latest posts</span>
      <!-- swap the icon as you like; or remove the <i> entirely -->
      <i class="fa-regular fa-newspaper" aria-hidden="true"></i>
      <span class="screen-reader-text">Open the newest blog post</span>
    </a>

    <?php if ($fb || $ig || $li): ?>
      <div class="sidebar-social" role="group" aria-label="Social links">
        <?php if ($fb): ?>
          <a href="<?php echo esc_url($fb); ?>" class="social-btn" aria-label="Facebook" target="_blank" rel="noopener">
            <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
          </a>
        <?php endif; ?>
        <?php if ($ig): ?>
          <a href="<?php echo esc_url($ig); ?>" class="social-btn" aria-label="Instagram" target="_blank" rel="noopener">
            <i class="fa-brands fa-instagram" aria-hidden="true"></i>
          </a>
        <?php endif; ?>
        <?php if ($li): ?>
          <a href="<?php echo esc_url($li); ?>" class="social-btn" aria-label="LinkedIn" target="_blank" rel="noopener">
            <i class="fa-brands fa-linkedin-in" aria-hidden="true"></i>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($q->have_posts()) : ?>
      <div class="sidebar-ctas">
        <?php $i = 0;
        while ($q->have_posts()) : $q->the_post();
          $color_key = isset($color_styles[$i]) ? $color_styles[$i] : $fallback_colors[$i % count($fallback_colors)];
          $class = 'cta-' . $color_key; ?>
          <a class="sidebar-cta <?php echo esc_attr($class); ?>" href="<?php the_permalink(); ?>">
            <?php echo esc_html( wp_trim_words( get_the_title(), 10, '…' ) ); ?>
          </a>
        <?php $i++; endwhile; wp_reset_postdata(); ?>
      </div>
    <?php endif; ?>

    <?php if ($desc): ?>
      <p class="sidebar-desc"><?php echo esc_html($desc); ?></p>
    <?php endif; ?>

    <?php if ($footer): ?>
      <div class="sidebar-footer">
        <?php echo wpautop( wp_kses_post( $footer ) ); ?>
      </div>
    <?php endif; ?>

  </div>
</aside>
