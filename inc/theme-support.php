<?php
/**
 * This file contained theme support functions, filters and actions
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeredesign.com
 */

/*
*
* Add Twitter Bootstrap's standard 'active' class name to the active nav link item
*/
if (!function_exists('umamah_menu_classes')) {
    function umamah_menu_classes($classes, $item)
    {
        if ($item->menu_item_parent == 0 && in_array('current-menu-item', $classes)) {
            $classes[] = "active";
            if (($key = array_search('current-menu-item', $classes)) !== false) {
                unset($classes[$key]);
            }
        }

        if (in_array('current-menu-parent', $classes)) {
            $classes[] = "active";
        }

        if (in_array('current_page_item', $classes)) {
            $classes[] = "active";
            if (($key = array_search('current_page_item', $classes)) !== false) {
                unset($classes[$key]);
            }
        }

        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = "dropdown";
            if (($key = array_search('menu-item-has-children', $classes)) !== false) {
                unset($classes[$key]);
            }
        }

        if (in_array('current-menu-ancestor', $classes)) {
            $classes[] = "active";
        }
        $classes = array_unique($classes);

        return $classes;
    }
}
add_filter('nav_menu_css_class', 'umamah_menu_classes', 10, 2);

if (!function_exists('custom_image_resize_dimensions')) {
    function custom_image_resize_dimensions($payload, $orig_w, $orig_h, $dest_w, $dest_h, $crop)
    {

        // Change this to a conditional that decides whether you
        // want to override the defaults for this image or not.
        if (false)
            return $payload;

        if ($crop) {
            // crop the largest possible portion of the original image that we can size to $dest_w x $dest_h
            $aspect_ratio = $orig_w / $orig_h;
            $new_w = min($dest_w, $orig_w);
            $new_h = min($dest_h, $orig_h);

            if (!$new_w) {
                $new_w = intval($new_h * $aspect_ratio);
            }

            if (!$new_h) {
                $new_h = intval($new_w / $aspect_ratio);
            }

            $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

            $crop_w = round($new_w / $size_ratio);
            $crop_h = round($new_h / $size_ratio);

            $s_x = floor(($orig_w - $crop_w) / 2);
            $s_y = 0; // [[ formerly ]] ==> floor( ($orig_h - $crop_h) / 2 );
        } else {
            // don't crop, just resize using $dest_w x $dest_h as a maximum bounding box
            $crop_w = $orig_w;
            $crop_h = $orig_h;

            $s_x = 0;
            $s_y = 0;

            list($new_w, $new_h) = wp_constrain_dimensions($orig_w, $orig_h, $dest_w, $dest_h);
        }

        // if the resulting image would be the same size or larger we don't want to resize it
        if ($new_w >= $orig_w && $new_h >= $orig_h)
            return false;

        // the return array matches the parameters to imagecopyresampled()
        // int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h
        return array(0, 0, (int)$s_x, (int)$s_y, (int)$new_w, (int)$new_h, (int)$crop_w, (int)$crop_h);

    }
}
add_filter('image_resize_dimensions', 'custom_image_resize_dimensions', 10, 6);
