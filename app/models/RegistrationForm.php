<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\HttpException;

/**
 * LoginForm is the model behind the login form.
 */
class RegistrationForm extends Model
{
    public $username;
    public $password;

    public $OIB;
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $creditCardNumber;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'OIB' => 'OIB',
            'username' => 'Username',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'creditCardNumber' => 'Credit Card Number',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['OIB', 'username', 'password', 'firstName', 'lastName', 'email', 'phone', 'creditCardNumber'], 'required'],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            [['username'], 'string', 'min' => 2, 'max' => 16],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'string', 'min' => 6],

            [['OIB', 'creditCardNumber'], 'integer'],
            [['firstName', 'lastName'], 'string', 'min' => 2, 'max' => 40],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register()
    {
        if($this->validate())
        {
            $user = new User();
            $user->OIB = $this->OIB;
            $user->firstName = $this->firstName;
            $user->lastName = $this->lastName;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->creditCardNumber = $this->creditCardNumber;

            $user->username = $this->username;
            $user->setPassword($this->password);
            $user->generateAuthKey();

            $user->save();
            return $user;
        }

        return null;
    }
}
