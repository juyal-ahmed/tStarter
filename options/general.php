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
        'name' => 'Header/Footer Layout',
        'id' => 'general_header_footer_layout',
        'default' => false,
        'desc' => '',
        'enabled' => 'Wide',
        'disabled' => 'Boxed',
        'type' => 'enable'
    ) );

    $tab->createOption( array(
        'name' => 'Content Layout',
        'id' => 'general_content_layout',
        'default' => false,
        'desc' => '',
        'enabled' => 'Wide',
        'disabled' => 'Boxed',
        'type' => 'enable'
    ) );

    $tab->createOption( array(
        'type' => 'save',
    ) );
}
add_action( 'tf_create_options', 'trtheme_general_theme_options' );