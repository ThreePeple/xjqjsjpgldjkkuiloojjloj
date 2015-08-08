(function(_exportName_) {
    var console = ZSYFCEditorUtil.console;
    var ID_KEY = ZSYFCEditorConfig["ID_KEY"];
    var undefined;
    // Object has owner property ?
    var hasOwnProp_ = function(o, p) {
        return Object.prototype.hasOwnProperty.call(o, p);
    };
    // Sub array
    var slice_ = function(arrLike, index) {
        return Array.prototype.slice.call(arrLike, index);
    };
    var safeKey_ = function(key) {
        if (key == undefined)
            return false;
        key = String(key);
        switch (key) {
            case "prototype":
            case "__proto__":
            case "__defineSetter__":
            case "__defineGetter__":
            case "__lookupGetter__":
            case "__lookupSetter__":
            case "constructor":
            case "hasOwnProperty":
            case "isPrototypeOf":
            case "propertyIsEnumerable":
            case "toLocaleString":
            case "toString":
            case "valueOf":
            case "arguments":
            case "caller":
            case "length":
            case "name":
            case "set __proto__":
            case "get __proto__":
                return false;
        }
        return true;
    };


    var nodeData_ = {
        "data_": null,
        "setData": function(d) {
            if (typeof d == "object" && d) {
                this["data_"] = d;
            } else {
                this["data_"] = null;
            }
            return this;
        },
        "getData": function() {
            if (this["data_"] != null) {
                return this["data_"];
            }
            throw "FCNodeData: init firstly.";
        },
        "removeItem": function(key) {
            if (this.hasItem(key)) {
                delete this["data_"][key];
                return true;
            }
            return false;
        },
        "hasItem": function(key) {
            if (this["data_"] && hasOwnProp_(this["data_"], key) && this["data_"][key] != undefined ) {
                return true;
            }
            return false;
        },
        "getItem": function(key) {
            if (this.hasItem(key)) {
                return this["data_"][key];
            }
            return null;
        },
        "setItem": function(key, data) {
            if (this["data_"] && safeKey_(key)) {
                this["data_"][key] = data;
                return true;
            }
            return false;
        },
        "clear": function() {
            this["data_"] = null;
            return this;
        }
    };
    window[_exportName_] = nodeData_;
})("FCNodeData");