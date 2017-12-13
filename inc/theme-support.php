<?php
if ( !class_exists( 'Umamah_Arrow_Walker_Nav_Menu' ) ) {
    class Umamah_Arrow_Walker_Nav_Menu extends Walker_Nav_Menu
    {
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
        {
            global $wp_query;
            $indent = ($depth) ? str_repeat("\t", $depth) : '';

            $class_names = '';

            $classes = empty($item->classes) ? array() : (array)$item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            if (!empty($item->description)) {
                $classes[] = 'has-description';
            }

            $icon_classes = array();
            foreach ($classes as $key => $val) {
                if ('glyphicon' == substr(trim($val), 0, 9)) {
                    if ('glyphicon' == $val) {
                        unset($classes[$key]);
                    } else {
                        $icon_classes[] = $val;
                        unset($classes[$key]);
                    }
                }
            }

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $class_names . '>';

            $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
            $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
            $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
            $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

            if (!empty($icon_classes)) {
                $icon_classes_str = join(' ', $icon_classes);
                $icon_text = '<span class="glyphicon glyphicon-icon ' . $icon_classes_str . '"></span>';
            } else {
                $icon_text = '';
            }

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $icon_text;
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;

            if (!empty($item->description)) {
                $item_output .= '<span class="menu-description">' . $item->description . '</span>';
            }

            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

        function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
        {
            $id_field = $this->db_fields['id'];

            if (!empty($children_elements[$element->$id_field]) && $element->menu_item_parent == 0) {
                $element->title = $element->title . '<span class="sf-sub-indicator"><i class="fa fa-angle-down"></i></span>';
            }

            if (!empty($children_elements[$element->$id_field]) && $element->menu_item_parent != 0) {
                $element->title = $element->title . '<span class="sf-sub-indicator"><i class="fa fa-angle-right"></i></span>';
            }

            Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
        }
    }
}

/*
*
* Adding bootstrap support on menu items by menu walker.
*/
if ( !class_exists( 'Umamah_Bootstrap_Walker' ) ) {
    class Umamah_Bootstrap_Walker extends Walker_Nav_Menu {
        function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
            global $wp_query;
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            $class_names = $value = '';

            if ( !empty( $args ) && is_object( $args ) && $args->has_children ) {
                $class_names = "dropdown ";
            }

            $classes = empty( $object->classes ) ? array() : (array) $object->classes;

            $class_names .= join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object ) );
            $class_names = ' class="'. esc_attr( $class_names ) . '"';

            $output .= $indent . '<li id="menu-item-'. $object->ID . '"' . $value . $class_names .'>';
            $attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
            $attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
            $attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';
            $attributes .= ! empty( $object->url )        ? ' href="'   . esc_attr( $object->url        ) .'"' : '';

            if ( !empty( $args ) && is_object( $args ) && $args->has_children ) {
                $attributes .= ' class="dropdown-toggle" data-toggle="dropdown"';
            }
            if ( !empty( $args ) && is_object( $args ) && $args->before ) {
                $item_output = $args->before;
            } else {
                $item_output = '';
            }

            $item_output .= '<a'. $attributes .'>';

            if ( !empty( $args ) && is_object( $args ) && $args->link_before ) {
                $item_output .= $args->link_before;
            }

            $item_output .= apply_filters( 'the_title', $object->title, $object->ID );

            if ( !empty( $args ) && is_object( $args ) && $args->link_after ) {
                $item_output .= $args->link_after;
            }

            if ( !empty( $args ) && is_object( $args ) && $args->has_children ) {
                $item_output .= '<span class="caret"></span></a>';
            } else {
                $item_output .= '</a>';
            }

            if ( !empty( $args ) && is_object( $args ) && $args->after ) {
                $item_output .= $args->after;
            }

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $object, $depth, $args );
        }

        function start_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"dropdown-menu\"  role=\"menu\">\n";
        }

        function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
            $id_field = $this->db_fields['id'];
            if ( is_object( $args[0] ) ) {
                $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
            }
            return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        }
    }
}


/*
*
* Add Twitter Bootstrap's standard 'active' class name to the active nav link item
*/
if (!function_exists('trtitan_menu_classes')) {
    function trtitan_menu_classes($classes, $item)
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
add_filter('nav_menu_css_class', 'trtitan_menu_classes', 10, 2);

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
