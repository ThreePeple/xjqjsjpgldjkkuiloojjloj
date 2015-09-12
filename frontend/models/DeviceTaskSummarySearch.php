<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\DeviceTaskSummary;

/**
 * DeviceTaskSummarySearch represents the model behind the search form about `frontend\models\DeviceTaskSummary`.
 */
class DeviceTaskSummarySearch extends DeviceTaskSummary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'taskId', 'devId', 'instId'], 'integer'],
            [['taskName', 'objIndex', 'objIndexDesc', 'averageValue', 'maximumValue', 'minimumValue', 'currentValue', 'summaryValue'], 'safe'],
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
        $query = DeviceTaskSummary::find();

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
            'taskId' => $this->taskId,
            'devId' => $this->devId,
            'instId' => $this->instId,
        ]);

        $query->andFilterWhere(['like', 'taskName', $this->taskName])
            ->andFilterWhere(['like', 'objIndex', $this->objIndex])
            ->andFilterWhere(['like', 'objIndexDesc', $this->objIndexDesc])
            ->andFilterWhere(['like', 'averageValue', $this->averageValue])
            ->andFilterWhere(['like', 'maximumValue', $this->maximumValue])
            ->andFilterWhere(['like', 'minimumValue', $this->minimumValue])
            ->andFilterWhere(['like', 'currentValue', $this->currentValue])
            ->andFilterWhere(['like', 'summaryValue', $this->summaryValue]);
        return $dataProvider;
    }
}
