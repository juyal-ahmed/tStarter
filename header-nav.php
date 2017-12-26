<?php
/**
 *
 * Theme default header.
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeana.com
 */

global $current_user;

$logo_image = '';
?>
<div id="header-outer">
    <header id="top">
        <div class="container <?php echo trtitan_get_site_layouot_css('header_footer'); ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="logo-wrapper pull-left">
                        <div class="logo-wrapper-inner">
                            <a id="logo" href="<?php echo home_url(); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.jpg" alt="Logo" />
                            </a>
                        </div>
                    </div>

                    <div class="pull-right">
                        <span class="toggle-mobile-menu">☰</span>

                        <nav class="primary-menu">
                            <ul>
                                <?php
                                if( has_nav_menu( 'primary' ) ) {
                                    wp_nav_menu( array('walker' => new Umamah_Arrow_Walker_Nav_Menu, 'theme_location' => 'primary', 'container' => '', 'items_wrap' => '%3$s' ) );
                                } else {
                                    echo '<li><a href="">No menu assigned!</a></li>';
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <nav class="mobile-menu">
                        <ul>
                            <?php
                            if( has_nav_menu( 'primary' ) ) {
                                wp_nav_menu( array('walker' => new Umamah_Arrow_Walker_Nav_Menu, 'theme_location' => 'primary', 'container' => '', 'items_wrap' => '%3$s' ) );
                            } else {
                                echo '<li><a href="">No menu assigned!</a></li>';
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</div>
