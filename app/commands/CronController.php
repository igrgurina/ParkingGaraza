<?php
namespace app\commands;

use app\models\ParkingSpot;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Ivan Grgurina <ivan.grgurina@fer.hr>
 */
class CronController extends Controller
{
    /**
     * This command chooses random parking spots and triggers sensors in them.
     */
    public function actionPick()
    {
        //$this->stdout("Hello?\n", Console::BOLD);
        $parkingSpots = ParkingSpot::find()->all();
        //shuffle($parkingSpots);

        foreach ($parkingSpots as $ps) {
            $prije = $this->ansiFormat($ps->sensor, Console::FG_GREEN);
            $ps->sensor = rand(ParkingSpot::STATUS_TAKEN,ParkingSpot::STATUS_FREE);
            $poslije = $this->ansiFormat($ps->sensor, Console::FG_GREEN);
            echo "ParkingSpot $ps->id \t $prije => $poslije \n";
            $ps->save();
        }

    }

    /**
     * This command updates periodic reservations (including the permanent ones) if they're eligible.
     */
    public function actionUpdate()
    {

    }
}
