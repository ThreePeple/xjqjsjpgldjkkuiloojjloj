( function (_exportName_){ 
    var console = ZSYFCEditorUtil.console;
    var helperSquareD_ = 6;// 四边节点直径（接连线）
    
    // Object-collector factory
    var objectCollector_ = window["FCObjectCollector"];

    var ID_KEY = ZSYFCEditorConfig["ID_KEY"];

    var delta = 10;

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
                        shape.cy() - shape.ry() - helperSquareD_ / 2 + delta,
                        helperSquareD_,
                        helperSquareD_,
                        shape.cx(),
                        shape.cy() - shape.ry() + delta
                    ];
                    // right
                    posMap["r"] = [
                        shape.cx() + shape.rx() - helperSquareD_ / 2 - delta,
                        shape.cy() - helperSquareD_ / 2,
                        helperSquareD_,
                        helperSquareD_,
                        shape.cx() + shape.rx() - delta,
                        shape.cy()
                    ];

                    // bottom
                    posMap["b"] = [
                        shape.cx() - helperSquareD_ / 2,
                        shape.cy() + shape.ry() - helperSquareD_ / 2 - delta,
                        helperSquareD_,
                        helperSquareD_,
                        shape.cx(),
                        shape.cy() + shape.ry() - delta
                    ];
                    // left
                    posMap["l"] = [
                        shape.cx() - shape.rx() - helperSquareD_ / 2 + delta,
                        shape.cy() - helperSquareD_ / 2,
                        helperSquareD_,
                        helperSquareD_,
                        shape.cx() - shape.rx() + delta,
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
	window[_exportName_] = helperPosition_;
})("FCHelperPosition");
