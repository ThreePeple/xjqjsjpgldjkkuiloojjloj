/**
 * Created by Shengjun on 15-7-9.
 */
(function() {

    var detailUrl = '/stat/device/ajax-device-tip';

    var alarmImageMap = {
        "router": {
            "2": "/images/icons2/alarm/router.gif"
        },
        "switch": {
            "2": "/images/icons2/alarm/switch.gif"
        },
        "server": {
            "2": "/images/icons2/alarm/server.gif"
        },
        "firewall": {
            "2": "/images/icons2/alarm/firewall.gif"
        },
        "driver": {
            "2": "/images/icons2/alarm/db.gif"
        },
        "wireless": {
            "2": "/images/icons2/alarm/wireless.gif"
        },
        "audio": {
            "2": "/images/icons2/alarm/voice.gif"
        },
        "printer": {
            "2": "/images/icons2/alarm/printer.gif"
        },
        "ups": {
            "2": "/images/icons2/alarm/ups.gif"
        },
        "pc": {
            "2": "/images/icons2/alarm/pc.gif"
        },
        "coreSwitch": {
            "2": "/images/icons2/alarm/core.gif"
        },
        "mainSwitch": {
            "2": "/images/icons2/alarm/mainSwitch.gif"
        }
    };

    var ZSYFCEditorConfig = window.ZSYFCEditorConfig = {
        "ID_KEY": "__id__",
        "singleMode": true,
        "shape": {
            "router": {
                "rx": 19,
                "ry": 19,
                "imgSrc": "/images/icons2/router.png"
            },
            "switch": {
                "rx": 26.5,
                "ry": 20,
                "imgSrc": "/images/icons2/switch.png"
            },
            "server": {
                "rx": 21.5,
                "ry": 31,
                "imgSrc": "/images/icons2/server.png"
            },
            "firewall": {
                "rx": 23,
                "ry": 27,
                "imgSrc": "/images/icons2/firewall.png"
            },
            "driver": {
                "rx": 35,
                "ry": 42,
                "imgSrc": "/images/icons2/db.png"
            },
            "wireless": {
                "rx": 25,
                "ry": 24,
                "imgSrc": "/images/icons2/wireless.gif"
            },
            "audio": {
                "rx": 25,
                "ry": 25,
                "imgSrc": "/images/icons2/voice.png"
            },
            "printer": {
                "rx": 40,
                "ry": 41,
                "imgSrc": "/images/icons2/printer.png"
            },
            "ups": {
                "rx": 40,
                "ry": 41.5,
                "imgSrc": "/images/icons2/ups.png"
            },
            "pc": {
                "rx": 38,
                "ry": 38.5,
                "imgSrc": "/images/icons2/pc.png"
            },
            "coreSwitch": {
                "rx": 32.5,
                "ry": 23,
                "imgSrc": "/images/icons2/core.png"
            },
            "mainSwitch": {
                "rx": 32.5,
                "ry": 23,
                "imgSrc": "/images/icons2/mainSwitch.png"
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
                var id = ZSYFCEditor.getData()[d[ZSYFCEditorConfig['ID_KEY']]]["data"]["id"];
                $.get(detailUrl, {
                    fromWhere: "node",
                    id: id
                }, function(j) {
                    $content.find("div.popup_content").html(j);
                    popPanel.refresh();
                }, 'html');
            }
        }).init().show(x, y);
    };

    var _showPathDetail = function(d, e, contentHtmlTpl) {
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
                $.get(detailUrl, {
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
    var _updateImage = function(shape, shapeType, s) {
        if (s == '1') {
            shape.attr("href", ZSYFCEditorConfig["shape"][shapeType]["imgSrc"]);
        } else {
            shape.attr("href", alarmImageMap[shapeType]["2"]);
        }
    };

    // Ready for startup.
    $(function() { 
        // Render FCEditor
        ZSYFCEditor.init({}, {
            svg: d3.select("svg.ZSYFCEditor"),
            width: 1280,
            height: 940
        });

        ZSYFCEditor.updateCallback(function() {
            var data = ZSYFCEditor.getData();

            d3.selectAll(".element")
                .on("click", function(data) {
                    PopupPanel.clearAll();
                    _showNodeDetail(data, d3.event, _getNodeDetailTpl());
                });

            d3.selectAll("path.node_link")
                .on("click", function(d) {
                    try {
                        PopupPanel.clearAll();
                        var _d = {};
                        _d["from"] = data[d["from"]]["data"]["id"];
                        _d["to"] = data[d["to"]]["data"]["id"];
                        _showPathDetail(_d, d3.event, _getNodeDetailTpl());
                    } catch (e) {
                        console.log(e);
                    }
                }); 

            // Update switch status.
            var keys = Object.keys(data),
                s, imgSrc;
            keys.forEach(function(id) {
                ZSYFCEditor.callFN("shape", id, function() {
                    this.attr("data-status", data[id]['data']["status"]);
                    _updateImage(this, this.node().parentNode.getAttribute("data-shape-type"), data[id]['data']["status"]);
                });
            });

        });

        var pathIdPrefix = "ZSYFCEditor_Path";
        var _updateLinksStatus = function(links) {
            links.forEach(function(link) {
                d3.select('#' + pathIdPrefix + link.from + "_" + link.to).classed("node_link_error", link.status != '1');
            });
        };

        var refreshData = function() {
            $.ajax({
                url: '/topology/dashboard/ajax-links-refresh',
                type: "post",
                data: {
                    "type": 2
                },
                dataType: 'json',
                success: function(res) {
                    if (res.build) {
                        ZSYFCEditor.updateData(res.build);
                        _updateLinksStatus(res.links);
                    }
                    setTimeout(refreshData, 30000);
                }
            });
        };
        refreshData();
    });
})();