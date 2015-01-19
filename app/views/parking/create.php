<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Parking */

$this->title = 'Kreiraj parkiralište';
$this->params['breadcrumbs'][] = ['label' => 'Parkings', 'url' => ['admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parking-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
