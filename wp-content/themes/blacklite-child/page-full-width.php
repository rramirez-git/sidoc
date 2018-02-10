<?php
/*
    Template Name: Pagina de Ancho Completo (Full Width)
*/

get_header(); 

$blacklite_sidebar_page = get_theme_mod( 'blacklite_sidebar_page' );

?>

	<div id="primary" class="content-area container">
		<main id="main" class="site-main full-width" role="main">

			<?php
			while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->

				</article><!-- #post-## -->

            <?php
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->

	</div><!-- #primary -->

<?php
get_footer(); ?>