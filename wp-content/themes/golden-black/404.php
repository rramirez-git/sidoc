<?php get_header(); ?>

      <main class="cd-main-content">
      <!-- main content here -->

        <section class="fvp-main-container">
          <div class="row">
            <section class="fvp-main-section">
              <div class="small-12 medium-8 large-9 columns">
                <h1 class="fvp-404-title"><?php esc_html_e( 'Sorry, page not found', 'golden-black' ); ?></h1>
                <div class="fvp-404-content">
                  <?php esc_html_e( 'It looks like nothing was found at this location.', 'golden-black' ); ?>
                </div>
              </div>
            </section>
            <?php get_sidebar( '404' ); ?>
            </aside>
          </div>
        </section>

      </main>
<?php get_footer(); ?>
