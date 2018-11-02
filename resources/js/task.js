$('.card_content').perfectScrollbar();
$('.card_content').perfectScrollbar("update");

$(document).ready(function () {

    $('.card_super_container').css('height', 'calc(100% - ' + ($('.header').height() + 8) + 'px)');

    var cards = $('.card_content');

    var maxHeight = cards.parent().parent().height() - 30;
    for(var i = 0; i < cards.length; i++) {
        if(cards[i].scrollHeight < maxHeight) {
            cards[i].parentNode.style.height = 'auto';
        }
        console.log(cards[i].scrollHeight < maxHeight);
    }
});