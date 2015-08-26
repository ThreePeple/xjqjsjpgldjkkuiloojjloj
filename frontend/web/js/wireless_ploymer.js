/**
 * Created by jsj on 15/8/18.
 */

var __detailUrl = '/stat/wireless/ajax-device-tip';

function renderChart(url,params){
    var __data;
    $.ajax({
        url : url,
        data: params,
        type:"POST",
        dataType:'JSON',
        success:function(res){
            if(res.status){
                $("#ZSYPolymerChart").find(">*").filter(":not(defs)").remove();
                __data = res.data;
                ZSYPolymerChart.init({data: __data, svgWidth:1300, svgHeight: 1000});
                ZSYPolymerChart.render();
                readyChartCallback(__data);
            }
        }
    });

}

function changeArea(id){
    $("#events_type button[id="+id+"]]").removeClass("btn-primary").addClass("btn-default");
    $("#events_type button[id="+id+"]]").removeClass("btn-default").addClass("btn-primary");
    renderChart('/topology/dashboard/ac-ap',{id:id})
}

var __updateStatus = function ( data ){
    var groups = data["groups"];
    var links = data["links"];
    var keys;

    Object.keys(groups).forEach( function ( group ){
        groups[group].forEach( function ( d ) {
            d3.select("#" + d["id"] ).attr("data-status", d["status"]);
        } );
    } )

    var from, to, status;

    links.forEach( function ( link ){
        from = link["from"];
        to = link["to"];
        status = link["status"];
        d3.select( '#' + [ to, '_', from ].join('') ).attr("data-status", status);
    } );
};


var _showNodeDetail = function(d, e, contentHtmlTpl) { 
    var $tg = $(e.target);
    if (false == $tg.is(".node")) {
        $tg = $tg.closest(".node");
    } 

    var offset = $tg.offset();
    var x = offset.left,
        y = offset.top;

    var contentTpl = '<div class="popupBody">' +
        '<div class="popup_close" title="关闭">&nbsp;</div>' +
        '<div class="popup_content" >{content}</div>' +
        '</div>';

    var offsetX = 90,
        offsetY = 65;
    
    var className = "nodeDetail";

    var _parseData = function(data) {
        if (data) {
            for (var p in data) {
                contentHtmlTpl = contentHtmlTpl.replace('{' + p + '}', data[p]);
            }
            return contentHtmlTpl;
        }
        return "<span class='none'>No data.</span>";
    };
    var _updateContent = function(html) {
        return contentTpl.replace("{content}", html);
    };
    var popPanel = new PopupPanel({
        className: 'modalessDialog' + (className ? " " + className : ""),
        offsetX: offsetX,
        offsetY: offsetY,
        destroy: true,
        animate: false,
        closeHandler: function() {},
        content: contentTpl,
        initInterface: function($content) {
            var inst = this;
            $content.click(function(e) {
                if ($(e.target).is('div.popup_close'))
                    inst.close(true);
            });

            $content.find("div.popup_content").html(_updateContent("loading...")); 
            // nodeDetail_.json : fail data, nodeDetail.json: ok data.
            var id  = d["data"]["id"], device_id = d["data"]["device_id"];
            $.get(__detailUrl, {
                id: device_id,
                device_id: device_id
            }, function(j) {
                $content.find("div.popup_content").html(j);
                popPanel.refresh(); 
                return;
                if (j.result == 1) {
                    $content.find("div.popup_content").html(_updateContent(_parseData(j.data)));
                } else {
                    $content.find("div.popup_content").html(_updateContent(j.msg));
                }
                popPanel.refresh();
            }, 'html');
        }
    }).init().show(x, y);
}; 


function readyChartCallback(__data){
    d3.selectAll(".ZSYPolymerChart g.node text") 
    .on("click", function(data) { 
        PopupPanel.clearAll();
        _showNodeDetail(data, d3.event, "");
    });  
    if(__data){
        __updateStatus(__data);
    }
}
