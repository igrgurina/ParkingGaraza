<?php

namespace app\models;

use Yii, DateTime, DateInterval;
use yii\log\Logger;

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
    const TYPE_INSTANT = 'instant';
    const TYPE_PERIODIC = 'recurring';
    const TYPE_PERMANENT = 'permanent';

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
            [['start', 'end', 'duration', 'period'], 'safe'],
            // TODO: usporedba ne radi baš najbolje ukoliko se rezervira isti dan
            ['start', 'compare', 'compareValue' => Reservation::sixHoursAheadFromNow(), 'operator' => '>='],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID Korisnika',
            'type' => 'Tip rezervacije',
            'parking_id' => 'ID Parkirališta',
            'start' => 'Vrijeme početka',
            'end' => 'Vrijeme završetka',
            'duration' => 'Trajanje',
            'period' => 'Period',
        ];
    }

    /**
     * @return string
     */
    public static function sixHoursAheadFromNow()
    {
        // 14.01.2015, 00:00
        $var = (new DateTime())->add(new DateInterval('PT6H0S'))->format('d.m.Y, H:i');
        Yii::getLogger()->log('Vrijeme koje se provjerava je: ' . $var, Logger::LEVEL_INFO);
        return $var;
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

    /*
     * Checks whether it's possible to add a reservation
     */

    public function isPossible()
    {
        $start = new DateTime($this->start);
        $end = new DateTime($this->end);

        if ($this->type == 'instant') {

            $count = $this->activeReservationsAt($start, $end);

            return (($count >= $this->parking->number_of_parking_spots) ? (false) : (true));

        } elseif ($this->type=='recurring' or $this->type=='permanent'){

            for ($i = $start; $i <= $end; $i->add(new DateInterval( 'P1D'/* 'P' . $this->period . 'D' */))) {
                $j = $i;
                if($end == $i) return false;

                if ($this->activeReservationsAt($i, $j->add(new DateInterval('PT' . $this->duration . 'H')))
                        >= $this->parking->number_of_parking_spots)
                    return false;
                // if ( activeReservationsAt(start, start+duration) >= totalSpotNum) return false;
                // ako prezivi sve iteracije, znaci da nema kolizije i vraca true

            }
            return true;
        }
    }

   /*
    * Counts collisions in certain day
    */


    private function activeReservationsAt ($start, $end) {

        $count = 0;
        foreach($this->parking->reservations as $res) {

            if (true /* $res->active  - NEMA GA U BAZI!*/) {
                $cmpstart = new DateTime($res->start);
                $cmpend = new DateTime($res->end);

                if (($cmpend > $start) && ($cmpstart < $end)) {

                    if ($res->type == 'instant')
                        $count++;
                    else {
                        for ($i = $cmpstart; $i < $cmpend;) {
                            if (($i < $end) and ($i->add(new DateInterval('PT' . $this->duration . 'H')) > $start)) {
                                $count++;
                                break;
                            }
                            $i->add(new DateInterval('P1D'));   // adds a day
                        }
                    }
                }
            }
        }
        return $count;
    }
}


