/**
 * Created by jsj on 15/8/18.
 */

var __detailUrl = '/stat/device/ajax-device-tip';

function renderChart(id1, id2) {
    var __data;

    $.ajax({
        url: '/topology/dashboard/ajax-get-hub',
        data: {
            "id1": id1,
            "id2": id2
        },
        type: "POST",
        dataType: 'JSON',
        success: function(res) {
            if (res.status) {
                //console.log("refresh content.");
                $("#ZSYPolymerChart").find(">*").filter(":not(defs)").remove();
                __data = res.data;
                ZSYPolymerChart.init({
                    data: __data,
                    svgWidth: 1200,
                    svgHeight: 1000,
                    polymerWidth: 110,
                    groupsHPadding: 70
                });
                ZSYPolymerChart.render();
                readyChartCallback(__data);
            }
        }
    });

}

function changeCore(group, id1, id2) {
    $("#events_type button[group='" + group + "']").removeClass("btn-primary").addClass("btn-default");
    $("#events_type button[group='" + (group + 1 > 2 ? 1 : group + 1) + "']").removeClass("btn-default").addClass("btn-primary");
    renderChart(id1, id2)
}
var __updateStatus = function(data) {
    var groups = data["groups"];
    var links = data["links"];
    var keys;

    Object.keys(groups).forEach(function(group) {
        groups[group].forEach(function(d) {
            d3.select("#" + d["id"]).attr("data-status", d["status"]);
        });
    })

    var from, to, status;
    links.forEach(function(link) {
        from = link["from"];
        to = link["to"];
        status = link["status"];
       // console.log([to, '_', from].join(''),status)
        d3.select('#' + [to, '_', from].join('')).attr("data-status", status);
    });
};

var _showPathDetail = function(d, e, contentHtmlTpl) {  
    var $tg = $(e.target); 

    var offset = $tg.offset();
    var x = offset.left,
        y = offset.top;

    var contentTpl = '<div class="popupBody">' +
        '<div class="popup_close" title="鍏抽棴">&nbsp;</div>' +
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
            $.get(__detailUrl, {
                fromWhere: "path",
                from: d["from"],
                to: d["to"]
            }, function(j) {
                $content.find("div.popup_content").html(j);
                popPanel.refresh();  
            }, 'html');
        }
    }).init().show(x, y);
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
            var id = d["data"]["id"],
                device_id = d["data"]["device_id"];
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


function readyChartCallback(__data) {
    //console.log(__data)
    d3.selectAll(".ZSYPolymerChart g.node text")
        .on("click", function(data) {
            PopupPanel.clearAll();
            _showNodeDetail(data, d3.event, "");
        });

    d3.selectAll(".ZSYPolymerChart path.link-path")
            .on("click", function(d) {
                PopupPanel.clearAll();
                var _d = {};
                _d["from"] = d["linkFrom"];
                _d["to"] = d["linkTo"]; 
                _showPathDetail(_d, d3.event);
            });  

    if (__data) {
       // __updateStatus(__data);
    }
}

//定时切换分组
var changeFlag = true;
var curr_group=1;
function changeGroup(){
    var count = $('#events_type').find('.group').length;
    setTimeout(function(){
        if(changeFlag){
            curr_group++;
            if(curr_group >count){
                curr_group = curr_group-count;
            }

            $('#events_type').find('button[group="'+curr_group+'"]').trigger('click');
        }
        changeGroup();
    },10000)
}
$(document).ready(function(){
    $('#changeBtn').click(function(){
        changeFlag = !changeFlag;
        if(changeFlag){
            $(this).text('定时切换(开)');
        }else{
            $(this).text('定时切换(关)');
        }
    });
})