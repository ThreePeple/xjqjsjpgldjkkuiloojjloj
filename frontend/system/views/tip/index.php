<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use kartik\tabs\TabsX;

$items = [
    [
        'label'=>'<i class="glyphicon glyphicon-cog"></i> 设备信息',
        'content'=>$content1,
        'active'=>true,
    ],
    [
        'label'=>'<i class="glyphicon glyphicon-tasks"></i> 性能信息',
        'content'=>$content2,
    ]
];

$js =<<<JS
    $(".save").click(function(){
        var type = $(this).attr("type");
        var ids = $("#info_config_"+type).yiiGridView("getSelectedRows");
        console.log(ids);
        $.ajax({
            url: '/system/tip/save-config',
            type: 'POST',
            data: {"type":type,"selected":ids},
            dataType:"json",
            success:function(res){
                if(res.status){
                    alert('操作成功')
                }else{
                    alert('操作失败')
                }
            }
        })
    })
JS;
$this->registerJs($js);
?>

<div class="row">
    <div class="col-md-12">
        <?=TabsX::widget([
            "items" => $items,
            'position'=>TabsX::POS_LEFT,
            'sideways'=>true,
            "encodeLabels" => false,
        ])?>
    </div>
</div>