(function($) {
    $(document).ready(function(){
        $('.anim-scroll').click(function(){
            scrollto_c($(this).attr('href'));
            return false;
        });

        $('.b-catlist__header').click(function(){
            var parent = $(this).parent();
            if(parent.hasClass('open')){
                $(this).siblings('.b-catlist__list').stop().slideUp('fast', function(){
                    parent.removeClass('open');
                });
            } else {
                $(this).siblings('.b-catlist__list').stop().slideDown('fast', function(){
                    parent.addClass('open');
                });
            }
            return false;
        });
        $('a', '.b-catlist__header').click(function(){
            event.cancelBubble = true;
        });

        $('.b-contacts__map-link').click(function(){
            return false;
        });

        $('input, textarea').placeholder();
    });

    $(window).load(function() {
        $('.b-slider').flexslider({
            controlNav: true,
            directionNav: false,
            prevText: "",
            nextText: ""
        });
    });

    /*
    * Плавная прокрутка
    *
    * param {string} Id объекта к которому нужно скролить
    * */
    function scrollto_c(elem){
        $('html, body').animate({
            scrollTop: $(elem).offset().top
        }, 500);
    }
}(jQuery));