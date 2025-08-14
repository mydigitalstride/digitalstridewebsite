<?php
/**
 * Resource Listing (single group)
 */

$header      = get_sub_field('listing_header');
$icons       = get_sub_field('listing_plus_icons');

$post_type   = trim(get_sub_field('posts_post_type') ?: 'post');
$source      = get_sub_field('posts_source') ?: 'latest';
$per_page    = (int)(get_sub_field('posts_per_section') ?: 4);
$cat_slug    = trim(get_sub_field('posts_category_slug') ?: '');
$tag_slug    = trim(get_sub_field('posts_tag_slug') ?: '');
$selected    = get_sub_field('posts_selected') ?: [];
$btn_text    = trim(get_sub_field('listing_button_text') ?: 'Read More');
$view_all    = get_sub_field('view_all_link');


$base_id     = $header ? sanitize_title($header) : 'section';
$unique_id   = $base_id . '-' . get_row_index(); 

// Build query
$args = [
  'post_type'           => $post_type,
  'posts_per_page'      => $per_page,
  'ignore_sticky_posts' => true,
];

switch ($source) {
  case 'category':
    if ($cat_slug) { $args['category_name'] = $cat_slug; }
    break;
  case 'tag':
    if ($tag_slug) { $args['tag'] = $tag_slug; }
    break;
  case 'selected':
    if (!empty($selected)) {
      $args['post__in'] = array_map('intval', wp_list_pluck($selected, 'ID'));
      $args['orderby']  = 'post__in';
      if ($per_page <= 0 || $per_page > count($args['post__in'])) {
        $args['posts_per_page'] = count($args['post__in']);
      }
    } else {
      $args['post__in'] = [0]; 
    }
    break;
  case 'latest':
  default:
    // no extra filters
    break;
}

$q = new WP_Query($args);
?>

<section id="<?php echo esc_attr($unique_id); ?>" class="resource-listing-section">
  <?php if ($header): ?>
    <h3 class="listing-header"><?php echo esc_html($header); ?></h3>
  <?php endif; ?>

  <?php if ($icons): ?>
    <div class="plus-icon-listing"><?php echo esc_html($icons); ?></div>
  <?php endif; ?>

  <div class="listing-wrapper">
    <?php if ($q->have_posts()): while ($q->have_posts()): $q->the_post(); ?>
      <a class="listing-card" href="<?php the_permalink(); ?>">
        <h3><?php the_title(); ?></h3>
        <p>
          <?php
            $excerpt = get_the_excerpt();
            if (empty($excerpt)) {
              $excerpt = wp_trim_words(wp_strip_all_tags(get_the_content()), 26, '…');
            } else {
              $excerpt = wp_trim_words($excerpt, 26, '…');
            }
            echo esc_html($excerpt);
          ?>
        </p>
        <span class="listing-btn"><?php echo esc_html($btn_text); ?></span>
      </a>
    <?php endwhile; wp_reset_postdata(); else: ?>
      <div class="listing-card no-results">
        <h3>No items found</h3>
        <p>Try adjusting this section’s source settings.</p>
      </div>
    <?php endif; ?>
  </div>

  <?php if (!empty($view_all['url'])): ?>
    <div class="listing-view-all">
      <a class="btn view-all-btn"
         href="<?php echo esc_url($view_all['url']); ?>"
         <?php if (!empty($view_all['target'])) echo 'target="'.esc_attr($view_all['target']).'"'; ?>
         <?php if (!empty($view_all['target']) && $view_all['target'] === '_blank') echo 'rel="noopener"'; ?>>
        <?php echo esc_html($view_all['title'] ?: 'View All'); ?>
      </a>
    </div>
  <?php endif; ?>
</section>
