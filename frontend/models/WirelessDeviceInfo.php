<?php

namespace app\models;

use frontend\models\DeviceModel;
use frontend\models\DeviceSeries;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * This is the model class for table "wireless_device_info".
 *
 * @property integer $id
 * @property string $label
 * @property string $ip
 * @property string $mask
 * @property integer $status
 * @property string $sysName
 * @property string $location
 * @property string $sysOid
 * @property string $runtime
 * @property string $lastPoll
 * @property integer $categoryId
 * @property integer $supportPing
 * @property integer $webMgrPort
 * @property integer $configPollTime
 * @property integer $statePollTime
 * @property string $typeName
 * @property integer $positionX
 * @property integer $positionY
 * @property integer $symbolType
 * @property string $symbolDesc
 * @property string $mac
 * @property string $phyName
 * @property string $phyCreateTime
 * @property integer $series_id
 * @property string $model_id
 * @property string $interfaces
 * @property string $category
 * @property string $update_time
 * @property string $series_name
 * @property string $model_name
 */
class WirelessDeviceInfo extends \yii\db\ActiveRecord
{
    const STATUS_UNMANAGED = -1;
    const STATUS_UNKNOWN = 0;
    const STATUS_NORMAL = 1;
    const STATUS_WARNING =2;
    const STATUS_MINOR =3;
    const STATUS_IMPORTANT =4;
    const STATUS_SERIOUS =5;

    static $status_titles = [
        self::STATUS_UNMANAGED =>'<span style="color:#808080" class="label label-default">未管理</span>',
        self::STATUS_UNKNOWN => '<span style="color:#00F" class="label label-default">未知</span>',
        self::STATUS_NORMAL => '<span style="color:#008000" class="label label-default">正常</span>',
        self::STATUS_WARNING => '<span style="color:#0FF" class="label label-default">警告</span>',
        self::STATUS_MINOR => '<span style="color:#FF0" class="label label-default">次要</span>',
        self::STATUS_IMPORTANT => '<span style="color:#FFA500" class="label label-default">重要</span>',
        self::STATUS_SERIOUS => '<span style="color:#F00" class="label label-default">严重</span>',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wireless_device_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'label', 'ip'], 'required'],
            [['id', 'status', 'categoryId', 'supportPing', 'webMgrPort', 'configPollTime', 'statePollTime', 'positionX', 'positionY', 'symbolType', 'series_id'], 'integer'],
            [['lastPoll', 'phyCreateTime', 'update_time'], 'safe'],
            [['symbolDesc', 'interfaces'], 'string'],
            [['label', 'ip', 'mask', 'sysName', 'location', 'sysOid', 'runtime', 'typeName', 'mac', 'phyName', 'model_id', 'category', 'series_name', 'model_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '设备ID'),
            'label' => Yii::t('app', '名称'),
            'ip' => Yii::t('app', '设备IP'),
            'mask' => Yii::t('app', '设备掩码'),
            'status' => Yii::t('app', '设备状态'),
            'sysName' => Yii::t('app', '系统名称'),
            'location' => Yii::t('app', '物理位置'),
            'sysOid' => Yii::t('app', 'sysOID'),
            'runtime' => Yii::t('app', '运行时间'),
            'lastPoll' => Yii::t('app', '最后轮询时间'),
            'categoryId' => Yii::t('app', '设备类型ID'),
            'supportPing' => Yii::t('app', 'Support Ping'),
            'webMgrPort' => Yii::t('app', 'Web Mgr Port'),
            'configPollTime' => Yii::t('app', 'Config Poll Time'),
            'statePollTime' => Yii::t('app', 'State Poll Time'),
            'typeName' => Yii::t('app', '类型名称'),
            'positionX' => Yii::t('app', 'Position X'),
            'positionY' => Yii::t('app', 'Position Y'),
            'symbolType' => Yii::t('app', 'Symbol Type'),
            'symbolDesc' => Yii::t('app', 'Symbol Desc'),
            'mac' => Yii::t('app', '设备MAC地址'),
            'phyName' => Yii::t('app', 'Phy Name'),
            'phyCreateTime' => Yii::t('app', '创建时间'),
            'series_id' => Yii::t('app', 'Series ID'),
            'model' => Yii::t('app', 'Model'),
            'interfaces' => Yii::t('app', 'Interfaces'),
            'category' => Yii::t('app', 'Category'),
            'update_time' => Yii::t('app', 'Update Time'),
            'series_name' => Yii::t('app', '设备系列'),
            'model_name' => Yii::t('app', '设备型号'),

        ];
    }

    /**
     * 设备所属系列
     * @return \yii\db\ActiveQuery
     */
    public function getSeries(){
        return $this->hasOne(DeviceSeries::className(),['id'=>'series_id']);
    }

    public function getCategory(){
        return $this->hasOne(WirelessDeviceCategory::className(),["id"=>'categoryId']);
    }

    public function getType(){
        return $this->hasOne(WirelessDeviceCategory::className(),["id"=>'categoryId']);
    }

    public function getModel(){
        return $this->hasOne(DeviceModel::className(),["id"=>"model_id"]);
    }

    public function getInterfaces(){
        return $this->hasMany(WirelessDeviceInterface::className(),["device_id"=>"id"]);
    }

    public function search($params){
        $query = WirelessDeviceInfo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,

        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'typeName', $this->typeName])
            ->andFilterWhere(['like', 'ip', $this->ip]);
        return $dataProvider;
    }

    public static function getSelect2List($q=null,$selected=[]){

        $query = self::find();
        $query->andFilterWhere(["like","label",$q]);
        // $query->andFilterWhere(["not in","id",$exclude_ids]);
        $query->select(["id"=>"id","label"=>"label"]);
        $rows = $query->asArray()->all();
        array_walk($rows,function(&$item,$k,$seleceted){
            if(in_array($item["id"],$seleceted)){
                $item["disabled"] = true;
            }
        },$selected);
        return $rows;
    }

    public static function getDeviceList(){
        $result = [];
        $filterIps = DeviceIpfilter::getIdsByType(DeviceIpfilter::TYPE_WIRELESS);
        $rows = self::find()
            ->with("category")
            ->where(["ip"=>$filterIps])
            ->orderBy("ip asc")
            ->asArray()
            ->all();
        foreach($rows as $row){
            $type = $row["category"]["node_group"];
            if(!isset($result[$type])){
                $result[$type] = [];
            }
            $result[$type][] = ["id"=>$row["id"],"label"=>$row["ip"]];
        }
        return $result;
    }

    /**
     * 获取设备链路
     */
    public function getLinks(){
        $links = [];
        $left = (new Query())->from("device_link a")
            ->leftJoin("device_info b","a.rightDevice=b.id")
            ->select(["link_device"=>"b.label","desc"=>"a.rightIfDesc","a.brandWidth","a.status"])
            ->where(["a.leftDevice"=>$this->id])
            ->one();
    }

    public function getStatusShow(){
        switch($this->status){
            case self::STATUS_UNMANAGED:
                return '<span style="color:#808080">未管理</span>';
            case self::STATUS_UNKNOWN:
                return '<span style="color:#00F">未知</span>';
            case self::STATUS_NORMAL:
                return '<span style="color:#008000">正常</span>';
            case self::STATUS_WARNING:
                return '<span style="color:#0FF">警告</span>';
            case self::STATUS_MINOR:
                return '<span style="color:#FF0">次要</span>';
            case self::STATUS_IMPORTANT:
                return '<span style="color:#FFA500">重要</span>';
            case self::STATUS_SERIOUS:
                return '<span style="color:#F00">严重</span>';
            default:
                return '<span style="color:#00F">未知</span>';
        }
    }

}
