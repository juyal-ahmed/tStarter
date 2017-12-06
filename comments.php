<?php
/**
 * This file contains the styling for comments display.
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeredesign.com
 */

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
    die (_('Please do not load this page directly. Thanks!', LANG_DOMAIN));
}

$post_type = get_post_type();

if (post_password_required()) {
    ?>
    <div class="article-wrapper comment-article-wrapper">
        <div class="post-wrapper-inner comment-content-wrapper">
            <div class="comment-content">
                <div class="alert alert-info"><?php _e("This post is password protected. Enter the password to view comments.", LANG_DOMAIN); ?></div>
            </div>
        </div>
    </div>
    <?php
    return;
}
?>

<?php if (have_comments()) : ?>
    <div class="article-wrapper comment-article-wrapper">
        <div class="post-wrapper-inner comment-content-wrapper comment-list-content-wrapper">
            <div class="comment-content">
                <?php
                $comments_by_type = separate_comments($comments);
                if (!empty($comments_by_type['comment'])) : ?>

                    <?php
                    if ('ticket' == $post_type) {
                        ?>
                        <h3 id="comments"><?php comments_number('<span>' . __("No", LANG_DOMAIN) . '</span> ' . __("Responses", LANG_DOMAIN) . '', '<span>' . __("One", LANG_DOMAIN) . '</span> ' . __("Response", LANG_DOMAIN) . '', '<span>%</span> ' . __("Responses", LANG_DOMAIN)); ?></h3>
                        <?php
                    } else {
                        ?>
                        <h3 id="comments"><?php comments_number('<span>' . __("No", LANG_DOMAIN) . '</span> ' . __("Responses", LANG_DOMAIN) . '', '<span>' . __("One", LANG_DOMAIN) . '</span> ' . __("Response", LANG_DOMAIN) . '', '<span>%</span> ' . __("Comments", LANG_DOMAIN)); ?></h3>
                        <?php
                    }
                    ?>

                    <?php
                    $umamah_get_previous_comments_link = umamah_get_previous_comments_link(__("Older comments", LANG_DOMAIN));
                    $umamah_get_next_comments_link = umamah_get_next_comments_link(__("Newer comments", LANG_DOMAIN));
                    if (!empty($umamah_get_previous_comments_link) || !empty($umamah_get_next_comments_link)) {
                        ?>
                        <nav class="comment-nav">
                            <ul class="clearfix">
                                <?php if (!empty($umamah_get_previous_comments_link)) { ?>
                                    <li><?php echo $umamah_get_previous_comments_link; ?></li>
                                <?php } ?>
                                <?php if (!empty($umamah_get_next_comments_link)) { ?>
                                    <li><?php echo $umamah_get_next_comments_link; ?></li>
                                <?php } ?>
                            </ul>
                        </nav>
                        <?php
                    }
                    ?>

                    <ol class="commentlist"><?php wp_list_comments(array('avatar_size' => '60', 'type' => 'comment')); ?></ol>

                <?php endif; ?>

                <?php if (!empty($comments_by_type['pings'])) : ?>

                    <h3 id="pings"><?php _e("Trackbacks/Pingbacks", LANG_DOMAIN); ?></h3>

                    <ol class="pinglist"><?php wp_list_comments('type=pings'); ?></ol>

                <?php endif; ?>

                <?php
                $umamah_get_previous_comments_link = umamah_get_previous_comments_link(__("Older comments", LANG_DOMAIN));
                $umamah_get_next_comments_link = umamah_get_next_comments_link(__("Newer comments", LANG_DOMAIN));
                if (!empty($umamah_get_previous_comments_link) || !empty($umamah_get_next_comments_link)) {
                    ?>
                    <nav class="comment-nav">
                        <ul class="clearfix">
                            <?php if (!empty($umamah_get_previous_comments_link)) { ?>
                                <li><?php echo $umamah_get_previous_comments_link; ?></li>
                            <?php } ?>
                            <?php if (!empty($umamah_get_next_comments_link)) { ?>
                                <li><?php echo $umamah_get_next_comments_link; ?></li>
                            <?php } ?>
                        </ul>
                    </nav>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php
if (comments_open()) : ?>
    <div class="article-wrapper comment-article-wrapper">
        <div class="post-wrapper-inner comment-content-wrapper">
            <div class="comment-content">
                <section id="respond" class="respond-form">

                    <h3 id="comment-form-title">
                        <?php
                        if ('ticket' == $post_type) {
                            ?>
                            <?php comment_form_title(__("Leave a Response", LANG_DOMAIN), __("Leave a Response to", LANG_DOMAIN) . ' %s'); ?>
                            <?php
                        } else {
                            ?>
                            <?php comment_form_title(__("Leave a Reply", LANG_DOMAIN), __("Leave a Reply to", LANG_DOMAIN) . ' %s'); ?>
                            <?php
                        }
                        ?>
                    </h3>


                    <div id="cancel-comment-reply">
                        <p class="small"><?php cancel_comment_reply_link(__("Cancel", LANG_DOMAIN)); ?></p>
                    </div>

                    <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
                        <div class="help">
                            <p><?php _e("You must be", LANG_DOMAIN); ?> <a
                                        href="<?php echo wp_login_url(get_permalink()); ?>"><?php _e("logged in", LANG_DOMAIN); ?></a> <?php _e("to post a comment", LANG_DOMAIN); ?>
                                .</p>
                        </div>
                    <?php else : ?>

                        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post"
                              class="form-horizontal" id="commentform" role="form">

                            <?php if (is_user_logged_in()) : ?>

                                <?php
                                if ('ticket' != $post_type) {
                                    ?>
                                    <p class="comments-logged-in-as"><?php _e("Logged in as", LANG_DOMAIN); ?> <a
                                                href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>.
                                        <a href="<?php echo wp_logout_url(get_permalink()); ?>"
                                           title="<?php _e("Log out of this account", LANG_DOMAIN); ?>"><?php _e("Log out", LANG_DOMAIN); ?>
                                            &raquo;</a></p>
                                    <?php
                                }
                                ?>

                            <?php else : ?>
                                <div id="comment-form-elements">
                                    <div class="form-group">
                                        <label for="author"
                                               class="col-sm-3 col-xs-12 control-label"><?php _e('Name:', LANG_DOMAIN) ?><?php if ($req) _e('(required)', LANG_DOMAIN); ?></label>
                                        <div class="col-sm-9 col-xs-12">
                                            <input type="text" name="author"
                                                   value="<?php echo esc_attr($comment_author); ?>" class="form-control"
                                                   id="author" placeholder="<?php _e('Your full name', LANG_DOMAIN); ?>"
                                                   tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email"
                                               class="col-sm-3 col-xs-12 control-label"><?php _e('Mail:', LANG_DOMAIN) ?><?php if ($req) _e('(required)', LANG_DOMAIN); ?></label>
                                        <div class="col-sm-9 col-xs-12">
                                            <input type="text" name="email"
                                                   value="<?php echo esc_attr($comment_author_email); ?>"
                                                   class="form-control" id="email"
                                                   placeholder="<?php _e('Your email address', LANG_DOMAIN); ?>"
                                                   tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="url"
                                               class="col-sm-3 col-xs-12 control-label"><?php _e('Website:', LANG_DOMAIN) ?> </label>
                                        <div class="col-sm-9 col-xs-12">
                                            <input type="text" name="url"
                                                   value="<?php echo esc_attr($comment_author_url); ?>"
                                                   class="form-control" id="url"
                                                   placeholder="<?php _e('Your website starting with http://', LANG_DOMAIN); ?>"
                                                   tabindex="3"/>
                                        </div>
                                    </div>


                                </div>
                            <?php endif; ?>

                            <?php
                            if ('ticket' == $post_type) {
                                ?>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                    <textarea name="comment"
                                              placeholder="<?php _e('Write you response', LANG_DOMAIN); ?>"
                                              class="form-control" rows="10" cols="30" id="comment"
                                              tabindex="1"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" name="submitted" class="btn btn-primary btn-lg"
                                                tabindex="2"><?php _e('SUBMIT', LANG_DOMAIN) ?></button>
                                    </div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="form-group">
                                    <label for="comment"
                                           class="col-sm-3 col-xs-12 control-label"><?php _e('Comment:', LANG_DOMAIN) ?></label>
                                    <div class="col-sm-9 col-xs-12">
                                    <textarea name="comment"
                                              placeholder="<?php _e('Write you message', LANG_DOMAIN); ?>"
                                              class="form-control" rows="10" cols="30" id="comment"
                                              tabindex="4"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9 col-xs-12">
                                        <button type="submit" name="submitted" class="btn btn-primary btn-lg"
                                                tabindex="5"><?php _e('SUBMIT', LANG_DOMAIN) ?></button>
                                    </div>
                                </div>

                                <div class="form-group comment-instruction">
                                    <div class="col-sm-offset-3 col-sm-9 col-xs-12">
                                        <h4><?php _e('Rules of the Blog', LANG_DOMAIN); ?></h4>
                                        <p><?php _e('Do not post violating content, tags like bold, italic and underline are allowed that means HTML can be used while commenting.', LANG_DOMAIN); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <?php comment_id_fields(); ?>

                            <?php
                            do_action('comment_form()', $post->ID);
                            ?>

                        </form>

                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
<?php else : ?>

    <?php
    if (('page' == $post_type)) {
    } else {
        ?>
        <div class="article-wrapper comment-article-wrapper">
            <div class="post-wrapper-inner comment-content-wrapper">
                <div class="comment-content">
                    <p class="alert alert-info"><?php _e("Comments are closed.", LANG_DOMAIN); ?></p>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

<?php endif; ?>