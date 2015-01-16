<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parking_spot".
 *
 * @property integer $id
 * @property integer $parking_id
 * @property integer $sensor  is one if taken
 *
 * @property Parking $parking
 */
class ParkingSpot extends \yii\db\ActiveRecord
{
    const STATUS_FREE = 1;
    const STATUS_TAKEN = 0;

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
            [['parking_id', 'sensor'], 'required'],
            [['parking_id', 'sensor'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parking_id' => 'Parking ID',
            'sensor' => 'Sensor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParking()
    {
        return $this->hasOne(Parking::className(), ['id' => 'parking_id']);
    }

    /**
     * @inheritdoc
     * @return ParkingSpotQuery
     */
    public static function find()
    {
        return new ParkingSpotQuery(get_called_class());
    }

    public static function triggerSensorsAt($parkingSpots)
    {
        foreach ($parkingSpots as $ps) {
            $ps->sensor = !$ps->sensor;
        }

    }
}
