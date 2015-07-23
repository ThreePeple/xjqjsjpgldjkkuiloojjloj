<?php
/* @var $this yii\web\View */
//use frontend\widgets\DataTableAsset;
//use frontend\widgets\DataTable;
use kartik\grid\GridView;

?>
<div class="row" style="margin-top: 50px;">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Table With Full Features</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?=
                DataTable::widget([
                    "columns"=>[
                        ["data"=>"column1","name"=>'111'],
                        ["data"=>"column1"],
                        ["data"=>"column1"],
                    ],
                    "ajaxOptions"=>[
                        "url" => "/system/user/test",
                        "type"=>"post"
                    ],
                ]);
                ?>
            </div><!-- /.box-body -->
    </div>
</div>
