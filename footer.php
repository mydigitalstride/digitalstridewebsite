<!-- <section class="back-to-top-band" aria-label="Back to top">
  <a href="#site-top-anchor" class="back-to-top-link" aria-label="Scroll to Top">
    Scroll to Top
  </a>
</section> -->


<footer class="site-footer" style="--footer-overlay-image: url('https://staging8.mydigitalstride.com/wp-content/uploads/2025/06/3-1.png');">
  <div class="footer-grid-container">
    <?php if(have_rows('global_header_and_footer', 'option')): ?>
      <?php while(have_rows('global_header_and_footer', 'option')): the_row(); ?>
        <?php if(get_row_layout() == 'footer'): ?>
          
          <?php 
          $logo_contact = get_sub_field('footer_logo_contact');
          $links_cta = get_sub_field('footer_links_cta');
          ?>
          
          <!-- Left Column - Logo & Contact -->
          <div class="footer-left-col">
            <?php if($logo_contact['footer_logo']): ?>
              <div class="footer-logo">
                <img src="<?php echo esc_url($logo_contact['footer_logo']['url']); ?>" alt="<?php bloginfo('name'); ?>">
              </div>
            <?php endif; ?>
            
            <?php if($logo_contact['footer_contact_box']): ?>
              <div class="footer-contact">
                <?php echo wp_kses_post($logo_contact['footer_contact_box']); ?>
              </div>
            <?php endif; ?>
          </div>
          
          <!-- Middle Column - Services Text -->
          <div class="footer-middle-col">
            <?php if($links_cta['footer_services_text']): ?>
              <div class="footer-services">
               <?php echo apply_filters('the_content', $links_cta['footer_services_text']); ?>
              </div>
            <?php endif; ?>
          </div>
          
          <!-- Right Column - CTA & Social -->
          <div class="footer-right-col">
            <?php if($links_cta['footer_cta_button']): ?>
              <a href="<?php echo esc_url($links_cta['footer_cta_button']['url']); ?>" 
                 class="footer-cta-button"
                 target="<?php echo esc_attr($links_cta['footer_cta_button']['target'] ?: '_self'); ?>">
                <?php echo esc_html($links_cta['footer_cta_button']['title']); ?>
              </a>
            <?php endif; ?>
            
            <?php if(have_rows('footer_social_links')): ?>
              <div class="footer-social-icons">
                <?php while(have_rows('footer_social_links')): the_row(); ?>
                  <?php 
                  $icon = get_sub_field('icon');
                  $icon_url = get_sub_field('icon_url');
                  if($icon && $icon_url): ?>
                    <a href="<?php echo esc_url($icon_url['url']); ?>" 
                       target="<?php echo esc_attr($icon_url['target'] ?: '_blank'); ?>">
                      <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
                    </a>
                  <?php endif; ?>
                <?php endwhile; ?>
              </div>
              
            <?php endif; ?>
            <?php
$footer_pixel_image = get_field('footer_pixel_image', 'option');
if ($footer_pixel_image): ?>
  <div class="footer-pixels">
    <img src="<?php echo esc_url($footer_pixel_image); ?>" alt="" />
  </div>
<?php endif; ?>
          </div>
          
        <?php endif; ?>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</footer>
<a id="backToTop"
   class="back-to-top-fab"
   href="#site-top-anchor"
   aria-label="Back to top">
  <span class="btp-icon" aria-hidden="true"></span><!-- only arrow -->
</a>

<?php wp_footer(); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const sidebar = document.querySelector('.floating-sidebar');
  if (!sidebar) return;

  // Adjust to your real hero selector if different
  const hero   = document.querySelector('.resources-hero, .hero-section, [data-section="hero"], #hero');
  const footer = document.querySelector('footer.site-footer');

  function updateSidebar() {
    const y = window.scrollY;

    // 1) After the hero is out of view, pin the sidebar under the header
    const heroEnd = hero ? (hero.getBoundingClientRect().bottom + window.scrollY) : 400;
    if (y >= heroEnd) {
      sidebar.classList.add('after-hero');
    } else {
      sidebar.classList.remove('after-hero');
    }

    // 2) Keep inner height from overlapping footer
    const inner = sidebar.querySelector('.sidebar-inner');
    if (inner) {
      const topOffset = parseInt(getComputedStyle(sidebar).top) || 0;
      const footerTop = footer ? (footer.getBoundingClientRect().top + window.scrollY) : Infinity;
      const available = footerTop - y - topOffset - 16;  // small buffer
      inner.style.maxHeight = Math.max(240, available) + 'px';
    }
  }

  window.addEventListener('scroll', updateSidebar, { passive: true });
  window.addEventListener('resize', updateSidebar);
  updateSidebar();
});
</script>

<script>
(function() {
  function init() {
    /* ===== Primary menu toggle ===== */
    const toggle   = document.querySelector('.mega-menu-toggle');
    const menuWrap = document.querySelector('#mega-menu-wrap-primary');
    if (toggle && menuWrap && !toggle.dataset.bound) {
      toggle.addEventListener('click', () => menuWrap.classList.toggle('mega-menu-open'));
      toggle.dataset.bound = '1';
    }

    /* ===== Back-to-Top FAB behavior ===== */
    const fab    = document.getElementById('backToTop');
    const footer = document.querySelector('footer.site-footer'); // change selector if needed
    if (!fab) return;

    // prevent double-binding if this template loads twice
    if (fab.dataset.bound === '1') return;
    fab.dataset.bound = '1';

    // Detect all possible scroll roots (window OR container)
    const getScrollCandidates = () => {
      const roots = [
        document.scrollingElement || document.documentElement,
        document.body
      ];
      const likelyContainers = document.querySelectorAll('#page, .site, main, [data-scroll-container]');
      return Array.from(new Set([...roots, ...likelyContainers])).filter(Boolean);
    };

    const scrollToAbsoluteTop = () => {
      const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      const behavior = prefersReduced ? 'auto' : 'smooth';

      // 1) Try window first
      try { window.scrollTo({ top: 0, behavior }); } catch(_) { window.scrollTo(0, 0); }

      // 2) Then any container that actually scrolls
      const cands = getScrollCandidates();
      for (const el of cands) {
        if (!el) continue;
        // Only bother if it can scroll
        const canScroll = (el.scrollHeight - el.clientHeight) > 0 || el.scrollTop > 0;
        if (!canScroll) continue;
        if (typeof el.scrollTo === 'function') {
          try { el.scrollTo({ top: 0, behavior }); } catch(_) { el.scrollTop = 0; }
        } else {
          el.scrollTop = 0;
        }
      }

      // Optional: clear hash to avoid anchor re-jumps
      if (history.replaceState) history.replaceState(null, '', location.pathname + location.search);
    };

    // State: once clicked, stay hidden until footer is seen again.
    let dismissed = false;

    const show = () => fab.classList.add('is-visible');
    const hide = () => fab.classList.remove('is-visible');

    // Show when scrolled down, unless dismissed
    const updateVisibility = () => {
      if (dismissed) { hide(); return; }
      const scrolled = (window.scrollY || (document.scrollingElement || document.documentElement).scrollTop) > 600;
      scrolled ? show() : hide();
    };

    window.addEventListener('scroll', updateVisibility, { passive: true });
    window.addEventListener('resize', updateVisibility);
    updateVisibility();

    // Reset dismissal ONLY when the footer enters view
    if ('IntersectionObserver' in window && footer) {
      const io = new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
          dismissed = false;
          show();
        }
      }, { threshold: 0 });
      io.observe(footer);
    } else {
      // Fallback: near bottom = "footer seen"
      window.addEventListener('scroll', () => {
        if (!dismissed) return;
        const nearBottom = (window.innerHeight + (window.scrollY || (document.scrollingElement || document.documentElement).scrollTop)) >= (document.body.offsetHeight - 200);
        if (nearBottom) { dismissed = false; show(); }
      }, { passive: true });
    }

    // Click => scroll to absolute top on window AND any scroll container
    fab.addEventListener('click', (e) => {
      e.preventDefault();
      dismissed = true;
      hide();
      scrollToAbsoluteTop();
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>

</body>
</html>
