<?php
// Get the ACF image
$x_image = get_sub_field('x_image');
?>

<section class="x-wrapper" style="background-image: url('<?php echo esc_url($x_image['url']); ?>');">
  
  <?php get_template_part('template-parts/section', 'header'); ?>
  <?php get_template_part('template-parts/section', 'subheader'); ?>

</section>
