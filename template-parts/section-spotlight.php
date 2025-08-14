<section class="values-section client-spotlight-section">
  <div class="values-bubble-spotlight">

    <?php
      // one image, used twice (mirrored on the right)
      $corner = get_sub_field('corner_accent');
    ?>
    <?php if ($corner && !empty($corner['url'])): ?>
      <img class="corner-accent corner-accent--left"
           src="<?php echo esc_url($corner['url']); ?>"
           alt=""
           aria-hidden="true" />
      <img class="corner-accent corner-accent--right"
           src="<?php echo esc_url($corner['url']); ?>"
           alt=""
           aria-hidden="true" />
    <?php endif; ?>

    <h2 class="spotlight-title"><?php the_sub_field('section_title'); ?></h2>

    <?php if (have_rows('before_after_slider')): ?>
      <div class="before-after-slider">
        <div class="slider-wrapper">
          <button class="slider-nav prev">&#10094;</button>

          <div class="slider">
            <?php while (have_rows('before_after_slider')): the_row();
              $before = get_sub_field('before_image');
              $after  = get_sub_field('after_image');
              if ($before && $after): ?>
                <div class="slide">
                  <div class="slide-inner">
                    <img src="<?php echo esc_url($before['url']); ?>" alt="Before Image" class="slide-img" />
                    <img src="<?php echo esc_url($after['url']); ?>"  alt="After Image"  class="slide-img" />
                  </div>
                </div>
              <?php endif; ?>
            <?php endwhile; ?>
          </div>

          <button class="slider-nav next">&#10095;</button>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <div class="cta-wrapper">
    <h2 class="cta-title"><?php the_sub_field('cta_title'); ?></h2>
    <div class="cta-decoration"><?php the_sub_field('cta_decorative_line'); ?></div>
    <p class="cta-description"><?php the_sub_field('cta_description'); ?></p>
    <a href="<?php the_sub_field('cta_button_link'); ?>" class="cta-button">
      <?php the_sub_field('cta_button_text'); ?>
    </a>
  </div>
</section>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".before-after-slider .slide");
    const nextBtn = document.querySelector(".slider-nav.next");
    const prevBtn = document.querySelector(".slider-nav.prev");
    let currentIndex = 0;

    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.classList.toggle("active", i === index);
      });
    }

    nextBtn.addEventListener("click", () => {
      currentIndex = (currentIndex + 1) % slides.length;
      showSlide(currentIndex);
    });

    prevBtn.addEventListener("click", () => {
      currentIndex = (currentIndex - 1 + slides.length) % slides.length;
      showSlide(currentIndex);
    });

    // Show the first slide initially
    showSlide(currentIndex);
  });
</script>
