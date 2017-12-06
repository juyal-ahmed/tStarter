<?php
/**
*
* Template Name: Contact
* Description: This file contains the theme included contact form.
*
* @author Juyal Ahmed<tojibon@gmail.com>
* @version: 1.0.0
* https://themeredesign.com
*/

get_header();
?>
	<div id="content-body">
	
	<?php get_template_part( 'partials/partial-content', 'banner' ); ?>
	
	<?php 
	if( have_posts() ) { 
		while( have_posts() ) {
			the_post(); 
			get_template_part( 'partials/contact', 'page' );
		}
	}
	?>
	
	<?php get_template_part( 'partials/partial', 'content' ); ?>
	
	</div>
<?php 
get_footer();