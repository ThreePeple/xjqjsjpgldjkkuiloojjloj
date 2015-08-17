<?php

namespace app\models;

use Yii;
use app\models\DeviceInfo;
use app\models\DeviceLink;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "view_template".
 *
 * @property integer $id
 * @property integer $device_id
 * @property string $attributes
 * @property string $type
 */
class ViewTemplate extends \yii\db\ActiveRecord
{
    const TYPE_BUILD =1;
    const TYPE_WLAN = 2;
    const TYPE_WIFI = 3;

    static $areas = [
        "1" => [
            [305,144],[588,312],[387,414],[110,233]
        ]
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'device_id', 'attributes'], 'required'],
            [['id', 'device_id'], 'integer'],
            [['attributes', 'type'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'device_id' => Yii::t('app', 'Device ID'),
            'attributes' => Yii::t('app', 'Attributes'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * 有线网络设备
     * @return \yii\db\ActiveQuery
     */
    public function getDevice(){
        return $this->hasOne(DeviceInfo::className(),["id"=>"device_id"]);
    }

    /**
     * 无线网络设备
     * @return \yii\db\ActiveQuery
     */
    public function getWireless(){
        return $this->hasOne(WirelessDeviceInfo::className(),["id"=>"device_id"]);
    }

    public static function getTempateSet($type){
        if($type == 3){
            //无线设备
            $rows = self::find()->with([
                "wireless"=>function($query){
                    $query->select("id,label,status");
                }
            ])->where(["type"=>$type])->asArray()->all();
            $data = new \stdClass();
            foreach($rows as $row){
                if(!$row["wireless"])
                    continue;
                $d = array_merge($row["wireless"],["areaId"=>$row["areaId"]]);
                $data->{$row["id"]} = [
                    "data" => $d,
                    "attributes" => json_decode($row["attributes"]),
                    "links" => json_decode($row["links"])
                ];
            }
        }else{
            $rows = self::find()->with([
                "device"=>function($query){
                    $query->select("id,label,status");
                }
            ])->where(["type"=>$type])->asArray()->all();
            $data = new \stdClass();
            foreach($rows as $row){
                if(!$row["device"])
                    continue;
                $d = array_merge($row["device"],["areaId"=>$row["areaId"]]);
                $data->{$row["id"]} = [
                    "data" => $d,
                    "attributes" => json_decode($row["attributes"]),
                    "links" => json_decode($row["links"])
                ];
            }
        }



        return $data;
    }



    /**
     * 获取区域内设备
     */
    public static function getAreaDeviceData($area,$type=2){
        $template = self::find()->where(["type"=>$type,"areaId"=>$area])->select("device_id,attributes")->asArray()->all();
        $data = ArrayHelper::map($template,'device_id',"attributes");
        $deviceIds = array_keys($data);
        //var_dump($deviceIds);
        if($type == 3){
            //无线设备
            $rows = WirelessDeviceInfo::find()->with(["category"])->where(["id"=>$deviceIds])->select("id,label,categoryId")->asArray()->all();
        }else{
            $rows = DeviceInfo::find()->with(["category"])->where(["id"=>$deviceIds])->select("id,label,categoryId")->asArray()->all();
        }
        $result = [];
        foreach($rows as $row){
            //$pos = self::getPosition($data[$row["id"]]);
            $result[] = [
                "id" => $row["id"],
                "label" => $row["label"],
                "group" => isset($row["category"])?$row["category"]["node_group"]:'',
               // 'x' => $pos["x"],
               // 'y' => $pos["y"]
            ];
        }
        return $result;
    }

    private static function getPosition($data){
        $data = json_decode($data,true);
        return [
            "x" => $data["cx"]-700,
            "y" => $data["cy"]-400
        ];
    }

    public static function getLinks($ids,$type=2){
        if($type==3){
            $query = WirelessDeviceLink::find();
        }else{
            $query = DeviceLink::find();
        }
        $rows = $query->where(["leftDevice"=>$ids,"rightDevice"=>$ids])
            ->select(["id","status","from"=>"leftDevice","to"=>"rightDevice"])
            ->asArray()
            ->all();
        array_walk($rows,function(&$item){
            $item["color"] = $item["status"]==1? 'green':'red';
            $item["value"] = 2;
        });
        return $rows;
    }


    /**
     * 判断点是否在四边形内
     * @param $point 点位坐标
     * @param $area  是个顶点坐标
     * @return boolean
     */
    public static function isInArea($point,$area){
        $flag = true;
        $diff = [];
        for($i=0; $i<4;$i++){
            $diff[$i][0] = $area[($i+1)%4][0] - $area[$i][0];
            $diff[$i][1] = $area[($i+1)%4][1] - $area[$i][1];
        }
        $i = 0;
        while($i<4){
            $a = ( $point[1] - $area[ $i ][ 1 ] ) * $diff[ $i ][ 0 ];            //a = (y3-y1)(x2-x1)
            $b = ( $point[0] - $area[ $i ][ 0 ] ) * $diff[ $i ][ 1 ];            //b = (x3-x1)(y2-y1)
            if($a-$b<0){
                $flag = false;
                break;
            }
            $i++;
        }
        return $flag;
    }
}
