<?php
/**
 * All defined constants of the theme
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeredesign.com
 */

if ( ! function_exists( 'youtha_setup' ) ) {
    function youtha_setup() {
        load_theme_textdomain( 'youtha', get_template_directory() . '/languages' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary Menu', 'youtha' ),
        ) );

        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        add_theme_support( 'post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
        ) );

        add_theme_support( 'custom-background', apply_filters( 'youtha_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) ) );
    }
}
add_action( 'after_setup_theme', 'youtha_setup' );

if ( !function_exists('youtha_content_width')) {
    function youtha_content_width()
    {
        $GLOBALS['content_width'] = apply_filters('youtha_content_width', 640);
    }
}
add_action( 'after_setup_theme', 'youtha_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function youtha_scripts() {
    if ( is_admin() ) { return false; }

    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/bower_components/font-awesome/css/font-awesome.css' );
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/bower_components/bootstrap/dist/css/bootstrap.css', array(), '1.0', 'all' );
    wp_enqueue_style( 'chosen', get_template_directory_uri() . '/assets/bower_components/chosen/chosen.css', array(), '1.2', 'all' );
    wp_enqueue_style( 'prettyPhoto', get_template_directory_uri() . '/assets/bower_components/jquery-prettyPhoto/css/prettyPhoto.css', array(), '1.2', 'all' );
    wp_enqueue_style( 'youtha', get_stylesheet_uri(), array(), '1.0', 'all' );    //Main theme stylesheet


    wp_enqueue_script( 'youtha-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
    wp_enqueue_script( 'youtha-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'youtha_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * Load Titan Framework options
 */
require get_template_directory() . '/titan-options.php';