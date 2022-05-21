function myMenu() {
    var x = document.getElementById("myMenu");
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}
//carousel
$(document).ready(function() {
    $('.owl-slider').owlCarousel({
        margin: 0,
        autoplay: true,
        autoplayTimeout: 10000,
        nav: false,
        dots: true,
        loop: true,
        items: 1,
    });
    $('.owl-produtos').owlCarousel({
        margin: 0,
        autoplay: false,
        autoplayTimeout: 5000,
        nav: false,
        dots: true,
        loop: true,
        items: 1,
    });
    $('.owl-one').owlCarousel({
        margin: 0,
        autoplay: true,
        autoplayTimeout: 7000,
        nav: false,
        dots: true,
        loop: true,
        items: 4,
        responsive: {
            0: { items: 1, dots: true },
            600: { items: 3, dots: true },
            1000: {
                items: 4,
                dots: true
            }
        }
    });
});
//menu fixo
$(window).on('scroll', function() {
    if ($(window).scrollTop() > 350) {
        $('#topo').attr('style', 'position: fixed; top: 0; z-index: 9999;');
        $('#topo').addClass('bg-custom');
        $('#header').attr('style', 'position: fixed; background: #fff; top: 30px;');
        $('.menu-mobile-box').attr('style', 'top: 20px; position: relative;');
    } else {
        $('#topo').attr('style', 'position: relative;');
        $('#topo').removeClass('bg-custom');
        $('#header').attr('style', 'position: absolute; ');
        $('.menu-mobile-box').attr('style', 'top: 0px; position: relative;');
    }
});

// light-gallery 
//$('.image-gallery').each(function() {
//    var selector = $(this),
//        popup = selector.find('.gallery-icon > a');
//    selector.lightGallery({
//        selector: popup,
//        share: false,
//        pager: false,
//    });
//});

// descrição produto scroll 
$(window).on('scroll', function() {
    if ($(window).scrollTop() > 650 && $(window).width() > 580) {
        $('.product-details').attr('style', 'display: none;');
    } else {
        $('.product-details').attr('style', 'display: block;');
    }
});

//fade in
var root = document.documentElement;
root.className += ' js';

function boxTop(idBox) {
    var boxOffset = $(idBox).offset().top;
    return boxOffset;
}

$(document).ready(function() {
    var $target = $('.anime'),
        animationClass = 'anime-init',
        windowHeight = $(window).height(),
        offset = windowHeight - (windowHeight / 4);

    function animeScroll() {
        var documentTop = $(document).scrollTop();
        $target.each(function() {
            if (documentTop > boxTop(this) - offset) {
                $(this).addClass(animationClass);
            } else {
                $(this).removeClass(animationClass);
            }
        });
    }
    animeScroll();
    $(document).scroll(function() {
        animeScroll();
    });
});
var root = document.documentElement;
root.className += ' js';

function boxTop(idBox) {
    var boxOffset = $(idBox).offset().top;
    return boxOffset;
}

$(document).ready(function() {
    var $target = $('.anime-down'),
        animationClass = 'anime-init',
        windowHeight = $(window).height(),
        offset = windowHeight - (windowHeight / 4);

    function animeScroll() {
        var documentTop = $(document).scrollTop();
        $target.each(function() {
            if (documentTop > boxTop(this) - offset) {
                $(this).addClass(animationClass);
            } else {
                $(this).removeClass(animationClass);
            }
        });
    }
    animeScroll();
    $(document).scroll(function() {
        animeScroll();
    });
});



$('.nav-tabs').click(function() {
    $('.nav-tabs > li > a').addClass('active')
    $(this).find('li > a').removeClass('active')
});