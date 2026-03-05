<?php
/**
 * Template Part: Events Section with Calendar View
 *
 * Usage: get_template_part( 'template-parts/section-events' );
 *
 * Displays all published Events (ds_event CPT) in a month-view calendar
 * plus a card grid. Clicking any event opens a modal with full details
 * and Add to Google / Apple Calendar buttons.
 */

// Query all published events. Avoid meta_key constraint so events without a
// saved date (e.g. newly created drafts) still appear. PHP-sorts by date below.
$events_query = new WP_Query([
    'post_type'      => 'ds_event',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'ASC',
]);

$events_data = [];

if ( $events_query->have_posts() ) {
    while ( $events_query->have_posts() ) {
        $events_query->the_post();
        $post_id = get_the_ID();

        $raw_date = get_field( 'event_date' ); // Ymd e.g. 20260315
        $date_obj = $raw_date ? DateTime::createFromFormat( 'Ymd', $raw_date ) : null;
        $photo    = get_field( 'event_photo' );

        $events_data[] = [
            'id'            => $post_id,
            'title'         => get_the_title(),
            'description'   => (string) get_field( 'event_description' ),
            'date'          => $raw_date ?: '',
            'dateFormatted' => $date_obj ? $date_obj->format( 'F j, Y' ) : '',
            'dateISO'       => $date_obj ? $date_obj->format( 'Y-m-d' ) : '',
            'time'          => (string) get_field( 'event_time' ),
            'location'      => (string) get_field( 'event_location' ),
            'regLink'       => (string) get_field( 'event_registration_link' ),
            'photoUrl'      => $photo ? esc_url( $photo['url'] ) : '',
            'photoAlt'      => $photo ? esc_attr( $photo['alt'] ) : '',
        ];
    }
    wp_reset_postdata();
}
?>

<section class="ds-events-section">

    <div class="ds-events-header">
        <h2>Upcoming Events</h2>
    </div>

    <?php if ( empty( $events_data ) ) : ?>

        <p class="ds-events-empty">No events scheduled at this time. Check back soon!</p>

    <?php else : ?>

    <!-- ── Month Calendar ──────────────────────────────────────────────────── -->
    <div class="ds-calendar-wrap">
        <div class="ds-calendar-nav">
            <button class="ds-cal-btn" id="ds-cal-prev" aria-label="Previous month">&#8249;</button>
            <h2 class="ds-cal-month-label" id="ds-cal-month-label"></h2>
            <button class="ds-cal-btn" id="ds-cal-next" aria-label="Next month">&#8250;</button>
        </div>
        <div class="ds-calendar-grid" id="ds-calendar-grid">
            <?php foreach ( ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day_name ) : ?>
                <div class="ds-cal-day-header"><?php echo esc_html( $day_name ); ?></div>
            <?php endforeach; ?>
            <!-- Day cells injected by events.js -->
        </div>
    </div>

    <!-- ── Events Card Grid ────────────────────────────────────────────────── -->
    <div class="ds-events-list-wrap">
        <h3>All Events</h3>
        <div class="ds-events-grid">
            <?php foreach ( $events_data as $evt ) :
                $has_photo   = ! empty( $evt['photoUrl'] );
                $plain_desc  = wp_strip_all_tags( $evt['description'] );
                $excerpt     = mb_strlen( $plain_desc ) > 130
                    ? mb_substr( $plain_desc, 0, 130 ) . '&hellip;'
                    : $plain_desc;
            ?>
            <div class="ds-event-card"
                 data-event-id="<?php echo esc_attr( $evt['id'] ); ?>"
                 role="button"
                 tabindex="0"
                 aria-label="<?php echo esc_attr( 'View details: ' . $evt['title'] ); ?>">

                <div class="ds-event-card-image<?php echo $has_photo ? '' : ' no-photo'; ?>">
                    <?php if ( $has_photo ) : ?>
                        <img src="<?php echo esc_url( $evt['photoUrl'] ); ?>"
                             alt="<?php echo esc_attr( $evt['photoAlt'] ); ?>"
                             loading="lazy">
                    <?php endif; ?>
                </div>

                <div class="ds-event-card-body">
                    <h4 class="ds-event-card-title"><?php echo esc_html( $evt['title'] ); ?></h4>

                    <?php if ( $excerpt ) : ?>
                        <p class="ds-event-card-excerpt"><?php echo $excerpt; ?></p>
                    <?php endif; ?>

                    <div class="ds-event-card-meta">
                        <?php if ( $evt['dateFormatted'] ) : ?>
                        <span>
                            <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                            <?php echo esc_html( $evt['dateFormatted'] . ( $evt['time'] ? ' · ' . $evt['time'] : '' ) ); ?>
                        </span>
                        <?php endif; ?>
                        <?php if ( $evt['location'] ) : ?>
                        <span>
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            <?php echo esc_html( $evt['location'] ); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php endif; ?>

</section>

<!-- ── Event Detail Modal ───────────────────────────────────────────────────── -->
<div class="ds-events-modal-overlay"
     id="ds-events-modal-overlay"
     role="dialog"
     aria-modal="true"
     aria-labelledby="ds-modal-title-text">

    <div class="ds-events-modal" id="ds-events-modal">

        <button class="ds-modal-close" id="ds-modal-close" aria-label="Close event details">&#x2715;</button>

        <div class="ds-modal-image-banner" id="ds-modal-image-banner">
            <img id="ds-modal-image" src="" alt="" loading="lazy">
        </div>

        <div class="ds-modal-body">
            <h2 class="ds-modal-title" id="ds-modal-title-text"></h2>
            <div class="ds-modal-description" id="ds-modal-description"></div>
            <div class="ds-modal-meta" id="ds-modal-meta"></div>
            <div id="ds-modal-reg-wrap"></div>
            <div class="ds-modal-cal-btns" id="ds-modal-cal-btns"></div>
        </div>

    </div>
</div>

<!-- All event data for JS calendar + modal -->
<script>
window.dsEventsData = <?php echo wp_json_encode( $events_data, JSON_HEX_TAG | JSON_HEX_AMP ); ?>;
</script>
