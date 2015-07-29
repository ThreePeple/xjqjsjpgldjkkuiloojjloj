$(function() {
    $(".voice_2 ul li").click(function() {
        var li_index = $(this).index();
        $(this).animate({
                width: 880
            },
            200);
        $(this).find(".unfold").show();
        $(this).find(".fold").hide();
        $(this).siblings().animate({
                width: 100
            },
            200);
        $(this).siblings().find(".unfold").hide();
        $(this).siblings().find(".fold").show();
    })
})