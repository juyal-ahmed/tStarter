<?php
/**
*
* This file contains the status contents for posts
*
* @author Juyal Ahmed<tojibon@gmail.com>
* @version: 1.0.0
* https://themeana.com
*/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post-item' ); ?> role="article">
    <?php get_template_part( 'formats/post', 'date' );  ?>
    <section class="article-content">
        <h2 class="article-header"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
        <?php get_template_part( 'formats/content-with', 'footer' );  ?>
    </section>
    <?php get_template_part( 'partials/block', 'blog-navigation' );  ?>
    <?php
    if( is_singular() ) {
        get_template_part( 'partials/content', 'comment-form' );
    }
    ?>
</article>
