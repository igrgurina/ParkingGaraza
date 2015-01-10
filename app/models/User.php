<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $OIB
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property integer $credit_card_number
 * @property string $last_login
 *
 * TODO: session variables for latitude and longitude ?
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OIB', 'username', 'first_name', 'last_name', 'email', 'password', 'phone', 'credit_card_number'], 'required'],
            [['OIB', 'credit_card_number'], 'integer'],
            [['last_login'], 'safe'],
            [['username'], 'string', 'max' => 16],
            [['first_name', 'last_name'], 'string', 'max' => 40],
            [['email'], 'string', 'max' => 70],
            [['password'], 'string', 'max' => 64],
            [['phone'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'OIB' => 'Oib',
            'username' => 'Username',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Phone',
            'credit_card_number' => 'Credit Card Number',
            'last_login' => 'Last Login',
        ];
    }
}
