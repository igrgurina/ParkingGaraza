<?php

namespace app\models;

use Yii;

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
            'name' => 'Name',
            'address' => 'Address',
            'lat' => 'Lat',
            'lng' => 'Lng',
        ];
    }

    public function getParking()
    {
        return $this->hasOne(Parking::className(), ['location_id' => 'id']);
    }

    /**
     * @return Parking[]
     */
    public function suggestParking()
    {
        // TODO: nađi najbliža parkirališta
        $parking = null;


    }

    /**Metod returns distance in km
     * @param $lat1
     * @param $lon1
     * @param $lat2
     * @param $lon2
     * @return float
     */
    private function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        return ($miles * 1.609344);
    }


}
