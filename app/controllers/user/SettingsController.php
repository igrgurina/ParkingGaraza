<?php

namespace app\controllers\user;


use app\models\User;
use dektrium\user\controllers\SettingsController as BaseController;

use dektrium\user\Finder;
use dektrium\user\models\Account;
use dektrium\user\models\SettingsForm;
use dektrium\user\Module;
use yii\authclient\ClientInterface;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * SettingsController manages updating user settings (e.g. profile, email and password).
 */
class SettingsController extends BaseController
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'disconnect' => ['post'],
                    //'deactivate' => ['post']
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['profile', 'account', 'confirm', 'networks', 'connect', 'disconnect', 'deactivate'],
                        'roles'   => ['@']
                    ],
                ]
            ],
        ];
    }

    /**
     * Shows profile settings form.
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $model = User::findOne(\Yii::$app->user->id);

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Uspješno su izmjenjeni korisnički podaci.'));
            return $this->refresh();
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    /**
     * Deactivates the user.
     * @param  integer $id
     * @return \yii\web\Response
     */
    public function actionDeactivate()
    {
        $model = User::findOne(\Yii::$app->user->id);
        $model->deactivate();
        \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Deaktivirali ste vlastiti račun.'));

        $this->redirect(['/user/security/logout']);
    }
}
