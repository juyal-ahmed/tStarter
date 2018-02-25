<?php
/*
*
* Template Name: Left Sidebar
* Description: This template can use to create left sidebar page.
*
* @author Juyal Ahmed<tojibon@gmail.com>
* @version: 1.0.0
* https://themeana.com
*/

get_header(); ?>
<div class="row">
	<div class="col-md-3 col-sm-12 sidebar-wrap">
		<?php get_sidebar(); ?>
	</div>
	<div class="col-md-9 col-sm-12">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php while (have_posts()) : the_post(); ?>

					<?php get_template_part('partials/content', 'page'); ?>

					<?php
					if (comments_open() || get_comments_number()) :
						comments_template();
					endif;
					?>

				<?php endwhile; ?>

			</main>
		</div>
	</div>
</div>
<?php get_footer(); ?>

