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
function trtheme_theme_cpost_before_common_options() {
    global $theme_metas;
    $panel = $theme_metas->createMetaBox( array(
        'name' => 'Item Information',
        'post_type' => ['theme', 'plugin', 'markup']
    ) );
    $today = date("Y-m-d");
    $post_type_option_slug = '';

    $panel->createOption( array(
        'name' => '',
        'type' => 'note',
        'desc' => 'Please follow carefully each fields description instruction to create a full content theme display or single page.'
    ) );

    $panel->createOption( array(
        'name' => 'Sub Heading',
        'id' => $post_type_option_slug . 'sub_heading',
        'desc' => 'Item sub heading is going to display right after item heading / title and top of item special text on single page above the media items.',
        'type' => 'text'
    ) );
    $panel->createOption( array(
        'name' => 'Special Text',
        'id' => $post_type_option_slug . 'special_text',
        'desc' => 'Item special text is going to display right after item sub heading on single page above the media items.',
        'type' => 'editor'
    ) );
    $panel->createOption( array(
        'name' => 'Is New?',
        'id' => $post_type_option_slug . 'is_new',
        'desc' => 'Check this to display new item sticker.',
        'type' => 'checkbox'
    ) );
    $panel->createOption( array(
        'name' => 'Price',
        'id' => $post_type_option_slug . 'price',
        'desc' => 'Please entry a price in integer format without any dollar($) sign, 0.00 or less then 0.00 will supposed to be a free item.',
        'type' => 'text'
    ) );
    $panel->createOption( array(
        'name' => 'Demo Button Text',
        'id' => $post_type_option_slug . 'demo_button_text',
        'type' => 'text',
        'default' => 'Live Demo'
    ) );
    $panel->createOption( array(
        'name' => 'Demo Button Tooltip',
        'id' => $post_type_option_slug . 'demo_button_tooltip',
        'type' => 'text',
        'default' => 'Live Demo'
    ) );
    $panel->createOption( array(
        'name' => 'Demo Button URL',
        'id' => $post_type_option_slug . 'demo_button_url',
        'type' => 'text',
        'desc' => 'You can keep this empty to remove that Live Demo button on item single page.',
        'default' => '#',
    ) );
    $panel->createOption( array(
        'name' => 'Download Button Text',
        'id' => $post_type_option_slug . 'download_button_text',
        'type' => 'text',
        'desc' => 'Note: The [PRICE] text is a place to put the price here, If you remove it then the price amount will be removed from the button, For a free item you can remove it and use \'Download Free\' only. Ex: [PRICE] Buy Now',
        'default' => '[PRICE] Buy Now'
    ) );
    $panel->createOption( array(
        'name' => 'Download Button Tooltip',
        'id' => $post_type_option_slug . 'download_button_tooltip',
        'type' => 'text',
        'default' => 'Buy Now'
    ) );
    $panel->createOption( array(
        'name' => 'Download Button URL',
        'id' => $post_type_option_slug . 'download_button_url',
        'type' => 'text',
        'desc' => '',
        'default' => '#',
    ) );
    $panel->createOption( array(
        'name' => 'Requirements',
        'id' => $post_type_option_slug . 'requirements',
        'type' => 'textarea',
        'desc' => '',
        'default' => ''
    ) );
    $panel->createOption( array(
        'name' => 'Features',
        'id' => $post_type_option_slug . 'features',
        'type' => 'textarea',
        'desc' => '',
        'default' => ''
    ) );
}
add_action( 'tf_create_options', 'trtheme_theme_cpost_before_common_options' );
