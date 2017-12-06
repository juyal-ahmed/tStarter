jQuery(document).ready(function() {

    var $ = jQuery;


    /*
    ---------------------------------------------------------------------------------------
        Loading different settings meta block for Page, Post, Portfolio when page template changed on WordPress admin
    ---------------------------------------------------------------------------------------
    */
    umamah_admin_post_meta_changes();
    function umamah_admin_post_meta_changes() {
        var $ = jQuery;
        var $page_template = $('#page_template');
        $page_template.change(function() {
            umamah_post_templace_reload( $(this).val() );
        }).change();
    }

    /*
    ---------------------------------------------------------------------------------------
        Orders metabox on add / edit interface adjustment on Order type select
    ---------------------------------------------------------------------------------------
    */
    var $val = $('select[name="umamah_orders_type"]').val();
    order_item_setup($val);
    $(document).on('change', 'select[name="umamah_orders_type"]', function() {
        var $val = $(this).val();
        order_item_setup($val);
    });
    function order_item_setup($val) {
        if ( $val === 'online_order' ) {
            $('select[name="umamah_orders_theme"], select[name="umamah_orders_plugin"], select[name="umamah_orders_markup"]').parent().parent().hide();
            for ( var i = 1; i <= 5; i++ ) {
                $('select[name="umamah_orders_theme_'+i+'"], input[name="umamah_orders_theme_purchased_price_'+i+'"]').parent().parent().show();
                $('select[name="umamah_orders_plugin_'+i+'"], input[name="umamah_orders_plugin_purchased_price_'+i+'"]').parent().parent().show();
                $('select[name="umamah_orders_markup_'+i+'"], input[name="umamah_orders_markup_purchased_price_'+i+'"]').parent().parent().show();
            }
            $('select[name="umamah_orders_membership"], select[name="umamah_orders_bundle"]').parent().parent().show();
        } else {
            $('select[name="umamah_orders_theme"], select[name="umamah_orders_plugin"], select[name="umamah_orders_markup"]').parent().parent().show();
            for ( var i = 1; i <= 5; i++ ) {
                $('select[name="umamah_orders_theme_'+i+'"], input[name="umamah_orders_theme_purchased_price_'+i+'"]').parent().parent().hide();
                $('select[name="umamah_orders_plugin_'+i+'"], input[name="umamah_orders_plugin_purchased_price_'+i+'"]').parent().parent().hide();
                $('select[name="umamah_orders_markup_'+i+'"], input[name="umamah_orders_markup_purchased_price_'+i+'"]').parent().parent().hide();
            }
            $('select[name="umamah_orders_membership"], select[name="umamah_orders_bundle"]').parent().parent().hide();
        }
    }
});


function umamah_post_templace_reload( $page_template_val ) {
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

