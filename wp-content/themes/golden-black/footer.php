    </main> <!-- fvpgb_main-content -->
    <footer class="fvp-site-footer">
      <div class="row">
        <div class="small-12 medium-6 columns">
          <?php dynamic_sidebar('footer-left'); ?>
        </div>
        <div class="small-12 medium-6 columns">
          <?php dynamic_sidebar('footer-right'); ?>
        </div>
      </div>
      <div class="row column">
        <div class="copyright-footer">
          <?php echo date_i18n( esc_html__( 'Y', 'golden-black' ) ) ?> &copy; <?php bloginfo('name') ?>. <?php esc_html_e( 'Powered by WordPress and Golden Black Theme', 'golden-black' ); ?>
        </div>
      </div>
    </footer>

    <!-- Menu -->
    <?php if (has_nav_menu('primary')) { wp_nav_menu( array(
      'theme_location'=>'primary',
      'container'=>'nav',
      'container_id' => 'fvpgoldenblack_pmenu',
      'depth' => 3
    ) ); } ?>

    <?php wp_footer(); ?>
  </body>
</html>
