<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reservation".
 *
 * @property integer $id
 * @property integer $userId
 * @property string $type
 * @property integer $parkingSpotId
 * @property string $start
 * @property string $end
 * @property string $duration
 * @property string $period
 *
 * @property ParkingSpot $parkingSpot
 * @property User $user
 */
class Reservation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reservation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'type', 'parkingSpotId'], 'required'],
            [['userId', 'parkingSpotId'], 'integer'],
            [['type'], 'string'],
            [['start', 'end', 'duration', 'period'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'type' => 'Type',
            'parkingSpotId' => 'Parking Spot ID',
            'start' => 'Start',
            'end' => 'End',
            'duration' => 'Duration',
            'period' => 'Period',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParkingSpot()
    {
        return $this->hasOne(ParkingSpot::className(), ['id' => 'parkingSpotId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
