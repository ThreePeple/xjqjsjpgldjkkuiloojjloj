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


    var containers = [];
    function renderEChart(id,chart,option){
        if(!containers[id]){
            var myChart = echarts.init(document.getElementById(id));
            containers[id] = myChart;
        }
        $.extend(option,{
            textStyle:{
                fontFamily: '"microsoft yahei", STHeitiSC-Light, Roboto, _H_Helvetica, sans-serif, Arial'
            }
        })
        containers[id].setOption(option);
    }

    function loadDeviceChart(data,markData,categories){
        var option = {
            title: {
                x: '',
                text: '',
                subtext: ''
            },
            tooltip: {
                trigger: 'item'
            },
            toolbox: false,
            calculable: false,
            grid: {
                borderWidth: 0,
                y: 22,
                y2: 40,
                x:10,
                x2:10
            },
            xAxis: [
                {
                    type: 'category',
                    //show: false,
                    data: categories,
                    splitLine: false,
                    axisTick: false,
                    axisLine: {show :false},
                    axisLabel: {
                        textStyle: {
                            color:'#fff'
                        },
                        rotate:45
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    show: false
                }
            ],
            series: [
                {
                    name: '数量',
                    type: 'bar',
                    itemStyle: {
                        normal: {
                            color: function(params) {
                                // build a color map as your need.
                                var colorList = [
                                    '#808080','#00F','#008000','#0FF','#FF0',
                                    '#FFA500','#F00','#00F','#F3A43B','#60C0DD',
                                    '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                                ];
                                return colorList[params.dataIndex]
                            },
                            label: {
                                show: true,
                                position: 'top',
                                formatter: '{c}'
                            },
                            barBorderRadius: [5,5,5,5]
                        }
                    },
                    data: data
                    /*
                    markPoint: {
                        tooltip: {
                            trigger: 'item',
                            backgroundColor: 'rgba(0,0,0,0)'
                        },
                        data: markData
                    }*/
                }
            ]
        };
        renderEChart('device_status',"bar",option);
    }

    function loadAlarmTypeChart(data,categories,colors){

        var option = {
            title : false,
            tooltip : {
                trigger: 'item'
            },
            /*
            legend: {
                data:['2011年', '2012年']
            },*/
            legend: false,
            toolbox: false,
            calculable : false,
            grid:{
                borderWidth:0,
                x: 80,
                y: 0,
                x2: 5,
                y2: 5
            },

            xAxis : [
                {
                    type : 'value',
                    boundaryGap : [0, 0.01],
                    show:false
                }
            ],
            yAxis : [
                {
                    splitLine: false,
                    axisTick: false,
                    axisLine: {show :false},
                    axisLabel: {
                        textStyle: {
                            color:'#fff'
                        }
                    },
                    type : 'category',
                    data : categories
                }
            ],
            series : [
                {

                    itemStyle: {
                        normal: {
                            color: function(params) {
                                // build a color map as your need.
                                var colorList = [
                                    '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                                    '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                                    '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                                ];
                                return colorList[params.dataIndex]
                            },
                            barBorderRadius:[0,5,5,0],
                            label: {
                                show: true,
                                position: 'right',
                                formatter: '{c}'
                            }
                        }
                    },
                    name:'数量',
                    type:'bar',
                    data:data
                }
            ]
        };
        renderEChart("itemType","bar",option);
    }

    function loadAlarmLevelPie(data,categories,colors){

        var option = {
            title : false,
            tooltip : {
                trigger: 'item',
                formatter: "{b} : {c}"
            },
            legend: {
                orient: 'vertical',
                x : 'right',
                y : 'top',
                data:categories,
                textStyle:{
                    color:"#fff"
                }
            },
            toolbox: false,
            calculable : true,
            series : [
                {
                    name:'数量',
                    type:'pie',
                    radius : [20, '88%'],
                    center : ['40%', '50%'],
                    //roseType : 'radius',
                    itemStyle : {
                        normal : {
                            label : {
                                show : false
                            },
                            labelLine : {
                                show : false
                            },
                            color: function(params){
                                // build a color map as your need.
                                var colorList = ['#FF4500','#FF7F50','#FFD700','#87CEFF','#7F7F7F','#8BAE3D'];
                                //var colorList= colors;
                                return colorList[params.dataIndex]
                            }
                        },
                        emphasis : {
                            label : {
                                show : false
                            },
                            labelLine : {
                                show : false
                            },
                            color: function(params){
                                // build a color map as your need.
                                var colorList= ['#FF6A6A','#FFB90F','#FFE4B5','#97FFFF','#C7C7C7','8BAE3D'];
                                return colorList[params.dataIndex]
                            }
                        }
                    },
                    data:data
                }

            ]
        };
        renderEChart('events_levels','pie',option);
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
                    loadDeviceChart(res.device.data,res.device.markData,res.device.categories);
                    //loadAlarmTypeChart(res.alarmType.data,res.alarmType.categories,res.alarmType.colors);
                    loadAlarmLevelPie(res.alarmLevel.data,res.alarmLevel.categories,res.alarmLevel.colors);
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
                width: 1280,
                height: 940
            } 
        );

        $('.ZSYFCEditor').click( function(e){
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