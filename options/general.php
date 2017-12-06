<?php
/**
 * General - Theme option
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeredesign.com
 */

/*
---------------------------------------------------------------------------------------
	Registering General Theme Options
---------------------------------------------------------------------------------------
*/
function trtheme_general_theme_options() {
    global $theme_option;
    $tab = $theme_option->createTab( array(
        'name' => 'General',
    ) );

    $tab->createOption( array(
        'name' => 'Enable Image Logo',
        'id' => 'general_image_logo_enable',
        'default' => false,
        'desc' => '',
        'type' => 'enable'
    ) );

    $tab->createOption( array(
        'name' => 'Logo',
        'id' => 'general_logo',
        'default' => false,
        'desc' => '',
        'type' => 'upload'
    ) );

    $tab->createOption( array(
        'name' => 'Disable Secondary Menu',
        'id' => 'general_secondary_menu',
        'default' => false,
        'desc' => '',
        'type' => 'enable'
    ) );

    $tab->createOption( array(
        'type' => 'save',
    ) );
}
add_action( 'tf_create_options', 'trtheme_general_theme_options' );