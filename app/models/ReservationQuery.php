<?php

namespace app\models;

use Faker\Provider\DateTime;
use yii\db\ActiveQuery;

class ReservationQuery extends ActiveQuery
{
    /*public function expiring($date = null)
    {
        if(is_null($date))
            $date = date('Y-m-d H:i:s');

        $this->andWhere(['sensor' => $date]);
        return $this;
    }*/

    public function periodic()
    {
        $this->andWhere(['type' => Reservation::TYPE_PERIODIC]);
        return $this;
    }

    public function instant()
    {
        $this->andWhere(['type' => Reservation::TYPE_INSTANT]);
        return $this;
    }

    public function permanent()
    {
        $this->andWhere(['type' => Reservation::TYPE_PERMANENT]);
        return $this;
    }
}