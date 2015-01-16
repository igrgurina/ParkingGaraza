<?php
namespace app\commands;

use app\models\ParkingSpot;
use app\models\Reservation;
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
        $parkingSpots = ParkingSpot::find()->all();
        //shuffle($parkingSpots);

        foreach ($parkingSpots as $ps) {
            $beforeChange = $this->ansiFormat($ps->sensor, Console::FG_GREEN);
            $ps->sensor = rand(ParkingSpot::STATUS_TAKEN, ParkingSpot::STATUS_FREE);
            $afterChange = $this->ansiFormat($ps->sensor, Console::FG_GREEN);
            echo "ParkingSpot $ps->id \t $beforeChange => $afterChange \n";
            $ps->save();
        }
    }

    /**
     * This command updates periodic reservations (including the permanent ones) if they're eligible.
     */
    public function actionUpdate()
    {
        $reservations = Reservation::find()->active()->refreshable()->all();

        foreach ($reservations as $reservation) {
            if($reservation->isExpiringToday())
            {
                if(is_null($reservation->duration))
                    $reservation->duration = 30;
                // uvećaj početno vrijeme za trajanje rezervacije
                $date = \DateTime::createFromFormat("Y-m-d H:i:s", $reservation->start);
                $reservation->start = $date->add(new \DateInterval('P' . $this->duration . 'D'))->format("Y-m-d H:i:s");

                // ako je ponavljajuća, uvećaj završno vrijeme za trajanje rezervacije
                // ukoliko je trajna, završno vrijeme ostaje null
                if($reservation->type == Reservation::TYPE_PERIODIC)
                {
                    $date = \DateTime::createFromFormat("Y-m-d H:i:s", $reservation->end);
                    $reservation->end = $date->add(new \DateInterval('P' . $this->duration . 'D'))->format("Y-m-d H:i:s");
                }

                if($reservation->isPossible()) {
                    $reservation->save();
                } else {
                    $reservation->deactivate();
                }

                $after = $this->ansiFormat($reservation->type, Console::FG_GREEN);
                echo "reservation $after\n";
            }
        }
    }
}
