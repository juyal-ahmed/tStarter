<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package youtha
 */

get_header(); ?>
<div class="row">
    <div class="col-md-9 col-sm-12">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php while (have_posts()) : the_post(); ?>

                    <?php get_template_part('partials/content', 'page'); ?>

                    <?php the_post_navigation(); ?>

                    <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; ?>

            </main>
        </div>
    </div>
    <div class="col-md-3 col-sm-12 sidebar-wrap">
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>

