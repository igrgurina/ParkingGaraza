<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Reservation */

$this->title = 'Odaberi termin';
$this->params['breadcrumbs'][] = ['label' => 'Rezervacije', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservation-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
