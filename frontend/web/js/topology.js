/**
 * Created by Shengjun on 15-7-9.
 */
( function () { 
   
    var detailUrl = '/stat/device/ajax-device-tip';

    var switchStatusImg = {
        '-1': "/images/building_switch_status2/s-1.gif",
        '0': "/images/building_switch_status2/s0.gif",
        '1': "/images/building_switch_status2/s1.gif",
        '2': "/images/building_switch_status2/s2.gif",
        '3': "/images/building_switch_status2/s3.gif",
        '4': "/images/building_switch_status2/s4.gif",
        '5': "/images/building_switch_status2/s5.gif"
    }; 

    var _showNodeDetail = function(d, e, contentHtmlTpl) { 
        var $tg = $(e.target);
        if (false == $tg.is(".element")) {
            $tg = $tg.closest(".element");
        }
        $tg = $tg.find(".shape");

        var offset = $tg.offset();
        var x = offset.left,
            y = offset.top;

        var contentTpl = '<div class="popupBody">' +
            '<div class="popup_close" title="关闭">&nbsp;</div>' +
            '<div class="popup_content" >{content}</div>' +
            '</div>';

        var offsetX = 33,
            offsetY = 15;
        
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
                // nodeDetail_.json : fail data, nodeDetail.json: ok data.
                var id  = ZSYFCEditor.getData()[ d[ ZSYFCEditorConfig['ID_KEY'] ] ]["data"]["id"];
                $.get(detailUrl, {
                    id: id
                }, function(j) {
                    $content.find("div.popup_content").html(j);
                    popPanel.refresh(); 
                    return;
                    if (j.result == 1) {
                        $content.find("div.popup_content").html(_updateContent(_parseData(j.data)));
                    } else {
                        $content.find("div.popup_content").html(_updateContent(j.msg));
                    }
                    popPanel.refresh();
                }, 'html');
            }
        }).init().show(x, y);
    }; 






    var ZSYFCEditorConfig = window.ZSYFCEditorConfig = {
        "ID_KEY": "__id__",
        "singleMode": true,
        "shape": { 
            "switch": {
                "rx": 15,
                "ry": 7.5,
                "imgSrc": switchStatusImg["-1"]
            }
        }

    }; 

    var events_type =  {
        categories: ['有害程序', '网络攻击','信息破坏','信息安全','设备故障','安全预警','其他事件'],
        series: [{
            data: [{
                name: 'Point 1',
                color: '#1C9AB6',
                y: 4
            }, {
                name: 'Point 2',
                color: '#4BB097',
                y: 18
            },{
                name: 'Point 2',
                color: '#4E4168',
                y: 13
            },{
                name: 'Point 2',
                color: '#4C7EAC',
                y: 5
            },{
                name: 'Point 2',
                color: '#A75A70',
                y: 8
            },{
                name: 'Point 2',
                color: '#8BAE3D',
                y: 11
            },{
                name: 'Point 2',
                color: '#DE6756',
                y: 6
            }],
            dataLabels:{
                enabled: true,
                align: 'top'
            }
        }]
    };

    function loadDeviceChart(series,categories){
        $('#device_status').highcharts({
            credits: {
                enabled: false
            },
            chart: {
                type: 'column',
                backgroundColor:'transparent',
                marginBottom: 50,
                allowOverlap:true,
                marginTop:20,
                height:200
            },
            plotOptions:{
                series:{
                    groupPadding:0.05,
                    pointPadding:0
                }
            },
            title:{
                text: ''
            },
            xAxis: {
                categories: categories,
                tickLength: 0
            },
            yAxis: {
                title: '',
                gridLineWidth: 0,
                labels:{ enabled:false}
            },
            legend: {
                enabled: false
            },
            series: series
        });
    }

    function loadAlarmTypeChart(series,categories){
        console.log(JSON.stringify(series))
        $('#runtime').highcharts({
            credits: {
                enabled: false
            },
            chart: {
                type: 'bar',
                height: 200,
                backgroundColor:'transparent'
            },
            plotOptions:{
                series:{
                    groupPadding:0.05,
                    pointPadding:0
                }
            },
            title:{
                text: ''
            },
            xAxis: {
                categories: categories,
                tickLength: 0
            },
            yAxis: {
                title: '',
                gridLineWidth: 0,
                labels:{ enabled:false}
            },
            legend: {
                enabled: false
            },
            series: series
        });
    }

    function loadAlarmLevelPie(series){
        $('#events_levels').highcharts({
            credits: {
                enabled: false
            },
            legend: {
                enabled: true,
                layout: 'vertical',
                //backgroundColor: '#FFFFFF',
                align: 'right',
                verticalAlign: 'top',
               // floating: true,
                //x: 0,
                //y: 0
            },
            chart: {
                polar: true,
                height: 200,
                backgroundColor: 'transparent',
                margin: 0
            },

            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                    /*
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y}',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        },
                        connectorColor: 'silver'
                    }*/
                }
            },
            series: series
        });
    }

    function loadAlarmLevelData(series,max){
        var count = series[0].data.length;
        var rote = 360/count;
        console.log(count);
        $('#events_levels').highcharts({
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            chart: {
                polar: true,
                height: 200,
                backgroundColor:'transparent',
                margin:0
            },

            title: {
                text: ''
            },
            pane: {
                startAngle: 0,
                endAngle: 360
            },
            xAxis: {
                tickInterval: rote,
                min: 0,
                max: 360,
                labels: {
                    enabled:false
                },
                gridLineWidth:0
            },

            yAxis: {
                min: 0,
                lineWidth:0,
                gridLineWidth:0,
                max: max
            },

            plotOptions: {
                series: {
                    pointStart: 0,
                    pointInterval: rote
                },
                column: {
                    pointPadding: 0,
                    groupPadding: 0
                }
            },
            series : series
        });

    }

    // Dom Ready 
    $(function(){ 

        var reloadChart = function(){
            $.ajax({
                url:'/topology/dashboard/ajax-chart-data',
                type:"post",
                data: {"type":1},
                dataType:'json',
                success:function(res){
                    loadDeviceChart(res.device.series,res.device.categories);
                    loadAlarmTypeChart(res.alarmType.series,res.alarmType.categories);
                    loadAlarmLevelData(res.alarmLevel.series,res.alarmLevel.max);
                    //loadAlarmLevelPie(res.alarmLevel.series);
                    setTimeout(reloadChart,30000);
                }
            });
        }
        reloadChart();

        // Render FCEditor
        ZSYFCEditor.init(
            {},
            {
                svg: d3.select("svg.ZSYFCEditor"),
                width: 1366,
                height: 768
            } 
        );

        $('.ZSYFCEditor').click( function (e) {
            var $tg = $(e.target);
            var data = ZSYFCEditor.getData();
            if($tg.is(".shape")){
                var d = d3.select(e.target).datum() || "";
                if( d ){
                    var key = d[ ZSYFCEditorConfig["ID_KEY"] ];
                    if( data[key] ){
                        var id = data[key]["data"]["id"];
                        console.log( "Load page", "http://www.cnpc.com/?id=" + id );
                        window.open( "/stat/device/detail?id=" + id, "building-node-detail" );
                    }
                }
            }
        }).mouseover( function(e){
            var $tg = $(e.target);
            var data = ZSYFCEditor.getData();
            if($tg.is(".shape")){
                var d = d3.select(e.target).datum() || "";
                if( d ){
                     PopupPanel.clearAll();
                    _showNodeDetail(d, e );
                }
            }
        });

        ZSYFCEditor.updateCallback( function(){
            // Update switch status.
            var data = ZSYFCEditor.getData();
            var keys = Object.keys( data ), s, imgSrc; 
            keys.forEach( function ( id ){
                ZSYFCEditor.callFN("shape", id, function (){
                    s = data[id]['data'] ? data[id]['data']["status"] ? data[id]['data']['status'] : '-1' : '-1';
                    imgSrc = switchStatusImg[s] ? switchStatusImg[s] : switchStatusImg['-1'];
                    //alert(imgSrc);
                    this.attr( "href", imgSrc );
                });
            });
            
        } );

        var refreshData = function(){
            $.ajax({
                url:'/topology/dashboard/ajax-refresh',
                type:"post",
                data: {"type":1},
                dataType:'json',
                success:function(res){
                    if(res.build){
                        ZSYFCEditor.updateData(res.build);
                    }
                    setTimeout(refreshData,30000);
                }
            });
        };
        refreshData();
    });

} )();