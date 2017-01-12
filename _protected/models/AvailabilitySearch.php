<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Availability;

/**
 * AvailabilitySearch represents the model behind the search form about `app\models\Availability`.
 */
class AvailabilitySearch extends Availability
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'duration_sec'], 'integer'],
            [['start_time', 'end_time', 'created_by',  'updated_by'], 'string'],
            [['fault_code_id', 'work_centre_id', 'created_at', 'updated_at'], 'safe'],
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
        $query = Availability::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('createdBy');
        $query->joinWith('workCentre');
        $query->joinWith('faultCode');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'start_time' => $this->start_time,
            //'end_time' => $this->end_time,
            'duration_sec' => $this->duration_sec,
            //'fault_code_id' => $this->fault_code_id,
            //'work_centre_id' => $this->work_centre_id,
            //'created_at' => $this->created_at,
            //'created_by' => $this->created_by,
            //'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['like', 'user.username', $this->created_by])
            ->andFilterWhere(['like', 'user.username', $this->updated_by])
            ->andFilterWhere(['like', 'work_centre.name', $this->work_centre_id])
            ->andFilterWhere(['like', 'fault_code.name', $this->fault_code_id]);
  

        return $dataProvider;
    }
}
