/**
 * Created by Shengjun on 15-7-9.
 */
( function () { 
   
    var detailUrl = '/stat/wireless/ajax-device-tip';

    var switchStatusImg = {
        '-1': "/images/building_switch_status2/s-1.gif",
        '0': "/images/building_switch_status2/s0.gif",
        '1': "/images/building_switch_status2/s1.gif",
        '2': "/images/building_switch_status2/s2.gif",
        '3': "/images/building_switch_status2/s3.gif",
        '4': "/images/building_switch_status2/s4.gif",
        '5': "/images/building_switch_status2/s5.gif"
    };

    var ZSYFCEditorConfig = window.ZSYFCEditorConfig = {
        "ID_KEY": "__id__",
        "singleMode": true,
        "shape": { 
            "ac": {
                "rx": 19,
                "ry": 19,
                "imgSrc": "/images/icons3/ac.png" 
            },
            "switch": {
                "rx": 42.5,
                "ry": 32.5,
                "imgSrc": "/images/icons3/mainSwitch.png"
            },
            "server": {
                "rx": 17,
                "ry": 25,
                "imgSrc": "/images/icons3/server.png"
            },
            "firewall": {
                "rx": 19,
                "ry": 18,
                "imgSrc": "/images/icons3/firewall.png"
            }, 
            "wireless": {
                "rx": 25,
                "ry": 24,
                "imgSrc": "/images/icons3/ap.png"
            },
            "coreSwitch":{
                "rx": 26.5,
                "ry": 27.5,
                "imgSrc": "/images/icons3/core.png"
            }
        }

    }; 



 var _getNodeDetailTpl = function() {
        var tmp = null;
        return function() {
            if (!tmp) {
                tmp = $('#switch_node_detail').html();
            }
            return tmp;
        };
    }();

    var _showNodeDetail = function(d, e, contentHtmlTpl) { 
        var $tg = $(e.target);
        if (false == $tg.is(".element")) {
            $tg = $tg.closest(".element");
        }
        $tg = $tg.find(".shape");

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
                var id  = ZSYFCEditor.getData()[ d[ ZSYFCEditorConfig['ID_KEY'] ] ]["data"]["id"];
                $.get(detailUrl, {
                    id: id
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


    // Dom Ready 
    $(function(){ 

 
        // Render FCEditor
        ZSYFCEditor.init(
            {},
            {
                svg: d3.select("svg.ZSYFCEditor"),
                width: 1440,
                height: 800
            } 
        ); 

        ZSYFCEditor.updateCallback( function(){

            d3.selectAll(".element") 
            .on("mouseover", function(data) {
                PopupPanel.clearAll();
                _showNodeDetail(data, d3.event, _getNodeDetailTpl());
            }).on("click", function(data){
                var id  = ZSYFCEditor.getData()[ data[ ZSYFCEditorConfig['ID_KEY'] ] ]["data"]["id"];
                 window.open("/stat/wireless/detail?id=" + id, "wlan-node-detail");
            });  

             return;


            // Update switch status.
            var data = ZSYFCEditor.getData();
            var keys = Object.keys( data ), s, imgSrc; 
            keys.forEach( function ( id ){
                ZSYFCEditor.callFN("shape", id, function (){
                    s = data[id]['data'] ? data[id]['data']["status"] ? data[id]['data']['status'] : '-1' : '-1';
                    imgSrc = switchStatusImg[s] ? switchStatusImg[s] : switchStatusImg['-1'];
                    //alert(imgSrc);
                    this.attr( "href", imgSrc );
                });
            });
            
        } ); 




        var refreshData = function(){
            $.ajax({
                url:'/topology/dashboard/ajax-refresh',
                type:"post",
                data:{"type":3},
                dataType:'json',
                success:function(res){
                    if(res.build){
                        ZSYFCEditor.updateData(res.build);
                    }
                    setTimeout(refreshData,30000);
                }
            });
        };
        refreshData();
    });

} )();