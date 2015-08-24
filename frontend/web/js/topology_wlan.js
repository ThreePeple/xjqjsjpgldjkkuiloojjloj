/**
 * Created by Shengjun on 15-7-9.
 */
( function () { 
   
    var detailUrl = '/stat/device/ajax-node-tip';

    var _showNodeDetail = function(id, e ) { 
        var $tg = $(e.target); 

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
                $.get(detailUrl, {
                    id: id
                }, function(j) {
                    $content.find("div.popup_content").html(j);
                    popPanel.refresh(); 
                }, 'html');
            }
        }).init().show(x, y);
    };  

    // Dom Ready 
    $(function(){ 

        $('#wireNetworkHolder').click( function (e){
            var $tg = $(e.target);
            var id;
            if($tg.is(".element_link path") ){
                id = $tg.closest(".element_link").attr("id"); 
            } else if($tg.is(".element_node>div")){
                id = $tg.closest(".element_node").attr("id"); 
            }

            id && _showNodeDetail(id, e);
        });

        var _updateData = function (map){ 
            Object.keys(map).forEach( function (id) { 
                $("#" + id).attr("data-status", map[id]["status"]);
            } ); 
        }; 

        var refreshData = function(){
            $.ajax({
                url:'/topology/dashboard/ajax-wlan-refresh',
                type:"post",
                data:{"type":2},
                dataType:'json',
                success:function(res){
                    if(res){
                        _updateData(res);
                    }
                    setTimeout(refreshData,30000);
                }
            });
        };

        refreshData();
    });

} )();