<?php

namespace app\models;

use yii\db\ActiveQuery;

class ParkingSpotQuery extends ActiveQuery
{
    public function free($state = ParkingSpot::STATUS_FREE)
    {
        $this->andWhere(['sensor' => $state]);
        return $this;
    }
}