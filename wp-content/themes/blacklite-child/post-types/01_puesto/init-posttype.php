<?php
add_action( 'init', 'IMGXPRegister_Puesto' );
add_action( 'add_meta_boxes', 'IMGX_Puesto_MetaBox' );
add_action( 'save_post', 'IMGX_Puesto_Save' );
add_filter( 'manage_imgx_puesto_posts_columns', 'IMGX_Puesto_Dependencia_AddAdminColumnList_head');
add_action( 'manage_imgx_puesto_posts_custom_column', 'IMGX_Puesto_Dependencia_AddAdminColumnList_content', 10, 2);
add_action( 'restrict_manage_posts', 'IMGX_PuestoFiltroControl' );
add_filter( 'parse_query', 'IMGX_PuestoFiltro' );

require_once( $imgx_post_types[ "puesto" ][ "path" ] . "organigrama.php" );

function IMGXPRegister_Puesto() {
	global $imgx_post_types;
	register_post_type( "imgx_puesto", array(
		'labels' 		=> array(
							"name" 					=> "Puestos",
							"singularname" 			=> "Puesto",
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
		//'menu_icon'		=> $imgx_post_types[ "puesto" ][ "uri" ] . "icon.png",
		'menu_icon'		=> "dashicons-networking",
		'menu_position'	=> 20,
		'hierarchical'	=> true,
		'supports'		=> array( 'title', 'editor', 'thumbnail' )
	) );
}

function IMGX_Puesto_MetaBox() {
	add_meta_box( 'IMG_Puesto_MetaBox', 'Datos del Puesto', 'IMGX_Puesto_MetaBox_Callback', 'imgx_puesto' );
}

function IMGX_Puesto_MetaBox_Callback( $post ) {
	$metas = new MyMetas( $post->ID );
	$padres = IMGX_GetPuestos( $metas->getMeta( 'imgx_guid' ) )
	?>
		<input type="hidden" name="guid" id="guid" value="<?php echo esc_attr( $metas->getMeta( 'imgx_guid' ) ); ?>" />
		<div class="custom-meta-box">
			<table>
				<tbody>
					<tr>
						<td class="label">
							Funciones:
						</td>
						<td class="control">
							<textarea id="funciones" name="funciones" rows="15"><?php echo esc_attr( $metas->getMeta( 'imgx_puesto_funciones' ) ); ?></textarea>
						</td>
					</tr>
					<tr>
						<td class="label">
							Depende de:
						</td>
						<td class="control">
							<select name="padre" id="padre">
								<option value=""></option>
								<?php foreach( $padres as $opt ): ?>
									<option value="<?php echo $opt[ "guid" ]; ?>" <?php echo ( $opt[ "guid" ] == $metas->getMeta('imgx_puesto_padre') ? 'selected="selected"' : '' ); ?> >
										<?php echo $opt[ "puesto" ]; ?>
									</option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	<?php
}

function IMGX_Puesto_Save( $post_id ) {
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if( ! current_user_can( 'edit_post' ) ) {
		return;
	}
	update_post_meta( $post_id, 'imgx_guid', esc_attr( isset( $_POST[ "imgx_guid" ] ) ? $_POST[ "imgx_guid" ] : CreateGUID() ) );
	update_post_meta( $post_id, 'imgx_puesto_funciones', esc_attr( isset( $_POST[ "funciones" ] ) ? $_POST[ "funciones" ] : '' ) );
	update_post_meta( $post_id, 'imgx_puesto_padre', esc_attr( isset( $_POST[ "padre" ] ) ? $_POST[ "padre" ] : '' ) );
}

function IMGX_Puesto_Dependencia_AddAdminColumnList_head( $defaults ) {
	$defaults[ "imgx_puesto_dependencia" ] = "Depende de";
	return $defaults;
}

function IMGX_Puesto_Dependencia_AddAdminColumnList_content( $columna, $post_id ) {
	if( "imgx_puesto_dependencia" == $columna ) {
		$metas = new MyMetas( $post_id );
		echo IMGX_GetPuesto( $metas->getMeta( "imgx_puesto_padre" ) );
	}
}

function IMGX_PuestoFiltroControl() {
	$type = isset( $_GET[ "post_type" ] ) ? $_GET[ "post_type" ] : "post";
	if( "imgx_puesto" == $type ) {
		$puestos = IMGX_GetPuestos( '' );
		$current = isset( $_GET[ "imgx_post_filtro" ] ) ? $_GET[ "imgx_post_filtro" ] : "";
		?>
		<select name="imgx_post_filtro" id="imgx_post_filtro">
			<option value="">Todos los Puestos</option>
			<?php foreach( $puestos as $pto ): ?>
				<option value="<?php echo $pto[ "guid" ]; ?>" <?php echo ( $current == $pto[ "guid" ] ? 'selected="selected"' : '' ); ?> >
					<?php echo $pto[ "puesto" ]; ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?php
	}
}

function IMGX_PuestoFiltro( $query ) {
	global $pagenow;
	$type = isset( $_GET[ "post_type" ] ) ? $_GET[ "post_type" ] : "post";
	if ( 'imgx_puesto' == $type && is_admin() && $pagenow =='edit.php' && isset( $_GET[ 'imgx_post_filtro' ] ) && $_GET[ 'imgx_post_filtro' ] != '') {
        $query->query_vars['meta_key'] = 'imgx_puesto_padre';
        $query->query_vars['meta_value'] = $_GET['imgx_post_filtro'];
    }
}

function IMGX_GetPuestos( $current_guid ) {
	global $wpdb;
	$pref = $wpdb->prefix;
	$resultados = $wpdb->get_results( $wpdb->prepare( "select id, post_title as puesto,meta_value as guid from {$pref}posts p inner join {$pref}postmeta m on p.id = m.post_id where post_status = %s and post_type = %s and meta_key = %s and meta_value <> %s order by post_title;", 'publish', 'imgx_puesto', 'imgx_guid', $current_guid ), 'ARRAY_A' );
	return $resultados;
}

function IMGX_GetPuesto( $current_guid ) {
	global $wpdb;
	$pref = $wpdb->prefix;
	$resultados = $wpdb->get_results( $wpdb->prepare( "select id, post_title as puesto,meta_value as guid from {$pref}posts p inner join {$pref}postmeta m on p.id = m.post_id where post_status = %s and post_type = %s and meta_key = %s and meta_value = %s;", 'publish', 'imgx_puesto', 'imgx_guid', $current_guid ), 'ARRAY_A' );
	if( count( $resultados ) > 0 ) {
		return $resultados[ 0 ][ "puesto" ];
	}
	return "";
}

function IMGX_GetDataPuesto( $guid, $is_guid = true ) {
	global $wpdb;
	$pref = $wpdb->prefix;
	if( $is_guid ) {
		$post_id = $wpdb->get_results( $wpdb->prepare( "select post_id from {$pref}postmeta where meta_key = %s and meta_value = %s;", 'imgx_guid', $guid ), 'ARRAY_A' )[ 0 ][ "post_id" ];
	} else {
		$post_id = $guid;
	}
	if( is_numeric( $post_id ) && intval( $post_id ) > 0 ) {
		$data = $wpdb->get_results( $wpdb->prepare( "select id, post_title, guid from {$pref}posts where id = %s;", $post_id ), 'ARRAY_A' )[ 0 ];
		return $data;
	}
	return null;
}

function IMGX_GetPuestoHierarchyHijos( $guid ) {
	global $wpdb;
	$pref = $wpdb->prefix;
	$data = $wpdb->get_results( $wpdb->prepare( "select post_id from {$pref}postmeta where meta_key = %s and meta_value = %s;", 'imgx_puesto_padre', $guid ), 'ARRAY_A' );
	$res = array();
	foreach( $data as $tmp ) {
		array_push( $res, $tmp[ "post_id" ] );
	}
	return $res;
}

function IMGX_GetGuid( $post_id ) {
	global $wpdb;
	$pref = $wpdb->prefix;
	$guid = $wpdb->get_results( $wpdb->prepare( "select meta_value from {$pref}postmeta where post_id = %s and meta_key = %s;", $post_id , 'imgx_guid' ), 'ARRAY_A' )[ 0 ][ "meta_value" ];
	return $guid;
}