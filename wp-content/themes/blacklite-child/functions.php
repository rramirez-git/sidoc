<?php
add_action( 'wp_enqueue_scripts', 'Estilos_Child');
add_action( 'wp_enqueue_scripts', 'JS_Child');
add_action( 'admin_head', 'Estilos_Child_Admin' );

function Estilos_Child() {
	//wp_enqueue_style( 'bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' );
	wp_enqueue_style( 'parent_css', get_stylesheet_directory_uri() . '/../blacklite/style.css' );
	wp_enqueue_style( 'main_css', get_stylesheet_directory_uri() . '/style.css' );
	wp_enqueue_style( 'hierarchy_view_css', get_stylesheet_directory_uri() . '/hierarchy-view/css/hierarchy-view.css' );
	wp_enqueue_style( 'hierarchy_main_css', get_stylesheet_directory_uri() . '/hierarchy-view/css/main.css' );
}

function JS_Child() {
  global $wp_scripts;
  //wp_enqueue_script( 'bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
  //wp_enqueue_script( 'bootstrap_bundle_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js');
  wp_enqueue_script( 'main_js', get_stylesheet_directory_uri() . '/javascript.js' );
}

function Estilos_Child_Admin() {
	wp_enqueue_style( 'admin_css', get_stylesheet_directory_uri() . '/admin.css' );
}

require_once( get_stylesheet_directory() . '/login.php' );
require_once( get_stylesheet_directory() . '/post-types/generic.php' );

$imgx_post_types = array();
$dir = dir( get_stylesheet_directory() . '/post-types' );
$dirs = array();
while( false !== ( $entry = $dir->read() ) ) {
	if( "." != $entry && ".." != $entry && is_dir( $dir->path . "/" . $entry ) ) {
		array_push( $dirs, $entry );
	}
}
sort( $dirs );
foreach( $dirs as $entry ) {
	$loader_file = $dir->path . "/" . $entry . "/" . "init-posttype.php";
	if( file_exists( $loader_file ) ) {
		$ptype = ( false !== strpos( $entry, "_" ) ? substr( $entry, strpos( $entry, "_" ) + 1 ) : $entry );
		$imgx_post_types[ $ptype ] = array( 
			'path' => $dir->path . "/" . $entry . "/",
			'uri' => get_stylesheet_directory_uri(). "/post-types/$entry/"
			);
		require_once( $loader_file );
	}
}
