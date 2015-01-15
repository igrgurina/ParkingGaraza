<?php

namespace app\controllers;

use app\models\Parking;
use dosamigos\google\maps\LatLng;
use Yii;
use yii\debug\models\search\Db;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\log\Logger;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegistrationForm;
use yii\web\UrlManager;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'register'],
                'rules' => [
                    [
                        'actions' => ['register'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        //Parking::find()->all();
        //Yii::getLogger()->log(Yii::$app->request->, Logger::LEVEL_ERROR);
        $request = Yii::$app->request;
        if($request->get('Location'))
        {
            // korisnik je "unio" svoju trenutnu lokaciju
            $coordinate = new LatLng(['lat' => $request->get('Location.lat'), 'lng' => $request->get('Location.lng')]);
            // sad imamo koordinate u povoljnom formatu
            // trebamo pronaći idealan parking i vratit ga na mapu
            return $this->render('index', [
                'parkings' => array(Parking::suggestParking($coordinate)),
                'currentLocation' => null
            ]);
        }

        return $this->render('index', [
            'parkings' => Parking::find()->all(),
            'currentLocation' => Yii::$app->request->get('Location') ?
                new LatLng(['lat' => Yii::$app->request->get('Location.lat'), 'lng' => Yii::$app->request->get('Location.lng')]) : null
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegister()
    {
        $model = new RegistrationForm();
        if($model->load(Yii::$app->request->post())) {
            if($user = $model->register()) {
                if(Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }
}
