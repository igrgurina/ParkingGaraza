<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parking_spot".
 *
 * @property integer $id
 * @property integer $parkingId
 * @property integer $sensor
 *
 * @property Parking $parking
 * @property Reservation[] $reservations
 */
class ParkingSpot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parking_spot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parkingId', 'sensor'], 'required'],
            [['parkingId', 'sensor'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parkingId' => 'Parking ID',
            'sensor' => 'Sensor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParking()
    {
        return $this->hasOne(Parking::className(), ['id' => 'parkingId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservations()
    {
        return $this->hasMany(Reservation::className(), ['parkingSpotId' => 'id']);
    }
}
