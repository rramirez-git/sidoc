<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
  <head>
  	<meta charset="<?php bloginfo('charset'); ?>">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?> >
    <header class="fvpgb_header">
      <?php if (is_home()): ?>
          <h1 id="cd-logo" href="#0"><?php golden_black_custom_logo(); ?></h1>
      <?php else: ?>
  		    <div id="cd-logo" href="#0"><?php golden_black_custom_logo(); ?></div>
      <?php endif; ?>
  		<a id="cd-menu-trigger" href="#0"><span class="cd-menu-text"><?php esc_html_e( 'Menu', 'golden-black' ); ?></span><span class="cd-menu-icon"></span></a>
      <div class="fvpgb_clear"></div>
    </header>
    <main class="fvpgb_main-content">
