(function() {
    var data;

    var polymerChart;

    var svgWidth = 1000,
        svgHeight = 1000,
        circleRadius = 160;

    var polymerWidth,
        polymerHeight,
        polymer1CenterX,
        polymer1CenterY,
        polymer2CenterX,
        polymer2CenterY;

    var groupsHPadding,
        groupsVPadding;

    var nodeCircleRadius = 5;

    var groupCenterXY = {}; 

    var fromAngle = function(pi) {
            var angle = pi * 180 / Math.PI;
            return angle;
        }(Math.PI / 4),
        toAngle = function(pi) {
            var angle = pi * 180 / Math.PI;
            return angle;
        }(Math.PI * 7 / 4);

    var init = function(config) {
        config = config || {};

        if (!config.data)
            throw "missing data inited."

        data = config.data;

        svgWidth = config.svgWidth || 1100;
        svgHeight = config.svgHeight || 1100;
        circleRadius = 160;

        polymerWidth = 60;
        polymerHeight = 30;


        groupsHPadding = polymerWidth + 100,
        groupsVPadding = polymerHeight + 60;

        groupCenterXY["group1"] = {
            x: (svgWidth - groupsHPadding) / 2 - circleRadius,
            y: (svgHeight - groupsVPadding) / 2 - circleRadius
        };
        groupCenterXY["group2"] = {
            x: (svgWidth + groupsHPadding) / 2 + circleRadius,
            y: (svgHeight - groupsVPadding) / 2 - circleRadius
        };

        polymer2CenterX = polymer1CenterX = svgWidth / 2;
        polymer1CenterY = groupCenterXY["group1"]["y"] - polymerHeight / 2 - 30;
        polymer2CenterY = groupCenterXY["group1"]["y"] + polymerHeight / 2 + 30;

        xyMap = {};
    };

    var render = function() {
        polymerChart = d3.select("body").append("svg")
            .attr("class", "ZSYPolymerChart")
            .attr("width", svgWidth)
            .attr("height", svgHeight); 
        var group1 = polymerChart.append("g")
            .attr("transform", "translate(" + groupCenterXY["group1"]["x"] + "," + groupCenterXY["group1"]["y"] + ")"); 
        var group2 = polymerChart.append("g")
            .attr("transform", "rotate(180)translate(" + -1 * groupCenterXY["group2"]["x"] + "," + -1 * groupCenterXY["group2"]["y"] + ")"); 

        _renderPolymers(); 
        _renderGroup("group1", data.groups, group1);
        _renderGroup("group2", data.groups, group2, true); 
        _renderLinks(data.polymers);

        _bindEvents();
    };

    var _highlightNode = function ( d, highlight ){ 
        var id = d.data.id; 
        if( highlight ){
            d3.select('#'+ id ).classed("hover", true);
            d3.selectAll([ '#p1_' + id, '#p2_' + id ].join(",")).classed("hover", true);
        } else {
            d3.select('#'+ id ).classed("hover", false);
            d3.selectAll([ '#p1_' + id, '#p2_' + id ].join(",")).classed("hover", false);
        }
    };
    var _bindEvents = function (){
        polymerChart.selectAll("g.node")
        .on("mouseover", function (){
           var d = d3.select(this).datum();
           _highlightNode( d, true );
        })
        .on("mouseout", function (){
           var d = d3.select(this).datum();
           _highlightNode( d, false );
        });
    };

    var _genSource = function( fromData, group, containerXY ){
        var x, y;
        switch( group ){
            case "group1":
                x = fromData.left;
                y = fromData.top + polymerHeight / 2; 
                return { x: x - containerXY.left, y: y - containerXY.top}; 
            case "group2":
                x = fromData.left + polymerWidth;
                y = fromData.top + polymerHeight / 2; 
                return { x: x - containerXY.left, y: y - containerXY.top}; 
        }
        console.log("Group: ", group);
        throw "Invalid data.";
    };

    var _renderLinks = function (polymers){
        var links = [], from, to;
        polymers.forEach( function( polymer ){
            from = polymer.id;
            polymer.children && polymer.children.forEach( function (link) {
                if( link ){
                    link = link.split(":");
                    if( link[1] != undefined ){
                        to = link[1];
                        links.push( { from: from, to: to, group: link[0] } );
                    }
                }
            });
        } ); 
         
        var map = {}, source, target ;
        var containerXY = $(polymerChart.node()).offset();
        links.forEach( function (link, idx){
            if( undefined == map[ link.from ] ) {
                map[ link.from ] = $('#'+link.from).offset();
            }
            source = _genSource( map[link.from], link.group, containerXY ) ;
            if( undefined == map[ link.to ] ) {
                map[ link.to ] = $('#'+link.to + " circle").offset();
            }
            target = { x: map[ link.to ].left + nodeCircleRadius - containerXY.left, 
                        y: map[ link.to ].top + nodeCircleRadius - containerXY.top };

            links[idx] = { source: source, target: target, linkPath: link.from + "_" + link.to  };
        });
        _renderPath( links ); 
        map = null; 
    };

    var _renderPath = function ( links ){
        polymerChart.selectAll(".link-path")
        .data(links)
        .enter()
        .append("path")
        .attr("class", "link-path")
        .attr("id", function (d){
            return d.linkPath;
        })
        .attr("d", function (d){
            return d3.svg.diagonal()
                    .source(d.source)
                    .target(d.target)
                    .projection(function(d){
                      var r = d.y, a = (d.x - 90) / 180 * Math.PI;
                      return [d.x, d.y];
                    })(); 
        });        
    };

    var _renderPolymers = function() {
        var g;
        data.polymers.forEach(function(polymer, idx) {
            g = polymerChart.append("g");
            switch (idx) {
                case 0:
                    g.append("ellipse")
                        .attr("id", polymer.id)
                        .attr("class", "shape shape" + idx)
                        .attr("cx", polymer1CenterX)
                        .attr("cy", polymer1CenterY)
                        .attr("rx", polymerWidth / 2)
                        .attr("ry", polymerHeight / 2);
                    g.append("text")
                        .attr("x", polymer1CenterX)
                        .attr("y", polymer1CenterY - 20 )
                        .attr("text-anchor", "middle")
                        .text(polymer.label);
                    break;
                case 1:
                    g.append("ellipse")
                        .attr("id", polymer.id)
                        .attr("class", "shape shape" + idx)
                        .attr("cx", polymer1CenterX)
                        .attr("cy", polymer2CenterY)
                        .attr("rx", polymerWidth / 2)
                        .attr("ry", polymerHeight / 2);
                    g.append("text")
                        .attr("x", polymer1CenterX)
                        .attr("y", polymer2CenterY + polymerHeight )
                        .attr("text-anchor", "middle")
                        .text(polymer.label);
                    break;
            }
        });
    };
    var _renderGroup = function(groupId, groupData, group, clockwise) { 
        // Nodes surrounding direction.
        clockwise = !!clockwise;

        var data = groupData[groupId];
        var count = data.length;
        var genAngle = d3.scale.linear()
            .domain([0, count - 1])
            .range([fromAngle, toAngle]);

        var pie = function(data) {
            var wrap = [];
            var count = data.length,
                i = 0;
            var x, y;
            for (; i < count; i++) { 
                wrap.push({
                    data: data[i],
                    angle: genAngle(i)
                });
            } 
            return wrap;
        };

        var nodes;

        if (clockwise == false) {
            nodes = group.selectAll(".node")
                .data(pie(data))
                .enter()
                .append("g")
                .attr("id", function(d) {
                    return d.data.id;
                })
                .attr("transform", function(d) {
                    return "rotate(" + (360 - d['angle']) + ")translate(" + circleRadius + ")";
                })
                .attr("class", "node");

            nodes.append("circle")
                .attr("r", nodeCircleRadius)
                .attr("title", function(d) {
                    return d.data.label;
                })
                .attr("angle", function(d) {
                    return d['angle'];
                })
                .attr('cx', 1)
                .attr("cy", -4);

            nodes.append("text")
                .attr("dx", nodeCircleRadius)
                .attr("dy", 0)
                .text(function(d) {
                    return d.data['label'];
                }); 


        } else {
            nodes = group.selectAll(".node")
                .data(pie(data))
                .enter()
                .append("g")
                .attr("id", function(d) {
                    return d.data.id;
                })
                .attr("transform", function(d) {
                    return "rotate(" + (d['angle']) + ")translate(" + circleRadius + ")";
                })
                .attr("class", "node");

            nodes.append("circle")
                .attr("r", nodeCircleRadius)
                .attr("title", function(d) {
                    return d.data.label;
                })
                .attr("angle", function(d) {
                    return d['angle'];
                })
                .attr('cx', 1)
                .attr("cy", -4);

            nodes.append("text")
                .attr("dx", nodeCircleRadius)
                .attr("dy", 0)
                .text(function(d) {
                    return d.data['label'];
                });

        } 
    }; 

    window["ZSYPolymerChart"] = {
        "init": init,
        "render": render
    };
})();