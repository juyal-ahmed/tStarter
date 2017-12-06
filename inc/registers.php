<?php
/**
 * Created by IntelliJ IDEA.
 * User: juyal
 * Date: 9/26/17
 * Time: 10:55 PM
 */

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( !function_exists("umamah_widgets_init")){
    function umamah_widgets_init() {
        register_sidebar(array(
            'name' => __( 'Main Sidebar', LANG_DOMAIN ),
            'id' => 'main-sidebar',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __( 'Page Sidebar', LANG_DOMAIN ),
            'id' => 'page-sidebar',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __( 'Footer Col 1', LANG_DOMAIN ),
            'id' => 'footer1',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __( 'Footer Col 2', LANG_DOMAIN ),
            'id' => 'footer2',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => __( 'Footer Col 3', LANG_DOMAIN ),
            'id' => 'footer3',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        if ( is_plugin_active( 'umamah/index.php' ) ) {
            // plugin dependent sidebars
        }
    }
    add_action( 'widgets_init', 'umamah_widgets_init' );
}

// enqueue all required styles for umamah
if( !function_exists( "umamah_theme_styles" ) ) {
    function umamah_theme_styles() {
        global $wp, $post;

        if ( is_admin() ) { return false; }

        //registering and enqueing all theme required css
        if ( false ) { //If you have any other conditions to skip default resource loading

        } else {
            wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/bower_components/font-awesome/css/font-awesome.css' );
            wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/bower_components/bootstrap/dist/css/bootstrap.css', array(), '1.0', 'all' );
            wp_enqueue_style( 'chosen', get_template_directory_uri() . '/assets/bower_components/chosen/chosen.css', array(), '1.2', 'all' );
            wp_enqueue_style( 'prettyPhoto', get_template_directory_uri() . '/assets/bower_components/jquery-prettyPhoto/css/prettyPhoto.css', array(), '1.2', 'all' );
            wp_enqueue_style( 'youtha', get_stylesheet_uri(), array(), '1.0', 'all' );    //Main theme stylesheet
        }
    }
}
add_action( 'wp_enqueue_scripts', 'umamah_theme_styles' );


// enqueue all required javascript for umamah
if( !function_exists( "umamah_theme_js" ) ) {
    function umamah_theme_js(){
        global $wp;

        if ( is_admin() ) { return false; }

        //registering and enqueing all theme required jacvascripts
        if ( false ) { //If you have any other conditions to skip default resource loading

        } else {

            wp_enqueue_script( 'jquery' );

            wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/bower_components/bootstrap/dist/js/bootstrap.js', array('jquery'), '1.2', true );
            wp_enqueue_script( 'hoverIntent-js', get_template_directory_uri() . '/assets/bower_components/superfish/dist/js/hoverIntent.js', array('jquery'), '1.2', true );
            wp_enqueue_script( 'superfish-js', get_template_directory_uri() . '/assets/bower_components/superfish/dist/js/superfish.js', array('jquery'), '1.2', true );
            wp_enqueue_script( 'chosen-js', get_template_directory_uri() . '/assets/bower_components/chosen/chosen.jquery.js', array('jquery'), '1.2', true );
            wp_enqueue_script( 'prettyPhoto', get_template_directory_uri() . '/assets/bower_components/jquery-prettyPhoto/js/jquery.prettyPhoto.js', array('jquery'), '1.2', true );

            wp_enqueue_script( 'youtha-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
            wp_enqueue_script( 'youtha-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
            if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
            }

            wp_enqueue_script( 'youtha', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), '1.3', true ); //Umamah custm javascript
            wp_localize_script( 'youtha', 'Youtha', array(
                'ajaxurl' => admin_url('admin-ajax.php')
            ));
        }
    }
}
add_action( 'wp_enqueue_scripts', 'umamah_theme_js' );

if( !function_exists( "umamah_theme_admin_js" ) ) {
    function umamah_theme_admin_js(){
        global $wp;

        if ( is_admin() ) {
            wp_enqueue_script( 'umamah-custom-admin-js', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), '1.3', true ); //Umamah custm javascript
            wp_localize_script( 'umamah-custom-admin-js', 'Umamah', array(
                'ajaxurl' => admin_url('admin-ajax.php')
            ));
        }

        return true;
    }
}
add_action( 'admin_enqueue_scripts', 'umamah_theme_admin_js' );

add_filter( 'image_resize_dimensions', 'custom_image_resize_dimensions', 10, 6 );
function custom_image_resize_dimensions( $payload, $orig_w, $orig_h, $dest_w, $dest_h, $crop ){

    // Change this to a conditional that decides whether you
    // want to override the defaults for this image or not.
    if( false )
        return $payload;

    if ( $crop ) {
        // crop the largest possible portion of the original image that we can size to $dest_w x $dest_h
        $aspect_ratio = $orig_w / $orig_h;
        $new_w = min($dest_w, $orig_w);
        $new_h = min($dest_h, $orig_h);

        if ( !$new_w ) {
            $new_w = intval($new_h * $aspect_ratio);
        }

        if ( !$new_h ) {
            $new_h = intval($new_w / $aspect_ratio);
        }

        $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

        $crop_w = round($new_w / $size_ratio);
        $crop_h = round($new_h / $size_ratio);

        $s_x = floor( ($orig_w - $crop_w) / 2 );
        $s_y = 0; // [[ formerly ]] ==> floor( ($orig_h - $crop_h) / 2 );
    } else {
        // don't crop, just resize using $dest_w x $dest_h as a maximum bounding box
        $crop_w = $orig_w;
        $crop_h = $orig_h;

        $s_x = 0;
        $s_y = 0;

        list( $new_w, $new_h ) = wp_constrain_dimensions( $orig_w, $orig_h, $dest_w, $dest_h );
    }

    // if the resulting image would be the same size or larger we don't want to resize it
    if ( $new_w >= $orig_w && $new_h >= $orig_h )
        return false;

    // the return array matches the parameters to imagecopyresampled()
    // int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h
    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );

}