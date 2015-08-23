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

    /**
     * @var array 区域坐标
     */
    static $areas = [
        "wlan" => [
            1=>[[308,142],[600,308],[380,420],[110,234]], //广域网
            2=>[[388,622],[802,864],[432,1074],[30,818]], //因特网
            3=>[[1162,684],[1340,784],[1116,948],[934,838]], //大厦局域网
            4=>[[928,186],[1080,264],[860,394],[700,310]], //基础数据
            5=>[[1100,272],[1264,354],[1038,486],[874,402]], //三层
            6=>[[1280,360],[1450,450],[1230,600],[1056,504]], //一层

        ],
        /*
        'wireless' => [
            1=>[[670,50],[780,130],[140,460],[0,387]], //A
            2=>[[810,145],[957,223],[333,557],[160,465]], //B
            3=>[[1143,260],[1290,335],[640,687],[468,600]], //C
            4=>[[1296,337],[1477,426],[799,773],[655,695]], //D
            5=>[[1165,0],[1464,148],[1260,252],[951,99]], //E
            6=>[[273,24],[462,120],[324,184],[138,93]], //A-F7
        ],
        */
        "wireless" => [
            1 => [[663,59],[963,220],[333,559],[0,387]],    //红
            2 => [[1077,286],[1408,452],[760,773],[426,608]],    //绿
            3 => [[1113,0],[1413,130],[1209,237],[912,84]],   //兰
            4=> [[987,229],[1071,274],[882,370],[807,325]],    //黄
        ],
    ];
    static $groups = [
        "2" => [ //wlan
            "router" => ["shape"=>"image","image"=>'/images/icons2/router.png'],
            "switch" => ["shape"=>"image","image"=>'/images/icons2/switch.png'],
            "server" => ["shape"=>"image","image"=>'/images/icons2/server.png'],
            "firewall" => ["shape"=>"image","image"=>'/images/icons2/firewall.png'],
            "driver" => ["shape"=>"image","image"=>'/images/icons2/db.png'],
            "wireless" => ["shape"=>"image","image"=>'/images/icons2/wireless.gif'],
            "audio" => ["shape"=>"image","image"=>'/images/icons2/voice.png'],
            "printer" => ["shape"=>"image","image"=>'/images/icons2/printer.png'],
            "ups" => ["shape"=>"image","image"=>'/images/icons2/ups.png'],
            "pc" => ["shape"=>"image","image"=>'/images/icons2/pc.png'],
            "coreSwitch" => ["shape"=>"image","image"=>'/images/icons2/core.png'],
            "mainSwitch" => ["shape"=>"image","image"=>'/images/icons2/mainSwitch.png'],
        ],
        "3" => [ //wireless
            "switch" => ["shape"=>"image","image"=>'/images/icons3/switch.png'],
            "server" => ["shape"=>"image","image"=>'/images/icons3/server.png'],
            "firewall" => ["shape"=>"image","image"=>'/images/icons3/firewall.png'],
            "wireless" => ["shape"=>"image","image"=>'/images/icons3/wireless.gif'],
            "ac" => ["shape"=>"image","image"=>'/images/icons3/ac.png'],
            "coreSwitch" => ["shape"=>"image","image"=>'/images/icons3/core.png'],
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

    public function getAreaId($x,$y){
        if($this->type == 2){
            $areas = self::$areas["wlan"];
        }elseif($this->type==3){
            $areas = self::$areas["wireless"];
        }else{
            $areas = [];
        }
        $areaId = null;
        foreach($areas as $id=>$area){
            if(self::isInArea([$x,$y],$area)){
                $areaId = $id;
                break;
            }
        }
        return $areaId;
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
