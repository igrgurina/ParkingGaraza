<?php

namespace app\models;

use yii\db\ActiveQuery;

class ParkingQuery extends ActiveQuery
{
    public function active($state = Parking::STATUS_OPEN)
    {
        $this->andWhere(['status' => $state]);
        return $this;
    }
}