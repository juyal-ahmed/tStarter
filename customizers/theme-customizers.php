<?php
/**
 * Registering - Theme customizer
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeana.com
 */

/*
---------------------------------------------------------------------------------------
	Registering Theme Options
---------------------------------------------------------------------------------------
*/
function trtheme_theme_customizers() {
    global $theme_customizer;
    $titan = TitanFramework::getInstance( TRTHEME_THEME_SLUG );
    $theme_customizer = $titan->createThemeCustomizerSection( array(
        'name' => __( 'Theme Options', TRTHEME_LANG_DOMAIN ),
    ) );
}
add_action( 'tf_create_options', 'trtheme_theme_customizers' );
