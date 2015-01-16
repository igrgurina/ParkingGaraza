<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReservationTypeForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservation-form col-md-3">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList([ 'instant' => 'Jednokratna', 'recurring' => 'Ponavljajuća', 'permanent' => 'Trajna', ], ['prompt' => 'Odaberite tip rezervacije']) ?>


    <div class="form-group">
        <?= Html::submitButton('Next', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
