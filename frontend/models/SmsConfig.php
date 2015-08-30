<?php

namespace frontend\models;

use app\models\AlarmCategory;
use app\models\AlarmLevel;
use app\models\User;
use Yii;

/**
 * This is the model class for table "sms_config".
 *
 * @property integer $id
 * @property string $alarmSet
 * @property string $alarmCondition
 * @property integer $smsTemplate_id
 * @property string $receivers
 * @property string $create_time
 * @property string $update_time
 */
class SmsConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alarmSet', 'alarmCondition'], 'string'],
            [['smsTemplate_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['receivers', 'smsTemplate_id'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alarmSet' => 'Alarm Set',
            'alarmCondition' => 'Alarm Condition',
            'smsTemplate_id' => 'Sms Template ID',
            'receivers' => 'Receivers',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    public function setReceivers($vals){
        $this->receivers = implode(',',$vals);
    }


    public function setAlarmCondition($name=false)
    {
        $items = json_decode($this->alarmSet, true);
        $conditions = [];
        foreach ($items as $item) {
            $tmp = '';
            switch ($item["key"]) {
                case 1:
                    $tmp = 'alarmCategory = ' . $item["val"];
                    break;
                case 2:
                    $tmp = 'alarmLevel = ' . $item["val"];
                    break;
                case 3:
                    $k = explode(',', $item["val"]);
                    $c = [];
                    foreach ($k as $one) {
                        $c[] = 'alarmDesc like "%'.$one.'%"';
                    }
                    $tmp = count($c)>1? '('.implode(') OR (', $c).')' : $c[0];
                    break;
                default:
                    continue;
            }
            if ($item["contain"] == 1) {
                $conditions[] = $tmp;
            } else {
                $conditions[] = ' NOT ( ' . $tmp . ' )';
            }
        }

        if (count($conditions) > 1) {
            $this->alarmCondition = '(' . implode(') AND (', $conditions) . ')';
        } else {
            $this->alarmCondition = implode(' AND ', $conditions);
        }
    }

    public function getConditionShow(){
        $items = json_decode($this->alarmSet, true);
        $conditions = [];
        foreach ($items as $item) {
            $tmp = '';
            switch ($item["key"]) {
                case 1:
                    $tmp = AlarmCategory::find()->where(["id"=>$item["val"]])->select('subDesc')->scalar();
                    break;
                case 2:
                    $tmp = AlarmLevel::find()->where(["id"=>$item["val"]])->select('desc')->scalar();
                    break;
                case 3:
                    $tmp = '关键字：'.$item['val'];
                    break;
                default:
                    continue;
            }
            if ($item["contain"] == 1) {
                $conditions[] = $tmp;
            } else {
                $conditions[] = ' 不包含(' . $tmp . ')';
            }
        }
        return implode(';',$conditions);
    }

    public function getUsers(){
        $users=User::find()->where(["id"=>explode(',',$this->receivers)])->select("username")->column();
        return implode(',',$users);
    }

    public function getTemplate(){
        return '默认模版';
    }

    public function getReceiverSelect(){
        return explode(',',$this->receivers);
    }
}