<?php
/**
*
* General pagination functions file using by Umamah themes.
*
* @author Juyal Ahmed<tojibon@gmail.com>
* @version: 1.0.0
* https://themeredesign.com
*/

function get_asset_stylesheet_uri($css) {
    return get_template_directory_uri() . '/assets/css/' . $css . '.css';
}

function get_asset_js_uri($js) {
    return get_template_directory_uri() . '/assets/js/' . $js . '.js';
}

function get_public_stylesheet_uri($css) {
    return get_template_directory_uri() . '/public/css/' . $css . '.css';
}

function get_public_js_uri($js) {
    return get_template_directory_uri() . '/public/js/' . $js . '.js';
}