<?php
/**
 * Template part to render the Resources page with a sticky right sidebar.
 * Assumes Flexible Content field name: home_page_section
 * Sidebar layout machine name: scrolling_sidebar
 */

$rows = get_field('home_page_section') ?: [];
$sidebar_data = null;

// 1) Pre-scan to pull the Scrolling Sidebar data (wherever it sits in the list)
foreach ($rows as $row) {
  if (!empty($row['acf_fc_layout']) && $row['acf_fc_layout'] === 'scrolling_sidebar') {
    $sidebar_data = $row; // keep the first one you find
    break;
  }
}

if ($rows):
  $opened_two_col = false;

  foreach ($rows as $row):
    $layout = $row['acf_fc_layout'] ?? '';

    // 2) Render the Hero full-width first
    if ($layout === 'hero_section') {
      // your hero renderer here (or replace with get_template_part)
      // Example:
      set_query_var('flex_row', $row);
      get_template_part('template-parts/flex/hero-section');
      continue;
    }

    // 3) Immediately after Hero, open the two-column shell (left content + right sidebar)
    if (!$opened_two_col) {
      $opened_two_col = true; ?>
      <div class="resources-shell">
        <div class="resources-main">
      <?php
    }

    // 4) If this row IS the Scrolling Sidebar, skip printing (we already captured it)
    if ($layout === 'scrolling_sidebar') {
      // Do nothing here (pre-scanned). We’ll print the sidebar once to the right column.
      continue;
    }

    // 5) Print all other layouts into the LEFT column
    // Map your layout names to their partials
    switch ($layout) {
      case 'resource_cards':
        set_query_var('flex_row', $row);
        get_template_part('template-parts/flex/resource-cards');
        break;

      case 'resource_listing':
        set_query_var('flex_row', $row);
        get_template_part('template-parts/flex/resource-listing');
        break;

      case 'peach_banner':
        set_query_var('flex_row', $row);
        get_template_part('template-parts/flex/peach-banner');
        break;

      // add other layout cases as needed...
      default:
        // Fallback
        set_query_var('flex_row', $row);
        get_template_part('template-parts/flex/' . $layout);
        break;
    }

  endforeach;

  // 6) Close LEFT column, render RIGHT sidebar once, then close shell
  ?>
      </div><!-- /.resources-main -->

      <aside class="resources-sidebar">
        <div class="sidebar-inner">
          <?php
          // If we found a Scrolling Sidebar row, render it; otherwise show nothing/fallback
          if ($sidebar_data) {
            // Expecting fields: heading, subheading, search, facebook_link, instagram_link, linkedin_link, post_buttons (repeater)
            $heading   = $sidebar_data['heading'] ?? '';
            $sub       = $sidebar_data['subheading'] ?? '';
            $search    = $sidebar_data['search'] ?? '';
            $fb        = $sidebar_data['facebook_link'] ?? '';
            $ig        = $sidebar_data['instagram_link'] ?? '';
            $li        = $sidebar_data['linkedin_link'] ?? '';
            $buttons   = $sidebar_data['post_buttons'] ?? [];

            ?>
            <section class="sidebar-card">
              <?php if ($heading): ?><h3><?php echo esc_html($heading); ?></h3><?php endif; ?>
              <?php if ($sub): ?><p class="sidebar-sub"><?php echo esc_html($sub); ?></p><?php endif; ?>

              <?php if (!empty($search)): ?>
                <form class="sidebar-search" action="<?php echo esc_url(home_url('/')); ?>">
                  <input type="search" name="s" placeholder="Search..." value="<?php echo esc_attr($search); ?>">
                </form>
              <?php endif; ?>

              <div class="sidebar-social">
                <?php if ($fb): ?><a href="<?php echo esc_url($fb); ?>" aria-label="Facebook" target="_blank" rel="noopener">FB</a><?php endif; ?>
                <?php if ($ig): ?><a href="<?php echo esc_url($ig); ?>" aria-label="Instagram" target="_blank" rel="noopener">IG</a><?php endif; ?>
                <?php if ($li): ?><a href="<?php echo esc_url($li); ?>" aria-label="LinkedIn" target="_blank" rel="noopener">IN</a><?php endif; ?>
              </div>

              <?php if (!empty($buttons) && is_array($buttons)): ?>
                <div class="sidebar-ctas">
                  <?php foreach ($buttons as $b):
                    $label = $b['button_text'] ?? '';
                    $url   = $b['button_link'] ?? '';
                    $style = $b['color_style'] ?? ''; // e.g., 'teal', 'blue', 'peach'
                    if (!$label || !$url) continue; ?>
                    <a class="sidebar-cta <?php echo esc_attr('cta-' . strtolower($style)); ?>"
                       href="<?php echo esc_url($url); ?>">
                      <?php echo esc_html($label); ?>
                    </a>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </section>
            <?php
          } // endif $sidebar_data
          ?>
        </div>
      </aside>
    </div><!-- /.resources-shell -->
<?php
endif;
