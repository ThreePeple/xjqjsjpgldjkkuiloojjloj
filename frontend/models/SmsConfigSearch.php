<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\SmsConfig;

/**
 * SmsConfigSearch represents the model behind the search form about `frontend\models\SmsConfig`.
 */
class SmsConfigSearch extends SmsConfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'smsTemplate_id'], 'integer'],
            [['alarmSet', 'alarmCondition', 'receivers', 'create_time', 'update_time'], 'safe'],
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
        $query = SmsConfig::find();

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
            'smsTemplate_id' => $this->smsTemplate_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'alarmSet', $this->alarmSet])
            ->andFilterWhere(['like', 'alarmCondition', $this->alarmCondition])
            ->andFilterWhere(['like', 'receivers', $this->receivers]);

        return $dataProvider;
    }
}
