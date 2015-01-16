<?php

namespace app\models;

use dosamigos\google\maps\LatLng;
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

    const MAXIMUM_DISTANCE = 50000;

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
            [['type'], 'string'],
            ['number_of_parking_spots', 'compare', 'compareValue' => 10, 'operator' => '>='],
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
     * @inheritdoc
     * @return ParkingQuery
     */
    public static function find()
    {
        return new ParkingQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFreeParkingSpots()
    {
        return $this->hasMany(ParkingSpot::className(), ['parking_id' => 'id'])->free();
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
     * @param $number integer
     * @return Parking[]
     */
    public static function findBestSuggestion($number)
    {
        // TODO: ispraviti
        $parkings = [];
        foreach (Parking::find()->active()->all() as $item) {
            if($item->freeParkingSpotsCount > $number)
                array_push($parkings, $item);
        }
        return $parkings;
        //return Parking::find()->where('freeParkingSpotsCount > num', ['num' => $number])->all(); //->andWhere(['location.lat' => $coordinate->getLat(), 'location.lng' => $coordinate->getLng()]) ->all();
    }

    /**
     * @param $coordinate LatLng
     * @return $parking Parking
     */
    public static function suggestParking($coordinate)
    {
        $lat = $coordinate->getLat();
        $lng = $coordinate->getLng();

        $minimumDistance = static::MAXIMUM_DISTANCE;
        $suggestedParking = null;
        foreach (Parking::findBestSuggestion(9) as $item) {
            /* @param $item Parking */
            $distance = $item->location->distance($lat, $lng);
            if($distance < $minimumDistance) {
                $minimumDistance = $distance;
                $suggestedParking = $item;
            }
        }
        if($minimumDistance != static::MAXIMUM_DISTANCE)
        {
            return $suggestedParking;
        }
        foreach (Parking::findBestSuggestion(0) as $item) {
            /* @param $item Parking */
            $distance = $item->location->distance($lat, $lng);
            if($distance < $minimumDistance) {
                $minimumDistance = $distance;
                $suggestedParking = $item;
            }
        }

        if($minimumDistance != static::MAXIMUM_DISTANCE)
        {
            return $suggestedParking;
        }

        return null;
    }

    public function createParkingSpots()
    {
        for ($i = 1; $i <= $this->number_of_parking_spots; $i++){
            $parkingSpot = new ParkingSpot();
            $parkingSpot->parking_id = $this->id;
            $parkingSpot->sensor = ParkingSpot::STATUS_FREE;
            $parkingSpot->save(false);
        }
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

    public function delete()
    {
        // TODO: promijeniti na STATUS_CLOSED
    }

}
