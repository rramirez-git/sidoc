<?php

function golden_black_script_enqueue() {

  wp_enqueue_style( 'foundation', get_template_directory_uri() . '/css/foundation.css', array(), '6.2.3', 'all' );
  wp_enqueue_style( 'goldenblack', get_template_directory_uri() . '/css/goldenblack.css', array(), '1.0.0', 'all' );

  wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Josefin+Sans|Noto+Sans', array(), null, 'all' );

  wp_enqueue_script( 'cd-navigation', get_template_directory_uri() . '/js/cd-navigation.js', array('jquery'), '1.0.0', true );

  if ( is_singular() ) wp_enqueue_script( "comment-reply" );

}
add_action( 'wp_enqueue_scripts', 'golden_black_script_enqueue');


/*
  ====================================================
    Theme Features
  ====================================================
*/

function golden_black_setup() {

  add_theme_support( 'menus' );

  register_nav_menu( 'primary', __('Primary Header Navigation' , 'golden-black') );
  register_nav_menu( 'secondary', __('Footer Navigation' , 'golden-black') );

  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'html5' );
  add_theme_support( 'title-tag' );
  add_theme_support( 'automatic-feed-links' );

  add_theme_support( 'custom-logo', array(
      'height'      => 200,
      'width'       => 500,
      'flex-height' => true,
      'flex-width'  => true,
      'header-text' => array( 'site-title', 'site-description' ),
  ) );

  add_image_size( 'golden_black_post_thumbnail', '746', '484', array( 'center', 'center' ) );
}
add_action( 'after_setup_theme', 'golden_black_setup' );


function golden_black_custom_logo() {
  if ( function_exists( 'the_custom_logo' ) ) {
    if ( has_custom_logo() ) {
      the_custom_logo();
    } else {
      echo '<a href="' . esc_url( home_url() ) . '" class="fvp-logo-name">' . get_bloginfo( 'name' ) . '</a>';
    }
  } else {
    echo '<a href="' . esc_url( home_url() ) . '" class="fvp-logo-name">' . get_bloginfo( 'name' ) . '</a>';
  }
}


/*
  ====================================================
    Sidebar and Footer Function
  ====================================================
*/

function golden_black_widget_setup() {

  // Sidebar
  register_sidebar(
    array(
      'name'          => __('Sidebar' , 'golden-black'),
      'id'            => 'sidebar-1',
      'class'         => 'fvp',
      'description'   => __('Standard Sidebar' , 'golden-black'),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
	    'after_widget'  => '</section>',
	    'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>'
    )
  );

  // Footer Left Area
  register_sidebar(
    array(
      'name'          => __('Footer Left Area' , 'golden-black'),
      'id'            => 'footer-left',
      'class'         => 'fvp',
      'description'   => __('Footer Left Area' , 'golden-black'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	    'after_widget'  => '</aside>',
	    'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>'
    )
  );

  // Footer Right Area
  register_sidebar(
    array(
      'name'          => __('Footer Right Area' , 'golden-black'),
      'id'            => 'footer-right',
      'class'         => 'fvp',
      'description'   => __('Footer Right Area' , 'golden-black'),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	    'after_widget'  => '</aside>',
	    'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>'
    )
  );

}
add_action( 'widgets_init', 'golden_black_widget_setup' );


/*
  ====================================================
    Custom Excerpt
  ====================================================
*/

function golden_black_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'golden_black_excerpt_length', 999 );


function golden_black_fix_pagination($content) {
    // Remove role attribute
    $content = str_replace('role="navigation"', '', $content);

    // Remove h2 tag
    $content = preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $content);

    return $content;
}
add_action('navigation_markup_template', 'golden_black_fix_pagination');


/*
  ====================================================
    Other things needed
  ====================================================
*/

function golden_black_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'golden_black_content_width', 870 );
}
add_action( 'after_setup_theme', 'golden_black_content_width', 0 );
