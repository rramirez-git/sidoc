<?php get_header(); ?>

      <main class="cd-main-content">
      <!-- main content here -->

        <section class="fvp-main-container">
          <div class="row">
            <section class="fvp-main-section">
              <div class="small-12 medium-8 large-9 columns">
                <?php if (have_posts()): while (have_posts()): the_post(); ?>

                  <article <?php post_class('fvp-single-post'); ?>>
                    <div class="row column">
                      <header>
                        <h1 class="fvp-single-post-title"><?php the_title(); ?></h1>
                      </header>
                    </div>
                    <div class="row column">
                      <?php edit_post_link(); ?>
                    </div>
                    <?php if ( has_post_thumbnail() ): ?>
                    <div class="row column">
                      <div class="fvp-post-thumbnail">
                        <?php the_post_thumbnail(); ?>
                      </div>
                    </div>
                    <?php endif; ?>
                    <div class="row column">
                      <div class="fvp-post-info clearfix">
                        <div class="float-left">
                          <?php printf( __('Posted on %1$s by %2$s', 'golden-black'), get_the_date(), get_the_author() ); ?>
                        </div>
                        <div class="float-right">
                          <?php the_category( $separator = ' | ' ); ?>
                        </div>
                      </div>
                    </div>
                    <div class="row column">
                      <div class="fvp-post-content">
                        <?php the_content(); ?>
                      </div>
                    </div>
                    <?php if (has_tag()): ?>
                    <div class="row column">
                      <div class="fvp-post-tags fvp-post-info">
                        <?php the_tags( $before = null, $sep = ', ', $after = '' ) ?>
                      </div>
                    </div>
                  <?php endif; ?>
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
