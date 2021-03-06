! function(_exportName_) {

    var console = ZSYFCEditorUtil.console;
/**
  *
  * Some resource location.
  *
 **/
	var config_ = ZSYFCEditorConfig["shape"];

    var MAP_ = {
        "title_": "title",
        "cx_": "cx",
        "cy_": "cy",
        "rx_": "rx",
        "ry_": "ry"
    };

    var TypeMap_ = {
        "title_": "string",
        "cx_": "int",
        "cy_": "int",
        "rx_": "int",
        "ry_": "int" 
    };

    var array_ = function(args) {
        if (args) {
            return Array.prototype.slice.call(args, 0);
        }
        return [];
    };

    var metaMethod_ = function(key) {
        // Filter invalid keys.
        switch (key) {
            case "constructor":
            case "prototype":
            case "__proto__":
                throw new Error("Invalid key.");
                break;
        }
        return function(v) {
            if (v !== undefined) {
                switch( TypeMap_[key] ){
                    case "string":
                        this[key] = String(v);
                        break;
                    case "int":
                        this[key] = +(v); 
                        break;
                }
                this.update_(key, this[key]);
            }
            return this[key];
        };
    };

    var metaMethod1_ = function(key) {
        return function(v) {
            var v_ = metaMethod_(key).call(this, v);
            if (v !== undefined) {
                this["r_"] = String(v);
                this["rx_"] = String(v);
                this["ry_"] = String(v);
                this.update_("r_", this["r_"]);
            }
            return v_;
        };

    };

    var constructor_ = function(shapeName) {
        return function(title, cx, cy, rx, ry) {
            var args_ = [shapeName, title, cx, cy, rx, ry];
            base_.apply(this, args_);
        };
    };

    var base_ = function(type, title, cx, cy, rx, ry) {
        this.type_ = type;
        this.bindData_ = null;

        this.title_ = title;
        this.cx_ = cx;
        this.cy_ = cy;
        this.rx_ = rx;
        this.ry_ = ry;
    };
    base_.prototype.update_ = function(p, v) {
        var d = this.bindData_;  
        var key = MAP_[p]; // Convert key. 
        if (d && (key in d)) {
            d[key] = v;
        }
    };
    base_.prototype.bindData = function(d) {
        if (typeof d != 'object') {
            throw "Invalid parameter.";
        }

        this.bindData_ = d;
        return this;
    };
    base_.prototype.getBindData = function (){
        if( this.bindData_ )
            return JSON.parse( JSON.stringify(this.bindData_) ); // Clone object.
        return null;
    };
    base_.prototype.fromData = function(d) {
        if (typeof d != 'object') {
            throw "Invalid parameter.";
        }
        // Reassign variables from {d}
        this.type_ = d["type"];
        this.title_ = d["title"];
        this.cx_ = d.cx;
        this.cy_ = d.cy;
        this.rx_ = d.rx;
        this.ry_ = d.ry;
        return this;
    };

    base_.prototype.toData = function() {
        return {
            "type": this.type_,
            "title": this.title_,
            "cx": this.cx_,
            "cy": this.cy_,
            "rx": this.rx_,
            "ry": this.ry_
        };
    };

    base_.prototype.getType = function() {
        return this.type_;
    };

    base_.prototype.render = function( g ){
        throw "Unimplement function.";
    };

    // Meta method
    base_.prototype.title = metaMethod_("title_");
    base_.prototype.cx = metaMethod_("cx_");
    base_.prototype.cy = metaMethod_("cy_");
    base_.prototype.rx = metaMethod_("rx_");
    base_.prototype.ry = metaMethod_("ry_");


    var circle_ = function(title, cx, cy, r) {
        var args_ = ["circle", title, cx, cy, r, r];
        base_.apply(this, args_);
        this.r_ = r;
    };
    circle_.prototype = new base_();
    circle_.prototype.update_ = function(p, v) {
        var d = this.bindData_;
        var k = MAP_[p];
        if (d && (k in d)) {
            if (k == 'rx' || k == 'ry') {
                k = 'r';
            }
            d[k] = v;
        }
    };
    circle_.prototype.constructor = circle_;
    circle_.prototype.r = metaMethod1_("r_");
    circle_.prototype.fromData = function(d) {
        if (typeof d != 'object') {
            throw "Invalid parameter.";
        }
        // Reassign variables from {d}
        this.type_ = d["type"];
        this.title_ = d["title"];
        this.cx_ = d.cx;
        this.cy_ = d.cy;
        this.rx_ = d.r;
        this.ry_ = d.r;
        this.r_ = d.r;
        return this;
    };
    circle_.prototype.toData = function() {
        return {
            "type": this.type_,
            "title": this.title_,
            "cx": this.cx_,
            "cy": this.cy_,
            "r": this.r_
        };
    };
    circle_.prototype.render = function ( g ){
        var shape = this;
        return g.append("circle")
            .attr("class", "shape")
            .attr("cx", shape.cx())
            .attr("cy", shape.cy())
            .attr("r", shape.r()); 
    };
    circle_.newOne = function (title, x, y){
        return new circle_(title, x, y, config_["circle"]["r"]);
    };

    var rect_ = constructor_("rect");
    rect_.prototype = new base_();
    rect_.prototype.constructor = rect_;

    // TODO: render & newOne.

    var ellipse_ = constructor_("ellipse");
    ellipse_.prototype = new base_();
    ellipse_.prototype.constructor = ellipse_;
    ellipse_.prototype.render = function (g){
        var shape = this;
        return g.append("ellipse")
            .attr("class", "shape")
            .attr("cx", shape.cx())
            .attr("cy", shape.cy())
            .attr("rx", shape.rx())
            .attr("ry", shape.ry());            
    };
    ellipse_.newOne = function (title, x, y){
        return new ellipse_(title, x, y, config_["ellipse"]["rx"], config_["ellipse"]["ry"]);
    }; 
    

    var mainSwitch_  = constructor_("mainSwitch");
    mainSwitch_.prototype = new base_();
    mainSwitch_.prototype.constructor = mainSwitch_;
    mainSwitch_.prototype.render = function (g){
        var shape = this;
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href", config_["mainSwitch"]["imgSrc"]);            
    };
    mainSwitch_.newOne = function (title, x, y){
        return new mainSwitch_(title, x, y, config_["mainSwitch"]["rx"], config_["mainSwitch"]["ry"]);
    }; 

    var coreSwitch_  = constructor_("coreSwitch");
    coreSwitch_.prototype = new base_();
    coreSwitch_.prototype.constructor = coreSwitch_;
    coreSwitch_.prototype.render = function (g){
        var shape = this;
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href", config_["coreSwitch"]["imgSrc"]);            
    };
    coreSwitch_.newOne = function (title, x, y){
        return new coreSwitch_(title, x, y, config_["coreSwitch"]["rx"], config_["coreSwitch"]["ry"]);
    }; 


    var switch_  = constructor_("switch");
    switch_.prototype = new base_();
    switch_.prototype.constructor = switch_;
    switch_.prototype.render = function (g){
        var shape = this; 
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href", config_["switch"]["imgSrc"]);            
    };
    switch_.newOne = function (title, x, y){
        return new switch_(title, x, y, config_["switch"]["rx"], config_["switch"]["ry"]);
    }; 

    var server_  = constructor_("server");
    server_.prototype = new base_();
    server_.prototype.constructor = server_;
    server_.prototype.render = function (g){
        var shape = this; 
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href", config_["server"]["imgSrc"]);            
    };
    server_.newOne = function (title, x, y){
        return new server_(title, x, y, config_["server"]["rx"], config_["server"]["ry"]);
    }; 

    var db_  = constructor_("db");
    db_.prototype = new base_();
    db_.prototype.constructor = db_;
    db_.prototype.render = function (g){
        var shape = this; 
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href",config_["db"]["imgSrc"]);            
    };
    db_.newOne = function (title, x, y){
        return new db_(title, x, y, config_["db"]["rx"], config_["db"]["ry"]);
    }; 

    var driver_  = constructor_("driver");
    driver_.prototype = new base_();
    driver_.prototype.constructor = driver_;
    driver_.prototype.render = function (g){
        var shape = this; 
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href",config_["driver"]["imgSrc"]);            
    };
    driver_.newOne = function (title, x, y){
        return new driver_(title, x, y, config_["driver"]["rx"], config_["driver"]["ry"]);
    };  


    var firewall_  = constructor_("firewall");
    firewall_.prototype = new base_();
    firewall_.prototype.constructor = firewall_;
    firewall_.prototype.render = function (g){
        var shape = this; 
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href", config_["firewall"]["imgSrc"]);            
    };
    firewall_.newOne = function (title, x, y){
        return new firewall_(title, x, y, config_["firewall"]["rx"], config_["firewall"]["ry"]);
    };         
    
    var router_  = constructor_("router");
    router_.prototype = new base_();
    router_.prototype.constructor = router_;
    router_.prototype.render = function (g){
        var shape = this; 
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href", config_["router"]["imgSrc"]);            
    };
    router_.newOne = function (title, x, y){
        return new router_(title, x, y, config_["router"]["rx"], config_["router"]["ry"]);
    };

    var wireless_  = constructor_("wireless");
    wireless_.prototype = new base_();
    wireless_.prototype.constructor = wireless_;
    wireless_.prototype.render = function (g){
        var shape = this; 
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href", config_["wireless"]["imgSrc"]);            
    };
    wireless_.newOne = function (title, x, y){
        return new wireless_(title, x, y, config_["wireless"]["rx"], config_["wireless"]["ry"]);
    };

    var printer_  = constructor_("printer");
    printer_.prototype = new base_();
    printer_.prototype.constructor = printer_;
    printer_.prototype.render = function (g){
        var shape = this; 
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href", config_["printer"]["imgSrc"]);            
    };
    printer_.newOne = function (title, x, y){
        return new printer_(title, x, y, config_["printer"]["rx"], config_["printer"]["ry"]);
    }; 

    var ups_  = constructor_("ups");
    ups_.prototype = new base_();
    ups_.prototype.constructor = ups_;
    ups_.prototype.render = function (g){
        var shape = this; 
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href", config_["ups"]["imgSrc"]);            
    };
    ups_.newOne = function (title, x, y){
        return new ups_(title, x, y, config_["ups"]["rx"], config_["ups"]["ry"]);
    };  

    var pc_  = constructor_("pc");
    pc_.prototype = new base_();
    pc_.prototype.constructor = pc_;
    pc_.prototype.render = function (g){
        var shape = this; 
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href", config_["pc"]["imgSrc"]);            
    };
    pc_.newOne = function (title, x, y){
        return new pc_(title, x, y, config_["pc"]["rx"], config_["pc"]["ry"]);
    };  

    var audio_  = constructor_("audio");
    audio_.prototype = new base_();
    audio_.prototype.constructor = audio_;
    audio_.prototype.render = function (g){
        var shape = this; 
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href", config_["audio"]["imgSrc"]);            
    };
    audio_.newOne = function (title, x, y){
        return new audio_(title, x, y, config_["audio"]["rx"], config_["audio"]["ry"]);
    };  


    var ac_  = constructor_("ac");
    ac_.prototype = new base_();
    ac_.prototype.constructor = ac_;
    ac_.prototype.render = function (g){
        var shape = this; 
        return g.append("image")
            .attr("class", "shape")
            .attr("x", shape.cx() - shape.rx() )
            .attr("y", shape.cy() - shape.ry())
            .attr("width", 2 * shape.rx())
            .attr("height",2 * shape.ry())
            .attr("xlink:href", config_["ac"]["imgSrc"]);            
    };
    ac_.newOne = function (title, x, y){
        return new ac_(title, x, y, config_["ac"]["rx"], config_["ac"]["ry"]);
    };  

    // Exports
    window[_exportName_] = {
    	"circle": circle_,
    	"rect": rect_,
    	"ellipse": ellipse_,
    	"mainSwitch": mainSwitch_,
        "coreSwitch": coreSwitch_,
    	"switch": switch_,
    	"server": server_,
    	"db": db_,
        "driver": driver_,
    	"firewall": firewall_,
        "router": router_,
        "wireless": wireless_,
        "printer": printer_,
        "ups": ups_,
        "pc": pc_,
        "audio": audio_,
        "ac": ac_
	};

}("FCShapeMaker")