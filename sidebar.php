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
    <?php
    //Widgets general settings
    $args = array(
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div><div class="widget-divider"></div>',
        'before_title' => '<h3 class="widget-title widetext">',
        'after_title' => '</h3><div class="clearfix"></div>'
    );
    ?>
    <?php the_widget('WP_Widget_Recent_Posts', array(), $args); ?>
    <div class="clearfix"></div>
    <?php the_widget('WP_Widget_Recent_Comments', array(), $args); ?>
    <div class="clearfix"></div>
    <?php the_widget('WP_Widget_Archives', array(), $args); ?>
    <div class="clearfix"></div>
    <?php the_widget('WP_Widget_Categories', array(), $args); ?>
    <div class="clearfix"></div>
    <?php the_widget('WP_Widget_Meta', array(), $args); ?>
    <div class="clearfix"></div>
    <!--END Static Sidebar Widgets-->

<?php } ?>