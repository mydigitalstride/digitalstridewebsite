<?php
/**
 * Single Event Template
 *
 * Displays full details for a single ds_event post.
 *
 * @package DigitalStride
 */

get_header();

$fallback_img    = get_stylesheet_directory_uri() . '/images/Pattern.png';
$archive_url     = get_post_type_archive_link( 'ds_event' ) ?: home_url( '/events/' );

while ( have_posts() ) : the_post();

    $raw_date = get_field( 'event_date' ); // Ymd
    $date_obj = $raw_date ? DateTime::createFromFormat( 'Ymd', $raw_date ) : null;
    $date_fmt = $date_obj ? $date_obj->format( 'F j, Y' ) : '';
    $time     = (string) get_field( 'event_time' );
    $location = (string) get_field( 'event_location' );
    $reg_link = (string) get_field( 'event_registration_link' );
    $desc     = get_field( 'event_description' );
    $photo    = get_field( 'event_photo' );

    $photo_url = $photo ? esc_url( $photo['url'] ) : '';
    $photo_alt = $photo ? esc_attr( $photo['alt'] ) : esc_attr( get_the_title() );
?>

<main id="primary" class="site-main ds-single ds-single-event">

    <!-- HERO -->
    <section class="ds-hero">
        <div class="ds-hero__inner">

            <div class="ds-hero__text">
                <span class="ds-hero__kicker">Event</span>
                <h1 class="ds-hero__title"><?php the_title(); ?></h1>

                <div class="ds-hero__meta">
                    <?php if ( $date_fmt ) : ?>
                        <span class="ds-meta__item">
                            <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                            <?php echo esc_html( $date_fmt . ( $time ? ' · ' . $time : '' ) ); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ( $location ) : ?>
                        <span class="ds-meta__dot">•</span>
                        <span class="ds-meta__item">
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            <?php echo esc_html( $location ); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <?php if ( $reg_link ) : ?>
                    <a class="ds-btn ds-btn--primary" href="<?php echo esc_url( $reg_link ); ?>" target="_blank" rel="noopener noreferrer">
                        Register Now
                    </a>
                <?php endif; ?>
            </div>

            <div class="ds-hero__media">
                <?php if ( $photo_url ) : ?>
                    <img class="ds-hero__img"
                         src="<?php echo esc_url( $photo_url ); ?>"
                         alt="<?php echo $photo_alt; ?>"
                         loading="lazy">
                <?php elseif ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'large', [
                        'class' => 'ds-hero__img',
                        'alt'   => esc_attr( get_the_title() ),
                    ] ); ?>
                <?php else : ?>
                    <img class="ds-hero__img"
                         src="<?php echo esc_url( $fallback_img ); ?>"
                         alt="<?php echo esc_attr( get_the_title() ); ?>"
                         loading="lazy">
                <?php endif; ?>
            </div>

        </div>
    </section>

    <!-- EVENT BODY -->
    <?php if ( $desc ) : ?>
    <section class="ds-body">
        <div class="ds-content-wrap">
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'ds-post-content' ); ?>>
                <?php echo wp_kses_post( $desc ); ?>
            </article>
        </div>
    </section>
    <?php endif; ?>

    <!-- BACK LINK -->
    <section class="ds-body">
        <div class="ds-content-wrap">
            <div class="ds-post-actions">
                <a class="ds-btn ds-btn--primary" href="<?php echo esc_url( $archive_url ); ?>">
                    View All Events
                </a>
            </div>
        </div>
    </section>

</main>

<?php
endwhile;

get_footer();
