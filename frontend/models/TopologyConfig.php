<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "topology_config".
 *
 * @property string $id
 * @property string $device1
 * @property string $device2
 * @property integer $type_id
 */
class TopologyConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topology_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['type_id'], 'integer'],
            [['id', 'device1', 'device2'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'device1' => 'Device1',
            'device2' => 'Device2',
            'type_id' => 'Type ID',
        ];
    }

    /**
     * 设备节点状态
     * @return array
     */
    public static function getWlanNodeStatus(){
        $rows = (new Query())
            ->from("topology_config a")
            ->innerJoin("device_info b","a.device1 = b.ip")
            ->where(["a.type_id"=>1])
            ->select(["node"=>"a.id","status"=>"b.status"])
            ->all();
        return ArrayHelper::map($rows,"node",function($data){
            return ["status"=>$data["status"]];
        });
    }

    public static function getWlanLinkStatus(){
        $rows = (new Query())
            ->from("topology_config a")
            ->innerJoin("device_info b"," a.device1 = b.ip or a.device2=b.ip")
            ->where(["a.type_id"=>2])
            ->select(["link"=>"a.id","devId"=>"b.id"])
            ->all();
        $data = [];
        $ids = [];
        foreach($rows as $row){
            $data[$row["link"]][] = $row["devId"];
            $ids[] = $row["devId"];
        }
        $rows = (new Query())->from("device_link")
            ->where(["leftDevice"=>$ids,"rightDevice"=>$ids])
            ->select(["d1"=>"leftDevice","d2"=>"rightDevice","status"])
            ->all();
        $result = [];
        foreach($rows as $row){
            $key = ($t=array_search([$row["d1"],$row["d2"]],$data))? $t : array_search([$row["d2"],$row["d1"]],$data);
            if($key){
                $result[$key] = ["status"=>$row["status"]];
            }
        }
        return $result;
    }

}
