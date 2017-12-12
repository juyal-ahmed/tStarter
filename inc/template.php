<?php

function generate_global_css() {
    $mp_nots = [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95, 100];
    $css = '';
    foreach( $mp_nots as $val ) {
        $css.= '.p-'.$val.' {
        padding: '.$val.'px !important;
    }';
        $css.= '.m-'.$val.' {
        margin: '.$val.'px !important;
    }';
        $css.= '.pt-'.$val.' {
        padding-top: '.$val.'px !important;
    }';
        $css.= '.mt-'.$val.' {
        margin-top: '.$val.'px !important;
    }';
        $css.= '.pr-'.$val.' {
        padding-right: '.$val.'px !important;
    }';
        $css.= '.mr-'.$val.' {
        margin-right: '.$val.'px !important;
    }';
        $css.= '.pb-'.$val.' {
        padding-bottom: '.$val.'px !important;
    }';
        $css.= '.mb-'.$val.' {
        margin-bottom: '.$val.'px !important;
    }';
        $css.= '.pl-'.$val.' {
        padding-left: '.$val.'px !important;
    }';
        $css.= '.ml-'.$val.' {
        margin-left: '.$val.'px !important;
    }';
    }
    return $css;
}

function generate_transition_css($attributes_list = ['all', 'background', 'border',  'color'], $duration = '0.5s', $effect = 'linear') {
    $css = '';
    foreach( $attributes_list as $val ) {
        if ( $val == 'all' ) {
            $css .= '.transition {
                -webkit-transition: all '.$duration.' '.$effect.';
                -moz-transition: all '.$duration.' '.$effect.';
                -ms-transition: all '.$duration.' '.$effect.';
                -o-transition: all '.$duration.' '.$effect.';
                transition: all '.$duration.' '.$effect.';
            }';
        } else {
            $css .= '.transition-' . $val . ' {
                -webkit-transition: ' . $val . ' '.$duration.' '.$effect.';
                -moz-transition: ' . $val . ' '.$duration.' '.$effect.';
                -ms-transition: ' . $val . ' '.$duration.' '.$effect.';
                -o-transition: ' . $val . ' '.$duration.' '.$effect.';
                transition: ' . $val . ' '.$duration.' '.$effect.';
            }';
        }
    }
    return $css;
}

function get_author_info_box()
{
	global $post;
	$content = '';

	if (is_single() && isset($post->post_author)) {
		$display_name = get_the_author_meta('display_name', $post->post_author);
		if (empty($display_name))
			$display_name = get_the_author_meta('nickname', $post->post_author);
		$user_description = get_the_author_meta('user_description', $post->post_author);
		$user_website = get_the_author_meta('url', $post->post_author);
		$user_posts = get_author_posts_url(get_the_author_meta('ID', $post->post_author));
		if (!empty($display_name))
			$author_details = '<p class="author_name">About ' . $display_name . '</p>';
		if (!empty($user_description))
			$author_details .= '<p class="author_details">' . get_avatar(get_the_author_meta('user_email'), 90) . nl2br($user_description) . '</p>';
		$author_details .= '<p class="author_links"><a href="' . $user_posts . '">View all posts by ' . $display_name . '</a>';
		if (!empty($user_website)) {
			$author_details .= ' | <a href="' . $user_website . '" target="_blank" rel="nofollow">Website</a></p>';
		} else {
			$author_details .= '</p>';
		}
		$content = $content . '<footer class="author_bio_section" >' . $author_details . '</footer>';
	}
	return $content;
}
