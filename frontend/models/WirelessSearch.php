<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\WirelessDeviceInfo;
use yii\helpers\ArrayHelper;

/**
 * WirelessSearch represents the model behind the search form about `app\models\WirelessDeviceInfo`.
 */
class WirelessSearch extends WirelessDeviceInfo
{
    public $series;
    public $model;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'categoryId', 'supportPing', 'webMgrPort', 'configPollTime', 'statePollTime', 'positionX', 'positionY', 'symbolType', 'series_id'], 'integer'],
            [['label', 'ip', 'mask', 'sysName', 'location', 'sysOid', 'runtime', 'lastPoll', 'typeName', 'symbolDesc', 'mac', 'phyName', 'phyCreateTime', 'model_id', 'interfaces', 'category', 'update_time', 'series_name', 'model_name'], 'safe'],
            [['series','model'],'safe']
        ];
    }

    public function attributeLabels(){
        return ArrayHelper::merge(parent::attributeLabels(),[
            "series" => "设备系列",
            "model" => "设备型号"
        ]);
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
    public function search($params,$ips=[])
    {
        $query = WirelessDeviceInfo::find();
        $query->joinWith(['series','model']);

        $query->andFilterWhere(["ip"=>$ips]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'device_info.id' => $this->id,
            'status' => $this->status,
            'lastPoll' => $this->lastPoll,
            'categoryId' => $this->categoryId,
            'supportPing' => $this->supportPing,
            'webMgrPort' => $this->webMgrPort,
            'configPollTime' => $this->configPollTime,
            'statePollTime' => $this->statePollTime,
            'positionX' => $this->positionX,
            'positionY' => $this->positionY,
            'symbolType' => $this->symbolType,
            'phyCreateTime' => $this->phyCreateTime,
            'series_id' => $this->series_id,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'mask', $this->mask])
            ->andFilterWhere(['like', 'sysName', $this->sysName])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'sysOid', $this->sysOid])
            ->andFilterWhere(['like', 'runtime', $this->runtime])
            ->andFilterWhere(['like', 'typeName', $this->typeName])
            ->andFilterWhere(['like', 'symbolDesc', $this->symbolDesc])
            ->andFilterWhere(['like', 'mac', $this->mac])
            ->andFilterWhere(['like', 'phyName', $this->phyName])
            ->andFilterWhere(['like', 'model_id', $this->model_id])
            ->andFilterWhere(['like', 'interfaces', $this->interfaces])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'series_name', $this->series_name])
            ->andFilterWhere(['like', 'model_name', $this->model_name])
            ->andFilterWhere(['like', 'device_model.name', $this->model])
            ->andFilterWhere(['like', 'device_series.name', $this->series]);

        return $dataProvider;
    }
}
