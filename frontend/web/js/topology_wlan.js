/**
 * Created by Shengjun on 15-7-9.
 */
( function () { 

    var switchStatusImg = {
        '-1': "/images/building_switch_status2/s-1.gif",
        '0': "/images/building_switch_status2/s0.gif",
        '1': "/images/building_switch_status2/s1.gif",
        '2': "/images/building_switch_status2/s2.gif",
        '3': "/images/building_switch_status2/s3.gif",
        '4': "/images/building_switch_status2/s4.gif",
        '5': "/images/building_switch_status2/s5.gif"
    };

    var ZSYFCEditorConfig = window.ZSYFCEditorConfig = {
        "ID_KEY": "__id__",
        "singleMode": true,
        "shape": { 
                  "router": {
                        "rx": 19,
                        "ry": 19,
                        "imgSrc": "/images/icons2/router.png" 
                    },
                    "switch": {
                        "rx": 42.5,
                        "ry": 32.5,
                        "imgSrc": "/images/icons2/mainSwitch.png"
                    },
                    "server": {
                        "rx": 17,
                        "ry": 25,
                        "imgSrc": "/images/icons2/server.png"
                    },
                    "firewall": {
                        "rx": 19,
                        "ry": 18,
                        "imgSrc": "/images/icons2/firewall.png"
                    },
                    "db": {
                        "rx": 35,
                        "ry": 42,
                        "imgSrc": "/images/icons2/db.png"
                    },
                    "wireless": {
                        "rx": 25,
                        "ry": 24,
                        "imgSrc": "/images/icons2/wireless.gif"
                    },
                    "printer": {
                        "rx": 40,
                        "ry": 41,
                        "imgSrc": "/images/icons2/printer.png"
                    },
                    "ups": {
                        "rx": 40,
                        "ry": 41.5,
                        "imgSrc": "/images/icons2/ups.png"
                    },
                    "pc": {
                        "rx": 38,
                        "ry": 38.5,
                        "imgSrc": "/images/icons2/pc.png"
                    }
        }

    }; 
 

    // Dom Ready 
    $(function(){ 

      

        // Render FCEditor
        ZSYFCEditor.init(
            {},
            {
                svg: d3.select("svg.ZSYFCEditor"),
                width: 1440,
                height: 1200
            } 
        ); 

        ZSYFCEditor.updateCallback( function(){ return;
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
                data:{"type":2},
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