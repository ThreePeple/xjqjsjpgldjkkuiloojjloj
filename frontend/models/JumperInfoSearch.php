<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\JumperInfo;

/**
 * JumperInfoSearch represents the model behind the search form about `app\models\JumperInfo`.
 */
class JumperInfoSearch extends JumperInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['ip', 'port', 'wire_frame', 'wire_position', 'point', 'insert_no'], 'safe'],
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
        $query = JumperInfo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                "pageSize"  => 10
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
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'port', $this->port])
            ->andFilterWhere(['like', 'wire_frame', $this->wire_frame])
            ->andFilterWhere(['like', 'wire_position', $this->wire_position])
            ->andFilterWhere(['like', 'point', $this->point])
            ->andFilterWhere(['like', 'insert_no', $this->insert_no]);

        return $dataProvider;
    }
}
