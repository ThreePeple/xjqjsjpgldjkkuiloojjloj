<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use kartik\tabs\TabsX;

$items = [
    [
        'label'=>'<i class="glyphicon glyphicon-home"></i> 设备信息',
        'content'=>'',
        'active'=>true,
        'linkOptions'=>['data-url'=>Url::to(['/system/tip/ajax-get-content',"type"=>1])]
    ],
    [
        'label'=>'<i class="glyphicon glyphicon-user"></i> 性能信息',
        'content'=>'',
        'linkOptions'=>['data-url'=>Url::to(['/system/tip/ajax-get-content',"type"=>2])]
    ]
];

$js =<<<JS
    $("#w0-tab0").trigger("click");
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