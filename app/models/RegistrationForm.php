<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\HttpException;
use dektrium\user\models\RegistrationForm as RegForm;

/**
 * LoginForm is the model behind the login form.
 */
class RegistrationForm extends RegForm
{
    //public $username;
    //public $password;
    //public $email;

    /** @var integer */
    public $OIB;
    /** @var string */
    public $firstName;
    /** @var string */
    public $lastName;

    /** @var string */
    public $phone;
    /** @var integer */
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
            'password' => 'Password',
            'creditCardNumber' => 'Credit Card Number',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            /*['username', 'filter', 'filter' => 'trim'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z]\w+$/'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => $this->module->modelMap['User'],
                'message' => \Yii::t('user', 'This username has already been taken')],
            ['username', 'string', 'min' => 3, 'max' => 20],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => $this->module->modelMap['User'],
                'message' => \Yii::t('user', 'This email address has already been taken')],

            ['password', 'required', 'skipOnEmpty' => $this->module->enableGeneratingPassword],
            ['password', 'string', 'min' => 6],

            [['OIB', 'firstName', 'lastName', 'phone', 'creditCardNumber'], 'required'],

            [['OIB', 'creditCardNumber'], 'integer'],
            [['firstName', 'lastName'], 'string', 'min' => 2, 'max' => 40],
            [['phone'], 'string', 'max' => 20],*/
            [['username', 'password', 'email', 'OIB', 'firstName', 'lastName', 'phone', 'creditCardNumber'], 'safe'],
        ];
    }

    /**
     * Registers a new user account.
     * @return bool
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->user->setAttributes([
            'email'    => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone' => $this->phone,
            'credit_card_number' => $this->creditCardNumber
        ]);

        return $this->user->register();
    }
}
