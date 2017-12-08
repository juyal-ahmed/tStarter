<?php
/**
 *
 * Theme default sidebar
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeredesign.com
 */

$is_sidebar_widgets_loaded = false;
?>
<?php if (!is_page() && (function_exists('dynamic_sidebar') && is_active_sidebar('main-sidebar'))) { ?>

    <!--BEGIN Main Sidebar-->
    <?php dynamic_sidebar('main-sidebar'); ?>
    <!--END Main Sidebar-->

    <?php $is_sidebar_widgets_loaded = true; ?>

<?php } else if (is_page() && (function_exists('dynamic_sidebar') && is_active_sidebar('page-sidebar'))) { ?>

    <!--BEGIN Page Sidebar-->
    <?php dynamic_sidebar('page-sidebar'); ?>
    <!--END Page Sidebar-->

    <?php $is_sidebar_widgets_loaded = true; ?>

<?php } else if ((function_exists('dynamic_sidebar') && is_active_sidebar('main-sidebar'))) { ?>

    <!--BEGIN Main Sidebar-->
    <?php dynamic_sidebar('main-sidebar'); ?>
    <!--END Main Sidebar-->

    <?php $is_sidebar_widgets_loaded = true; ?>

<?php }

if (!$is_sidebar_widgets_loaded) { ?>

    <!--BEGIN Static Sidebar Widgets-->
    <?php the_widget('WP_Widget_Recent_Posts'); ?>
    <?php the_widget('WP_Widget_Recent_Comments'); ?>
    <?php the_widget('WP_Widget_Archives'); ?>
    <?php the_widget('WP_Widget_Categories'); ?>
    <?php the_widget('WP_Widget_Meta'); ?>
    <!--END Static Sidebar Widgets-->

<?php } ?>