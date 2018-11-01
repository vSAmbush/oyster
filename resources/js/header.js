var angle;

function rotation(object, side, speed = 3) {

    object.css({
        '-webkit-transform' : 'rotate(' + angle + 'deg)',
        '-o-transform' : 'rotate(' + angle + 'deg)',
        '-moz-transform' : 'rotate(' + angle + 'deg)',
        '-ms-transform' : 'rotate(' + angle + 'deg)',
        'transform' : 'rotate(' + angle + 'deg)'
    });

    if(side && angle < 0)
        angle += speed;
    else
        if(angle > -90)
            angle -= speed;
}

/**
 * Stopping interval, because every click creates new interval, which fasts animation and works in every .complex object
 * @param id
 */
function stop(id) {
    clearInterval(id);
}

function checkSubNavigations(object) {

    $('.sub-navigation').hide();

    var flag = false;

    $('.complex').find('i').each(function () {
        if($(this).hasClass('rotated') && object[0] !== $(this)[0]) {
            angle = 0;
            var timerId = setInterval(rotation, 1, $(this), false, 5);
            $(this).removeClass('rotated');
            flag = true;

            setTimeout(stop, 150, timerId);
        }
    });

    return flag;
}

function animate(object) {
    var obj = object.find('i');
    var menu = object.parent().find('.sub-navigation');
    var timerId;

    /**
     * Setting the width of sub-nav equals nav-item if first is less
     */
    if(menu.outerWidth() < object.innerWidth())
        menu.css({
           'width': object.innerWidth() - 2
        });

    if (obj.hasClass('rotated')) {
        angle = 0;
        timerId = setInterval(rotation, 1, obj, false);
        obj.removeClass('rotated');

        object.parent().find('.sub-navigation').hide();
    }
    else {
        angle = -90;
        timerId = setInterval(rotation, 1, obj, true);
        obj.addClass('rotated');

        object.parent().find('.sub-navigation').show();
    }
    setTimeout(stop, 250, timerId);
}

$('.complex').on('click', function (e) {

    if(checkSubNavigations($(this).find('i')))
        setTimeout(animate, 200, $(this));
    else
        animate($(this));
});

/**
 * Need when user reload page and scroll not on the start value
 */
$(document).ready(function () {
    $('.pseudo-header').height($('.header').outerHeight());

    $(window).scroll();
});

/**
 * Needs to avoid leaps
 */
var prevScroll = 0;
$(window).scroll(function (e) {

    var header = $('.header'),
        scroll = $(this).scrollTop();

    if(scroll > 0) {

        $('.pseudo-header').show();
        header.addClass('fixed');
        if(scroll - prevScroll > 30) {
            $(this).scrollTop(prevScroll);
        }
        prevScroll = scroll;
    } else {

        header.removeClass('fixed');
        $('.pseudo-header').hide();
    }
});
