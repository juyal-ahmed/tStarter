<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package trstarter
 */

get_header(); ?>
<div class="row">
    <div class="col-md-8 col-sm-12">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php while (have_posts()) : the_post(); ?>

                    <?php get_template_part('partials/content', 'single'); ?>

                    <?php the_post_navigation(); ?>

					<?php echo get_author_info_box(); ?>

                    <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; ?>

            </main>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 sidebar-wrap">
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>
