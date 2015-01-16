<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Reservation */

$this->title = 'Create Reservation';
$this->params['breadcrumbs'][] = ['label' => 'Reservations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($model->type == \app\models\Reservation::TYPE_INSTANT): ?>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    <?php elseif($model->type == \app\models\Reservation::TYPE_PERIODIC): ?>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    <?php else: ?>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    <?php endif; ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
