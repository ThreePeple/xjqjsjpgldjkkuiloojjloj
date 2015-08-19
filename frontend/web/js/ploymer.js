/**
 * Created by jsj on 15/8/18.
 */

function renderChart(core_id){
    $.ajax({
        url : '/topology/dashboard/ajax-get-hub',
        data:{"core_id":core_id},
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

function changeCore(_this,id){
    $(_this).removeClass("btn-primary").addClass("btn-info");
    $(_this).siblings('.btn-info').removeClass("btn-info").addClass("btn-primary");
    renderChart(id)
}