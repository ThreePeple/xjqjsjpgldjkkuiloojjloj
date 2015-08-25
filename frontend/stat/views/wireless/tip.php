<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-8-6.上午2:19
 * Description:
 */
$this->registerCssFile('/css/popuppanel.css');

$dataProvider = new \yii\data\ArrayDataProvider([
    "allModels" => $deviceConfig
]);
?>
<style>
.popup_content h4{
    font-size: 16px;
    font-weight: bold;
}
.popup_content a.detail-link,
.popup_content a.detail-link:hover{
    color: #fff;
}
a.detail-link{
    float: right;
    padding: 0 5px 0 0;
    text-decoration: underline;
}
</style>
<?php
if(!empty($deviceConfig)){
?>
    <h4>基础信息：<?=\yii\helpers\Html::a('查看详情',\yii\helpers\Url::toRoute(["/stat/wireless/detail","id"=>$model->id]),["class"=>"btn btn-link detail-link","target"=>"_blank"])?>
    </h4>
    <table class="table" border="0">
        <tbody>
        <?php
        foreach($deviceConfig as $key=>$attribute){
            if($attribute == 'vendor.name'){
                $value = isset($model->model)?(isset($model->model->vendor)?$model->model->vendor->name:''):'';
            }else{
                $value = $model->{$attribute};
            }
            echo '<tr><th style="border-top:0;text-align:right;padding:1px 8px 1px;width: 200px">'.$key.'</th><td style="border-top:0;padding:1px 8px 1px;">'.$value.'</td></tr>';
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
            echo '<tr><th style="border-top:0;text-align:right;padding:1px 8px 1px; width:200px">'.$key.'</th><td style="border-top:0;padding:1px 8px 1px;">'.$value.'</td></tr>';
        }
        ?>
        </tbody>
    </table>
<?php
}
?>