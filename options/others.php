<?php
/**
 * Others - Theme option
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeana.com
 */

/*
---------------------------------------------------------------------------------------
	Registering Others Theme Options
---------------------------------------------------------------------------------------
*/
function trtheme_others_theme_options() {
    global $theme_option;
    $tab = $theme_option->createTab( array(
        'name' => 'Others',
    ) );

    $tab->createOption( array(
        'name' => 'Global Notice HTML',
        'id' => 'others_notice_html',
        'default' => '',
        'desc' => '',
        'type' => 'editor'
    ) );

    $tab->createOption( array(
        'name' => 'Footer Copyright',
        'id' => 'others_footer_copyright',
        'default' => '',
        'desc' => '',
        'type' => 'editor'
    ) );

    $tab->createOption( array(
        'name' => 'Custom CSS',
        'id' => 'others_custom_css',
        'default' => '',
        'desc' => '',
        'type' => 'textarea'
    ) );

    $tab->createOption( array(
        'name' => 'Google Analytics',
        'id' => 'others_google_analytics',
        'default' => '',
        'desc' => 'Do not place html/head/body tags here. Insert the tags as would normally be used in your body element. &lt;script&gt; tags ARE allowed, though they are best placed at the end of your HTML',
        'type' => 'textarea'
    ) );

    $tab->createOption( array(
        'type' => 'save',
    ) );
}
add_action( 'tf_create_options', 'trtheme_others_theme_options' );
