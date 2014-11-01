<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ParkingSpot */

$this->title = 'Create Parking Spot';
$this->params['breadcrumbs'][] = ['label' => 'Parking Spots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parking-spot-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
