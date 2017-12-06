<?php
/**
* This file contained theme support functions, filters and actions
*
* @author Juyal Ahmed<tojibon@gmail.com>
* @version: 1.0.0
* https://themeredesign.com
*/


if ( ! isset( $content_width ) ) $content_width = 1140;

/*
*
* Adding theme support for html5 and editor styling
*/
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails', array('post', 'page'));
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
    add_editor_style( 'editor-style.css' );
    $post_formats = array( 'aside', 'audio', 'gallery', 'image', 'link', 'quote', 'video' );
    add_theme_support( 'post-formats', $post_formats );
    add_theme_support('menus');
    add_theme_support('automatic-feed-links');
}

/*
*
* Killing the admin bar for customer role user.
*/
$is_user_logged_in = is_user_logged_in();
if ( $is_user_logged_in ) {
	$user_role = 'user';//umamah_get_user_role();
	if ( 'customer' == strtolower( $user_role ) ) {
		add_filter( 'show_admin_bar', '__return_false' ); 
	}
}

/*
*
* Add Twitter Bootstrap's standard 'active' class name to the active nav link item
*/
if ( !function_exists( 'umamah_menu_classes' ) ) {
	function umamah_menu_classes( $classes, $item ) {
		if( $item->menu_item_parent == 0 && in_array( 'current-menu-item', $classes ) ) {
			$classes[] = "active";
			if ( ( $key = array_search( 'current-menu-item', $classes ) ) !== false ) {
				unset( $classes[ $key ] );
			}
		}
		
		if( in_array( 'current-menu-parent', $classes ) ) {
			$classes[] = "active";
		} 
		
		if( in_array( 'current_page_item', $classes ) ) {
			$classes[] = "active";
			if ( ( $key = array_search( 'current_page_item', $classes ) ) !== false ) {
				unset( $classes[ $key ] );
			}
		} 
		
		if( in_array( 'menu-item-has-children', $classes ) ) {
			$classes[] = "dropdown";
			if ( ( $key = array_search( 'menu-item-has-children', $classes ) ) !== false ) {
				unset( $classes[ $key ] );
			}
		} 
		
		if( in_array( 'current-menu-ancestor', $classes ) ) {
			$classes[] = "active";
		}
		$classes = array_unique($classes);

		return $classes;
	}
}
add_filter( 'nav_menu_css_class', 'umamah_menu_classes', 10, 2 );


/*
*
* Updating excert of posts to display custom read more button.
*/
if ( !function_exists( 'umamah_excerpt_more' ) ) {
	function umamah_excerpt_more( $more ) {
		return '... <a class="more-link" href="'. get_permalink( get_the_ID() ) . '">' . __( "Continue Reading", "umamah" ) . '<span></span></a>';
	}
}
add_filter( 'excerpt_more', 'umamah_excerpt_more' );

class umamah_add_span_bottom_walker extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

		if ( !empty( $item->description ) ) {
			$classes[] = 'has-description';
		}
		
		$icon_classes = array();
        foreach( $classes as $key => $val ){
            if( 'fa-' == substr( trim( $val ), 0, 3 ) ) {
                if( 'fa-' == $val ){
                    unset( $classes[ $key ] );
                } else {
                    $icon_classes[] = $val;
                    unset( $classes[ $key ] );
                }
            }
        }
		
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		if( !empty( $icon_classes ) ){
            $icon_classes_str = join( ' ', $icon_classes );
			$icon_text = '<span class="glyphicon glyphicon-icon '.$icon_classes_str.'"></span>';
		} else {
			$icon_text = '';
		}
		
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
		$item_output .= $icon_text;
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

        if ( 'primary' == $args->theme_location ) {
            $submenus = 0 == $depth || 1 == $depth ? get_posts( array( 'post_type' => 'nav_menu_item', 'numberposts' => 1, 'meta_query' => array( array( 'key' => '_menu_item_menu_item_parent', 'value' => $item->ID, 'fields' => 'ids' ) ) ) ) : false;
            $item_output .= ! empty( $submenus ) ? ( 0 == $depth ? '<span class="arrow glyphicon glyphicon-chevron-down"></span>' : '<span class="arrow sub-arrow glyphicon glyphicon-chevron-down"></span>' ) : '';
        }
		
		if ( !empty( $item->description ) ) {
			$item_output .= '<span class="menu-description">' . $item->description . '</span>';
		}
		
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/*
*
* Adding Arrow on menu items by menu walker.
*/
class Umamah_Arrow_Walker_Nav_Menu extends Walker_Nav_Menu {
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

		if ( !empty( $item->description ) ) {
			$classes[] = 'has-description';
		}
		
		$icon_classes = array();
        foreach( $classes as $key => $val ){
            if( 'glyphicon' == substr( trim( $val ), 0, 9 ) ) {
                if( 'glyphicon' == $val ){
                    unset( $classes[ $key ] );
                } else {
                    $icon_classes[] = $val;
                    unset( $classes[ $key ] );
                }
            }
        }
		
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		if( !empty( $icon_classes ) ){
            $icon_classes_str = join( ' ', $icon_classes );
			$icon_text = '<span class="glyphicon glyphicon-icon '.$icon_classes_str.'"></span>';
		} else {
			$icon_text = '';
		}
        
        if ( in_array( 'cart', $classes ) ) {
            $total_items = (int) umamah_get_the_number_of_cart_items();
            $cart_text = '<span class="cart-counter wow zoomIn" data-wow-delay=".5s" data-wow-duration=".5s">'.$total_items.'</span>';
        } else {
            $cart_text = '';
        }
		
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
		$item_output .= $icon_text;
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= $cart_text;

        if ( 'primary' == $args->theme_location ) {
            $submenus = 0 == $depth || 1 == $depth ? get_posts( array( 'post_type' => 'nav_menu_item', 'numberposts' => 1, 'meta_query' => array( array( 'key' => '_menu_item_menu_item_parent', 'value' => $item->ID, 'fields' => 'ids' ) ) ) ) : false;
            $item_output .= ! empty( $submenus ) ? ( 0 == $depth ? '<span class="arrow glyphicon glyphicon-chevron-down"></span>' : '<span class="arrow sub-arrow glyphicon glyphicon-chevron-down"></span>' ) : '';
        }
		
		if ( !empty( $item->description ) ) {
			$item_output .= '<span class="menu-description">' . $item->description . '</span>';
		}
		
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
	
    function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
        $id_field = $this->db_fields['id'];
		
		if (!empty($children_elements[$element->$id_field]) && $element->menu_item_parent == 0) { 
            $element->title =  $element->title . '<span class="sf-sub-indicator"><i class="fa fa-angle-down"></i></span>'; 
			$element->classes[] = 'sf-with-ul';
        }
		
		if (!empty($children_elements[$element->$id_field]) && $element->menu_item_parent != 0) { 
            $element->title =  $element->title . '<span class="sf-sub-indicator"><i class="fa fa-angle-right"></i></span>'; 
        }

        Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
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
---------------------------------------------------------------------------------------
    Adding akv3_query_format_standard allowed standard blog post listing
	
    @since: 1.0.0
	@url http://alexking.org/blog/2012/01/05/wp_query-by-standard-post-format	
---------------------------------------------------------------------------------------
*/
function akv3_query_format_standard($query) {
	if (isset($query->query_vars['post_format']) &&
		$query->query_vars['post_format'] == 'post-format-standard') {
		if (($post_formats = get_theme_support('post-formats')) &&
			is_array($post_formats[0]) && count($post_formats[0])) {
			$terms = array();
			foreach ($post_formats[0] as $format) {
				$terms[] = 'post-format-'.$format;
			}
			$query->is_tax = null;
			unset($query->query_vars['post_format']);
			unset($query->query_vars['taxonomy']);
			unset($query->query_vars['term']);
			unset($query->query['post_format']);
			$query->set('tax_query', array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'post_format',
					'terms' => $terms,
					'field' => 'slug',
					'operator' => 'NOT IN'
				)
			));
		}
	}
}
add_action('pre_get_posts', 'akv3_query_format_standard');

/*
---------------------------------------------------------------------------------------
    Adding wp_nav_menu_container_allowedtags allowed tags for menu container
---------------------------------------------------------------------------------------
*/
add_filter('wp_nav_menu_container_allowedtags', 'umamah_wp_nav_menu_container_allowedtags', 10, 2 );
function umamah_wp_nav_menu_container_allowedtags(  $tags ) {
	//$allowed_tags = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
	//see wp-includes/nav-menu-template.php
	$tags[] = 'ul';
	return $tags;
}

/*
---------------------------------------------------------------------------------------
    Adding wp_page_menu Alternative fallback_cb for default wp_nav_menu
	Thsi fallback_cb is supposed to be used only when no menu already created by the admin user
	THIS one only supposed to work for bootstrap navbar.
---------------------------------------------------------------------------------------
*/
function umamah_wp_page_menu( $args = array() ) {
	$defaults = array('sort_column' => 'menu_order, post_title', 'menu_class' => 'menu', 'echo' => true, 'link_before' => '', 'link_after' => '');
	$args = wp_parse_args( $args, $defaults );

	$args = apply_filters( 'wp_page_menu_args', $args );
	$menu = '';
	$list_args = $args;

	if ( ! empty($args['show_home']) ) {
		if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
			$text = __('Home');
		else
			$text = $args['show_home'];
		$class = '';
		if ( is_front_page() && !is_paged() )
			$class = 'class="active"';
		$menu .= '<li ' . $class . '><a href="' . home_url( '/' ) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';
		
		if (get_option('show_on_front') == 'page') {
			if ( !empty( $list_args['exclude'] ) ) {
				$list_args['exclude'] .= ',';
			} else {
				$list_args['exclude'] = '';
			}
			$list_args['exclude'] .= get_option('page_on_front');
		}
	}

	$list_args['echo'] = false;
	$list_args['title_li'] = '';
	$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );
	$menu = str_replace( array( "current_page_item", "page_item_has_children", "children", "sub-menu" ), array( "active", "dropdown", "dropdown-menu", "dropdown-menu" ), $menu );

	if ( $menu )
		$menu = '<ul class="' . esc_attr($args['menu_class']) . '">' . $menu . '</ul>';

	$menu = apply_filters( 'wp_page_menu', $menu, $args );
	if ( $args['echo'] )
		echo $menu;
	else
		return $menu;
}

/*
---------------------------------------------------------------------------------------
    Body Class filter to add custom classes
    @return array of custom classes
---------------------------------------------------------------------------------------
*/
add_filter('body_class', 'umamah_body_classes', 10, 2 );
function umamah_body_classes(  $classes, $extra ) {
        global $post, $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone; 
		
		if ( empty( $classes ) ) {
			$classes = umamah_get_custom_body_classes();
		}
		
		if($is_lynx) $classes[] = 'lynx';
		elseif($is_gecko) $classes[] = 'gecko';
		elseif($is_opera) $classes[] = 'opera';
		elseif($is_NS4) $classes[] = 'ns4';
		elseif($is_safari) $classes[] = 'safari';
		elseif($is_chrome) $classes[] = 'chrome';
		elseif($is_IE) $classes[] = 'ie';
		else $classes[] = 'unknown';
		if($is_iphone) $classes[] = 'iphone';
		
		$content = '';
		if ( !empty( $post ) ) {
            $content = $post->post_content;
        }
		if( trim( $content ) == "" && !empty( $post ) && trim( $post->post_content ) == "" ) {
			$classes[] = 'umamah-empty-content';
		}
		// $notice_html = umamah_get_option( 'others', 'notice_html', '' );
		if( !empty( $notice_html ) ) $classes[] = 'umamah_notice_bar';
		
		return $classes;
}

/*
*
* Updating title
*/
add_action( 'after_setup_theme', 'umamah_theme_title' );
function umamah_theme_title() {
    add_theme_support( 'title-tag' );
}

/*
*
* Updating title via filter.
*/
if ( !function_exists( "umamah_filter_wp_title" ) ) {
	function umamah_filter_wp_title( $title ) {
		global $page, $paged, $post;
        
        $title = trim( str_replace('&raquo;', '', $title) );
		
        $separator = '-';

        if ( is_feed() )
            return $title;

        $site_description = get_bloginfo( 'description' );

        if ( is_front_page() && is_home() ) {
            // Default homepage
            $filtered_title = $title . get_bloginfo( 'name' );
        } elseif ( is_front_page() ) {
            // static homepage
            $filtered_title = $title . get_bloginfo( 'name' );
        } elseif ( is_home() ) {
            // blog page
            $filtered_title = $title;
        } elseif ( !empty( $post ) && is_single() && 'themes' == get_post_type( $post ) ) {
            // theme single
            $_data_sub_title = $_header_sub_title = get_post_meta( $post->ID, 'themes-general_theme_sub_heading', TRUE );
            $filtered_title = $title . ' - ' . $_data_sub_title;
        } elseif ( !empty( $post ) && is_single() && 'plugins' == get_post_type( $post ) ) {
            // theme single
            $_data_sub_title = $_header_sub_title = get_post_meta( $post->ID, 'plugins-general_plugin_sub_heading', TRUE );
            $filtered_title = $title . ' - ' . $_data_sub_title;
        } else {
            //everything else
            $filtered_title = $title . ' | ' . get_bloginfo( 'name' );    
        }      

        
        $filtered_title .= ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) ? ' '.$separator.' ' . $site_description: '';
        $filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' '.$separator.' ' . sprintf( __( 'Page %s', LANG_DOMAIN), max( $paged, $page ) ) : '';

        return $filtered_title;
	}
}
add_filter( 'wp_title', 'umamah_filter_wp_title' );


/**
*
* Adding public query vars which all are using on this plugins
*/

function umamah_query_vars() {
	global $wp;
	$wp->add_query_var('redirect-to');
	$wp->add_query_var('umamah-action');
	$wp->add_query_var('umamah-logout');
}

add_action( 'init', 'umamah_query_vars', 10, 1 );


/**
*
* Protecting secure page from unauthorized users.
*/

function umamah_page_redirect_control() {
    global $post;


    $account_secured_page = false;
    $is_user_logged_in = is_user_logged_in();

    if ( !empty( $post ) ) {
        if ( 'orders' == get_post_type() && !$is_user_logged_in ) {
            $account_secured_page= true;
        }
    }


    if ( is_page_template( 'templates/account.php' ) ) {
        $account_secured_page= true;
    } else if ( is_page_template( 'templates/download.php' ) ) {
        $account_secured_page= true;
    } else if ( is_page_template( 'templates/subscription.php' ) ) {
        $account_secured_page= true;
    } else if ( is_page_template( 'templates/tickets.php' ) || is_page_template( 'templates/submit-a-ticket.php' ) ) {
        $account_secured_page= true;
    } else if ( is_page_template( 'templates/edit-profile.php' ) || is_page_template( 'templates/change-password.php' ) ) {
        $account_secured_page= true;
    } else if ( is_singular() && 'tickets' == get_post_type() ) {
        $account_secured_page= true;
    } else if ( is_page_template( 'templates/login.php' ) || is_page_template( 'templates/forgot-password.php' ) || is_page_template( 'templates/reset-password.php' ) ) {
        if ( $is_user_logged_in ) {
            wp_redirect( umamah_url( 'account' ), 301 );
            exit;
        }
    }

    $current_page_uri = get_permalink();

    if( $account_secured_page && !$is_user_logged_in ) {
        wp_redirect( umamah_url( 'login', false, array('redirect_to' => urlencode( $current_page_uri )) ), 301 );
        exit;
    }
}

add_action( 'template_redirect', 'umamah_page_redirect_control', 10, 1 );


/**
 *
 * Umamah user sign in
 * This can only be executed before anything is outputed in the page because of that we're adding it to the init hook
 *
 * @Author       : Jewel Ahmed
 * @Author Web   : http://codeatomic.com
 **/
function umamah_user_signin(){
    global $wp, $post, $umamah_err, $umamah_info, $current_user;

    $http_post = ('POST' == $_SERVER['REQUEST_METHOD']);

    if( !empty( $_POST['umamah-user-login'] ) && $_POST['umamah-user-login'] == 'yes' ) {

        $username = '';
        if ( isset( $_POST['username'] ) ) {
            $username = wp_unslash( trim( strip_tags( $_POST['username'] ) ) );
        }
        $password = '';
        if ( isset( $_POST['password'] ) ) {
            $password = wp_unslash( trim( strip_tags( $_POST['password'] ) ) );
        }


        if( empty( $username ) ) {
            $umamah_err = true;
            $umamah_info = __('<strong>ERROR</strong>: Enter a username or e-mail address.', 'umamah');
        } else if( empty( $password ) ) {
            $umamah_err = true;
            $umamah_info = __('<strong>ERROR</strong>: Please enter your account passsword.', 'umamah');
        } else if ( strpos( $username, '@' ) ) {
            $user_data = get_user_by( 'email', trim( $username ) );
            $login_type = 'email';
            if ( empty( $user_data ) ) {
                $umamah_err = true;
                $umamah_info = __('<strong>ERROR</strong>: There is no user registered with that email address.', 'umamah');
            } else {
                $username = $user_data->data->user_login;
            }
        } else {
            $user_data = get_user_by( 'login', $username );
            $login_type = 'username';
            if ( empty( $user_data ) ) {
                $umamah_err = true;
                $umamah_info = __('<strong>ERROR</strong>: There is no user registered with that username.', 'umamah');
            }
        }

        if( !$umamah_err ) {

            if ( 'POST' == $_SERVER['REQUEST_METHOD'] && wp_verify_nonce( $_POST['umamah_login_nonce_field'], 'verify_true_login' ) ) {
                if ( isset( $_POST['remember-me'] ) ) {
                    $remember = strip_tags( $_POST['remember-me'] );
                } else {
                    $remember = false;
                }

                $current_user = wp_signon( array( 'user_login' => $username, 'user_password' => $password, 'remember' => $remember ), false );

                if ( is_wp_error( $current_user ) )  {
                    $umamah_err = true;
                    $umamah_info = '<strong>ERROR:</strong> Invalid '.$login_type.' or password provided.';
                } else if( !empty( $_REQUEST['redirect_to'] ) ) {
                    wp_redirect( urldecode( $_REQUEST['redirect_to'] ), 301 );
                    exit;
                } else if( umamah_url( 'login-redirect' ) ) {
                    wp_redirect( umamah_url( 'login-redirect' ), 301 );
                    exit;
                } else {
                    wp_redirect( home_url(), 301 );
                    exit;
                }
            }

        }
    } else if( !empty($_REQUEST['umamah-resetpass']) && $_REQUEST['umamah-resetpass']=='yes' ) {
        global $rp_login, $rp_key;
        list( $rp_path ) = explode( '?', wp_unslash( $_SERVER['REQUEST_URI'] ) );
        $rp_cookie = 'wp-resetpass-' . COOKIEHASH;
        if ( isset( $_GET['key'] ) ) {
            $value = sprintf( '%s:%s', wp_unslash( $_GET['login'] ), wp_unslash( $_GET['key'] ) );
            setcookie( $rp_cookie, $value, 0, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
            wp_safe_redirect( remove_query_arg( array( 'key', 'login' ) ) );
            exit;
        }

        if ( isset( $_COOKIE[ $rp_cookie ] ) && 0 < strpos( $_COOKIE[ $rp_cookie ], ':' ) ) {
            list( $rp_login, $rp_key ) = explode( ':', wp_unslash( $_COOKIE[ $rp_cookie ] ), 2 );
            $user = check_password_reset_key( $rp_key, $rp_login );
            if ( isset( $_POST['pass1'] ) && ! hash_equals( $rp_key, $_POST['rp_key'] ) ) {
                $user = false;
            }
        } else {
            $user = false;
        }

        if ( ! $user || is_wp_error( $user ) ) {
            setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
            if ( $user && $user->get_error_code() === 'expired_key' )
                wp_redirect( umamah_url( 'forgot-password', false, array( 'error' => 'expiredkey' ) ) );
            else
                wp_redirect( umamah_url( 'forgot-password', false, array( 'error' => 'invalidkey' ) ) );
            exit;
        }


        $errors = new WP_Error();
        if ( isset($_POST['pass1']) && $_POST['pass1'] != $_POST['pass2'] ) {
            $umamah_err = true;
            $umamah_info = __( '<strong>ERROR:</strong> The passwords do not match.', 'umamah' );
            $errors->add( 'password_reset_mismatch', __( 'The passwords do not match.', 'umamah' ) );
        }

        do_action( 'validate_password_reset', $errors, $user );

        if ( ( ! $errors->get_error_code() ) && isset( $_POST['pass1'] ) && !empty( $_POST['pass1'] ) ) {
            //wp_set_password( strip_tags( $_POST['pass1'] ), $user );
            reset_password($user, $_POST['pass1']);
            setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
            wp_redirect( umamah_url( 'login', false, array( 'password-reset' => 'done' ) ) );
            exit;
        }

    } else if( $http_post && !empty($_POST['umamah-user-forgot-password']) && $_POST['umamah-user-forgot-password']=='yes' ) {

        $user_login = '';
        if ( isset( $_POST['user_login'] ) ) {
            $user_login = trim( strip_tags( $_POST['user_login'] ) );
        }

        if( empty( $user_login ) ) {
            $umamah_err = true;
            $umamah_info = __("<strong>ERROR:</strong> Please enter your account username or email.", 'umamah');
        }


        if( !$umamah_err ) {

            if ( 'POST' == $_SERVER['REQUEST_METHOD'] && wp_verify_nonce( $_POST['umamah_login_nonce_field'], 'verify_true_login' ) ) {

                $email = get_user_by( 'email', $user_login );
                $user = get_user_by( 'login', $user_login );

                $umamah_reset_password_check_email_uri = umamah_url( 'reset-password-checkemail' );

                if( !empty( $email ) ) {
                    $errors = umamah_retrieve_password();
                    if ( !is_wp_error($errors) ) {
                        $redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : $umamah_reset_password_check_email_uri;
                        wp_safe_redirect( $redirect_to );
                        exit();
                    }
                } else if( !empty( $user ) ) {
                    $errors = umamah_retrieve_password();
                    if ( !is_wp_error($errors) ) {
                        $redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : $umamah_reset_password_check_email_uri;
                        wp_safe_redirect( $redirect_to );
                        exit();
                    }
                } else {
                    $umamah_err = true;
                    $umamah_info = __('<strong>ERROR:</strong> Invalid username or e-mail.', 'umamah');
                }
            }

        }
    }

    if ( !empty( $_REQUEST[ 'umamah-action' ] ) && $_REQUEST[ 'umamah-action' ] == 'logout' ) {
        wp_logout();
        if( false ) {
            //$wp_slrp_logout_redirect_page_uri = get_permalink(WP_SLRP_LOGOUT_REDIRECT_PAGE_ID);
            //wp_redirect($wp_slrp_logout_redirect_page_uri);
            //exit;
        } else if( !empty( $_GET['redirect-to'] ) ) {
            wp_redirect( $_GET['redirect-to'], 301 );
        } else {
            wp_redirect( home_url(), 301 );
        }
        exit;
    }
}
add_action('init', 'umamah_user_signin');


/**
 *
 * Processing submit a ticket form action for logged in users only.
 *
 * @Author       : Jewel Ahmed
 * @Author Web   : http://codeatomic.com
 **/
function umamah_ticket_submit() {
    global $wp, $post, $umamah_err, $umamah_info, $current_user;
    $http_post = ('POST' == $_SERVER['REQUEST_METHOD']);

    if ( $http_post && !empty( $_POST['ticket_submitted'] ) && 'submit-ticket' == $_POST['ticket_submitted'] ) {

        $ticket_priority = '';
        if ( !empty( $_POST['ticket_priority'] ) ) {
            $ticket_priority = $_POST['ticket_priority'];
        } else {
            $umamah_err = true;
            $umamah_info = __('<strong>ERROR</strong>: Please select a priority of your ticket.', 'umamah');
        }

        if ( !$umamah_err ) {
            $ticket_item_id = '';
            if ( !empty( $_POST['ticket_item_id'] ) ) {
                $ticket_item_id = $_POST['ticket_item_id'];
            } else {
                $umamah_err = true;
                $umamah_info = __('<strong>ERROR</strong>: Please select a product about which you are submitting this ticket.', 'umamah');
            }
        }

        if ( !$umamah_err ) {
            $ticket_website = '';
            if ( !empty( $_POST['ticket_website'] ) ) {
                $ticket_website = strip_tags( $_POST['ticket_website'] );
            } else {
                $umamah_err = true;
                $umamah_info = __('<strong>ERROR</strong>: Please enter your website url.', 'umamah');
            }
        }

        if ( !$umamah_err ) {
            $ticket_subject = '';
            if ( !empty( $_POST['ticket_subject'] ) ) {
                $ticket_subject = strip_tags( $_POST['ticket_subject'] );
            } else {
                $umamah_err = true;
                $umamah_info = __('<strong>ERROR</strong>: Please enter your ticket subject in a line.', 'umamah');
            }
        }

        if ( !$umamah_err ) {
            $ticket_comments = '';
            if ( !empty( $_POST['ticket_comments'] ) ) {
                $ticket_comments = $_POST['ticket_comments'];
            } else {
                $umamah_err = true;
                $umamah_info = __('<strong>ERROR</strong>: Please enter your ticket details.', 'umamah');
            }
        }

        if ( !$umamah_err ) {
            $ticket_submitted_by = $current_user->ID;

            $ticket_post = array(
                'post_title' => $ticket_subject,
                'post_content' => $ticket_comments,
                'post_status' => 'open',
                'post_author' => $ticket_submitted_by,
                'post_type' => 'ticket',
            );
            $wp_error = "";

            $ticket_post_id = wp_insert_post( $ticket_post, $wp_error );

            if ( is_wp_error( $wp_error ) ) {
                $umamah_err = true;
                $umamah_info = $wp_error->get_error_message();
            } else {
                $umamah_info = __('<strong>SUCCESS</strong>: Your ticket has been submitted successfully, We will get back with it soon.', 'umamah');

                update_post_meta( $ticket_post_id, THEME_KEY . 'ticket_customer_id', $current_user->ID );
                update_post_meta( $ticket_post_id, THEME_KEY . 'ticket_customer_name', $current_user->user_login );
                update_post_meta( $ticket_post_id, THEME_KEY . 'ticket_customer_email', $current_user->user_email );
                update_post_meta( $ticket_post_id, THEME_KEY . 'ticket_item_id', $ticket_item_id );
                update_post_meta( $ticket_post_id, THEME_KEY . 'ticket_website', $ticket_website );
                update_post_meta( $ticket_post_id, THEME_KEY . 'ticket_priority', $ticket_priority );

                //Processing uploaded ticket files
                if ( !empty( $_SESSION['ticket_files'] ) ) {
                    foreach( $_SESSION['ticket_files'] as $k => $v ) {
                        if ( !empty( $v['url'] ) ) {
                            $url = $v['url'];
                            $file = $v['file'];

                            $post_mime_type = wp_check_filetype( $url, null );
                            $attachment = array(
                                'guid' => $url,
                                'post_mime_type' => $post_mime_type['type'],
                                'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $url ) ),
                                'post_content' => '',
                                'post_status' => 'inherit'
                            );
                            $attach_id = wp_insert_attachment( $attachment, $file, $ticket_post_id );
                            $ticket_attachments[] = $attach_id;
                            /*require_once(ABSPATH . 'wp-admin/includes/image.php');
                            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
                            wp_update_attachment_metadata( $attach_id, $attach_data );
                            update_post_meta( $ticket_post_id, 'tickets_ticket_file_' . ($k+1), $url );*/
                        }
                    }
                    if ( !empty( $ticket_attachments ) && count($ticket_attachments) > 0 ) {
                        update_post_meta($ticket_post_id, THEME_KEY . 'ticket_screenshots', implode(',', $ticket_attachments));
                    }
                    $_SESSION['ticket_files'] = null;
                }
            }
        }
    }
}
add_action( 'init', 'umamah_ticket_submit' );

/**
* Validating plugins allowed file types when uploading photos or files
* 
* @param file_name string currently uploading file name field
* @param allrowed_types array allowed file extensions array list
* @return boolean
* @access public if allowed then true else false
*/
function umamah_allowed_file_type( $file_name, $allowed_types=array() ) {
    foreach( $allowed_types as $key => $value ) {
        $pos = strpos( strtolower( $file_name ), strtolower( $value ) );
        if ( $pos === false ) {
            $return = false;
        } else {
            $return = true;
            break;
        }
    }
    return $return;
}

function umamah_user_upload_mime_types($mime_types){
    $mime_types = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'pdf' => 'application/pdf',
        'zip' => 'application/zip',
        'tar' => 'application/x-tar',
        'rar' => 'application/rar',
        '7z' => 'application/x-7z-compressed',
        'gz|gzip' => 'application/x-gzip',
        'bmp' => 'image/bmp',
        'tif|tiff' => 'image/tiff'
    );
    return $mime_types;
}
add_filter('upload_mimes', 'umamah_user_upload_mime_types', 1, 1);

/**
 *
 * Uploading ajax based file upload and responding uploaded file url to display in a iframe to use it via JavaScript. It is using for submit a ticket file uploading.
 *
 * @Author       : Jewel Ahmed
 * @Author Web   : http://codeatomic.com
 *
 * @return str uploaded file url.
 **/
if ( !function_exists( 'umamah_iframe_media_upload_callback' ) ) {
    function umamah_iframe_media_upload_callback() {
        global $wpdb;

        $err = '';
        ob_clean();

        $file_field = 'ticket_media';
        $allowed_file_types = array( '.jpg','.jpeg','.png', '.gif', '.zip', '.pdf' );
        $max_file_size = 5000000;
        $err='';

        if ( $_FILES[ $file_field ][ "error" ] ) {
            $err ='File upload error no: ' . $_FILES[$file_field]["error"];
        } else if ( !umamah_allowed_file_type( $_FILES[ $file_field ][ "name" ], $allowed_file_types ) ) {
            $err ='Invalid file type. only allowed: '.implode( ', ',$allowed_file_types );
        } else if ( $_FILES[ $file_field ][ "size" ] > $max_file_size ) {
            $err ='Very Large File. Please try a smaller file';
        }

        if( empty( $err ) ) {

            if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
            $uploadedfile = $_FILES[$file_field];
            $upload_overrides = array( 'test_form' => false );
            $upload = wp_handle_upload( $uploadedfile, $upload_overrides );

            //$upload = wp_upload_bits( $_FILES[ $file_field ][ "name" ], null, @file_get_contents( $_FILES[ $file_field ][ "tmp_name" ] ) );
            if ( !empty( $upload ) && empty( $upload['error'] ) ) {
                if ( !empty( $upload[ 'url' ] ) ) {
                    //Successfully file uploaded!
                    $_SESSION['ticket_files'][] = $upload;
                    $url = $upload[ 'url' ];
                    echo $url;
                    // $img = '..' . substr( $upload[ 'url' ], strpos( $upload[ 'url' ], '/wp-content' ) );
                    // if ( !empty( $thumb ) ) {
                    // $thumb = str_replace( '..', site_url(), $thumb );
                    // } else {
                    // $thumb = str_replace( '..', site_url(), $img );
                    // }
                }
            } else if ( !empty( $upload['error'] ) ) {
                echo $upload['error'];
            } else {
                echo "Possible file upload attack!\n";
            }
        } else {
            echo $err;
        }
        die(1);
    }
}
add_action('wp_ajax_nopriv_umamah_iframe_media_upload', 'umamah_iframe_media_upload_callback');
add_action('wp_ajax_umamah_iframe_media_upload', 'umamah_iframe_media_upload_callback');

/**
* Processing the purchased item downloadable files and document zip or license (txt/pdf) file download.
* 
* @return null 
*/
if ( !function_exists( "umamah_item_download_process" ) ) {
    function umamah_item_download_process() {
        global $current_user;
        $is_user_logged_in = is_user_logged_in();
        
        if ( !empty( $_REQUEST[ 'download' ] ) ) {
            //Incoming download request
            
            if ( $is_user_logged_in ) {
                
                $download_token = trim( strip_tags( $_REQUEST[ 'download' ] ) );
                if ( !empty( $download_token ) ) {
                    $download_token_arr = explode( '.', $download_token );
                    if ( !empty( $download_token_arr) && is_array( $download_token_arr ) ) {
                        $download_token_md5 = $download_token_arr[0];
                        
                        if ( !empty( $download_token_arr[1] ) ) {
                            $download_token_format = $download_token_arr[1];
                        } else {
                            $download_token_format = '';
                        }
                        
                        if ( 'zip' == $download_token_format || 'pdf' == $download_token_format || 'txt' == $download_token_format ) {
                            if ( 'zip' == $download_token_format ) {
                                //Request to download All Files & Documentations
                                
                                umamah_download_item_files( $download_token_md5, 'zip' );
                            } else if ( 'pdf' == $download_token_format ) {
                                //Request to download License Certificate & Purchase Code (PDF)
                                
                                umamah_download_license_files( $download_token_md5, 'pdf' );
                            } else if ( 'txt' == $download_token_format ) {
                                //Request to download License Certificate & Purchase Code (TXT)
                                
                                umamah_download_license_files( $download_token_md5, 'txt' );
                            } 
                        } else {
                            wp_redirect( umamah_url( 'download', false, array('download-error' => 'download_type_token' ) ), 301 );
                            exit;
                        }
                        
                    } else {
                        wp_redirect( umamah_url( 'download', false, array('download-error' => 'download_token' ) ), 301 );
                        exit;
                    }
                } else {
                    wp_redirect( umamah_url( 'download', false, array('download-error' => 'download_token' ) ), 301 );
                    exit;
                }
                
            } else {
                //Redirecting user to login interface
                $current_page_uri = get_permalink();
                wp_redirect( umamah_url( 'login', false, array('redirect_to' => urlencode( $current_page_uri )) ), 301 );     
                exit;
            }
            
        }
    }
}
add_action( 'init', 'umamah_item_download_process' );

/**
* Processing the free item downloadable files and document zip file download.
* 
* @return null 
*/
if ( !function_exists( "umamah_item_download_free_process" ) ) {
    function umamah_item_download_free_process() {
        if ( !empty( $_REQUEST[ 'download-free' ] ) ) {
            //Incoming download request
            global $umamah_err, $umamah_info;
            
            $download_token_md5 = trim( strip_tags( $_REQUEST[ 'download-free' ] ) );
            if ( !empty( $download_token_md5 ) ) {
                //Request to download All Files & Documentations
                umamah_download_free_item_files( $download_token_md5, 'zip' );
            } else {
                $umamah_err = true;
                $umamah_info = __('<strong>Error:</strong> Invalid download token used.', LANG_DOMAIN);
            }
            
        }
    }
}
add_action( 'init', 'umamah_item_download_free_process' );

/**
* Retrieving all purchased theme and plugin post items id in a array for currently logged in user.
* TODO: Needs to add a filter if s/he added that item on download list
*/
function get_logged_in_user_downloadable_items() {
    global $current_user;
    $return = array();
    
    if ( 0 == $current_user->ID ) {
        return $return;
    }
    
    $args = array(
           'post_type' => array('theme', 'plugin', 'markup'),
           'posts_per_page' => -1,
           'fields' => 'id',            
           'orderby'=> 'menu_order date'
    );   
    query_posts( $args );
    if ( have_posts() ) { 
        while( have_posts() ) {
            the_post(); 
            array_push( $return, get_the_ID() );
        }
    } 
    wp_reset_query();
    return $return;
}

/**
* Retrieving all purchased theme and plugin post items id in a array for any user.
* TODO: Needs to add a filter if s/he added that item on download list
*/
function get_free_downloadable_items() {
    $return = array();
    
    $args = array(
           'post_type' => array('theme', 'plugin', 'markup'),
           'posts_per_page' => -1,
           'fields' => 'id',            
           'orderby'=> 'menu_order date'
    );   
    query_posts( $args );
    if ( have_posts() ) { 
        while( have_posts() ) {
            the_post(); 
            array_push( $return, get_the_ID() );
        }
    } 
    wp_reset_query();
    return $return;
}

/**
* To get theme or plugin post id by it's md5 token string for a logged in user only.
* 
* @param download_token_md5 string mdf string to item id
* @return type int post ID
*/
function get_post_id_by_download_token_md5( $download_token_md5 ){
    $logged_in_user_downloadable_items = get_logged_in_user_downloadable_items();
    $post_id = 0;
    if ( !empty( $logged_in_user_downloadable_items ) && is_array( $logged_in_user_downloadable_items ) ) { //Is valid user requesting the downlaod
        foreach($logged_in_user_downloadable_items as $index => $pid) {
            if ( md5($pid) != $download_token_md5 ) continue;
            $post_id = $pid;
            break;
        }
    }
    return $post_id;
}

/**
* To get theme or plugin post id by it's md5 token string for any user.
* 
* @param download_token_md5 string mdf string to item id
* @return type int post ID
*/
function get_post_id_by_download_free_token_md5( $download_token_md5 ){
    $downloadable_items = get_free_downloadable_items();
    $post_id = 0;
    if ( !empty( $downloadable_items ) && is_array( $downloadable_items ) ) { //Is valid user requesting the downlaod
        foreach($downloadable_items as $index => $pid) {
            if ( md5($pid) != $download_token_md5 ) continue;
            $post_id = $pid;
            break;
        }
    }
    return $post_id;
}

/**
* Checking if the item theme / plugin is free to download by id
* 
* @param post_id int 
* @return bool true if the requested item is free to download by price
*/
function umamah_check_if_item_is_free_by_id( $post_id ){
    $post_type = get_post_type( $post_id );
    $post_type_singular = umamah_get_item_post_type_singular_slug( $post_type );
    $_item_price = (int) get_post_meta( $post_id, $post_type_singular . '_price', TRUE );
    
    return $_item_price <= 0;
}

/**
 *
 * Read file using WordPress WP_Filesystem
 *
 * @Author       : Jewel Ahmed
 * @Author Web   : http://codeatomic.com
 *
 * @param str $download_file_path - (required) the path of downloadable file
 *
 * @return outputing readfile using WordPress filesystem_method
 **/
function umamah_read_file( $download_file_path ) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    WP_Filesystem();
    global $wp_filesystem;
    echo $wp_filesystem->get_contents( $download_file_path );
}

/**
 *
 * Write file using WordPress WP_Filesystem
 *
 * @Author       : Jewel Ahmed
 * @Author Web   : http://codeatomic.com
 *
 * @param str $path - (required) the path of file
 * @param str $content - (required) the content of file
 *
 * @return outputing readfile using WordPress filesystem_method
 **/
function umamah_write_file( $path, $content ) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    WP_Filesystem();
    global $wp_filesystem;
    $wp_filesystem->put_contents( $path, $content, FS_CHMOD_FILE );
}

/**
 *
 * Get file using WordPress WP_Filesystem
 *
 * @Author       : Jewel Ahmed
 * @Author Web   : http://codeatomic.com
 *
 * @param str $path - (required) the path of file
 *
 * @return getting file content using WordPress filesystem_method
 **/
function umamah_get_file_content( $path ) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    WP_Filesystem();
    global $wp_filesystem;
    return $wp_filesystem->get_contents( $path );
}

/**
* Processing the purchased item downloadable files and document zip file download.
* 
* @param download_token_md5 string mdf string to item id
* @param type string type of file to be downloaded and it can be zip only for this current version.
*/
function umamah_download_item_files( $download_token_md5, $type = 'zip' ) {
    global $umamah_err, $umamah_info;
    $theme_key = 'umamah_';
    
    $post_id = get_post_id_by_download_token_md5( $download_token_md5 );
    if ( $post_id > 0 ) {
        $post_type = get_post_type( $post_id );
        $post_type_singular = umamah_get_item_post_type_singular_slug( $post_type );
        $downloadable_zip = get_post_meta( $post_id, $theme_key . $post_type_singular . '_downloadable_all_files', TRUE );
        $upload_dir = wp_upload_dir();
        
        if ( !empty( $downloadable_zip ) ) {
            // $attachment_id = umamah_get_attachment_id_from_url($downloadable_zip);
            $download_file_path = get_attached_file( $downloadable_zip, $unfiltered = false );
            if ( file_exists( $download_file_path ) ) {
                $file_name = basename($download_file_path);
                header("Content-Type: application/zip");
                header("Content-Disposition: attachment; filename=$file_name");
                header("Content-Length: " . filesize($download_file_path));
                readfile($download_file_path);
                exit;
            } else {
                $umamah_err = true;
                $umamah_info = __('<strong>Error:</strong> Item downloadable files is not available, please contact help desk.', LANG_DOMAIN);
            }
        } else {
            $umamah_err = true;
            $umamah_info = __('<strong>Error:</strong> Item downloadable files is not available, please contact help desk.', LANG_DOMAIN);
        } 
        
    } else {
        $umamah_err = true;
        $umamah_info = __('<strong>Error:</strong> Invalid download token used.', LANG_DOMAIN);
    }
}


/**
* Processing the purchased item downloadable files and document zip file download.
* 
* @param download_token_md5 string mdf string to item id
* @param type string type of file to be downloaded and it can be zip only for this current version.
*/
function umamah_download_free_item_files( $download_token_md5, $type = 'zip' ) {
    global $umamah_err, $umamah_info;
    $theme_key = 'umamah_';
    
    $post_id = get_post_id_by_download_free_token_md5( $download_token_md5 );
    
    if ( $post_id > 0 ) {
        
        $is_free = umamah_check_if_item_is_free_by_id( $post_id );
        if ( $is_free ) {
        
            $post_type = get_post_type( $post_id );
            $post_type_singular = umamah_get_item_post_type_singular_slug( $post_type );
            $downloadable_zip = get_post_meta( $post_id, $theme_key . $post_type_singular . '_downloadable_all_files', TRUE );
            $upload_dir = wp_upload_dir();

            if ( !empty( $downloadable_zip ) ) {
                // $attachment_id = umamah_get_attachment_id_from_url($downloadable_zip);
                $download_file_path = get_attached_file( $downloadable_zip, $unfiltered = false );
                if ( file_exists( $download_file_path ) ) {
                    $file_name = basename($download_file_path);
                    header("Content-Type: application/zip");
                    header("Content-Disposition: attachment; filename=$file_name");
                    header("Content-Length: " . filesize($download_file_path));
                    readfile($download_file_path);
                    exit;
                } else {
                    $umamah_err = true;
                    $umamah_info = __('<strong>Error:</strong> Item downloadable files is not available, please contact help desk.', LANG_DOMAIN);
                }
            } else {
                $umamah_err = true;
                $umamah_info = __('<strong>Error:</strong> Item downloadable files is not available, please contact help desk.', LANG_DOMAIN);
            } 
            
        } else {
            $umamah_err = true;
            $umamah_info = __('<strong>Error:</strong> This item is not free to download.', LANG_DOMAIN);
        }  
        
    } else {
        $umamah_err = true;
        $umamah_info = __('<strong>Error:</strong> Invalid download token used.', LANG_DOMAIN);
    }
}


/**
* Returing the attachment id by url
* 
* @return id 
*/
function umamah_get_attachment_id_from_url( $attachment_url = '' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}

/**
* Returing the operating system dependent end of line special characters.
* 
* @return string 
*/
function get_eol(){
    if (!defined('PHP_EOL')) {
        switch (strtoupper(substr(PHP_OS, 0, 3))) {
            // Windows
            case 'WIN':
                define('PHP_EOL', "\r\n");
                break;

            // Mac
            case 'DAR':
                define('PHP_EOL', "\r");
                break;

            // Unix
            default:
                define('PHP_EOL', "\n");
        }
    }
    
    return PHP_EOL;
}

/**
* Processing the purchased item license file download
* 
* @param download_token_md5 string mdf string to item id
* @param type string type of file to be downloaded and it can be txt or pdf
*/
function umamah_download_license_files( $download_token_md5, $type = 'txt' ) {
    global $current_user, $umamah_err, $umamah_info;
    $theme_key = 'umamah_';
    
    $post_id = get_post_id_by_download_token_md5( $download_token_md5 );
    if ( $post_id > 0 ) {
        $post_item = get_post( $post_id );
        
        if ( !empty( $post_item ) ) {
            $_data_title = $post_item->post_title;
            
            $post_type = get_post_type( $post_id );
            $post_type_singular = umamah_get_item_post_type_singular_slug( $post_type );

            $_data_sub_title = get_post_meta( $post_id, $theme_key . 'sub_heading', TRUE );
            if ( !empty( $_data_sub_title ) ) {
                $_data_title.= ' - ' . $_data_sub_title;
            }
            $_data_item_url = get_permalink( $post_id );
            $_data_contact_url = umamah_url( 'contact' );
            
            if ( is_multisite() ) {
                $_data_blogname = $GLOBALS['current_site']->site_name;
            } else {
                $_data_blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
            }
            
            $_data_toc_url = umamah_url( 'terms-and-condition' );
            $_data_licensee_email = $current_user->data->user_email;
            
            $_data_purchase_date = date("Y-m-j g:i a");
            
            $license_file_name = sanitize_title_with_dashes( $_data_title ) . '-license-'.$post_id.'.' . $type;
            
$content = "
LICENSE CERTIFICATE : [SITE_NAME] Item 
*********************************************** 

This document certifies the purchase of: ONE REGULAR LICENSE 
As defined in the standard terms and conditions on [TOC_URL] 

Licensee: [LICENSEE_EMAIL]

For the item: [ITEM_TITLE] 

Item URL: [ITEM_URL]
Item ID: [ITEM_ID] 
Purchase Date: [PURCHASE_DATE] 

For any queries related to this document or license please contact Help Team via [CONTACT_URL] 

[SITE_NAME] 

**** THIS IS NOT A TAX RECEIPT OR INVOICE ****";
            
            
            $license_text = nl2br( umamah_get_option( 'account', 'purchased_item_license_text', $content ) );
            $license_text = str_replace( '<br />', get_eol(), $license_text );
            
            $shortcodes_list = array(
                '[SITE_NAME]' => $_data_blogname,
                '[TOC_URL]' => $_data_toc_url,
                '[LICENSEE_EMAIL]' => $_data_licensee_email,
                '[ITEM_TITLE]' => $_data_title,
                '[ITEM_URL]' => $_data_item_url,
                '[ITEM_ID]' => $post_id,
                '[PURCHASE_DATE]' => $_data_purchase_date,
                '[CONTACT_URL]' => $_data_contact_url
            );
            $license_text = str_replace( array_keys($shortcodes_list), array_values($shortcodes_list), $license_text );
            
            $handle = fopen( $license_file_name, "w" );
            fwrite( $handle, $license_text );
            fclose( $handle );

            header( 'Content-Type: application/octet-stream' );
            header( 'Content-Disposition: attachment; filename='.basename( $license_file_name ) );
            header( 'Expires: 0' );
            header( 'Cache-Control: must-revalidate' );
            header( 'Pragma: public' );
            header( 'Content-Length: ' . filesize( $license_file_name ) );
            readfile( $license_file_name );
            exit;
            
        } else {
            $umamah_err = true;
            $umamah_info = __('<strong>Error:</strong> Item does not exists, please contact help desk.', LANG_DOMAIN);
        }
        
    } else {
        $umamah_err = true;
        $umamah_info = __('<strong>Error:</strong> Invalid download token used.', LANG_DOMAIN);
    }  
}



function umamah_search_filter( $query ) {
    if ( $query->is_search ) {
        $pages = get_posts( array(
            'numberposts' => -1,
            'order' => 'asc',
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => array( 'templates/payment-success.php', 'templates/payment-cancel.php', 'templates/download.php', 'templates/checkout.php', 'templates/account.php' )
        ));
        $page_ids = array();
        foreach($pages as $key=>$val){
            $page_ids[] = $val->ID;
        }
        if( !empty($page_ids) ) {
            $query->set('post__not_in', $page_ids);    
        }
        
    }
    return $query;
}
add_filter('pre_get_posts','umamah_search_filter');