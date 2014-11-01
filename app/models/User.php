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
 * @property integer $location_id
 * @property string $last_login
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
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
            [['OIB', 'credit_card_number', 'location_id'], 'integer'],
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
            'location_id' => 'Location ID',
            'last_login' => 'Last Login',
        ];
    }

    public static function findIdentity($id)
    {
    	return static::findOne($id);
    }

	/**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    	return null; // static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
    	return $this->id;
    }

    public function getAuthKey()
    {
        return null; // $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return true; // $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
