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
                ZSYPolymerChart.init({data: res.data});
                ZSYPolymerChart.render();
            }
        }
    });

}