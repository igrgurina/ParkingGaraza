<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Parking */

$this->title = 'Update Parking: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Parkings', 'url' => ['admin']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="parking-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
