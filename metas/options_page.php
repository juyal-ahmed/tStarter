<?php
/**
 * All pages common options file.
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeana.com
 */

/*
---------------------------------------------------------------------------------------
	Registering Page Common Options
---------------------------------------------------------------------------------------
*/
function trtheme_theme_page_common_options() {
    global $theme_metas;
    $panel = $theme_metas->createMetaBox( array(
        'name' => 'Header Options',
        'post_type' => ['page']
    ) );
    $today = date("Y-m-d");

    $panel->createOption( array(
        'name' => 'Custom Title',
        'id' => 'custom_title',
        'type' => 'text',
        'desc' => 'Enter the page header custom title. So that will overwrite the default page title.'
    ) );
    $panel->createOption( array(
        'name' => 'Sub Title',
        'id' => 'sub_title',
        'type' => 'text',
        'desc' => 'Enter the page header sub title.'
    ) );
    $panel->createOption( array(
        'name' => 'Hide Title',
        'id' => 'hide_title',
        'desc' => 'Check this to hide the page title and subtitle section.',
        'type' => 'enable',
        'enabled' => 'Yes',
        'disabled' => 'No',
        'default' => 'No'
    ) );
}
add_action( 'tf_create_options', 'trtheme_theme_page_common_options' );
