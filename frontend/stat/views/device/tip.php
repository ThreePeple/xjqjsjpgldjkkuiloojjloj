<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-8-6.上午2:19
 * Description:
 */
$this->registerCssFile('/css/popuppanel.css');
?>
<!--
<ul>
    <li><span>名称:</span><?=$model["label"]?></li>
    <li><span>楼层:</span></li>
    <li><span>ip地址:</span><?=$model["ip"]?></li>
    <li><span>设备厂商:</span></li>
    <li><span>设备类型:</span><?=isset($model->type)?$model->type->name:''?></li>
</ul>-->

<ul>
    <?php
        foreach($deviceConfig as $key=>$attribute){
            if($attribute == 'vendor.name'){
                $value = isset($model->model)?(isset($model->model->vendor)?$model->model->vendor->name:''):'';
            }else{
                $value = $model->{$attribute};
            }
            echo '<li><span>'.$key.'</span>'.$value.'</li>';
        }
    ?>
</ul>
