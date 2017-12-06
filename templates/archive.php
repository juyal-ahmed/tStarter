<?php
/*
*
* Template Name: Themes
* Description: This template can use to create theme item listing page.
*                                                      
* @author Juyal Ahmed<tojibon@gmail.com>
* @version: 1.0.0
* https://themeredesign.com
*/


global $wp_query;
$theme_key = 'umamah_';
$current_page = pagination_paged();
/*
---------------------------------------------------------------------------------------
    Page header meta info 
---------------------------------------------------------------------------------------
*/
$_header_custom_title = 'Themes';// get_post_meta( get_the_ID(), 'page-header_header_custom_title', TRUE );
$_header_sub_title = 'All Responsive themes';// get_post_meta( get_the_ID(), 'page-header_header_sub_title', TRUE );
if ( !empty( $_header_sub_title ) ) {
	$_header_sub_title = '<span class="entry-sub-title">'.$_header_sub_title.'</span>';
}
if ( !empty( $_header_custom_title ) ) {
	$title = $_header_custom_title;
} else {
	$title = get_the_title();
}

$themes_category = get_query_var( 'themes' );
if( !empty( $themes_category ) ) {
	$themes_category_Obj = get_term_by( 'slug', $themes_category, 'themes' );
    $_header_sub_title = '';
    $title = $themes_category_Obj->name;
} else {
    $themes_category_Obj = '';
}

/*
---------------------------------------------------------------------------------------
    Loading page header section
---------------------------------------------------------------------------------------
*/
get_header();
?>
	<div id="content-body">
	
	<?php get_template_part( 'partials/partial-content', 'banner' ); ?>
	
	<?php 
	if( have_posts() ) { 
			the_post(); 
			?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header>
					<div class="container container-wide">
						<div class="item-navbar-row">
							<h2 class="entry-title"><?php echo $title; ?> <?php echo $_header_sub_title; ?></h2>
                            <nav class="filter-navbar pull-right">
                                <ul id="plugins-filters">
                                    <?php
                                    $entries = get_categories( 'taxonomy=themes&title_li=&orderby=name&suppress_filters=0&hide_empty=1' );
                                    foreach ( $entries as $key => $entry ) {
                                        $options[ $entry->term_id ] = $entry->name;
                                        $catlink = get_term_link( $entry, 'theme' );
                                        ?>
                                        <li><a class="<?php echo $entry->slug; ?> transition <?php if ( !empty($themes_category) && $themes_category === $entry->slug ) { echo 'active'; } ?>" href="<?php echo $catlink; ?>"><?php echo $entry->name; ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </nav>
						</div>
					</div>
				</header>
				<?php 
				$content = get_the_content();
				if( trim( $content ) == "" && !$themes_category_Obj ) {	//Nothing to display
				?>
				<div class="theme-plugin-empty-page-content"></div>
				<?php 
				} else if ( !$themes_category_Obj ) {
				?>
				<section class="entry-section">
					<div class="container container-wide">
						<div class="row">
							<div class="col-sm-12">
								<div class="entry-content pb-0">
								<?php the_content( ); ?>
								<?php
                                $args = array(
                                    'before'           => '<nav class="wp-prev-next post-index-navigation" id="blog-pagination-nav-number"><p class="pagination wp_link_pages_wrap">',
                                    'after'            => '</p></nav>',
                                    'link_before'      => '<span>',
                                    'link_after'       => '</span>',
                                    'next_or_number'   => 'number',
                                    'separator'        => ' ',
                                    'nextpagelink'     => __( 'Next page', 'umamah' ),
                                    'previouspagelink' => __( 'Previous page', 'umamah' ),
                                    'pagelink'         => '%',
                                    'echo'             => 1
                                );
                                wp_link_pages( $args );
                                ?>
								</div>
							</div>
						</div>
					</div>
				</section>
				<?php
				} else if ( !empty( $themes_category_Obj ) && !empty( $themes_category_Obj->description ) ) {
				?>
				<section class="entry-section">
					<div class="container container-wide">
						<div class="row">
							<div class="col-sm-12">
								<div class="entry-content pb-0"><?php echo nl2br($themes_category_Obj->description); ?></div>
							</div>
						</div>
					</div>
				</section>
				<?php
				} else {
                ?>
                <div class="theme-plugin-empty-page-content"></div>
                <?php 
                }
				?>
				
			</article> 
			
			<?php 
			$post_count = 0; 
			$posts_per_page = 9;
            if ( empty( $posts_per_page ) || (int) $posts_per_page <= 0 ) {
                $posts_per_page = 9;
            }
			$width = 610; //Originally 365x365
			$height = 610;
			$crop = array('center', 'top');
			
            if( !empty( $themes_category ) ) {
                $tax_query = array (
                    array (
                        'taxonomy' => 'themes',
                        'field' => 'slug',
                        'terms' => $themes_category
                    )
                );
            } else {
                $tax_query = array();
            }
            
            $the_query = new WP_Query( 
                array(
                    'post_type' => 'theme',
                    'posts_per_page' => -1,
                    'orderby'=> 'menu_order date',
                    'tax_query' => $tax_query
                )
            );
            
            while ( $the_query->have_posts() ) { 
                $the_query->the_post();
                $post_count++;
            }
            wp_reset_postdata();
			
            $args = array(
                   'post_type' => 'theme',
                   'posts_per_page' => $posts_per_page,
                   'paged' => $current_page,    
                   'orderby'=> 'menu_order date',
                   'tax_query' => $tax_query
            );   
            query_posts( $args );
			if ( have_posts() ) { 
			?>
			
				<div class="container container-wide">
					<div class="row">
						<div class="col-sm-12">
                            <div class="items-grid">
							    <div class="row">
								<?php 
								while( have_posts() ) {
									the_post();
                                    ?>
                                    <div class="col-sm-12 col-md-6 col-md-4">
                                        <?php get_template_part( 'partials/themes/item' ); ?>
                                    </div>
								<?php } ?>
                                </div>
							</div>
							
							<div class="theme-plugin-item-display-pagination">
							<?php get_template_part( 'partials/block', 'item-index-navigation' ); ?>
							</div>
							
						</div>
					</div>
				</div>
			
			<?php 
            } else {
            ?>
                <div class="container">
					<div class="row">
						<div class="col-sm-12 empty-items-listing">
                            <p class="alert alert-info"><?php _e('Sorry, no themes found at this time on our database for your search criteria, please come back later or refer to our newsletter subscription for upcoming releases.', 'umamah'); ?></p>
                        </div>
                    </div>
                </div>
            <?php
            }
			wp_reset_query();
		}
	?>
	
	</div>
<?php 
get_footer();
