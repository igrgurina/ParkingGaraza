<?php

namespace app\models;

use Yii;
use dektrium\user\models\User as BaseUser;
use yii\debug\models\search\Base;

/**
 * This is the model class for table "user".
 *
 * @property integer $OIB
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property integer $credit_card_number
 * @property integer $role
 *
 * @property bool $isAdmin
 *
 * TODO: session variables for latitude and longitude ?
 */
class User extends BaseUser
{
    const ROLE_ADMIN = 1;

    /**
     * @return bool Whether the user is an admin or not.
     */
    public function getIsAdmin()
    {
        return $this->role === static::ROLE_ADMIN;
    }

    public function scenarios()
    {
        return [
            'register' => ['username', 'email', 'password', 'OIB', 'first_name', 'last_name', 'phone', 'credit_card_number'],
            'connect'  => ['username', 'email'],
            'create'   => ['username', 'email', 'password'],
            'update'   => ['username', 'email', 'password'],
            'settings' => ['username', 'email', 'password']
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            [
                [['OIB', 'first_name', 'last_name', 'password', 'phone', 'credit_card_number'], 'required'],
                [['OIB', 'credit_card_number'], 'integer'],
                [['last_login'], 'safe'],
                [['first_name', 'last_name'], 'string', 'max' => 40],
                [['phone'], 'string', 'max' => 20]
            ],
            parent::rules()
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge([
            'OIB' => 'Oib',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'credit_card_number' => 'Credit Card Number',
        ]);
    }
}
