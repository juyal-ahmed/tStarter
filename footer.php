<?php
/**
 *
 * Theme default footer
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeredesign.com
 */
?>


<!-- END #container -->
</div>

<div id="footer-wrapper" class="mt-60">
    <div class="container <?php echo trtitan_get_site_layouot_css('header_footer'); ?>">
        <div class="row">
            <div class="col-lg-12">

                <footer id="footer" class="container-background footer">

                    <?php if ( is_active_sidebar( 'footer1' ) || is_active_sidebar( 'footer2' ) || is_active_sidebar( 'footer3' ) ) : ?>
                        <div id="footer-sidebars" class="box-sizing footer-sidebars clearfix">
                            <div class="row">

                                <div class="footer-sidebars-inner-widgets col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <?php if ( is_active_sidebar( 'footer1' ) ) : ?>
                                        <div class="footer-sidebars-widgets-inner">
                                            <?php dynamic_sidebar( 'footer1' ); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>


                                <div class="footer-sidebars-inner-widgets col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <?php if ( is_active_sidebar( 'footer2' ) ) : ?>
                                        <div class="footer-sidebars-widgets-inner">
                                            <?php dynamic_sidebar( 'footer2' ); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>


                                <div class="footer-sidebars-inner-widgets col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <?php if ( is_active_sidebar( 'footer3' ) ) : ?>
                                        <div class="footer-sidebars-widgets-inner">
                                            <?php dynamic_sidebar( 'footer3' ); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>


                                <div class="footer-sidebars-inner-widgets col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <?php if ( is_active_sidebar( 'footer4' ) ) : ?>
                                        <div class="footer-sidebars-widgets-inner">
                                            <?php dynamic_sidebar( 'footer4' ); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="copyright clearfix">
                        <?php
                        $footer_copyright_text = '';// trtitan_get_option( 'others', 'footer_copyright_text', '' );
                        if( !empty( $footer_copyright_text ) ) {
                            echo do_shortcode( $footer_copyright_text );
                        } else {
                            $footer_copyright_text = 'Copyright &copy; '.date( "Y" ).' '.get_bloginfo( 'name' ).' Powered by <a href="http://wordpress.org/">WordPress</a>. '.get_bloginfo( 'name' ).' by Themeana.';
                            ?><p><?php echo $footer_copyright_text; ?></p><?php
                        }
                        ?>
                    </div>

                </footer>

            </div>
        </div>
    </div>
</div>

<!--<a class="move-to-top" href="#" id="move-to-top"><span class="glyphicon glyphicon-chevron-up"></span></a>-->

<!-- Theme Hook -->
<?php wp_footer(); ?>

<!-- END html -->
</html>
