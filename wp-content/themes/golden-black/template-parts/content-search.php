<article class="fvp-post-on-blog">
  <div class="row">
    <?php if ( has_post_thumbnail() ): ?>
    <div class="small-12 medium-6 columns">
      <a href="<?php the_permalink(); ?>" class="fvp-featured-image">
        <?php the_post_thumbnail('golden_black_post_thumbnail'); ?>
      </a>
    </div>
    <?php endif; ?>
    <?php if ( has_post_thumbnail() ): ?><div class="small-12 medium-6 columns"><?php else: ?><div class="small-12 columns"><?php endif; ?>
      <header>
        <h2 class="fvp-post-title">
          <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
        </h2>
      </header>
      <div class="fvp-post-content">
        <?php the_excerpt(); ?>
      </div>
      <div class="fvp-permalink-container">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="fvp-permalink-button"><?php esc_html_e( 'Read More', 'golden-black' ); ?></a>
      </div>
    </div>
  </div>

</article>
