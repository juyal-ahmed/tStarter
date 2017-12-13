jQuery(document).ready(function() {

    var $ = jQuery;


    /*
    ---------------------------------------------------------------------------------------
        Loading different settings meta block for Page, Post, Portfolio when page template changed on WordPress admin
    ---------------------------------------------------------------------------------------
    */
    trtitan_admin_post_meta_changes();
    function trtitan_admin_post_meta_changes() {
        var $ = jQuery;
        var $page_template = $('#page_template');
        $page_template.change(function() {
            trtitan_post_templace_reload( $(this).val() );
        }).change();
    }
});


function trtitan_post_templace_reload( $page_template_val ) {
    var $ = jQuery;

    $('#contact-form-info').hide();
    $('#postimagediv').show();
    if ( $page_template_val == 'templates/contact.php' ) {
        $('#contact-form-info').show();
    } else if ( $page_template_val == 'templates/home.php' ) {
        $('#header-options').hide();
        $('#postimagediv').hide();
    } else {

    }
}

