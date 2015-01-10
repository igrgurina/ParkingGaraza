<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reservation".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property integer $parking_spot_id
 * @property string $start
 * @property string $end
 * @property string $duration
 * @property string $period
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
            [['user_id', 'type', 'parking_spot_id'], 'required'],
            [['user_id', 'parking_spot_id'], 'integer'],
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
            'user_id' => 'User ID',
            'type' => 'Type',
            'parking_spot_id' => 'Parking Spot ID',
            'start' => 'Start',
            'end' => 'End',
            'duration' => 'Duration',
            'period' => 'Period',
        ];
    }
}
