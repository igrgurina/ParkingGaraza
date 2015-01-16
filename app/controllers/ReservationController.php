<?php

namespace app\controllers;

use app\models\ReservationTypeForm;
use app\models\User;
use kartik\daterange\DateRangePicker;
use Yii;
use app\models\Reservation;
use app\models\ReservationSearch;
use yii\base\ErrorException;
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
                'only' => ['index', 'admin', 'create', 'delete', 'type'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'delete', 'type'],
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
        $dataProvider = $searchModel->mySearch(Yii::$app->request->queryParams);

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

        $model->parking_id = $parking_id;
        $model->user_id = Yii::$app->user->id;
        $model->type = $type;

        $request = Yii::$app->request;
        if($request->isPost)
        {
            switch($model->type)
            {
                case Reservation::TYPE_INSTANT:
                    $start = explode('-', $_POST['Reservation']['termin']);
                    // TODO: start i end moraju biti u istom danu
                    $model->duration = 1;
                    $model->period = null;
                    $model->start = date("Y-m-d H:i:s", strtotime($start[0])); // ,  $_POST['Reservation']['start']); // 16.01.2015, 00:00
                    $model->end = date("Y-m-d H:i:s", strtotime($start[1])); //['end']); // j.n.Y, H:i
                    break;
                case Reservation::TYPE_PERMANENT:
                    $model->duration = 30;
                    $model->period = null; // period je null, ili 1 po dogovoru
                    $model->end = null; // trajna rezervacija nema službeni kraj, samo početak
                    $model->start = date("Y-m-d H:i:s", strtotime($_POST['Reservation']['start']));
                    break;
                default:
                    $start = explode('-', $_POST['Reservation']['termin']);
                    $model->duration = 30;
                    $model->period = $_POST['Reservation']['period'];
                    $model->start = date("Y-m-d H:i:s", strtotime($start[0]));
                    $model->end = date("Y-m-d H:i:s", strtotime($start[1]));
                    break;
            }


            if($model->isPossible() && $model->save())
                \Yii::$app->getSession()->setFlash('success', 'Rezervacija je uspješno kreirana.');
            else
                \Yii::$app->getSession()->setFlash('danger', 'Nemate dovoljno sredstava na računu za obaviti rezervaciju.');


            return $this->goHome();

            //if ($model->load(Yii::$app->request->post()) && $model->isPossible()) {
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * [UC11] Cancels an existing Reservation model.
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
