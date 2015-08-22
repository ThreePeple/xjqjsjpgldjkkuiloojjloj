/**
 * Created by jsj on 15/8/18.
 */

function renderChart(id1,id2){
    $.ajax({
        url : '/topology/dashboard/ajax-get-hub',
        data:{"id1":id1,"id2":id2},
        type:"POST",
        dataType:'JSON',
        success:function(res){
            if(res.status){
                var content = '<defs> <filter id="filter_blur" x="0" y="0"> <feGaussianBlur in="SourceGraphic" stdDeviation="1" /> </filter> </defs>'
                $("#ZSYPolymerChart").html(content);
                ZSYPolymerChart.init({data: res.data, svgWidth:1300, svgHeight: 1000});
                ZSYPolymerChart.render();
            }
        }
    });

}

function changeCore(group,id1,id2){
    $("#events_type button[group='"+group+"']").removeClass("btn-primary").addClass("btn-default");
    $("#events_type button[group='"+(group+1>2?1:group+1)+"']").removeClass("btn-default").addClass("btn-primary");
    renderChart(id1,id2)
}