<?php

namespace app\models;

use dosamigos\google\maps\overlays\Marker;
use Yii;
use yii\log\Logger;

/**
 * This is the model class for table "location".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property double $lat
 * @property double $lng
 *
 * @property Parking $parking
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'lat', 'lng'], 'required'],
            [['lat', 'lng'], 'number'],
            [['name', 'address'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Ime',
            'address' => 'Adresa',
            'lat' => 'Geografska širina',
            'lng' => 'Geografska dužina',
        ];
    }

    public function getParking()
    {
        return $this->hasOne(Parking::className(), ['location_id' => 'id']);
    }

    /**
     * Method returns distance in km
     * @param $lat float
     * @param $lon float
     * @return float
     */
    public function distance($lat, $lon)
    {
        // haversine formula
        $latFrom = deg2rad($this->lat);
        $lonFrom = deg2rad($this->lng);
        $latTo = deg2rad($lat);
        $lonTo = deg2rad($lon);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return ($angle * 6371);
    }

    /**
     * @param $coordinates string
     * @return Location
     */
    public static function createLocation($coordinates)
    {
        Yii::getLogger()->log('Coordinates: ' . $coordinates, Logger::LEVEL_ERROR);
        $pom = explode(',', $coordinates);
        $model = new Location();
        $model->lat = floatval($pom[0]);
        $model->lng = floatval($pom[1]);
        $model->address = 'Zagreb';
        $model->name = 'Parkiralište';

        $model->save(false);

        return $model;
    }

    /*
     *  Returns marker to location
     */

    public function getMarker()
    {

    }
}
