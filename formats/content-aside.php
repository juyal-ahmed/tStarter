<?php
/**
* 
* This file contains the aside contents for posts
*
* @author Juyal Ahmed<tojibon@gmail.com>
* @version: 1.0.0
* https://themeredesign.com
*/
?>   

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post-item' ); ?> role="article">
    <section class="article-content">
        <?php get_template_part( 'formats/content' );  ?> 
    </section>
    <?php get_template_part( 'partials/block', 'blog-navigation' );  ?>
    <?php 
    if( is_singular() ) {
        get_template_part( 'partials/content', 'comment-form' );
    }
    ?> 
</article>  