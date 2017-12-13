<?php
/**
 * All defined constants of the theme
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeredesign.com
 */

if ( ! function_exists( 'trtitan_setup' ) ) {
    function trtitan_setup() {
        load_theme_textdomain( 'youtha', get_template_directory() . '/languages' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_editor_style( 'editor-style.css' );
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
            'gallery',
            'video',
            'quote',
            'link',
        ) );

        add_theme_support( 'custom-background', apply_filters( 'trtitan_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) ) );
    }
}
add_action( 'after_setup_theme', 'trtitan_setup' );

if ( !function_exists('trtitan_content_width')) {
    function trtitan_content_width()
    {
        $GLOBALS['content_width'] = apply_filters('trtitan_content_width', 640);
    }
}
add_action( 'after_setup_theme', 'trtitan_content_width', 0 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/titan/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/titan/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/titan/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/titan/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/titan/jetpack.php';
