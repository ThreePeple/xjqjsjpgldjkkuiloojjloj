<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "wireless_device_link".
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
class WirelessDeviceLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wireless_device_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'leftIfDesc', 'rightIfDesc', 'bandWidth', 'leftDevice', 'rightDevice'], 'required'],
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
            'id' => 'ID',
            'type' => 'Type',
            'leftSymbolId' => 'Left Symbol ID',
            'leftIfDesc' => 'Left If Desc',
            'rightSymbolId' => 'Right Symbol ID',
            'rightIfDesc' => 'Right If Desc',
            'status' => 'Status',
            'bandWidth' => 'Band Width',
            'leftDevice' => 'Left Device',
            'rightDevice' => 'Right Device',
            'update_time' => 'Update Time',
        ];
    }

    public function getLeft(){
        return $this->hasOne(WirelessDeviceInfo::className(),["id"=>"leftDevice"]);
    }

    public function getRight(){
        return $this->hasOne(WirelessDeviceInfo::className(),["id"=>"rightDevice"]);
    }

    public function getBandFormat(){
        return (int)($this->bandWidth/1000000).'M';
    }

    public static function getLinks($areaId){
        $ids = ViewTemplate::find()->where(["type"=>ViewTemplate::TYPE_WIFI,"areaId"=>$areaId])->select("device_id")->column();
        $rows = self::find()
            ->where(["or",["leftDevice"=>$ids,"rightDevice"=>$ids]])
            ->all();
        return  $rows;
    }

    /**
     * 无线链路状态
     */
    public static function getWirelessLinkStatus($areaId){
        $ids = ViewTemplate::find()->where(["type"=>ViewTemplate::TYPE_WIFI,"areaId"=>$areaId])->select("device_id")->column();
        //var_dump($ids);
        $query = WirelessDeviceLink::find();
        $query->where(["or",["leftDevice"=>$ids],["rightDevice"=>$ids]]);
        $query->andWhere("status>1");
        $count = $query->count();
        return $count>0? 2 : 1;
    }

    public static function getPolymerData($id1,$id2){
        $polymers = [];

        $models = WirelessDeviceInfo::find()->where(["id"=>[$id1,$id2]])->all();
        $n =1 ;
        foreach($models as $model){
            $polymers[$model->id] = [
                'id' => 'p'.$n,
                'label' => $model->label,
                "children" => []
            ];
            $n++;
        }

        $filterIds = DeviceIpfilter::find()->where(["type_id"=>DeviceIpfilter::TYPE_WIRELESS])->select("ip")->column();
        $links = [];

        $group1 = (new Query())
            ->from("wireless_device_link a")
            ->leftJoin("wireless_device_info b","a.leftDevice = b.id")
            ->where(['and',["a.rightDevice"=>[$id1,$id2],"b.ip"=>$filterIds],["not",["a.leftDevice"=>[$id1,$id2]]]])
            ->select(["label"=>"b.ip","id"=>"CONCAT('id',b.id)","group"=>"CONCAT('group1:',CONCAT('id',b.id))","status"=>"b.status",'polymer_id'=>"a.rightDevice","device_id"=>"b.id","linkStatus"=>"a.status"])
            ->groupBy('a.leftDevice')
            ->all();
        foreach($group1 as $one){
            $polymers[$one["polymer_id"]]["children"][] = $one["group"];

            $links[] = [
                "from"=> $one["id"],
                "to" => $polymers[$one["polymer_id"]]["id"],
                "status" => $one["linkStatus"]
            ];
        }

        $group2 = (new Query())
            ->from("wireless_device_link a")
            ->leftJoin("wireless_device_info b","a.rightDevice = b.id")
            ->where(["and",["a.leftDevice"=>[$id1,$id2],"b.ip"=>$filterIds],["not",["a.rightDevice"=>[$id1,$id2]]]])
            ->select(["label"=>"b.ip","id"=>"CONCAT('id',b.id)","group"=>"CONCAT('group2:',CONCAT('id',b.id))","status"=>"b.status","polymer_id"=>"a.leftDevice","device_id"=>"b.id","linkStatus"=>"a.status"])
            ->groupBy('a.rightDevice')
            ->all();
        foreach($group2 as $one){
            $polymers[$one["polymer_id"]]["children"][] = $one["group"];
            $links[] = [
                "from"=> $one["id"],
                "to" => $polymers[$one["polymer_id"]]["id"],
                "status" => $one["linkStatus"]
            ];
        }

        return [
            "groups" => ["group1"=>$group1,"group2"=>$group2],
            "polymers" => array_values($polymers),
            "links" => $links
        ];
    }
}
