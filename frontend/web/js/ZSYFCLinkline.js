! function(_exportName_) {
	var console = ZSYFCEditorUtil.console;
    var undefined;
    // Data Factory
    var gData_ = window["FCNodeData"];
    // Shape-maker factory
    var shapeMaker_ = window["FCShapeMaker"];
    // Object-collector factory
    var objectCollector_ = window["FCObjectCollector"];
    // Helper Position factory.
    var helperPosition_ = window['FCHelperPosition'];
    // Line Path Position
    var linePathPosition_ = window["FCLinePathPosition"];

    var ID_KEY = ZSYFCEditorConfig["ID_KEY"];

    var key_ = function(v) {
        if (v && typeof v == 'object') {
            if (shapeMaker_[v.type] != undefined) {
                return v[ID_KEY]; // key
            }
        }
        return null;
    };

    // Generate center-part path data.
    var fixCenterData_ = function(source, target) {
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
                        'L' + target.cy + ',' + (source.cx + target.cx) / 2;
                }
            }
        }

        return 'L' + target.cy + ',' + source.cx;
    };

    var pointValue_ = function(v, radius) {
    	radius = radius || 10;
        v = parseInt(v, radius);
        if (isNaN(v)) {
            throw "point value: invalid value.";
        }
        return v;
    };

    var firstAndLastPoint_ = function(points) {
        if (Array.isArray(points) && points.length) {
            var firstPoint = points[0],
                lastPoint = points[points.length - 1];
            return [firstPoint, lastPoint];
        }
        return null;
    };

    var genLinePathPartData_ = function(which, originRect, destRect) {
        helperPosition_.get(this.endD());
    };

    var fixPolylineCenterData_ = function(source, target, points) {
        // Self.
        if (target.cx == source.cx || target.cy == source.cy)
            return '';
        var path_ = [] ;
        if (Array.isArray(points) && points.length) {
        	points.forEach( function ( point, i ){
        		path_.push("L" + pointValue_(point[0]) + "," + pointValue_(point[1]));
        	} );
        	return path_.join("");
        } else {
        	return "";
        }
    };

    // linkLine path function.
    var linkLineData_ = function(d) {
        var source = d.source,
            target = d.target;

        //M216,484L893,686
        var path = [
            'M' + source.cy + ',' + source.cx,
            fixCenterData_(source, target),
            'L' + target.cy + ',' + target.cx
        ];
        return path.join('');
    };

    var linkPolylineData_ = function(d) {
        var source = d.source,
            target = d.target,
            points = d.points;

        //M216,484L893,686
        var path = [
            'M' + source.cy + ',' + source.cx,
            fixPolylineCenterData_(source, target, points),
            'L' + target.cy + ',' + target.cx
        ];
        return path.join('');
    };


    /**
     * Line
     * @constructor
     */
    var Line = function() {
        this.startD_ = null;
        this.endD_ = null;
    };
    Line.prototype.startD = function(d) {
        if (d) {
            this.startD_ = d;
            return this;
        }
        return this.startD_;
    };
    Line.prototype.endD = function(d) {
        if (d) {
            this.endD_ = d;
            return this;
        }
        return this.endD_;
    };
    // SVG: path data.
    Line.prototype.pathData = function() {
        var which,
            sourceShape,
            targetShape,
            sourcePos,
            targetPos;
        var a, b;

        which = linePathPosition_.findShapeHelper(this.startD(), this.endD());
        sourcePos = helperPosition_.get(this.startD());
        targetPos = helperPosition_.get(this.endD());
        sourceShape = objectCollector_.get(this.startD());
        targetShape = objectCollector_.get(this.endD());

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
        return linkLineData_({
            source: b,
            target: a
        });
    };

    Line.prototype.toPlainData = function() {
        var v1 = key_(this.startD_),
            v2 = key_(this.endD_);
        if (v1 == null || v2 == null) {
            throw "Line: init startD_/endD_ firstly.";
        }
        var _j = {
            "type": "line",
            "data": {
                "from": v1,
                "to": v2
            }
        };
        return _j;
    };

    Line.instanceFromData = function(d) {
        if (typeof d != 'object' || d["type"] != "line" || typeof d["data"] != 'object') {
            return null;
        }
        var l = new Line();
        l.startD(gData_.getItem(d['data']['from'])["attributes"]);
        l.endD(gData_.getItem(d['data']['to'])["attributes"]);
        return l;
    };

    var Polyline = function() {
        this.startD_ = null;
        this.linkPoints_ = [];
        this.endD_ = null;
    };

    Polyline.prototype.startD = function(d) {
        if (d) {
            this.startD_ = d;
            return this;
        }
        return this.startD_;
    };

    Polyline.prototype.linkPoints = function(point) {
        if (point) {
            if (point && typeof point == 'object' && point.constructor === Array) {
                this.linkPoints_.push(point);
            }
            return this;
        }
        return this.linkPoints_;
    };
    Polyline.prototype.endD = function(d) {
        if (d) {
            this.endD_ = d;
            return this;
        }
        return this.endD_;
    };
    // SVG: path data.
    Polyline.prototype.pathData = function() {
        var which,
            sourceShape,
            targetShape,
            sourcePos,
            targetPos;
        var a, b;

        sourceShape = objectCollector_.get(this.startD());
        targetShape = objectCollector_.get(this.endD());

        which = linePathPosition_.findShapeHelper(this.startD(), this.endD()); 

        sourcePos = helperPosition_.get(this.startD());
        targetPos = helperPosition_.get(this.endD());


        var points_ = firstAndLastPoint_(this.linkPoints_);
        if(points_){
        	// Point:{first} compare to Point:{first + 1}
	        x = points_[0][0];
	        y = points_[0][1];
	        x = pointValue_(x, 10);
	        y = pointValue_(y, 10);

	        which = linePathPosition_.findHelper(
	            [sourceShape.cx(), sourceShape.cy(), sourceShape.rx(), sourceShape.ry()], [x, y, 0, 0]
	        );

	        b = {
	            cx: sourcePos[which[0]][5],
	            cy: sourcePos[which[0]][4],
	            linkPoint: which[0],
	            rx: 0,
	            ry: 0
	        };	        
	        // Point:{last - 1} compare to Point:{last}
	        x = points_[1][0];
	        y = points_[1][1];
	        x = pointValue_(x, 10);
	        y = pointValue_(y, 10);

	        which = linePathPosition_.findHelper(
	            [x, y, 0, 0], [targetShape.cx(), targetShape.cy(), targetShape.rx(), targetShape.ry()]
	        );

	        a = {
	            cx: targetPos[which[1]][5],
	            cy: targetPos[which[1]][4],
	            linkPoint: which[1],
	            rx: 0,
	            ry: 0
	        };

        } else { // Only link source And target point.
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

        }

        return linkPolylineData_({
            source: b,
            target: a,
            points: this.linkPoints_
        });
    };

    Polyline.prototype.toPlainData = function() {
        var v1 = key_(this.startD_),
            v2 = key_(this.endD_);
        if (v1 == null || v2 == null) {
            throw "Polyline: init startD_/endD_ firstly.";
        }
        var _j = {
            "type": "polyline",
            "data": {
                "from": v1,
                "linkPoints": this.linkPoints_,
                "to": v2
            }
        };
        return _j;
    };
    Polyline.instanceFromData = function(d) {
        if (typeof d != 'object' || d["type"] != "polyline" || typeof d["data"] != 'object') {
            return null;
        }

        var l = new Polyline();
        l.startD(gData_.getItem(d['data']['from'])["attributes"]);
        // Set points.
        d["data"]["linkPoints"].forEach(function(point) {
            l.linkPoints(point);
        })
        l.endD(gData_.getItem(d['data']['to'])["attributes"]);
        return l;
    };

    // Base line types.
    var base_ = {
        "Line": Line,
        "Polyline": Polyline
    };
    // Exports
    window[_exportName_] = {
        "getPathData": function(data) {
            if (data && typeof data == 'object' && data["type"]) {
                switch (data["type"]) {
                    case "line":
                        return base_["Line"].instanceFromData(data).pathData();
                    case "polyline":
                        return base_["Polyline"].instanceFromData(data).pathData();
                }
            }
            return null;
        },
        "base": base_
    };

}("FCLinkline");