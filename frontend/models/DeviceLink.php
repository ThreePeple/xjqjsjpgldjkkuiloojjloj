<?php

namespace app\models;

use Yii;

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
}
