/**
 * Created by Shengjun on 15-7-9.
 */
( function () {

    var ZSYFCEditorConfig = window.ZSYFCEditorConfig = {
        "ID_KEY": "__id__",
        "singleMode": true,
        "shape": { 
            "switch": {
                "rx": 25,
                "ry": 15,
                "imgSrc": "/images/icons/switch2.png"
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

    // Dom Ready
    $(function(){ 

        $('#events_type').highcharts({
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
                categories: events_type.categories,
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
            series: events_type.series
        });
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
                tickInterval: 72,
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
                max:20
            },

            plotOptions: {
                series: {
                    pointStart: 0,
                    pointInterval: 72
                },
                column: {
                    pointPadding: 0,
                    groupPadding: 0
                }
            },

            series: [{
                type: 'column',
                name: 'Column',
                data: [
                    {color:'#9BCA62',y:18},
                    {color:'#EDD777',y:14},
                    {color:'#61C0DE',y:8},
                    {color:'#067CCC',y:11},
                    {color:'#F88464',y:4}
                ],
                pointPlacement: 'between'
            }]
        });
        $('#runtime').highcharts({
            credits: {
                enabled: false
            },
            chart: {
                type: 'bar',
                height: 150,
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
                categories: ['安全设备', '服务器','机房设备','客户端','应用系统','通讯设备','网络设备'],
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
            series: [{
                data: [{
                    name: 'Point 1',
                    color: '#59BFA9',
                    y: 2
                }, {
                    name: 'Point 2',
                    color: '#F95E4B',
                    y: 10
                },{
                    name: 'Point 2',
                    color: '#59BFA9',
                    y: 2
                },{
                    name: 'Point 2',
                    color: '#59BFA9',
                    y:2
                },{
                    name: 'Point 2',
                    color: '#E99406',
                    y: 8
                },{
                    name: 'Point 2',
                    color: '#FBDB51',
                    y: 3
                },{
                    name: 'Point 2',
                    color: '#59BFA9',
                    y: 4
                }],
                dataLabels:{
                    enabled: true,
                    align: 'top'
                }
            }]
        });

        // Render FCEditor
        ZSYFCEditor.init(
            {},
            {
                svg: d3.select("svg.ZSYFCEditor"),
                width: 1011,
                height: 676
            }
        );

        var refreshData = function(){
            $.ajax({
                url:'/topology/dashboard/ajax-refresh',
                type:"post",
                dataType:'json',
                success:function(res){
                    if(res.build){
                        ZSYFCEditor.updateData(res.build)
                    }
                    setTimeout(refreshData,30000);
                }
            });
        }
        refreshData();
    });

} )();