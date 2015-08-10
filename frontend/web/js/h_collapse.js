$(function() {
    $(".voice_2 ul li").click(function() {
        var li_index = $(this).index();
        var li_count = $(".voice_2>ul>li").length;
        var width = $(".voice_2").width() - 100*(li_count-1);
        $(this).animate({
                width: width
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