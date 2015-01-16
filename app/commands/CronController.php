<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\ParkingSpot;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CronController extends Controller
{
    /**
     * This command chooses random parking spots and triggers sensors in them.
     */
    public function actionPick()
    {
        $parkingSpots = ParkingSpot::find()->all();
        shuffle($parkingSpots);
        ParkingSpot::triggerSensorsAt(array_slice($parkingSpots, 2, 6));
    }

    /**
     * This command updates periodic reservations (including the permanent ones) if they're eligible.
     */
    public function actionUpdate()
    {

    }
}
