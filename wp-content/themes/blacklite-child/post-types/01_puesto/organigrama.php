<?php
function IMGX_CreatePerson( $puesto, $picture = "", $name = "" ) {
	ob_start();
	if( "" == $picture) {
		$picture = IMGX_GetRandomUsrInfo()[ "picture" ][ "large" ];
	}
	?>
	<div class="person">
        <img src="<?php echo $picture ; ?>" />
        <p class="name"><?php echo ( "" != $name ? $name . ' / ' : '' ) . $puesto; ?></p>
    </div>
	<?php
	$contenido = "\n" . ob_get_contents() . "\n";
	ob_end_clean();
	return $contenido;
}

function IMGX_Organigrama_CreateItem( $puesto, $picture = "", $name = "", $is_padre = false, $is_hijo_unico = false, $debug = false ) {
	ob_start();
	$hirerachy_class = ( $is_padre ? 'hv-item-parent' : 'hv-item-child' );
	$unique_class = ( $is_hijo_unico ? 'hijo-unico' : '' );
	?>
	<div class="<?php echo "$hirerachy_class $unique_class"; ?>"><?php if( $debug ) { var_dump( func_get_args() ); } ?>
        <?php echo IMGX_CreatePerson( $puesto, $picture, $name ); ?>
	</div>
	<?php
	$contenido = "\n" . ob_get_contents() . "\n";
	ob_end_clean();
	return $contenido;
}

function IMGX_Organigrama_CreateChildren( $children_list ) {
	ob_start();
	if( count( $children_list ) > 0 ): ?>
		<div class="hv-item-children">
		    <?php foreach( $children_list as $tmp ): 
		        $data_hijo = IMGX_GetDataPuesto( $tmp, false );
		        echo IMGX_Organigrama_CreateItem( '<a href="' . $data_hijo[ "guid" ] . '">' . $data_hijo[ "post_title" ] . '</a>', '', '', false, count( $posts_hijo ) == 1 );
		    endforeach; ?>
		</div>
	<?php endif;
	$contenido = "\n" . ob_get_contents() . "\n";
	ob_end_clean();
	return $contenido;
}
?>
