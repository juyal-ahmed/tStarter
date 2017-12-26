<?php
/**
 *
 * Template Name: Contact
 * Description: This file contains the theme included contact form.
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeana.com
 */

/*
---------------------------------------------------------------------------------------
    Form area meta info
---------------------------------------------------------------------------------------
*/
$_sidebar_content = get_post_meta( get_the_ID(), TRTHEME_THEME_KEY . 'contact_sidebar_content', TRUE );


get_header(); ?>
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">

                    <?php while (have_posts()) : the_post(); ?>

                        <?php get_template_part('partials/content', 'contact'); ?>

                    <?php endwhile; ?>

                </main>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">

            <?php if (!empty($_sidebar_content)) { ?>
                <div class="entry-contact-sidebar p-20">
                    <?php echo wpautop(do_shortcode($_sidebar_content)); ?>
                </div>
            <?php } ?>

        </div>
    </div>
<?php get_footer(); ?>
