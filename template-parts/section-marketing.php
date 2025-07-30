<section class="values-section marketing-section">
  <div class="values-bubble-marketing">
    <div class="left-section">
			<h2><?php the_sub_field('marketing_title'); ?></h2>
			<?php if (get_sub_field('marketing_stars')): ?>
				<h3 class="marketing-stars-title"><?php the_sub_field('marketing_stars'); ?></h3>
			<?php endif; ?>
			<div class="marketing-content">
				<?php the_sub_field('marketing_content'); ?>
			</div>
				<?php 
		$cta_text = get_sub_field('marketing_cta_text');
		$cta_link = get_sub_field('marketing_cta_link');
		if ($cta_text && $cta_link): ?>
		  <div class="marketing-cta">
			<a href="<?php echo esc_url($cta_link); ?>" class="marketing-cta-button">
			  <?php echo esc_html($cta_text); ?>
			</a>
		  </div>
		<?php endif; ?>
	</div>
	  
    <div class="right-section">
		<?php 
		$marketing_image = get_sub_field('marketing_image');
		if ($marketing_image): ?>
		<div class="marketing_image">
			<img 
				 src="<?php echo esc_url($marketing_image['url']); ?>" 
				 alt="<?php echo esc_attr($marketing_image['alt']); ?>" 
				 class="marketing-image"
				 />
		</div>
	</div>
    <?php endif; ?>


    
  </div>
</section>
