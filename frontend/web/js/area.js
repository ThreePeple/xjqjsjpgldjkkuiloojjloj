/**
 * Created by jsj on 15/8/17.
 */

var showLinkDetail = function(detailUrl,params,areaType){

    var id = params["edges"][0];
    var offset = params.pointer.DOM;
    var x = offset.x,
        y = offset.y;

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
        $.get(detailUrl, {
            id: id,
            type: areaType
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
}

