<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package trstarter
 */

$_header_custom_title = get_post_meta( get_the_ID(), TRTHEME_THEME_KEY . 'custom_title', TRUE );
$_header_sub_title = get_post_meta( get_the_ID(), TRTHEME_THEME_KEY . 'sub_title', TRUE );
$_header_hide_title = get_post_meta( get_the_ID(), TRTHEME_THEME_KEY . 'hide_title', TRUE );
if ( !empty( $_header_sub_title ) ) {
	$_header_sub_title = ' <small class="entry-sub-title">'.$_header_sub_title.'</small>';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (!is_front_page() && !$_header_hide_title) { ?>
        <header class="entry-header">
            <?php the_title('<h1 class="entry-title">',  $_header_sub_title .'</h1>'); ?>
        </header>
    <?php } ?>

    <div class="entry-content">
        <?php the_content(); ?>
        <?php
        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', TRTHEME_LANG_DOMAIN),
            'after' => '</div>',
        ));
        ?>
    </div>

    <?php if (!is_front_page() && is_user_logged_in() ) { ?>
        <footer class="entry-footer">
            <?php
            edit_post_link(
                sprintf(
                /* translators: %s: Name of current post */
                    esc_html__('Edit %s', TRTHEME_LANG_DOMAIN),
                    the_title('<span class="screen-reader-text">"', '"</span>', false)
                ),
                '<span class="edit-link">',
                '</span>'
            );
            ?>
        </footer>
    <?php } ?>
</article>

