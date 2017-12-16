<?php
/**
 * Load all custom metas
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeredesign.com
 */

include_once get_template_directory() . '/inc/prefetch/titan-framework-checker.php';
include_once get_template_directory() . '/inc/prefetch/const.php';
include_once get_template_directory() . '/inc/prefetch/titan.php';
include_once get_template_directory() . '/inc/prefetch/metas.php';
include_once get_template_directory() . '/inc/prefetch/options.php';
include_once get_template_directory() . '/inc/prefetch/customizer.php';
if (is_admin()) {
	include_once get_template_directory() . '/inc/importer/importer.inc.php';
}
