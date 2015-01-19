<?php
use dosamigos\google\maps\LatLng;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
$this->title = 'Parking Zagreb';
/* @var $parkings \yii\db\ActiveQuery */
/* @var $currentLocation LatLng */

// TODO: dodaj cjenik iz dizajna
?>
<div class="site-index">
   <div class="body-content">
       <div class="row">
           <div class="col-xs-12">
               <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
                   <?php if (in_array($type, ['success', 'danger', 'warning', 'info'])): ?>
                       <div class="alert alert-<?= $type ?>">
                           <?= $message ?>
                       </div>
                   <?php endif ?>
               <?php endforeach ?>
           </div>
       </div>
       <div class="row">
           <div class="col-md-4">
               <?= $this->render('_search', [
                   'model' => new \app\models\Location(),
               ]) ?>
           </div>
           <div class="col-md-2 col-md-offset-5">
               <div class="box">
                   <div class="info">
                       <h4 class="text-left" style="padding-left: 7px; margin-bottom: 3px">Cjenik:</h4>
                       <p id="cjenikGL" class="center-block">5 kn/h</p>
                       <ul class="list-group list-group-flush text-center" style="margin-bottom: 0">
                           <li class="list-group-item" style="font-size: 18px"><i class="icon-ok text-danger"></i><strong>Registrirani korisnici:</strong></li>
                           <li class="list-group-item"><i class="icon-ok text-danger"></i>Popust 20%</li>
                           <li class="list-group-item"><i class="icon-ok text-danger"></i>Mogućnost rezervacije</li>
                       </ul>

                       <!--<a href="" class="btn">Cjenik i upute</a>-->
                   </div>
               </div>
           </div>

       </div>
        <div class="row">
            <div class="col-md-12">
                <?= $this->render('_map', [
                    'parkings' => $parkings,
                    'currentLocation' => $currentLocation
                ]) ?>
            </div>
        </div>
    </div>
</div>
