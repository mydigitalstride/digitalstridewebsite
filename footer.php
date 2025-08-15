<!-- <section class="back-to-top-band" aria-label="Back to top">
  <a href="#site-top-anchor" class="back-to-top-link">Back to top</a>
</section>
 -->
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
<?php wp_footer(); ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.querySelector('.mega-menu-toggle');
    const menuWrap = document.querySelector('#mega-menu-wrap-primary');

    if (toggle && menuWrap) {
      toggle.addEventListener('click', function () {
        menuWrap.classList.toggle('mega-menu-open');
      });
    }
  });
</script>

</body>
</html>
