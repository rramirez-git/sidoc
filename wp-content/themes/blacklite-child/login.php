<?php
add_action( 'login_enqueue_scripts', 'LoginLogo_Child' );
add_filter( 'login_headerurl', 'LoginLogoURL_Child' );
add_filter( 'login_headertitle', 'LoginLogoURLTitle_Child' );

function LoginLogo_Child() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url( '<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.png' );
    </style>
<?php }
function LoginLogoURL_Child() {
    return home_url();
}
function LoginLogoURLTitle_Child() {
    return 'SiDoc';
}
