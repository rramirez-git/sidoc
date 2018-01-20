<?php get_header(); ?>

      <main class="cd-main-content">
      <!-- main content here -->

        <section class="fvp-main-container">
          <div class="row">
            <section class="fvp-main-section">
              <div class="small-12 medium-8 large-9 columns">
                <h1 class="fvp-search-results-title"><?php esc_html_e( 'Search Results for "', 'golden-black' ) ?><?php echo get_search_query(); ?>":</h1>
                <?php if (have_posts()): while (have_posts()): the_post(); ?>

                  <?php get_template_part( 'template-parts/content', 'search' ) ?>

                <?php endwhile; ?>
                <div class="row column">
                  <div class="fvp-pagination text-center">
                    <?php the_posts_pagination(); ?>
                  </div>
                </div>
                <?php endif; ?>
              </div>
            </section>
            <?php get_sidebar( 'search' ); ?>
            </aside>
          </div>
        </section>

      </main>
<?php get_footer(); ?>
