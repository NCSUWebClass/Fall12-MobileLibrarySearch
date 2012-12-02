$(document).ready(function() {

    // Blink fast when we reached this element (post number 4)
    $('#post4').waypoint(function() {
       $(this).fadeOut(300).fadeIn(300);
    }, {
        offset: '50%',  // middle of the page
        triggerOnce: true
    });

    // ajaxy content
    var $loading = $("<div class='loading'><p>Loading more items ...</p></div>"),
    $footer = $('footer'),
    opts = {
        offset: '100%'
    };
    $footer.waypoint(function(event, direction) {
        $footer.waypoint('remove');
        $('.example').append($loading);
        $.get($('.more a').attr('href'), function(data) {
            var $data = $(data);
            $('#container').append($data.find('.post'));
            $loading.detach();
            if ($data.find('.more').length) {
                $('.more').replaceWith($data.find('.more'));
                $footer.waypoint(opts);
            } else {
                $('.more').parent().remove();
            }
        });
    }, opts);


    // nav menu
    $('#nav-holder').waypoint(function(event, direction) {
        $(this).parent().toggleClass('sticky', direction === "down");
        event.stopPropagation();
    });

    // goto 'Top' button
    $('.top').addClass('hidden');
    $.waypoints.settings.scrollThrottle = 25;
    $('.example').waypoint(function(event, direction) {
        $('.top').toggleClass('hidden', direction === "up");
    }, {
        offset: '-100%'
    });

});