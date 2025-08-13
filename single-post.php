<?php
/**
 * Single Post Template — text LEFT, image RIGHT (full-bleed hero)
 */
get_header();

$fallback_img = get_stylesheet_directory_uri() . '/images/Pattern.png';
$archive_url  = get_post_type_archive_link('post') ?: home_url('/blog/');
?>

<main id="primary" class="site-main ds-single">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <!-- HERO (full width) -->
  <section class="ds-hero">
    <div class="ds-hero__inner">

      <!-- TEXT (LEFT) -->
      <div class="ds-hero__text">
        <span class="ds-hero__kicker">+</span>
        <h1 class="ds-hero__title"><?php the_title(); ?></h1>
        <?php
          $ds_excerpt = get_the_excerpt();
          if ( empty($ds_excerpt) ) {
            $ds_excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), 35, '…' );
          }
        ?>
        <p class="ds-hero__excerpt"><?php echo esc_html( $ds_excerpt ); ?></p>

        <div class="ds-hero__meta">
          <span class="ds-meta__item"><?php echo get_the_date(); ?></span>
          <span class="ds-meta__dot">•</span>
          <span class="ds-meta__item"><?php the_author(); ?></span>
          <?php if ( $cats = get_the_category() ) : ?>
            <span class="ds-meta__dot">•</span>
            <span class="ds-meta__item"><?php echo esc_html( $cats[0]->name ); ?></span>
          <?php endif; ?>
        </div>
      </div>

      <!-- IMAGE (RIGHT) -->
      <div class="ds-hero__media">
        <?php if ( has_post_thumbnail() ) : ?>
          <?php the_post_thumbnail( 'large', [
            'class' => 'ds-hero__img',
            'alt'   => esc_attr( get_the_title() )
          ] ); ?>
        <?php else : ?>
          <img class="ds-hero__img"
               src="<?php echo esc_url( $fallback_img ); ?>"
               alt="<?php echo esc_attr( get_the_title() ); ?>"
               loading="lazy" />
        <?php endif; ?>
      </div>

    </div>
  </section>

  <!-- BODY (custom wrapper, NOT .container) -->
  <section class="ds-body">
    <div class="ds-content-wrap">
      <article id="post-<?php the_ID(); ?>" <?php post_class('ds-post-content'); ?>>
        <?php the_content(); ?>
        <?php wp_link_pages([
          'before' => '<div class="page-links">' . esc_html__('Pages:', 'your-theme'),
          'after'  => '</div>',
        ]); ?>
      </article>

      <div class="ds-post-actions">
        <a class="ds-btn ds-btn--primary" href="<?php echo esc_url( $archive_url ); ?>">
          View More Posts
        </a>
      </div>
    </div>
  </section>

<?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
