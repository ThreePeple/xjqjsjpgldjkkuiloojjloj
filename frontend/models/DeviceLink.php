<?php

namespace app\models;

use frontend\models\DeviceInfo;
use frontend\models\DeviceIpfilter;
use frontend\models\DeviceTaskSummary;
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

    public static function getPolymerData($id1,$id2){
        $polymers = [];
        $links = [];
        $group1 = $group2 = [];

        $models = DeviceInfo::find()->where(["id"=>[$id1,$id2]])->all();
        foreach($models as $model){
            $polymers[$model->id] = [
                'id' => 'p'.$model->id,
                'label' => $model->label,
                "children" => []
            ];
        }

        $filterIds = DeviceIpfilter::find()->where(["type_id"=>DeviceIpfilter::TYPE_POLYMER])->select("ip")->column();

        $rows = (new Query())
            ->from("device_link a")
            ->leftJoin("device_info b","a.leftDevice = b.id or a.rightDevice=b.id")
            ->where(['and',['b.ip'=>$filterIds],"a.leftDevice in($id1,$id2) or a.rightDevice in($id1,$id2)"])
            ->select(['label'=>"b.ip","b.id","b.status",'linkStatus'=>"a.status",'b.area',"a.leftDevice",
                "a.rightDevice"])
            ->groupBy('b.id')
            ->all();
        foreach($rows as $row){
            if(in_array($row["id"],[$id1,$id2]))
                continue;
            if(in_array(strtoupper($row["area"]),["A","C"])){
                $group="group1:id".$row["id"];
                $group1[] = [
                    "label" => $row["label"],
                    "id" => 'id'.$row["id"],
                    "group" => $group,
                    "status" => $row["status"],
                    "device_id" => $row["id"],
                ];
            }else{
                $group = "group2:id".$row["id"];
                $group2[] = [
                    "label" => $row["label"],
                    "id" => 'id'.$row["id"],
                    "group" => $group,
                    "status" => $row["status"],
                    "device_id" => $row["id"],
                ];
            }
            $polymer_id = ($row["leftDevice"] == $row["id"])? $row["rightDevice"] : $row["leftDevice"];

            $polymers[$polymer_id]["children"][] = $group;
            $links[] = [
                "from"=> 'id'.$row["id"],
                "to" => $polymers[$polymer_id]["id"],
                "status" => $row["linkStatus"]
            ];
        }

        return [
                "groups" => ["group1"=>$group1,"group2"=>$group2],
                "polymers" => array_values($polymers),
                "links" => $links
        ];
    }

    /**
     * 获取链路接口介入速率
     */
    public function getLeftInSpeed(){
        $data = DeviceTaskSummary::find()->where(["devId"=>$this->leftDevice,"taskId"=>1])->orderBy("instId desc")
            ->select
        ("currentValue")->asArray()->scalar();
        return $this->bpsToMBps($data);
    }
    public function getLeftOutSpeed(){
        $data = DeviceTaskSummary::find()->where(["devId"=>$this->leftDevice,"taskId"=>5])->orderBy("instId desc")
            ->select
        ("currentValue")->asArray()->scalar();
        return $this->bpsToMBps($data);
    }
    public function getRightInSpeed(){
        $data = DeviceTaskSummary::find()->where(["devId"=>$this->rightDevice,"taskId"=>1])->orderBy("instId desc")
            ->select
        ("currentValue")->asArray()->scalar();
        return $this->bpsToMBps($data);
    }
    public function getRightOutSpeed(){
        $data = DeviceTaskSummary::find()->where(["devId"=>$this->rightDevice,"taskId"=>5])->orderBy("instId desc")
            ->select
        ("currentValue")->asArray()->scalar();
        return $this->bpsToMBps($data);
    }

    /**
     *  bps 转化成MBps
     * 1 MB = 1,024 KB= 1,048,576 Bytes
     * 1Byte=8bit
     */
    public function bpsToMBps($bps){
        return $bps/(8*1048576).'MB';
    }
}
