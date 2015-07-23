! function(_exportName_) {

/**
  *
  * Some resource location.
  *
 **/
	var config_ = { imagesWhereUrl:  '.' };

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
        return new circle_(title, x, y, 20);
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
        return new ellipse_(title, x, y, 20, 30);
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
            .attr("xlink:href", config_["imagesWhereUrl"] + "/images/icons/switch1.png");            
    };
    mainSwitch_.newOne = function (title, x, y){
        return new mainSwitch_(title, x, y, 30, 18);
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
            .attr("xlink:href", config_["imagesWhereUrl"] + "/images/icons/switch2.png");            
    };
    switch_.newOne = function (title, x, y){
        return new switch_(title, x, y, 25, 15);
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
            .attr("xlink:href", config_["imagesWhereUrl"] + "/images/icons/server.png");            
    };
    server_.newOne = function (title, x, y){
        return new server_(title, x, y, 17, 25);
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
            .attr("xlink:href", config_["imagesWhereUrl"] + "/images/icons/db.png");            
    };
    db_.newOne = function (title, x, y){
        return new db_(title, x, y, 19, 13);
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
            .attr("xlink:href", config_["imagesWhereUrl"] + "/images/icons/firewall.png");            
    };
    firewall_.newOne = function (title, x, y){
        return new firewall_(title, x, y, 19, 18);
    };         
    

    // Exports
    window[_exportName_] = function( config ){
		if( config )
			config_ = config;

		return {
			"circle": circle_,
			"rect": rect_,
			"ellipse": ellipse_,
			"mainSwitch": mainSwitch_,
			"switch": switch_,
			"server": server_,
			"db": db_,
			"firewall": firewall_
		}; 
	};

}("FCShapeMaker")