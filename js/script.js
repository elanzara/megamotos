function include(url) {
    document.write('<script src="' + url + '"></script>');
    return false;
}

/* cookie.JS
 ========================================================*/
include('js/jquery.cookie.js');


/* DEVICE.JS
 ========================================================*/
include('js/device.min.js');

/* Stick up menu
 ========================================================*/
include('js/tmstickup.js');
$(window).load(function () {
    if ($('html').hasClass('desktop')) {
        $('#stuck_container').TMStickUp({
        })
    }
});

/* Easing library
 ========================================================*/
include('js/jquery.easing.1.3.js');

/* ToTop
 ========================================================*/
include('js/jquery.ui.totop.js');
$(function () {
    $().UItoTop({ easingType: 'easeOutQuart' });
});


/* DEVICE.JS AND SMOOTH SCROLLIG
 ========================================================*/
include('js/jquery.mousewheel.min.js');
include('js/jquery.simplr.smoothscroll.min.js');
$(function () {
    if ($('html').hasClass('desktop')) {
        $.srSmoothscroll({
            step: 150,
            speed: 800
        });
    }
});

/* Copyright Year
 ========================================================*/
var currentYear = (new Date).getFullYear();
$(document).ready(function () {
    $("#copyright-year").text((new Date).getFullYear());
});


/* Superfish menu
 ========================================================*/
include('js/superfish.js');

/* Parallax
 ========================================================*/
include('js/jquery.parallax-1.1.3.js');
$(document).ready(function () {
    if ((obj = $('.parallax')).length > 0 && $('html').hasClass('desktop')) {
        obj.parallax("50%");
    }
});


/* Google Map
 ========================================================*/
$(window).load()
{
    if ($('#google-map').length > 0) {
        var styles = [
                {
                    "stylers": [
                        { "saturation": -100 }
                    ]
                }, {
                    "featureType": "water",
                    "stylers": [
                        { "lightness": -88 }
                    ]
                }, {
                    "featureType": "landscape",
                    "stylers": [
                        { "lightness": -18 }
                    ]
                }
        ];

        var mapOptions = {
            zoom: 14,
            center: new google.maps.LatLng(parseFloat(40.646197), parseFloat(-73.9724068, 14)),
            scrollwheel: false,
            styles: styles
        }
        new google.maps.Map(document.getElementById("google-map"), mapOptions);
    }
}

/* Orientation tablet fix
 ========================================================*/
$(function () {
    // IPad/IPhone
    var viewportmeta = document.querySelector && document.querySelector('meta[name="viewport"]'),
        ua = navigator.userAgent,

        gestureStart = function () {
            viewportmeta.content = "width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0";
        },

        scaleFix = function () {
            if (viewportmeta && /iPhone|iPad/.test(ua) && !/Opera Mini/.test(ua)) {
                viewportmeta.content = "width=device-width, minimum-scale=1.0, maximum-scale=1.0";
                document.addEventListener("gesturestart", gestureStart, false);
            }
        };

    scaleFix();
    // Menu Android
    if (window.orientation != undefined) {
        var regM = /ipod|ipad|iphone/gi,
            result = ua.match(regM);
        if (!result) {
            $('.sf-menu li').each(function () {
                if ($(">ul", this)[0]) {
                    $(">a", this).toggle(
                        function () {
                            return false;
                        },
                        function () {
                            window.location.href = $(this).attr("href");
                        }
                    );
                }
            })
        }
    }
});
var ua = navigator.userAgent.toLocaleLowerCase(),
    regV = /ipod|ipad|iphone/gi,
    result = ua.match(regV),
    userScale = "";
if (!result) {
    userScale = ",user-scalable=0"
}
document.write('<meta name="viewport" content="width=device-width,initial-scale=1.0' + userScale + '">')

/* Greensock
 ========================================================*/
include('js/greensock/TweenMax.min.js');
include('js/greensock/TimelineMax.min.js');


/* Paw
 ========================================================*/
include('js/paw/paw-0.0.1.js');
$(window).load(function () {
    var paw = new Paw();

    $('.sf-menu a').pawInk();
    if ($('.camera_pag li').length) {
        $('.camera_pag li').pawInk();
    }
});

/* Unveil
 ========================================================*/
include('js/jquery.unveil.js');
$(window).load(function () {
    var isIE = function () {
        var myNav = navigator.userAgent.toLowerCase();
        return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
    };

    $('.lazy-img img').unveil(0, function () {            
        if (isIE() && isIE() < 9) {
            $(this).load().addClass("lazy-loaded").parent().find('.paw-spin-container').fadeOut("slow", function () {
                this.parentNode.removeChild(this);
            });
        } else {
            $(this).load(function () {
                $(this).addClass("lazy-loaded");
                $(this).parent().find('.paw-spin-container').fadeOut("slow", function () {
                    this.parentNode.removeChild(this);
                });
            })
        }       
    });
});


/* Custom Scripts
 ========================================================*/
$(document).ready(function () {
    var obj;

    if ((obj = $('#camera')).length > 0) {
        obj.camera({
            autoAdvance: false,
            height: '38.53658536585366%',
            minHeight: '424px',
            pagination: true,
            thumbnails: false,
            playPause: false,
            hover: false,
            loader: 'none',
            navigation: false,
            navigationHover: false,
            mobileNavHover: false,
            fx: 'simpleFade',

        })
    }


    if ((obj = $('.thumb')).length > 0) {
        obj.fancybox()
            .fancybox({
                openEffect: 'none',
                closeEffect: 'none',
                prevEffect: 'none',
                nextEffect: 'none',

                arrows: false,
                helpers: {
                    media: {},
                    buttons: {}
                }
            });
    }


});
