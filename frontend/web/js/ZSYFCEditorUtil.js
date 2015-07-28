! function(ns) {
    // Debug mode.
    var DEBUG_ = false;

    
    // Console wrapper.
    var console = {
        "log": function() {
            DEBUG_ && window.console && window.console.log.apply(window.console, arguments);
        }
    };
 
    var ZSYFCEditorUtil = {
        "console": console
    };

    //---------------------------------------------
    // Export object.
    //---------------------------------------------
    window[ns] = ZSYFCEditorUtil;
}("ZSYFCEditorUtil");