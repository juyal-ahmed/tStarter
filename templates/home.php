<?php
/*
*
* Template Name: Home
* Description: This template can use to create site front page.
*
* @author Juyal Ahmed<tojibon@gmail.com>
* @version: 1.0.0
* https://themeana.com
*/


get_header(); ?>
<div class="row">
    <div class="col-sm-12">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php while (have_posts()) : the_post(); ?>

                    <?php get_template_part('partials/content', 'page'); ?>

                <?php endwhile; ?>

            </main>
        </div>
    </div>
</div>
<?php get_footer(); ?>
