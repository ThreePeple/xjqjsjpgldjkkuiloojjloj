(function() {
    var data;

    var polymerChart;

    var svgWidth = 1000,
        svgHeight = 1000,
        circleRadius = 120;

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

    var angle_ = function(pi) {
        var angle = pi * 180 / Math.PI;
        return angle;
    };

    var fromAngle = angle_(Math.PI / 4),
        toAngle = angle_(Math.PI * 7 / 4);

    var bezierCurveData = function() {
        var points;
        var t = 0.5,
            delta = 0.01;

        function interpolate(d, p) {
            var r = [];
            for (var i = 1; i < d.length; i++) {
                var d0 = d[i - 1],
                    d1 = d[i];
                r.push({
                    x: d0.x + (d1.x - d0.x) * p,
                    y: d0.y + (d1.y - d0.y) * p
                });
            }
            return r;
        }

        function getLevels(d, t_) {
            var x = [points.slice(0, d)];
            for (var i = 1; i < d; i++) {
                x.push(interpolate(x[x.length - 1], t_));
            }
            return x;
        }

        function getCurve(d) {
            var curve = [];
            for (var t_ = 0; t_ <= 1; t_ += delta) {
                var x = getLevels(d, t_);
                curve.push(x[x.length - 1][0]);
            }
            return curve;
        }
        return function(threePoints) {
            points = threePoints;
            return getCurve(3);
        };
    }();

    var init = function(config) {
        config = config || {};

        if (!config.data)
            throw "missing data inited."

        data = config.data;

        svgWidth = config.svgWidth || 900;
        svgHeight = config.svgHeight || 900;
        circleRadius = config.circleRadius || 220;

        if (config.from && config.to) {
            fromAngle = angle_(config.from);
            toAngle = angle_(config.to);
        }

        polymerWidth = config.polymerWidth || 120;
        polymerHeight = config.polymerHeight || 35;


        groupsHPadding = config.groupsHPadding || (polymerWidth - 10),
        groupsVPadding = config.groupsVPadding || polymerHeight;

        groupCenterXY["group1"] = {
            x: (svgWidth - groupsHPadding) / 2 - circleRadius,
            y: svgHeight / 2
        };
        groupCenterXY["group2"] = {
            x: (svgWidth + groupsHPadding) / 2 + circleRadius,
            y: svgHeight / 2
        };

        polymer2CenterX = polymer1CenterX = svgWidth / 2;
        polymer1CenterY = groupCenterXY["group1"]["y"] - groupsVPadding / 2 - 10;
        polymer2CenterY = groupCenterXY["group1"]["y"] + groupsVPadding / 2 + 10;

        xyMap = {};
    };

    var render = function() {
        // Init chart.
        polymerChart = d3.select("#ZSYPolymerChart")
            .attr("class", "ZSYPolymerChart")
            .attr("width", svgWidth)
            .attr("height", svgHeight);

        var linkParent = polymerChart.append("g").attr("class", "links");

        // Group 1
        var group1 = polymerChart.append("g")
            .attr("class", "left")
            .attr("transform", "translate(" + groupCenterXY["group1"]["x"] + "," + groupCenterXY["group1"]["y"] + ")");

        // Group 2
        // TODO : 179.38, not 180 ?
        var group2 = polymerChart.append("g")
            .attr("class", "right")
            .attr("transform", "rotate(179.38)translate(" + (-1 * groupCenterXY["group2"]["x"]) + "," + (-1 * groupCenterXY["group2"]["y"]) + ")");

        _renderPolymers();
        _renderGroup("group1", data.groups, group1);
        _renderGroup("group2", data.groups, group2, true);
        _renderLinks(data.polymers, linkParent);
        _bindEvents();
        
        /* 
         * Fixed: 
         *   chrome(版本 44.0.2403.155 m), g.text下的transform无法正确显示（错位），
         *   故而增加 ZSYPolymerChart_rendered
         *
         */
        polymerChart.attr("class", "ZSYPolymerChart ZSYPolymerChart_rendered");
    };

    var _highlightNode = function(d, highlight) {
        var id = d.data.id;
        if (highlight) {
            d3.select('#' + id).classed("hover", true);
            d3.selectAll(['#p1_' + id, '#p2_' + id].join(",")).classed("hover", true);
        } else {
            d3.select('#' + id).classed("hover", false);
            d3.selectAll(['#p1_' + id, '#p2_' + id].join(",")).classed("hover", false);
        }
    };
    var _bindEvents = function() {
        polymerChart.selectAll("g.node")
            .on("mouseover", function() {
                var d = d3.select(this).datum();
                _highlightNode(d, true);
            })
            .on("mouseout", function() {
                var d = d3.select(this).datum();
                _highlightNode(d, false);
            });
    };

    var _genSource = function(fromData, group, containerXY) {
        var x, y;
        switch (group) {
            case "group1":
                x = fromData.left;
                y = fromData.top + polymerHeight / 2;
                return {
                    x: x - containerXY.left,
                    y: y - containerXY.top
                };
            case "group2":
                x = fromData.left + polymerWidth;
                y = fromData.top + polymerHeight / 2;
                return {
                    x: x - containerXY.left,
                    y: y - containerXY.top
                };
        }
        console.log("Group: ", group);
        throw "Invalid data.";
    };

    var _renderLinks = function(polymers, linkParent) {
        var links = [],
            from, to;
        polymers.forEach(function(polymer) {
            from = polymer.id;
            polymer.children && polymer.children.forEach(function(link) {
                if (link) {
                    link = link.split(":");
                    if (link[1] != undefined) {
                        to = link[1];
                        links.push({
                            from: from,
                            to: to,
                            group: link[0]
                        });
                    }
                }
            });
        });

        var map = {},
            source, target;
        var containerXY = $(polymerChart.node()).offset();
        links.forEach(function(link, idx) {
            if (undefined == map[link.from]) {
                map[link.from] = $('#' + link.from).offset();
            }
            source = _genSource(map[link.from], link.group, containerXY);

            if (undefined == map[link.to]) {
                map[link.to] = $('#' + link.to + " circle").offset();
            }
            target = {
                x: map[link.to].left + nodeCircleRadius - containerXY.left,
                y: map[link.to].top + nodeCircleRadius - containerXY.top
            };

            links[idx] = {
                source: source,
                target: target,
                groupCenter: groupCenterXY[link.group],
                linkPath: link.from + "_" + link.to,
                linkFrom: link.from,
                linkTo: link.to
            };
        });
        _renderPath(links, linkParent);
        map = null;
    };

    var line = d3.svg.line()
        .x(function(d) {
            return d.x;
        })
        .y(function(d) {
            return d.y;
        });

    var _renderPath = function(links, linkParent) {
        linkParent.selectAll(".link-path")
            .data(links)
            .enter()
            .append("path")
            .attr("data-from", function(d){return d.linkFrom;})
            .attr("data-to", function(d){return d.linkTo;})
            .attr("class", "link-path")
            .attr("id", function(d) {
                return d.linkPath;
            })
            .attr("d", function(d) {
                return line(bezierCurveData([d.source, d.groupCenter, d.target]));
            });
    };

    var _renderPolymers = function() {
        var g;
        data.polymers.forEach(function(polymer, idx) {
            g = polymerChart.append("g").attr("class", "polymer");
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
                        .attr("y", polymer1CenterY + 5)
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
                        .attr("y", polymer2CenterY + 5)
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

            nodes.append("g").append("circle")
                .attr("r", nodeCircleRadius)
                .attr("title", function(d) {
                    return d.data.label;
                })
                .attr("angle", function(d) {
                    return d['angle'];
                })
                .attr('cx', 1)
                .attr("cy", -4);

            nodes.append("g")
            .attr("class","text") 
            .append("text")
                .attr("dx", 2.5 * nodeCircleRadius)
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

            nodes.append("g").append("circle")
                .attr("r", nodeCircleRadius)
                .attr("title", function(d) {
                    return d.data.label;
                })
                .attr("angle", function(d) {
                    return d['angle'];
                })
                .attr('cx', 1)
                .attr("cy", -4);

            nodes.append("g")
            .attr("class","text") 
            .append("text")
                .attr("dx", 2.5 * nodeCircleRadius)
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