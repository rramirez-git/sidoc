<?php if( in_the_loop() ): ?>
		<?php
			$thumb_id = get_post_thumbnail_id();

			$target = '';
			if ( get_theme_mod( 'social_target', 1 ) == 1 ) {
				$target = 'target="_blank"';
			}

			$facebook = add_query_arg( array(
				'u' => get_permalink(),
			), 'https://www.facebook.com/sharer.php' );

			$twitter = add_query_arg( array(
				'url' => get_permalink(),
			), 'https://twitter.com/share' );

			$gplus = add_query_arg( array(
				'url' => get_permalink(),
			), 'https://plus.google.com/share' );

			$pinterest = add_query_arg( array(
				'url'         => get_permalink(),
				'description' => get_the_title(),
				'media'       => blacklite_light_get_image_src( get_post_thumbnail_id(), 'large' ),
			), 'https://pinterest.com/pin/create/bookmarklet/' );
		?>
		
	<a href="<?php echo esc_url( $facebook ); ?>" <?php echo $target; ?> class="share-box"><i class="fa fa-facebook"></i></a>
	<a href="<?php echo esc_url( $twitter ); ?>" <?php echo $target; ?> class="share-box"><i class="fa fa-twitter"></i></a>
	<a href="<?php echo esc_url( $gplus ); ?>" <?php echo $target; ?> class="share-box"><i class="fa fa-google-plus"></i></a>
<?php if ( ! empty( $thumb_id ) ): ?>
	<a href="<?php echo esc_url( $pinterest ); ?>" <?php echo $target; ?> class="social-icon"><i class="fa fa-pinterest"></i></a>
<?php endif; ?>

<?php endif; ?>