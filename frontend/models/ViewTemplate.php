<?php

namespace app\models;

use Yii;
use app\models\DeviceInfo;
use app\models\DeviceLink;

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

    public function getDevice(){
        return $this->hasOne(DeviceInfo::className(),["id"=>"device_id"]);
    }

    public static function getTempateSet($type){
        $rows = self::find()->with([
            "device"=>function($query){
                $query->select("id,label,status");
            }
        ])->where(["type"=>$type])->asArray()->all();

        $data = [];
        foreach($rows as $row){
            if(!$row["device"])
                continue;
            $d = array_merge($row["device"],["areaId"=>$row["areaId"]]);
            $data[$row["id"]] = [
                "data" => $d,
                "attributes" => json_decode($row["attributes"]),
                "links" => json_decode($row["links"])
            ];
        }
        return $data;
    }

    /**
     * 获取区域内设备
     */
    public static function getAreaDeviceData($area){
        $deviceIds = self::find()->where(["type"=>self::TYPE_WLAN,"areaId"=>$area])->select("device_id")->asArray()->column();
        $rows = DeviceInfo::find()->with(["category"])->where(["id"=>$deviceIds])->select("id,label,categoryId")->asArray()->all();
        $result = [];
        foreach($rows as $row){
            $result[] = [
                "id" => $row["id"],
                "label" => $row["label"],
                "group" => isset($row["category"])?$row["category"]["node_group"]:'',
            ];
        }
        return $result;
    }

    public static function getLinks($ids){
        $rows = DeviceLink::find()->where(["leftDevice"=>$ids,"rightDevice"=>$ids])
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
