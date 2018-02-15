<?php
add_action( 'init', 'IMGXPRegister_Persona');
add_action( 'add_meta_boxes', 'IMGX_Persona_MetaBox' );
add_action( 'save_post', 'IMGX_Persona_Save' );

function IMGXPRegister_Persona() {
	global $imgx_post_types;
	register_post_type( "imgx_persona", array(
		'labels' 		=> array(
							"name" 					=> "Personas",
							"singularname" 			=> "Persona",
							"add_new" 				=> "Añadir Nueva Persona",
							"add_new_item" 			=> "Nueva Persona",
							"edit_item" 			=> "Actualizar Persona",
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
	add_shortcode( 'Organigrama', 'IMGX_GeneraOrganigrama_SC' );
	add_shortcode( 'OrganigramaParcial', 'IMGX_GeneraOrganigrama_SCP' );
}

function IMGX_Persona_MetaBox() {
	add_meta_box( 'IMG_Persona_MetaBox', 'Datos de la Persona', 'IMGX_Persona_MetaBox_Callback', 'imgx_persona' );
}

function IMGX_Persona_MetaBox_Callback( $post ) {
	$metas = new MyMetas( $post->ID );
	$raices = IMGX_GetRoots();
	$organigrama = array();
	foreach( $raices as $raiz ) {
		array_push( $organigrama, IMGX_GeneraOrganigrama_Data( $raiz ) );
	}
	//echo "<pre>"; print_r( $organigrama ); echo "</pre>"; 
	?>
		<input type="hidden" name="imgx_guid" id="imgx_guid" value="<?php echo esc_attr( $metas->getMeta( 'imgx_guid' ) ); ?>" />
		<div class="custom-meta-box">
			<table>
				<tbody>
					<tr>
						<td class="label">Puesto:</td>
						<td class="control">
							<select name="imgx_puesto" id="imgx_puesto">
								<option value=""></option>
								<?php foreach( $organigrama as $raiz ){
									echo IMGX_GeneraOptionsPuesto( $raiz, $metas->getMeta( 'imgx_persona_puesto' ) );
								} ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label">Depende de:</td>
						<td class="control">
							<select name="imgx_depende_de" id="imgx_depende_de">
								<option value=""></option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	<?php
}

function IMGX_Persona_Save( $post_id ) {
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if( ! current_user_can( 'edit_post' ) ) {
		return;
	}
	update_post_meta( $post_id, 'imgx_guid', esc_attr( isset( $_POST[ "imgx_guid" ] ) ? $_POST[ "imgx_guid" ] : CreateGUID() ) );
	update_post_meta( $post_id, 'imgx_puesto', esc_attr( isset( $_POST[ "imgx_puesto" ] ) ? $_POST[ "imgx_puesto" ] : '' ) );
	update_post_meta( $post_id, 'imgx_depende_de', esc_attr( isset( $_POST[ "imgx_depende_de" ] ) ? $_POST[ "imgx_depende_de" ] : '' ) );
}

function IMGX_GeneraOrganigrama_SC() {
	
}

function IMGX_GeneraOrganigrama_SCP() {
	
}





function IMGX_GeneraOrganigrama_Data( $post_puesto ) {
	$resultado = array( 
		"metas" => new MyMetas( $post_puesto ), 
		"hijos" => array(),
		"personas" => array()
	);
	$hijos = IMGX_GetPuestoHierarchyHijos( $resultado[ "metas" ]->getMeta( "imgx_guid" ) );
	foreach( $hijos as $hijo ) {
		array_push( $resultado[ "hijos" ], IMGX_GeneraOrganigrama_Data( $hijo ) );
	}
	//$resultado[ "personas" ] = IMGX_ObtienePersonasEnPuesto( $resultado[ "metaa" ]->getMeta( 'imgx_guid' ) );
	return $resultado;
}

function IMGX_ObtienePersonasEnPuesto( $guid_puesto ) {
	
}





function IMGX_GeneraOptionsPuesto( $estructura_puesto, $valor_actual, $nivel = 0 ) {
	//print_r( $estructura_puesto );
	$precad = "";
	if( $nivel > 0 ) {
		$precad = str_repeat( "&nbsp;&nbsp;&nbsp;&nbsp;", $nivel );
	}
	$guid = $estructura_puesto[ "metas" ]->getMeta( 'imgx_guid' );
	$txt = $precad . IMGX_GetDataPuesto( $guid )[ "post_title" ];
	$selecto = ( $guid == $valor_actual ? 'selected="selected"' : '' );
	$resultado = '<option value="' . $guid . '" ' . $selecto . '>' . $txt . '</option>';
	foreach( $estructura_puesto[ "hijos" ] as $hijo ) {
		$resultado .= IMGX_GeneraOptionsPuesto( $hijo, $valor_actual, $nivel + 1 );
	}
	return $resultado;
}