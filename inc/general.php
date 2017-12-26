<?php
/**
*
* General pagination functions file using by Umamah themes.
*
* @author Juyal Ahmed<tojibon@gmail.com>
* @version: 1.0.0
* https://themeana.com
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

function set_admin_notice(){
	global $pagenow, $trtitan_admin_notice;
	if ( false && $pagenow == 'options-general.php' ) {
		echo '<div class="notice notice-warning is-dismissible">
             <p>This notice appears on the settings page.</p>
         </div>';
	}

	if ( $trtitan_admin_notice  && count($trtitan_admin_notice) > 0 ) {
		foreach($trtitan_admin_notice as $k => $v) {
			echo '<div class="notice notice-warning is-dismissible">
             <p>'.$v.'</p>
         </div>';
		}
	}
}
add_action('admin_notices', 'set_admin_notice');
