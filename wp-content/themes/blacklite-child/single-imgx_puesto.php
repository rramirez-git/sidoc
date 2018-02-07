<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package blacklite
 */

get_header(); 

$blacklite_sidebar_post = get_theme_mod( 'blacklite_sidebar_post' );

?>

	<div id="primary" class="content-area container">
		<main id="main" class="site-main full-width" role="main">

		<?php
		while ( have_posts() ) : 
			the_post(); 
			$metas = new MyMetas( get_the_ID() );
			$funciones = array();
			$tmp = explode( "\r", $metas->getMeta( 'imgx_puesto_funciones' ) );
			foreach( $tmp as $tmp2 ) {
				if( "" != trim( $tmp2 ) ) {
					array_push( $funciones, trim( $tmp2 ) );
				}
			}
			$data_padre = IMGX_GetDataPuesto( $metas->getMeta( 'imgx_puesto_padre' ) );
			$posts_hijo = IMGX_GetPuestoHierarchyHijos( $metas->getMeta( 'imgx_guid' ) );
			?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php
					the_title( '<h1 class="entry-title">Puesto: ', '</h1>' );
                    ?>
					<span class="title-divider"></span>
				</header><!-- .entry-header -->

				
				
				
				
				
<div class="management-hierarchy">
    <div class="hv-container">
        <div class="hv-wrapper">
            <div class="hv-item">
            	<?php if( null != $data_padre ):
            		echo IMGX_Organigrama_CreateItem( '<a href="' . $data_padre[ "guid" ] . '">' . $data_padre[ "post_title" ] . '</a>', "", "", true );
            		?>
                	<div class="hv-item-children">
	                <div class="hv-item-child">
	                    <div class="hv-item">
                <?php endif; 
                echo IMGX_Organigrama_CreateItem( '<strong style="font-size: 150%;">' . get_the_title() . '</strong>', "", "", count( $posts_hijo ) > 0 );
                echo IMGX_Organigrama_CreateChildren( $posts_hijo );
                if( null != $data_padre ): ?>
	                    </div>
	                </div>
	                
	                <?php echo IMGX_Organigrama_CreateItem( 'Otros Puestos' ); ?>
	                
	                </div>
	            <?php endif; ?>
            </div>
        </div>
    </div>
</div>				
				
				
				
				
				
				
				
				
				
				

				<div class="entry-content">
					<?php the_content(); ?>
					
					<?php if( count( $funciones ) > 0 ): ?>
						<h3>Funciones:</h3>
						<ol class="imgx-list">
							<?php foreach( $funciones as $tmp ): ?>
								<li><?php echo $tmp; ?></li>
							<?php endforeach; ?>
						</ol>
					<?php endif; ?>
					
				</div><!-- .entry-content -->
				
			</article><!-- #post-## -->

			<?php
		endwhile; // End of the loop.
		?>

		</main><!-- #main -->

	</div><!-- #primary -->

<?php
get_footer();