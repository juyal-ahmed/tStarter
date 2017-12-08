<?php
/**
* 
* This file contains the post content only
*
* @author Juyal Ahmed<tojibon@gmail.com>
* @version: 1.0.0
* https://themeredesign.com
*/

?>
<time class="meta-post-date" datetime="<?php echo the_time( 'Y-m-d h:i:s' ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time>
<?php

get_template_part( 'partials/article-post', 'slider' );

$_post_summary = get_post_meta( get_the_ID(), 'posts-other-info_post_summary', true ); 
if( !empty( $_post_summary ) ) {
?>
<div class="post-summary">
    <?php echo do_shortcode( $_post_summary ); ?>
</div>
<?php 
}
?>

<div class="post-content">
<?php 
if( !is_singular() ) {
    $blog_index_content_type = 'content';
    if( $blog_index_content_type == 'content' ) {
        the_content( __( "Continue Reading &#8594;", TRTHEME_LANG_DOMAIN ) . "<span></span>" );    
    } else {
        the_excerpt();
    }                
} else {
    the_content( __( "Continue Reading &#8594;", TRTHEME_LANG_DOMAIN ) . "<span></span>" );
}
?>
</div>