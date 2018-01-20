<?php get_header(); ?>

      <main class="cd-main-content">
      <!-- main content here -->

        <section class="fvp-main-container">
          <div class="row">
            <section class="fvp-main-section">
              <div class="small-12 medium-12 large-9 columns">
                <?php if (have_posts()): ?>
                  <header class="fvp-archive-header">
                    <?php
                      the_archive_title( '<h1 class="fvp-archive-title">', '</h1>' );
                      the_archive_description( '<div class="fvp-archive-description">', '</div>' );
                    ?>
                  </header>

                  <?php while (have_posts()): the_post(); ?>

                  <?php get_template_part( 'template-parts/content', 'blog' ) ?>

                <?php endwhile; ?>
                <div class="row column">
                  <div class="fvp-pagination text-center">
                    <?php the_posts_pagination(); ?>
                  </div>
                </div>
                <?php endif; ?>
              </div>
            </section>
            <?php get_sidebar(); ?>
          </div>
        </section>

      </main>
<?php get_footer(); ?>
