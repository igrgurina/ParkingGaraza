<?php

namespace app\models;

use dektrium\user\helpers\Password;
use Yii;
use dektrium\user\models\User as BaseUser;
use yii\debug\models\search\Base;
use yii\log\Logger;

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
        Yii::getLogger()->log($this->role . ' is the role of the user',Logger::LEVEL_INFO);
        return $this->role == User::ROLE_ADMIN;
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
        return [
            [['OIB', 'first_name', 'last_name', 'password', 'phone', 'credit_card_number'], 'required'],
            [['OIB', 'credit_card_number'], 'integer'],
            [['last_login'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 40],
            [['phone'], 'string', 'max' => 20],

            // username rules
            ['username', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            ['username', 'match', 'pattern' => '/^[a-zA-Z]\w+$/'],
            ['username', 'string', 'min' => 3, 'max' => 25],
            ['username', 'unique'],
            ['username', 'trim'],

            // email rules
            ['email', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique'],
            ['email', 'trim'],

            // password rules
            ['password', 'required', 'on' => ['register']],
            ['password', 'string', 'min' => 6, 'on' => ['register', 'create']],

            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge([
            'OIB' => 'OIB',
            'first_name' => 'Ime',
            'last_name' => 'Prezime',
            'phone' => 'Broj telefona',
            'credit_card_number' => 'Broj kreditne kartice',
        ]);
    }

    /**
     * This method is used to register new user account. If Module::enableConfirmation is set true, this method
     * will generate new confirmation token and use mailer to send it to the user. Otherwise it will log the user in.
     * If Module::enableGeneratingPassword is set true, this method will generate new 8-char password. After saving user
     * to database, this method uses mailer component to send credentials (username and password) to user via email.
     *
     * @return bool
     */
    public function register()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        if ($this->module->enableConfirmation == false) {
            $this->confirmed_at = time();
        }

        if ($this->module->enableGeneratingPassword) {
            $this->password = Password::generate(8);
        }

        $this->trigger(self::USER_REGISTER_INIT);

        if ($this->save(false)) {
            Yii::getLogger()->log($this->getErrors(), Logger::LEVEL_INFO);
            $this->trigger(self::USER_REGISTER_DONE);
            if ($this->module->enableConfirmation) {
                $token = \Yii::createObject([
                    'class' => \dektrium\user\models\Token::className(),
                    'type'  => \dektrium\user\models\Token::TYPE_CONFIRMATION,
                ]);
                $token->link('user', $this);
                $this->mailer->sendConfirmationMessage($this, $token);
            } else {
                \Yii::$app->user->login($this);
            }
            if ($this->module->enableGeneratingPassword) {
                $this->mailer->sendWelcomeMessage($this);
            }
            \Yii::$app->session->setFlash('info', $this->getFlashMessage());
            \Yii::getLogger()->log('User has been registered', Logger::LEVEL_INFO);
            return true;
        }

        \Yii::getLogger()->log('An error occurred while registering user account', Logger::LEVEL_ERROR);

        return false;
    }
}
