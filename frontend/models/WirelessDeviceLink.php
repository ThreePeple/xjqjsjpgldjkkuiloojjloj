<?php

namespace app\models;

use frontend\models\DeviceIpfilter;
use frontend\models\WirelessDeviceInfo;
use frontend\models\WirelessDeviceTaskSummary;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

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
            [['update_time','label'], 'safe'],
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
            'label' => '链路标签',
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
    /**
     * 获取链路接口介入速率
     */
    public function getLeftInSpeed(){
        $data = WirelessDeviceTaskSummary::find()->where(["devId"=>$this->leftDevice,"taskId"=>1])->orderBy("instId
        desc")
            ->select
        ("currentValue")->asArray()->scalar();
        return $this->bpsToKbps($data);
    }
    public function getLeftOutSpeed(){
        $data = WirelessDeviceTaskSummary::find()->where(["devId"=>$this->leftDevice,"taskId"=>5])->orderBy("instId
        desc")->select
        ("currentValue")->asArray()->scalar();
        return $this->bpsToKbps($data);
    }
    public function getRightInSpeed(){
        $data = WirelessDeviceTaskSummary::find()->where(["devId"=>$this->rightDevice,"taskId"=>1])->orderBy("instId
        desc")->select
        ("currentValue")->asArray()->scalar();
        return $this->bpsToKbps($data);
    }
    public function getRightOutSpeed(){
        $data = WirelessDeviceTaskSummary::find()->where(["devId"=>$this->rightDevice,"taskId"=>5])->orderBy("instId
        desc")->select
        ("currentValue")->asArray()->scalar();
        return $this->bpsToKbps($data);
    }

    /**
     *  bps 转化成MBps
     * 1 MB = 1,024 KB= 1,048,576 Bytes
     * 1Byte=8bit
     */
    public function bpsToKbps($bps){
        if($bps >= 1048576){
            return number_format($bps/1048576,2).'Mb';
        }
        return number_format($bps/1024,2).'Kb';
    }

    /**
     * 获取Echarts 和弦图数据
     */
    public static function getEData($id1,$id2){
        $links = [];
        $nodes = WirelessDeviceInfo::find()->where(["id"=>[$id1,$id2]])->select(["id","name"=>"label"])->asArray()
            ->all();
/*
        array_walk($nodes,function(&$val,$key,$id1){
            $nodeStyle= [];
           if($val["id"]== $id1){
               $nodeStyle['normal'] = [
                   'color' => 'green'
               ];
           }else{
               $nodeStyle['normal'] = [
                   //'color' => '#45d3c9'
                   'color' => 'green'
               ];
           }
            $val["itemStyle"] = $nodeStyle;
        },$id1);
*/

        $filterIds = DeviceIpfilter::find()->where(["type_id"=>DeviceIpfilter::TYPE_WIRELESS])->select("ip")->column();

        $lefts = (new Query())
            ->from('wireless_device_link a')
            ->leftJoin("wireless_device_info b","a.leftDevice = b.id")
            ->where(['and',["a.rightDevice"=>[$id1,$id2],"b.ip"=>$filterIds],["not",["a.leftDevice"=>[$id1,$id2]]]])
            ->select(["leftDevice","rightDevice","name"=>"b.ip","id"=>"b.id"])
            ->all();

        $rows = (new Query())
            ->from('wireless_device_link a')
            ->leftJoin("wireless_device_info b","a.rightDevice = b.id")
            ->where(["and",["a.leftDevice"=>[$id1,$id2],"b.ip"=>$filterIds],["not",["a.rightDevice"=>[$id1,$id2]]]])
            ->select(["leftDevice","rightDevice","name"=>"b.ip","id"=>"b.id"])
            ->all();

        $rows = array_merge($lefts,$rows);

        $tmp = ArrayHelper::map($nodes,"id","name");

        foreach($rows as $row){
            $nodes[] = [
                "id" => $row["id"],
                "name" => $row["name"],
            ];
            if(isset($tmp[$row["leftDevice"]])){
                $source = $tmp[$row["leftDevice"]];
                $target = $row["name"];
            }else{
                $source = $tmp[$row["rightDevice"]];
                $target = $row["name"];
            }

            if($row['leftDevice'] == $id1 || $row["rightDevice"]==$id1){
                $color = 'green';
            }else{
                $color = '#45d3c9';
            }

            $links[] = [
                'source' => $source,
                'target' => $target,
                'weight' => 1,
                'itemStyle' => [
                    'normal' => [
                        'color' => $color,
                        'width' => 2,
                    ]
                ]
            ];
            $links[] = [
                'source' => $target,
                'target' => $source,
                'weight' => 0.9,
                'itemStyle' => [
                    'normal' => [
                        'color' => $color,
                        'width' => 2
                    ]
                ]
            ];
        }
        return [
            "nodes" => $nodes,
            "links" => $links
        ];
    }
}
