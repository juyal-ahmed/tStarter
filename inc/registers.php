<?php
/**
 * Created by IntelliJ IDEA.
 * User: juyal
 * Date: 9/26/17
 * Time: 10:55 PM
 */

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( !function_exists("trtitan_widgets_init")){
    function trtitan_widgets_init() {
        register_sidebar(array(
            'name' => esc_html__( 'Main Sidebar', TRTHEME_LANG_DOMAIN ),
            'id' => 'main-sidebar',
            'description'   => 'Site default main sidebar for blog.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => esc_html__( 'Page Sidebar', TRTHEME_LANG_DOMAIN ),
            'id' => 'page-sidebar',
            'description'   => 'Site default page sidebar.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => esc_html__( 'Footer Col 1', TRTHEME_LANG_DOMAIN ),
            'id' => 'footer1',
            'description'   => 'Site footer column one widget area.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => esc_html__( 'Footer Col 2', TRTHEME_LANG_DOMAIN ),
            'id' => 'footer2',
            'description'   => 'Site footer column two widget area.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => esc_html__( 'Footer Col 3', TRTHEME_LANG_DOMAIN ),
            'id' => 'footer3',
            'description'   => 'Site footer column three widget area.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => esc_html__( 'Footer Col 4', TRTHEME_LANG_DOMAIN ),
            'id' => 'footer4',
            'description'   => 'Site footer column four widget area.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));

        if ( is_plugin_active( 'umamah/index.php' ) ) {
            // plugin dependent sidebars
        }
    }
    add_action( 'widgets_init', 'trtitan_widgets_init' );
}

// enqueue all required styles for umamah
if( !function_exists( "trtitan_theme_styles" ) ) {
    function trtitan_theme_styles() {
        global $wp, $post;

        if ( is_admin() ) { return false; }

        //registering and enqueing all theme required css
        if ( false ) { //If you have any other conditions to skip default resource loading

        } else {
            wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/bower_components/font-awesome/css/font-awesome.css' );
            wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/bower_components/bootstrap/dist/css/bootstrap.css', array(), '1.0', 'all' );
            wp_enqueue_style( 'chosen', get_template_directory_uri() . '/bower_components/chosen/chosen.css', array(), '1.2', 'all' );
            wp_enqueue_style( 'prettyPhoto', get_template_directory_uri() . '/bower_components/jquery-prettyPhoto/css/prettyPhoto.css', array(), '1.2', 'all' );
            //wp_enqueue_style( 'global', get_asset_stylesheet_uri('global'), array(), '1.0', 'all' );    //Main theme stylesheet
            //wp_enqueue_style( 'header', get_asset_stylesheet_uri('header'), array(), '1.0', 'all' );    //Main theme stylesheet
            //wp_enqueue_style( 'sidebar', get_asset_stylesheet_uri('sidebar'), array(), '1.0', 'all' );    //Main theme stylesheet
            //wp_enqueue_style( 'footer', get_asset_stylesheet_uri('footer'), array(), '1.0', 'all' );    //Main theme stylesheet
            wp_enqueue_style( 'app', get_public_stylesheet_uri('app'), array(), '1.0', 'all' );    //Main theme stylesheet
            wp_enqueue_style( TRTHEME_LANG_DOMAIN, get_stylesheet_uri(), array(), '1.0', 'all' );    //Main theme stylesheet
        }
    }
}
add_action( 'wp_enqueue_scripts', 'trtitan_theme_styles' );


// enqueue all required javascript for umamah
if( !function_exists( "trtitan_theme_js" ) ) {
    function trtitan_theme_js(){
        global $wp;

        if ( is_admin() ) { return false; }

        //registering and enqueing all theme required jacvascripts
        if ( false ) { //If you have any other conditions to skip default resource loading

        } else {

            wp_enqueue_script( 'jquery' );

            wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bower_components/bootstrap/dist/js/bootstrap.js', array('jquery'), '1.2', true );
            wp_enqueue_script( 'prettyPhoto', get_template_directory_uri() . '/bower_components/jquery-prettyPhoto/js/jquery.prettyPhoto.js', array('jquery'), '1.2', true );

            // wp_enqueue_script( 'trtitan-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20120206', true );
            wp_enqueue_script( 'trtitan-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20130115', true );
            if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
            }

            wp_enqueue_script( TRTHEME_LANG_DOMAIN, get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), '1.3', true ); //Umamah custm javascript
            wp_enqueue_script( 'app', get_public_js_uri('app'), array('jquery'), '1.3', true ); //Umamah custm javascript
            wp_localize_script( TRTHEME_LANG_DOMAIN, 'Youtha', array(
                'ajaxurl' => admin_url('admin-ajax.php')
            ));
        }
    }
}
add_action( 'wp_enqueue_scripts', 'trtitan_theme_js' );

if( !function_exists( "trtitan_theme_admin_js" ) ) {
    function trtitan_theme_admin_js(){
        global $wp;

        if ( is_admin() ) {
            wp_enqueue_script( 'trtitan-custom-admin-js', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), '1.3', true ); //Umamah custm javascript
            wp_localize_script( 'trtitan-custom-admin-js', 'Umamah', array(
                'ajaxurl' => admin_url('admin-ajax.php')
            ));
        }

        return true;
    }
}
add_action( 'admin_enqueue_scripts', 'trtitan_theme_admin_js' );
