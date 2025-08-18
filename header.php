<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DigitalStride
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<?php if( get_field('google_tag_manager_id', 'option') ): ?>
		<?php $gtm_id = get_field('google_tag_manager_id', 'option'); ?>
			<script>
				(function(w,d,s,l,i){
					w[l]=w[l]||[];
					w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});
					var f=d.getElementsByTagName(s)[0];
					var j=d.createElement(s);
					j.async=true;
					j.src='https://www.googletagmanager.com/gtm.js?id='+i;
					f.parentNode.insertBefore(j,f);
				})(window,document,'script','dataLayer','<?php echo esc_js($gtm_id); ?>');
			</script>
	<?php elseif( get_field('google_analytics_tag', 'option') ): ?>
		<?php $ga_id = get_field('google_analytics_tag', 'option'); ?>
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($ga_id); ?>"></script>
			<script>
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());
				gtag('config', '<?php echo esc_js($ga_id); ?>'); 
			</script>
	<?php endif; ?>

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if( get_field('google_tag_manager_id', 'option') ): ?>
    <?php $gtm_id = get_field('google_tag_manager_id', 'option'); ?>
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr($gtm_id); ?>"
        height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
<?php elseif( get_field('google_analytics_tag', 'option') ): ?>
    <?php $ga_id = get_field('google_analytics_tag', 'option'); ?>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo esc_js($ga_id); ?>');
    </script>
<?php endif; ?>

<div id="page" class="site">
	<div id="site-top-anchor" class="visually-hidden" aria-hidden="true"></div>
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'digitalstride' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<div class="wp-soft-margin header-grid-container">
				<div class="header-logo">
					<a href="<?php echo esc_url( home_url( '/https://staging8.mydigitalstride.com/home-page-2/' ) ); ?>" rel="home">
						<?php 
						$user = wp_get_current_user();
						if ($user->exists()) {
							$user_roles = $user->roles;
							$primary_role = isset($user_roles[0]) ? $user_roles[0] : '';
							$user_id = get_current_user_id();
							if($primary_role == 'professional_plus') {
								echo wp_get_attachment_image(get_field('alternate_logo', 'user_'.$user_id), 'full', '', array('class' => ''));
							} else {
								echo wp_get_attachment_image(get_field('header_logo', 'option'), 'full', false, array('class' => 'header-logo-img'));
							}
						} else {
							echo wp_get_attachment_image(get_field('header_logo', 'option'), 'full', false, array('class' => 'header-logo-img'));

						} 
						?>
					</a>
				</div>
			<div class="header-menu-container">
  <nav id="mega-menu-wrap-primary" class="mega-menu-wrap">
    <?php
      wp_nav_menu(
        array(
          'theme_location' => 'primary',
          'menu_id'        => 'primary-menu',
          'container'      => false,
          'menu_class'     => 'mega-menu',
        )
      );
    ?>
  </nav>
</div>
			</div>
		</div><!-- .site-branding -->
	</header><!-- #masthead -->
