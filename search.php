<?php
/**
 *
 * The template for displaying Search Results pages
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeredesign.com
 */

global $wp_query;

$search_text = '';
if (!empty($_REQUEST['s'])) {
    $search_text = $_REQUEST['s'];
}
$found_posts = $wp_query->found_posts;

$total_page = $wp_query->max_num_pages;
$paged = (get_query_var('page')) ? intval(get_query_var('page')) : (get_query_var('paged')) ? intval(get_query_var('paged')) : 1;

get_header();
?>

    <!--BEGIN #content-body -->
    <div id="content-body">
        <div class="page search-result-page hentry">
            <header>
                <div class="container">
                    <div class="row item-navbar-row">
                        <div class="col-sm-12">
                            <h2 class="entry-title">
                                <?php _e('Search results for:', TRTHEME_LANG_DOMAIN) ?><?php echo $search_text; ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </header>
        </div>
        <div class="entry-section entry-search-result-form-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="entry-content">
                            <p class="page-sub-head"><?php echo sprintf(_n('Total <span>%d</span> result found', 'Total <span>%d</span> results found', $found_posts, TRTHEME_LANG_DOMAIN), $found_posts); ?><?php _e('/', TRTHEME_LANG_DOMAIN); ?><?php echo sprintf(__("You are on page %d of %d", TRTHEME_LANG_DOMAIN), $paged, $total_page); ?></p>


                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="<?php echo home_url('/'); ?>" method="get"
                                          class="search search-box search-page-search-form">
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><span
                                                        class="glyphicon glyphicon-search"></span></span>
                                            <input type="text"
                                                   placeholder="<?php _e('Type Your Search Keywords', TRTHEME_LANG_DOMAIN); ?>"
                                                   name="s" value="<?php echo $search_text; ?>" title="Search for:"
                                                   class="form-control search-field input-lg" id="s">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-primary btn-lg">Search</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="entry-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="entry-content">
                            <?php
                            if (have_posts()) {
                                while (have_posts()) {
                                    the_post();
                                    get_template_part('partials/content', 'search-archive');
                                }
                                ?>
                                <div class="blog-item-display-pagination">
                                    <?php
                                    get_template_part('partials/block', 'post-index-navigation');
                                    ?>
                                </div>
                                <?php
                            } else {
                                get_template_part('partials/content', 'search-not-found');
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

<?php
get_footer();

