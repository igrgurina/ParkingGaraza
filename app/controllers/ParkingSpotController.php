<?php

namespace app\controllers;

use Yii;
use app\models\ParkingSpot;
use app\models\ParkingSpotSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ParkingSpotController implements the CRUD actions for ParkingSpot model.
 */
class ParkingSpotController extends Controller
{
    /**
     * Finds the ParkingSpot model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ParkingSpot the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ParkingSpot::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
