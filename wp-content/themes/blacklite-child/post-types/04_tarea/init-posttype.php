<?php
add_action( 'init', 'IMGXPRegister_Tarea');

function IMGXPRegister_Tarea() {
	global $imgx_post_types;
	register_post_type( "imgx_tarea", array(
		'labels' 		=> array(
							"name" 					=> "Tareas",
							"singularname" 			=> "Tarea",
							"add_new" 				=> "Añadir",
							"add_new_item" 			=> "Añadir",
							"edit_item" 			=> "Actualizar",
							"new_item" 				=> "Nueva",
							"view_item" 			=> "Ver",
							"search_item" 			=> "Buscar",
							"not_found" 			=> "Sin Coincidencias",
							"not_found_in_trash" 	=> "Sin Coincidencias en Papelera"
						),
		'public' 		=> true,
		'has_archive'	=> true,
		//'menu_icon'		=> $imgx_post_types[ "tarea" ][ "uri" ] . "icon.png",
		'menu_icon'		=> "dashicons-yes",
		'menu_position'	=> 20,
		'hierarchical'	=> true,
		'supports'		=> array( 'title', 'editor', 'thumbnail' )
	) );
}

