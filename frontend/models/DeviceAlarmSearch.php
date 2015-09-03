<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\DeviceAlarm;

/**
 * DeviceAlarmSearch represents the model behind the search form about `app\models\DeviceAlarm`.
 */
class DeviceAlarmSearch extends DeviceAlarm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'deviceId', 'alarmLevel', 'alarmCategory', 'faultTime', 'recTime', 'recStatus', 'ackTime', 'ackStatus', 'somState', 'defineType', 'customAlarmLevel', 'specificId', 'originalType'], 'integer'],
            [['OID', 'originalTypeDesc', 'deviceIp', 'deviceName', 'alarmLevelDesc', 'alarmCategoryDesc', 'faultTimeDesc', 'recTimeDesc', 'recStatusDesc', 'recUserName', 'ackTimeDesc', 'ackStatusDesc', 'ackUserName', 'alarmDesc', 'remark', 'eventName', 'reason', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DeviceAlarm::find();
        $query->andWhere(['not',["deviceId"=>0]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                "pageSize" => 10
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'deviceId' => $this->deviceId,
            'alarmLevel' => $this->alarmLevel,
            'alarmCategory' => $this->alarmCategory,
            'faultTime' => $this->faultTime,
            'recTime' => $this->recTime,
            'recStatus' => $this->recStatus,
            'ackTime' => $this->ackTime,
            'ackStatus' => $this->ackStatus,
            'somState' => $this->somState,
            'defineType' => $this->defineType,
            'customAlarmLevel' => $this->customAlarmLevel,
            'update_time' => $this->update_time,
            'specificId' => $this->specificId,
            'originalType' => $this->originalType,
        ]);

        $query->andFilterWhere(['like', 'OID', $this->OID])
            ->andFilterWhere(['like', 'originalTypeDesc', $this->originalTypeDesc])
            ->andFilterWhere(['like', 'deviceIp', $this->deviceIp])
            ->andFilterWhere(['like', 'deviceName', $this->deviceName])
            ->andFilterWhere(['like', 'alarmLevelDesc', $this->alarmLevelDesc])
            ->andFilterWhere(['like', 'alarmCategoryDesc', $this->alarmCategoryDesc])
            ->andFilterWhere(['like', 'faultTimeDesc', $this->faultTimeDesc])
            ->andFilterWhere(['like', 'recTimeDesc', $this->recTimeDesc])
            ->andFilterWhere(['like', 'recStatusDesc', $this->recStatusDesc])
            ->andFilterWhere(['like', 'recUserName', $this->recUserName])
            ->andFilterWhere(['like', 'ackTimeDesc', $this->ackTimeDesc])
            ->andFilterWhere(['like', 'ackStatusDesc', $this->ackStatusDesc])
            ->andFilterWhere(['like', 'ackUserName', $this->ackUserName])
            ->andFilterWhere(['like', 'alarmDesc', $this->alarmDesc])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'eventName', $this->eventName])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
