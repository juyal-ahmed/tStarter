<?php
/**
 * Registering - Theme post metas
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeredesign.com
 */

/*
---------------------------------------------------------------------------------------
	Registering Theme Metas
---------------------------------------------------------------------------------------
*/
function trtheme_theme_post_metas() {
    global $theme_metas;
    $theme_metas = TitanFramework::getInstance( TRTHEME_THEME_SLUG );
}
add_action( 'tf_create_options', 'trtheme_theme_post_metas' );