<?php
namespace app\controllers\user;

use dektrium\user\Finder;
use app\models\User;
use dektrium\user\models\UserSearch;
use yii\base\Model;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use dektrium\user\controllers\AdminController as BaseAdminController;

/**
 * AdminController allows you to administrate users.
 *
 * @property \dektrium\user\Module $module
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class AdminController extends BaseAdminController
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete'  => ['post'],
                    'confirm' => ['post'],
                    'block'   => ['post'],
                    'admin'   => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'block', 'confirm', 'admin'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return \Yii::$app->user->identity->getIsAdmin() || !\Yii::$app->user->identity->getIsBlocked();
                        }
                    ],
                ]
            ]
        ];
    }

    /**
     * Toggles the User privileges.
     * @param integer $id
     * @param string  $back
     * @return \yii\web\Response
     */
    public function actionAdmin($id, $back = 'index')
    {
        $model = User::findOne($id);
        if($model->isAdmin)
        {
            $model->removeAdmin();
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Korisnik više nije administrator.'));
        }
        else
        {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Korisnik je uspješno proglašen administratorom.'));
            $model->makeAdmin();
        }

        $url = $back == 'index' ? ['index'] : ['update', 'id' => $id];
        return $this->redirect($url);
    }

    /**
     * Blocks the user.
     * @param  integer $id
     * @param  string  $back
     * @return \yii\web\Response
     */
    public function actionBlock($id, $back = 'index')
    {
        $user = User::findOne($id);
        if ($id == \Yii::$app->user->getId()) {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('user', 'Ne možeš blokirati ni odblokirati vlastiti korisnički račun.'));
        }
        else if($user->isAdmin) {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('user', 'Ne možeš blokirati administratora. Pokušaj ponovno nakon što mu smanjiš privilegije.'));
        }
        else {
            if ($user->getIsBlocked()) {
                $user->unblock();
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Korisnik je odblokiran.'));
            } else {
                $user->block();
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Korisnik je blokiran.'));
            }
        }
        $url = $back == 'index' ? ['index'] : ['update', 'id' => $id];
        return $this->redirect($url);
    }
}
