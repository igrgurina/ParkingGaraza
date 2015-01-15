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
     * @param $lat2 float
     * @param $lon2 float
     * @return float
     */
    public function distance($lat2, $lon2)
    {
        $theta = $this->lng - $lon2;
        $dist = sin(deg2rad($this->lat)) * sin(deg2rad($lat2)) +
            cos(deg2rad($this->lat)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        return ($miles * 1.609344);
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
