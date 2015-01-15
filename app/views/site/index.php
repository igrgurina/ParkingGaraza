<?php
use dosamigos\google\maps\LatLng;
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
/* @var $parkings \yii\db\ActiveQuery */
/* @var $currentLocation LatLng */
?>
<div class="site-index">

    <?= $this->render('_search', [
        'model' => new \app\models\Location(),
    ]) ?>
   <div class="body-content">
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
