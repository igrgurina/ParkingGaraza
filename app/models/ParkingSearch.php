<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Parking;

/**
 * ParkingSearch represents the model behind the search form about `app\models\Parking`.
 */
class ParkingSearch extends Parking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'locationId', 'numberOfParkingSpots', 'companyId', 'cost'], 'integer'],
            [['type'], 'safe'],
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
        $query = Parking::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'locationId' => $this->locationId,
            'numberOfParkingSpots' => $this->numberOfParkingSpots,
            'companyId' => $this->companyId,
            'cost' => $this->cost,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
