<?php
use dosamigos\google\maps\LatLng;
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
/* @var $parkings \yii\db\ActiveQuery */
/* @var $currentLocation LatLng */

// TODO: dodaj cjenik iz dizajna
?>
<div class="site-index">

    <?= $this->render('_search', [
        'model' => new \app\models\Location(),
    ]) ?>
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
            <div class="col-md-12">
                <?= $this->render('_map', [
                    'parkings' => $parkings,
                    'currentLocation' => $currentLocation
                ]) ?>
            </div>
        </div>

    </div>
</div>
