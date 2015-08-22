( function (_exportName_){ 
    var console = ZSYFCEditorUtil.console;
    var helperSquareD_ = 0;// 四边节点直径（接连线）
    
    // Object-collector factory
    var objectCollector_ = window["FCObjectCollector"];

    var ID_KEY = ZSYFCEditorConfig["ID_KEY"];

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
                        shape.cx() ,
                        shape.cy() ,
                        helperSquareD_,
                        helperSquareD_,
                        shape.cx(),
                        shape.cy() 
                    ];
                    // right
                    posMap["r"] = [
                        shape.cx() ,
                        shape.cy() ,
                        helperSquareD_,
                        helperSquareD_,
                        shape.cx() ,
                        shape.cy()
                    ];

                    // bottom
                    posMap["b"] = [
                        shape.cx() ,
                        shape.cy() ,
                        helperSquareD_,
                        helperSquareD_,
                        shape.cx(),
                        shape.cy() 
                    ];
                    // left
                    posMap["l"] = [
                        shape.cx() ,
                        shape.cy() ,
                        helperSquareD_,
                        helperSquareD_,
                        shape.cx() ,
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
