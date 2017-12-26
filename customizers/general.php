<?php
/**
 * General - Theme customizer
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeana.com
 */

/*
---------------------------------------------------------------------------------------
	Registering General Theme Options
---------------------------------------------------------------------------------------
*/
function trtheme_general_theme_customizers() {
    global $theme_customizer;
    $theme_customizer->createOption( array(
        'name' => __( 'Background Color', TRTHEME_LANG_DOMAIN ),
        'id' => 'sample_color1',
        'type' => 'text',
        'desc' => __( 'This color changes the background of your theme', TRTHEME_LANG_DOMAIN ),
        'default' => '#FFFFFF',
        'css' => 'body { background-color: value }',
    ) );

    $theme_customizer->createOption( array(
        'name' => __( 'Headings Font', TRTHEME_LANG_DOMAIN ),
        'id' => 'headings_font',
        'type' => 'font',
        'desc' => __( 'Select the font for all headings in the site', TRTHEME_LANG_DOMAIN ),
        'show_color' => false,
        'show_font_size' => false,
        'show_font_weight' => false,
        'show_font_style' => false,
        'show_line_height' => false,
        'show_letter_spacing' => false,
        'show_text_transform' => false,
        'show_font_variant' => false,
        'show_text_shadow' => false,
        'default' => array(
            'font-family' => 'Fauna One',
        ),
        'css' => 'h1, h2, h3, h4, h5, h6 { value }',
    ) );
}
add_action( 'tf_create_options', 'trtheme_general_theme_customizers' );
