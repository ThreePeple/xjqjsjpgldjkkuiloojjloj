( function (_exportName_){ 
	var console = ZSYFCEditorUtil.console;
	var shapeMaker_  = window["FCShapeMaker"]; 
    var ID_KEY = ZSYFCEditorConfig["ID_KEY"];
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
	window[_exportName_] = objectCollector_;
})("FCObjectCollector");
