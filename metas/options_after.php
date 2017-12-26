<?php
/**
 * All custom post types common options file.
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeana.com
 */

/*
---------------------------------------------------------------------------------------
	Registering Custom Post Type Common Options
---------------------------------------------------------------------------------------
*/
function trtheme_theme_cpost_common_options() {
    global $theme_metas;
    $panel = $theme_metas->createMetaBox( array(
        'name' => 'Additional Options',
        'post_type' => ['post_type']
    ) );
    $today = date("Y-m-d");

    $panel->createOption( array(
        'name' => 'Released On',
        'id' => 'released_on',
        'type' => 'date',
        'desc' => '',
        'default' => $today
    ) );

}
//add_action( 'tf_create_options', 'trtheme_theme_cpost_common_options' );
