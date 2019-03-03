jQuery.noConflict();

setTimeout(function() {



    if( jQuery('body').hasClass('home') )

    {

        var currentTOP  =   jQuery('.header-container header').height();

        jQuery( '.lp-header-search-wrap' ).css('top', '-'+currentTOP+'px');

    }



    jQuery(".lp-header-search .lp-header-search-form form, .lp-header-search .lp-header-search-cats ul").show()

}, 600);

jQuery(function(){

    var sidebarHeight   =   jQuery('.sidebar-top0').height(),

        DesHeight       =   sidebarHeight-200,

        topHeader       =   jQuery('.lp-listing-top-title-header').height(),

        minHeight       =   jQuery('.min-height-class').height(),

        desHeightT      =   topHeader+minHeight,

        minHeightT      =   sidebarHeight-DesHeight;



    if( DesHeight >= sidebarHeight )

    {

        jQuery('.min-height-class').css('min-height', minHeightT);

    }

    else

    {

        minHeightT  =   sidebarHeight-topHeader+140;

        jQuery('.min-height-class').css('min-height', minHeightT);

    }


});
jQuery(document).ready(function (e) {

    jQuery('.manage-group-types').click(function (e) {
        e.preventDefault();
        window.location.replace(jQuery(this).data('url')) ;
    });

    jQuery('.show-number-wrap').click(function(e){
        jQuery(this).find('.show-number').css('display', 'none');
        jQuery(this).find('.grind-number').css('display', 'inline-block');
    });

    jQuery('.show-more-event-content').click(function (e) {

        var showMore    =   jQuery(this).data('more'),

            showLess    =   jQuery(this).data('less');
        if( jQuery(this).hasClass('expanded') )
        {
            jQuery('.lp-evnt-content-container p').css('height', '31px');
            jQuery(this).text(showMore);
            jQuery(this).removeClass('expanded');
        }
        else
        {
            jQuery('.lp-evnt-content-container p').height('auto');
            jQuery(this).addClass('expanded');
            jQuery(this).text(showLess);
        }
    });

    jQuery( ".header-cat-menu" ).hover(
        function() {
            jQuery( this ).find('#menu-category').addClass( "show-cat-nav" );
        }, function() {
            jQuery( this ).find('#menu-category').removeClass( "show-cat-nav" );
        }
    );
    
if( jQuery('#lp-submit-form').length != 0 )
    {
        var lp_custom_title =   '';
        if( jQuery('#lp_custom_title').length != 0 ){
            lp_custom_title     =   jQuery('#lp_custom_title').offset().top;
        }
        var inputAddress =   '';
        if( jQuery('#inputAddress').length != 0 ){
            inputAddress     =   jQuery('#inputAddress').offset().top;
        }
        var inputCity =   '';
        if( jQuery('.lp-new-cat-wrape label[for="inputTags"]').length != 0 ){
            inputCity     =   jQuery('.lp-new-cat-wrape label[for="inputTags"]').offset().top;
        }
        var inputPhone =   '';
        if( jQuery('#inputPhone').length != 0 ){
            inputPhone     =   jQuery('label[for="inputPhone"]').offset().top;
        }
        var inputWebsite =   '';
        if( jQuery('#inputWebsite').length != 0 ){
            inputWebsite     =   jQuery('#inputWebsite').offset().top;
        }
        var inputCategory =   '';
        if( jQuery('label[for="inputCategory"]').length != 0 ){
            inputCategory     =   jQuery('label[for="inputCategory"]').offset().top;
        }
        var price_status =   '';
        if( jQuery('label[for="price_status"]').length != 0 ){
            price_status     =   jQuery('label[for="price_status"]').offset().top;
        }
        var bussinTop   =   '';
        if( jQuery('.bussin-top').length != 0 ){
            bussinTop     =   jQuery('.bussin-top').offset().top;
        }
        var get_media_url =   '';
        if( jQuery('#get_media_url').length != 0 ){
            get_media_url     =   jQuery('#get_media_url').offset().top;
        }
        var inpuFaqsLp =   '';
        if( jQuery('label[for="inpuFaqsLp"]').length != 0 ){
            inpuFaqsLp     =   jQuery('label[for="inpuFaqsLp"]').offset().top;
        }
        var descTop     =   '';
        if( jQuery('.description-tip').length != 0 ){
            descTop     =   jQuery('.description-tip').offset().top;
        }
        var postVideo =   '';
        if( jQuery('#postVideo').length != 0 ){
            postVideo     =   jQuery('#postVideo').offset().top;
        }
        var gallTop     =   '';
        if( jQuery('.lp-img-gall-upload-section').length != 0 ){
            var gallTop     =   jQuery('.lp-img-gall-upload-section').offset().top;
        }
        var bLogoTop    = '';
        if( jQuery('.b-logo-img-label').length != 0 ){
            var bLogoTop    =   jQuery('.b-logo-img-label').offset().top;
        }
        var featTop     =   '';
        if( jQuery('.featured-img-label').length != 0 ){
            featTop     =   jQuery('.featured-img-label').offset().top;
        }

        jQuery(window).scroll(function (e) {
            var scrollPos   =   jQuery(window).scrollTop()+400;

            if( scrollPos > lp_custom_title )
            {
                jQuery('.quick-tip-inner').html(jQuery('#lptitle').data('quick-tip'));
            }
            if( scrollPos > inputAddress )
            {
                jQuery('.quick-tip-inner').html(jQuery('#inputAddress').data('quick-tip'));
            }
            if( scrollPos > inputCity )
            {
                jQuery('.quick-tip-inner').html(jQuery('#inputCity').data('quick-tip'));
            }
            if( scrollPos > inputPhone )
            {
                jQuery('.quick-tip-inner').html(jQuery('#inputPhone').data('quick-tip'));
            }
            if( scrollPos > inputWebsite )
            {
                jQuery('.quick-tip-inner').html(jQuery('#inputWebsite').data('quick-tip'));
            }
            if( scrollPos > inputCategory )
            {
                jQuery('.quick-tip-inner').html(jQuery('#inputCategory').data('quick-tip'));
            }
            if( scrollPos > price_status )
            {
                jQuery('.quick-tip-inner').html(jQuery('#price_status').data('quick-tip'));
            }
            if( scrollPos > bussinTop )
            {
                jQuery('.quick-tip-inner').html(jQuery('.bussin-top').data('quick-tip'));
            }
            if( scrollPos > get_media_url )
            {
                jQuery('.quick-tip-inner').html(jQuery('#get_media').data('quick-tip'));
            }
            if( scrollPos > inpuFaqsLp )
            {
                jQuery('.quick-tip-inner').html(jQuery('#inpuFaqsLp').data('quick-tip'));
            }
            if( scrollPos > descTop )
            {
                jQuery('.quick-tip-inner').html(jQuery('.description-tip').data('quick-tip'));
            }
            if( scrollPos > postVideo )
            {
                jQuery('.quick-tip-inner').html(jQuery('#postVideo').data('quick-tip'));
            }
            if( scrollPos > gallTop )
            {
                jQuery('.quick-tip-inner').html(jQuery('.lp-img-gall-upload-section').data('quick-tip'));
            }
            if( scrollPos > bLogoTop )
            {
                jQuery('.quick-tip-inner').html(jQuery('.b-logo-img-label').data('quick-tip'));
            }
            if( scrollPos > featTop )
            {
                jQuery('.quick-tip-inner').html(jQuery('.featured-img-label').data('quick-tip'));
            }

        });



        jQuery('#lp-submit-form input, #lp-submit-form textarea').on('focus', function (e) {

            var quickTip    =   jQuery(this).data('quick-tip');

            jQuery('.quick-tip-inner').html(quickTip);

        });



        jQuery('select.select2').on('select2:open', function (e) {

            var quickTip =  jQuery(this).data('quick-tip');

            jQuery('.quick-tip-inner').html(quickTip);

        });

    }

    if( jQuery('.page-style2-sidebar').length!= 0 )

    {

        var scrollState =   '';

        var offset = jQuery('.page-style2-sidebar').offset().top-50;

        jQuery(window).scroll(function (event) {

            var scroll = jQuery(window).scrollTop();

            if( offset >= scroll )

            {

                jQuery('.page-style2-sidebar').css({

                    'position':'static',

                    'width': 'auto'

                });

                jQuery('.page-style2-sidebar').removeClass('style2-sidebar-fixed');

                scrollState =   'scrolled';

            }

            else

            {

                var topMAr  =   10;

                if( jQuery('.page-style2-sidebar').hasClass('logged-in') )

                {

                    topMAr  =   50;

                }

                if( scrollState == 'scrolled' )

                {

                    // jQuery('.page-style2-sidebar').css({

                    //     'position':'fixed',

                    //     'top' : topMAr+'px',

                    //     'width': '338px'

                    // });

                    // jQuery('.page-style2-sidebar').css({
                    //
                    //     'position':'fixed',
                    //
                    //     'top' : 0,
                    //
                    //     'width': '338px'
                    //
                    // }).animate({
                    //
                    //     top: -150
                    //
                    // }, 250, function () {
                    //
                    //     jQuery('.page-style2-sidebar').animate({
                    //
                    //         top: 200
                    //
                    //     }, 250, function () {
                    //
                    //         jQuery('.page-style2-sidebar').animate({
                    //
                    //             top: -100
                    //
                    //         }, 300, function () {
                    //
                    //             jQuery('.page-style2-sidebar').animate({
                    //
                    //                 top: 100
                    //
                    //             }, 300, function () {
                    //
                    //                 jQuery('.page-style2-sidebar').animate({
                    //
                    //                     top: -50
                    //
                    //                 }, 350, function () {
                    //
                    //                     jQuery('.page-style2-sidebar').animate({
                    //
                    //                         top: topMAr
                    //
                    //                     }, 400)
                    //
                    //                 })
                    //
                    //             })
                    //
                    //         });
                    //
                    //     })
                    //
                    // })

                    jQuery('.page-style2-sidebar').addClass('style2-sidebar-fixed testClass');

                    scrollState =   '';

                }







            }

        });

    }

    var dateToday = new Date();

    jQuery('.discount-date').datepicker({

        minDate: dateToday,

    });

    jQuery('.mobile-toggle-filters').click(function (e) {

        e.preventDefault();

        jQuery('.filters-wrap-for-mobile').slideToggle(500);

    });



    jQuery('#lp-review-listing').on('select2:select', function (e) {

        var reviewStyle =   jQuery('#reviews-nav-li').data('style'),
            listID      =   jQuery('#lp-review-listing option:selected').val(),
            authorID    =   jQuery('.lp-author-nav').data('author');

        jQuery('#reviews').find('.author-inner-content-wrap').addClass('content-loading');
        jQuery.ajax({
            type: 'POST',
            url: ajax_search_term_object.ajaxurl,
            data: {
                'action': 'author_review_tab_cb',
                'reviewStyle': reviewStyle,
                'listID' : listID,
                'authorID': authorID
            },

            success: function(data)
            {
                jQuery('#reviews').find('.author-inner-content-wrap').removeClass('content-loading');
                jQuery('#reviews').find('.author-inner-content-wrap').html(data);

                //$this.addClass('data-available');

            }

        });

    })

    jQuery('.lp-author-nav li a').click(function (e) {

        e.preventDefault();

        var $this   =   jQuery(this),
            targetID    =   $this.attr('href'),
            authorID    =   jQuery('.lp-author-nav').data('author'),
            tabType     =   '',
            reviewStyle =   '',
            listingLayout   =   '';


        if( targetID == '#reviews' )
        {
            tabType =   'reviews';
            var reviewStyle =   $this.data('style');
        }
        else if( targetID == '#photos' )
        {
            tabType =   'photos';
        }
        else if( targetID == '#aboutme' )
        {
            tabType =   'aboutme';
        }
        else if( targetID == '#contact' )
        {
            tabType =   'contact';
        }
        else if ( targetID == '#mylistings' )
        {
            tabType =   'mylistings';
            listingLayout   =   $this.data('listing-layout');
        }

        jQuery('.lp-author-nav li a.active').removeClass('active');
        $this.addClass('active');

        jQuery('.author-tab-content .active').removeClass('active').hide();
        jQuery(targetID).addClass('active').show();

        if( $this.hasClass( 'data-available' ) )
        {
            return false;
        }
        else
        {


            jQuery(targetID).find('.author-inner-content-wrap').addClass('content-loading');

            jQuery.ajax({
                type: 'POST',
                url: ajax_search_term_object.ajaxurl,
                data: {
                    'action': 'author_archive_tabs_cb',
                    'tabType': tabType,
                    'reviewStyle': reviewStyle,
                    'authorID': authorID,
                    'listingLayout' : listingLayout
                },
                success: function(data)
                {
                    jQuery(targetID).find('.author-inner-content-wrap').removeClass('content-loading');
                    jQuery(targetID).find('.author-inner-content-wrap').html(data);
                    $this.addClass('data-available');
                }
            });
        }
    });



    jQuery('.author-inner-content-wrap .lp-pagination span').click(function (e) {

        var $this   =   jQuery(this);
        var pageNum =   jQuery(this).data('pageurl');

        jQuery('span.current').removeClass('current');
        jQuery('#content-grids').html('').addClass('content-loading');



        jQuery.ajax({
            type: 'POST',
            url: ajax_search_term_object.ajaxurl,
            data: {
                'action': 'author_archive_listings_cb',
                'pageNum': pageNum,

            },
            success: function(data)
            {
                $this.addClass('current');
                jQuery('#content-grids').removeClass('content-loading').html(data);
            }
        });



    });

    jQuery('.lp-header-nav-btn button').click(function (e) {

        if( jQuery('.lp-header-nav-btn').hasClass('active-can-menu') )

        {

            jQuery('.lp-header-nav-btn').removeClass('active-can-menu');

            jQuery('#menu-categories-menu').css('opacity', '0');

            jQuery('#menu-categories-menu').css('transform', 'scale(0)');

        }

        else

        {

            jQuery('#menu-categories-menu').css('opacity', '1');

            jQuery('#menu-categories-menu').css('transform', 'scale(1)');

            jQuery('.lp-header-nav-btn').addClass('active-can-menu');

        }

    });





    jQuery( '.browse-imgs' ).click(function (e) {

        e.preventDefault();
        jQuery('#filer_input2').trigger('click');

    });



    jQuery('.search-filter-response .loop-switch-class').last().find('.lp-listing').addClass('last');

    jQuery('.lp-author-listings-wrap .loop-switch-class').last().find('.lp-listing').addClass('last');

    jQuery('.lp-listing-announcement .announcement-wrap').last().addClass('last');



    jQuery('.lp-listing-stars, .lp-review-images .browse-imgs, .lp-review-stars').click(function(e){
        if( jQuery('.lp-review-form-bottom').hasClass('review-form-opened') )
       {  }
       else
       {
           jQuery('.lp-review-form-bottom').slideDown(500);
           jQuery('.lp-review-form-bottom').addClass('review-form-opened');
       }   
                                                                                 
    });

    // jQuery('.lp-listing-stars').click(function(e){

    //     jQuery('.lp-review-form-bottom').slideToggle(500);

    // })

    var topWidgetWrap       =   jQuery('.lp-widget-inner-wrap').first();

    var lastWidgetWrap      =   jQuery('.lp-widget-inner-wrap').last();



    if( topWidgetWrap.hasClass('lp-listing-timings') )

    {

        topWidgetWrap.find('.lp-today-timing').addClass('top-border-radius');

    }

    else

    {

        topWidgetWrap.addClass('top-border-radius');

    }

    if( lastWidgetWrap.hasClass('lp-listing-timings') )

    {

        lastWidgetWrap.find('.lp-today-timing').addClass('bottom-border-radius');

    }

    else if( lastWidgetWrap.hasClass('singlemap') )

    {

        jQuery('.lp-widget-social-links').addClass('bottom-border-radius');

    }

    else

    {

        lastWidgetWrap.addClass('bottom-border-radius');

    }

    // if( jQuery('.dis-code-copy-pop').length != 0 )
    //
    // {
    //     jQuery('.dis-code-copy-pop').each(function (e) {
    //
    //         var minusBottom =   0;
    //         if( jQuery(this).hasClass('extra-bottom') )
    //         {
    //             minusBottom =   49;
    //         }
    //         var $this       =   jQuery(this),
    //             popHeight   =   $this.height()-minusBottom;
    //
    //
    //         $this.css('bottom', '-'+popHeight+'px');
    //
    //         $this.attr('bottom', popHeight);
    //     });
    //
    // }

    

    jQuery('.lp-dis-code-copy span').click(function (e)

    {

        var targetCodeEL    =   jQuery(this).data('target-code'),

            targetCodeELC   =   '.'+targetCodeEL;



        var copyCode    =   jQuery( targetCodeELC).find('strong.copycode').text();



        jQuery( targetCodeELC).find('input.codtopcopy').val(copyCode).select();

        document.execCommand("copy");

        jQuery(this).html('<i class="fa fa-files-o" aria-hidden="true"></i> copied').delay(1000).show(500, function(e)

        {

            jQuery(targetCodeELC).fadeOut();

            jQuery('.code-overlay').fadeOut();

        });



    });



    jQuery('.close-copy-code').click(function (e)

    {

        e.preventDefault();

        var targetCodeEL    =   jQuery(this).data('target-code'),

            targetCodeELC   =   '.'+targetCodeEL;



        jQuery(targetCodeELC).fadeOut();

        jQuery('.code-overlay').fadeOut();

    });



    jQuery('.more-filters').click(function(e)

    {

        jQuery('.lp-header-search-filters .lp-features-filter').toggleClass( 'add-border' );

        jQuery('.more-filters-container').slideToggle();

    })



    function toggleIcon(e)

    {



        jQuery(e.target)

            .prev('.faq-heading')

            .find(".more-less")

            .toggleClass('glyphicon-plus glyphicon-minus');





    }

    // jQuery('.faq-heading a').on('click',function(e){

    //     jQuery( '.collapse.in.faq-answer' ).collapse('hide');

    // });

    slickINIT();

    if( jQuery('.listing-slider').length != 0 )

    {

        jQuery('.listing-slider').slick({

            infinite: true,

            slidesToShow: 3,

            slidesToScroll: 1,

            prevArrow:"<i class=\"fa fa-angle-right arrow-left\" aria-hidden=\"true\"></i>",

            nextArrow:"<i class=\"fa fa-angle-left arrow-right\" aria-hidden=\"true\"></i>",

            responsive: [

                {

                    breakpoint: 768,

                    settings: {

                        slidesToShow: 1,

                        slidesToScroll: 1,

                        infinite: true

                    }

                }

            ]

        });

        jQuery('.lp-listings .listing-slider').show();

    }



    // slickINIT();

    // jQuery('.single-tabber2 ul li a').click(function (e) {
    //
    //     var menuCheck   =   jQuery(this).attr('href');
    //     if( menuCheck == '#menu_tab' )
    //     {
    //         slickINIT();
    //     }
    //
    // });



    if( jQuery('.lp-child-cats-tax-slider').length != 0 )

    {

        var chilCatsLoc =   jQuery( '.lp-child-cats-tax-slider' ).data('child-loc'),

            childCatNum =   3;

        if( chilCatsLoc == 'fullwidth' )

        {

            childCatNum =   5;

        }

        if( jQuery('.lp-child-cats-tax-wrap').length > childCatNum )

        {

            jQuery('.lp-child-cats-tax-slider').slick({

                infinite: true,

                slidesToShow: childCatNum,

                slidesToScroll: 1,

                prevArrow:"<i class=\"fa fa-angle-right arrow-left\" aria-hidden=\"true\"></i>",

                nextArrow:"<i class=\"fa fa-angle-left arrow-right\" aria-hidden=\"true\"></i>"

            });

        }

    }









    if( jQuery('.lp-locations-slider') .length != 0 && jQuery('.lp-locations-slider .lp-location-box').length > 6 )

    {



        jQuery('.lp-locations-slider').slick({

            infinite: true,

            slidesToShow: 6,

            slidesToScroll: 1,

            nextArrow:"<i class=\"fa fa-angle-right arrow-left\" aria-hidden=\"true\"></i>",

            prevArrow:"<i class=\"fa fa-angle-left arrow-right\" aria-hidden=\"true\"></i>",
			responsive: [

                   {
                       breakpoint: 480,
                       settings: {
                           arrows: true,
                           centerMode: false,
                           centerPadding: '0px',
                           slidesToShow: 2
                       }
                   }
               ]

        });

    }



    jQuery('.sort-by-filter').hover(function (e)

    {

        e.preventDefault();



        if( jQuery( this ).hasClass('active-tooltip-filter') )

        {

            return false;

        }

        jQuery('.active-tooltip-filter').find('.sort-filter-inner').fadeOut(200);

        jQuery('.active-tooltip-filter').removeClass('active-tooltip-filter');

        jQuery(this).addClass('active-tooltip-filter');

        jQuery(this).find('.sort-filter-inner').fadeIn(200);

    })

    jQuery('body').click(function(e){



        if(e.target.id == "header-rated-filter" || e.target.id == "header-reviewed-filter" || e.target.id == "header-viewed-filter" )

            return;

        if(jQuery('.sort-filter-inner').is(":visible"))

        {

            jQuery('.sort-filter-inner').fadeOut(200);

        }

        jQuery('.active-tooltip-filter').removeClass('active-tooltip-filter');

    });

    // jQuery('.listing-toggle-btn').click(function(e)

    // {

    //     e.preventDefault();

    //     if( !jQuery(this).hasClass('active') )

    //     {

    //         var targetView  =   jQuery(this).data('view');

    //         jQuery('.listing-toggle-btn').removeClass('active');

    //         jQuery(this).addClass('active');

    //

    //

    //         if( targetView == 'grid-style' )

    //         {

    //             jQuery('.loop-switch-class').removeClass('col-md-12');

    //             jQuery('.loop-switch-class').addClass('col-md-6');

    //             jQuery('.lp-listings.active-view').removeClass('list-style');

    //             jQuery('.lp-listings.active-view').addClass('grid-style');

    //         }

    //         if( targetView == 'list-style' )

    //         {

    //             jQuery('.loop-switch-class').removeClass('col-md-6');

    //             jQuery('.loop-switch-class').addClass('col-md-12');

    //             jQuery('.lp-listings.active-view').addClass('list-style');

    //             jQuery('.lp-listings.active-view').removeClass('grid-style');

    //

    //         }

    //

    //     }

    //

    // });

    jQuery('.listing-view-layout ul li a').click(function (e) {

       e.preventDefault();

       var $this   =   jQuery(this),

           targetView  =   '';

       if($this.hasClass('list'))

       {

           targetView  =   'list-style';

       }

       if($this.hasClass('grid'))

       {

           targetView  =   'grid-style';

       }

       if( targetView == 'grid-style' )

       {

           jQuery('.loop-switch-class').removeClass('col-md-12');

           jQuery('.loop-switch-class').addClass('col-md-6');
           jQuery('.loop-switch-class.listing-style-1').removeClass('col-md-6');
           jQuery('.loop-switch-class.listing-style-1').addClass('col-md-4');

           jQuery('.lp-listings.active-view').removeClass('list-style');

           jQuery('.lp-listings.active-view').addClass('grid-style');

       }

       if( targetView == 'list-style' )

       {
            
           jQuery('.loop-switch-class').removeClass('col-md-6');
             jQuery('.loop-switch-class.listing-style-1').removeClass('col-md-4');

           jQuery('.loop-switch-class').addClass('col-md-12');

           jQuery('.lp-listings.active-view').addClass('list-style');

           jQuery('.lp-listings.active-view').removeClass('grid-style');



       }



   });



    if( jQuery('.lp-listing-slider').length != 0 )

    {

        var totalSlides     =   jQuery('.lp-listing-slider').attr('data-totalSlides'),

            slidesToShow    =   3;

        if( totalSlides == 1 )

        {

            slidesToShow    =   1;

        }

        if( totalSlides ==  2 )

        {

            slidesToShow    =   2;

        }

        jQuery('.lp-listing-slider').slick({

            infinite: true,

            slidesToShow: slidesToShow,

            slidesToScroll: 1,

            prevArrow: "<i class=\"fa fa-angle-right arrow-left\" aria-hidden=\"true\"></i>",

            nextArrow: "<i class=\"fa fa-angle-left arrow-right\" aria-hidden=\"true\"></i>",
			responsive: [
                   {
                       breakpoint: 480,
                       settings: {
                           arrows: true,
                           centerMode: false,
                           centerPadding: '0px',
                           slidesToShow: 2
                       }
                   }
               ]

        });



        jQuery('.lp-listing-slider').show();

    }

    if( jQuery('.listing-review-slider').length != 0 )

    {
        var totalSlieds =   jQuery( '.listing-review-slider' ).attr('data-review-thumbs');
        jQuery('.listing-review-slider').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            prevArrow: "<i class=\"fa fa-angle-right arrow-left\" aria-hidden=\"true\"></i>",
            nextArrow: "<i class=\"fa fa-angle-left arrow-right\" aria-hidden=\"true\"></i>"

        });
    }


    jQuery( '.btn-link-field-toggle' ).click( function (e)

    {

        var dataTargetLink  =   jQuery(this).data('target-link');



        jQuery( '.btn-link-target' ).slideToggle(300);

        jQuery( this ).toggleClass( 'link-active' );



        var targetSwitch    =   'input#'+dataTargetLink;

        jQuery(targetSwitch).val('');

    });



    jQuery('.review-form-toggle, .lp-listing-review-form h2').click(function(e)

    {

        e.preventDefault();

        jQuery('.lp-listing-review-form .lp-form-opener').hide();



        jQuery('.lp-review-form-bottom').slideToggle(500);

        jQuery('html,body').animate(

            {

                scrollTop: jQuery(".lp-listing-review-form").offset().top -100

            },

            'slow');

    });

    jQuery('.lp-see-menu-btn').click(function (e) {

        e.preventDefault();

        jQuery('html,body').animate(

            {

                scrollTop: jQuery(".lp-listing-menuu-wrap").offset().top - 120

            },

            'slow');

    })



    jQuery('.toggle-all-days').click(function(e)
    {
        e.preventDefault();
        var leftColHeight   =   jQuery('.min-height-class').height(),
            timingsIH       =   jQuery('.lp-listing-timings').height();

        jQuery('.lp-today-timing.all-days-timings').slideToggle(200).toggleClass('days-opened');
        var lessText = jQuery(this).data('contract');
        var moreText    =   jQuery(this).data('expand');
        setTimeout(function(){
            var isOpened    =   jQuery('.lp-today-timing.all-days-timings').is('.days-opened');

            if( isOpened === true ) {
                var timingsOH           =   jQuery('.lp-listing-timings').height(),
                    leftColHeightN      =   leftColHeight+timingsOH;
                jQuery('.min-height-class').css('min-height', leftColHeightN+'px');
                jQuery('.toggle-all-days').html('<i class="fa fa-minus" aria-hidden="true"></i> ' + lessText);
            }
            else
            {
                var leftColHeightN      =   leftColHeight-timingsIH;
                jQuery('.min-height-class').css('min-height', leftColHeightN+'px');
                jQuery('.toggle-all-days').html('<i class="fa fa-plus" aria-hidden="true"></i> '+moreText);
            }
        }, 150);

    });


    jQuery('.toggle-additional-details').click(function(e)
    {
        e.preventDefault();
        jQuery('.additional-detail-hidden').slideToggle(200).toggleClass('details-opened');

        var lessText    =   jQuery(this).data('contract');
        var moreText    =   jQuery(this).data('expand');

        var leftColHeight       =   jQuery('.min-height-class').height(),
            additoinalIH        =   jQuery('.lp-listing-additional-details').height();

        setTimeout(function(){
            var isOpened    =   jQuery('.additional-detail-hidden').is('.details-opened');
            if( isOpened === true )
            {
                var additoinalOH    =   jQuery('.lp-listing-additional-details').height(),
                    leftColHeightN  =   (leftColHeight+additoinalOH)-360;

                jQuery('.min-height-class').css('min-height', leftColHeightN+'px');
                jQuery('.toggle-additional-details').html('<i class="fa fa-minus" aria-hidden="true"></i> '+lessText);
            }
            else
            {
                var leftColHeightN      =   (leftColHeight-additoinalIH)+360;
                jQuery('.min-height-class').css('min-height', leftColHeightN+'px');

                jQuery('.toggle-additional-details').html('<i class="fa fa-plus" aria-hidden="true"></i> '+moreText);
            }
        }, 150);

    });



    jQuery('.lp-listing-faqs').on('hidden.bs.collapse', toggleIcon);

    jQuery('.lp-listing-faqs').on('shown.bs.collapse', toggleIcon);



    jQuery(document).on('click', '.add-to-fav-v2',function(e)

    {

        e.preventDefault()

        $this = jQuery(this);

        $this.find('i').addClass('fa-spin fa-spinner');

        var val = jQuery(this).data('post-id');

        var type = jQuery(this).data('post-type');



        jQuery.ajax({

            type: 'POST',

            dataType: 'json',

            url: ajax_search_term_object.ajaxurl,

            data: {

                'action': 'listingpro_add_favorite_v2',

                'post-id': val,

                'type': type,

            },

            success: function(data)

            {

                if(data){

                    if(data.active == 'yes'){

                        $this.find('i').removeClass('fa-spin fa-spinner');

                        if(data.type == 'grid' || data.type == 'list')

                        {

                            $this.find('i').removeClass('fa-heart-o');

                            $this.find('i').addClass('fa-heart');

                        }

                        else

                        {

                            var successText =$this.data('success-text');

                            $this.find('span').text(successText);

                            $this.html('<i class="fa fa-bookmark" aria-hidden="true"></i> '+data.text);

                        }

                        $this.removeClass('add-to-fav-v2');

                        $this.addClass('remove-fav-v2');

                    }

                }

            }

        });

    });



    jQuery(document).on('click', '.remove-fav-v2', function(e)

    {

        e.preventDefault();

        var val = jQuery(this).data('post-id');

        var type = jQuery(this).data('post-type');

        jQuery(this).find('i').removeClass('fa-close');

        jQuery(this).find('i').addClass('fa-spinner fa-spin');



        $this = jQuery(this);

        jQuery.ajax({

            type: 'POST',

            dataType: 'json',

            url: ajax_search_term_object.ajaxurl,

            data: {

                'action': 'listingpro_remove_favorite_v2',

                'post-id': val,

                'type' : type

            },

            success: function(data)

            {

                if(data){

                    if(data.remove == 'yes')

                    {
                        $this.find('i').removeClass('fa-spin fa-spinner');

                        if(data.type == 'grid' || data.type == 'list')

                        {
                            $this.find('i').addClass('fa-heart-o');
                        }

                        else

                        {
                            $this.html('<i class="fa fa-bookmark-o" aria-hidden="true"></i> '+data.text);
                        }
						 if( jQuery('.page-template-template-favourites').length != 0 )
						{
						$this.closest( ".lp-grid-box-contianer" ).fadeOut();
						}
                        $this.removeClass('remove-fav-v2');

                        $this.addClass('add-to-fav-v2');

                    }

                }

            }

        });



    });



    /* Social Share */

    var social = jQuery('.lp-listing-action-btns ul li div.social-icons.post-socials');

    var socialOvrly = jQuery('.lp-listing-action-btns ul li .md-overlay');



    jQuery('.lp-single-sharing').on('click', function(event)

    {

        event.preventDefault();

        social.fadeIn(400);



        if(socialOvrly.hasClass('hide')){

            jQuery(socialOvrly).removeClass('hide');

            jQuery(socialOvrly).addClass('show');

        }

        else{

            jQuery(socialOvrly).removeClass('show');

            jQuery(socialOvrly).addClass('hide');



        }

    });



    socialOvrly.on('click', function(event)

    {



        event.preventDefault();

        social.hide();



        if(socialOvrly.hasClass('show')){

            jQuery(socialOvrly).removeClass('show');

            jQuery(socialOvrly).addClass('hide');

        }

        else{

            jQuery(socialOvrly).removeClass('hide');

            jQuery(socialOvrly).addClass('show');

        }

    });



    jQuery(document).on('click' , '.lp-review-right-bottom .review-reaction, .lp-activity-description .review-reaction',function(e)

    {
        e.preventDefault();
        if(jQuery(this).hasClass('active-now')) { return false; }
        reviewID = '';

        ajaxResErr = '';

        var $this = jQuery(this);

        $this.addClass('active-now');

        reviewID = $this.data('id'),

            currentVal = $this.data('score'),

            restype = $this.data('restype');



        $this.find('span.react-count').html('<i class="fa fa-spinner fa-spin"></i>');

        jQuery.ajax({

            type: 'POST',

            dataType: 'json',

            url: ajax_review_object.ajaxurl,

            data:{

                action:'lp_reviews_interests',

                interest : currentVal,

                restype : restype,

                id : reviewID,

            },



            success: function(res){



                if(res.errors=="no"){

                    ajaxResErr = 'no';

                    var newscore = res.newScore;

                    $this.data('score', newscore);

                    $this.find('span.react-count').html(newscore);

                    $this.find('span.react-msg').text(res.statuss).fadeIn(500).delay(2000).fadeOut(500);



                    if(restype=='interesting'){

                        $this.css({'background-color': '#417cdf',

                            'color': '#fff'});

                        $this.find('span.react-count').css({'color': '#fff'});

                    }

                    else if(restype=='lol'){

                        $this.css({'background-color': '#ff8e29',

                            'color': '#fff'});

                        $this.find('span.react-count').css({'color': '#fff'});

                    }

                    else if(restype=='love'){

                        $this.css({'background-color': '#ff2357',

                            'color': '#fff'});

                        $this.find('span.react-count').css({'color': '#fff'});

                    }

                    currentVal = false;

                } else{

                    ajaxResErr = 'yes';

                    var newscore = res.newScore;

                    $this.find('span.react-count').text(newscore);

                    $this.find('span.react-msg').text(res.statuss).fadeIn(500).delay(2000).fadeOut(500);

                }

                $this.removeClass('active-now');

            },

            error: function(request, error){

                alert(error);

            }

        });



        e.preventDefault();

    });


    jQuery(document).on('click', '#lp-save-menu', function (e) {

        e.preventDefault();
        var $this   =   jQuery(this),
            userID  =   $this.data('uid'),
            mTitle  =   jQuery('#menu-title').val(),
            mDetail  =   jQuery('#menu-detail').val(),
            mOldPrice  =   jQuery('#menu-old-price').val(),
            mNewPrice  =   jQuery('#menu-new-price').val(),
            mQuoteT  =   jQuery('#menu-quote-text').val(),
            mQuoteL  =   jQuery('#menu-quote-link').val(),
            mListing  =   jQuery('#menu-listing').val(),
            mLink  =   jQuery('#menu-link').val(),
            mImage  =   jQuery('.new-file-upload .frontend-input').val(),
            mType  =   jQuery('#menu-type').val(),
            mGroup  =   jQuery('#menu-group').val();

        if( mImage == '' && jQuery('.new-file-upload .frontend-input-multiple').length != 0 )
        {
            mImage  =   jQuery('.new-file-upload .frontend-input-multiple').val();
        }
        if( mListing == '' || mListing == null || mListing == 0 )
        {
            jQuery('#select2-menu-listing-container').addClass('error');
        }
        else
        {
            jQuery('#select2-menu-listing-container').removeClass('error');
        }

        if( mTitle == '' )
        {
            jQuery('#menu-title').addClass('error');
        }
        else
        {
            jQuery('#menu-title').removeClass('error');
        }

        if( mType == '' || mType == 0 || mType == null )
        {
            jQuery('#select2-menu-type-container').addClass('error');
        }
        else
        {
            jQuery('#select2-menu-type-container').removeClass('error');
        }
        if( mGroup == '' || mGroup == 0 || mGroup == null )
        {
            jQuery('#select2-menu-group-container').addClass('error');
        }
        else
        {
            jQuery('#select2-menu-group-container').removeClass('error');
        }

        if( mTitle == '' || ( mType == '' && mType == 0 ) || ( mGroup == '' && mGroup == 0 ) || mListing == '' || mListing == null || mListing == 0  )
        {
            var dataError   =   [];
            dataError.status    =   'error';
            dataError.msg    =   jQuery('.lp-notifaction-area').data('error-msg');
            ajax_success_popup( dataError, $this );
            return false;
        }

        $this.append('<i class="fa fa-spin fa-spinner"></i>');
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_search_term_object.ajaxurl,
            data:{
                'action': 'add_menu_cb',
                'user_id' : userID,
                'mTitle' : mTitle,
                'mDetail' : mDetail,
                'mOldPrice' : mOldPrice,
                'mNewPrice' : mNewPrice,
                'mQuoteT' : mQuoteT,
                'mQuoteL' : mQuoteL,
                'mListing' : mListing,
                'mLink' : mLink,
                'mImage' : mImage,
                'mType' : mType,
                'mGroup' : mGroup,
            },
            success: function( res )
            {
                ajax_success_popup( res, $this );
            },
            error: function( err )
            {
                alert( err );
                $this.find('i').remove();
            }
        });
    });

    jQuery('.add-new-open-form').click(function (e) {
        e.preventDefault();
        var targetForm  =   '#'+jQuery(this).data('form')+'-form-toggle';

        jQuery(targetForm).slideToggle( 'fast', function () {
            jQuery('html, body').animate({
                scrollTop: jQuery(targetForm).offset().top
            }, 1000, function () {
                jQuery('.lp-blank-section').fadeOut();
            });
        } );

    });
    var targetPlanMetaKey   =   'menu';
    if( jQuery('.select2-ajax').length != 0 )
    {
        targetPlanMetaKey   =   jQuery('.select2-ajax').data('metakey');

        var noResultsText   =   jQuery('#select2-ajax-noresutls').val(),
            inputShortText  =   jQuery('#select2-ajax-tooshort').val(),
            searchingText   =   jQuery('#select2-ajax-searching').val();
    }

    jQuery('.select2-ajax').select2({
        ajax: {
            url: ajax_search_term_object.ajaxurl,
            dataType: 'json',
            type:'GET',
            data: function (params) {
                return {
                    q: params.term, // search query
                    targetPlanMetaKey: targetPlanMetaKey,
                    action: 'select2_ajax_dashbaord_listing' // AJAX action for admin-ajax.php
                };
            },
            processResults: function( data ) {
                var options = [];
                var disabled_opts   =   false;
                if ( data ) {

                    // data is the array of arrays, and each of them contains ID and the Label of the option
                    jQuery.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
                        var disabled_opts   =   false;
                        if( text[2] == 'yes' )
                        {
                            disabled_opts   =   true;
                        }
                        options.push( { id: text[0], text: text[1], disabled:disabled_opts } );
                    });

                }
                return {
                    results: options
                };
            },
            cache: true
        },
        minimumInputLength: 3,
        language: {
            inputTooShort: function () {
                return inputShortText;
            },
            noResults: function () {
                return noResultsText;
            },
            searching: function () {
                return searchingText;
            }
        }
    });
	
	
	/* for campaigns */
	jQuery('.lp-search-listing-camp').select2({
        ajax: {
            url: ajax_search_term_object.ajaxurl,
            dataType: 'json',
            type:'GET',
            data: function (params) {
                return {
                    q: params.term, // search query
                    action: 'select2_ajax_dashbaord_listing_camp' // AJAX action for admin-ajax.php
                };
                console.log(params);
            },
            processResults: function( data ) {
                var options = [];
                if ( data ) {

                    // data is the array of arrays, and each of them contains ID and the Label of the option
                    jQuery.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
                        options.push( { id: text[0], text: text[1]  } );
                    });

                }
                return {
                    results: options
                };
            },
            cache: true
        },
        minimumInputLength: 3
    });
	/* end for camp */

    var uniqueMetaKey   =   'event_id';
    var planmetakey     =   'events';
    if( jQuery('.select2-ajax-unique').length != 0 )
    {
        uniqueMetaKey   =   jQuery('.select2-ajax-unique').data('metakey');
        planmetakey     =   jQuery('.select2-ajax-unique').data('planmetakey');

        var noResultsText   =   jQuery('#select2-ajax-noresutls').val(),
            inputShortText  =   jQuery('#select2-ajax-tooshort').val(),
            searchingText   =   jQuery('#select2-ajax-searching').val();
    }

    jQuery('.select2-ajax-unique').select2({
        ajax: {
            url: ajax_search_term_object.ajaxurl,
            dataType: 'json',
            type:'GET',
            data: function (params) {
                return {
                    q: params.term, // search query
                    uniqueMetaKey: uniqueMetaKey,
                    planmetakey: planmetakey,
                    action: 'select2_ajax_dashbaord_listing_unique' // AJAX action for admin-ajax.php
                };
            },
            processResults: function( data ) {
                var options = [];
                if ( data ) {

                    // data is the array of arrays, and each of them contains ID and the Label of the option
                    jQuery.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
                        var disabled_opts   =   false;
                        if( text[2] == 'yes' )
                        {
                            disabled_opts   =   true;
                        }

                        options.push( { id: text[0], text: text[1], disabled:disabled_opts } );
                    });

                }
                return {
                    results: options
                };
            },
            cache: true
        },
        minimumInputLength: 3,
        language: {
            inputTooShort: function () {
                return inputShortText;
            },
            noResults: function () {
                return noResultsText;
            },
            searching: function () {
                return searchingText;
            }
        }
    });

    jQuery('#ad-announcement-btn').on( 'click', function (e) {
       e.preventDefault();
       var $this   =   jQuery(this),
           userID  =   $this.data('uid'),
           annMsg  =   jQuery('#announcements-message').val(),
           annBT   =   jQuery('#announcements-btn-text').val(),
           annBL   =   jQuery('#announcements-btn-link').val(),
           annLI   =   jQuery('#announcements-listing').val(),
           annSt   =   jQuery('#ann-style').find(':selected').val(),
           annIC   =   jQuery('#announcements-icon').val(),
           annType =   '',
           annTI   =   jQuery('#announcements-title').val();

       if( annIC != '' )

       {
           var annType =   jQuery('#announcements-icon').attr('icon-type');
       }

       if( annLI == 0 || annLI == '' || annLI == null )
       {
           jQuery('#select2-announcements-listing-container').addClass('error');
       }
       else
       {
           jQuery('#select2-announcements-listing-container').removeClass('error');
       }
       if( annMsg == '' )
       {
           jQuery('#announcements-message').addClass('error');
       }
       else
       {
           jQuery('#announcements-message').removeClass('error');
       }

       if( annLI == 0 || annLI == '' || annMsg == '' || annLI == 0 || annLI == '' || annLI == null )
       {
		   var dataError   =   [];
       dataError.status    =   'error';
       dataError.msg    =   jQuery('.lp-notifaction-area').data('error-msg');
       ajax_success_popup( dataError, $this );
           $this.find('i').remove();
           return false;
       }
       if( $this.hasClass('processing-ann') )
       {}
       else
       {
           $this.append('<i class="fa fa-spin fa-spinner"></i>');
           $this.addClass('processing-ann');

           jQuery.ajax({
               type: 'POST',
               dataType: 'json',
               url: ajax_search_term_object.ajaxurl,
               data:{
                   'action': 'add_announcements_cb',
                   'user_id' : userID,
                   'annSt' : annSt,
                   'annMsg' : annMsg,
                   'annBT' : annBT,
                   'annBL' : annBL,
                   'annLI' : annLI,
                   'annTI' : annTI,
                   'annIC' : annIC,
                   'annType' : annType
               },
               success: function( res )
               {
                  ajax_success_popup( res, $this );
               },

               error: function( err )
               {
                   $this.find('i').remove();
               }
           });
       }


   });


    jQuery('#ann-style').on('change', function (e) {

        var $this   =   jQuery(this),

            $thisDes    =   $this.find(':selected').attr('data-des'),

            $thisTI     =   $this.find(':selected').attr('data-title'),

            $thisIC     =   $this.find(':selected').attr('data-icon'),

            $thisBT     =   $this.find(':selected').text(),

            $thisST     =   $this.find(':selected').attr('data-st');



        jQuery('.announcement-wrap span').text($thisDes);

        jQuery('#announcements-message').val($thisDes);

        jQuery('.announcement-wrap a').text($thisBT);

        jQuery('.announcement-wrap strong').text($thisTI);

        jQuery('#announcements-btn-text').val($thisBT);

        jQuery('#announcements-title').val($thisTI);

        jQuery('.announcement-wrap i').removeClass();

        jQuery('.announcement-wrap i').addClass($thisIC);





        jQuery('.field-desc strong').text($thisDes.length);





    })

    jQuery('.ann-style-wrap span').click(function (e) {

        var $this   =   jQuery(this),

            $thisWrap   =   $this.closest('.ann-style-wrap'),

            $thislabel  =   $this.closest('label'),

            $thisDes    =   $this.data('des'),

            $thisBT     =   $this.data('bt');





        $thisWrap.find('input[name="ann-style"]:checked').removeAttr('checked');

        $thisWrap.find('.ann-style-val').val($thislabel.find('input').val());

        $thislabel.find('input').attr('checked', true);



        jQuery('.announcement-wrap span, #announcements-message').text($thisDes);

        jQuery('.announcement-wrap a').text($thisBT);

        jQuery('#announcements-btn-text').val($thisBT);





    });



    jQuery(document).on('click', '#lp-save-dis', function(e)
    {
        e.preventDefault();

        var $this   =   jQuery(this),
            userID  =   $this.data('uid'),
            disHea  =   jQuery('#dis-heading').val(),
            disCod  =   jQuery('#dis-code').val(),
            disExpE  =   jQuery('#dis-expiry-e').val(),
            disExpS  =   jQuery('#dis-expiry-s').val(),
            disBT   =   jQuery('#dis-btn-text').val(),
            disBL   =   jQuery('#dis-btn-link').val(),
            disLI   =   jQuery('#dis-listing').val(),
            disImg   =   jQuery('.new-file-upload .frontend-input').val(),
            disOff   =   jQuery('#dis-off').val(),
            disDes   =   jQuery('#dis-description').val();


        if( disLI == 0 || disLI == '' || disLI == null )
        {
            jQuery('#select2-dis-listing-container').addClass('error');
        }
        else
        {
            jQuery('#select2-dis-listing-container').removeClass('error');
        }
        if( disHea == '' )
        {
            jQuery('#dis-heading').addClass('error');
        }
        else
        {
            jQuery('#dis-heading').removeClass('error');
        }

        if( disLI == 0 || disLI == '' || disLI == null || disHea == '' )
        {
			var dataError   =   [];
		   dataError.status    =   'error';
		   dataError.msg    =   jQuery('.lp-notifaction-area').data('error-msg');
		   ajax_success_popup( dataError, $this );
            $this.find('i').removeClass('fa-spin fa-spinner');
            return false;
        }
        if( $this.hasClass('processing-dis') )
        {}
        else
        {
            $this.addClass('processing-dis');
            $this.append('<i class="fa fa-spin fa-spinner"></i>');
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_search_term_object.ajaxurl,
                data:{
                    'action': 'add_discount_cb',
                    'user_id' : userID,
                    'disHea' : disHea,
                    'disCod' : disCod,
                    'disExpE' : disExpE,
                    'disExpS' : disExpS,
                    'disBT' : disBT,
                    'disBL' : disBL,
                    'disLI' : disLI,
                    'disDes' : disDes,
                    'disOff' : disOff,
                    'disImg' : disImg,
                    'disSta' : 'active',
                },
                success: function( res )
                {
                   ajax_success_popup( res, $this );
                },

                error: function( err )
                {
                    alert( err );
                    $this.find('i').remove();
                }
            });
        }
    });

    jQuery(document).on('click', '#lp-save-offer', function(e)
    {

        e.preventDefault();



        var $this   =   jQuery(this),

            userID  =   $this.data('uid'),

            offerTitle  =   jQuery('#offer-title').val(),

            offerDes  =   jQuery('#offer-description').val(),

            offerExp  =   jQuery('#offer-expriry').val(),

            offerBT  =   jQuery('#offer-btn-text').val(),

            offerBL  =   jQuery('#offer-btn-link').val(),

            offerImg  =   jQuery('#frontend-input').val(),

            offerLI  =   jQuery('#offer-listing').val();



        if( !jQuery('.btn-link-field-toggle').hasClass('link-active') )

        {

            offerBL =   '';

        }



        $this.append('<i class="fa fa-spin fa-spinner"></i>');



        if( offerLI == null || offerLI == '' || offerTitle == '' || offerExp == '' )

        {

            jQuery('.ann-err-msg').fadeIn(500).delay(1500).fadeOut(500);

            $this.find('i').remove();

            return false;

        }



        jQuery.ajax({

            type: 'POST',

            dataType: 'json',

            url: ajax_search_term_object.ajaxurl,

            data:{

                'action': 'add_offer_cb',

                'user_id' : userID,

                'offerTitle' : offerTitle,

                'offerDes' : offerDes,

                'offerExp' : offerExp,

                'offerBT' : offerBT,

                'offerBL' : offerBL,

                'offerLI' : offerLI,

                'offerImg' : offerImg,

            },

            success: function( res )

            {

                console.log( res );

                $this.find('i').removeClass('fa-spin fa-spinner');

                $this.find('i').addClass('fa fa-check');

                location.reload();

            },

            error: function( err )

            {

                alert( err );

                $this.find('i').remove();

            }

        });

    });

    jQuery(document).on('click', '.del-this', function(e)
    {
        e.preventDefault();
        jQuery('.remove-active').removeClass('remove-active');
        jQuery(this).addClass('remove-active');
        jQuery('#dashboard-delete-modal').modal('show');
        jQuery('.modal-backdrop').hide();
    });

    jQuery(document).on('click', '.dashboard-confirm-del-btn', function (e) {

        var $this       =   jQuery('.remove-active');

        if( $this.hasClass('del-all-menu') )

        {



            var lid     =   $this.data('lid'),

                user_id =   $this.data('uid');



            jQuery(this).append('<i class="fa fa-spin fa-spinner" style="margin-left: 5px;"></i>');

            jQuery.ajax({

                type: 'POST',

                dataType: 'json',

                url: ajax_search_term_object.ajaxurl,

                data:{

                    'action': 'del_all_menu_cb',

                    'user_id' : user_id,

                    'lid' : lid,

                },

                success: function( res )

                {

                    if( res.status == 'success' )

                    {

                        location.reload();

                    }

                    $this.find('i').removeClass('fa-spin fa-spinner').addClass('fa-trash-o');

                },



                error: function( err )

                {

                    console.log( err );

                    $this.find('i').removeClass('fa-spin fa-spinner').addClass('fa-trash-o');

                }

            });

        }

        else

        {

            var targetID    =   $this.data('targetid'),

                userID      =   $this.data('uid'),

                delType     =   '',

                delIDS      =   '',

                dellAll     =   '';





            if( $this.hasClass('dis-del') )

            {

                delType =   'dis';

            }

            if( $this.hasClass('event-del') )

            {

                delType =   'event';

            }



            if( $this.hasClass('ann-del') )

            {

                delType =   'ann';

            }



            if( $this.hasClass('offer-del') )

            {

                delType     =   'offer';

                delIDS      =   $this.data('del-ids');

            }

            if( $this.hasClass('menu-del') )

            {

                delType =   'menu';

                delIDS  =   $this.data('lid');

            }

            if( $this.hasClass('del-type') )

            {

                delType =   'type';

                dellAll =   jQuery('input[name="delete-group-type"]:checked').val();

            }

            if( $this.hasClass('del-group') )

            {

                delType =   'group';

                dellAll =   jQuery('input[name="delete-group-type"]:checked').val();

            }





            jQuery(this).append('<i class="fa fa-spin fa-spinner" style="margin-left: 5px;"></i>');





            jQuery.ajax({

                type: 'POST',

                dataType: 'json',

                url: ajax_search_term_object.ajaxurl,

                data:{

                    'action': 'del_ann_dis_menu_cb',

                    'user_id' : userID,

                    'delType' : delType,

                    'targetID' : targetID,

                    'delIDS' : delIDS,

                    'dellAll' : dellAll,

                },

                success: function( res )

                {



                    if( res.status == 'success' )

                    {

                        location.reload();

                    }

                    $this.find('i').removeClass('fa-spin fa-spinner').addClass('fa-trash-o');

                },



                error: function( err )

                {

                    console.log( err );

                    $this.find('i').removeClass('fa-spin fa-spinner').addClass('fa-trash-o');

                }

            });

        }





    });
    jQuery(document).on('click', 'a.event-edit, a.menu-edit, a.ann-edit, a.dis-edit, a.offer-edit', function(e)
    {
        e.preventDefault();
        var $this       =   jQuery(this),
            targetID    =   $this.data('targetid'),
            updateWrap  =   '#update-wrap-'+targetID;

        if( jQuery('.active-update-form').length != 0 )
        {
            jQuery('.active-update-form').slideUp(500, function (e) {
                jQuery('.active-update-form').removeClass('active-ann-form');
                jQuery(updateWrap).slideToggle('500', function (e) {
                    jQuery(updateWrap).addClass('active-update-form');
                    jQuery('.cancel-update').click(function(e)
                    {
                        e.preventDefault();
                        jQuery('.active-update-form').slideUp(500, function (e) {
                            jQuery('.active-update-form').removeClass('active-update-form');
                        })
                    })
                });
            });
        }
        else
        {
            jQuery(updateWrap).slideToggle('500', function (e) {
                jQuery(updateWrap).addClass('active-update-form');
                jQuery('.cancel-update').click(function(e)
                {
                    e.preventDefault();
                    jQuery('.active-update-form').slideUp(500, function (e) {
                        jQuery('.active-update-form').removeClass('active-update-form');
                    })
                })
            });
        }
    });
    jQuery(document).on( 'click', '.edit-menu-item', function (e) {
        e.preventDefault();
        var $this       =   jQuery(this),
            targetID    =   $this.data('menuid'),
            updateWrap  =   '#menu-update-'+targetID;

        if( jQuery('.active-update-formm').length != 0 )
        {
            jQuery('.active-update-formm').slideUp(500, function (e) {
                jQuery('.active-update-formm').removeClass('active-ann-form');
                jQuery(updateWrap).slideToggle('500', function (e) {
                    jQuery(updateWrap).addClass('active-update-formm');
                    jQuery('.cancel-update-menu').click(function(e)
                    {
                        e.preventDefault();
                        jQuery('.active-update-formm').slideUp(500, function (e) {
                            jQuery('.active-update-formm').removeClass('active-update-formm');
                        })
                    })
                });
            });
        }
        else
        {
            jQuery(updateWrap).slideToggle('500', function (e) {
                jQuery(updateWrap).addClass('active-update-formm');
                jQuery('.cancel-update-menu').click(function(e)
                {
                    e.preventDefault();
                    jQuery('.active-update-formm').slideUp(500, function (e) {
                        jQuery('.active-update-formm').removeClass('active-update-formm');
                    })
                })
            });
        }
    } );

    if( jQuery('.lp-countdown').length != 0 )
    {
        jQuery('.lp-countdown').each(function (i, obj) {
            var selector    =   '#'+jQuery(this).attr('id');
            init_countdown(selector);
        });
    }
});



jQuery(document).on('change', '#discount_displayin', function (e) {

    e.preventDefault();

    var $this   =   jQuery(this),

        thisval =   $this.val(),

        userID  =   $this.data('udi');



    jQuery($this).after('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');

    jQuery.ajax({

        type: 'POST',

        dataType: 'json',

        url: ajax_search_term_object.ajaxurl,

        data:{

            'action': 'discount_display_area',

            'userID' : userID,

            'thisval' : thisval,

        },

        success: function( res )

        {

            jQuery('#discount_displayin').next('i').remove();

        },

        error: function( err )

        {

            alert( err );

            $this.find('i').remove();

        }

    });

})



jQuery(document).on('click', '.lp-edit-offer', function(e)

{

    e.preventDefault();





    var $this   =   jQuery(this),

        userID  =   $this.data('uid'),

        offerID       =   $this.data('offerid'),

        offerTitle  =   jQuery('#offer-title-'+offerID).val(),

        offerDes  =   jQuery('#offer-description-'+offerID).val(),

        offerExp  =   jQuery('#offer-expriry-'+offerID).val(),

        offerBT  =   jQuery('#offer-btn-text-'+offerID).val(),

        offerBL  =   jQuery('#offer-btn-link-'+offerID).val(),

        offerLI  =   jQuery('#offer-listing-'+offerID).val();



    if( !jQuery('.btn-link-field-toggle').hasClass('link-active') )

    {

        offerBL =   '';

    }





    $this.append('<i class="fa fa-spin fa-spinner"></i>');



    if( offerLI == null || offerLI == '' || offerTitle == '' || offerExp == '' )

    {

        jQuery('.ann-err-msg').fadeIn(500).delay(1500).fadeOut(500);

        $this.find('i').remove();

        return false;

    }





    jQuery.ajax({

        type: 'POST',

        dataType: 'json',

        url: ajax_search_term_object.ajaxurl,

        data:{

            'action': 'add_offer_cb',

            'user_id' : userID,

            'offerTitle' : offerTitle,

            'offerDes' : offerDes,

            'offerExp' : offerExp,

            'offerBT' : offerBT,

            'offerBL' : offerBL,

            'offerLI' : offerLI,

            'offerUP' : 'yes',

            'offerID' : offerID

        },

        success: function( res )

        {

            // console.log(res);

            $this.find('i').removeClass('fa-spin fa-spinner');

            $this.find('i').addClass('fa fa-check');

            location.reload();

        },

        error: function( err )

        {

            alert( err );

            $this.find('i').remove();

        }

    });

});



jQuery(document).on('click', '.lp-edit-dis', function (e)

{
    e.preventDefault();
    var $this       =   jQuery(this),

        disID       =   $this.data('disid'),
        userID      =   $this.data('uid'),
        disHea      =   jQuery('#dis-heading-'+disID).val(),
        disCod      =   jQuery('#dis-code-'+disID).val(),
        disExpE      =   jQuery('#dis-expiry-e-'+disID).val(),
        disExpS      =   jQuery('#dis-expiry-s-'+disID).val(),
        disBT       =   jQuery('#dis-btn-text-'+disID).val(),
        disBL       =   jQuery('#dis-btn-link-'+disID).val(),
        disLI       =   $this.data('listid'),
        disOff   =   jQuery('#dis-off-'+disID).val(),
		disImg      =   jQuery('.edit-upload-'+disID+' .frontend-input').val();
        disDes      =   jQuery('#dis-description-'+disID).val();
    

    $this.append('<i class="fa fa-spin fa-spinner"></i>');
    if( disLI == 0 || disLI == '' )
    {
        jQuery('.ann-err-msg').fadeIn(500).delay(1500).fadeOut(500);
        $this.find('i').remove();
        return false;
    }
	if( disImg == '' )
   {
       disImg  =   jQuery('#dis-old-img-'+disID).val();
   }
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_search_term_object.ajaxurl,
        data:{
            'action': 'add_discount_cb',
            'user_id' : userID,
            'disID' : disID,
            'disHea' : disHea,
            'disCod' : disCod,
            'disExpE' : disExpE,
            'disExpS' : disExpS,
            'disBT' : disBT,
            'disBL' : disBL,
            'disLI' : disLI,
            'disDes' : disDes,
            'disOff' : disOff,
			'disImg' : disImg,
            'disUp' : 'yes'
        },
        success: function( res )
        {
            ajax_success_popup( res, $this );
        },
        error: function( err )
        {
            // alert( err );
            // $this.find('i').remove();
        }
    });
});



jQuery(document).on('click', '.lp-edit-announcements', function (e)
{
    e.preventDefault();
    var $this       =   jQuery(this),
        annID       =   $this.data('annid'),
        userID      =   $this.data('uid'),
        annMsg  =   jQuery('#announcements-message-'+annID).val(),
        annBT   =   jQuery('#announcements-btn-text-'+annID).val(),
        annBL   =   jQuery('#announcements-btn-link-'+annID).val(),
        annSt   =   jQuery('#ann-style-val-'+annID).val(),
        annTI   =   jQuery('#announcements-title-'+annID).val(),
        annIC   =   jQuery('#announcements-icon-'+annID).val(),
        annLI   =   jQuery(this).data('lid');

    $this.append('<i class="fa fa-spin fa-spinner"></i>');
    if( annLI == 0 || annLI == '' || annMsg == '' )
    {
        jQuery('.ann-err-msg-'+annID).fadeIn(500).delay(1500).fadeOut(500);
        $this.find('i').remove();
        return false;
    }

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_search_term_object.ajaxurl,
        data:{
            'action': 'add_announcements_cb',
            'user_id' : userID,
            'annMsg' : annMsg,
            'annSt' : annSt,
            'annBT' : annBT,
            'annBL' : annBL,
            'annLI' : annLI,
            'annTI' : annTI,
            'annIC' : annIC,
            'annUP' : 'yes',
            'annID' : annID,
        },

        success: function( res )
        {
            ajax_success_popup( res, $this );

        },

        error: function( err )
        {

        }
    });
});



jQuery(document).on('click', '.lp-edit-menu', function (e) {

    e.preventDefault();

    var $this       =   jQuery(this),
        userID      =   $this.data('uid'),
        LID      =   $this.data('lid'),
        menuID  =   $this.data('menuid'),
        mTitle  =   jQuery('#menu-title-'+menuID).val(),
        mDetail  =   jQuery('#menu-detail-'+menuID).val(),
        mOldPrice  =   jQuery('#menu-old-price-'+menuID).val(),
        mNewPrice  =   jQuery('#menu-new-price-'+menuID).val(),
        mQuoteT  =   jQuery('#menu-quote-text-'+menuID).val(),
        mQuoteL  =   jQuery('#menu-quote-link-'+menuID).val(),
        mLink  =   jQuery('#menu-link-'+menuID).val(),
        mGroup  =   jQuery('#menu-group-'+menuID).val(),
        mType  =   jQuery('#menu-type-'+menuID).val(),
        mImage      =   jQuery('.edit-upload-'+menuID+' .frontend-input').val();
    if( mImage == '' )
    {
        mImage  =   jQuery('#dis-old-img-'+menuID).val();
    }



    $this.append('<i class="fa fa-spin fa-spinner"></i>');

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_search_term_object.ajaxurl,
        data: {
            'action': 'add_menu_cb',
            'user_id': userID,
            'LID' : LID,
            'menuID' : menuID,
            'mTitle': mTitle,
            'mDetail': mDetail,
            'mOldPrice': mOldPrice,
            'mNewPrice': mNewPrice,
            'mQuoteT': mQuoteT,
            'mQuoteL': mQuoteL,
            'mLink': mLink,
            'mImage': mImage,
            'mType' : mType,
            'mGroup' : mGroup,
            'menuUp': 'yes'
        },
        success: function (res) {
            ajax_success_popup( res, $this );
        },

        error: function (err) {
            alert(err);
            $this.find('i').remove();
        }
    });
});



function init_countdown( selector )
{
    var $this   =   jQuery(selector);
    if( !$this.length ) return false;

    var clock;
    var daysLabel  =   jQuery(selector).data('label-days'),
        hoursLabel   =   jQuery(selector).data('label-hours'),
        minsLabel   =   jQuery(selector).data('label-mints'),
        cDay        =   jQuery(selector).data('day'),
        cMonth      =   jQuery(selector).data('month'),
        cYear       =   jQuery(selector).data('year');

    FlipClock.Lang.Custom = { days: daysLabel, hours: hoursLabel, minutes: minsLabel };

    var startDate = new Date(cYear, cMonth, cDay); //year, month, day
    var now = Math.floor(Date.now()/1000); //Current timestamp in seconds
    var clockStart = startDate.getTime()/1000 - now; //What to set the clock at when page loads
    var numDays = Math.floor(clockStart / 86400);

    var minDigits   =   6;
    if( numDays > 99 )
    {
        minDigits   =   7;
    }

    clock = jQuery(selector).FlipClock({
        clockFace: 'DailyCounter',
        autoStart: true,
        showSeconds: false,
        language: 'Custom',
        minimumDigits: minDigits
   });

    clock.setTime(clockStart);
    clock.setCountdown(true);
}

jQuery(document).on( 'mouseleave', '#menu-categories-menu', function (e) {

    jQuery('.lp-header-nav-btn').removeClass('active-can-menu');

    jQuery('#menu-categories-menu').css('opacity', '0');

    jQuery('#menu-categories-menu').css('transform', 'scale(0)');

});

jQuery(document).on( 'click', '.lp-ann-btn', function (e) {

    e.preventDefault();

    var targetANN   =   '#'+jQuery(this).attr('data-ann');



    jQuery(targetANN).find('.lp-listing-announcement').fadeIn();

    jQuery(targetANN).find('.lp-listing-announcement').addClass('active-ann');

    jQuery('.code-overlay').fadeIn();

});



jQuery(document).on( 'click', '.close-ann', function (e) {

    e.preventDefault();

    jQuery('.active-ann').fadeOut();

    jQuery('.active-ann').removeClass('active-ann');

    jQuery('.code-overlay').fadeOut();

});



jQuery(document).on('click', '.lp-coupon-btn', function(e){

    e.preventDefault();



    var targetCOUP   =   '#'+jQuery(this).data('coupon');



    jQuery(targetCOUP).fadeIn();

    jQuery(targetCOUP).addClass('active-coupon');



    jQuery('.code-overlay').fadeIn();



});

jQuery(document).on('click', '.close-coupon', function (e) {

    e.preventDefault();



    jQuery('.active-coupon').fadeOut();

    jQuery('.active-coupon').removeClass('active-coupon');

    jQuery('.code-overlay').fadeOut();

});



jQuery(document).on('shown.bs.tab', 'a[href="#menu_tab"]', function (e) {
    //slickINIT();
    jQuery('.lp-listing-menuu-slider').slick('refresh');
});





jQuery(document).on( 'click', '.ann-toggle-btn', function (e) {

    e.preventDefault();
    var $this   =   jQuery(this),
        status  =   $this.attr('data-status'),
        annID   =   $this.data('annid'),
        userID  =   $this.data('uid');

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_search_term_object.ajaxurl,
        data:{
            'action': 'add_announcements_cb',
            'user_id' : userID,
            'status' : status,
            'annID' : annID,
            'annUP' : 'on-off'
        },

        success: function( res )
        {
            if( res.status == 0 )
            {
                status  =   'inactive';
            }
            else if ( res.status == 1 )
            {
                status  =   'active';
            }
            $this.attr('data-status', status);
        },
        error: function( err )
        {
            $this.find('i').remove();
        }
    });

});
jQuery(document).on('change', '.on-off-ann', function (e) {
    e.preventDefault();

    var $this   =   jQuery(this),
        status  =   $this.attr('data-status'),
        annID   =   $this.data('annid'),
        userID  =   $this.data('uid');

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_search_term_object.ajaxurl,
        data:{
            'action': 'add_announcements_cb',
            'user_id' : userID,
            'status' : status,
            'annID' : annID,
            'annUP' : 'on-off'
        },

        success: function( res )
        {
            if( res.status == 0 )
            {
                status  =   'inactive';
            }
            else if ( res.status == 1 )
            {
                status  =   'active';
            }
            $this.attr('data-status', status);
        },
        error: function( err )
        {
            $this.find('i').remove();
        }
    });
});


jQuery(document).on('keyup', '#announcements-message', function (e) {

    var thisText    =   jQuery(this).val();

    jQuery('.ann-preivew-wrap .announcement-wrap span').text(thisText);



    jQuery('.field-desc strong').text(thisText.length);

});

jQuery(document).on('keyup', '#announcements-title', function (e) {

    var thisText    =   jQuery(this).val();

    jQuery('.ann-preivew-wrap .announcement-wrap strong').text(thisText);

});

jQuery(document).on('keyup', '#announcements-btn-text', function (e) {

    var thisText    =   jQuery(this).val();

    jQuery('.ann-preivew-wrap .announcement-wrap .announcement-btn').text(thisText);



});

jQuery(document).on('focusout', '#announcements-icon', function (e) {

    var thisText    =   jQuery(this).val();
	if( thisText == '' ) { return false; }

    if (thisText.match("^fa"))

    {

        jQuery('.announcement-wrap img').hide();

        jQuery('.announcement-wrap i').show();

        jQuery(this).attr('icon-type', 'fa-icon');

        jQuery('.announcement-wrap i').removeClass().addClass('fa '+thisText);

    }

    else

    {

        jQuery('.announcement-wrap i').hide()

        jQuery('.announcement-wrap img').show();

        jQuery('.announcement-wrap img').attr('src', thisText);

        jQuery(this).attr('icon-type', 'img-icon');

    }



});





function  slickINIT() {

    if( jQuery('.lp-listing-menuu-slider').length != 0 )
    {
        jQuery('.lp-listing-menuu-slider').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            adaptiveHeight: true,
            nextArrow: "<i class=\"fa fa-angle-right arrow-left\" aria-hidden=\"true\"></i>",
            prevArrow: "<i class=\"fa fa-angle-left arrow-right\" aria-hidden=\"true\"></i>"
        });

    }

}
jQuery(document).on('change', '.coupons-fields-switch input[type="checkbox"]', function (e) {
    e.preventDefault();
    var targetID    =   jQuery(this).data('target');
    if( targetID == 'coupon-external' )
    {
        if( jQuery(this).is(':checked') )
        {
            jQuery('#code-switch').slideUp(500, function () {
                jQuery('#btn-url-switch').slideDown(500);
            });
        }
        else
        {
            jQuery('#btn-url-switch').slideUp(500, function () {
                jQuery('#code-switch').slideDown(500);
            });
        }

    }else if(targetID == 'quote-button'){
        if( jQuery(this).is(':checked') )
        {
            jQuery('.menu-price-wrap').slideUp(500, function () {
                jQuery('.menu-quote-wrap').slideDown(500);
            });
        }
        else
        {
            jQuery('.menu-quote-wrap').slideUp(500, function () {
                jQuery('.menu-price-wrap').slideDown(500);
            });
        }
    }
    else
    {
        jQuery('#'+targetID+'-switch').slideToggle(500, function () {
            if( !jQuery('#date-switch').is(':visible') && !jQuery('#time-switch').is(':visible') )
            {
                jQuery('.empty-row-check').slideToggle();
            }
        });
    }

});

jQuery(document).on('click', '.add-new-type', function(e){
    e.preventDefault();
    jQuery('#menu-type-new, .save-new-type').fadeIn();
});
jQuery(document).on('click', '.add-new-group', function(e){
    e.preventDefault();
    jQuery('#menu-group-new, .save-new-group').fadeIn();
});
jQuery(document).on('click', '.save-new-type', function (e) {
    e.preventDefault();


    var $this   =   jQuery(this),
        userID  =   $this.data('uid'),
        type    =   jQuery('#menu-type-new').val();


    $this.append('<i class="fa fa-spin fa-spinner"></i>');
    if( type == '' )
    {
        jQuery('#menu-type-new').addClass('error');
        $this.find('i').remove();
        return false;
    }
    else
    {
        jQuery('#menu-type-new').removeClass('error');
    }
    if( $this.hasClass('processing') )
    {

    }
    else
    {
        $this.addClass('processing');


        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_search_term_object.ajaxurl,
            data:{
                'action': 'add_menu_type_cb',
                'user_id' : userID,
                'type' : type,
            },
            success: function( res )
            {

                if( $this.hasClass('manage-type-group-form') )
                {
                    location.reload();
                }
                else
                {
                    var optData = {
                        id: type,
                        text: type
                    };

                    var newOption = new Option(optData.text, optData.id, false, false);
                    jQuery('#menu-type').append(newOption).trigger('change');

                    var currentTypes    =   jQuery('#menu-type').val();
                    if( currentTypes == null )
                    {
                        jQuery('#menu-type').val(type).trigger('change');
                    }
                    else
                    {
                        currentTypes.push( type );
                        jQuery('#menu-type').val(currentTypes).trigger('change');
                    }
                }

                $this.find('i').removeClass('fa-spin fa-spinner');
                $this.find('i').remove();
                $this.removeClass('processing');
                jQuery('#menu-type-new').val('');

            },
            error: function( err )

            {
                alert( err );
                $this.find('i').remove();
            }

        });
    }
});
jQuery(document).on( 'click', '.save-new-group', function (e) {

    e.preventDefault();





    var $this   =   jQuery(this),

        userID  =   $this.data('uid'),

        group    =   jQuery('#menu-group-new').val();



    $this.append('<i class="fa fa-spin fa-spinner"></i>');





    if( group == '' )

    {

        jQuery('#menu-group-new').addClass('error');

        $this.find('i').remove();

        return false;

    }

    else

    {

        jQuery('#menu-group-new').removeClass('error');

    }

    if( $this.hasClass('processing') )

    {



    }

    else

    {

        $this.addClass('processing');

        jQuery.ajax({

            type: 'POST',

            dataType: 'json',

            url: ajax_search_term_object.ajaxurl,

            data:{

                'action': 'add_menu_group_cb',

                'user_id' : userID,

                'group' : group,

            },

            success: function( res )

            {



                if( $this.hasClass('manage-type-group-form') )

                {

                    location.reload();

                }

                else

                {

                    var optData = {

                        id: group,

                        text: group

                    };

                    var newOption = new Option(optData.text, optData.id, false, false);

                    jQuery('#menu-group').append(newOption).trigger('change');



                    var currentGroups   =   jQuery('#menu-group').val();

                    if( currentGroups == null )

                    {

                        jQuery('#menu-group').val(group).trigger('change');

                    }

                    else

                    {

                        currentGroups.push(group);

                        jQuery('#menu-group').val(currentGroups).trigger('change');

                    }

                }
                $this.find('i').removeClass('fa-spin fa-spinner');

                $this.find('i').remove();

                $this.removeClass('processing');

                jQuery('#menu-group-new').val('');

            },

            error: function( err )

            {

                alert( err );

                $this.find('i').remove();

            }

        });

    }

} );

jQuery(document).on('click', '.del-all-menu', function (e) {
    e.preventDefault();

    jQuery(this).addClass('remove-active');
    jQuery('#dashboard-delete-modal').modal('show');
    jQuery('.modal-backdrop').hide();


});

jQuery(document).on('click', '#lp-save-events', function(e){

    e.preventDefault();

    var $this   =   jQuery(this),
        eTitle  =   jQuery('#event-title').val(),
        eDesc   =   jQuery('#event-description').val(),
        eDate   =   jQuery('#event-date-s').val(),
        eTime   =   jQuery('#event-time').val(),
        eLoc    =   jQuery('#event-location').val(),
        eLat    =   jQuery('#lp-events-form .latitude').val(),
        eLon    =   jQuery('#lp-events-form .longitude').val(),
        eTUrl   =   jQuery('#event-ticket-url').val(),
        eLID    =   jQuery('#event-listing').val(),
        eImg    =   jQuery('.new-file-upload .frontend-input').val(),
        eUID    =   $this.data('uid'),
        eUtils  =    '';


    jQuery('.coupons-fields-switch').find('.switch-checkbox').each(function () {
        var CheckboxX       =   jQuery(this),
            target          =   CheckboxX.data('target'),
            targetVal       =   ''

        if( CheckboxX.is(':checked') )
        {
            targetVal   =   'yes';
        }
        else
        {
            targetVal   =   'no';
        }
        eUtils  +=   target+'|'+targetVal+'*';
    });

    if( eLID == '' || eLID == 0 || eLID == null )
    {
        jQuery('#select2-event-listing-container').addClass('error');
    }
    else
    {
        jQuery('#select2-event-listing-container').removeClass('error');
    }
    if( eTitle == '' )
    {
        jQuery('#event-title').addClass('error');
    }
    else
    {
        jQuery('#event-title').removeClass('error');
    }

    if( eLoc == '' ){
        jQuery('#event-location').addClass('error');
    }
    else
    {
        jQuery('#event-location').removeClass('error');
    }
    if( eDate == '' ){
        jQuery('#event-date-s').addClass('error');
    }
    else
    {
        jQuery('#event-date-s').removeClass('error');
    }
    if( eTime == '' ){
        jQuery('#event-time').addClass('error');
    }
    else
    {
        jQuery('#event-time').removeClass('error');
    }
    if( eLID == '' || eLID == 0 || eLID == null || eTitle == '' || eTime == '' || eDate == '' || eLoc == '' )
    {
        var dataError   =   [];
        dataError.status    =   'error';
        dataError.msg    =   jQuery('.lp-notifaction-area').data('error-msg');
        ajax_success_popup( dataError, $this );
        return false;
    }
    $this.append('<i class="fa fa-spin fa-spinner"></i>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_search_term_object.ajaxurl,
        data:{
            'action': 'add_events_cb',
            'eTitle' : eTitle,
            'eDesc' : eDesc,
            'eDate' : eDate,
            'eTime' : eTime,
            'eLoc' : eLoc,
            'eLat' : eLat,
            'eLon' : eLon,
            'eTUrl' : eTUrl,
            'eLID' : eLID,
            'eUID' : eUID,
            'eImg' : eImg,
            'eUtils' : eUtils,
        },
        success: function( res )
        {
            ajax_success_popup( res, $this );

        },

        error: function( err )
        {
            console.log( err );
        }
    });
});

//lp-save-events


jQuery(document).on('click', '.lp-save-events', function(e){
    e.preventDefault();
    var $this   =   jQuery(this),
        eID     =   $this.data('eid'),
        eTitle  =   jQuery('#event-title-'+eID).val(),
        eDesc   =   jQuery('#event-description-'+eID).val(),
        eDate   =   jQuery('#event-date-s-'+eID).val(),
        eTime   =   jQuery('#event-time-'+eID).val(),
        eLoc    =   jQuery('#event-location-'+eID).val(),
        eLat    =   $this.closest('.lp-coupons-form-inner').find('.latitude').val(),
        eLong    =  $this.closest('.lp-coupons-form-inner').find('.longitude').val(),
        eTUrl   =   jQuery('#event-ticket-url-'+eID).val(),
        eImg    =   jQuery('.edit-upload-'+eID+' .frontend-input').val(),
        eUID    =   $this.data('uid');


    if( eTitle == '' )
    {
        jQuery('#event-title').addClass('error');
    }
    else
    {
        jQuery('#event-title').removeClass('error');
    }

    if( eTitle == '' )
    {
        return false;
    }
    if( eImg == '' )
    {
        eImg    =   jQuery('#event-old-img-'+eID).val();
    }
    $this.append('<i class="fa fa-spin fa-spinner"></i>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_search_term_object.ajaxurl,
        data:{
            'action': 'add_events_cb',
            'eTitle' : eTitle,
            'eDesc' : eDesc,
            'eDate' : eDate,
            'eTime' : eTime,
            'eLoc' : eLoc,
            'eLat' : eLat,
            'eLon' : eLong,
            'eTUrl' : eTUrl,
            'eUID' : eUID,
            'eID' : eID,
            'eImg' : eImg,
            'eUp' : 'yes'
        },
        success: function( res )
        {
            ajax_success_popup( res, $this );
        },

        error: function( err )
        {
            console.log( err );
        }
    });
});
jQuery(document).on( 'click', '#attend-event', function (e) {
    e.preventDefault();
    var $this   =   jQuery(this),
        eID     =   $this.data('event'),
        eUID    =   $this.data('uid');



    if( $this.hasClass('processing') )
    {

    }
    else
    {
        $this.append('<i class="fa fa-spinner fa-spin"></i>');
        $this.addClass('processing');
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_search_term_object.ajaxurl,
            data: {
                'action': 'event_attending_cb',
                'eID': eID,
                'eUID': eUID,
            },
            success: function (res) {
                console.log(res);
                jQuery('.total-going').text(res.total_attending);
                $this.find('i').removeClass('fa-spin fa-spinner').addClass('fa-check');
            },
            error: function (err) {
                console.log(err);
            }
        });
    }
});

jQuery(document).on('click', '.cancel-ad-new-btn', function (e) {
    e.preventDefault();
    var targetForm      =   '#'+jQuery(this).data('cancel')+'-form-toggle';

    jQuery(targetForm).fadeOut('slow', function () {
        jQuery('html, body').animate({
            scrollTop: jQuery('.add-new-open-form').offset().top
        }, 1000);
    });
});

jQuery(document).on('click', '.lp-notifi-icons', function (e) {
    e.preventDefault();
    jQuery(this).closest('.active-wrap').removeClass('active-wrap');
});
jQuery(document).ready(function () {
    jQuery('#fill-o-bot-check').on('change', function(e){
       if( jQuery(this).is(':checked') )
       {
            jQuery('#lptitle').attr('type', 'hidden');
           jQuery('.lptitle').addClass('fill-o-bot-active');
            jQuery('#lptitle').attr('name', '');
            jQuery('#lptitleGoogle').attr('name', 'postTitle');
            jQuery('#lptitleGoogle').attr('type', 'text');
       }
       else
       {
            jQuery('#lptitleGoogle').attr('type','hidden');
           jQuery('.lptitle').removeClass('fill-o-bot-active');
            jQuery('#lptitle').attr('name', 'postTitle');
            jQuery('#lptitle').attr('type', 'text');
            jQuery('#lptitleGoogle').attr('name', '');
            
       }
   });

});
jQuery('html').click(function (e) {
   if(jQuery('.lp-multi-star-wrap').is(":visible") && e.target.className != 'open-multi-rate-box' ) {
       jQuery('.lp-multi-star-wrap').slideUp();
   }
});

function ajax_success_popup( res, $this )
{
   if( res.status == 'success' )
   {
       $this.find('i').removeClass('fa-spin fa-spinner').addClass('fa-check');
       jQuery('.lp-notifaction-area').find('h4').text(res.msg);
       jQuery('.lp-notifaction-area').removeClass('lp-notifaction-error').addClass('lp-notifaction-success');
       jQuery('.lp-notifaction-area').addClass('active-wrap');

	 
       location.reload();
   }
   if ( res.status == 'error' )
   {
       $this.find('i').remove();
       jQuery('.lp-notifaction-area').find('h4').text(res.msg);
       jQuery('.lp-notifaction-area').removeClass('lp-notifaction-success').addClass('lp-notifaction-error');
       jQuery('.lp-notifaction-area').addClass('active-wrap');
   }
}
jQuery(document).on('keyup', '#menu-type-new, #menu-group-new', function()

{
    var typeGroupText   =   jQuery(this).val(),
        errMsg          =   jQuery(this).data('err'),
        re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;

    var isSplChar = re.test(typeGroupText);
    if(isSplChar)

    {
        var no_spl_char = typeGroupText.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');

        jQuery(this).val(no_spl_char);
        jQuery(this).after('<p>'+ errMsg +'</p>');
    }

});
//Event detail page view more and less more
jQuery(document).ready(function() {
    jQuery('.lp-event-view-less').click(function(e){
        e.preventDefault();
        var lessText = jQuery(this).data('contract');
        var moreText    =   jQuery(this).data('expand');
        if(jQuery(this).hasClass('event-shown')){
            jQuery(this).removeClass('event-shown');
            jQuery(this).html(moreText);
            jQuery('.lp-attende-extra').removeClass('active');
        }else{
            jQuery(this).addClass('event-shown');
            jQuery('.lp-attende-extra').addClass('active');
            jQuery(this).html(lessText);
        }

    });

    /* for event gaddress */

    function initializeEventAddr() {
        if( jQuery('.event-addr').length > 0 )
        {
            jQuery('.event-addr').each(function(index){
                var input = document.getElementById(jQuery(this).attr('id'));
                var autocomplete = new google.maps.places.Autocomplete(input);
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace();
                    var lat = place.geometry.location.lat();
                    var lon =  place.geometry.location.lng();
                    jQuery('input.latitude').val(lat);
                    jQuery('input.longitude').val(lon);
                });
            });
        }

    }
    google.maps.event.addDomListener(window, 'load', initializeEventAddr);

    /* gaddress ends */
});

jQuery(document).on('click', 'span.remove-menu-img', function (e) {
    e.preventDefault();
    var targetID    =   jQuery(this).data('target'),
        targetSrc   =   jQuery(this).data('src')+',',
        targetImgs  =   jQuery('.active-upload').find('.frontend-input-multiple').val();    if( targetImgs == undefined )
    {
        targetImgs  =   jQuery('#'+targetID).val();
    }    targetImgs  =   targetImgs.replace( targetSrc, '' );
    jQuery(this).closest('.menu-edit-img-wrap').remove();
    jQuery('input#'+targetID).val(targetImgs);
});

jQuery(document).on('click', '.select2-results ul li', function(e){
    jQuery('.lp-pp-noa-tip').fadeIn();
});

jQuery('.select2-ajax').on('select2:select', function (e) {
   jQuery('.lp-pp-noa-tip').fadeOut();
});


jQuery(document).on('click', '.remove-event-img', function (e) {
    e.preventDefault();
    var $this   =   jQuery(this);
    if( $this.hasClass('remove-eei') )
    {
        var targetID    =   $this.data('targetid');
        $this.closest('.removeable-image').find('.frontend-image').attr('src', '');
        $this.closest('.removeable-image').find('.lp-uploaded-img').attr('src', '');
        $this.closest('.removeable-image').find('.frontend-input').val('');
        jQuery('#event-old-img-'+targetID).val('');
        $this.remove();
    }
    else
    {
        $this.closest('.removeable-image').find('.frontend-image').attr('src', '');
        $this.closest('.removeable-image').find('.frontend-input').val('');
        $this.remove();
    }
});

/* for listing select2 ajax based booking and services screen */
jQuery(document).ready(function(){
	
	/* for bookings */
	jQuery('#reservaListing').select2({
        ajax: {
            url: ajax_search_term_object.ajaxurl,
            dataType: 'json',
            type:'GET',
            data: function (params) {
                return {
                    q: params.term, // search query
                    action: 'select2_ajax_dashbaord_listing_booking' // AJAX action for admin-ajax.php
                };
                console.log(params);
            },
            processResults: function( data ) {
                var options = [];
                if ( data ) {

                    // data is the array of arrays, and each of them contains ID and the Label of the option
                    jQuery.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
                        options.push( { id: text[0], text: text[1]  } );
                    });

                }
                return {
                    results: options
                };
            },
            cache: true
        },
        minimumInputLength: 3
    });
	/* end for bookings */
	
});

/* end for listing select2 ajax based booking and services screen */


jQuery(document).on('click', '.lp-copy-code', function (e)
{

    e.preventDefault();

    var $this           =   jQuery(this);

    var targetCodeEL    =   jQuery(this).data('target-code'),

        thisHtml        =   jQuery(this).data('html'),

        targetCodeELC   =   '.'+targetCodeEL;





    if( $this.hasClass('close-copy-pop') )

    {
        jQuery(targetCodeELC).animate({
            bottom: '-'+ jQuery(targetCodeELC).height() +'px'

        }, 500, function (e) {

            $this.html(thisHtml);

            $this.removeClass('close-copy-pop');

        });

    }

    else

    {

        var bottomPlus  =   0;

        if( $this.hasClass('lp-discount-btn') )

        {

            bottomPlus  =   49;

        }

        jQuery(targetCodeELC).animate({
            bottom: bottomPlus+'px'
        }, 500, function (e) {
            if( $this.hasClass('lp-discount-btn') )
            {
                $this.addClass('close-copy-pop');
                $this.html('<span><i class="fa fa-times"></i></span>');
            }
        });

    }

});
jQuery(document).on('click', '.close-right-icon', function (e) {
    e.preventDefault();
    var $this  =   jQuery(this),
        target =   '.'+$this.data('target');

    jQuery(target).animate({
        bottom: '-'+jQuery(target).height()+'px'
    });
});
jQuery(document).on('click', '.copy-now', function (e) {

    e.preventDefault();
    var targetCodeEL    =   jQuery(this).data('target-code'),
        targetCodeELC   =   '#'+targetCodeEL;

    jQuery(targetCodeELC).find('input[type="text"]').select();
    document.execCommand("copy");
    jQuery(targetCodeELC).find('.dis-code-copy-pop-inner-cell').find('p:first-child').text(jQuery('.copy-now').data('coppied-label'));
});