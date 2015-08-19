<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "device_link".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $leftSymbolId
 * @property string $leftIfDesc
 * @property integer $rightSymbolId
 * @property string $rightIfDesc
 * @property integer $status
 * @property string $bandWidth
 * @property string $leftDevice
 * @property string $rightDevice
 * @property string $update_time
 */
class DeviceLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'type', 'leftSymbolId', 'rightSymbolId', 'status'], 'integer'],
            [['update_time'], 'safe'],
            [['leftIfDesc', 'rightIfDesc', 'bandWidth', 'leftDevice', 'rightDevice'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'leftSymbolId' => Yii::t('app', 'Left Symbol ID'),
            'leftIfDesc' => Yii::t('app', 'Left If Desc'),
            'rightSymbolId' => Yii::t('app', 'Right Symbol ID'),
            'rightIfDesc' => Yii::t('app', 'Right If Desc'),
            'status' => Yii::t('app', 'Status'),
            'bandWidth' => Yii::t('app', 'Band Width'),
            'leftDevice' => Yii::t('app', 'Left Device'),
            'rightDevice' => Yii::t('app', 'Right Device'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }
    public function getLeft(){
        return $this->hasOne(DeviceInfo::className(),["id"=>"leftDevice"]);
    }

    public function getRight(){
        return $this->hasOne(DeviceInfo::className(),["id"=>"rightDevice"]);
    }


    public function getBandFormat(){
        return (int)($this->bandWidth/1000000).'M';
    }

    public static function getPolymerData($core_id){
        $polymers = [];
        $models = self::find()->with("right")->where(["leftDevice"=>$core_id])->limit(2)->all();
        $n =1 ;
        foreach($models as $model){
            if(!$model->right) continue;
            $polymers[$model->right->id] = [
                'id' => 'p'.$n,
                'label' => $model->right->label,
                "children" => []
            ];
            $n++;
        }

        $ployIds = array_keys($polymers);

        $group1 = [];
        $rows = self::find()->with("left")->where(["and",["rightDevice"=>$ployIds],["not",["leftDevice"=>$core_id]]])->all();
        //$rows = self::find()->with("left")->where(["rightDevice"=>$ployIds])->groupBy("leftDevice")->all();
        foreach($rows as $model){
            if(!$model->left) continue;
            $polymerId = $model->rightDevice;
            $node_id = 'id'.$model->left->id;
            $group1[] = ["label"=>$model->left->label,"id"=>$node_id,"status"=>$model->left->status];
            $polymers[$polymerId]["children"][] = "group1:".$node_id;
        }

        $group2 = [];
        $rows = self::find()->with("right")->where(["leftDevice"=>$ployIds])->groupBy("rightDevice")->all();
        foreach($rows as $model){
            if(!$model->right) continue;
            $polymerId = $model->leftDevice;
            $node_id = 'id'.$model->right->id;
            $group2[] = ["label"=>$model->right->label,"id"=>$node_id,"status"=>$model->right->status];
            $polymers[$polymerId]["children"][] = "group2:".$node_id;
        }

        return [
            "groups" => ["group1"=>$group1,"group2"=>$group2],
            "polymers" => array_values($polymers)
        ];
    }
}
