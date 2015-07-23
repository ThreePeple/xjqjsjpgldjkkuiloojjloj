! function(ns) {
    // Debug mode.
    var DEBUG_ = false;
    // Console wrapper.
    var console = {
        "log": function() {
            DEBUG_ && window.console && window.console.log.apply(window.console, arguments);
        }
    };
    // Object has owner property ?
    var hasOwnProp_ = function(o, p) {
        return Object.prototype.hasOwnProperty.call(o, p);
    };
    // Sub array
    var slice_ = function(arrLike, index) {
        return Array.prototype.slice.call(arrLike, index);
    };

    var ZSYFCEditor = {};

    // Shape-maker factory
    var shapeMaker_ = window["FCShapeMaker"];

    var ID_ELEMENTINDEX = 0,
        ID_KEY = "__id__";

    var helperSquareD_ = 6, // 四边节点直径（接连线）
        closeSquareD_ = 8; // close btn 直径

    var titleFontSize_ = 12; // 标题字体大小，定位text位置

    var gSVG_,
        gLinkDragPathHelper_,
        gNodeEnter_, gNodeUpdate_, gNodeExit_;

    var gData_, gBindData_, gLinkData_,
        gSVGWidth_, gSVGHeight_, gCurrentSelectedData_,
        gLinkHelperPath_;

    var elementID_ = {
        "generate": function(idx) {
            if (idx != undefined)
                return "ZSYFCEditor_Element" + String(idx);
            throw "Invalid parameter.";
        }
    };

    // Export {ZSYFCEditor} member
    function exportLabel_(key, value) {
        ZSYFCEditor[key] = value;
    }

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
            "makeLink": function(d, tgDatum) {
                var _key = dataFactory_.getId(tgDatum);
                var data = gData_[dataFactory_.getId(d)];
                if (data && gData_[_key]) {
                    data["links"] = data["links"] || [];
                    var found = false;
                    data["links"].forEach(function(v, i) {
                        if (v == _key) {
                            found = true;
                        }
                    });
                    if (found === false)
                        data["links"].push(_key);
                }
            },
            "addNew": function(shapeType) {
                if (shapeFactory_["newOne"]) {
                    var id = dataFactory_['getId']();
                    var one = shapeFactory_["newOne"](shapeType);
                    var d = one.toData();
                    one.bindData(d); // Relative.
                    gData_[id] = {
                        "attributes": d
                    };
                }
            },
            "stringify": function() {
                return JSON.stringify(gData_);
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

    var events_ = {
        "dragProxy": function() {
            return d3.behavior.drag()
                .on("dragstart", function(d) {
                    if (d3.event.sourceEvent.which != 1) {
                        return;
                    }
                    d3.select(document.body).classed("ZSYFCEditor_shape_moving", true);
                    this.__originXY__ = [d.cx, d.cy];
                    var mouseX = (this.__originXY__[0] += 0),
                        mouseY = (this.__originXY__[1] += 0);
                    var shape = objectCollector_.get(d);
                    shape.cx(mouseX - shape.rx() + document.body.scrollLeft);
                    shape.cy(mouseY - 2 * shape.ry() + document.body.scrollTop);
                    repaint_();
                })
                .on("drag", function(d) {
                    if (d3.event.sourceEvent.which != 1) {
                        return;
                    }

                    var mouseX = (this.__originXY__[0] += d3.event.dx),
                        mouseY = (this.__originXY__[1] += d3.event.dy);
                    var shape = objectCollector_.get(d);
                    shape.cx(mouseX - shape.rx() + document.body.scrollLeft);
                    shape.cy(mouseY - 2 * shape.ry() + document.body.scrollTop);
                    repaint_();
                })
                .on("dragend", function(d) {
                    var shape = objectCollector_.get(d);
                    if (d3.event.sourceEvent.which != 1) {
                        return;
                    }
                    d3.select(document.body).classed("ZSYFCEditor_shape_moving", false);
                    this.__originXY__ = null;
                    shapeFactory_["position"] && shapeFactory_["position"](d,
                        shape.cx(),
                        shape.cy());
                    repaint_();
                });
        },
        "linkDragProxy": function() {
            return d3.behavior.drag()
                .on("dragstart", function(d) {
                    if (d3.event.sourceEvent.which != 1) {
                        return;
                    }
                    this.__originXY__ = [d.cx, d.cy];
                    d3.select(document.body).classed("ZSYFCEditor_link_moving", true);
                    gLinkHelperPath_.classed("on", true);
                })
                .on("drag", function(d) {
                    if (d3.event.sourceEvent.which != 1) {
                        return;
                    }
                    var data = [{
                        source: {
                            cy: this.__originXY__[0],
                            cx: this.__originXY__[1]
                        },
                        target: {
                            cx: d3.event.y - 2,
                            cy: d3.event.x - 2
                        }
                    }];
                    gLinkHelperPath_.data(data).attr("d", linePathData_);
                })
                .on("dragend", function(d) {
                    if (d3.event.sourceEvent.which != 1) {
                        return;
                    }
                    if (d3.event.sourceEvent.target) {
                        var tgDatum = d3.select(d3.event.sourceEvent.target).datum();
                        if (tgDatum && tgDatum != d) {
                            console.log("Drag-Drop end:", d, tgDatum);
                            if (shapeFactory_.accept && shapeFactory_.accept(tgDatum)) {
                                dataFactory_["makeLink"](d, tgDatum);
                                repaint_();
                            }
                        }
                    }
                    this.__originXY__ = null;
                    d3.select(document.body).classed("ZSYFCEditor_link_moving", false);
                    gLinkHelperPath_.classed("on", false).attr("d", null);
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
            delete gData_[d[ID_KEY]];
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

    var linePathPosition_ = {
        "findHelper": function(sourceD, targetD) {
            var sourceShape = objectCollector_.get(sourceD),
                targetShape = objectCollector_.get(targetD);
            var sourceHelperPos = helperPosition_.get(sourceD),
                targetHelperPos = helperPosition_.get(targetD);

            var which = ['l', 'b'];

            /**
             * 		target location:
             *
             *                   |
             *      top-left     |     top-right
             *                   |
             *     ---------------------------------
             *     				 |
             * 		bottom-left  |	   bottom-right
             * 					 |
             *
             *
             */

            // Fixed locatioin
            // -- source >>
            if (sourceShape.cx() > targetShape.cx()) {
                which[0] = 'l';
            } else {
                if (sourceShape.cx() <= targetShape.cx() + targetShape.rx() && sourceShape.cx() >= targetShape.cx() - targetShape.rx()) {
                    which[0] = 't';
                    if (sourceShape.cy() < targetShape.cy()) {
                        which[0] = 'b';
                    }
                } else {
                    which[0] = 'r';
                }
            }

            // -- target >>
            if (sourceShape.cy() > targetShape.cy()) {
                which[1] = 'b';
            } else {
                if (sourceShape.cy() <= targetShape.cy() + targetShape.ry() && sourceShape.cy() >= targetShape.cy() - targetShape.ry()) {
                    which[1] = 'l';
                    if (sourceShape.cx() > targetShape.cx()) {
                        which[1] = 'r';
                    }
                } else {
                    which[1] = 't';
                }
            }
            console.log('|> Link Points: ', which);
            return which;
        }
    };

    // 4 rect(s) helper( for generating {x,y,w,h,cx,cy} ) 
    var helperPosition_ = {
        "cache_": {},
        "get": function(d) {
            var key = d[ID_KEY];
            if (key !== undefined) {
                if (this["cache_"][key] == undefined) {
                    var shape = objectCollector_.get(d);
                    var posMap = {};
                    //x,y,w,h,cx,cy
                    // top
                    posMap["t"] = [
                        shape.cx() - helperSquareD_ / 2,
                        shape.cy() - shape.ry() - helperSquareD_ / 2,
                        helperSquareD_,
                        helperSquareD_,
                        shape.cx(),
                        shape.cy() - shape.ry()
                    ];
                    // right
                    posMap["r"] = [
                        shape.cx() + shape.rx() - helperSquareD_ / 2,
                        shape.cy() - helperSquareD_ / 2,
                        helperSquareD_,
                        helperSquareD_,
                        shape.cx() + shape.rx(),
                        shape.cy()
                    ];

                    // bottom
                    posMap["b"] = [
                        shape.cx() - helperSquareD_ / 2,
                        shape.cy() + shape.ry() - helperSquareD_ / 2,
                        helperSquareD_,
                        helperSquareD_,
                        shape.cx(),
                        shape.cy() + shape.ry()
                    ];
                    // left
                    posMap["l"] = [
                        shape.cx() - shape.rx() - helperSquareD_ / 2,
                        shape.cy() - helperSquareD_ / 2,
                        helperSquareD_,
                        helperSquareD_,
                        shape.cx() - shape.rx(),
                        shape.cy()
                    ];
                    this["cache_"][key] = posMap;
                    posMap = null;
                    console.log("!> Helper position: new.")
                } else {
                    console.log("|> Helper posiiton: From cache.")
                }
                return this["cache_"][key];
            }
            throw "Invalid parameter.";
        },
        "clear": function() {
            this["cache_"] = null;
            this["cache_"] = {};
        }
    };

    var objectCollector_ = {
        "collector_": {},
        "get": function(d) {
            var key = d[ID_KEY];
            if (key !== undefined) {
                if (this["collector_"][key] == undefined) {
                    this["collector_"][key] = (new shapeMaker_[d.type]()).bindData(d).fromData(d);
                }
                return this["collector_"][key];
            }
            throw "Invalid parameter.";
        },
        "clear": function() {
            this["collector_"] = null;
            this["collector_"] = {};
        }
    };

    var shapeFactory_ = {
        "accept": function(d) {
            return true;
        },
        "newOne": function(shapeType) {
            if (shapeType in shapeMaker_) {
                return new shapeMaker_[shapeType].newOne("", gSVGWidth_ / 2, gSVGHeight_ / 2);
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
            g.append("text")
                .attr("class", function(d) {
                    return shape["title"]() ? "title" : "title none";
                })
                .attr("x", shape["cx"]())
                .attr("y", shape["cy"]() + shape["ry"]() + titleFontSize_)
                .text(shape["title"]() || "<No Title>")
                .on("click", events_["shapeTitleClickEvent"]);

            shape.render(g)
                .call(events_["dragProxy"]())
                .on("mousedown", events_["shapeSelectedClickEvent"]);

            var hPos = helperPosition_.get(d);

            if (hPos) {
                for (var p in hPos) {
                    g.append("rect")
                        .attr("class", "helper")
                        .attr("x", hPos[p][0])
                        .attr("y", hPos[p][1])
                        .attr("width", hPos[p][2])
                        .attr("height", hPos[p][3])
                        .call(events_["linkDragProxy"]());
                }
            }

            // Close btn.
            var cg = g.append("g")
                .attr("transform", "matrix(1,0,0,1," +
                    (shape.cx() + shape.rx() - closeSquareD_ / 2) +
                    "," + (shape.cy() - shape.ry() - closeSquareD_ / 2) + ")")
                .attr("class", "remove")
                .on("click", events_["shapeRemoveClickEvent"]);
            makeCloseBtn_(cg);
        }
    };

    // Init svg painter
    function initPage_(d, config) {
        var svg = config.svg
            .attr("class", "ZSYFCEditor")
            .attr("width", config.width)
            .attr("height", config.height);
        // Init helper( with path element )
        gLinkHelperPath_ = svg.append("path")
            .attr("class", "link_drag_helper");
        // Append some or not elements in SVG.
        svg = prepareSVG_(svg);

        // Init closure variables.
        gData_ = d;
        d = parseData_(gData_);

        gSVGWidth_ = config.width;
        gSVGHeight_ = config.height;
        gSVG_ = svg;
        gBindData_ = d["nodes"];
        gLinkData_ = d["links"];

        // Pare data.
        renderSVG_();
    }
    // Add something
    function prepareSVG_(svg) {
        return svg.select("g.container");
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

            d.links && d.links.forEach(function(c, i) {
                if (data[c]) {
                    // Extend ID_KEY attribute.
                    data[c]["attributes"][ID_KEY] = c;
                    c = data[c];
                    which = linePathPosition_.findHelper(d["attributes"], c["attributes"]);
                    sourcePos = helperPosition_.get(d["attributes"]);
                    targetPos = helperPosition_.get(c["attributes"]);
                    sourceShape = objectCollector_.get(d["attributes"]);
                    targetShape = objectCollector_.get(c["attributes"]);
                    a = {
                        cx: targetPos[which[1]][5],
                        cy: targetPos[which[1]][4],
                        linkPoint: which[1],
                        rx: sourceShape.rx(),
                        ry: sourceShape.ry()
                    };
                    b = {
                        cx: sourcePos[which[0]][5],
                        cy: sourcePos[which[0]][4],
                        linkPoint: which[0],
                        rx: targetShape.rx(),
                        ry: targetShape.ry()
                    };
                    links.push({
                        source: b,
                        target: a
                    });
                }
            });
        });
        // Find max key-value.
        var _max = _ids.sort().pop();
        // Init some constants
        dataFactory_.init(_max || 1);

        _ids = null;

        return {
            nodes: nodes,
            links: links
        };
    }
    // Lin path function.
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

    function fixCenterData_(source, target) {
        if (target.cx == source.cx || target.cy == source.cy)
            return '';
        var v1, v2;
        v1 = target.cy - source.cy;
        v2 = target.cx - source.cx;

        if ((source.linkPoint == 'l' || source.linkPoint == 'r') && (target.linkPoint == 'l' || target.linkPoint == 'r') && Math.abs(target.cx - source.cx) < target.rx) {
            if (v1 || v2) {
                return 'L' + (source.cy + target.cy) / 2 + ',' + source.cx +
                    'L' + (source.cy + target.cy) / 2 + ',' + target.cx;
            }
        } else {
            if ((source.linkPoint == 't' || source.linkPoint == 'b') && (target.linkPoint == 't' || target.linkPoint == 'b') && Math.abs(target.cy - source.cy) < target.ry) {
                if (v1 || v2) {
                    return 'L' + source.cy + ',' + (source.cx + target.cx) / 2 +
                        'L' + target.cy  + ',' + (source.cx + target.cx) / 2;
                }
            }
        }

        return 'L' + target.cy + ',' + source.cx;
    }

    // polyline path function.
    function polylineData_(d) {
        var source = d.source,
            target = d.target;

        //M216,484L893,686
        var path = [
            'M' + source.cy + ',' + source.cx,
            fixCenterData_(source, target),
            'L' + target.cy + ',' + target.cx
        ];
        return path.join('');
    }

    // Render elements in SVG.
    function renderSVG_() {
        d = parseData_(gData_);
        gBindData_ = d["nodes"];
        gLinkData_ = d["links"];
        var arr = gBindData_;

        var shape = gSVG_.selectAll(".element").data(arr);
        var shapeEnter = shape.enter();
        var shapeExit = shape.exit();
        gNodeEnter_ = shapeEnter;
        gNodeUpdate_ = shape;
        gNodeExit_ = shapeExit;

        var g = gNodeEnter_.append("g")
            .attr("data-shape-type", function(d) {
                return d.type;
            })
            .attr("class", function(d) {
                if (gCurrentSelectedData_ == d) return "element current";
                return "element";
            })
            .attr("id", function(d) {
                return elementID_["generate"](dataFactory_.getId(d));
            })
            .each(function(d) {
                shapeFactory_["render"](d, d3.select(this));
            });

        gNodeExit_.transition().remove();

        var link = gSVG_.selectAll(".node_link")
            .data(gLinkData_)
            .enter().append("path")
            .attr("class", "node_link")
            .attr("d", polylineData_);
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
    // Do insert shape
    function insertShape_(shapeType) {
        if (hasOwnProp_(shapeMaker_, shapeType)) {
            dataFactory_["addNew"](shapeType);
            repaint_();
        } else {
            console.log("unsupported shape type(:" + shapeType + ").");
        }
    }
    // Do get data-json-string
    function dataJsonEncode_() {
        return dataFactory_['stringify']();
    }

    // Relative fn with ZSYFCEditor
    exportLabel_("init", initPage_);
    exportLabel_('addShape', insertShape_);
    exportLabel_('getData', dataJsonEncode_);
    //---------------------------------------------
    // Export object.
    //---------------------------------------------
    window[ns] = ZSYFCEditor;
}("ZSYFCEditor");