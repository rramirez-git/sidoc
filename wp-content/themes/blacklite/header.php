<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package blacklite
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'blacklite' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<nav id="site-navigation" class="main-navigation" role="navigation">
		<div class="top-nav container">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<span class="m_menu_icon"></span>
				<span class="m_menu_icon"></span>
				<span class="m_menu_icon"></span>
			</button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>

			<div id="top-search">
				<a href="#"><i class="fa fa-search"></i></a>
			</div>
			<div class="show-search">
				<?php get_search_form(); ?>
			</div>
			<div id="top-social">
				
				<?php if(get_theme_mod('blacklite_facebook')) : ?><a href="<?php echo esc_url(get_theme_mod('blacklite_facebook')); ?>" target="_blank"><i class="fa fa-facebook"></i></a><?php endif; ?>
				<?php if(get_theme_mod('blacklite_twitter')) : ?><a href="<?php echo esc_url(get_theme_mod('blacklite_twitter')); ?>" target="_blank"><i class="fa fa-twitter"></i></a><?php endif; ?>
				<?php if(get_theme_mod('blacklite_instagram')) : ?><a href="<?php echo esc_url(get_theme_mod('blacklite_instagram')); ?>" target="_blank"><i class="fa fa-instagram"></i></a><?php endif; ?>
				<?php if(get_theme_mod('blacklite_pinterest')) : ?><a href="<?php echo esc_url(get_theme_mod('blacklite_pinterest')); ?>" target="_blank"><i class="fa fa-pinterest"></i></a><?php endif; ?>
				<?php if(get_theme_mod('blacklite_bloglovin')) : ?><a href="<?php echo esc_url(get_theme_mod('blacklite_bloglovin')); ?>" target="_blank"><i class="fa fa-heart"></i></a><?php endif; ?>
				<?php if(get_theme_mod('blacklite_google')) : ?><a href="<?php echo esc_url(get_theme_mod('blacklite_google')); ?>" target="_blank"><i class="fa fa-google-plus"></i></a><?php endif; ?>
				<?php if(get_theme_mod('blacklite_tumblr')) : ?><a href="<?php echo esc_url(get_theme_mod('blacklite_tumblr')); ?>.tumblr.com/" target="_blank"><i class="fa fa-tumblr"></i></a><?php endif; ?>
				<?php if(get_theme_mod('blacklite_youtube')) : ?><a href="<?php echo esc_url(get_theme_mod('blacklite_youtube')); ?>" target="_blank"><i class="fa fa-youtube-play"></i></a><?php endif; ?>

				<?php if(get_theme_mod('blacklite_dribbble')) : ?><a href="<?php echo esc_url(get_theme_mod('blacklite_dribbble')); ?>" target="_blank"><i class="fa fa-dribbble"></i></a><?php endif; ?>
				<?php if(get_theme_mod('blacklite_soundcloud')) : ?><a href="<?php echo esc_url(get_theme_mod('blacklite_soundcloud')); ?>" target="_blank"><i class="fa fa-soundcloud"></i></a><?php endif; ?>
				<?php if(get_theme_mod('blacklite_vimeo')) : ?><a href="<?php echo esc_url(get_theme_mod('blacklite_vimeo')); ?>" target="_blank"><i class="fa fa-vimeo-square"></i></a><?php endif; ?>
				<?php if(get_theme_mod('blacklite_linkedin')) : ?><a href="<?php echo esc_url(get_theme_mod('blacklite_linkedin')); ?>" target="_blank"><i class="fa fa-linkedin"></i></a><?php endif; ?>
				<?php if(get_theme_mod('blacklite_rss')) : ?><a href="<?php echo esc_url(get_theme_mod('blacklite_rss')); ?>" target="_blank"><i class="fa fa-rss"></i></a><?php endif; ?>
				
			</div>
		</div>
		</nav><!-- #site-navigation -->

		<div class="site-branding container">

			<?php
				if ( has_custom_logo() ) {

					blacklite_the_custom_logo();

				}else{ ?>

				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

				<?php
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>

			<?php } ?>

		</div><!-- .site-branding -->

	</header><!-- #masthead -->

	<div id="content" class="site-content">
