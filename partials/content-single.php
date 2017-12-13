<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package trstarter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if (has_post_thumbnail()) { ?>
		<div class="featured-image"><?php the_post_thumbnail(); ?></div>
	<?php } ?>

	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>

		<div class="entry-meta">
			<?php trtitan_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages(array(
			'before' => '<div class="page-links">' . esc_html__('Pages:', TRTHEME_LANG_DOMAIN),
			'after' => '</div>',
		));
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php trtitan_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

