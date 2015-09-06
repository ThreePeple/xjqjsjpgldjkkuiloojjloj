/**
 * Created by Shengjun on 15-7-9.
 */
( function () { 
   
    var detailUrl = '/stat/wireless/ajax-device-tip'; 

    //var mainLinkDetailUrl = '/stat/wireless/ajax-link-tip';

    var alarmImageMap = { 
        "ac": { 
            "2": "/images/icons3/alarm/ac.gif" 
        },
        "switch": { 
            "2": "/images/icons3/alarm/switch.gif"
        },
        "server": { 
            "2": "/images/icons3/alarm/server.gif"
        },
        "firewall": { 
            "2": "/images/icons3/alarm/firewall.gif"
        }, 
        "wireless": { 
            "2": "/images/icons3/alarm/wireless.gif"
        },
        "coreSwitch":{ 
            "2": "/images/icons3/alarm/core.gif"
        } 
    };

    var ZSYFCEditorConfig = window.ZSYFCEditorConfig = {
        "ID_KEY": "__id__",
        "singleMode": true,
        "shape": { 
            "ac": {
                "rx": 19,
                "ry": 21,
                "imgSrc": "/images/icons3/ac.png" 
            },
            "switch": {
                "rx": 20,
                "ry": 20,
                "imgSrc": "/images/icons3/switch.png"
            },
            "server": {
                "rx": 15,
                "ry": 19.5,
                "imgSrc": "/images/icons3/server.png"
            },
            "firewall": {
                "rx": 44.5,
                "ry": 34,
                "imgSrc": "/images/icons3/firewall.png"
            }, 
            "wireless": {
                "rx": 13.5,
                "ry": 16,
                "imgSrc": "/images/icons3/wireless.png"
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

    var _showNodeDetail = function(d, e ) { 
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
                var id  = ZSYFCEditor.getData()[ d[ ZSYFCEditorConfig['ID_KEY'] ] ]["data"]["id"];
                $.get(detailUrl, {
                    id: id,
                    fromWhere: "node",
                }, function(j) {
                    $content.find("div.popup_content").html(j);
                    popPanel.refresh();  
                }, 'html');
            }
        }).init().show(x, y);
    }; 

    var _showMainLinkDetail = function(where, e ) { 
        var $tg = $(e.target);
        if (false == $tg.is(".main_node_link")) {
            $tg = $tg.closest(".main_node_link");
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
        
        var className = "mainLinkDetail"; 

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

                $.get(mainLinkDetailUrl, {
                    where: where
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
    var _updateImage = function (shape, shapeType, s){  
        if( s == '1' ){
           shape.attr("href", ZSYFCEditorConfig["shape"][shapeType]["imgSrc"] );
        } else { 
           shape.attr("href", alarmImageMap[shapeType]["2"]);
        }
    };
 
    var _mockMainLinkPath = function(){
        /*
        d3.select("svg.ZSYFCEditor")
            .insert("path", "g.svg-container")
            .attr("class", "main_node_link green_link")
            .attr("d", "M210,442L817,132L971,214L829,289L849,298")
            .attr("id", "main_link_r")
            .on("click", function() {
                PopupPanel.clearAll();
                _showMainLinkDetail("r", d3.event );
            });  

        d3.select("svg.ZSYFCEditor")
            .insert("path", "g.svg-container")
            .attr("class", "main_node_link green_link")
            .attr("id", "main_link_g")
            .attr("d", "M638,670L1262,353L1049,245L1032,255")
            .on("click", function() {
                PopupPanel.clearAll();
                _showMainLinkDetail("g", d3.event );
            });  
        */
        d3.select("svg.ZSYFCEditor")
            .insert("path", "g.svg-container")
            .attr("class", "main_node_link blue_link")
            .attr("id", "main_link_b")
            .attr("d", "M1014,312L640,529L688,550")
            .on("click", function() {
                PopupPanel.clearAll();
                _showMainLinkDetail("b", d3.event );
            });  
    };

    // Dom Ready 
    $(function(){ 

 
        // Render FCEditor
        ZSYFCEditor.init(
            {},
            {
                svg: d3.select("svg.ZSYFCEditor"),
                width: 1280,
                height: 926
            } 
        );


        ZSYFCEditor.updateCallback( function(){
            var data = ZSYFCEditor.getData();

            d3.selectAll(".element") 
            .on("click", function(data) {
                PopupPanel.clearAll();
                _showNodeDetail(data, d3.event );
            });   
            
            d3.selectAll("path.node_link")
            .on("click", function(d) {
                PopupPanel.clearAll();
                var _d = {};
                _d["from"] = data[ d["from"] ]["data"]["id"];
                _d["to"] = data[ d["to"] ]["data"]["id"];

                _showPathDetail(_d, d3.event);
            });  

            // Update switch status.
            var keys = Object.keys( data ), s, imgSrc; 
            keys.forEach( function ( id ){
                ZSYFCEditor.callFN("shape", id, function (){
                    this.attr("data-status", data[id]['data']["status"] ); 
                    _updateImage(this, this.node().parentNode.getAttribute("data-shape-type") ,data[id]['data']["status"]);
                });
            });
            
        } ); 

        // _mockMainLinkPath();

        var pathIdPrefix = "ZSYFCEditor_Path";
        var _updateLinksStatus = function (links){
            links.forEach( function ( link ){
                d3.select('#' + pathIdPrefix + link.from + "_" + link.to).classed( "node_link_error", link.status != '1' );
            } );
        };

        var _updateMainLinksStatus = function ( map ){
            var link;
            Object.keys(map).forEach( function (k) {
                link = d3.select('#main_link_' + k ); 
                if( link.node() ){
                    link.attr("data-status", map[k]["status"] );
                }
            } )
        }

        var refreshData = function(){
            $.ajax({
                url:'/topology/dashboard/ajax-links-refresh',
                type:"post",
                data:{"type":3},
                dataType:'json',
                success:function(res){
                    if(res.build){
                        ZSYFCEditor.updateData(res.build);
                        _updateLinksStatus( res.links );
                        _updateMainLinksStatus( res.mainLinks );
                    }
                    setTimeout(refreshData,30000);
                }
            });
        };
        refreshData();
    });

} )();