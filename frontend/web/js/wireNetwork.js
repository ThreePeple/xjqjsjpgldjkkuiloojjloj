! function() { 

    var deviceInfo = {
        "d5": "<ul><li>设备名称: 交换机A132-1</li><li>设备ID: S023482382</li><li>告警类型: Error</li><li>性能告警: 是</li><li>发生时间: 2015/7/9 19:30</li><li>当前区域: A区</li></ul>",
        "d3": "<ul><li>IP地址: 10.200.36.36</li><li>服务器类型: Windows</li><li>操作系统: Windows Server</li></ul>"
    };

    var contentTpl = '<div class="popupBody">' +
        '<div class="popup_close" title="关闭">&nbsp;</div>' +
        '<div class="popup_content" >{content}</div>' +
        '</div>';

    var _show = function(e,id) {
        var tg = e.target;
        var x, y, offset;
        offset = $(tg).offset();
        x = offset.left + $(tg).width();
        y = offset.top;
        var offsetX = 5,
            offsetY = 5;
        
        var info = deviceInfo[id];

        new PopupPanel({
            className: 'wirenetwork_message',
            forceOptPosition: ["!right", "!top"],
            offsetX: offsetX,
            offsetY: offsetY,
            destroy: true,
            closeHandler: function() {},
            content: contentTpl.replace( "{content}", info ),
            initInterface: function($content) {
                var inst = this;

                // close popup
                $content.find('div.popup_close').click(function() {
                    inst.close(true);
                });

            }
        }).init().show(x, y);
    };

    var _initDeviceInfo = function(container){
        var h = '<div data-id="d5" class="device-slot error"></div><div data-id="d3" class="device-slot normal"></div>';
        $(container).html( h ).click( _clickBubble  );
    };

    var _clickBubble = function( e ){
        var $tg = $(e.target);
        if($tg.is(".error")){
            _show(e, $tg.data("id"));
        } else if( $tg.is(".normal") ){
            _show(e, $tg.data("id"));
        }

    };
    
    $.fn.zsyWireNetworkChart = function() { 
        this.each(function() { 
            _initDeviceInfo( this );
        })
    };

}();