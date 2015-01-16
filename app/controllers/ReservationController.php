<?php

namespace app\controllers;

use app\models\ReservationTypeForm;
use app\models\User;
use Yii;
use app\models\Reservation;
use app\models\ReservationSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReservationController implements the CRUD actions for Reservation model.
 */
class ReservationController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'admin', 'create', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['admin'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action) {
                            return Yii::$app->user->identity->isAdmin;
                        }
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Reservation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReservationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * [UC17] Lists all Reservation models.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new ReservationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionType($parking_id)
    {
        // novi type choicer
        $model = new ReservationTypeForm();
        // pridruži dobiveni parking_id trenutnoj formi kako bi prenio na sljedeći korak (create)
        $model->parking_id = $parking_id;

        if(Yii::$app->request->isPost)
        {
            //print_r($_POST['ReservationTypeForm']['type']); die;// post('ReservationTypeForm'));die;
            $model->type = $_POST['ReservationTypeForm']['type'];

            return $this->redirect(['create', 'type' => $model->type, 'parking_id' => $model->parking_id]);
        }

        return $this->render('type', [
            'model' => $model
        ]);
    }

    /**
     * [UC10] Creates a new Reservation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $parking_id ID of the parking where the reservation takes place
     * @param string $type type of the reservation delivered by ReservationTypeForm view
     * @return mixed
     */
    public function actionCreate($parking_id, $type)
    {
        $model = new Reservation();

        if ($model->load(Yii::$app->request->post()) && $model->isPossible()) {
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->parking_id = $parking_id;
            $model->user_id = Yii::$app->user->id;
            $model->type = $type;

            switch($model->type)
            {
                case Reservation::TYPE_INSTANT:
                    $model->duration = null;
                    $model->period = null;
                    break;
                case Reservation::TYPE_PERMANENT:
                    $model->duration = 30;
                    $model->period = null;
                    break;
                default:
                    break;
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * [UC11] Deletes an existing Reservation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->cancel();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Reservation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reservation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reservation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
