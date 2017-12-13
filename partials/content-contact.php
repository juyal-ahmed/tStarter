<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package youtha
 */

global $contact_error_text, $contact_has_error, $contact_email_sent, $contact_captcha_placeholder;

$_form_title = get_post_meta( get_the_ID(), TRTHEME_THEME_KEY . 'contact_form_title', TRUE );
$_summary = get_post_meta( get_the_ID(), TRTHEME_THEME_KEY . 'contact_form_summary', TRUE );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'youtha' ),
				'after'  => '</div>',
			) );
		?>

        <?php if( $contact_email_sent ) { ?>
            <p class="mt-30 mb-0 alert alert-success"><?php _e( 'Thanks, your contact request email was sent successfully.', 'umamah' ) ?></p>
        <?php } else { ?>
            <div class="entry-contact-wrapper trtitan-form-wrapper">
                <div id="contactform-wrapper">

                    <form class="form-horizontal" method="post" action="<?php the_permalink(); ?>" role="form">

                        <?php if ( !empty( $_form_title ) ) { ?>
                            <h3><?php echo $_form_title; ?></h3>
                        <?php } ?>

                        <?php if ( !empty( $_summary ) ) { ?>
                            <p><?php echo nl2br( $_summary ); ?></p>
                        <?php } ?>

                        <?php if( $contact_has_error ) {
                            if( empty( $contact_error_text ) ) {
                                $contact_error_text = __( 'Sorry, an error occured.', 'umamah' );
                            }
                            ?>
                            <p class="mt-30 alert alert-warning"><?php echo $contact_error_text; ?></p>
                        <?php } ?>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="contact_name" value="<?php if(isset($_POST['contact_name'])) echo $_POST['contact_name'];?>" class="form-control input-lg" id="contact_name" placeholder="<?php _e('Name:*', 'umamah') ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="contact_email" name="contact_email" value="<?php if(isset($_POST['contact_email'])) echo $_POST['contact_email'];?>" class="form-control input-lg" id="contact_email" placeholder="<?php _e('Email:*', 'umamah') ?>">                     </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="contact_subject" value="<?php if(isset($_POST['contact_subject'])) echo $_POST['contact_subject'];?>" class="form-control input-lg" id="contact_subject" placeholder="<?php _e('Subject:', 'umamah') ?>">        </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea name="contact_comments" id="comments-text" class="form-control input-lg" rows="5" cols="30" placeholder="<?php _e('Your Say:*', 'umamah') ?>"><?php if(isset($_POST['contact_comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['contact_comments']); } else { echo $_POST['contact_comments']; } } ?></textarea>        </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="contact_captcha" value="" class="form-control input-lg" id="contact_captcha" placeholder="<?php echo $contact_captcha_placeholder; ?>">        </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" name="contact_submitted" class="btn btn-primary btn-lg"><?php _e('SUBMIT CONTACT', 'umamah') ?></button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        <?php } ?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'youtha' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

