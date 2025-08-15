<?php
/**
 * Resource Listing (single group)
 */

$header   = get_sub_field('listing_header');
$icons    = get_sub_field('listing_plus_icons');

$post_type  = 'post'; // blog posts
$per_page   = (int)(get_sub_field('posts_per_section') ?: 4);
$btn_text   = trim(get_sub_field('listing_button_text') ?: 'Read More');
$view_all   = get_sub_field('view_all_link');

// Stable anchor id
$manual_anchor = trim((string) get_sub_field('section_anchor'));
$anchor_id     = $manual_anchor !== '' ? sanitize_title($manual_anchor)
                                       : sanitize_title($header ?: 'section');

/** Map anchor -> category slug */
if (!function_exists('ds_anchor_to_cat')) {
  function ds_anchor_to_cat($anchor_slug) {
    $slug = sanitize_title($anchor_slug);
    // Hard mapping for your site’s anchors -> WP category slugs
    $map = [
      'marketing-resources'       => 'marketing',
      'digital-marketing-guides'  => 'guides',
      'small-business-resources'  => 'small-business',
      'entrepreneurship'          => 'entrepreneurship',
      'exp-1st-news'              => 'exp-1st-news',
    ];
    if (isset($map[$slug])) return $map[$slug];

    // Generic fallback: strip common suffixes and try that as a category
    $base = preg_replace('/-(resources?|guides?|news|posts?)$/', '', $slug);
    if ($base && term_exists($base, 'category')) return $base;

    return ''; // no match -> show latest
  }
}

$cat_slug = ds_anchor_to_cat($anchor_id);

/** Optional: keep posts unique across sections */
static $already_shown_ids = [];

$args = [
  'post_type'           => $post_type,
  'posts_per_page'      => $per_page,
  'ignore_sticky_posts' => true,
  'orderby'             => 'date',
  'order'               => 'DESC',
  'post__not_in'        => $already_shown_ids,
];

if ($cat_slug) {
  // Use term ID to avoid slug edge cases
  $term = get_term_by('slug', $cat_slug, 'category');
  if ($term && !is_wp_error($term)) {
    $args['cat'] = (int) $term->term_id;
  }
}

$q = new WP_Query($args);
?>
<section id="<?php echo esc_attr($anchor_id); ?>" class="resource-listing-section">
  <?php if ($header): ?><h3 class="listing-header"><?php echo esc_html($header); ?></h3><?php endif; ?>
  <?php if ($icons): ?><div class="plus-icon-listing"><?php echo esc_html($icons); ?></div><?php endif; ?>

  <div class="listing-wrapper">
    <?php if ($q->have_posts()): while ($q->have_posts()): $q->the_post();
      $already_shown_ids[] = get_the_ID(); ?>
      <a class="listing-card" href="<?php the_permalink(); ?>">
        <h3><?php the_title(); ?></h3>
        <p>
          <?php
            $excerpt = get_the_excerpt();
            echo esc_html( wp_trim_words( $excerpt ?: wp_strip_all_tags(get_the_content()), 26, '…' ) );
          ?>
        </p>
        <span class="listing-btn"><?php echo esc_html($btn_text); ?></span>
      </a>
    <?php endwhile; wp_reset_postdata(); else: ?>
      <div class="listing-card no-results">
        <h3>No items found</h3>
        <p>Try adjusting this section’s anchor-to-category mapping.</p>
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

  <!-- debug (remove after testing):
  anchor=<?php echo esc_html($anchor_id); ?> cat=<?php echo esc_html($cat_slug); ?>
  -->
</section>
