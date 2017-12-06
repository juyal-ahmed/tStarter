<?php
/**
 * Pages - Theme option
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeredesign.com
 */

/*
---------------------------------------------------------------------------------------
	Registering Pages Theme Options
---------------------------------------------------------------------------------------
*/
function trtheme_pages_theme_options() {
    global $theme_option;
    $tab = $theme_option->createTab( array(
        'name' => 'Pages',
    ) );

    $tab->createOption( array(
        'type' => 'note',
        'desc' => 'Here you can save some page settings of your site '. get_bloginfo( 'name' ) .', so the system can automatically generate the right url for a page to use them on different area.'
    ) );

    $tab->createOption( array(
        'name' => 'Contact',
        'id' => 'pages_contact',
        'desc' => '',
        'type' => 'select-pages'
    ) );

    $tab->createOption( array(
        'name' => 'Terms and Condition',
        'id' => 'pages_toc',
        'desc' => '',
        'type' => 'select-pages'
    ) );

    $tab->createOption( array(
        'name' => 'Terms of Service',
        'id' => 'pages_tos',
        'desc' => '',
        'type' => 'select-pages'
    ) );

    $tab->createOption( array(
        'type' => 'save',
    ) );
}
add_action( 'tf_create_options', 'trtheme_pages_theme_options' );