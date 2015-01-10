<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parking".
 *
 * @property integer $id
 * @property integer $location_id
 * @property string $type
 * @property integer $number_of_parking_spots
 * @property integer $company_id
 * @property integer $status
 *
 * @property Company $company
 * @property Location $location
 * @property ParkingSpot[] $parkingSpots
 * @property Reservation[] $reservations
 */
class Parking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location_id', 'type', 'number_of_parking_spots', 'company_id'], 'required'],
            [['location_id', 'number_of_parking_spots', 'company_id', 'status'], 'integer'],
            [['type'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location_id' => 'Location ID',
            'type' => 'Type',
            'number_of_parking_spots' => 'Number Of Parking Spots',
            'company_id' => 'Company ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParkingSpots()
    {
        return $this->hasMany(ParkingSpot::className(), ['parking_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservations()
    {
        return $this->hasMany(Reservation::className(), ['parking_id' => 'id']);
    }
}
