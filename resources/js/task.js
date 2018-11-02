$('.card_content').perfectScrollbar({
    useBothWheelAxes: false,
    suppressScrollX: true
});

$('.card_super_container').perfectScrollbar({
    useBothWheelAxes: false,
    suppressScrollY: true
})

$(document).ready(function () {

    $('.card_super_container').css('height', 'calc(100% - ' + ($('.header').height() + 8) + 'px)');

    var cards = $('.card_content');

    var maxHeight = cards.parent().parent().height() - 30;
    for(var i = 0; i < cards.length; i++) {
        if(cards[i].scrollHeight < maxHeight) {
            cards[i].parentNode.style.height = 'auto';
        }
    }
});