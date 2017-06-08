$(document).ready(function() {
    $('#index-hero-carousel').jcarousel({
        scroll: 1,
        auto: 3,
        wrap: "last",
        buttonNextHTML: null,
        buttonPrevHTML: null,
        initCallback: function(b) {
            $('#index-hero-control .index-hero-number').bind('click',
            function(a) {
                a.preventDefault();
                b.scroll($.jcarousel.intval($(this).text()));
                $(this).parent().siblings('.over').animate({
                    width: 37
                },
                280,
                function() {
                    $(this).removeClass('over')
                });
                $(this).parent().animate({
                    width: 280
                },
                280,
                function() {
                    $(this).addClass('over')
                })
            })
        },
        itemVisibleInCallback: {
            onBeforeAnimation: function(a, b, i) {
                var c = $('#index-hero-control li.over');
                var d = $('#index-hero-control li').eq(i - 1);
                if (c !== d) {
                    c.animate({
                        width: 37
                    },
                    280,
                    function() {
                        $(this).removeClass('over')
                    });
                    d.animate({
                        width: 280
                    },
                    280,
                    function() {
                        $(this).addClass('over')
                    })
                }
            }
        }
    });    
});