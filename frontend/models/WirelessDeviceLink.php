<?php

namespace app\models;

use Yii;

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
}
