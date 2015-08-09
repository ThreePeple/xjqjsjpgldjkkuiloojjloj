<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-8-4.下午6:49
 * Description:
 */
$this->registerJsFile('/js/vis/dist/vis.min.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerCssFile('/js/vis/dist/vis.min.css');
$js = <<<JS
        var container = document.getElementById("area-network");
        var options = {
            autoResize: true,
              height: '100%',
              width: '100%'
              ,edges:{
                "smooth": {
                      "type": "discrete",
                      "forceDirection": "vertical",
                      "roundness": 0
                    }
              }
              ,nodes:{
                font:{size:14, color:'white', face:'arial'}
              }
              //,physics: false
              /*,layout: {
                  hierarchical: {
                    direction: 'LR'
                  }
                }*/
              ,groups:{
                    "router":{
                        "shape":"image",
                        "image":'/images/icons2/router.png'
                    },
                    "switch":{
                        "shape":"image",
                        "image":'/images/icons2/mainSwitch.png'
                    },
                    "server":{
                        "shape":"image",
                        "image":'/images/icons2/server.png'
                    },
                    "firewall":{
                        "shape":"image",
                        "image":'/images/icons2/firewall.png'
                    },
                    "db":{
                        "shape":"image",
                        "image":'/images/icons2/db.png'
                    },
                    "wireless":{
                        "shape":"image",
                        "image":'/images/icons2/wireless.png'
                    },
                    "printer":{
                        "shape":"image",
                        "image":'/images/icons2/printer.png'
                    },
                    "ups":{
                        "shape":"image",
                        "image":'/images/icons2/ups.png'
                    },
                    "pc":{
                        "shape":"image",
                        "image":'/images/icons2/pc.png'
                    }
              }
        };
        var nodes = new vis.DataSet();
        var edges = new vis.DataSet();

        var data = {
            nodes: nodes,
            edges: edges
        };
        var network = new vis.Network(container, data, options);
        network.on("click", function (params) {
            var device_id = params["nodes"][0];
            if(!device_id) return;
            //console.log(JSON.stringify(params, null, 4));
            window.location.href = '/stat/device/wlan-detail?id='+device_id;
        });
        function getNodes(){
            var params = {};
            params["area"] = $area;
            //network.setData();
            $.ajax({
                url:'/topology/dashboard/ajax-get-nodes',
                data:params,
                type:'POST',
                dataType:'JSON',
                success:function(res){
                    nodes.update(res.nodes);
                    edges.update(res.edges);
                    setTimeout(getNodes,1000)
                }
            })
        }

        getNodes();

JS;
$this->registerJs($js);

?>
<div id="area-network" style="width: 100%;height: 600px;margin-top: 50px;">

</div>
