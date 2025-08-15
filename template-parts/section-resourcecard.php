<?php if (have_rows('resource_cards')): ?>
  <section class="resource-cards-section">
    <h2 class="section-heading">Find Your Resource</h2>
    <div class="card-wrapper">
      <?php while (have_rows('resource_cards')): the_row(); 
        // Existing link (can be full URL or '#anchor')
        $link_raw = get_sub_field('resource_link');
        $url      = is_array($link_raw) ? ($link_raw['url'] ?? '') : trim((string)$link_raw);
        $target   = is_array($link_raw) ? ($link_raw['target'] ?? '') : '';

        // NEW: anchor-based linking
        $anchor_slug = trim((string)get_sub_field('target_anchor')); // e.g. "marketing-resources"
        $target_page = get_sub_field('target_page'); // optional

        if ($anchor_slug !== '') {
          $anchor = '#' . ltrim(sanitize_title($anchor_slug), '#');
          $url    = $target_page ? (get_permalink($target_page) . $anchor) : $anchor;
          $target = ''; // anchors should open in same tab
        }

        $title = get_sub_field('resource_title');
        $icon  = get_sub_field('resource_icon');
      ?>

        <?php if ($url): ?>
          <a 
            class="resource-card" 
            href="<?php echo esc_url($url); ?>" 
            <?php if ($target) echo 'target="'.esc_attr($target).'"'; ?>
            <?php if ($target === '_blank') echo 'rel="noopener"'; ?>
            aria-label="<?php echo esc_attr($title); ?>"
          >
        <?php else: ?>
          <div class="resource-card">
        <?php endif; ?>

            <div class="card-content">
              <h3><?php echo esc_html($title); ?></h3>
              <div class="decor-line">+ + + + +</div>
              <p><?php the_sub_field('resource_description'); ?></p>
            </div>

            <?php if (!empty($icon['url'])): ?>
              <div class="card-icon">
                <img 
                  src="<?php echo esc_url($icon['url']); ?>" 
                  alt="<?php echo esc_attr($title); ?>"
                >
              </div>
            <?php endif; ?>

        <?php if ($url): ?>
          </a>
        <?php else: ?>
          </div>
        <?php endif; ?>

      <?php endwhile; ?>
    </div>
  </section>
<?php endif; ?>
