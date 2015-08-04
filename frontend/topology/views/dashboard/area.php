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
              ,nodes:{
                font:{size:14, color:'white', face:'arial'}
              }
              //,physics: false
              /*
              ,layout: {
                  hierarchical: {
                    sortMethod: 'hubsize'
                  }
                }*/
              ,groups:{
                    "hub":{
                        "shape":"image",
                        "image":'/images/icons/switch1.png'
                    },
                    "server":{
                        "shape":"image",
                        "image":'/images/icons/server.png'
                    },
                    "firewall":{
                        "shape":"image",
                        "image":'/images/icons/firewall.png'
                    },
                    "db":{
                        "shape":"image",
                        "image":'/images/icons/db.png'
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
        function getNodes(){
            var params = {};
            params["area"] = 1;
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
<div id="area-network" style="width: 100%;height: 700px;margin-top: 50px;">

</div>
