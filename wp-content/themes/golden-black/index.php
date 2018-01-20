
<?php get_header(); ?>

      <main class="cd-main-content">
      <!-- main content here -->

        <section class="fvp-main-container">
          <div class="row">
            <section class="fvp-main-section">
              <div class="small-12 medium-8 large-9 columns">
                <?php if (have_posts()): while (have_posts()): the_post(); ?>

                  <article class="fvp-single-post">
                    <div class="row column">
                      <header>
                        <h1 class="fvp-single-post-title"><?php the_title(); ?></h1>
                      </header>
                    </div>
                    <?php if ( has_post_thumbnail() ): ?>
                    <div class="row column">
                      <?php the_post_thumbnail(); ?>
                    </div>
                    <?php endif; ?>

                    <div class="row column">
                      <div class="fvp-post-content">
                        <?php the_content(); ?>
                      </div>
                    </div>

                  </article>
                  <?php if (comments_open()) { comments_template(); } ?>
                  <?php wp_link_pages(); ?>
                <?php endwhile; endif; ?>
              </div>
            </section>
            <?php get_sidebar(); ?>
          </div>
        </section>

      </main>
<?php get_footer(); ?>
