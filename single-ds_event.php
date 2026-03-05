<?php
/**
 * Single Event Template
 *
 * Layout: 2:1 banner image (gradient fallback) → Title → Description →
 *         Date/Time → Location → Registration Link → Add to Calendar buttons
 *
 * @package DigitalStride
 */

get_header();

while ( have_posts() ) : the_post();

    $raw_date = get_field( 'event_date' ); // Ymd e.g. 20260315
    $date_obj = $raw_date ? DateTime::createFromFormat( 'Ymd', $raw_date ) : null;
    $date_fmt = $date_obj ? $date_obj->format( 'F j, Y' ) : '';
    $time     = (string) get_field( 'event_time' );
    $location = (string) get_field( 'event_location' );
    $reg_link = (string) get_field( 'event_registration_link' );
    $desc     = get_field( 'event_description' );
    $photo    = get_field( 'event_photo' );

    $photo_url = $photo ? esc_url( $photo['url'] ) : '';
    $photo_alt = $photo ? esc_attr( $photo['alt'] ) : esc_attr( get_the_title() );

    // ── Google Calendar URL ────────────────────────────────────────────────
    $gc_start = $date_obj ? $date_obj->format( 'Ymd' ) : '';
    $gc_end   = '';
    if ( $date_obj ) {
        $end_obj = clone $date_obj;
        $end_obj->modify( '+1 day' );
        $gc_end = $end_obj->format( 'Ymd' );
    }
    $gc_url = '';
    if ( $gc_start ) {
        $gc_url = 'https://calendar.google.com/calendar/render?' . http_build_query( [
            'action'   => 'TEMPLATE',
            'text'     => get_the_title(),
            'dates'    => $gc_start . '/' . $gc_end,
            'details'  => wp_strip_all_tags( (string) $desc ),
            'location' => $location,
        ] );
    }

    // ── ICS file for Apple Calendar ────────────────────────────────────────
    $ics_uri = '';
    if ( $gc_start ) {
        $ics  = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//Digital Stride//Events//EN\r\n";
        $ics .= "BEGIN:VEVENT\r\n";
        $ics .= "DTSTART;VALUE=DATE:{$gc_start}\r\n";
        $ics .= "DTEND;VALUE=DATE:{$gc_end}\r\n";
        $ics .= 'SUMMARY:' . str_replace( ["\n", "\r"], '', get_the_title() ) . "\r\n";
        if ( $location ) {
            $ics .= 'LOCATION:' . str_replace( ["\n", "\r"], '', $location ) . "\r\n";
        }
        if ( $desc ) {
            $ics .= 'DESCRIPTION:' . str_replace( ["\n", "\r"], ' ', wp_strip_all_tags( $desc ) ) . "\r\n";
        }
        $ics    .= "END:VEVENT\r\nEND:VCALENDAR";
        $ics_uri = 'data:text/calendar;charset=utf8,' . rawurlencode( $ics );
    }
?>

<main id="primary" class="site-main ds-event-single-page">

    <!-- ── Banner: 2:1 image or teal-blue gradient ─────────────────────── -->
    <div class="ds-event-banner<?php echo $photo_url ? '' : ' ds-event-banner--gradient'; ?>">
        <?php if ( $photo_url ) : ?>
            <img src="<?php echo esc_url( $photo_url ); ?>"
                 alt="<?php echo $photo_alt; ?>"
                 loading="eager">
        <?php endif; ?>
    </div>

    <div class="ds-event-single-wrap">

        <!-- Title -->
        <h1 class="ds-event-single-title"><?php the_title(); ?></h1>

        <!-- Description -->
        <?php if ( $desc ) : ?>
        <div class="ds-event-single-description">
            <?php echo wp_kses_post( $desc ); ?>
        </div>
        <?php endif; ?>

        <!-- Meta: Date / Time / Location -->
        <?php if ( $date_fmt || $location ) : ?>
        <div class="ds-event-single-meta">
            <?php if ( $date_fmt ) : ?>
            <div class="ds-event-meta-row">
                <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                <span><?php echo esc_html( $date_fmt . ( $time ? ' · ' . $time : '' ) ); ?></span>
            </div>
            <?php endif; ?>
            <?php if ( $location ) : ?>
            <div class="ds-event-meta-row">
                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                <span><?php echo esc_html( $location ); ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Registration Link -->
        <?php if ( $reg_link ) : ?>
        <div class="ds-event-single-reg">
            <a class="ds-event-reg-btn"
               href="<?php echo esc_url( $reg_link ); ?>"
               target="_blank"
               rel="noopener noreferrer">
                Register Now <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
        <?php endif; ?>

        <!-- Add to Calendar -->
        <?php if ( $gc_url || $ics_uri ) : ?>
        <div class="ds-event-single-cal">
            <span class="ds-event-cal-label">Add to calendar:</span>
            <div class="ds-event-cal-btns">
                <?php if ( $gc_url ) : ?>
                <a class="ds-event-cal-btn ds-cal-google"
                   href="<?php echo esc_url( $gc_url ); ?>"
                   target="_blank"
                   rel="noopener noreferrer">
                    <i class="fa-brands fa-google" aria-hidden="true"></i>
                    Google Calendar
                </a>
                <?php endif; ?>
                <?php if ( $ics_uri ) : ?>
                <a class="ds-event-cal-btn ds-cal-apple"
                   href="<?php echo esc_attr( $ics_uri ); ?>"
                   download="<?php echo esc_attr( sanitize_title( get_the_title() ) ); ?>.ics">
                    <i class="fa-brands fa-apple" aria-hidden="true"></i>
                    Apple Calendar
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Back link -->
        <div class="ds-event-single-back">
            <a href="<?php echo esc_url( home_url( '/events/' ) ); ?>">
                &larr; Back to All Events
            </a>
        </div>

    </div><!-- .ds-event-single-wrap -->

</main>

<?php
endwhile;

get_footer();
