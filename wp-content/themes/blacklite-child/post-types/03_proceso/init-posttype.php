<?php              
add_action( 'init', 'IMGXPRegister_Proceso');

function IMGXPRegister_Proceso() {
	global $imgx_post_types;
	register_post_type( "imgx_proceso", array(
		'labels' 		=> array(
							"name" 					=> "Procesos",
							"singularname" 			=> "Proceso",
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
		//'menu_icon'		=> $imgx_post_types[ "proceso" ][ "uri" ] . "icon.png",
		'menu_icon'		=> "dashicons-admin-generic",
		'menu_position'	=> 20,
		'hierarchical'	=> true,
		'supports'		=> array( 'title', 'editor', 'thumbnail' )
	) );
}

