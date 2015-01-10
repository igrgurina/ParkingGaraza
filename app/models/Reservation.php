<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reservation".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property integer $parking_id
 * @property string $start
 * @property string $end
 * @property string $duration
 * @property string $period
 * @property bool $active
 *
 * @property User $user
 * @property Parking $parking
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
            [['user_id', 'type', 'parking_id'], 'required'],
            [['user_id', 'parking_id'], 'integer'],
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
            'parking_id' => 'Parking ID',
            'start' => 'Start',
            'end' => 'End',
            'duration' => 'Duration',
            'period' => 'Period',
        ];
    }

    public function cancel()
    {
        $this->active = false;
        $this->save(false);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParking()
    {
        return $this->hasOne(Parking::className(), ['id' => 'parking_id']);
    }
}
