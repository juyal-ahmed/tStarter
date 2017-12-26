<?php
/**
 * Contact template page options file.
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeana.com
 */

/*
---------------------------------------------------------------------------------------
	Registering Contact Page Template Options
---------------------------------------------------------------------------------------
*/
function trtheme_contact_page_common_options() {
    global $theme_metas;
    $panel = $theme_metas->createMetaBox( array(
        'name' => 'Contact Form Info',
        'post_type' => ['page']
    ) );
    $today = date("Y-m-d");

    $panel->createOption( array(
        'name' => '',
        'type' => 'note',
        'desc' => 'Note that, This group of meta informations will be only used for Contact page template.',
        'default' => ''
    ) );
    $panel->createOption( array(
        'name' => 'Form Title',
        'id' => 'contact_form_title',
        'type' => 'text',
        'desc' => 'Enter the title for contact form.'
    ) );
    $panel->createOption( array(
        'name' => 'Form Summary',
        'id' => 'contact_form_summary',
        'type' => 'textarea',
        'desc' => 'Enter the contact form summary content which is going to display right after the contact form title.'
    ) );
    $panel->createOption( array(
        'name' => 'Sidebar Content',
        'id' => 'contact_sidebar_content',
        'type' => 'editor',
        'desc' => 'Enter the contact form sidebar content which is going to display on right side of the contact. It allows any kinds of markup by the default editor.'
    ) );
}
add_action( 'tf_create_options', 'trtheme_contact_page_common_options' );
