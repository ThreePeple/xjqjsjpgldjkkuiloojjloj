<?php

namespace app\models;

use Yii;

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
                $query->select("id,label,status,");
            }
        ])->where(["type"=>$type])->asArray()->all();

        $data = [];
        foreach($rows as $row){
            $data[$row["id"]] = [
                "data" => $row["device"],
                "attribute" => json_decode($row["attributes"])
            ];
        }
        return $data;
    }
}
