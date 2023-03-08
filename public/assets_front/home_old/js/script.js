(function($) {
    
    "use strict";

    // ==================== Preloader
    function preloader_load() {
        if($('.preloader').length){
            $('.preloader').delay(300).fadeOut(500);
        }
    }



    // Funfact script
    $('.start-count').each(function() {
        var $this = $(this);
        $this.data('target', parseInt($this.html()));
        $this.data('counted', false);
        $this.html('0');
    });
    $(window).bind('scroll', function() {
        var speed = 3000;
        $('.start-count').each(function() {
            var $this = $(this);
            if (!$this.data('counted') && $(window).scrollTop() + $(window).height() >= $this.offset().top) {
                $this.data('counted', true);
                $this.animate({
                    dummy: 1
                }, {
                    duration: speed,
                    step: function(now) {
                        var $this = $(this);
                        var val = Math.round($this.data('target') * now);
                        $this.html(val);
                        if (0 < $this.parent('.value').length) {
                            $this.parent('.value').css('width', val + '%');
                        }
                    }
                });
            }
        });
    }).triggerHandler('scroll');



    // ==================== Navbar Scroll To Fixed
        $('.scrollingto-fixed').scrollToFixed();
        var summaries = $('.summary');
        summaries.each(function(i) {
            var summary = $(summaries[i]);
            var next = summaries[i + 1];
            summary.scrollToFixed({
                marginTop: $('.scrollingto-fixed').outerHeight(true) + 10,
                limit: function() {
                    var limit = 0;
                    if (next) {
                        limit = $(next).offset().top - $(this).outerHeight(true) - 10;
                    } else {
                        limit = $('.footer').offset().top - $(this).outerHeight(true) - 10;
                    }
                    return limit;
                },
                zIndex: 999
            });
        });

    // Header animation on scroll
    window.addEventListener('scroll', function(e){
            var distanceY = window.pageYOffset || document.documentElement.scrollTop,
                shrinkOn = 50,
                header = document.querySelector("header");
            if (distanceY > shrinkOn) {
                classie.add(header,"smaller");
            } else {
                if (classie.has(header,"smaller")) {
                    classie.remove(header,"smaller");
                }
            }
    });


    // ==================== Gallery Masonry Isotop And Other Gallery and Lightbox
    function masonryIsotop() {
        if ($('.masonry-gallery').length) {
            $('.masonry-gallery').isotope({
                layoutMode:'masonry'
            });
        }
        if($('.masonry-filter').length){
            $('.masonry-filter a').children('span').on('click', function(){
                var Self = $(this);
                var selector = Self.parent().attr('data-filter');
                $('.masonry-filter a').children('span').parent().removeClass('active');
                Self.parent().addClass('active');
                $('.masonry-gallery').isotope({ filter: selector });
                return false;
            });
        }
        
        //LighvtBox / Fancybox
        if($('.lightbox-image').length) {
              $('.lightbox-image').fancybox();
            }

    }


    // ==================== Parallax Backgrounds
    $.stellar({
       horizontalScrolling: false,
       responsive: true
    });

    // ==================== Price range slider
    

    // Owl carousel - Testimonial
    if($('.testimonial-carousel').length){
        $('.testimonial-carousel').owlCarousel({
            loop:true,
            margin:30,
            dots: true,
            nav:false,
            autoplayHoverPause:false,
            autoplay: true,
            smartSpeed: 700,
            responsive: {
                0: {
                    items: 1,
                    center: false
                },
                480:{
                    items:1,
                    center: false
                },
                600: {
                    items: 1,
                    center: false
                },
                768: {
                    items: 1
                },
                992: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            }
        })
    }

    // Owl carousel - Client
    if($('.client-carousel').length){
        $('.client-carousel').owlCarousel({
            loop:true,
            margin:120,
            dots: false,
            nav:false,
            autoplayHoverPause:false,
            autoplay: true,
            smartSpeed: 700,
            responsive: {
                0: {
                    items: 2,
                    margin:80
                },
                480:{
                    items:3,
                    margin:80
                },
                600: {
                    items: 4,
                    margin:80
                },
                768: {
                    items: 4,
                    margin:80
                },
                992: {
                    items: 5
                },
                1200: {
                    items: 5
                }
            }
        })
    }

    // Video popup
    jQuery("a.video-popup").YouTubePopUp();



    // ==================== Scroll To top
    $(function () {
            $.scrollUp({
                scrollName: 'scrollUp', 
                scrollDistance: 300,       
                scrollFrom: 'top',          
                scrollSpeed: 700,           
                easingType: 'linear',   
                animation: 'fade',      
                animationSpeed: 200,      
                scrollTrigger: false,     
                scrollTarget: false,
                scrollImg: true,      
                scrollText: '', 
                scrollTitle: false,   
                scrollImg: false,   
                activeOverlay: false,
                zIndex: 2147483647, 
            });
        });


    
/* ==========================================================================
   When document is loading, do
   ========================================================================== */

    $(window).on('load', function() {
        // add your functions
        preloader_load();
        masonryIsotop();
    }); 



})(window.jQuery);