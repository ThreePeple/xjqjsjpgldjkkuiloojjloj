$(function(){var ytx={};$('[t_nav]').hover(function(){var _nav=$(this).attr('t_nav');clearTimeout(ytx[_nav+'_timer']);ytx[_nav+'_timer']=setTimeout(function(){$('#'+_nav).stop(true,true).slideDown(200);},150);},function(){var _nav=$(this).attr('t_nav');clearTimeout(ytx[_nav+'_timer']);ytx[_nav+'_timer']=setTimeout(function(){$('#'+_nav).stop(true,true).slideUp(200);},150);});$(".submenu dl").each(function(){var dl_h=$(this).height();$(this).find("dt").height(dl_h);})
    $(".box1 ul li").hover(function(){$(this).find(".unhover").find("i").animate({bottom:-145,opacity:'0'},500);$(this).find(".unhover").find(".txt").animate({left:-125,opacity:'0'},500);$(this).find(".hover").show().find("i").animate({top:0},500);$(this).find(".hover").show().find(".txt").animate({right:0},500);},function(){$(this).find(".unhover").find("i").animate({bottom:0,opacity:'1'},500);$(this).find(".unhover").find(".txt").animate({left:0,opacity:'1'},500);$(this).find(".hover").find("i").animate({top:-125},500);$(this).find(".hover").find(".txt").animate({right:-110},500);})
    var current=$(".index_2 span.txt.current").index();$(".index_2 span.txt").not(".current").hover(function(){var span_index=$(this).index();$(this).addClass("current");$(".txt_desc").find("span").eq(span_index).fadeIn(800).siblings("span").fadeOut(800);},function(){var span_index=$(this).index();$(this).removeClass("current");$(".txt_desc").find("span").eq(span_index).fadeOut(800).siblings("span").eq(current).fadeIn(800);})
    $(".index_4 ul li").hover(function(){var img_src=$(this).find("img").attr("src");var img_name=img_src.substring(7).replace(".png","");$(this).find("img").attr("src","/front/"+img_name+"_hover.png");},function(){var img_src=$(this).find("img").attr("src");var img_name=img_src.substring(7).replace("_hover.png","");$(this).find("img").attr("src","/front/"+img_name+".png");})
    $(".voice_2 ul li").each(function(){var fold=$(this).find(".fold");var unfold=$(this).find(".unfold");if(fold.is(":hidden")){$(this).width(680);}else{$(this).width(100);}})
    $(".voice_2 ul li").click(function(){var li_index=$(this).index();$(this).animate({width:680},200);$(this).find(".unfold").show();$(this).find(".fold").hide();$(this).siblings().animate({width:100},200);$(this).siblings().find(".unfold").hide();$(this).siblings().find(".fold").show();})
    $("div.select_box ul li:even").css("background","#f5f5f5");$("div.select_box").click(function(e){if("readonly"==$(this).attr('readonly')){return false;}
        e.stopPropagation();$(this).children("ul").toggle();$(this).toggleClass("focus");});})/**
 * Created by Shengjun on 15-7-29.
 */