<?php
/*
*
* Template Name: Home
* Description: This template can use to create site front page.
*                                                      
* @author Juyal Ahmed<tojibon@gmail.com>
* @version: 1.0.0
* https://themeredesign.com
*/


$theme_key = 'umamah_';

get_header();
?>
	<div id="content-body">

        <?php get_template_part( 'partials/partial-content', 'banner' ); ?>

        <?php
        if( have_posts() ) {
            while( have_posts() ) {
                the_post();
                ?>
                <div class="container content">
                    <?php the_content(); ?>
                </div>
                <?php
            }
        }
        ?>

        <div class="container container-wide">
        <?php
        wp_reset_postdata();

        $args = array(
            'post_type' => 'theme',
            'posts_per_page' => 4,
            'paged' => 1,
            'orderby'=> 'menu_order date'
        );
        $the_query = new WP_Query($args);
        $i = 0;
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $i++;
            if ( $i == 1 ) {
                $image = wp_get_attachment_url( get_post_thumbnail_id() );
                $_sub_title = get_post_meta( get_the_ID(), $theme_key . 'sub_heading', TRUE );
                $_theme_price = (int) get_post_meta( get_the_ID(), $theme_key . 'price', TRUE );
                ?>
                <div class="container latest-theme">
                    <div class="theme">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?> - <?php echo $_sub_title; ?>">
                            <img src="<?php echo $image; ?>"
                                 class="attachment-feature size-feature transition"
                                 alt="<?php the_title(); ?> - <?php echo $_sub_title; ?>"
                                 srcset="<?php echo $image; ?> 1170w, <?php echo $image; ?> 300w, <?php echo $image; ?> 768w, <?php echo $image; ?> 1024w"
                                 sizes="(max-width: 1170px) 100vw, 1170px">
                            <div class="overlay transition"></div>
                            <div class="overlay-title transition"><?php the_title(); ?></div>
                            <div class="overlay-title overlay-sub-title transition"><?php echo $_sub_title; ?></div>
                        </a>
                    </div>
                </div>
                <?php
            } else {
                // TODO: Rest of the themes will goes here
                if ( $i == 2 ) {
                    ?>
                    <div class="home-items-grid items-grid">
                        <div class="row">
                    <?php
                }
                ?>
                    <div class="col-sm-12 col-md-6 col-md-4">
                        <?php get_template_part( 'partials/themes/item' ); ?>
                    </div>
                <?php
            }
        }
        ?>
                        </div>
                    </div>
        </div>

    </div>
<?php 
get_footer();
