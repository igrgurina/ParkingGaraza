<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reservation;

/**
 * ReservationSearch represents the model behind the search form about `app\models\Reservation`.
 */
class ReservationSearch extends Reservation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'parking_id'], 'integer'],
            [['type', 'start', 'end', 'duration', 'period'], 'safe'],
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
        $query = Reservation::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'parking_id' => $this->parking_id,
            'start' => $this->start,
            'end' => $this->end,
            'duration' => $this->duration,
            'period' => $this->period,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function mySearch($params)
    {
        $query = Reservation::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => Yii::$app->user->id,
            'parking_id' => $this->parking_id,
            'start' => $this->start,
            'end' => $this->end,
            'duration' => $this->duration,
            'period' => $this->period,
            'active' => true
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }

}
