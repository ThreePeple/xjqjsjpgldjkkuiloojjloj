<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\AccessDeviceInfo;

/**
 * AccessDeviceInfoSearch represents the model behind the search form about `frontend\models\AccessDeviceInfo`.
 */
class AccessDeviceInfoSearch extends AccessDeviceInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'deviceId', 'ifIndex', 'vlanId', 'status'], 'integer'],
            [['deviceIp', 'ifDesc', 'learnIp', 'learnMac', 'update_time'], 'safe'],
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
        $query = AccessDeviceInfo::find();

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
            'id' => $this->id,
            'deviceId' => $this->deviceId,
            'ifIndex' => $this->ifIndex,
            'vlanId' => $this->vlanId,
            'status' => $this->status,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'deviceIp', $this->deviceIp])
            ->andFilterWhere(['like', 'ifDesc', $this->ifDesc])
            ->andFilterWhere(['like', 'learnIp', $this->learnIp])
            ->andFilterWhere(['like', 'learnMac', $this->learnMac]);

        return $dataProvider;
    }
}
