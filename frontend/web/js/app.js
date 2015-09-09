function renderHub(dataUrl, containerId, detailUrl) {
    var radius = 600 / 2; // SVG radius

    var cluster = d3.layout.cluster()
        .size([300, radius - 150]);

    var diagonal = d3.svg.diagonal.radial()
        .projection(function(d) {
            return [d.y, d.x / 150 * Math.PI];
        });

    var svg = d3.select("#" + containerId).append("svg")
        .attr("width", radius * 2)
        .attr("height", radius * 2)
        .append("g")
        .attr("transform", "translate(" + radius + "," + radius + ")");

    var _getNodeDetailTpl = function() {
        var tmp = null;
        return function() {
            if (!tmp) {
                tmp = $('#switch_node_detail').html();
            }
            return tmp;
        };
    }();

    var _showNodeDetail = function(d, e, contentHtmlTpl) {
        console.log(d, e, contentHtmlTpl)
        var $tg = $(e.target);
        if (false == $tg.is("g.box")) {
            $tg = $tg.closest("g.box");
        }
        $tg = $tg.find("circle");

        var offset = $tg.offset();
        var x = offset.left,
            y = offset.top;

        var contentTpl = '<div class="popupBody">' +
            '<div class="popup_close" title="关闭">&nbsp;</div>' +
            '<div class="popup_content" >{content}</div>' +
            '</div>';

        var offsetX = 0,
            offsetY = 0;
        var className = "nodeDetail";
        var _parseData = function(data) {
            if (data) {
                for (var p in data) {
                    contentHtmlTpl = contentHtmlTpl.replace('{' + p + '}', data[p]);
                }
                return contentHtmlTpl;
            }
            return "<span class='none'>No data.</span>";
        };
        var _updateContent = function(html) {
            return contentTpl.replace("{content}", html);
        };
        var popPanel = new PopupPanel({
            className: 'modalessDialog' + (className ? " " + className : ""),
            offsetX: offsetX,
            offsetY: offsetY,
            destroy: true,
            animate: false,
            closeHandler: function() {},
            content: contentTpl,
            initInterface: function($content) {
                var inst = this;
                $content.click(function(e) {
                    if ($(e.target).is('div.popup_close'))
                        inst.close(true);
                });

                $content.find("div.popup_content").html(_updateContent("loading..."));
                console.log(d)
                // nodeDetail_.json : fail data, nodeDetail.json: ok data.
                $.get(detailUrl, {
                    node: d.id
                }, function(j) {
                    if (j.result == 1) {
                        $content.find("div.popup_content").html(_updateContent(_parseData(j.data)));
                    } else {
                        $content.find("div.popup_content").html(_updateContent(j.msg));
                    }
                    popPanel.refresh();
                }, 'json');
            }
        }).init().show(x, y);
    };
    d3.json(dataUrl, function(error, root) {
        if (error) throw error;

        var nodes = cluster.nodes(root);
        var link = svg.selectAll("path.link")
            .data(cluster.links(nodes))
            .enter().append("path")
            .attr("class", function(d) {
                if (d['target']['status'] == 0)
                    return "link error";
                return "link";
            })
            .attr("d", diagonal);

        var _path = function(node) {
            var len = link[0].length;
            for (var i = 0; i < len; i++) {
                if (d3.select(link[0][i]).data()[0].target == d3.select(node).data()[0]) {
                    return d3.select(link[0][i]);
                }
            }
            return d3.select();
        };

        var node = svg.selectAll("g.node")
            .data(nodes)
            .enter().append("g")
            .attr("class", function(d) {
                if (d['status'] == 0)
                    return "node error";
                return "node";
            })
            .attr("transform", function(d) {
                return "rotate(" + (d.x - 90) + ")translate(" + d.y + ")";
            });


        node = node.append("g")
            .attr("class", "box")
            .on("mouseover", function() {
                _path(this.parentNode).classed("hover", true);
            })
            .on("mouseout", function() {
                _path(this.parentNode).classed("hover", false);
            })
            .on("click", function(data) {
                _showNodeDetail(data, d3.event, _getNodeDetailTpl());
            });

        node.append("rect")
            .attr("x", "-5")
            .attr("y", "-5")
            .attr("width", "30px")
            .attr("height", "10px")
        //.attr("fill", "red"); // Fixed: g.box:hover 遇到空隙会闪烁
        .attr("fill", "transparent");

        node.append("circle")
            .attr("cx", "0.15em")
            .attr("r", 4.5);

        node.append("text")
            .attr("dy", ".31em")
            .attr("text-anchor", function(d) {
                return d.x < 180 ? "start" : "end";
            })
            .attr("level", function(d) {
                return d.depth;
            })
            .attr("transform", function(d) {
                return d.x < 180 ? "translate(8)" : "rotate(180)translate(-8)";
            })
            .text(function(d) {
                return d.name;
            });
    });

    d3.select(self.frameElement).style("height", radius * 2 + "px");
}