<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parking".
 *
 * @property integer $id
 * @property integer $locationId
 * @property string $type
 * @property integer $numberOfParkingSpots
 * @property integer $companyId
 * @property integer $cost
 *
 * @property Company $company
 * @property Location $location
 * @property ParkingSpot[] $parkingSpots
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
            [['locationId', 'type', 'numberOfParkingSpots', 'companyId', 'cost'], 'required'],
            [['locationId', 'numberOfParkingSpots', 'companyId', 'cost'], 'integer'],
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
            'locationId' => 'Location ID',
            'type' => 'Type',
            'numberOfParkingSpots' => 'Number Of Parking Spots',
            'companyId' => 'Company ID',
            'cost' => 'Cost',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'companyId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'locationId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParkingSpots()
    {
        return $this->hasMany(ParkingSpot::className(), ['parkingId' => 'id']);
    }
}
