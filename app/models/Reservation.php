<?php

namespace app\models;

use Yii, DateTime, DateInterval;
/**
 * This is the model class for table "reservation".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property integer $parking_id
 * @property string $start			// timestamp pocetka prvog termina
 * @property string $end			// timestamp kraja prvog termina
 * @property string $duration		// trajanje rezervacije u danima (=1 za instant rezervacije)
 * @property string $period			// period ponavljanja u danima (null za instant i permanent rezervacije)
 * @property bool $active
 *
 * @property User $user
 * @property Parking $parking
 * 
 */
class Reservation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reservation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'parking_id'], 'required'],
            [['user_id', 'parking_id'], 'integer'],
            [['type'], 'string'],
            [['start', 'end', 'duration', 'period'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'parking_id' => 'Parking ID',
            'start' => 'Start',
            'end' => 'End',
            'duration' => 'Duration',
            'period' => 'Period',
        ];
    }

    public function cancel()
    {
        $this->active = false;
        $this->save(false);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParking()
    {
        return $this->hasOne(Parking::className(), ['id' => 'parking_id']);
    }

    /*
     * Checks whether it's possible to add a reservation
     */

    public function isPossible()
    {
        $start = new DateTime($this->start);		// vrijeme pocetka prvog termina
        $end = new DateTime($this->end);			// vrijeme kraja prvog termina

        if ($this->type == 'instant') {
			
			// u slucaju jednokratne rezervacije, imamo samo jedan termin
			
            $count = $this->activeReservationsAt($start, $end);		// i prebrojimo kolizije u njemu
			
            return (($count >= $this->parking->number_of_parking_spots) ? (false) : (true));

        } elseif ($this->type=='recurring'){
		
			// u slucaju ponavljajuce rezervacije, imamo po jedan termin svaki $period-ti dan, i tako $duration dana
			
            for ($i = 1; $i <= $this->duration; $i += $this->period) {
                
                if ($this->activeReservationsAt($start, $end) >= $this->parking->number_of_parking_spots)
                    return false;
				// pa provjeravamo broj kolizija u svakom od tih termina
				
				$start->add(new DateInterval('P' . $this->period . 'D' ));		// dodaje $period dana
				$end->add(new DateInterval('P' . $this->period . 'D' ));		// dodaje $period dana
				// i na kraju svakog prolaska kroz petlju se pomicemo na sljedeci termin

            }
			// ako prezivi sve iteracije, znaci da nema previse kolizija niti u jednom terminu, i vraca true
            return true;
			
        } elseif ($this->type=='permanent') {
			
			// u slucaju ponavljajuce rezervacije, imamo po jedan termin svaki dan, i tako unedogled
			// Q: koliko unaprijed trebamo provjeravati kolizije, odnosno koliko unaprijed se smije rezervirati?
			// ovdje pretpostavljam 366 dana
			
			for ($i = 1; $i <= 366; $i++) {
				
				// sama petlja je prakticki ista kao i kod ponavljajuce rezervacije
				
				if ($this->activeReservationsAt($start,$end) >= $this->parking->number_of_parking_spots)
					return false;
				
				$start->add(new DateInterval('P1D'));
				$end->add(new DateInterval('P1D'));
			}
			return true;
			
		}
    }

   /*
    * Counts collisions in certain day
    */
    private function activeReservationsAt ($start, $end) {

        $count = 0;		// inicijalizacija brojaca
        foreach($this->parking->reservations as $res) {			// za svaku rezervaciju promatranog parkinga

            if (true /* trebalo bi biti "$res->active", ali nema ga u bazi */) {	// ako nije neaktivna
                
				// $start i $end pripadaju traženom terminu ulazne rezervacije
				// $cmpstart i $cmpend pripadaju terminu rezervacije u ovoj iteraciji petlje (u daljnjim komentarima cmprezervacija)
					// za kojeg gledamo je li u koliziji sa ulaznim terminom
				$cmpstart = new DateTime($res->start);
                $cmpend = new DateTime($res->end);

                if ($res->type == 'instant') {
					
					// ukoliko je cmprezervacija jednokratna, ima samo jedan termin (za koji provjeravamo kolizije)
					
					if (($cmpend > $start) && ($cmpstart < $end))
						$count++;
					
				} elseif ($res->type == 'recurring') {
					
					// ukoliko je cmprezervacija ponavljajuca, ima cijeli set termina (svaki $period-ti dan, i tako $duration dana)
					// i za svaki od tih termina gledamo radi li koliziju sa ulaznim terminom
					
					for ($i = 1; $i <= $res->duration; $i += $res->period) {
						
						if (($cmpend > $start) && ($cmpstart < $end)) {
							$count++;
							break;
							// ukoliko nađemo da radi koliziju s ulaznim terminom, 
							// ne trebamo traziti dalje, vec idemo na sljedecu cmprezervaiciju
						}
						$cmpstart->add(new DateInterval('P' . $res->period . 'D' ));	// dodaje $period dana
						$cmpend->add(new DateInterval('P' . $res->period . 'D' ));		// dodaje $period dana
					}
					
				} elseif ($res->type == 'permanent') {
					
					// ukoliko je cmprezervacija trajna, situacija je slicna kao kod ponavljajuce
					
					$temp = $start;
					$temp->add(new DateInterval('P' . $this->duration . 'D' );
					// zapravo, treba mi while($cmpstart <= $start+$duration), ali ne nalazim prikladnu DateTime funkciju za takvo sto
					
					while ($cmpstart <= $temp) {
						
						if (($cmpend > $start) && ($cmpstart < $end)) {
							$count++;
							break;
						}
						$cmpstart->add(new DateInterval('P' . $res->period . 'D' ));	// dodaje $period dana
						$cmpend->add(new DateInterval('P' . $res->period . 'D' ));		// dodaje $period dana
					}
				}
            }
        }
        return $count;
    }
}