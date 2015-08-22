<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jumper_info".
 *
 * @property integer $id
 * @property string $ip
 * @property string $port
 * @property string $wire_frame
 * @property string $wire_position
 * @property string $point
 * @property string $insert_no
 */
class JumperInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jumper_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip'], 'string', 'max' => 64],
            [['port', 'wire_frame', 'wire_position', 'point', 'insert_no','tag'], 'string', 'max' => 128],
            [['ip', 'port'], 'unique', 'targetAttribute' => ['ip', 'port'], 'message' => 'The combination of Ip and Port has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => '交换机IP',
            'port' => '设备端口',
            'wire_frame' => '线架号',
            'wire_position' => '线架位置',
            'point' => '线架端口',
            'tag' => '点位标签',
            'insert_no' => '点位号'
        ];
    }
}
