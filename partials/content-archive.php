<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package trstarter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>

		<?php
		wp_link_pages(array(
			'before' => '<div class="page-links">' . esc_html__('Pages:', TRTHEME_LANG_DOMAIN),
			'after' => '</div>',
		));
		?>

		<div class="archive-lists">
			<h4><?php _e('Last 30 Posts', TRTHEME_LANG_DOMAIN) ?></h4>
			<ul>
				<?php $archive_30 = get_posts('numberposts=30');
				foreach ($archive_30 as $post) : ?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endforeach; ?>
			</ul>
			<h4><?php _e('Archives by Month:', TRTHEME_LANG_DOMAIN) ?></h4>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
			<h4><?php _e('Archives by Subject:', TRTHEME_LANG_DOMAIN) ?></h4>
			<ul>
				<?php wp_list_categories('title_li='); ?>
			</ul>
		</div>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				esc_html__('Edit %s', TRTHEME_LANG_DOMAIN),
				the_title('<span class="screen-reader-text">"', '"</span>', false)
			),
			'<span class="edit-link">',
			'</span>'
		);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

