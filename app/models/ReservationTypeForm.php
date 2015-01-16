<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ReservationTypeForm extends Reservation
{
    public $parking_id;
    public $type;

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'type' => 'Tip rezervacije',
        ];
    }
}
