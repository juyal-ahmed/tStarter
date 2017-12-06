<?php
/**
 * Registering - Theme option
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeredesign.com
 */

/*
---------------------------------------------------------------------------------------
	Registering Theme Options
---------------------------------------------------------------------------------------
*/
function trtheme_theme_options() {
    global $theme_option;
    $titan = TitanFramework::getInstance( TRTHEME_THEME_SLUG );
    $theme_option = $titan->createAdminPage( array(
        'name' => 'Theme Options',
        'parent' => 'themes.php'
    ) );
}
add_action( 'tf_create_options', 'trtheme_theme_options' );