<?php
/**
 * Posts grid Blog Post page
 */

/* ----------------- CONFIG ----------------- */
$posts_per_page  = 6;            // how many per page
$category_slug   = '';           // filter by category slug, e.g. 'news' — or '' for all
$selected_ids    = [];           // e.g. [12,45,78] to force specific posts/order; leave [] for latest
/* --------------- /CONFIG ------------------ */

$paged = max( 1, get_query_var('paged') ?: get_query_var('page') ?: 1 );

// Build query
if ( !empty($selected_ids) ) {
  $args = [
    'post_type'           => 'post',
    'post__in'            => array_map('intval', $selected_ids),
    'orderby'             => 'post__in',
    'posts_per_page'      => $posts_per_page,
    'ignore_sticky_posts' => true,
  ];
} else {
  $args = [
    'post_type'           => 'post',
    'posts_per_page'      => $posts_per_page,
    'paged'               => $paged,
    'ignore_sticky_posts' => true,
  ];
  if ( $category_slug ) {
    $args['category_name'] = $category_slug; 
  }
}

$q = new WP_Query($args);
?>

<section class="featured-cards-section">
  <div class="container">
    <div class="featured-cards-wrap">
      <?php if ( $q->have_posts() ) : while ( $q->have_posts() ) : $q->the_post(); ?>
        <article class="featured-card">
          <a class="card-media" href="<?php the_permalink(); ?>">
            <?php if ( has_post_thumbnail() ) {
              the_post_thumbnail('medium_large', ['alt'=>esc_attr(get_the_title())]);
            } else { ?>
              <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/default.jpg' ); ?>" alt="">
            <?php } ?>
          </a>

          <div class="card-body">
            <h3 class="card-title">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>

            <p class="card-excerpt">
              <?php echo esc_html( wp_trim_words( get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 22, '…' ) ); ?>
            </p>

            <a class="btn btn-readmore card-button" href="<?php the_permalink(); ?>">Read More</a>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); else: ?>
        <p>No posts found.</p>
      <?php endif; ?>
    </div>

    <?php if ( $q->max_num_pages > 1 ): ?>
      <div class="view-more-wrap">
        <?php next_posts_link( '<span class="btn btn-view-more">View More Posts</span>', $q->max_num_pages ); ?>
      </div>
    <?php endif; ?>
  </div>
</section>
