/**
 * Created by Shengjun on 15-7-9.
 */
( function () { 

    var switchStatusImg = {
        '-1': "/images/building_switch_status/s-1.png",
        '0': "/images/building_switch_status/s0.png",
        '1': "/images/building_switch_status/s1.png",
        '2': "/images/building_switch_status/s2.png",
        '3': "/images/building_switch_status/s3.png",
        '4': "/images/building_switch_status/s4.png",
        '5': "/images/building_switch_status/s5.png"
    };

    var ZSYFCEditorConfig = window.ZSYFCEditorConfig = {
        "ID_KEY": "__id__",
        "singleMode": true,
        "shape": { 
            "switch": {
                "rx": 15,
                "ry": 6.5,
                "imgSrc": "/images/building_switch_status/s-1.png"
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
                        window.open( "http://www.cnpc.com/?id=" + id );
                    }
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
                    alert(imgSrc);
                    this.attr( "href", imgSrc );
                });
            });
            
        } );

        var refreshData = function(){
            $.ajax({
                url:'/topology/dashboard/ajax-refresh',
                type:"post",
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