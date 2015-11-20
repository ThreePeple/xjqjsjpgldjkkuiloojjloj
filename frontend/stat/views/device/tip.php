<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-8-6.上午2:19
 * Description:
 */
$this->registerCssFile('/css/popuppanel.css');

?>
<link type="text/css" rel="stylesheet" href="/css/node_detail_popup.css"></link>
<?php
if(!empty($deviceConfig)){
?>
    <h4>基础信息：<?=\yii\helpers\Html::a('查看详情',\yii\helpers\Url::toRoute(["/stat/device/detail","id"=>$model->id]),["class"=>"btn btn-link detail-link","target"=>"_blank"])?></h4>
    <table class="table" border="0">
        <tbody>
        <?php
        foreach($deviceConfig as $key=>$attribute){
            if($attribute == 'vendor.name'){
                $value = ($model->model && $model->model->vendor )?$model->model->vendor->name:'';
            }elseif($attribute == 'category.name'){
                $value = $model->type?$model->type->name:'';
            }else{
                $value = $model->{$attribute};
            }
            echo '<tr><th class="title" style="text-align:left;padding:1px 8px 1px;width: 180px">'.$key.'</th><td  class="content" style="padding:1px 8px 1px;">'.$value.'</td></tr>';
        }
        ?>
        </tbody>
    </table>
<?php
}
?>

<?php
if(!empty($perfConfig)){
    ?>
    <h4>性能指标：</h4>
    <table class="table" border="0">
        <tbody>
        <?php
        foreach($perfConfig as $key=>$id){
            $value = isset($perfData[$id])?$perfData[$id]:'';
            if(in_array($id,[1,5])){
                $value = number_format($value/(8*1024),2).'KB';
                $key = str_replace('(bps)','',$key);
            }
            echo '<tr><th  class="title" style="text-align:left;padding:1px 8px 1px; width:180px">'.$key.'</th><td class="content" style="padding:1px 8px 1px;">'.$value.'</td></tr>';
        }
        ?>
        </tbody>
    </table>
<?php
}
?>