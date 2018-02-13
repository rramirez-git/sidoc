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
							"add_new" 				=> "Crear Nuevo Puesto",
							"add_new_item" 			=> "Nuevo Puesto",
							"edit_item" 			=> "Actualizar Puesto",
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
	add_shortcode( 'EstructuraOrganizacional', 'IMGX_GeneraEstructuraOrganizacional_SC' );
	add_shortcode( 'EstructuraOrganizacionalParcial', 'IMGX_GeneraEstructuraOrganizacional_SCP' );
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
						<td class="label">Shortcodes:</td>
						<td class="control">
							<input type="text" readonly="readonly" value="[EstructuraOrganizacional post=<?php echo $post->ID; ?>]" />
						</td>
					</tr>
					<tr>
						<td class="label">&nbsp;</td>
						<td class="control">
							<input type="text" readonly="readonly" value="[EstructuraOrganizacionalParcial post=<?php echo $post->ID; ?>]" />
						</td>
					</tr>
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

function IMGX_GeneraEstructuraOrganizacional_SC( $args ) {
	$args = shortcode_atts( array( 'post' => null ), $args );
	if( null == $args[ "post" ] || ! is_numeric( $args[ "post" ] ) ) {
		return "";
	}
	ob_start();
	IMGX_GeneraEstructuraOrganizacional( intval( $args[ "post" ] ) );
	$contenido = "\n" . ob_get_contents() . "\n";
	ob_end_clean();
	return $contenido;
}

function IMGX_GeneraEstructuraOrganizacional_SCP( $args ) {
	$args = shortcode_atts( array( 'post' => null ), $args );
	if( null == $args[ "post" ] || ! is_numeric( $args[ "post" ] ) ) {
		return "";
	}
	ob_start();
	IMGX_GeneraEstructuraOrganizacional_Parcial( intval( $args[ "post" ] ) );
	$contenido = "\n" . ob_get_contents() . "\n";
	ob_end_clean();
	return $contenido;
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

function IMGX_GetRoots() {
	global $wpdb;
	$pref = $wpdb->prefix;
	$res = array();
	$regs = $wpdb->get_results( $wpdb->prepare( "select post_id as id from {$pref}postmeta p where meta_key = %s and ( meta_value is null or length( p.meta_value ) = 0 ) and post_id in (select id from {$pref}posts where post_status = %s and post_type = %s )", 'imgx_puesto_padre', 'publish', 'imgx_puesto' ), 'ARRAY_A' );
	foreach( $regs as $reg ) {
		array_push( $res, $reg[ "id" ] );
	}
	return $res;
}

function IMGX_ProcesaPuesto( $post_id ) {
	$guid = IMGX_GetGuid( $post_id );
	$hijos = IMGX_GetPuestoHierarchyHijos( $guid );
	$data = IMGX_GetDataPuesto( $guid );
	?>
	<div class="hv-item">
		<?php if( count( $hijos ) > 0 ): ?>
			<div class="hv-item-parent">
				<?php echo IMGX_CreatePerson( '<a href="' . $data[ "guid" ] . '">' . $data[ "post_title" ] . '</a>' ); ?>
			</div>
			<div class="hv-item-children">
				<?php 
				$class_hijo_unico = ( count( $hijos ) == 1 ? 'hijo-unico' : '' );
				foreach( $hijos as $hijo ): ?>
					<div class="hv-item-child <?php echo $class_hijo_unico; ?>">
						<?php IMGX_ProcesaPuesto( $hijo ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<?php echo IMGX_CreatePerson( '<a href="' . $data[ "guid" ] . '">' . $data[ "post_title" ] . '</a>' ); ?>
		<?php endif; ?>
	</div>
	<?php
}

function IMGX_GeneraEstructuraOrganizacional( $post_puesto_raiz ) {
	?>
	<div class="management-hierarchy">
		<div class="hv-container">
			<div class="hv-wrapper">
				<?php IMGX_ProcesaPuesto( $post_puesto_raiz ); ?>
			</div>
		</div>
	</div>
	<?php
}

function IMGX_GeneraEstructuraOrganizacional_Parcial( $post_puesto ) {
	$metas = new MyMetas( $post_puesto );
	$data = IMGX_GetDataPuesto( $post_puesto, false );
	$data_padre = IMGX_GetDataPuesto( $metas->getMeta( 'imgx_puesto_padre' ) );
	$posts_hijo = IMGX_GetPuestoHierarchyHijos( $metas->getMeta( 'imgx_guid' ) );
	$posts_hermanos = array();
	if( null != $data_padre ) {
		$aux = IMGX_GetPuestoHierarchyHijos( IMGX_GetGuid( $data_padre[ "id" ] ) );
		foreach( $aux as $hermano ) {
			if( $hermano != $post_puesto ) {
				array_push( $posts_hermanos, $hermano );
			}
		}
	}
	?>
	<div class="management-hierarchy">
		<div class="hv-container">
			<div class="hv-wrapper">
				<?php if( null != $data_padre ): ?>
					<div class="hv-item">
						<div class="hv-item-parent">
							<?php echo IMGX_CreatePerson( '<a href="' . $data_padre[ "guid" ] . '">' . $data_padre[ "post_title" ] . '</a>' ); ?>
						</div>
						<div class="hv-item-children">
							<?php if( 0 == count( $posts_hermanos ) ): ?>
								<?php if( 0 == count( $posts_hijo ) ): ?>
									<div class="hv-item-child hijo-unico puesto_actual">
										<?php echo IMGX_CreatePerson( $data[ "post_title" ] ); ?>
									</div>
								<?php else: ?>
									<div class="hv-item-child hijo-unico">
										<div class="hv-item">
											<div class="hv-item-parent puesto_actual">
												<?php echo IMGX_CreatePerson( $data[ "post_title" ] ); ?>
											</div>
											<div class="hv-item-children">
												<?php foreach( $posts_hijo as $hijo ): ?>
													<?php $data_hijo = IMGX_GetDataPuesto( $hijo, false ); ?>
													<div class="hv-item-child">
														<?php echo IMGX_CreatePerson( '<a href="' . $data_hijo[ "guid" ] . '">' . $data_hijo[ "post_title" ] . '</a>' ); ?>
													</div>
												<?php endforeach; ?>
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php else: ?>
								<?php foreach( $posts_hermanos as $k => $hermano ): ?>
									<?php $data_hermano = IMGX_GetDataPuesto( $hermano, false ); ?>
									<?php if( floor( count( $posts_hermanos ) / 2 ) == $k ): ?>
										<?php if( 0 == count( $posts_hijo ) ): ?>
											<div class="hv-item-child puesto_actual">
												<?php echo IMGX_CreatePerson( $data[ "post_title" ] ); ?>
											</div>
										<?php else: ?>
											<div class="hv-item-child">
												<div class="hv-item">
													<div class="hv-item-parent puesto_actual">
														<?php echo IMGX_CreatePerson( $data[ "post_title" ] ); ?>
													</div>
													<div class="hv-item-children">
														<?php if( count( $posts_hijo ) == 1 ): ?>
															<?php 
															$hijo = $posts_hijo[ 0 ];
															$data_hijo = IMGX_GetDataPuesto( $hijo, false ); 
															?>
															<div class="hv-item-child hijo-unico">
																<?php echo IMGX_CreatePerson( '<a href="' . $data_hijo[ "guid" ] . '">' . $data_hijo[ "post_title" ] . '</a>' ); ?>
															</div>
														<?php else: ?>
															<?php foreach( $posts_hijo as $hijo ): ?>
																<?php $data_hijo = IMGX_GetDataPuesto( $hijo, false ); ?>
																<div class="hv-item-child">
																	<?php echo IMGX_CreatePerson( '<a href="' . $data_hijo[ "guid" ] . '">' . $data_hijo[ "post_title" ] . '</a>' ); ?>
																</div>
															<?php endforeach; ?>
														<?php endif; ?>
													</div>
												</div>
											</div>
										<?php endif; ?>
									<?php endif; ?>
									<div class="hv-item-child">
										<?php echo IMGX_CreatePerson( '<a href="' . $data_hermano[ "guid" ] . '">' . $data_hermano[ "post_title" ] . '</a>' ); ?>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					</div>
				<?php else: ?>
					<?php if( 0 == count( $posts_hijo ) ): ?>
						<div class="hv-item puesto_actual">
							<?php echo IMGX_CreatePerson( $data[ "post_title" ] ); ?>
						</div>
					<?php else: ?>
						<div class="hv-item">
							<div class="hv-item-parent puesto_actual">
								<?php echo IMGX_CreatePerson( $data[ "post_title" ] ); ?>
							</div>
							<div class="hv-item-children">
								<?php $class_unico = ( 1 == count( $posts_hijo ) ? 'hijo-unico' : '' ); ?>
								<?php foreach( $posts_hijo as $hijo ): ?>
									<?php $data_hijo = IMGX_GetDataPuesto( $hijo, false ); ?>
									<div class="hv-item-child <?php echo $class_unico; ?>">
										<?php echo IMGX_CreatePerson( '<a href="' . $data_hijo[ "guid" ] . '">' . $data_hijo[ "post_title" ] . '</a>' ); ?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
}

