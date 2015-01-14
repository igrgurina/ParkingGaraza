<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;

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
 * @property string $coordinates
 *
 * @property Company $company
 * @property Location $location
 * @property \yii\db\ActiveQuery $parkingSpots
 * @property Reservation[] $reservations
 * @property integer $freeParkingSpotsCount
 * @property \yii\db\ActiveQuery $freeParkingSpots
 */
class Parking extends \yii\db\ActiveRecord
{
    public $coordinates;

    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 0;

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
            [['type', 'number_of_parking_spots', 'company_id'], 'required'],
            [['coordinates'], 'safe'],
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
            'type' => 'Tip',
            'number_of_parking_spots' => 'Broj parkirnih mjesta',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFreeParkingSpots()
    {
        return $this->hasMany(ParkingSpot::className(), ['parking_id' => 'id'])->onCondition(['sensor' => 1]);
    }

    /**
     * Returns number of free spots
     *
     * @return integer
     */
    public function getFreeParkingSpotsCount()
    {
        return count($this->freeParkingSpots);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function findBestSuggestion()
    {
        return Parking::find()->where('freeParkingSpotsCount > :num', ['num' => 9])->all();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //throw new ErrorException(explode(',',$this->coordinates)[1]);
            $this->company_id = 1;
            $this->status = static::STATUS_OPEN;
            $this->location_id = Location::createLocation($this->coordinates)->id;
            return true;
        } else {
            return false;
        }
    }

}
