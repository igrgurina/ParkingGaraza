<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Reservation;

/* @var $this yii\web\View */
/* @var $model app\models\ReservationTypeForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Odaberi tip';
$this->params['breadcrumbs'][] = ['label' => 'Rezervacije', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h3><?= Html::encode($this->title) ?></h3>
<div class="reservation-form">
<div class="col-md-4">
        <div class="progress">
            <div data-percentage="33%" style="width: 33%;" class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'type')->dropDownList([ Reservation::TYPE_INSTANT => 'Jednokratna', Reservation::TYPE_PERIODIC => 'Ponavljajuća', Reservation::TYPE_PERMANENT => 'Trajna', ], ['prompt' => 'Odaberite tip rezervacije']) ?>


        <div class="form-group">
            <?= Html::submitButton('Dalje', ['class' => 'btn btn-primary pull-right']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
