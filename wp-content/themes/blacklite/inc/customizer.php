<?php
/**
 * blacklite Theme Customizer.
 *
 * @package blacklite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blacklite_customize_register( $wp_customize ) {

	require_once get_template_directory().'/inc/customizer-controls.php';

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->add_panel( 'theme_options' ,
        array(
            'title'       => esc_html__( 'Theme Options', 'blacklite' ),
            'description' => ''
        )
    );

    // Sidebar settings
    $wp_customize->add_section( 'blacklite_home_sidebar' ,
        array(
            'title'       => esc_html__( 'Sidebar', 'blacklite' ),
            'description' => '',
            'panel'       => 'theme_options',
            'piority'     => 2
        )
    );

    $wp_customize->add_setting( 'blacklite_home_sidebar', array(
        'sanitize_callback' => 'blacklite_sanitize_checkbox',
        'default' => false,
    ) );

    $wp_customize->add_control(
        'blacklite_home_sidebar',
            array(
                'type' => 'checkbox',
                'label'      => esc_html__( 'Disable Sidebar on Home Page, Archive Page', 'blacklite' ),
                'section'    => 'blacklite_home_sidebar',
            )
    );

    $wp_customize->add_setting( 'blacklite_sidebar_post', array(
        'sanitize_callback' => 'blacklite_sanitize_checkbox',
        'default' => false,
    ) );

    $wp_customize->add_control(
        'blacklite_sidebar_post',
            array(
                'type' => 'checkbox',
                'label'      => esc_html__( 'Disable Sidebar on Single Post', 'blacklite' ),
                'section'    => 'blacklite_home_sidebar',
            )
    );

    $wp_customize->add_setting( 'blacklite_sidebar_page', array(
        'sanitize_callback' => 'blacklite_sanitize_checkbox',
        'default' => false,
    ) );

    $wp_customize->add_control(
        'blacklite_sidebar_page',
            array(
                'type' => 'checkbox',
                'label'      => esc_html__( 'Disable Sidebar on Single Page', 'blacklite' ),
                'section'    => 'blacklite_home_sidebar',
            )
    );

    // Social Media Settings
    $wp_customize->add_section( 'blacklite_social' ,
        array(
            'title'      => esc_html__('Social Media Settings', 'blacklite'),
            'description'=> esc_html__('Enter your social media(URL). Icons will not show if left blank.', 'blacklite'),
            'priority'   => 4,
            'panel'       => 'theme_options',
        ) 
    );

        $wp_customize->add_setting(
            'blacklite_facebook',
            array(
                'default'     => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_setting(
            'blacklite_twitter',
            array(
                'default'     => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_setting(
            'blacklite_instagram',
            array(
                'default'     => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_setting(
            'blacklite_pinterest',
            array(
                'default'     => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_setting(
            'blacklite_tumblr',
            array(
                'default'     => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_setting(
            'blacklite_bloglovin',
            array(
                'default'     => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_setting(
            'blacklite_google',
            array(
                'default'     => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_setting(
            'blacklite_youtube',
            array(
                'default'     => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_setting(
            'blacklite_soundcloud',
            array(
                'default'     => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_setting(
            'blacklite_vimeo',
            array(
                'default'     => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_setting(
            'blacklite_linkedin',
            array(
                'default'     => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_setting(
            'blacklite_rss',
            array(
                'default'     => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );


    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'blacklite_facebook',
            array(
                'label'      => esc_html__('Facebook', 'blacklite'),
                'section'    => 'blacklite_social',
                'settings'   => 'blacklite_facebook',
                'type'       => 'text',
                'priority'   => 1
            )
        )
    );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'blacklite_twitter',
                array(
                    'label'      => esc_html__('Twitter', 'blacklite'),
                    'section'    => 'blacklite_social',
                    'settings'   => 'blacklite_twitter',
                    'type'       => 'text',
                    'priority'   => 2
                )
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'blacklite_instagram',
                array(
                    'label'      => esc_html__('Instagram', 'blacklite'),
                    'section'    => 'blacklite_social',
                    'settings'   => 'blacklite_instagram',
                    'type'       => 'text',
                    'priority'   => 3
                )
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'blacklite_pinterest',
                array(
                    'label'      => esc_html__('Pinterest', 'blacklite'),
                    'section'    => 'blacklite_social',
                    'settings'   => 'blacklite_pinterest',
                    'type'       => 'text',
                    'priority'   => 4
                )
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'blacklite_bloglovin',
                array(
                    'label'      => esc_html__('Bloglovin', 'blacklite'),
                    'section'    => 'blacklite_social',
                    'settings'   => 'blacklite_bloglovin',
                    'type'       => 'text',
                    'priority'   => 5
                )
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'blacklite_google',
                array(
                    'label'      => esc_html__('Google Plus', 'blacklite'),
                    'section'    => 'blacklite_social',
                    'settings'   => 'blacklite_google',
                    'type'       => 'text',
                    'priority'   => 6
                )
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'blacklite_tumblr',
                array(
                    'label'      => esc_html__('Tumblr', 'blacklite'),
                    'section'    => 'blacklite_social',
                    'settings'   => 'blacklite_tumblr',
                    'type'       => 'text',
                    'priority'   => 7
                )
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'blacklite_youtube',
                array(
                    'label'      => esc_html__('Youtube', 'blacklite'),
                    'section'    => 'blacklite_social',
                    'settings'   => 'blacklite_youtube',
                    'type'       => 'text',
                    'priority'   => 8
                )
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'blacklite_soundcloud',
                array(
                    'label'      => esc_html__('Soundcloud', 'blacklite'),
                    'section'    => 'blacklite_social',
                    'settings'   => 'blacklite_soundcloud',
                    'type'       => 'text',
                    'priority'   => 9
                )
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'blacklite_vimeo',
                array(
                    'label'      => esc_html__('Vimeo', 'blacklite'),
                    'section'    => 'blacklite_social',
                    'settings'   => 'blacklite_vimeo',
                    'type'       => 'text',
                    'priority'   => 10
                )
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'blacklite_linkedin',
                array(
                    'label'      => esc_html__('Linkedin', 'blacklite'),
                    'section'    => 'blacklite_social',
                    'settings'   => 'blacklite_linkedin',
                    'type'       => 'text',
                    'priority'   => 11
                )
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'blacklite_rss',
                array(
                    'label'      => esc_html__('Rss', 'blacklite'),
                    'section'    => 'blacklite_social',
                    'settings'   => 'blacklite_rss',
                    'type'       => 'text',
                    'priority'   => 12
                )
            )
        );



    // Black Pro
	$wp_customize->add_section( 'blacklite_pro' ,
	    array(
	        'title'       => esc_html__( 'Upgrade to Black Pro', 'blacklite' ),
	        'description' => '',
	        //'panel'       => 'theme_options',
	        'piority'     => 5
	    )
	);

	$wp_customize->add_setting( 'blacklite_features', array(
            'sanitize_callback' => 'sanitize_text_field',
        ) );
	$wp_customize->add_control(
            new blacklite_Customize_Pro_Control(
                $wp_customize,
                'blacklite_features',
                array(
                    'label'      => esc_html__( 'Black Features', 'blacklite' ),
                    'description'   => sprintf( __('<span>WooCommerce Compatible (<a target="_blank" href="https://zthemes.net/z-black/shop">Shop Demo</a>)</span><span>Featured slider (<a target="_blank" href="https://zthemes.net/z-black/">Demo</a>)</span><span>10 Different Blog Layouts</span><span>3 Useful Promo Boxes</span><span>50+ Customizable coloring options</span><span>4 Custom Widgets</span><span>Posts/Page Settings</span><span>Footer Copyright Text</span><span>Lifetime Upgrades</span><span>LifeTime Support</span><span>Mailchimp Support</span><span>Well Documented</span><span>Child Theme included</span><span>And More...</span>','blacklite')),
                    'section'    => 'blacklite_pro',
                )
            )
	);
	$wp_customize->add_setting( 'blacklite_pro_links', array(
            'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control(
		new blacklite_Customize_Pro_Control(
			$wp_customize,
			'blacklite_pro_links',
			array(
				'description'   => sprintf( __('<a target="_blank" class="blacklite-buy-button" href="https://zthemes.net/themes/black/">Buy Now</a>', 'blacklite')),
				'section'    => 'blacklite_pro',
			)
        )
	);

}
add_action( 'customize_register', 'blacklite_customize_register' );

function blacklite_sanitize_checkbox( $input ){
    if ( $input == 1 || $input == 'true' || $input === true ) {
        return 1;
    } else {
        return 0;
    }
}

function blacklite_sanitize_number( $number, $setting ) {
    $number = absint( $number );
    return ( $number ? $number : $setting->default );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blacklite_customize_preview_js() {
	wp_enqueue_script( 'blacklite_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'blacklite_customize_preview_js' );

/**
 * Load customizer style
 */
function blacklite_customizer_load_css(){
    wp_enqueue_style( 'blacklite-customizer', get_template_directory_uri() . '/css/customizer.css' );
}
add_action('customize_controls_print_styles', 'blacklite_customizer_load_css');
