<?php
add_action( 'init', 'IMGXPRegister_Persona');

function IMGXPRegister_Persona() {
	global $imgx_post_types;
	register_post_type( "imgx_persona", array(
		'labels' 		=> array(
							"name" 					=> "Personas",
							"singularname" 			=> "Persona",
							"add_new" 				=> "Añadir",
							"add_new_item" 			=> "Añadir",
							"edit_item" 			=> "Actualizar",
							"new_item" 				=> "Nuevo",
							"view_item" 			=> "Ver",
							"search_item" 			=> "Buscar",
							"not_found" 			=> "Sin Coincidencias",
							"not_found_in_trash" 	=> "Sin Coincidencias en Papelera"
						),
		'public' 		=> true,
		'has_archive'	=> true,
		//'menu_icon'		=> $imgx_post_types[ "persona" ][ "uri" ] . "icon.png",
		'menu_icon'		=> "dashicons-businessman",
		'menu_position'	=> 20,
		'hierarchical'	=> true,
		'supports'		=> array( 'title', 'editor', 'thumbnail' )
	) );
}

