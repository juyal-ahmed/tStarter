jQuery(document).ready(function() {

    var $ = jQuery;


    /*
	---------------------------------------------------------------------------------------
		Superfish Menu Initialization
		@Since Version 1.0
	---------------------------------------------------------------------------------------
	*/
    jQuery('.sf-menu').superfish({
        //add options here if required
    });

    /*
	---------------------------------------------------------------------------------------
		Select field chosen Initialization
		@Since Version 1.0
	---------------------------------------------------------------------------------------
	*/
    jQuery('select.chosen').chosen();

    /*
    ---------------------------------------------------------------------------------------
        Initializing PrettyPhoto
    ---------------------------------------------------------------------------------------
    */
    prettyphoto_initialization();

    /*
    ---------------------------------------------------------------------------------------
        Global Notice initialization
    ---------------------------------------------------------------------------------------
    */
    umamah_global_notice_js();

});


/*
---------------------------------------------------------------------------------------
    Initializing PrettyPhoto
---------------------------------------------------------------------------------------
*/
function prettyphoto_initialization() {
    if (jQuery('#wpadminbar').length > 0) {
        jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
            hook: 'data-rel',
            animation_speed: 'normal',
            theme: 'light_square',
            markup: '<div class="pp_pic_holder_wrapper"><div class="pp_pic_holder"> \
						<div class="ppt">&nbsp;</div> \
						<div class="pp_top"> \
							<div class="pp_left"></div> \
							<div class="pp_middle"></div> \
							<div class="pp_right"></div> \
						</div> \
						<div class="pp_content_container"> \
							<div class="pp_left"> \
							<div class="pp_right"> \
								<div class="pp_content"> \
									<div class="pp_loaderIcon"></div> \
									<div class="pp_fade"> \
										<a href="#" class="pp_expand" title="Expand the image">Expand</a> \
										<div class="pp_hoverContainer"> \
											<a class="pp_next" href="#">next</a> \
											<a class="pp_previous" href="#">previous</a> \
										</div> \
										<div id="pp_full_res"></div> \
										<div class="pp_details"> \
											<div class="pp_nav"> \
												<a href="#" class="pp_arrow_previous">Previous</a> \
												<p class="currentTextHolder">0/0</p> \
												<a href="#" class="pp_arrow_next">Next</a> \
											</div> \
											<p class="pp_description"></p> \
											{pp_social} \
											<a class="pp_close" href="#">Close</a> \
										</div> \
									</div> \
								</div> \
							</div> \
							</div> \
						</div> \
						<div class="pp_bottom"> \
							<div class="pp_left"></div> \
							<div class="pp_middle"></div> \
							<div class="pp_right"></div> \
						</div> \
					</div></div> \
					<div class="pp_overlay"></div>',
            overlay_gallery: true
        });
    } else {
        jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
            hook: 'data-rel',
            animation_speed: 'normal',
            theme: 'light_square',
            overlay_gallery: true
        });
    }
}

/*
---------------------------------------------------------------------------------------
    Global Notice initialization
---------------------------------------------------------------------------------------
*/
function umamah_global_notice_js(){
    if ( jQuery( '.umamah-notice-btn').length > 0 ) {
        jQuery(document).on('click', '.umamah-notice-btn', function() {
            var $this = jQuery(this);
            $this.toggleClass('closed');
            if ( $this.hasClass('closed') ) {
                jQuery('body').removeClass('umamah-notice-bar-opened').addClass('umamah-notice-bar-closed');
                jQuery('#umamah-notice-message').slideUp('slow', function(){
                    $this.find('.fa').addClass('fa-rotate-180');
                    set_umamah_cookie( 'umamah-global-notice-open', 'no', 1 );
                });
            } else {
                jQuery('body').removeClass('umamah-notice-bar-closed').addClass('umamah-notice-bar-opened');
                jQuery('#umamah-notice-message').slideDown('slow', function(){
                    $this.find('.fa').removeClass('fa-rotate-180');
                    set_umamah_cookie( 'umamah-global-notice-open', 'yes', 1 );
                });
            }

            return false;
        });

        var global_notice_prev_state = get_umamah_cookie('umamah-global-notice-open' );
        var $this = jQuery('.umamah-notice-btn');
        if ( global_notice_prev_state == 'yes' ) {
            $this.removeClass('closed');
            jQuery('body').removeClass('umamah-notice-bar-closed').addClass('umamah-notice-bar-opened');
            jQuery('#umamah-notice-message').slideDown('slow', function(){
                $this.find('.fa').removeClass('fa-rotate-180');
            });
        } else {
            $this.addClass('closed');
            jQuery('body').removeClass('umamah-notice-bar-opened').addClass('umamah-notice-bar-closed');
            jQuery('#umamah-notice-message').slideUp('slow', function(){
                $this.find('.fa').addClass('fa-rotate-180');
            });
        }
    }
}