! function(ns) {

    var console = ZSYFCEditorUtil.console;

    var document = window.document;

    // Object has owner property ?
    var hasOwnProp_ = function(o, p) {
        return Object.prototype.hasOwnProperty.call(o, p);
    };
    // Sub array
    var slice_ = function(arrLike, index) {
        return Array.prototype.slice.call(arrLike, index);
    };

    var ZSYFCEditor = {};
    var refreshCallback_;

    // Import libs.
    // Data Factory
    var gData_ = window["FCNodeData"];
    // Shape Maker factory
    var shapeMaker_ = window["FCShapeMaker"];
    // Object Collector factory
    var objectCollector_ = window["FCObjectCollector"];
    // Helper Position factory.
    var helperPosition_ = window['FCHelperPosition'];
    // Line Path Position
    var linePathPosition_ = window["FCLinePathPosition"];
    // Link line
    var linkLine_ = window["FCLinkline"];

    var ID_ELEMENTINDEX = 0,
        ID_KEY = ZSYFCEditorConfig["ID_KEY"];

    var closeSquareD_ = 8; // close btn 直径

    var titleFontSize_ = 12; // 标题字体大小，定位text位置

    var gSVG_,
        gLinkDragPathHelper_,
        gNodeEnter_, gNodeUpdate_, gNodeExit_;

    var gBindData_, gLinkData_,
        gMode_, // Drag, link line/polyline mode.
        gSVGWidth_, gSVGHeight_, gCurrentSelectedData_,
        gLinkHelperPath_;

    var elementID_ = {
        "elementId": function(idx) {
            if (idx != undefined)
                return "ZSYFCEditor_Element" + String(idx);
            throw "Invalid parameter.";
        },
        "pathId": function(idx) {
            if (idx != undefined)
                return "ZSYFCEditor_Path" + String(idx);
            throw "Invalid parameter.";
        }
    };

    // Export {ZSYFCEditor} member
    function exportLabel_(key, value) {
        ZSYFCEditor[key] = value;
    }

    var getSvgOffset_ = function() {
        return $('svg.ZSYFCEditor').offset();
    };

    var makeCloseBtn_ = function(g) {
        g.append("line")
            .attr("class", "l1")
            .attr("x1", 0)
            .attr("y1", 0)
            .attr("x2", closeSquareD_)
            .attr("y2", closeSquareD_);

        g.append("line")
            .attr("class", "l2")
            .attr("x1", closeSquareD_)
            .attr("y1", 0)
            .attr("x2", 0)
            .attr("y2", closeSquareD_);
    };

    var pointValue_ = function(v, radius) {
        radius = radius || 10;
        v = parseInt(v, radius);
        if (isNaN(v)) {
            throw "point value: invalid value.";
        }
        return v;
    };

    var linkPathPusher_ = {
        "startD_": null,
        "endD_": null,
        "startOffset_": null,
        /* 起点坐标offset，距离设备中心的坐标差 */
            "endOffset_": null,
        /* 终点坐标offset，距离设备中心的坐标差 */
            "points_": [],
        "clear": function() {
            this["startD_"] = null;
            this["endD_"] = null;
            this["startOffset_"] = null;
            this["endOffset_"] = null;
            this["points_"].length = 0;
            // Hide link helper
            gLinkHelperPath_.classed("on", false).attr("d", "M0,0");
            return this;
        },
        "push": function(node, xy) {
            // TODO: check node forward( eg: D Or array[x, y] ).
            // Node data.
            if (node && typeof node == 'object' && hasOwnProp_(node, ID_KEY)) {
                if (this["startD_"] == null) {
                    this["startD_"] = node;
                    this["startOffset_"] = xy;
                } else {
                    if (this["startD_"] != node) {
                        this["endD_"] = node;
                        this["endOffset_"] = xy;
                        this["completeChoosen_"]();
                    }
                }
            } else { // node = null
                // Has chosen startD, then node ...
                if (this["startD_"] && Array.isArray(xy)) { // Normal node(x,y)
                    this["points_"].push(xy);
                }
            }
            return this;
        },
        "pop": function() {
            if (this["points_"].length) {
                this["points_"].pop();
            } else {
                this["clear"]();
            }
            return this;
        },
        "drawChoosenTrackingPoints": function(x, y) {
            if (this["startD_"]) { // Has chosen startD
                x = pointValue_(x);
                y = pointValue_(y);
                var path_ = [],
                    x_, y_;
                gLinkHelperPath_.classed("on", true);
                // If polyline,  from user clicked-xy drawn
                if (gMode_ == 'polyline') {
                    path_.push("M" + (this["startD_"]["cx"] - this["startOffset_"][0]) + "," + (this["startD_"]["cy"] - this["startOffset_"][1]));
                } else {
                    path_.push("M" + this["startD_"]["cx"] + "," + this["startD_"]["cy"]);
                }
                if (gMode_ == 'polyline') {
                    this["points_"].forEach(function(point) {
                        x_ = pointValue_(point[0]);
                        y_ = pointValue_(point[1]);
                        path_.push("L" + x_ + "," + y_);
                    });
                }
                path_.push("L" + x + "," + y);
                gLinkHelperPath_.attr("d", path_.join(""));
                return true;
            }
            console.log("Link line pusher: choose start point firstly.");
            return false;
        },
        "completeChoosen_": function() {
            var line;
            switch (gMode_) {
                case "line":
                    line = new linkLine_["base"]["Line"]();
                    line.startD(this["startD_"]); // TODO:  , this["startOffset_"]
                    line.endD(this["endD_"]); // TODO:  , this["endOffset_"]
                    gLinkHelperPath_.classed("on", false).attr("d", "M0,0");
                    dataFactory_.makeLink(this["startD_"], this["endD_"], line.toPlainData());
                    repaint_();
                    this.clear();
                    break;
                case "polyline":
                    line = new linkLine_["base"]["Polyline"]();
                    line.startD(this["startD_"], this["startOffset_"]);
                    this["points_"].forEach(function(point) {
                        line.linkPoints(point);
                    });
                    line.endD(this["endD_"], this["endOffset_"]);
                    gLinkHelperPath_.classed("on", false).attr("d", "M0,0");
                    dataFactory_.makeLink(this["startD_"], this["endD_"], line.toPlainData());
                    repaint_();
                    this.clear();
                    break;
            }
            return this;
        }
    };

    var dataFactory_ = function() {
        var cursor_ = 0;
        return {
            "init": function(beginCursor_) {
                beginCursor_ = +(beginCursor_); // To number
                cursor_ = Math.max(cursor_, beginCursor_);
            },
            "getId": function(d) {
                // Getter
                if (d)
                    return d[ID_KEY];
                ++cursor_;
                console.log('|> new key:' + cursor_);
                // New id.
                return String(cursor_);
            },
            "removeItem": function(d) {
                var delKey = d[ID_KEY];
                gData_.removeItem(delKey);

                // Remove relative links.
                var data = gData_.getData();
                var keys = Object.keys(data),
                    itm, link, key;
                for (var i = 0, len = keys.length; i < len; i++) {
                    key = keys[i];
                    itm = data[key];
                    if (itm["links"]) {
                        len1 = itm["links"].length;
                        while (--len1 > -1) {
                            link = itm["links"][len1];
                            if (link["data"]["from"] == delKey || link["data"]["to"] == delKey) {
                                itm["links"].splice(len1, 1);
                            }
                        }
                    }
                }
            },
            "unlink": function(fromD, toD) {
                var unlinkSourceId = fromD,
                    unlinkTargetId = toD;
                if (typeof fromD == 'object') {
                    unlinkSourceId = fromD[ID_KEY];
                }
                if (typeof toD == 'object') {
                    unlinkTargetId = toD[ID_KEY];
                }
                var source = gData_.getItem(unlinkSourceId);
                if (source) {
                    var links = source["links"];
                    if (links) {
                        var len1 = links.length,
                            link;
                        while (--len1 > -1) {
                            link = links[len1];
                            if (link["data"]["from"] == unlinkSourceId && link["data"]["to"] == unlinkTargetId) {
                                links.splice(len1, 1);
                                return true;
                            }
                        }
                    }
                }
                return false;
            },
            "makeLink": function(d, tgDatum, linkData) {
                var _key = this.getId(tgDatum);
                var ownerKey = this.getId(d);
                var data = gData_.getItem(ownerKey);

                var from = linkData["data"]["from"],
                    to = linkData["data"]["to"];

                if (data && gData_.hasItem(_key) && from == ownerKey) {
                    data["links"] = data["links"] || [];
                    var found = false;
                    data["links"].forEach(function(link) {
                        if (link["data"]["from"] == from && link["data"]["to"] == to) {
                            found = true;
                        }
                    });
                    console.log("Make link: found = ", found);
                    if (found === false)
                        data["links"].push(linkData);
                } else {
                    console.log("Make link failure.", data, gData_.hasItem(_key), from, ownerKey);
                }
            },
            "addNew": function(shapeType, data) {
                if (shapeFactory_["newOne"]) {
                    var id = this['getId']();
                    var one = shapeFactory_["newOne"](shapeType, data && data["label"]);
                    var d = one.toData();
                    one.bindData(d); // Relative.
                    gData_.setItem(id, {
                        "attributes": d,
                        "data": data ? data : undefined
                    });
                }
            },
            "stringify": function() {
                return JSON.stringify(gData_.getData());
            },
            "toData": function() {
                return gData_.getData();
            }
        };
    }();

    // New modaless dialog
    var modalessDialog__ = function(x, y, contentHtml, callback, className) {
        var contentTpl = '<div class="popupBody">' +
            '<div class="popup_close" title="关闭">&nbsp;</div>' +
            '<div class="popup_content" >{content}</div>' +
            '</div>';

        var offsetX = 5,
            offsetY = 5;

        return new PopupPanel({
            className: 'modalessDialog' + (className ? " " + className : ""),
            offsetX: offsetX,
            offsetY: offsetY,
            destroy: true,
            animate: false,
            closeHandler: function() {},
            content: contentTpl,
            initInterface: function($content) {
                var inst = this;
                $content.find('div.popup_close').click(function() {
                    inst.close(true);
                });
                $content.find("div.popup_content").html(contentHtml);
                callback && callback.contentInit && callback.contentInit.call(inst, $content);
            }
        }).init().show(x, y);
    };

    var allowedLazyDragXY_ = function(d, x, y) {
        var shape = objectCollector_.get(d);
        if (Math.abs(shape.cx() - x) < 5 && Math.abs(shape.cy() - y) < 5)
            return true;
        return false;
    };

    var dragRepaint_ = function() {
        var timer = null;
        return function() {
            if (timer) {
                window.clearTimeout(timer);
                timer = null;
            }
            timer = setTimeout(repaint_, 0);
        };
    }();

    var dragFactory_ = {
        "drag": {
            "start": function(d) {
                console.log("drag mode: start");
                if (d3.event.sourceEvent.which != 1 ||
                    (d3.event.dx == 0 && d3.event.dy == 0)) {
                    console.log("Invalid drag.");
                    return;
                }
                d3.select(document.body).classed("ZSYFCEditor_shape_moving", true);
            },
            "drag": function(d) {
                console.log("drag mode: drag");
                var x = d3.event.sourceEvent.clientX,
                    y = d3.event.sourceEvent.clientY;

                if (d3.event.sourceEvent.which != 1 ||
                    (d3.event.dx == 0 && d3.event.dy == 0)) {
                    console.log("Invalid drag.");
                    return;
                }

                var shape = objectCollector_.get(d);
                var svgOffset_ = getSvgOffset_();
                shape.cx(x - svgOffset_.left + document.body.scrollLeft);
                shape.cy(y - svgOffset_.top + document.body.scrollTop);
                dragRepaint_();
            },
            "end": function(d) {
                console.log("drag mode: end");
                if (d3.event.sourceEvent.which != 1 ||
                    (d3.event.dx == 0 && d3.event.dy == 0)) {
                    console.log("Invalid drag.");
                    return;
                }
                var shape = objectCollector_.get(d);
                d3.select(document.body).classed("ZSYFCEditor_shape_moving", false);
                shapeFactory_["position"] && shapeFactory_["position"](d,
                    shape.cx(),
                    shape.cy());
                dragRepaint_();
            },
        }
    };

    var events_ = {
        "dragProxy": function() {
            return d3.behavior.drag()
                .on("dragstart", function(d) {
                    switch (gMode_) {
                        case 'drag':
                            dragFactory_[gMode_]["start"](d);
                            break;
                    }
                })
                .on("drag", function(d) {
                    switch (gMode_) {
                        case 'drag':
                            dragFactory_[gMode_]["drag"](d);
                            break;

                    }
                })
                .on("dragend", function(d) {
                    switch (gMode_) {
                        case 'drag':
                            dragFactory_[gMode_]["end"](d);
                            break;

                    }
                });
        },
        "shapeSelectedClickEvent": function(d) {
            // Selected
            if (gCurrentSelectedData_ !== d) {
                if (d3.event.which == 1) { // Mouse: left key
                    gNodeUpdate_.classed(
                        "current",
                        function(nodeData) {
                            return d == nodeData;
                        }
                    );
                    gCurrentSelectedData_ = d;
                }
            } else { // Deselected
                if (d3.event.which != 1) {
                    gNodeUpdate_.classed("current", false);
                    gCurrentSelectedData_ = null;
                }
            }
        },
        "shapeRemoveClickEvent": function(d) {
            dataFactory_.removeItem(d);
            repaint_();
        },
        "shapeTitleClickEvent": function(d) {
            // To jQuery object
            var $tg = $(d3.event.target);
            var offset = $tg.offset();
            var x = offset.left,
                y = offset.top;

            // Show text modify dialog.
            modalessDialog__(x, y,
                "<input class='title' >", {
                    "contentInit": function($content) {
                        var inst = this;
                        var $input = $content.find("input.title").val(d['title'] || "")
                            .keyup(function(e) {
                                if (e.keyCode == 13) {
                                    var shape = objectCollector_.get(d);
                                    shape.title($(this).val());
                                    var data = gData_.getItem(dataFactory_.getId(d));
                                    // Sync title <=> label value.
                                    if (data && data["data"]) {
                                        data["data"]["label"] = shape.title();
                                    }
                                    inst.close();
                                    repaint_();
                                }
                            });
                        setTimeout(function() {
                            $input.select();
                        }, 50);
                    }
                },
                "modify_title"
            );
        }
    };

    // For: shape can drop\new one\position\re-render\...
    var shapeFactory_ = {
        "accept": function(d) {
            return true;
        },
        "newOne": function(shapeType, title) {
            if (shapeType in shapeMaker_) {
                return new shapeMaker_[shapeType].newOne(title || "", gSVGWidth_ / 2, gSVGHeight_ / 2);
            }
        },
        "position": function(d, x, y) {
            var shape = objectCollector_.get(d);
            //x -= shape.rx();
            //y -= shape.ry();
            shape.cx(Math.min(gSVGWidth_ - shape.rx(), Math.max(shape.rx(), x)));
            shape.cy(Math.min(gSVGHeight_ - shape.ry(), Math.max(shape.ry(), y)));
        },
        "render": function(d, container) {
            var shape = objectCollector_.get(d);

            var g = container;

            var titleTxt = g.append("text")
                .attr("class", function(d) {
                    return shape["title"]() ? "title" : "title none";
                })
                .attr("x", shape["cx"]())
                .attr("y", shape["cy"]() + shape["ry"]() + titleFontSize_)
                .text(shape["title"]() || "<No Title>");

            if (!ZSYFCEditorConfig["singleMode"])
                titleTxt.on("click", events_["shapeTitleClickEvent"]);

            var element = shape.render(g);

            if (!ZSYFCEditorConfig["singleMode"])
                element.call(events_["dragProxy"]())
                .on("mousedown", events_["shapeSelectedClickEvent"]);

            var hPos = helperPosition_.get(d);

            if (hPos) {
                for (var p in hPos) {
                    g.append("rect")
                        .attr("class", "helper")
                        .attr("x", hPos[p][0])
                        .attr("y", hPos[p][1])
                        .attr("width", hPos[p][2])
                        .attr("height", hPos[p][3]);
                }
            }

            // Close btn.
            if (!ZSYFCEditorConfig["singleMode"]) {
                var cg = g.append("g")
                    .attr("transform", "matrix(1,0,0,1," +
                        (shape.cx() + shape.rx() - closeSquareD_ / 2) +
                        "," + (shape.cy() - shape.ry() - closeSquareD_ / 2) + ")")
                    .attr("class", "remove")
                    .on("click", events_["shapeRemoveClickEvent"]);
                makeCloseBtn_(cg);
            }
        }
    };

    function bindEvents_(svg) {
        if (ZSYFCEditorConfig["singleMode"])
            return;

        svg.on("click", function() {
            if (gMode_ != "drag") { // line or polyline mode
                var event = d3.event,
                    target = event.target,
                    data;
                var x, y;
                var svgLT = getSvgOffset_();
                x = event.x - svgLT.left;
                y = event.y - svgLT.top;
                // Fixed: scroll left or top.
                x += document.body.scrollLeft;
                y += document.body.scrollTop;

                var element = $(target).closest("g.element")[0];
                if (element) {
                    data = d3.select(element).datum();

                    // 第二参数为距离设备中心的坐标差。
                    // offsetX: centerX - x
                    // offsetY: centerY - y
                    linkPathPusher_.push(data, [data["cx"] - x, data["cy"] - y]);
                } else {
                    linkPathPusher_.push(null, [x, y]);
                }
                console.log("svg click: ", x, y, target, element, data);
            }
        }).on("mousemove", function() {
            var event = d3.event,
                target = event.target,
                data;
            var x, y;
            var svgLT = getSvgOffset_();
            x = event.x - svgLT.left;
            y = event.y - svgLT.top;
            // Fixed: scroll left or top.
            x += document.body.scrollLeft;
            y += document.body.scrollTop;
            if (gMode_ != "drag") { // line or polyline mode
                linkPathPusher_.drawChoosenTrackingPoints(x, y);
            }
        }).on("mousedown", function() {
            var event = d3.event,
                target = event.target,
                data;
            // Select mode, and press mouse's right button
            if (gMode_ != "drag" && event.which === 3) {
                linkPathPusher_.pop();
            }
        });

        $(svg.node()).bind("dblclick", function(event) {
            var $target = $(event.target);
            if ($target.is("path.node_link")) {
                var from = $target.data("from"),
                    to = $target.data("to")
                var r = dataFactory_.unlink(from, to);
                r && $target.remove();
                return false;
            }
        });
    }

    // Init svg painter
    function exportFn_InitPage_(d, config) {
        var svg = config.svg
            .attr("class", "ZSYFCEditor")
            .attr("width", config.width)
            .attr("height", config.height);

        // Init helper( with path element )
        gLinkHelperPath_ = svg.append("path")
            .attr("class", "link_drag_helper");

        svg.append("g")
            .attr("class", "svg-container");

        bindEvents_(svg);

        // Add some padding elements.
        svg = prepareSVG_(svg);

        // Init closure variables.
        gData_.setData(d);
        d = parseData_(gData_.getData());

        gSVGWidth_ = config.width;
        gSVGHeight_ = config.height;
        gSVG_ = svg;
        gBindData_ = d["nodes"];
        gLinkData_ = d["links"];

        gMode_ = "drag";

        // Pare data.
        renderSVG_();
    }

    function resetEditor_() {
        // Init closure variables.
        gData_.setData({});
        d = parseData_(gData_.getData());
        gBindData_ = d["nodes"];
        gLinkData_ = d["links"];
        window.console.log(gBindData_, gLinkData_)
        // Pare data.
        repaint_();
    };

    function exportFn_reset_(userConfirm) {
        userConfirm = userConfirm === true ? true : false;
        if (userConfirm) {
            if (window.confirm("是否重新创建模版？")) {
                resetEditor_();
            }
        } else {
            resetEditor_();
        }

    }

    function exportFn_updateData_(d) {
        // Init closure variables.
        gData_.setData(d);
        d = parseData_(gData_.getData());
        gBindData_ = d["nodes"];
        gLinkData_ = d["links"];
        // Pare data.
        repaint_();
    }

    // Add something
    function prepareSVG_(svg) {
        return svg.select("g.svg-container");
    }
    // Retrieve nodes and links( For shapes and paths ).
    function parseData_(data) {
        var nodes = [];
        var links = [];
        var a, b;
        var keys = Object.keys(data),
            d;
        var _ids = [];

        var sourcePos, targetPos, which, sourceShape, targetShape;

        keys.forEach(function(k, i) {
            _ids.push(+(k));
            d = data[k];
            // Extend ID_KEY attribute.
            d["attributes"][ID_KEY] = k;
            nodes.push(d["attributes"]);
        });

        var pathData_,
            from,
            to;

        keys.forEach(function(k, i) {
            d = data[k];
            d.links && d.links.forEach(function(c, i) {
                from = c["data"]["from"];
                to = c["data"]["to"];
                if (gData_.hasItem(to)) {
                    pathData_ = linkLine_.getPathData(c);
                    if (pathData_) {
                        links.push({
                            from: from,
                            to: to,
                            pathData: pathData_
                        });
                    } else {
                        console.log("parse data: unknown link-value.", c, k);
                    }
                }
            });
        });


        // Find max key-value.
        _ids.sort(function(a, b) {
            if (a < b) return -1;
            else if (a > b) return 1;
            else return 0;
        });
        var _max = _ids.pop();
        // Init some constants
        dataFactory_.init(_max || 1);

        _ids = null;

        return {
            nodes: nodes,
            links: links
        };
    }

    // Link path handler.
    function linePathData_(d) {
        var points = [{
            x: d.source.cy,
            y: d.source.cx
        }, {
            x: d.target.cy,
            y: d.target.cx
        }];
        return d3.svg.line()
            .x(function(d) {
                return d.x;
            })
            .y(function(d) {
                return d.y;
            })(points);
    }

    // Render elements in SVG.
    function renderSVG_() {
        d = parseData_(gData_.getData());
        gBindData_ = d["nodes"];
        gLinkData_ = d["links"];
        var arr = gBindData_;

        var elementContainer =

            gSVG_.selectAll(".node_link").remove();

        var glinkPath = gSVG_.selectAll(".node_link")
            .data(gLinkData_);

        var shape = gSVG_.selectAll(".element").data(arr);
        var shapeEnter = shape.enter();
        var shapeExit = shape.exit();
        gNodeEnter_ = shapeEnter;
        gNodeUpdate_ = shape;
        gNodeExit_ = shapeExit;


        glinkPath.enter().append("path")
            .attr("class", "node_link")
            .attr("data-from", function(d) {
                return d.from;
            })
            .attr("data-to", function(d) {
                return d.to;
            })
            .attr("id", function(d) {
                return elementID_["pathId"](d.from + '_' + d.to);
            })
            .attr("d", function(d) {
                return d.pathData;
            });

        var g = gNodeEnter_.append("g")
            .attr("data-shape-type", function(d) {
                return d.type;
            })
            .attr("class", function(d) {
                if (gCurrentSelectedData_ == d) return "element current";
                return "element";
            })
            .attr("id", function(d) {
                return elementID_["elementId"](dataFactory_.getId(d));
            })
            .each(function(d) {
                shapeFactory_["render"](d, d3.select(this));
            });

        gNodeExit_.transition().remove();

        if (refreshCallback_)
            refreshCallback_();
    }
    // Repaint
    function repaint_() {
        gSVG_.selectAll("*").remove();
        ID_ELEMENTINDEX = 0;
        gBindData_ = null;
        gLinkData_ = null;

        helperPosition_.clear();
        objectCollector_.clear();

        // Render svg elements.
        renderSVG_();
    }

    // Add new shape
    function exportFn_AddNewShape_(shapeType, data) {
        if (hasOwnProp_(shapeMaker_, shapeType)) {
            dataFactory_["addNew"](shapeType, data);
            repaint_();
        } else {
            console.log("unsupported shape type(:" + shapeType + ").");
        }
    }

    // Get data-json-string
    function exportFn_toDataJson_(stringify) {
        var stringifyData = dataFactory_['stringify']();
        if (stringify)
            return stringifyData;
        return dataFactory_['toData']();
    }

    function exportFn_switchMode_(mode) {
        switch (mode) {
            case 'drag':
            case 'line':
            case 'polyline':
                gMode_ = mode;
                break;
            default:
                gMode_ = "";
                break;
        }
        linkPathPusher_.clear();
    }

    function exportFn_getDom_(nodeType, id) {
        switch (nodeType) {
            case "shape":
                return d3.select('#' + elementID_["elementId"](id) + ' .shape').node();
                break;
        }
        return null;
    }

    function exportFn_applyFn_(nodeType, id, applyFn) {
        if (!applyFn)
            return false;
        switch (nodeType) {
            case "shape":
                d3.select('#' + elementID_["elementId"](id) + ' .shape').call(applyFn);
                return true;
            default:
                return false;
        }
    }

    // --------------------------------------------
    // Export fn(s) for external invoking
    // --------------------------------------------
    // Relative fn with ZSYFCEditor
    exportLabel_("init", exportFn_InitPage_);
    exportLabel_("updateData", exportFn_updateData_);
    exportLabel_("reset", exportFn_reset_);
    exportLabel_('getData', exportFn_toDataJson_);
    exportLabel_("updateCallback", function(fn) {
        refreshCallback_ = fn
    });
    exportLabel_("getDOM", exportFn_getDom_);
    exportLabel_("callFN", exportFn_applyFn_);

    // Only for edit mode.
    if (!ZSYFCEditorConfig["singleMode"]) {
        exportLabel_('addShape', exportFn_AddNewShape_);
        exportLabel_('switchMode', exportFn_switchMode_);
    }

    //---------------------------------------------
    // Export object.
    //---------------------------------------------
    window[ns] = ZSYFCEditor;
}("ZSYFCEditor");