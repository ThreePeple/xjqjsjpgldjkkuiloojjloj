! function() {

    // Building count
    var buildingCount = 10;

    // Building switch count
    var buildingSwitchesCountMap = {
        "1": 15,
        "2": 14,
        "3": 21,
        "4": 21,
        "5": 15,
        "6": 15,
        "7": 15,
        "8": 15,
        "9": 15,
        "10": 14
    };

    // Building label
    var buildLabelMap = {
        "1": "A",
        "2": "A",
        "3": "B",
        "4": "B",
        "5": "C",
        "6": "C",
        "7": "D",
        "8": "D",
        "9": "D",
        "10": "D"
    };

    var _repeat = function(count) {
        var tpl = '<div class="building-floor-switch" data-switch-id="{id}"></div>';
        var h = [];
        for (var j = 0; j < count; j++) {
            h.push(tpl.replace("{id}", count - j));
        }
        return h.join('');
    }

    var buildingTemplate = function() {
        var h = [],
            key;
        for (var i = 1; i <= buildingCount; i++) {
            key = i + "";
            h.push('<div data-building-id="' + (i) + '" class="building-unit building-unit-' + i + '" data-switch-count="' + buildingSwitchesCountMap[key] + '">');
            h.push(_repeat(buildingSwitchesCountMap[key]));
            h.push('</div>');
        }
        try {
            return h.join('');
        } finally {
            h = null;
        }
    }();


    var _switchMessageTpl = "<ul>\
								<li><span>楼层:</span> {buildingNo}座{buildingFloor}楼</li>\
			    			</ul>";

    var contentTpl = '<div class="popupBody">' +
        '<div class="popup_close" title="关闭">&nbsp;</div>' +
        '<div class="popup_content" >{content}</div>' +
        '</div>';

    var _buildingInfo = function(tg, e, _switchMessageTpl) {
    	var $tg = $(tg);

    	return _switchMessageTpl.replace( "{buildingFloor}", $tg.data("switch-id"))
    						.replace( "{buildingNo}", buildLabelMap[ $tg.parent().data("building-id") ] ); 
    };

    var _show = function(e) {
    	var tg = e.target;
        var x, y, offset;
        offset = $(tg).offset();
        x = offset.left + $(tg).width();
        y = offset.top;
        var offsetX = 5,
            offsetY = 5;
        var info = _buildingInfo(tg, e, _switchMessageTpl);

        new PopupPanel({
            className: 'switch_message',
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

    $.fn.zsyBuildingChart = function() {
        var _clickBubble = function(e) {
            var $tg = $(e.target);
            if ($tg.is('.building-floor-switch'))
                _show(e);
        };
        this.each(function() {
            $(this).html(buildingTemplate).click(_clickBubble);
        })
    };

}();