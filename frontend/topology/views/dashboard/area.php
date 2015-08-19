<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-8-4.下午6:49
 * Description:
 */
$this->registerJsFile('/js/vis/dist/vis.min.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerCssFile('/js/vis/dist/vis.min.css');

$this->registerCssFile('/css/popuppanel.css');
$this->registerJsFile('/js/popuppanel.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/area.js',['depends'=>'frontend\assets\AppAsset']);

if($type == \app\models\ViewTemplate::TYPE_WLAN){
    $detailUrl = '/stat/device/wlan-detail?id=';
}else{
    $detailUrl = '/stat/wireless/detail?id=';
}

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
              ,groups: $group
        };
        var nodes = new vis.DataSet();
        var edges = new vis.DataSet();

        var data = {
            nodes: nodes,
            edges: edges
        };
        var network = new vis.Network(container, data, options);
        network.on("click", function (params) {
            //console.log(JSON.stringify(params, null, 4));return;
            var device_id = params["nodes"][0];
            var edgeId = params["edges"][0];

            if(device_id){
                window.location.href = '$detailUrl'+device_id;
            }else if(edgeId){
                showLinkDetail('/topology/dashboard/ajax-link-detail',params,$type)
            }
        });

        function getNodes(){
            var params = {};
            params["area"] = $area;
            params["type"] = $type;
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
